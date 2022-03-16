<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Pages Controller
 *
 * @property \App\Model\Table\PagesTable $Pages
 */
class ActivitiesController extends AppController
{
    /**
     * Projects method
     * @param string $type
     */
    public function index($type='projects')
    {				
        $this->loadModel('Projects');
        $userId = $this->Auth->user('id');
		$user_id = $this->Auth->user('id');
        $conditions = $votes = [];
        if($type == 'comments'){
            $this->loadModel('ProjectComments');
            $projectIds = $this->ProjectComments->find('list', [
                'keyField' => 'id',
                'valueField' => 'project_id'
            ])->where(['user_id'=>$userId])
                ->toArray();
            $conditions['Projects.id IN '] = $projectIds ? $projectIds : [-1];
        }elseif($type == 'votes'){
            $this->loadModel('ProjectVotes');			
			
            $votes = $this->ProjectVotes->find('list', [
                'keyField' => 'project_id',
                'valueField' => 'action'
            ])->where(['user_id'=>$userId])
                ->toArray();
            $conditions['Projects.id IN '] = $votes ? array_keys($votes) : [-1];
        }else {
            $conditions['Projects.created_by_id'] = $userId;
        }

        if(isset($this->request->query['title']) && $this->request->query['title'] !=''){
            $conditions['Projects.name LIKE'] = '%'.$this->request->query['title'].'%';
        }
        $query = $this->Projects->find('all', ['contain'=>['Backlogs', 'Users'], 'order'=>['Projects.status', 'Projects.created'=>'desc']])->where($conditions);
        $this->setDefaultOrdering($query, $this->Projects->alias());
        $data = $this->paginate($query);

        $this->request->session()->write('Back.projectView', 'activities');
        $this->set(compact('data', 'type', 'votes', 'userId'));
		$this->set('user_id', $user_id);
        $this->set('_serialize', ['data']);
    }

    public function pendingBacklog()
    {
        $this->loadModel('Backlogs');
        $userId = $this->Auth->user('id');
        $conditions = $votes = [];

        $conditions['Backlogs.created_by_id'] = $userId;
        $conditions['Backlogs.status'] = 'P';

        if(isset($this->request->query['title']) && $this->request->query['title'] !=''){
            $conditions['Backlogs.title LIKE'] = '%'.$this->request->query['title'].'%';
        }
        $query = $this->Backlogs->find('all', ['order'=>['Backlogs.created'=>'desc']])->where($conditions);
        $this->setDefaultOrdering($query, $this->Backlogs->alias());
        $data = $this->paginate($query);

        $this->set(compact('data', 'type', 'votes', 'userId'));
        $this->set('_serialize', ['data']);
    }


    /**
     * Comments
     */
    public function comments()
    {
        $this->loadModel('Projects');
        $conditions = [];
        $conditions['Projects.created_by_id'] = $this->Auth->user('id');

        if(isset($this->request->query['title']) && $this->request->query['title'] !=''){
            $conditions['Projects.name LIKE'] = '%'.$this->request->query['title'].'%';
        }
        $query = $this->Projects->find('all', ['contain'=>['Users', 'Backlogs'], 'order'=>['Projects.status', 'Projects.created'=>'desc']])->where($conditions);
        $this->setDefaultOrdering($query, $this->Projects->alias());
        $data = $this->paginate($query);
//        prd($data);
        $this->set(compact('data', 'backlogId', 'backlog'));
        $this->set('_serialize', ['data']);
    }

    /**
     * Votes
     */
    public function votes()
    {
        $this->loadModel('Projects');
        $conditions = [];
        $conditions['Projects.created_by_id'] = $this->Auth->user('id');

        if(isset($this->request->query['title']) && $this->request->query['title'] !=''){
            $conditions['Projects.name LIKE'] = '%'.$this->request->query['title'].'%';
        }
        $query = $this->Projects->find('all', ['contain'=>['Users', 'Backlogs'], 'order'=>['Projects.status', 'Projects.created'=>'desc']])->where($conditions);
        $this->setDefaultOrdering($query, $this->Projects->alias());
        $data = $this->paginate($query);
//        prd($data);
        $this->set(compact('data', 'backlogId', 'backlog'));
        $this->set('_serialize', ['data']);
    }

}
