<?php
namespace App\Controller\Admin;

use App\Controller\AppController;
use Cake\Core\Configure;

/**
 * Pages Controller
 *
 * @property \App\Model\Table\PagesTable $Pages
 */
class BacklogsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $conditions = [];
        if(isset($this->request->query['title']) && $this->request->query['title'] !=''){
              $conditions['Backlogs.title LIKE'] = '%'.$this->request->query['title'].'%';
        }
        if(isset($this->request->query['backlog']) && $this->request->query['backlog'] =='my'){
              $conditions['Backlogs.created_by_id'] = $this->Auth->user('id');
        }
        //Filter for type doing/done/close
        if(isset($this->request->query['type']) && $this->request->query['type'] !=''){
            $today = date('Y-m-d');
            if($this->request->query['type'] == 'doing'){
                $conditions['Backlogs.start_date <='] = $today;
                $conditions['Backlogs.end_date >='] = $today;
            }if($this->request->query['type'] == 'done'){
                $conditions['Backlogs.vote_start_date <='] = $today;
                $conditions['Backlogs.vote_end_date >='] = $today;
            }if($this->request->query['type'] == 'close'){
                $conditions['Backlogs.vote_end_date <'] = $today;
            }
        }

        //Filter for status
        if(isset($this->request->query['status']) && $this->request->query['status'] !=''){
            $status = $this->request->query['status'];
            //No Submission
            if($status == 'NS'){
                $this->loadModel('Projects');
                $projects = $this->Projects->find('list', [
                    'keyField' => 'id',
                    'valueField' => 'backlog_id'
                ])
                    ->distinct('backlog_id')
                    ->toArray();
                if(count($projects)){
                    $conditions['Backlogs.id NOT IN'] = $projects;
                    $conditions['Backlogs.status'] = 'A';
                }
            }elseif($status == 'NV'){ //No Votes
                $this->loadModel('ProjectVotes');
                $votes = $this->ProjectVotes->find('list', [
                    'keyField' => 'id',
                    'valueField' => 'project_id'
                ])
                    ->distinct('project_id')
                    ->toArray();
                if(count($votes)){
                    $this->loadModel('Projects');
                    $projects = $this->Projects->find('list', [
                        'keyField' => 'id',
                        'valueField' => 'backlog_id'
                    ])
                        ->where(['id IN'=>$votes, 'up_vote/(up_vote+down_vote) >= '=>2/3])
                        ->distinct('backlog_id')
                        ->toArray();
                    if(count($projects)){
                        $conditions['Backlogs.id NOT IN'] = $projects;
                    }
                }
            }else{
                $conditions['Backlogs.status'] = $status;
            }
        }

        $query = $this->Backlogs->find('all', ['contain' => ['Projects', 'Users']])->where($conditions);
        $this->setDefaultOrdering($query, $this->Backlogs->alias());
        $backlogs = $this->paginate($query);
