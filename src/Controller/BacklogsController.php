<?php
namespace App\Controller;

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
     * @param string $filter
     * @param string $type
     */
    public function index($filter = 'all', $type = 'doing')
    {
        $today = date('Y-m-d');
        $conditions = [];
        $userId = $this->Auth->user('id');
		//changed the condition
        //$conditions['Backlogs.status'] = '0';
        if ($type == 'doing') {
			//commented
            $conditions['Backlogs.start_date <='] = $today;
            $conditions['Backlogs.end_date >='] = $today;
            //$conditionsOr['Backlogs.project_added'] = 0;
        }
        if ($type == 'done') {
            $conditions['Backlogs.vote_start_date <='] = $today;
            $conditions['Backlogs.vote_end_date >='] = $today;
           // $conditions['Backlogs.project_added'] = 1;
           // $conditions['Backlogs.project_added'] = $conditionsOr['Backlogs.project_added'] = 1;
           // $conditionsOr['Backlogs.vote_added'] = 0;
        }
        if ($type == 'close') {
			//kritika : I have commented these codes to show the bcklogs 
            $conditions['Backlogs.vote_end_date <'] = $today;
            $conditions['Backlogs.project_added'] = 1;
            $conditions['Backlogs.vote_added'] = 1;

            //Check if the projects in the backlog have 2/3 votes
            $this->loadModel('Projects');
            $projects = $this->Projects->find('list', [
                'keyField' => 'id',
                'valueField' => 'backlog_id'
            ])
                ->where(['up_vote >'=>0, 'up_vote/(up_vote+down_vote) >= '=>2/3])
                ->distinct('backlog_id')
                ->toArray();
            if(count($projects)){
                //$conditions['Backlogs.id IN'] = $projects;
            }
            $nextReleaseDate = $this->__getNextReleaseDate();
        }

        if ($filter == 'my') {
            $conditions['Backlogs.created_by_id'] = $userId;
        }
        if (isset($this->request->query['title']) && $this->request->query['title'] != '') {
            $conditions['Backlogs.title LIKE'] = '%' . $this->request->query['title'] . '%';
        }

        $query = $this->Backlogs->find('all', ['contain' => ['Projects', 'Users']])->where($conditions);

        $this->setDefaultOrdering($query, $this->Backlogs->alias());
        //$this->paginate =  ['limit' => 1];
        $backlogs = $this->paginate($query);

        //Find winners of the close backlogs
        $winners = [];
        if ($type == 'close') {
            $backlogIds = [];
            if(count($backlogs) > 0) {
                foreach ($backlogs as $backlog) {
                    $backlogIds[] = $backlog->id;
                }
                $this->loadModel('Transactions');
                $winnerData = $this->Transactions->find('all', ['contain' => ['Users']])
                    ->where(['backlog_id IN' => $backlogIds])
                    ->order(['winner' => 'ASC'])
                    ->toArray();
                foreach ($winnerData as $winner) {
                    if ($winner->winner > 0) {
                        $winners[$winner->backlog_id][$winner->winner] = $winner->user->first_name . ' ' . $winner->user->last_name;
                    }
                }
            }
            //prd($winners);
        }
      
        $userRole = $this->Auth->user('role');

        if($userRole != 'A'){
            $query = $this->Backlogs->find('all', [
                'conditions' => [
                    'Backlogs.created_by_id' => $userId,
                ]
            ]);
            $totalUserBacklogLeftCalculated = Configure::read('MaxUserBacklogs') - $query->count();
			$totalUserBacklogLeft = ($query->count()> Configure::read('MaxUserBacklogs')) ? 0 : $totalUserBacklogLeftCalculated;

        }else{
            $totalUserBacklogLeft = 0;
        }
		//$user_id = $this->Auth->user('id');
		$this->set('user_id', $userId);		
        $this->set(compact('backlogs', 'userId', 'filter', 'type', 'winners', 'nextReleaseDate', 'totalUserBacklogLeft', 'userRole'));
        $this->set('_serialize', ['backlogs']);
    }

    function __getNextReleaseDate(){
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
            $daysLeft = $dateDiff % $interval->conf_value;
            $nextReleaseDate = date('m/d/Y', strtotime(' + '.$daysLeft.' days'));
            return $nextReleaseDate;
        }else{
            return 'Payment Date';
        }
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
        $githubOwner = Configure::read('githubOwner');
		$this->loadModel('Percentage');	
			
        $user_id = $this->Auth->user('id');
		$this->set('user_id', $user_id);
		$this->set('backlog', $backlog);
        $this->set('githubOwner',$githubOwner);
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
       $user_id = $this->Auth->user('id');
        //Max backlog/user check
        if ($this->Auth->user('role') != 'A') {
            $query = $this->Backlogs->find('all', [
                'conditions' => [
                    'Backlogs.created_by_id' => $user_id,
                ]
            ]);
            if ($query->count() >= Configure::read('MaxUserBacklogs')) {
                $this->Flash->error(__('You can only add '.Configure::read('MaxUserBacklogs').' backlogs.'));
                return $this->redirect(['action' => 'index']);
            }
        }
		
        if ($id == null) {
            $backlog = $this->Backlogs->newEntity();
            $action = 'Add';
            $this->request->data['created_by_id'] = $user_id;
        } else {
            $backlog = $this->Backlogs->get($id, [
                'contain' => []
            ]);

            if ($userId != $backlog->created_by_id) {
                $this->Flash->error(__('You don\'t have an access to this repository.'));
                return $this->redirect(['action' => 'index']);
            }

            $action = 'Edit';
            $this->request->data['updated'] = time();
            $this->request->data['updated_by_id'] = $user_id;
        }

        if ($this->request->is(['patch', 'post', 'put'])) {
            $backlog = $this->Backlogs->patchEntity($backlog, $this->request->data);
			
            if ($this->Backlogs->save($backlog)) {
                $this->loadComponent('Git');
                $update = false;
                //Create repo
                if ($id == null) {
//                 $repoName = str_replace(' ', '-', $this->request->data['repository_name']);
                   //$repoName = uniqid();
                   $repoName = str_replace(' ', '-', $this->request->data['repository_name']). '_' . $user_id;
					//$repoName = $this->request->data['repository_name'];
					$repoDesc = $this->request->data['description'];
                    $repo = $this->Git->createRepo($repoName, $repoDesc);
                    $this->request->data['github_repo'] = json_encode($repo);
                    $update = true;
                    $backlog->backlog_repo_name = $repoName;
                }
                //Create file
                if (isset($_FILES['code_base']['tmp_name']) && $_FILES['code_base']['tmp_name'] != '') {
                    if ($id > 0 && !empty($backlog->github_repo)) {
                        $repo = (array)json_decode($backlog->github_repo);
                    }
                    if ($repo != '') {
                        $fileInfo = $this->Git->uploadFile($repo['name'], $_FILES['code_base']);
                        $this->request->data['github_file'] = json_encode($fileInfo);
                        $update = true;
                    }
                }
                if ($update) {
                    $backlog = $this->Backlogs->patchEntity($backlog, $this->request->data);
                    $this->Backlogs->save($backlog);
                }

                if ($id == null) {
                    $this->loadComponent('Common');
                    //Send email to admin on backlog creation
                    $adminEmails = $this->Common->getAdminEmails();
                    $subject = "New backlog created";
                    $this->sendEmail($adminEmails, $subject, 'new_backlog_created', 'html', ['backlog' => $this->request->data]);
                    $message = 'The backlog has been created and sent to the admin for approval.';
                } else {
                    $message = 'The backlog has been updated.';
                }
                $this->Flash->success(__($message));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The backlog could not be saved. Please, try again.'));
            }
        }
        $scripts = [strtolower($this->name) . '/add-edit'];
        $this->set(compact('backlog', 'action', 'user_id', 'scripts'));
        $this->set('_serialize', ['backlog']);
    }

    /**
     * Projects method
     *
     * @return \Cake\Network\Response|null
     */
    public function projects($backlogId = 0)
    {
        $this->loadModel('Projects');
        $conditions = [];
        if ($backlogId) {
            $backlog = $this->Backlogs->get($backlogId);
            $conditions['Projects.backlog_id'] = $backlogId;
        } else {
            $backlog = null;
        }

        if (isset($this->request->query['title']) && $this->request->query['title'] != '') {
            $conditions['Projects.name LIKE'] = '%' . $this->request->query['title'] . '%';
        }
        $query = $this->Projects->find('all', ['contain' => ['Users', 'Backlogs'], 'order' => ['Projects.status', 'Projects.created' => 'desc']])->where($conditions);
        $this->setDefaultOrdering($query, $this->Projects->alias());
        $data = $this->paginate($query);
       //prd($data);
        $this->request->session()->write('Back.projectView', 'projects');
        $this->set(compact('data', 'backlogId', 'backlog'));
        $this->set('_serialize', ['data']);
		$user_id = $this->Auth->user('id');
		$this->set('user_id', $user_id);		
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
        $userId = $this->Auth->user('id');
        $this->loadModel('Projects');

        $cond['Projects.backlog_id'] = $backlogId;
        $cond['Projects.created_by_id'] = $userId;
        if($id != null){
            $cond['Projects.id <>'] = $id;
        }

        //user can't add more than one project under the same backlog
        $query = $this->Projects->find('all', [
            'conditions' => $cond
        ]);
        if ($query->count() > 0) {
            $this->Flash->error(__('You can not add more than one solution to a backlog.'));
            return $this->redirect(['controller' => 'backlogs', 'action' => 'view', $backlogId]);
        }

        if ($backlogId) {
            $backlog = $this->Backlogs->get($backlogId);
        } else {
            $backlog = [];
        }


        if ($id == null) {
            $project = $this->Projects->newEntity();
            $action = 'Add';
            $this->request->data['created_by_id'] = $userId;
        } else {
            $project = $this->Projects->get($id, [
                'contain' => []
            ]);
            //User can't edit other user's project
            if ($project->created_by_id != $userId) {
                $this->Flash->error(__('You are not authorized to edit this project.'));
                return $this->redirect(['controller' => 'activities', 'action' => 'index']);
            }
            $action = 'Edit';
            $this->request->data['updated'] = time();
            $this->request->data['updated_by_id'] = $userId;
        }

        if ($this->request->is(['patch', 'post', 'put'])) {
            $project = $this->Projects->patchEntity($project, $this->request->data);
            if ($this->Projects->save($project)) {
                $this->loadComponent('Git');
                $update = false;
                //Create Repo
                if ($id == null) {
                    $repoName = str_replace(' ', '-', $this->request->data['name']). '_' . $userId;
                   // $repoName = uniqid();
                    $repoDesc = $this->request->data['description'];
                    $repo = $this->Git->createRepo($repoName, $repoDesc);
                    $this->request->data['github_repo'] = json_encode($repo);
                    $this->request->data['backlog_id'] = $backlogId;
                    $update = true;

                    // Set the project_added to 1 if there is any project added in the backlog
                    if (count($backlog) > 0) {
                        $backlog = $this->Backlogs->patchEntity($backlog, ['project_added' => 1]);
                        $this->Backlogs->save($backlog);
                    }

                }

                //Create file
                if (isset($_FILES['code_base']['tmp_name']) && $_FILES['code_base']['tmp_name'] != '') {
                    if ($id > 0 && !empty($project->github_repo)) {
                        $repo = (array)json_decode($project->github_repo);
                        $oldFile = (array)json_decode($project->github_file);
                        //prd($oldFile['content']->sha);
                    }else {
                        $oldFile = '';
                    }

                    if ($repo != '') {
                        $fileInfo = $this->Git->uploadFile($repo['name'], $_FILES['code_base'], $oldFile);
//                        prd($fileInfo);
                        $this->request->data['github_file'] = json_encode($fileInfo);
                        $update = true;
                    }
                }
                if ($update) {
                    $project = $this->Projects->patchEntity($project, $this->request->data);
                   
                    $project->repo_name  = $repoName;
                    $this->Projects->save($project);
                }

                $this->Flash->success(__('The record has been saved.'));
                return $this->redirect(['controller' => 'activities', 'action' => 'index']);
            } else {
                $this->Flash->error(__('The record could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('project', 'action', 'backlogId', 'backlog'));
		$this->set('user_id', $userId);
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
        if ($object->github_repo != '') {
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
	    $userId = $this->Auth->user('id');
        $this->loadModel('Projects');
        $this->loadModel('ProjectComments');
        if ($backlogId) {
            $backlog = $this->Backlogs->get($backlogId);
        } else {
            $backlog = [];
        }
        $project = $this->Projects->get($id);

        $query = $this->ProjectComments->find('all', ['contain' => ['Users']])->where(['ProjectComments.project_id' => $id]);
        $this->setDefaultOrdering($query, $this->ProjectComments->alias());
        //$this->paginate = ['limit' => 2];
        $projectComments = $this->paginate($query);
        //prd(json_decode($project->github_repo)->downloads_url);
        $githubOwner = Configure::read('githubOwner');

        $backAction = $this->request->session()->read('Back.projectView');

        $scripts = [strtolower($this->name) . '/vote'];
        $this->set(compact('project', 'backlogId', 'backlog', 'projectComments', 'scripts', 'backAction','githubOwner'));
        $this->set('user_id', $userId);
		$this->set('_serialize', ['backlog']);
    }


    /**
     * Project collaboration method
     *
     * @param string|null $id Backlog id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function collaboration($backlogId = null, $id = null)
    {
        $this->loadModel('Projects');
        $this->loadModel('ProjectTasks');
        $project = $this->Projects->get($id);

        $projectTasks = $this->ProjectTasks->find('all',
            [
                'order' => ['ProjectTasks.created' => 'desc']
            ]
        )->where(['ProjectTasks.project_id' => $id]);

        $tasks = [];
        foreach ($projectTasks as $task) {
            $tasks[$task['status']][] = ['task' => $task['task'], 'id' => $task['id']];
        }
        $scripts = [strtolower($this->name) . '/' . __FUNCTION__, strtolower($this->name) . '/vote'];
        $this->set(compact('data', 'backlogId', 'project', 'tasks', 'scripts', 'id'));
        $this->set('_serialize', ['data']);
    }

    /**
     * Project comments method
     *
     * @param string|null $id Backlog id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function comments($backlogId = null, $id = null)
    {
        $this->loadModel('Projects');
        $this->loadModel('ProjectComments');
        $project = $this->Projects->get($id);
        $projectComment = $this->ProjectComments->newEntity();
        $name = $this->Auth->user('first_name') . ' ' . $this->Auth->user('last_name');
		$userId = $this->Auth->user('id');

        if ($this->request->is(['patch', 'post', 'put'])) {
            $this->request->data['user_id'] = $this->Auth->user('id');
            $this->request->data['project_id'] = $id;
            $projectComment = $this->ProjectComments->patchEntity($projectComment, $this->request->data);
            if ($this->ProjectComments->save($projectComment)) {
                $this->Flash->success(__('Comment has been added successfully.'));
                return $this->redirect(['action' => 'comments', $backlogId, $id]);
            } else {
                $this->Flash->error(__('Comment can not be added. Please, try again.'));
            }
        }

        if ($backlogId) {
            $backlog = $this->Backlogs->get($backlogId);
        } else {
            $backlog = [];
        }

        $query = $this->ProjectComments->find('all',
            [
                'contain' => ['Users'],
                'order' => ['ProjectComments.created' => 'desc']
            ]
        )->where(['ProjectComments.project_id' => $id]);
        $this->setDefaultOrdering($query, $this->ProjectComments->alias());
        $data = $this->paginate($query);
        $backAction = $this->request->session()->read('Back.projectView');
        $scripts = [strtolower($this->name) . '/' . __FUNCTION__, strtolower($this->name) . '/vote'];
        $this->set(compact('data', 'backlogId', 'project', 'name', 'projectComment', 'scripts', 'backlog', 'backAction'));
        $this->set('_serialize', ['data']);
		$this->set('user_id',$userId);
    }

    /**
     * Set the task status
     */
    public function setTaskStatus()
    {
        if ($this->request->is(array('ajax'))) {
            $this->loadModel('ProjectTasks');
            $projectTask = $this->ProjectTasks->get($this->request->data['id']);
            $projectTask = $this->ProjectTasks->patchEntity($projectTask, $this->request->data);
            $this->ProjectTasks->save($projectTask);
        }
        die;
    }

    /**
     * Save the task status
     */
    public function saveTask()
    {
        if ($this->request->is(array('ajax'))) {
            $this->loadModel('ProjectTasks');
            $projectTask = $this->ProjectTasks->newEntity();
            $projectTask = $this->ProjectTasks->patchEntity($projectTask, $this->request->data);
            $result = $this->ProjectTasks->save($projectTask);
            echo $result->id;
        }
        die;
    }

    /**
     * Save the vote
     * Return total votes
     */
    public function vote()
    {
        if ($this->request->is(array('ajax'))) {
            $this->loadModel('Projects');
            $this->loadModel('ProjectVotes');
            $userId = $this->Auth->user('id');
            $projectId = $this->request->data['project_id'];
            $action = $this->request->data['action'];
            $query = $this->ProjectVotes->find('all', [
                'conditions' => [
                    'ProjectVotes.project_id' => $projectId,
                    'ProjectVotes.user_id' => $userId,
                ]
            ]);
            //If user has not votes for this project
            if ($query->count() == 0) {
                $projectVote = $this->ProjectVotes->newEntity();
                $this->request->data['user_id'] = $userId;
                $projectVote = $this->ProjectVotes->patchEntity($projectVote, $this->request->data);
                $this->ProjectVotes->save($projectVote);

                $query = $this->ProjectVotes->find('all', [
                    'conditions' => [
                        'ProjectVotes.project_id' => $projectId,
                        'ProjectVotes.action' => $action,
                    ]
                ]);

                $action = $action == 'U' ? 'up' : 'down';
                $project = $this->Projects->get($projectId);
                $totalVotes = $query->count();
                $data[$action . '_vote'] = $totalVotes;
                $project = $this->Projects->patchEntity($project, $data);
                $this->Projects->save($project);

                // Set the vote_added to 1 if there is any up vote
                if ($action == 'up') {
                    $backlog = $this->Backlogs->get($project->backlog_id);
                    $backlog = $this->Backlogs->patchEntity($backlog, ['vote_added' => 1]);
                    $this->Backlogs->save($backlog);
                }
				if ($action == 'down') {
                    $backlog = $this->Backlogs->get($project->backlog_id);
                    $backlog = $this->Backlogs->patchEntity($backlog, ['vote_added' => 1]);
                    $this->Backlogs->save($backlog);
                }
                echo $totalVotes;
            } else 
			{
				echo 'NA';
			}	
        }
        die;
    }

}
