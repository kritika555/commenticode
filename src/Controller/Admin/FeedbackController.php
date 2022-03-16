<?php

namespace App\Controller\Admin;

use App\Controller\AppController;

class FeedbackController extends AppController
{
	public function index()
    {
       $this->loadModel('Users'); 
       $query = $this->Users->find('list', [
        'keyField' => 'id',
        'valueField' => 'username'
        ]);
        $users = $query->toArray();
        $this->set('feedback', $this->Feedback->find('all'),['contain' => ['Users']]); 
        $this->set('user',$users);            
    }
	
	public function view($id = null)
    {
       $this->loadModel('Users'); 
       $query = $this->Users->find('list', [
        'keyField' => 'id',
        'valueField' => 'username'
        ]); 
       $users = $query->toArray();
       $feedback = $this->Feedback->get($id);
       $this->set(compact('feedback','users'));       
    }
	
	 //Delete feedback 
    public function delete($id)
    {
        $this->request->allowMethod(['post', 'delete']);
        $feedback = $this->Feedback->get($id);
        if ($this->Feedback->delete($feedback)) {
            $this->Flash->success(__('The feedback with id: {0} has been deleted.', h($id)));
            return $this->redirect(['action' => 'dashboard','controller'=>'users']);
        }
    }    
	
}

?>