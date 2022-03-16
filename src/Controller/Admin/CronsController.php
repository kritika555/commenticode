<?php
namespace App\Controller\Admin;

use App\Controller\AppController;
use Cake\Core\Configure;

/**
 * Pages Controller
 *
 * @property \App\Model\Table\PagesTable $Pages
 */
class CronsController extends AppController
{
    /**
     * mintNewTokens
     */
    public function mintNewTokens()
    {
        $this->loadComponent('Common');
        $jwtToken = $this->Common->getToken();
        $url = Configure::read('ApiUrl') . "mintTokens/$jwtToken";
        $this->Common->curlPost($url);
        $this->saveLog(__FUNCTION__);
        die;
    }

    /**
     * Release Tokens For Winners And Set Total Voters
     */
    public function releaseTokensWinners()
    {
        if(!$this->__isReleaseScheduledToday()){
            die('Today is not the release date.');
        }
        $this->loadModel('Backlogs');
        $this->loadModel('Projects');
        $this->loadModel('Users');

        $backlogs = $this->Backlogs->find('list', [
            'keyField' => 'id',
            'valueField' => 'id'
        ])
            ->where([
                'Backlogs.tokens_released_winners' => 0,
                //'Backlogs.closed' => 0,
                'Backlogs.status' => 'A',
                'Backlogs.project_added' => 1,
                'Backlogs.vote_added' => 1,
                'Backlogs.bc_status' => 4,
                'Backlogs.vote_end_date IS NOT' => null,
                'Backlogs.vote_end_date <=' => date('Y-m-d')
            ]);

        foreach ($backlogs->toArray() as $backlogId) {
            $projects = $this->Projects->find('all')
                ->where([
                    'Projects.backlog_id' => $backlogId,
                ]);

            $winners = $winnerProjects = $projectVotes = [];
            $grandTotalVotes = 0;
            foreach ($projects->toArray() as $project) {
                $totalVotes = $project->up_vote + $project->down_vote;
//                $grandTotalVotes += $totalVotes;
                $percentage = $project->up_vote / $totalVotes * 100;
                if ($percentage >= (200 / 3)) {
                    $winners[$project->created_by_id] = $percentage;
                    $projectVotes[$project->created_by_id] = $totalVotes;
                    $winnerProjects[$project->created_by_id] = $project;
                }

            }
            if (count($winners) > 0) {
                arsort($winners);
                $users = $this->Users->find('list', [
                    'keyField' => 'id',
                    'valueField' => 'ethereum_public_address'
                ])
                    ->where([
                        'Users.id IN' => array_keys($winners),
                    ]);
                $userAddress = $users->toArray();

                $winnerAddress = $winnerIds = [];
                foreach ($winners as $winnerId => $row) {
                    $winnerAddress[] = $userAddress[$winnerId];
                    $winnerIds[] = $winnerId;
                    $grandTotalVotes += $projectVotes[$winnerId];
                }

                //prd($winnerAddress);
                $winner1 = $winnerAddress[0];
                $winner2 = isset($winnerAddress[1]) ? $winnerAddress[1] : '0x0000000000000000000000000000000000000000';
                $winner3 = isset($winnerAddress[2]) ? $winnerAddress[2] : '0x0000000000000000000000000000000000000000';

                $this->loadComponent('Common');
                $jwtToken = $this->Common->getToken();
                $url = Configure::read('ApiUrlDevAcc') . "releaseTokensToWinnersForCompleteBacklog/$backlogId/$winner1/$winner2/$winner3/$grandTotalVotes/$jwtToken";
                $result = json_decode($this->Common->curlPost($url));

                if(isset($result->status) && $result->status == 1) {
                    $data = [];
                    $data['backlog_id'] = $backlogId;
                    $data['status'] = 1;
                    $data['type'] = 'W';
                    if (isset($result->eventResult->returnValues->_firstWinnerTokens) && $result->eventResult->returnValues->_firstWinnerTokens > 0) {
                        $data['project_id'] = $winnerProjects[$winnerIds[0]]->id;
                        $data['user_id'] = $winnerIds[0];
                        $data['address'] = $winner1;
                        $data['amount'] = $result->eventResult->returnValues->_firstWinnerTokens;
                        $data['winner'] = 1;
                        $this->saveTransaction($data);
                    }
                    if (isset($result->eventResult->returnValues->_secondWinnerTokens) && $result->eventResult->returnValues->_secondWinnerTokens > 0) {
                        $data['project_id'] = $winnerProjects[$winnerIds[1]]->id;
                        $data['user_id'] = $winnerIds[1];
                        $data['address'] = $winner2;
                        $data['amount'] = $result->eventResult->returnValues->_secondWinnerTokens;
                        $data['winner'] = 2;
                        $this->saveTransaction($data);
                    }
                    if (isset($result->eventResult->returnValues->_thirdWinnerTokens) && $result->eventResult->returnValues->_thirdWinnerTokens > 0) {
                        $data['project_id'] = $winnerProjects[$winnerIds[2]]->id;
                        $data['user_id'] = $winnerIds[2];
                        $data['address'] = $winner3;
                        $data['amount'] = $result->eventResult->returnValues->_thirdWinnerTokens;
                        $data['winner'] = 3;
                        $this->saveTransaction($data);
                    }
                }else{
                    $i = 0;
                    foreach ($winners as $winnerId => $row) {
                        $data = [];
                        $data['backlog_id'] = $backlogId;
                        $data['project_id'] = $winnerProjects[$winnerId]->id;
                        $data['user_id'] = $winnerId;
                        $data['address'] = $winnerAddress[$i];
                        $i++;
                        $data['winner'] = $i;
                        $data['type'] = 'W';
                        $this->saveTransaction($data);
                    }

                    $this->loadComponent('Common');
                    $adminEmail = $this->Common->getAdminEmails();
                    $this->sendEmail($adminEmail, "Release token failed", 'release_token_fail', 'html');
                }

                $backlog = $this->Backlogs->get($backlogId);
                $update['tokens_released_winners'] = 1;
                $backlog = $this->Backlogs->patchEntity($backlog, $update);
                $this->Backlogs->save($backlog);
            }
        }
        $this->saveLog(__FUNCTION__);
        die;
    }

