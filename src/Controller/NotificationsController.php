<?php
   namespace App\Controller;
   use App\Controller\AppController;
    use Cake\ORM\TableRegistry;
	use Cake\Datasource\ConnectionManager;
   class NotificationsController extends AppController{
      
   public function index()
   { 
	 $user_id = $this->Auth->user('id');
	 $conn = ConnectionManager::get('default');
	 $stmt = $conn->execute('SELECT * FROM notifications WHERE user_id='.$user_id /*. ' AND ' /*"read_flag='0'" . */ .' ORDER BY id DESC');
	 $notifications_list = $stmt ->fetchAll('assoc');

 //update read flag
	$tablename = TableRegistry::get("Notifications");
			$query = $tablename->query();
            $result = $query->update()
                    ->set(['read_flag' =>1])
                    ->where(['user_id' => $user_id])
                    ->execute();
	 
	 $this->loadModel('Backlogs'); 
       $query = $this->Backlogs->find('list', [
        'keyField' => 'id',
        'valueField' => 'title'
        ]);
        $backlogs = $query->toArray();
	 $this->set('backlogs_list',$backlogs);
	 $this->set('user_id',$user_id);
     $this->set('notifications_list',$notifications_list);	   
   }
	
	public function countCoins()
	{
		$userId = $this->Auth->user('id');
		$this->loadModel('Users');
		//new balance for coins kritika
			$coins = $this->Users->find()
				->select(['id', 'coin_balance'])
				->where(['Users.id'=>$userId])
				->toList();
			
		return $coins[0]['coin_balance'];		
	}	



   
   }
?>