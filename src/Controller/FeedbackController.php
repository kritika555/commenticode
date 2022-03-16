<?php
   namespace App\Controller;
   use App\Controller\AppController;
   class FeedbackController extends AppController{
      public function feedbackWrite(){
		 $feedback = $this->Feedback->newEntity();
		 $user_id = $this->Auth->user('id');

		if ($this->request->is('post')) {
            $feedback = $this->Feedback->patchEntity($feedback, $this->request->data); 
          
            if ($this->Feedback->save($feedback)) {
                $this->Flash->success(__('Thank you.Your feedback has been saved.'));
                return $this->redirect(['controller'=>'Backlogs','action' => 'index']);
            }
            $this->Flash->error(__('Unable to add your feedback.'));
        }
     $this->set('feedback',$feedback);
		 $this->set('user_id', $user_id);

      }	
	 
   }
?>