    /**
     * Release Tokens For Voters
     */
    public function releaseTokensVoters()
    {
        if(!$this->__isReleaseScheduledToday()){
            die('Today is not the release date.');
        }
        $this->loadModel('Backlogs');
        $this->loadModel('Projects');
        $this->loadModel('Users');

        $this->Projects->recursive = 2;
        $projects = $this->Projects->find('all', ['contain' => ['ProjectVotes'=>['Users']]])
            ->where([
                'Projects.tokens_released_voters' => 0,
                'Projects.winner >' => 0,
            ]);


        $votersAddress = [];
        foreach ($projects->toArray() as $project) {
//            prd($project);
            if(is_array($project->project_votes) && count($project->project_votes)){
                foreach($project->project_votes as $votes){
                    $votersAddress[$project->backlog_id][] = [
                        'project_id' => $votes->project_id,
                        'user_id' => $votes->user_id,
                        'address' => $votes->user['ethereum_public_address']
                    ];
                }
            }

            $project = $this->Projects->get($project->id);
            $update = [];
            $update['tokens_released_voters'] = 1;
            $project = $this->Projects->patchEntity($project, $update);
            $this->Projects->save($project);
        }
//        pr($votersAddress);
//        die;
        $limit = 20;

        foreach($votersAddress as $backlogId=>$addresses) {
            $i = 0;
            $a = $u = [];
            foreach ($addresses as $address) {
                $i++;
                $a[] = $address['address'];
                $u[] = $address;
                if ($i == $limit) {
//                    pr($a);
                    $this->__releaseTokensVoters($backlogId, $a, $u);
                    $i = 0;
                    $a = $u = [];
                }
            }
            //For leftover addresses
            if(count($a) > 0){
                $this->__releaseTokensVoters($backlogId, $a, $u);
            }
        }
        $this->saveLog(__FUNCTION__);
        die;
    }

