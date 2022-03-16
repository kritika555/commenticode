<?php
   namespace App\Controller;
   use App\Controller\AppController;
   class AboutController extends AppController{
      public function index()
	  {
        $user_id = $this->Auth->user('id');
		$this->loadModel('Percentage');
		$lastCreatedPercentage = $this->Percentage->find('all', array('order' => array('Percentage.id' =>'desc')))->first()->toArray();
				
		$winner1_percentage = $lastCreatedPercentage['winner1'];
		$winner2_percentage = $lastCreatedPercentage['winner2'];
		$winner3_percentage = $lastCreatedPercentage['winner3'];		
		
        $this->set('winner1_percentage',$winner1_percentage);
		$this->set('winner2_percentage',$winner2_percentage);
		$this->set('winner3_percentage',$winner3_percentage);	

		$this->set('user_id',$user_id);
      }	
	 
   }
?>