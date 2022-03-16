<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link      http://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller;

use Cake\Controller\Controller;
use Cake\Event\Event;
use Cake\Mailer\Email;
use Cake\Core\Configure;
use Cake\Routing\Router;

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link http://book.cakephp.org/3.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller
{

    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading components.
     *
     * e.g. `$this->loadComponent('Security');`
     *
     * @return void
     */
    public function initialize()
    {
        parent::initialize();
        $this->loadComponent('RequestHandler');
        $this->loadComponent('Common');
        $this->loadComponent('Flash');

        $this->set('commonComponent', $this->Common);
        $this->set('siteTitle', Configure::read('Site.title'));
        $this->set('baseUrl', Router::url('/'));

        if(isset($this->request->params['prefix']) && $this->request->params['prefix'] == 'admin'){
            $this->viewBuilder()->layout('admin');
            $this->loadComponent('Auth', [
                'loginRedirect' => [
                    'controller' => 'Users',
                    'action' => 'dashboard',
                    'prefix'=>'admin'
                ],
                'logoutRedirect' => [
                    'controller' => 'Users',
                    'action' => 'login',
                    'prefix'=>'admin'
                ]
            ]);
            $this->Auth->sessionKey ='Auth.Admin';
            $this->Auth->allow(['forgotPassword', 'resetPassword', 'changeStatus', 'register', 'verify', 'checkEmail', 'checkUsername', 'deletePic'
                , 'mintNewTokens', 'getWinners', 'updateBacklogStatus', 'releaseTokensVoters'
                , 'processFailedTransactions', 'updateBacklogStartStatus', 'updateBacklogEndStatus'
                , 'updateBacklogVoteStartStatus', 'updateBacklogVoteEndStatus']);

            $this->loadModel('Transactions');
            $query = $this->Transactions->find('all', [
                'conditions' => [
                    'Transactions.status' => 0,
                    'Transactions.user_id >' => 0,
                    'Transactions.project_id >' => 0,
                    'Transactions.type IN' => ['W', 'V']
                ]
            ]);
            $this->set('failedTransactionsCount', $query->count());

        } else {
            $this->loadComponent('Auth', [
                'loginRedirect' => [
                    'controller' => 'About',
                    'action' => 'index'
                ],
                'logoutRedirect' => [
                    'controller' => 'Users',
                    'action' => 'login'
                ]
            ]);

            $this->Auth->allow(['home', 'forgotPassword', 'resetPassword', 'register', 'verify', 'checkEmail'
                , 'checkUsername','payWinnersWeekly']);
            if($this->request->session()->check('application_id')){
                $this->getMenuItems($this->request->session()->read('application_id'));
                $this->setCurrentPage();
            }
        }

        //If login cookie is set then automatically login user if session out.
        $this->checkLoginCookie();

        $this->set("authUser", $this->Auth->user());

        $this->loadComponent('Cookie');
        $this->Cookie->config('path', '/');
        $this->Cookie->config([
            'expires' => '+10 days',
            'httpOnly' => true
        ]);

        if(!isset($this->request->params['prefix']) || $this->request->params['prefix'] != 'admin'){
            //load all configurations
            $this->loadDefaultConfigurations();
        }

    }

    /**
     * Before render callback.
     *
     * @param \Cake\Event\Event $event The beforeRender event.
     * @return void
     */
    public function beforeRender(Event $event)
    {
        if (!array_key_exists('_serialize', $this->viewVars) &&
            in_array($this->response->type(), ['application/json', 'application/xml'])
        ) {
            $this->set('_serialize', true);
        }
    }

    /**
     * sendEmail
     *
     * @param $to email address
     * @param $subject string
     * @param $template string
     * @param $format string
     * @param $viewVars array
     * @return boolean
     */
    public function sendEmail($to, $subject, $template = 'default', $format = 'text',$viewVars= array()){

        if($_SERVER['HTTP_HOST'] == 'localhost'){
           // Sample smtp configuration.
//           Email::configTransport('gmail', [
//               'host' => 'ssl://smtp.gmail.com',
//               'port' => 465,
//               'username' => 'testersps@gmail.com',
//               'password' => 'Test@321',
//               'className' => 'Smtp'
//           ]);
//            return true;
        }
        $subject = '['.Configure::read('Site.title').'] '.$subject;
        $email = new Email();
        $email->to($to);
        $email->subject($subject);
        $email->template($template);
        $email->viewVars($viewVars);
        $email->emailFormat($format);
        $email->send();
        return true;
    }

    /**
     * setDefaultOrdering
     * Function used to set the default ordering
     * @param $query object query object
     * @param $alias table alias
     */
    public function setDefaultOrdering(&$query, $alias){
        $orderField = $alias.'.id';
        if(isset($this->request->query['sort']) && $this->request->query['sort'] !=''){
            $orderField = $this->request->query['sort'];
        }
        $orderDirection  = 'desc';
        if(isset($this->request->query['direction']) && $this->request->query['direction'] !=''){
            $orderDirection = $this->request->query['direction'];
        }
        $query->order([$orderField => $orderDirection]);
    }

    /**
     * getDefaultConfigurations
     * Function used to set the default ordering
     * @return array() data of all configurations
     */
    public function getDefaultConfigurations(){
        $this->loadModel('Configurations');
        $configs = $this->Configurations->find('all', [
                'fields'=>['conf_key', 'conf_value'],
                'conditions' => [
                    'Configurations.load'=>1,
                ]
        ]);
        $resp = array();
        foreach($configs  as $val){
            $resp[$val->conf_key] = $val->conf_value;
        }
       return $resp;
    }

    /**
     * loadDefaultConfigurations
     * Function to write the configurations in to session
     */
    public function loadDefaultConfigurations(){
        $session = $this->request->session();
        $configs = $session->read('Configs');
        if(empty($configs) || $configs == null){
            $session->write( 'Configs' ,$this->getDefaultConfigurations());
        }
    }

    /*
     * If login cookie is set then automatically login user if session out.
     */
    function checkLoginCookie(){
        $this->loadComponent('Cookie');
        if(isset($this->request->params['prefix']) && $this->request->params['prefix'] == 'admin'){
            $table = 'Admins';
        }elseif(isset($this->request->params['prefix']) && $this->request->params['prefix'] == 're'){
            $table = 'Partners';
        }else{
            $table = 'Users';
        }
        if(!$this->Auth->user() && $this->Cookie->read('remember_token') != ''){ //if remember me cookie is set
            $this->loadModel($table);
            $query = $this->$table->find('all', [
                'conditions' => [
                    $table.'.remember_token'=>$this->Cookie->read('remember_token'),
                ]
            ]);

            if ($query->count()) {
                $user = $query->first();
                if($user->status == 1){
                    $this->Auth->setUser($user->toArray());
                    if($table == 'Users'){

                    }
                    return $this->redirect($this->Auth->redirectUrl());
                }else{
                    $this->Flash->error(__('Your account is currently inactive.'));
                    $this->Cookie->delete('remember_token');
                    $this->Auth->logout();
                }

            }
        }else if ($table = 'Users' && !$this->request->session()->check('application_id') && $this->Auth->user()) {


        }
    }
}
