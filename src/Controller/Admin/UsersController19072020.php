<?php
namespace App\Controller\Admin;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Core\Configure;
use Cake\Utility\Security;


/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 */
class UsersController extends AppController
{
    public function beforeFilter($event)
    {
        parent::beforeFilter($event);
        // Allow users to register and logout.
        // You should not add the "login" action to allow list. Doing so would
        // cause problems with normal functioning of AuthComponent.
        $this->Auth->allow(['add','add-edit','logout']);
    } 

    public function login()
    {
        $this->viewBuilder()->layout('admin_login');
        $this->loadModel('Users');
        $this->loadComponent('Common');

        //If user is already logged in
        if ($this->Auth->user('id') > 0) {
            return $this->redirect(['controller' => 'Users', 'action' => 'dashboard']);
        } elseif ($this->Cookie->read('remember_token') != '') { //if remenber me cookie is set

            $query = $this->Users->find('all', [
                'conditions' => [
                    'Users.remember_token' => $this->Cookie->read('remember_token'),
                ]
            ]);

            if ($query->count()) {
                $user = $query->first();
                $this->Auth->setUser($user->toArray());
                $this->__addUserLog();
                return $this->redirect(['controller' => 'Backlogs', 'action' => 'index', 'prefix' => 'admin']);
            }
        }

        if ($this->request->is('post')) {
            $query = $this->Users->find('all', [
                'conditions' => [
                    'Users.username' => $this->request['data']['username'],
                    'Users.password' => md5($this->request['data']['password']),
                    'Users.role' => 'A',
                ]
            ]);
            if ($query->count()) {
                $user = $query->first();
                $this->Auth->setUser($user->toArray());
                if ($this->request['data']['remember'] == 1) {
                    $token = md5($user['id'] . time());
                    $user->remember_token = $token;
                    $this->Users->save($user);
                    $this->Cookie->write('remember_token', $token);
                } else {
                    $user->remember_token = '';
                    $this->Users->save($user);
                    $this->Cookie->delete('remember_token');
                }
                $this->__addUserLog();
                return $this->redirect($this->Auth->redirectUrl());
            }
            $this->Flash->error(__('Invalid username or password, try again'));
        }
    }

    public function logout()
    {
        $this->loadComponent('Common');
        $this->Cookie->delete('remember_token');
        $this->__addUserLog('logout');
        return $this->redirect($this->Auth->logout());
    }

    /*
     * Change password
     */
    public function changePassword()
    {
        $this->loadModel('Users');
        $admin = $this->Users->newEntity();
        if ($this->request->is('post')) {
            $admin = $this->Users->get($this->Auth->user('id'));
            $admin = $this->Users->patchEntity($admin, $this->request->data, [
                'validate' => 'ChangePass'
            ]);

            if (!$admin->errors()) {
                $admin->password = md5($this->request['data']['password']);
                $this->Users->save($admin);

                $this->Flash->success(__('Password changed successfully.'));
                $this->redirect(['controller' => 'Users', 'action' => 'change-password']);

            } else {
                $this->Flash->error(__('There are some validation issues. Please try again'));
            }
        } else { //to empty the default form
            $admin = $this->Users->newEntity();
        }
        $this->set(compact('admin'));
    }

