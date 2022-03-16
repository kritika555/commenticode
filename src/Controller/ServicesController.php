<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Core\Configure;
use Cake\Log\Log;

/**
 * Services Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 * @property \App\Controller\Component\MarksManComponent $MarksMan
 */
class ServicesController extends AppController
{
    public function initialize()
    {
        parent::initialize();
        $this->loadComponent('RequestHandler');
        $this->loadComponent('Workflow');
        $this->Auth->allow();
    }

    /*
    * Users login service
    */
    public function loginService()
    {

        $data = array();
        $this->loadModel('Users');
        if ($this->request->is('post')) {

            $query = $this->Users->find('all', [
                'conditions' => [
                    'Users.email' => $this->request['data']['email'],
                    'Users.password' => md5($this->request['data']['password']),
                ]
            ]);
            if ($query->count()) {
                $user = $query->first();
                if ($user->status == 1) {
                    $data['success'] = true;
					
					$this->loadModel('Applications');
                    
					$appQuery = $this->Applications->find('all', [
                        'conditions' => ['Applications.user_id' => $user->id, 'Applications.locked' => 0]
                    ]);
                    $data['data'] = [
                        'id' => $user->id,
                        'email' => $user->email,
                        'status' => $user->status,
                    ];
                    $appEntity = $appQuery->first();
                    if($appEntity){
                        $steps = $this->getMenuItems($appEntity->id, true);
                        $data['data']['steps'] = $steps;
                        $data['data']['application_id'] = $appEntity->id;
                    }

                } else {
                    $data['success'] = false;
                    $data['message'] = 'Your account is not verified yet. Please check your email for verification link.';
                }
            } else {
                $data['success'] = false;
                $data['message'] = 'You entered a wrong username or password.  Please try again.';
            }
        } else {
            $data['success'] = false;
            $data['message'] = 'Oops! We had a problem and could not log you on.  Please try again in a few minutes.';
        }
        $this->set('data', $data);
        $this->set('_serialize', ['data']);
    }

    /**
     * Register method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     * Array passed:
     * $data ['password']
     * $data ['confirm_password']
     * $data ['email']
     * $data ['confirm_email']
     *
     */
    public function register()
    {
        $data = array();

        if ($this->request->is('post')) {
            $this->loadModel('Users');
            $user = $this->Users->newEntity();
            $user = $this->Users->patchEntity($user, $this->request->data);
            if (!$user->errors()) {
                $user->status = 0;
                $user->password = md5($this->request['data']['password']);
                $user->verification_token = md5(time() . rand(100, 1000000));

                if ($this->Users->save($user)) {
                    $subject = "Welcome";
                    $this->sendEmail($user->email, $subject, 'register_user', 'html', ['user' => $user]);

                    $data['success'] = true;
                    $data['message'] = 'Your account has been registered. Please follow the link in your email to verify your account.';
                } else {
                    $data['success'] = false;
                    $data['errors'] = $user->errors();
                    $data['message'] = 'An error occurred while registering your account. Please, try again.';
                }
            } else {
                $data['success'] = false;
                $data['errors'] = $user->errors();
                $data['message'] = 'An error occurred while registering your account. Please, try again.';
            }
        } else {
            $data['success'] = false;
            $data['message'] = 'Invalid request. Please try again in a few minutes.';
        }

        $this->set('data', $data);
        $this->set('_serialize', ['data']);
    }


}