    /**
     * @param $backlogId
     * @param $a - Addresses
     * @param $u - Users address (in case of update=false) / transaction id (in case of update=true)
     * @param bool $update
     * @return bool
     */
    function __releaseTokensVoters($backlogId, $a, $u, $update=false){
        $this->loadComponent('Common');
        $jwtToken = $this->Common->getToken();

        $votersArray = implode(',', $a);

        //Update status
        $url = Configure::read('ApiUrlDevAcc')."releaseTokensForVoters/$backlogId/$votersArray/$jwtToken";
        $result = json_decode($this->Common->curlPost($url));
        //pr($result);
        if (isset($result->status) && $result->status == 1) {
            $data['status'] = 1;
            $data['amount'] = $result->eventResult->returnValues->_tokensPerVoter;
            if($update){
                $this->Transactions->updateAll(
                    [  // fields
                        'amount' => $data['amount'],
                        'status' => 1,
                        'updated' => date('Y-m-d H:i:s'),
                    ],
                    [  // conditions
                        'id IN' => $u,
                    ]
                );
            }
        }else{
            $this->loadComponent('Common');
            $adminEmail = $this->Common->getAdminEmails();
            $this->sendEmail($adminEmail, "Release token failed", 'release_token_fail', 'html');
        }

        if(!$update){
            foreach($u as $trans){
                $data['backlog_id'] = $backlogId;
                $data['project_id'] = $trans['project_id'];
                $data['user_id'] = $trans['user_id'];
                $data['address'] = $trans['address'];
                $this->saveTransaction($data);
            }
        }

        if (isset($result->status) && $result->status == 1) {
            return true;
        }else{
            return false;
        }
    }

