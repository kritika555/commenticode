<?php
namespace App\Controller;
use Cake\Datasource\ConnectionManager;
use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Core\Configure;
use Cake\Utility\Security;
use Cake\Mailer\Email;

/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 */
class UsersController extends AppController
{

    public function initialize()
    {
        parent::initialize();
        if ($this->request->action === 'register') {
            //reload recaptcha component
            $this->loadComponent('Recaptcha.Recaptcha');
        }
    }

    /**
     * Index method
     */
    public function index()
    {

    }

    /**
     * Home method
     */
    public function home()
    {
        $this->viewBuilder()->layout('home');

    }

    /**
     * Dashboard method
     */
    public function dashboard()
    {

    }

    /**
     * Register method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function register()
    {

        $this->viewBuilder()->layout('default_login');
        $user = $this->Users->newEntity();

        if ($this->request->is('post')) {
            $user = $this->Users->patchEntity($user, $this->request->data);
            if (!$user->errors()) {
                $user->status = 0;
                $user->password = md5($this->request['data']['password']);
                $user->verification_token = md5(time() . rand(100, 1000000));
                
                if ($this->Users->save($user)) {
                    $this->Flash->success(__('Your account has been registered. Please follow the link in your email to verify your account.'));
                    $subject = "Welcome to " . Configure::read('Site.title');
                    $this->sendEmail($user->email, $subject, 'register_user', 'html', ['user' => $user]);
                    return $this->redirect(['action' => 'register']);
                } else {
                    //$this->Flash->error(__('An error occurred while registering your account. Please, try again.'));
					//$this->Flash->error(__('An error occurred while registering your account. Please, try again.'));
					//$this->Flash->error(__('Sorry Incoming registrations are closed.'));
				}

            } else {
                //$this->Flash->error(__('An error occurred while registering your account. Please, try again.'));
                //$this->Flash->error(__('Sorry Incoming registrations are closed'));
			}
        }
		$this->Flash->error(__('Sorry Incoming registrations are closed'));
        $scripts = [strtolower($this->name).'/register'];
        $this->set(compact('user', 'scripts'));
        $this->set('_serialize', ['user']);
    }


    /**
     * Users login
     * @return \Cake\Network\Response|null
     */
    public function login()
    {        
        $this->viewBuilder()->layout('default_login');
        if ($this->Auth->user('id') > 0) {

            return $this->redirect(['controller' => 'about', 'action' => 'index']);
        }

        if ($this->request->is('post')) {

            $query = $this->Users->find('all', [
                'conditions' => [
                    'OR'=>[
                        'Users.email' => $this->request['data']['username'],
                        'Users.username' => $this->request['data']['username']
                    ],
                    'Users.password' => md5($this->request['data']['password']),
                    //'Users.role' => 'M',
                ]
            ]);

            if ($query->count()) {
                $user = $query->first();
                if ($user->status == 1) {
                    $this->Auth->setUser($user->toArray());
                    $this->__addUserLog();
					
                    return $this->redirect($this->Auth->redirectUrl());

                } else {
                    $this->Flash->error(__('Your account is currently inactive.'));
                }
            } else {
                $this->Flash->error(__('Invalid Username/Email or Password, try again'));
            }
        }
    }

    /**
     * Logout
     * @return \Cake\Network\Response|null
     */
    public function logout()
    {
        $this->Cookie->delete('remember_token');
        $this->__addUserLog('Logout');
        return $this->redirect($this->Auth->logout());
    }

    /**
     * Change Password
     */
    public function changePassword()
    {
        $this->Users->validator('default')
            ->requirePresence('current_password')
            ->notEmpty('current_password');

        if ($this->request->is(['patch', 'post', 'put'])) {
            $user = $this->Users->get($this->Auth->user('id'));


            $user = $this->Users->patchEntity($user, $this->request->data, [
                'validate' => 'ChangePass'
            ]);

            if (!$user->errors()) {
                $user->password = md5($this->request['data']['password']);
                $this->Users->save($user);

                $this->Flash->success(__('Password changed successfully.'));
                $this->redirect(['controller' => 'Users', 'action' => 'change-password']);

            } else {
                $this->Flash->error(__('There are some validation issues. Please try again'));
            }
        } else { //to empty the default form
            $user = $this->Users->newEntity();
        }
        $scripts = [strtolower($this->name).'/changePassword'];
        $this->set(compact('user', 'scripts'));
    }