    /*
     * Edit profile
     */
    public function editProfile()
    {

        $this->loadModel('Users');
        $admin = $this->Users->get($this->Auth->user('id'), [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            //$privateAddress = Security::encrypt($this->request->data['ethereum_private_address'], Configure::read('EncryptionKey'));

            //$this->request->data['ethereum_private_address'] = $privateAddress;
            $admin = $this->Users->patchEntity($admin, $this->request->data, [
                'validate' => 'EditProfile'
            ]);
            if ($this->Users->save($admin)) {
                $this->Flash->success(__('Profile has been saved.'));
                return $this->redirect(['action' => 'edit-profile']);
            } else {
                $this->Flash->error(__('Profile could not be saved. Please, try again.'));
            }

        }/*else{
            $privateAddress = $admin->ethereum_private_address;
        }*/
//        $admin->ethereum_private_address = $admin->confirm_ethereum_private_address = Security::decrypt($privateAddress, Configure::read('EncryptionKey'));
        $this->set(compact('admin'));
    }

    public function forgotPassword()
    {
        $this->viewBuilder()->layout('admin_login');
        if ($this->request->is('post')) {
            $this->loadModel('Users');
            $query = $this->Users->find('all', [
                'conditions' => [
                    'email' => $this->request['data']['email'],
                ]
            ]);

            if ($query->count()) {
                $user = $query->first();
                //reset password logic
                $token = md5(time() . rand(100, 1000000));
                $query->update()
                    ->set(['token' => $token])
                    ->where(['id' => $user->id])
                    ->execute();

                //send email to client
                $this->sendEmail($user['email'], "Admin Reset Password", 'reset_password', 'html', ['token' => $token, 'user' => $user]);
                $this->Flash->success(__('The link to reset password is sent to your email address. Please follow the instruction in the email.'));
            } else {
                $this->Flash->error(__('Invalid email address, please try again later'));
            }
        }
    }

    public function resetPassword($token = null)
    {
        if ($token != null && $token != '') {
            $this->viewBuilder()->layout('admin_login');
            $this->loadModel('Users');
            $query = $this->Users->find('all', [
                'conditions' => [
                    'Users.token' => $token,
                ]
            ]);
            if ($query->count()) {
                $user = $query->first();
                $admin = $this->Users->get($user->id);
                if ($this->request->is(['patch', 'post', 'put'])) {
                    $admin = $this->Users->patchEntity($admin, $this->request->data, [
                        'validate' => 'ResetPass'
                    ]);
                    if (!$admin->errors()) {
                        $admin->password = md5($this->request['data']['password']);
                        $admin->token = '';
                        $this->Users->save($admin);
                        $this->Flash->success(__('Password has been reset, please login with the new password'));
                        $this->redirect(['controller' => 'Users', 'action' => 'login']);
                    } else {
                        $this->Flash->error(__('There are some validation issues. Please try again'));
                    }

                    $this->set(compact('admin'));
                }
            } else {
                $this->Flash->error(__('Invalid Token or the reset password link is expired'));
                return $this->redirect(['controller' => 'Users', 'action' => 'login']);
            }
        } else {
            $this->Flash->error(__('Invalid Token'));
            return $this->redirect(['controller' => 'Users', 'action' => 'login']);
        }
    }

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $conditions['Users.role'] = 'M';
        if (isset($this->request->query['keyword']) && $this->request->query['keyword'] != '') {
            $conditions['OR']['Users.username LIKE'] = '%' . $this->request->query['keyword'] . '%';
            $conditions['OR']['Users.email LIKE'] = '%' . $this->request->query['keyword'] . '%';
            $conditions['OR']['Users.first_name LIKE'] = '%' . $this->request->query['keyword'] . '%';
            $conditions['OR']['Users.last_name LIKE'] = '%' . $this->request->query['keyword'] . '%';
        }

        $query = $this->Users->find('all', ['order' => ['Users.created' => 'desc']])->where($conditions);
        $this->setDefaultOrdering($query, $this->Users->alias());
        $users = $this->paginate($query);

        $this->set(compact('users'));
        $this->set('_serialize', ['users']);
    }

    /**
     * View method
     *
     * @param string|null $id User id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {

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
        if ($id == null) {
            $user = $this->Users->newEntity();
            $action = 'Add';
        } else {
            $user = $this->Users->get($id, [
                'contain' => []
            ]);
            $action = 'Edit';
            $this->request->data['updated'] = time();
        }

        if ($this->request->is(['patch', 'post', 'put'])) {
            $user = $this->Users->patchEntity($user, $this->request->data);
//            prd($user);
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The user could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('user', 'action'));
        $this->set('_serialize', ['user']);
    }

    /**
     * Delete method
     *
     * @param string|null $id User id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $user = $this->Users->get($id);
        if ($this->Users->delete($user)) {
            $this->Flash->success(__('The user has been deleted.'));
        } else {
            $this->Flash->error(__('The user could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }

    public function dashboard()
    {
//        require_once(ROOT . DS . 'src' . DS . "vendor". DS . "autoload.php");
//        $thi =  new \Github\Client();
//        prd($thi);
//        $this->loadComponent('Git');
//        $res = $this->Git->createRepo(['name'=>'testrepo3', 'desc'=>'test repo desc']);
//        prd($res);
    }

    /**
     * Save user log
     * @param string $type
     * @return void
     */
    function __addUserLog($type = 'login')
    {
        $this->loadModel('UserLogs');
        $userLogs = $this->UserLogs->newEntity();

        $userLogs->ip_address = $_SERVER['REMOTE_ADDR'];
        $userLogs->user_id = $this->Auth->user('id');
        $userLogs->type = $type;
        $this->UserLogs->save($userLogs);
    }