//        prd($backlogs);
        $this->set(compact('backlogs'));
        $this->set('_serialize', ['backlogs']);
    }

    /**
     * View method
     *
     * @param string|null $id Backlog id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $backlog = $this->Backlogs->get($id, [
            'contain' => []
        ]);

        $this->set('backlog', $backlog);
        $this->set('_serialize', ['backlog']);
    }



    /**
     * AddEdit method
     *
     * @param string|null $id Backlog id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function addEdit($id = null)
    {
		//print_r($_GET);
		//exit();
       $this->loadComponent('Common');
       $userId = $this->Auth->user('id');
       if($id == null) 
       {
            $backlog = $this->Backlogs->newEntity();
            $action = 'Add';
            $this->request->data['created_by_id'] = $userId;
            $this->request->data['status'] = 'A';
        } else {

            $backlog = $this->Backlogs->get($id, [
                'contain' => []
            ]);
			
            $action = 'Edit';
            $this->request->data['updated'] = time();
            $this->request->data['updated_by_id'] = $userId;
            if(isset($this->request->query['status']) && $this->request->query['status'] == 'A')
            {
                $this->request->data['status'] = 'A';
            }
            $oldAmount = $backlog->amount;
            $oldStatus = $backlog->status;		

        }
        if ($this->request->is(['patch', 'post', 'put'])) 
        {			
        	 $token = $this->Common->formatTokenSend($this->request->data['amount'], false);
			// prd($this->request->data['amount']);
			//pr((double)$this->request->data['amount']);
            $backlog = $this->Backlogs->patchEntity($backlog, $this->request->data);
            //$jwtToken = $this->Common->getToken();
            $token = $this->Common->formatTokenSend($this->request->data['amount']);    //18 decimal places
            //prd($token);

            if($id != null && $oldStatus == 'A' && $this->request->data['amount'] != $oldAmount)
            {
              //$url = Configure::read('ApiUrlDevAcc')."updateBacklogAmount/$id/$token/$jwtToken";
               // $result = json_decode($this->Common->curlPost($url));

               // if(isset($result->error->status) && $result->error->status == 0) 
                //{
                  //  $this->Flash->error(__('The backlog can not be updated, due to low balance.'));
                   // return $this->redirect(['action' => 'index']);
                //}
            }           

            if ($this->Backlogs->save($backlog)) 
            {
				
            	$this->Flash->success(__('The backlog is ' .$action .'ed.'));
                    return $this->redirect(['action' => 'index']);
            } else {
				$this->Flash->error(__('The backlog can not be' . $action . 'ed'));
                    return $this->redirect(['action' => 'index']);
            }       
       }
	   
	   $this->set(compact('backlog','action'));
    }

    /**
     * Set the Backlog Status
     */
    public function setBacklogStatus()
    {
        if ($this->request->is(array('ajax'))) {
            $response['success'] = 1;

            $this->loadModel('Backlogs');
            $this->loadModel('Users');
            $backlog = $this->Backlogs->get($this->request->data['id']);
            $user = $this->Users->get($backlog->created_by_id);
            if($backlog->amount > 0 && $this->request->data['status'] == 'A') {
                if(date('Y-m-d') == date('Y-m-d', strtotime($backlog->start_date))) {
                    $this->request->data['bc_status'] = 1;
                }else{
                    $this->request->data['bc_status'] = 0;
                }
            }
            $backlog = $this->Backlogs->patchEntity($backlog, $this->request->data);
            $this->Backlogs->save($backlog);

            //prd($backlog->start_date);

            if($backlog->amount > 0 && $this->request->data['status'] == 'A'){
                $this->loadComponent('Common');
             //   $jwtToken = $this->Common->getToken();
             //   $token = $this->Common->formatTokenSend($backlog->amount);
                $id = $this->request->data['id'];
               // $url = Configure::read('ApiUrlDevAcc')."addBacklog/$id/$token/$jwtToken";
                $result = json_decode($this->Common->curlPost($url));

                if(isset($result->error->status) && $result->error->status == 0) {
                    $backlog = $this->Backlogs->patchEntity($backlog, ['status'=>'P', 'bc_status'=>'']);
                    $result = $this->Backlogs->save($backlog);
                    $response['success'] = 0;
                    $response['message'] = 'The backlog can not be approved, due to low balance.';
                    print json_encode($response);
                    die;
                }

                //Update status
                if(date('Y-m-d') == date('Y-m-d', strtotime($backlog->start_date))) {
                 //   $url = Configure::read('ApiUrlDevAcc') . "updateBacklogStatus/$id/$jwtToken";
                  //  $result = $this->Common->curlPost($url);
                }
            }
            //Send email to user
            $status = Configure::read('BacklogStatus');
            $subject = "Your backlog status has been updated";
            $this->sendEmail($user->email, $subject, 'backlog_status_change', 'html', ['backlog' => $backlog, 'status' => $status]);

            print json_encode($response);
            die;
        }
        die;
    }

    /**
     * Delete method
     *
     * @param string|null $id Backlog id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $backlog = $this->Backlogs->get($id);

        //Delete the repo from the Github
        if($backlog->github_repo != ''){
            $repo = json_decode($backlog->github_repo);
            $this->loadComponent('Git');
            $this->Git->deleteRepo($repo->name);
        }

        //Delete the repo from the Github
        if($backlog->status == 'A'){
            $this->loadComponent('Common');
            $jwtToken = $this->Common->getToken();
            $url = Configure::read('ApiUrlDevAcc')."deleteBacklog/$id/$jwtToken";
            $result = $this->Common->curlPost($url);
        }

        if ($this->Backlogs->delete($backlog)) {
            $this->Flash->success(__('The backlog has been deleted.'));
        } else {
            $this->Flash->error(__('The backlog could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }

    /**
     * Projects method
     *
     * @return \Cake\Network\Response|null
     */
    public function projects($backlogId=0)
    {
        $this->loadModel('Projects');
        $conditions = [];
        if($backlogId){
            $backlog = $this->Backlogs->get($backlogId);
            $conditions['Projects.backlog_id'] = $backlogId;
        }else{
            $backlog = null;
        }

        if(isset($this->request->query['title']) && $this->request->query['title'] !=''){
            $conditions['Projects.name LIKE'] = '%'.$this->request->query['title'].'%';
        }
        $query = $this->Projects->find('all', ['contain'=>['Users', 'Backlogs']/*, 'order'=>['Projects.status', 'Projects.created'=>'desc']*/])->where($conditions);
        $this->setDefaultOrdering($query, $this->Projects->alias());
        $data = $this->paginate($query);
//        prd($data);
        $this->set(compact('data', 'backlogId', 'backlog'));
        $this->set('_serialize', ['data']);
    }


    /**
     * AddEdit method
     *
     * @param string|null $id Backlog id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function addEditProject($backlogId = null, $id = null)
    {
        if($backlogId){
            $backlog = $this->Backlogs->get($backlogId);
        }else{
            $backlog = [];
        }

        $this->loadModel('Projects');
        if($id == null){
            $project = $this->Projects->newEntity();
            $action = 'Add';
            $this->request->data['created_by_id'] = $this->Auth->user('id');
        }else{
            $project = $this->Projects->get($id, [
                'contain' => []
            ]);
            $action = 'Edit';
            $this->request->data['updated'] = time();
            $this->request->data['updated_by_id'] = $this->Auth->user('id');
        }

        if ($this->request->is(['patch', 'post', 'put'])) {
            $this->request->data['name'] = trim($this->request->data['name']);
            if($id == null){
                $this->loadComponent('Git');
//                $repoName = str_replace(' ', '-', $this->request->data['name']);
                $repoName = uniqid();
                $repoDesc = $this->request->data['description'];
                $repo = $this->Git->createRepo($repoName, $repoDesc);
                $this->request->data['github_repo'] = json_encode($repo);
                $this->request->data['backlog_id'] = $backlogId;
            }
            $project = $this->Projects->patchEntity($project, $this->request->data);
            if ($this->Projects->save($project)) {
                $this->Flash->success(__('The record has been saved.'));
                return $this->redirect(['action' => 'projects', $backlogId]);
            } else {
                $this->Flash->error(__('The record could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('project','action', 'backlogId', 'backlog'));
        $this->set('_serialize', ['project']);
    }



    /**
     * Delete Project method
     *
     * @param string|null $id Backlog id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function deleteProject($backlogId = null, $id = null)
    {
        $this->loadModel('Projects');
        $this->request->allowMethod(['post', 'delete']);
        $object = $this->Projects->get($id);

        //Delete the repo from the Github
        if($object->github_repo != ''){
            $repo = json_decode($object->github_repo);
            $this->loadComponent('Git');
            $this->Git->deleteRepo($repo->name);
        }

        if ($this->Projects->delete($object)) {
            $this->Flash->success(__('The record has been deleted.'));
        } else {
            $this->Flash->error(__('The record could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'projects', $backlogId]);
    }

    /**
     * View Project method
     *
     * @param string|null $id Backlog id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function viewProject($backlogId = null, $id = null)
    {
        $this->loadModel('Projects');
        $this->loadModel('ProjectComments');
        if($backlogId){
            $backlog = $this->Backlogs->get($backlogId);
        }else{
            $backlog = [];
        }
        $project = $this->Projects->get($id);

        $query = $this->ProjectComments->find('all', ['contain' => ['Users']])->where(['ProjectComments.project_id'=>$id]);
        $this->setDefaultOrdering($query, $this->ProjectComments->alias());
        //$this->paginate = ['limit' => 2];
        $projectComments = $this->paginate($query);
		//prd(json_decode($project->github_repo)->downloads_url);
        $this->set(compact('project', 'backlogId', 'backlog', 'projectComments'));
        $this->set('_serialize', ['backlog']);
    }
}