    /**
     * Verify email address of user
     * @param null $token
     * @return \Cake\Network\Response|null
     */
    public function verify($token = null)
    {
        $this->viewBuilder()->layout('default_login');
        if ($token != null && $token != '') {
            $query = $this->Users->find('all', [
                'conditions' => [
                    'Users.verification_token' => $token,
                ]
            ]);
            if ($query->count()) {
                $user = $query->first();
                $user = $this->Users->get($user->id);
                $user->verification_token = '';
                $user->status = 1;
                $this->Users->save($user);
                //Send email to user
                $subject = "Thanks for verifying your email";
                $this->sendEmail($user->email, $subject, 'user_thanks_for_verify', 'html', ['user' => $user]);

                $this->Flash->success(__('Thanks for verifying your email address, Please login to continue.'));
            } else {
                $this->Flash->error(__('Invalid Token or the link has been expired.'));
            }
        } else {
            $this->Flash->error(__('Invalid token.'));
        }
        return $this->redirect(['controller' => 'Users', 'action' => 'login']);
    }

    /**
     * checkEmail  method
     * @return void
     */
    public function checkEmail()
    {
        $this->viewBuilder()->layout('default_login');
        $this->autoRender = false;
        $resp = 'true';
        if ($this->request->query('email')) {
            $email = $this->request->query('email');
            if (!empty($email)) {
                $query = $this->Users->find('all', ['conditions' => ['Users.email' => $email]]);
                $userCnt = $query->count();
                if ($userCnt) {
                    $resp = 'false';
                }
            }
        }
        echo $resp;
        exit;
    }

    /**
     * checkEmail  method
     * @return void
     */
    public function checkUsername()
    {
        $this->viewBuilder()->layout('default_login');
        $this->autoRender = false;
        $resp = 'true';
        if ($this->request->query('username')) {
            $username = $this->request->query('username');
            if (!empty($username)) {
                $query = $this->Users->find('all', ['conditions' => ['Users.username' => $username]]);
                $userCnt = $query->count();
                if ($userCnt) {
                    $resp = 'false';
                }
            }
        }
        echo $resp;
        exit;
    }