    function account() {
        $data = [];
        $this->loadComponent('Common');
//        $data['balance'] = $this->Common->getBalance(Configure::read('AdminAccount'));
        $data['balance'] = Configure::read('InitialSupply');
        $data['balance_business'] = $this->Common->getBalance(Configure::read('BusinessAccount'));
        $data['balance_dev'] = $this->Common->getBalance(Configure::read('DevelopmentAccount'));

        $jwtToken = $this->Common->getToken();
        $balance = file_get_contents(Configure::read('ApiUrlDevAcc')."getTotalReservedTokens/$jwtToken");
        $data['total_reserved'] = $this->Common->formatToken(json_decode($balance)->TotalReserved);

        $data['remaining_tokens'] = $this->Common->getTokenBalance(Configure::read('DevelopmentAccount'));
       $data['remaining_tokens'] = $this->Common->formatToken(json_decode($balance)->RemainingTokens);

        $this->set(compact('data'));
    }

    function transfer(){
        if ($this->request->is('post')) {
            $this->loadComponent('Common');
            //prd($this->request->data);
            $jwtToken = $this->Common->getToken();
            $coins = $this->Common->formatTokenSend($this->request->data['coin']);
            $data = [];

            if($this->request->data['from_account'] == 'dev'){
                $url = Configure::read('ApiUrl')."transferTokensFromDevelopmentToBusiness/$coins/$jwtToken";
                $result = $this->Common->curlPost($url,[]);
                $data['type'] = 'DB';
            }elseif($this->request->data['from_account'] == 'business' && $this->request->data['to_account_type'] == 'dev'){
                $url = Configure::read('ApiUrl')."transferTokensFromBusinessToDevelopment/$coins/$jwtToken";
                $result = $this->Common->curlPost($url,[]);
                $data['type'] = 'BD';
            }elseif($this->request->data['from_account'] == 'business' && $this->request->data['to_account_type'] == 'other'){
                $toAddress = $this->request->data['to_address'];
                $url = Configure::read('ApiUrl')."transferTokensFromBusiness/$toAddress/$coins/$jwtToken";
                $result = $this->Common->curlPost($url,[]);
                $data['type'] = 'BO';

                $this->loadModel('Users');
                $query = $this->Users->find('all', [
                    'conditions' => [
                        'Users.ethereum_public_address' => $toAddress,
                    ]
                ]);

                if ($query->count()) {
                    $user = $query->first();
                    $data['user_id'] = $user->id;
                }

            }
            $result = json_decode($result);
            if(isset($result->status) && $result->status == 1){

                $this->loadModel('Transactions');
                $data['backlog_id'] = 0;
                $data['project_id'] = 0;
                if(!isset($data['user_id'])){
                    $data['user_id'] = 0;
                }
                $data['address'] = $toAddress;
                $data['status'] = 1;
                $data['amount'] = $coins;

                $transactions = $this->Transactions->newEntity();
                $transactions = $this->Transactions->patchEntity($transactions, $data);
                $this->Transactions->save($transactions);


                $this->Flash->success(__('Transfer has been completed successfully.'));
                $this->redirect(['controller' => 'Users', 'action' => 'transfer']);

            } else {
                if(isset($result->Error) && isset($result->Error->message->reason)) {
                    $this->Flash->error(__($result->Error->message->reason.'. Please try again'));
                }else{
                    $this->Flash->error(__('Transaction can not be completed. Please try again'));
                }

            }
        }
    }