    /**
     * Release Tokens For Voters
     */
    public function processFailedTransactions($redirect=false)
    {
        if(!$redirect && !$this->__isReleaseScheduledToday()){
            die('Today is not the release date.');
        }
        $failedW = $passedW = false;
        $failedV = $passedV = false;
        $this->loadModel('Transactions');
        $this->loadModel('Backlogs');
        $this->loadModel('Projects');
        $this->loadModel('Users');

        $transactions = $this->Transactions->find('all', ['contain'=>['Projects']])
            ->where([
                'Transactions.status' => 0,
                'Transactions.user_id >' => 0,
                'Transactions.project_id >' => 0,
                'Transactions.type IN' => ['W', 'V']
            ]);


        $votersAddress = $winners = [];
        foreach ($transactions->toArray() as $row) {
//            pr($row);
            if($row->address != ''){
                if($row->type == 'W'){
                    $winners[$row->backlog_id][$row->winner] = $row->address;
                    if(!isset($row[$row->backlog_id]['total_votes'])){
                        $winners[$row->backlog_id]['total_votes'] = $row->project->up_vote + $row->project->down_vote;
                    }else{
                        $winners[$row->backlog_id]['total_votes'] += $row->project->up_vote + $row->project->down_vote;
                    }

                }elseif($row->type == 'V'){
                    $votersAddress[$row->backlog_id][] = [
                        'id' => $row->id,
                        'address' => $row->address
                    ];
                }
            }
        }
//prd($winners);
        //Release token for failed transaction of the winners
        if(count($winners) > 0) {
            foreach ($winners as $backlogId => $address) {
                $winner1 = $address[1];
                $winner2 = isset($address[2]) ? $address[2] : '0x0000000000000000000000000000000000000000';
                $winner3 = isset($address[3]) ? $address[3] : '0x0000000000000000000000000000000000000000';
                $grandTotalVotes = $address['total_votes'];

                $this->loadComponent('Common');
                $jwtToken = $this->Common->getToken();
                $url = Configure::read('ApiUrlDevAcc') . "releaseTokensToWinnersForCompleteBacklog/$backlogId/$winner1/$winner2/$winner3/$grandTotalVotes/$jwtToken";
                $result = json_decode($this->Common->curlPost($url));
//                prd($result);

                if (isset($result->status) && $result->status == 1) {
                    if (isset($result->eventResult->returnValues->_firstWinnerTokens) && $result->eventResult->returnValues->_firstWinnerTokens > 0) {
                        $this->Transactions->updateAll(
                            [  // fields
                                'amount' => $result->eventResult->returnValues->_firstWinnerTokens,
                                'status' => 1,
                                'updated' => date('Y-m-d H:i:s'),
                            ],
                            [  // conditions
                                'status' => 0,
                                'type' => 'W',
                                'winner' => 1,
                                'backlog_id' => $backlogId,
                            ]
                        );
                    }
                    if (isset($result->eventResult->returnValues->_secondWinnerTokens) && $result->eventResult->returnValues->_secondWinnerTokens > 0) {
                        $this->Transactions->updateAll(
                            [  // fields
                                'amount' => $result->eventResult->returnValues->_secondWinnerTokens,
                                'status' => 1,
                                'updated' => date('Y-m-d H:i:s'),
                            ],
                            [  // conditions
                                'status' => 0,
                                'type' => 'W',
                                'winner' => 2,
                                'backlog_id' => $backlogId,
                            ]
                        );
                    }
                    if (isset($result->eventResult->returnValues->_thirdWinnerTokens) && $result->eventResult->returnValues->_thirdWinnerTokens > 0) {
                        $this->Transactions->updateAll(
                            [  // fields
                                'amount' => $result->eventResult->returnValues->_thirdWinnerTokens,
                                'status' => 1,
                                'updated' => date('Y-m-d H:i:s'),
                            ],
                            [  // conditions
                                'status' => 0,
                                'type' => 'W',
                                'winner' => 3,
                                'backlog_id' => $backlogId,
                            ]
                        );
                    }
                    $passedW = true;
                }else{
                    $failedW = true;
                }
            }
        }

        if(count($votersAddress) > 0) {
            $limit = 20;
            $update = true;
            //Release token for failed voter
            foreach ($votersAddress as $backlogId => $addresses) {
                $i = 0;
                $a = $id = [];
                foreach ($addresses as $address) {
                    $i++;
                    $a[] = $address['address'];
                    $id[] = $address['id'];
                    if ($i == $limit) {
                        //                    pr($a);
                        if($this->__releaseTokensVoters($backlogId, $a, $id, $update)){
                            $passedV = true;
                        }else{
                            $failedV = true;
                        }
                        $i = 0;
                        $a = $id = [];
                    }
                }
                //For leftover addresses
                if (count($a) > 0) {
                    if($this->__releaseTokensVoters($backlogId, $a, $id, $update)){
                        $passedV = true;
                    }else{
                        $failedV = true;
                    }
                }
            }
        }
        if($redirect){
            if($passedV && $passedW && !$failedV && !$failedW){
                $this->Flash->success(__('Transactions have been processed successfully.'));
            }elseif(!$passedV && !$passedW && $failedV && $failedW){
                $this->Flash->error(__('Transactions have not been processed, please try again.'));
            }else/*if(!$passedV && !$passedW && $failedV && $failedW)*/{
                $this->Flash->error(__('Transactions have been processed partially, please try again.'));
            }

            $this->redirect(['controller' => 'Users', 'action' => 'transactions', '?' => ['status' => 0]]);
        }else{
            $this->saveLog(__FUNCTION__);
            die;
        }
    }

    function __isReleaseScheduledToday(){
        return true; //TODO: Need to remove this line when go to production.

        $this->loadModel('Configurations');
        $query = $this->Configurations->find('all')
            ->where(['Configurations.conf_key' => 'token_release_date']);
        $date = $query->first();

        $query = $this->Configurations->find('all')
            ->where(['Configurations.conf_key' => 'token_release_interval']);
        $interval = $query->first();
        //pr($date->conf_value);
        //pr($interval->conf_value);
        if($interval->conf_value > 0 && (bool)strtotime($date->conf_value)){
            $today = strtotime(date('Y-m-d')); // or your date as well
            $releaseDate = strtotime($date->conf_value);
            $dateDiff = $today - $releaseDate;
            $dateDiff = round($dateDiff / (60 * 60 * 24));
            if($dateDiff % $interval->conf_value == 0){
                return true;
            }else{
                return false;
            }
        }else{
            return false;
        }
    }