    /**
     * Forgot Password
     */
    public function forgotPassword()
    {
        $this->viewBuilder()->layout('default_login');
        if ($this->request->is('post')) {
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
                $this->sendEmail($user['email'], "Reset Password", 'user_reset_password', 'html', ['token' => $token, 'user' => $user]);
                $this->Flash->success(__('The link to reset password is sent to your email address. Please follow the instruction in the email.'));
            } else {
                $this->Flash->error(__('Invalid email address, please try again later'));
            }
        }
    }

    /**
     * Reset password
     * @param null $token
     * @return \Cake\Network\Response|null
     */
    public function resetPassword($token = null)
    {
        $this->viewBuilder()->layout('default_login');
        if ($token != null && $token != '') {
            $query = $this->Users->find('all', [
                'conditions' => [
                    'Users.token' => $token,
                ]
            ]);
            if ($query->count()) {
                $user = $query->first();
                $user = $this->Users->get($user->id);
                if ($this->request->is(['patch', 'post', 'put'])) {
                    $user = $this->Users->patchEntity($user, $this->request->data, [
                        'validate' => 'ResetPass'
                    ]);
                    if (!$user->errors()) {
                        $user->password = md5($this->request['data']['password']);
                        $user->token = '';
                        $this->Users->save($user);
                        $this->Flash->success(__('Password has been reset, please login with the new password'));
                        $this->redirect(['controller' => 'users', 'action' => 'login']);
                    } else {
                        $this->Flash->error(__('There are some validation issues. Please try again'));
                    }

                    $this->set(compact('user'));
                }
            } else {
                $this->Flash->error(__('Invalid Token or the reset password link is expired'));
                return $this->redirect(['controller' => 'users', 'action' => 'login']);
            }
        } else {
            $this->Flash->error(__('Invalid Token'));
            return $this->redirect(['controller' => 'users', 'action' => 'login']);
        }
    }
	
	public function changePicture(){
		$user_id = $this->Auth->user('id');
		
		
		
	}

   public function changePortfolio()
   {
		$this->loadModel('Users');
        $user = $this->Users->get($this->Auth->user('id'), [
            'contain' => []
        ]);
		

		        $user_id = $this->Auth->user('id');
        
				if ($this->request->is(['patch', 'post', 'put'])) {
					$user = $this->Users->patchEntity($user, $this->request->data, [
						'validate' => 'changePortfolio'
					]); 
				}	
				$scripts = [strtolower($this->name).'/changePortfolio']; 
				
				$this->set(compact('user', 'scripts'));
				$this->set('user_id', $user_id);
		
   }   

    /*
     * Edit profile
     */
    public function editProfile()
    {		
		$this->loadModel('Users');
        $user = $this->Users->get($this->Auth->user('id'), [
            'contain' => []
        ]);
		$user_id = $this->Auth->user('id');
        if ($this->request->is(['patch', 'post', 'put'])) {
            $user = $this->Users->patchEntity($user, $this->request->data, [
                'validate' => 'EditProfile'
            ]);

		if(!empty($user['profile_photo']['name']))
        {
            $file = $user['profile_photo'];
			//prd($file['name']);
			$tmp_full = $file['tmp_name'];
			
			$tempname_split = explode("/", $tmp_full);
			$tempname = end($tempname_split);
            
			$type_split = explode("/", $file['type']);
			
			$extension=end($type_split);
            $newfilename=$tempname."_".$user_id . ".".$extension;
				
			$ext = substr(strtolower(strrchr($file['name'], '.')), 1); //get the extension
            $arr_ext = array('jpg', 'jpeg', 'gif','png'); //set allowed extensions

            //only process if the extension is valid
            if(in_array($ext, $arr_ext))
            {				
                //name image to saved in database
               // $user['image'] = $file['name'];
				$dir = WWW_ROOT . 'users' . DS . 'profile_photos'. DS; //<!-- app/webroot/img/
				$user['img_path']=$newfilename;
                //do the actual uploading of the file. First arg is the tmp name, second arg is
                //where we are putting it
               if(!move_uploaded_file($file['tmp_name'], $dir . $newfilename)) 
               {
                   $this -> Flash -> error(__('Image could not be saved. Please, try again.'));
                   //return $this->redirect(['action' => 'index']);
                }
			}
						
		}	
            if ($this->Users->save($user)) {
                $user = $this->Users->get($this->Auth->user('id'), [
                    'contain' => []
                ]);
                $data = $user->toArray();
                unset($data['password']);

                $this->Auth->setUser($data);
                $this->Flash->success(__('Profile has been saved.'));
                return $this->redirect(['action' => 'edit-profile']);
            } else {
                $this->Flash->error(__('Profile could not be saved. Please, try again.'));
            }
        }
        $scripts = [strtolower($this->name).'/editProfile'];
        $this->set(compact('user', 'scripts'));
		$this->set('user_id', $user_id);
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

    public function get_address($currentID) {
        $this->loadModel('Users');
        $address = $this->Users->find()
            ->select(['ethereum_public_address'])
            ->where(['Users.id'=>$currentID])
            ->distinct('ethereum_public_address')
            ->first()->toArray();
        $ethereum_public_address = $address['ethereum_public_address'];
        return $ethereum_public_address;     
    }

    function account() {
        $currentID =$this->Auth->user('id');
        $currentAddress = $this->get_address($currentID);        
        $address = (isset($_GET['address']) && !empty($_GET['address'])) ? $_GET['address'] : $currentAddress;

        $this->loadComponent('Common');
        $balance = $this->Common->getBalance($address);

        $this->loadModel('Transactions');
        $userId = $this->Auth->user('id');
        //must work on this in admin/users/transfer page
        $addresses = $this->Transactions->find()
            ->select(['id', 'address'])
            ->where(['Transactions.user_id'=>$userId, 'Transactions.status'=>1])
            ->distinct('address')
            ->toList();
        if(count($addresses) == 0) {
            $addresses[] = (object)['address'=>$currentAddress];
        }else{
            $add = true;
            foreach($addresses as $addr){
                if($addr->address == $currentAddress){
                    $add = false;
                    break;
                }
            }
            if($add) {
                $addresses[] = (object)['address'=>$currentAddress];
            }
        }

        $query = $this->Transactions->find('all',
            ['contain' => ['Projects']])
            ->where(['Transactions.user_id'=>$userId, 'Transactions.status'=>1, 'Transactions.address'=>$address]);
        $this->setDefaultOrdering($query, $this->Transactions->alias());
//        $this->paginate =  ['limit' => 1];
        $transactions = $this->paginate($query);
//        prd($transactions);
		//new balance for coins kritika
		$coins = $this->Users->find()
            ->select(['id', 'coin_balance'])
            ->where(['Users.id'=>$userId])
            ->toList();
			
		$coin_balance = $coins[0]['coin_balance'];	
		$this->set('user_id',$userId);
        $this->set(compact('address', 'balance', 'transactions', 'addresses','coin_balance'));
    }
	
	public function pay()
	{
       
		$this->viewBuilder()->layout('default_login');
        if ($this->request->is('post')) {
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
                $this->sendEmail($user['email'], "Reset Password", 'user_reset_password', 'html', ['token' => $token, 'user' => $user]);
                $this->Flash->success(__('The link to reset password is sent to your email address. Please follow the instruction in the email.'));
            } else {
                $this->Flash->error(__('Invalid email address, please try again later'));
            }
        }
     /*   
		// transfer coins to user accounts between last seven days check highest 3 votes for each backlog
		$this->loadModel('ProjectVotes');		
		$end_date = date('Y-m-d H:i:s');		
		$start_date = date('Y-m-d H:i:s', strtotime('-7 day', strtotime($end_date)));
		
		$conn = ConnectionManager::get('default');
		$stmt = $conn->execute("SELECT DISTINCT projects.backlog_id FROM project_votes JOIN projects ON project_votes.project_id=projects.id JOIN backlogs ON projects.backlog_id = backlogs.id WHERE project_votes.action='U' AND project_votes.created>='".$start_date. "' AND project_votes.created<='".$end_date. "' GROUP BY project_votes.project_id ORDER BY projects.backlog_id DESC");
		$backlogs_list = $stmt ->fetchAll('assoc');
		
		
		foreach($backlogs_list as $key=>$block)
		{
			$main_backlog_id = $block['backlog_id'];
			echo '---Backlog ID----' . $main_backlog_id . '<br>';
			$conn = ConnectionManager::get('default');
			$stmt = $conn->execute("SELECT project_id,COUNT(*) as total_upvotes,project_votes.user_id,project_votes.created,projects.name as project_name ,projects.backlog_id,backlogs.title as backlog_title FROM project_votes JOIN projects ON project_votes.project_id=projects.id JOIN backlogs ON projects.backlog_id = backlogs.id WHERE project_votes.action='U' AND project_votes.created>='".$start_date. "' AND project_votes.created<='".$end_date. "' AND projects.backlog_id=".$main_backlog_id . " GROUP BY project_votes.project_id ORDER BY projects.backlog_id,total_upvotes DESC");
			$results = $stmt ->fetchAll('assoc');
					print_r($results);
		
		
		$winner1 = array();
		$winner2_3 = array();
		$winner2 = array();
		$winner3 = array();
		$winning_vote1 = $results[0]['total_upvotes'];
		echo 'WINNING VOTE::: '. $winning_vote1;
				
					
		$winner1 = array();
		$winner2_3= array();
		$winner2 =array();
		$winner3= array();
		$winning_vote1 = $results[0]['total_upvotes'];
		//echo 'WINNING VOTE::: '. $winning_vote1;
		
		array_push($winner1,$results[0]);			
		
		foreach($results as $key=>$item)
		{
		    $current_votes = ($item['total_upvotes']);
							
				if($current_votes==$winning_vote1)
				{
					array_push($winner1,$item);					
				} else {
					if($current_votes<$winning_vote1 && $key<>0)
					{
						$winning_vote2 = $current_votes;
						array_push($winner2_3,$item);
													

						
					}				
				}	
				
	   }
		//code for winner 3
		print_r($winner2_3);
		if(!empty($winner2_3)){
		$winningvote2 = $winner2_3[0]['total_upvotes'];
		//echo 'WINNER2:' . $winningvote2 .'<br>';
		
		unset($winner2_3[0]);
				
			foreach($winner2_3 as $key=>$item)
			{	
				if($item['total_upvotes']<>$winningvote2 && $item['total_upvotes']<$winningvote2)
				{
					
					array_push($winner3,$winner2_3[$key]);
					unset($winner2_3[$key]);
					//print_r($winner3);
					break;
				}	
			}
        }		
		echo 'Winner 1::' .'<br>';
		print_r($winner1);
		echo '<br>';
		
		echo 'Winner 2::' . '<br>';
		print_r($winner2_3);
		echo '<br>';
		
		echo 'Winner3::' . '<br>';
		print_r($winner3);
		echo '<br>';		
		
		
		
		$this->loadModel('Percentage');
		$lastCreatedPercentage = $this->Percentage->find('all', array('order' => array('Percentage.id' =>'desc')))->first()->toArray();
				
		$winner1_percentage = $lastCreatedPercentage['winner1'];
		$winner2_percentage = $lastCreatedPercentage['winner2'];
		$winner3_percentage = $lastCreatedPercentage['winner3'];
		
		$initial_supply = Configure::read('InitialSupply');
		$winner1_count = count($winner1);
		$winner2_count = count($winner2);
		$winner3_count = count($winner3);
								
		echo '<br>';				
		foreach($winner1 as $item)
		{		
			$this->loadModel('Users');
			$backlog_id = $item['backlog_id'];
			$user_id = $item['user_id'];
			$backlog = $this->loadModel('Backlogs')->get($backlog_id);
			$allocated_coin_backlog = $backlog->amount;
			$this->loadModel('Percentage');
			
		    $backlog = $this->loadModel('Backlogs')->get($backlog_id);
			$query = $this->Backlogs->find('all') ->where(['id IN' => $backlog_id]);
			
			$calculated_coins_winner1 = ($winner1_percentage/100)*$initial_supply;
			
			$calculated_coins_winner1 = $calculated_coins_winner1/$winner1_count;
			
			$user = $this->loadModel('Users')->get($user_id);
			$coin_balance = $user->coin_balance+$calculated_coins_winner1;
			$notification_message = '"You have earned' . $coin_balance . 'as first prize reward for highest voted project.';
			
			$data = array(
				'Users' => array(
				    
					'coin_balance' => $coin_balance,
					'notification_message' => $notification_message
				)
			);
			
			$tablename = TableRegistry::get("Users");
			$query = $tablename->query();
            $result = $query->update()
                    ->set(['coin_balance' => $coin_balance,'notification_message'=>$notification_message])
                    ->where(['id' => $user_id])
                    ->execute();
		}
		echo '<br>';
		echo '----------'.'<br>';
		
		
		
		
		} 
        exit();	
        		
        	*/
	}
	
	public function payWinnersWeekly()
	{		
	    
		// transfer coins to user accounts between last seven days check highest 3 votes for each backlog
		$this->loadModel('ProjectVotes');		
		$end_date = date('Y-m-d H:i:s');		
		$start_date = date('Y-m-d H:i:s', strtotime('-7 day', strtotime($end_date)));
		
		$conn = ConnectionManager::get('default');
		$stmt = $conn->execute("SELECT DISTINCT projects.backlog_id FROM project_votes JOIN projects ON project_votes.project_id=projects.id JOIN backlogs ON projects.backlog_id = backlogs.id WHERE project_votes.action='U' AND project_votes.created>='".$start_date. "' AND project_votes.created<='".$end_date. "' GROUP BY project_votes.project_id ORDER BY projects.backlog_id DESC");
		$backlogs_list = $stmt ->fetchAll('assoc');
		
		/* STARTING of LOOP */
		foreach($backlogs_list as $key=>$block)
		{
			$main_backlog_id = $block['backlog_id'];
			echo '---Backlog ID----' . $main_backlog_id . '<br>';
			$conn = ConnectionManager::get('default');
			$stmt = $conn->execute("SELECT project_id,COUNT(*) as total_upvotes,project_votes.user_id,project_votes.created,projects.name as project_name ,projects.backlog_id,backlogs.title as backlog_title FROM project_votes JOIN projects ON project_votes.project_id=projects.id JOIN backlogs ON projects.backlog_id = backlogs.id WHERE project_votes.action='U' AND project_votes.created>='".$start_date. "' AND project_votes.created<='".$end_date. "' AND projects.backlog_id=".$main_backlog_id . " GROUP BY project_votes.project_id ORDER BY projects.backlog_id,total_upvotes DESC");
			$results = $stmt ->fetchAll('assoc');
					print_r($results);
		
		
		$winner1 = array();
		$winner2_3 = array();
		$winner2 = array();
		$winner3 = array();
		$winning_vote1 = $results[0]['total_upvotes'];
		echo 'WINNING VOTE::: '. $winning_vote1;				
					
		$winner1 = array();
		$winner2_3= array();
		$winner2 =array();
		$winner3= array();
		$winning_vote1 = $results[0]['total_upvotes'];
		//echo 'WINNING VOTE::: '. $winning_vote1;
		
		array_push($winner1,$results[0]);			
		
		foreach($results as $key=>$item)
		{
		    $current_votes = ($item['total_upvotes']);
							
				if($current_votes==$winning_vote1)
				{
					array_push($winner1,$item);					
				} else {
					if($current_votes<$winning_vote1 && $key<>0)
					{
						$winning_vote2 = $current_votes;
						array_push($winner2_3,$item);						
					}				
				}	
				
	   }
		//code for winner 3
		print_r($winner2_3);
		if(!empty($winner2_3)){
		$winningvote2 = $winner2_3[0]['total_upvotes'];
		//echo 'WINNER2:' . $winningvote2 .'<br>';
		
		unset($winner2_3[0]);
				
			foreach($winner2_3 as $key=>$item)
			{	
				if($item['total_upvotes']<>$winningvote2 && $item['total_upvotes']<$winningvote2)
				{
					
					array_push($winner3,$winner2_3[$key]);
					unset($winner2_3[$key]);
					//print_r($winner3);
					break;
				}	
			}
        }		
		echo 'Winner 1::' .'<br>';
		print_r($winner1);
		echo '<br>';
		
		echo 'Winner 2::' . '<br>';
		print_r($winner2_3);
		echo '<br>';
		
		echo 'Winner3::' . '<br>';
		print_r($winner3);
		echo '<br>';		
		
		/*PAYMENT process*/
		
		$this->loadModel('Percentage');
		$lastCreatedPercentage = $this->Percentage->find('all', array('order' => array('Percentage.id' =>'desc')))->first()->toArray();
				
		$winner1_percentage = $lastCreatedPercentage['winner1'];
		$winner2_percentage = $lastCreatedPercentage['winner2'];
		$winner3_percentage = $lastCreatedPercentage['winner3'];
		
		$initial_supply = Configure::read('InitialSupply');
		$winner1_count = count($winner1);
		$winner2_count = count($winner2);
		$winner3_count = count($winner3);
								
		echo '<br>';				
		foreach($winner1 as $item)
		{		
			$this->loadModel('Users');
			$backlog_id = $item['backlog_id'];
			$user_id = $item['user_id'];
			$backlog = $this->loadModel('Backlogs')->get($backlog_id);
			$allocated_coin_backlog = $backlog->amount;
			$this->loadModel('Percentage');
			
		    $backlog = $this->loadModel('Backlogs')->get($backlog_id);
			$query = $this->Backlogs->find('all') ->where(['id IN' => $backlog_id]);
			
			$calculated_coins_winner1 = ($winner1_percentage/100)*$initial_supply;
			
			$calculated_coins_winner1 = $calculated_coins_winner1/$winner1_count;
			
			$user = $this->loadModel('Users')->get($user_id);
			$coin_balance = $user->coin_balance+$calculated_coins_winner1;
			$notification_message = '"You have earned' . $coin_balance . 'as first prize reward for highest voted project.';
			
			$data = array(
				'Users' => array(
				    
					'coin_balance' => $coin_balance,
					'notification_message' => $notification_message
				)
			);
			
			$tablename = TableRegistry::get("Users");
			$query = $tablename->query();
            $result = $query->update()
                    ->set(['coin_balance' => $coin_balance,'notification_message'=>$notification_message])
                    ->where(['id' => $user_id])
                    ->execute();
		}
		echo '<br>';
		echo '----------'.'<br>';
		
		
		}
        exit();		
        	
	}
}