    function percentage(){
        $this->loadComponent('Common');
        $jwtToken = $this->Common->getToken();

        if ($this->request->is('post')) {
//            prd($this->request->data);
            $err = 0;
            if(isset($this->request->data['dev_business'])){
                $data['DevBusiPct'][] = $devPct = $this->request->data['development'];
                $data['DevBusiPct'][] = $busiPct = $this->request->data['business'];
                if($devPct + $busiPct == 100){
                    $url = Configure::read('ApiUrl')."updateDistributiveFiguresOfAccounts/$devPct/$busiPct/$jwtToken";
                    $result = $this->Common->curlPost($url,[]);
                }else{
                    $this->Flash->error(__('The sum of development and business percentage should be 100.'));
                    $err = 1;
                }

            }elseif(isset($this->request->data['dev_voter'])){
                $data['DevVoterPct'][] = $devPct = $this->request->data['developer'];
                $data['DevVoterPct'][] = $voterPct = $this->request->data['viewer'];
                if($devPct + $voterPct == 100){
                    $url = Configure::read('ApiUrlDevAcc')."updateDeveloperVoterPercentage/$devPct/$voterPct/$jwtToken";
                    $result = $this->Common->curlPost($url,[]);
                }else{
                    $this->Flash->error(__('The sum of developer and viewer percentage should be 100.'));
                    $err = 1;
                }
            }elseif(isset($this->request->data['winners'])){
                $data['WinnerPct'][] = $winner1 = $this->request->data['winner_1'];
                $data['WinnerPct'][] = $winner2 = $this->request->data['winner_2'];
                $data['WinnerPct'][] = $winner3 = $this->request->data['winner_3'];

                if(($winner1 + $winner2 + $winner3) == 100){
                    $url = Configure::read('ApiUrlDevAcc')."updateWinnersPercentage/$winner1/$winner2/$winner3/$jwtToken";
                    $result = $this->Common->curlPost($url,[]);
                }else{
                    $this->Flash->error(__('The sum of winner1, winner2 and winner3 percentage should be 100.'));
                    $err = 1;
                }
            }
            if($err == 0){
                $result = json_decode($result);
            }

            if($err == 0) {
                if (isset($result->status) && $result->status == 1) {
                    $this->Flash->success(__('Percentage has been updated successfully.'));
                    $this->redirect(['controller' => 'Users', 'action' => 'percentage']);

                } else {
                    if (isset($result->Error) && isset($result->Error->message->reason)) {
                        $this->Flash->error(__($result->Error->message->reason . '. Please try again'));
                    } else {
                        $this->Flash->error(__('Percentage can not be updated. Please try again'));
                    }
                }
            }
        }
        if(!isset($data['DevBusiPct'])){
            $dbp = json_decode(file_get_contents(Configure::read('ApiUrl') . "getPercentageForDevelopmentAndBusiness/$jwtToken"));
            foreach ((array)$dbp->DevBusiPct as $row) {
                $data['DevBusiPct'][] = $row;
            }
        }
        if(!isset($data['DevVoterPct'])) {
            $dvp = json_decode(file_get_contents(Configure::read('ApiUrlDevAcc') . "getDeveloperAndVoterPercentage/$jwtToken"));
            foreach ((array)$dvp->Result as $row) {
                $data['DevVoterPct'][] = $row;
            }
        }
        if(!isset($data['WinnerPct'])) {
            $wp = json_decode(file_get_contents(Configure::read('ApiUrlDevAcc') . "getWinnersPercentage/$jwtToken"));
            foreach ((array)$wp->Result as $row) {
                $data['WinnerPct'][] = $row;
            }
        }

        $this->set(compact('data'));
    }

    function minting(){
        $data = [];
        $this->set(compact('data'));
    }


    function transactions(){
        $data = [];
        $this->loadComponent('Common');
        $data['balance'] = Configure::read('InitialSupply');
        $data['balance_business'] = $this->Common->getBalance(Configure::read('BusinessAccount'));
        $data['balance_dev'] = $this->Common->getBalance(Configure::read('DevelopmentAccount'));
        $jwtToken = $this->Common->getToken();
        $balance = file_get_contents(Configure::read('ApiUrlDevAcc')."getTotalReservedTokens/$jwtToken");
        $data['total_reserved'] = $this->Common->formatToken(json_decode($balance)->TotalReserved);

        $this->loadModel('Transactions');

        $status = (isset($_GET['status']) && $_GET['status'] != '') ? $_GET['status'] : 1;
        if($status == 'BO' || $status == 'DB' || $status == 'BD'){
            $conditions['Transactions.status'] = 1;
            $conditions['Transactions.type'] = $status;
            $contain = [];
        }else{
            $conditions['Transactions.status'] = $status;
            $conditions['Transactions.project_id > '] = 0;
            $conditions['Transactions.type IN'] = ['W', 'V'];
            $contain['contain'] = ['Projects'];
        }

        $query = $this->Transactions->find('all', $contain)
            ->where($conditions);
        $this->setDefaultOrdering($query, $this->Transactions->alias());
//        $this->paginate =  ['limit' => 1];
        $transactions = $this->paginate($query);
        //prd($transactions);

        $this->set(compact('data', 'transactions'));
    }
}