    function saveTransaction($data)
    {
        $this->loadModel('Projects');
        $this->loadModel('Transactions');
        $transactions = $this->Transactions->newEntity();
        $transactions = $this->Transactions->patchEntity($transactions, $data);
        $this->Transactions->save($transactions);

        if(isset($data['winner']) && $data['winner'] > 0){
            $project = $this->Projects->get($data['project_id']);
            $update = [];
            $update['winner'] = $data['winner'];
            $project = $this->Projects->patchEntity($project, $update);
            $this->Projects->save($project);
        }
    }

    //Update Status For Existing Backlog
    function updateBacklogStatus(){
        $this->__updateStatus(0, 1, 'start_date');
        $this->__updateStatus(1, 2, 'end_date');
        $this->__updateStatus(2, 3, 'vote_start_date');
        $this->__updateStatus(3, 4, 'vote_end_date');
        $this->saveLog(__FUNCTION__);
        die;
    }

    function updateBacklogStartStatus(){
        $this->__updateStatus(0, 1, 'start_date');
        $this->saveLog(__FUNCTION__);
        die;
    }

    function updateBacklogEndStatus(){
        $this->__updateStatus(1, 2, 'end_date');
        $this->saveLog(__FUNCTION__);
        die;
    }

    function updateBacklogVoteStartStatus(){
        $this->__updateStatus(2, 3, 'vote_start_date');
        $this->saveLog(__FUNCTION__);
        die;
    }

    function updateBacklogVoteEndStatus(){
        $this->__updateStatus(3, 4, 'vote_end_date');
        $this->saveLog(__FUNCTION__);
        die;
    }

    function __updateStatus($fromStatus, $toStatus, $compareField){
        $this->loadModel('Backlogs');
        $today = date('Y-m-d');

        $conditions = [];
        $conditions['Backlogs.'.$compareField] = $today;
        $conditions['Backlogs.status'] = 'A';
        $conditions['Backlogs.bc_status'] = $fromStatus;
        if($fromStatus == 1){
            $conditions['Backlogs.project_added'] = 1;
        }

        $data = $this->Backlogs->find('all')->where($conditions);

        $this->loadComponent('Common');
        $jwtToken = $this->Common->getToken();

        foreach($data as $row){
            $id = $row->id;

            $updateStatus = false;
            //Change the status from 3 to 4 only if the one of the project in the backlog as 2/3 votes.
            if($fromStatus == 3){
                $this->loadModel('Projects');
                $projects = $this->Projects->find('all')
                    ->where([
                        'Projects.backlog_id' => $id,
                    ]);

                foreach ($projects->toArray() as $project) {
                    $totalVotes = $project->up_vote + $project->down_vote;
                    if($totalVotes == 0){
                        $percentage = 0;
                    }else{
                        $percentage = $project->up_vote / $totalVotes * 100;
                    }

                    if ($percentage >= (200 / 3)) {
                        $updateStatus = true;
                        break;
                    }
                }
            }else{
                $updateStatus = true;
            }

            if($updateStatus){
                //Update status
                $url = Configure::read('ApiUrlDevAcc')."updateBacklogStatus/$id/$jwtToken";
                $this->Common->curlPost($url);

                $backlog = $this->Backlogs->get($id);
                $update['bc_status'] = $toStatus;
                $backlog = $this->Backlogs->patchEntity($backlog, $update);
                $this->Backlogs->save($backlog);
            }
        }
    }

    private function saveLog($function){
        $this->loadModel('CronLogs');
        $cronLog = $this->CronLogs->newEntity();
        $logData['name'] = $function;
        $cronLog = $this->CronLogs->patchEntity($cronLog, $logData);
        $this->CronLogs->save($cronLog);
    }
}
