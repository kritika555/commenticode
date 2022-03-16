<?php
   namespace app\Controller;
   use Cake\Mailer\Email;
   use Cake\Datasource\ConnectionManager;
   use App\Controller\AppController;
   use Cake\ORM\TableRegistry;
   use Cake\Core\Configure;
   use Cake\Utility\Security;
   
   class PaymentController extends AppController {
    
	public function testCron()
	{
		$testCronTable = TableRegistry::get('TestCron');
		$item = $testCronTable->newEntity();
		$end_date = date('Y-m-d H:i:s');	
		$conn = ConnectionManager::get('default');
		$stmt = $conn->execute("INSERT INTO test_cron(payment_date) VALUES(2045-03-87)"); 
	}

	public function test()
    {		
		$this->set('data', 'test');
    }		
		
	public function payWinnersWeekly()
	{        
		// transfer coins to user accounts between last seven days check highest 3 votes for each backlog
		$this->loadModel('ProjectVotes');		
		$end_date = date('Y-m-d H:i:s');		
		$start_date = date('Y-m-d H:i:s', strtotime('-7 day', strtotime($end_date)));
		
		$conn = ConnectionManager::get('default');
		$stmt = $conn->execute("SELECT DISTINCT projects.backlog_id,backlogs.amount FROM project_votes JOIN projects ON project_votes.project_id=projects.id JOIN backlogs ON projects.backlog_id = backlogs.id WHERE project_votes.action='U' AND project_votes.created>='".$start_date. "' AND project_votes.created<='".$end_date. "' GROUP BY project_votes.project_id ORDER BY projects.backlog_id DESC");
		$backlogs_list = $stmt ->fetchAll('assoc');
				$email = new Email();
				//$email->setViewVars(['value' => 12345]);
				$email
					->template('payment_weekly', 'default')
					->emailFormat('html')
					->viewVars(['value' => 12345])
					->to('commenticode@gmail.com')
					->from('app@domain.com')
					->send();				
		echo'<html>';
        echo '<head>';
        echo '<style>
#customers {
  font-family: Arial, Helvetica, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

#customers td, #customers th {
  border: 1px solid #ddd;
  padding: 8px;
}

#customers tr:nth-child(even){background-color: #f2f2f2;}

#customers tr:hover {background-color: #ddd;}

#customers th {
  padding-top: 12px;
  padding-bottom: 12px;
  text-align: left;
  background-color: #B0C4DE;
  color: white;
}
</style>';
echo '</head>';
echo '<body>';
	echo '<h1 id="customers"> Commenticode Weekly Winning projects<h1>';
	echo '<h3 id="customers">
		From:' .$start_date .'<br>'.
		'To:'.$end_date.'</br>
		
	</h3>
	<table id="customers">
	<tr>
	<th>Backlog</th>
	<th>Allocated amount</th>
	<th>Winner 1</th>
	<th>Winner 2</th>
	<th>Winner 3</th>			
	</tr>';       
     
		/* STARTING of LOOP */		
		foreach($backlogs_list as $key=>$block)
		{
			$main_backlog_id = $block['backlog_id'];

			$conn = ConnectionManager::get('default');
			$stmt = $conn->execute("SELECT project_id,COUNT(*) as total_upvotes,project_votes.user_id,project_votes.created,projects.name as project_name ,projects.created_by_id as created_by_id,projects.backlog_id,backlogs.title as backlog_title FROM project_votes JOIN projects ON project_votes.project_id=projects.id JOIN backlogs ON projects.backlog_id = backlogs.id WHERE project_votes.action='U' AND project_votes.created>='".$start_date. "' AND project_votes.created<='".$end_date. "' AND projects.backlog_id=".$main_backlog_id . " GROUP BY project_votes.project_id ORDER BY projects.backlog_id,total_upvotes DESC");
			
			$results = $stmt ->fetchAll('assoc');	
						
			$winner1 = array();
			$winner2_3 = array();
			$winner2 = array();
			$winner3 = array();
			$winning_vote1 = $results[0]['total_upvotes'];			
								
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
	 
		if(!empty($winner2_3)){
		$winningvote2 = $winner2_3[0]['total_upvotes'];		
			foreach($winner2_3 as $key=>$item)
			{			
				if($item['total_upvotes']<>$winningvote2 && $item['total_upvotes']<$winningvote2)
				{					
					array_push($winner3,$winner2_3[$key]);
					unset($winner2_3[$key]);					
				}	
			}			
			
        }	

		echo '<tr>';
		 echo  '<td>';
		 echo $item['backlog_title'];
		 echo '</td>';
		  echo '<td>';
		  echo $block['amount'];
		  echo '</td>';
		  echo '<td>';
		  echo '<table>';

					$count = count($winner1); 
					if($count!=0)
					
					echo '<tr>';
					echo '<td>Project name</td>';
					echo '<td>Backlog title</td>';
					echo '<td>Total upvotes </td>';
					echo '<td>Created by id</td>';
					echo '<td>Coins</td>';
					
							$arr = $count-1;
							for($i=0;$i<=$arr;$i++)
							{
									         
				     echo '</tr>';
					echo '<tr>';
								echo '<td>' . $winner1[$i]['project_name'] .'</td>';
								echo '<td>' . $winner1[$i]['backlog_title'] . '</td>';
								echo '<td>' . $winner1[$i]['total_upvotes'] . '</td>';
								echo '<td>' . $winner1[$i]['created_by_id'] . '</td>';
								echo '<td></td>';
							echo '</tr>';		   	
							}
							
		echo '</table>';		   
		echo '</td>';
		echo '<td>';		   	   
		echo '<table>';
					
					 $count = count($winner2_3); 
					 if($count!=0){ 
				echo '<tr>
					<td>Project name</td>
					<td>Backlog title</td>
					<td>Total upvotes </td>
					<td>Created by id</td>
				 </tr>';						 
					 }	 
					 $arr = $count-1;
					 for($i=0;$i<=$arr;$i++)
					{						
					
						echo '<tr>';
						echo '<td>' . $winner2_3[$i]['project_name'] .'</td>';
						echo '<td>' . $winner2_3[$i]['backlog_title'] . '</td>';
						echo '<td>' . $winner2_3[$i]['total_upvotes'] .'</td>';
						echo '<td>' . $winner2_3[$i]['created_by_id'] .'</td>';
						echo '<td></td>';
						echo '</tr>';		   	
						}	
									
		echo '</table>	
		   		   
		   </td>	
		   <td>
		<table>';
	  
	
		if(!empty($winner3)){
		$winningvote3 = $winner3[0]['total_upvotes'];		
			foreach($winner3 as $key=>$item)
			{			
				if($item['total_upvotes']<>$winningvote3 && $item['total_upvotes']<$winningvote3)
				{		
					unset($winner3[$key]);
					
				}	
			}			
			
        }	
					$count = count($winner3); 
					$arr = $count-1;
					for($i=0;$i<=$arr;$i++)
					{
		     	echo '<tr>
					<td>Project Name</td>
					<td>Backlog Title</td>
					<td>Total Upvotes </td>
					<td>Created by id</td>
					<td>Coins</td>
				 </tr>
							<tr>';
								echo '<td>'.$winner3[$i]['project_name'].'</td>';
								echo '<td>'.$winner3[$i]['backlog_title'].'</td>';
								echo '<td>' . $winner3[$i]['total_upvotes'] . '</td>';
								echo '<td>' . $winner3[$i]['created_by_id'] . '</td>';
								echo '<td></td>';
								
							echo '</tr>';		   	
						}					
		echo '</table>';	   
		echo '</td>';
		echo '</tr>';
		echo '</table>';   	
	 
	 
		/*PAYMENT process*/		
		$this->loadModel('Percentage');
		$lastCreatedPercentage = $this->Percentage->find('all', array('order' => array('Percentage.id' =>'desc')))->first()->toArray();
				
		$winner1_percentage = $lastCreatedPercentage['winner1'];
		$winner2_percentage = $lastCreatedPercentage['winner2'];
		$winner3_percentage = $lastCreatedPercentage['winner3'];
		
		$initial_supply = Configure::read('InitialSupply');
		$winner1_count = count($winner1);
		$winner2_count = count($winner2_3);
		$winner3_count = count($winner3);								

		foreach($winner1 as $item)
		{		
			$this->loadModel('Users');
			$backlog_id = $item['backlog_id'];
			$user_id = $item['created_by_id'];
			$backlog = $this->loadModel('Backlogs')->get($backlog_id);
			$allocated_coin_backlog = $backlog->amount;
			$this->loadModel('Percentage');
			
		    $backlog = $this->loadModel('Backlogs')->get($backlog_id);
			$query = $this->Backlogs->find('all') ->where(['id IN' => $backlog_id]);
			
			$calculated_coins_winner1 = ($winner1_percentage/100)*$allocated_coin_backlog;
			
			$calculated_coins_winner1 = $calculated_coins_winner1/$winner1_count;
			
			$user = $this->loadModel('Users')->get($user_id);
			$coin_balance = $user->coin_balance+$calculated_coins_winner1;
			$notification_message = 'You have earned ' . $calculated_coins_winner1 . ' as first prize reward for highest voted project.';
			
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
					
			$tablename1 = TableRegistry::get("Notifications");
			$notification = $tablename1->newEntity();
			$notification->message = $notification_message;
			
			$notification->read_flag = 0;
			$notification->project_name =$item['project_name'];
			$notification->backlog_id = $backlog_id;
			$notification->user_id = $user_id;
			$notification->pay_date = date('Y-m-d');
			$notification->amount = $calculated_coins_winner1;

			if ($tablename1->save($notification)) {					
				$id = $notification->id;				
			}            		
		}
		
		foreach($winner2_3 as $item)
		{		
			$this->loadModel('Users');
			$backlog_id = $item['backlog_id'];
			$user_id = $item['created_by_id'];
			$backlog = $this->loadModel('Backlogs')->get($backlog_id);
			$allocated_coin_backlog = $backlog->amount;
			$this->loadModel('Percentage');
			
		    $backlog = $this->loadModel('Backlogs')->get($backlog_id);
			$query = $this->Backlogs->find('all') ->where(['id IN' => $backlog_id]);
			
			$calculated_coins_winner2 = ($winner2_percentage/100)*$allocated_coin_backlog;
			
			$calculated_coins_winner2 = $calculated_coins_winner2/$winner2_count;
			//echo '2nd winner is '. $user_id .' '. $backlog_id .' winner2: ' .$calculated_coins_winner2 . '<br/>';
			$user = $this->loadModel('Users')->get($user_id);
			$coin_balance = $user->coin_balance+$calculated_coins_winner2;
			$notification_message2 = 'You have earned ' . $calculated_coins_winner2 . ' as second prize reward for highest voted project for backlog_id= ' . $backlog_id;
			
			$data = array(
				'Users' => array(				    
					'coin_balance' => $coin_balance,
					'notification_message' => $notification_message2
				)
			);
			
			$tablename = TableRegistry::get("Users");
			$query = $tablename->query();
            $result = $query->update()
                    ->set(['coin_balance' => $coin_balance,'notification_message'=>$notification_message2])
                    ->where(['id' => $user_id])
                    ->execute();
					
			$tablename1 = TableRegistry::get("Notifications");
			$notification = $tablename1->newEntity();
			$notification->message = $notification_message2;
			$notification->read_flag = 0;
			$notification->project_name =$item['project_name'];
			$notification->backlog_id = $backlog_id;
			$notification->user_id = $user_id;
			$notification->amount = $calculated_coins_winner2;
			$notification->pay_date = date('Y-m-d');			
			
			if ($tablename1->save($notification)) {					
				$id = $notification->id;				
			}            
		}
		
		foreach($winner3 as $item)
		{		
			$this->loadModel('Users');
			$backlog_id = $item['backlog_id'];
			$user_id = $item['user_id'];
			$backlog = $this->loadModel('Backlogs')->get($backlog_id);
			$allocated_coin_backlog = $backlog->amount;
			$this->loadModel('Percentage');
			
		    $backlog = $this->loadModel('Backlogs')->get($backlog_id);
			$query = $this->Backlogs->find('all') ->where(['id IN' => $backlog_id]);
			
			$calculated_coins_winner3 = ($winner3_percentage/100)*$allocated_coin_backlog;			
			$calculated_coins_winner3 = $calculated_coins_winner3/$winner3_count;
			//echo $calculated_coins_winner3;
			$user = $this->loadModel('Users')->get($user_id);
			$coin_balance = $user->coin_balance+$calculated_coins_winner3;
			$notification_message3 = 'You have earned ' . $calculated_coins_winner3 . ' as third prize reward for highest voted project for backlog_id= ' . $backlog_id;
			
			$data = array(
				'Users' => array(				    
					'coin_balance' => $coin_balance,
					'notification_message' => $notification_message3
				)
			);
			
			$tablename = TableRegistry::get("Users");
			$query = $tablename->query();
            $result = $query->update()
                    ->set(['coin_balance' => $coin_balance,'notification_message'=>$notification_message3])
                    ->where(['id' => $user_id])
                    ->execute();
					
			$tablename1 = TableRegistry::get("Notifications");
			$notification = $tablename1->newEntity();
			$notification->message = $notification_message3;
			$notification->read_flag = 0;			
			$notification->project_name =$item['project_name'];
			$notification->backlog_id = $backlog_id;
			$notification->user_id = $user_id;
			$notification->amount = $calculated_coins_winner3;
			$notification->pay_date = date('Y-m-d');		
			
			if ($tablename1->save($notification)) {
					
				$id = $notification->id;				
			}          		
		}
		}  
    
        	
	
	 
   

echo '</body>';
echo '</html>';
}
}
