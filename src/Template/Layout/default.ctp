<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @since         0.10.0
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
use Cake\ORM\TableRegistry;
$cakeDescription = $siteTitle;

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <title>
        <?= $cakeDescription ?>:
        <?= $this->fetch('title') ?>
    </title>
    <?= $this->Html->meta('icon') ?>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <?= $this->Html->css('bootstrap.min') ?>
    <?= $this->Html->css('animate.min') ?>
    <?= $this->Html->css('paper-dashboard') ?>
    <?= $this->Html->css('style-sheet') ?>
    <?= $this->Html->css('demo') ?>
    <?= $this->Html->css('custom') ?>
	<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-star-rating/4.0.2/css/star-rating.min.css" rel="stylesheet" />
   <link href="http://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Muli:400,300' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css"
          integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
   
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-star-rating/4.0.2/js/star-rating.min.js"></script>
    <?= $this->Html->css('themify-icons') ?>
  
    <script type="text/javascript">
        var siteUrl = '<?=$this->Url->build('/', true); ?>';
		
    </script>
    <?= $this->Html->script('jquery-1.10.2'); ?>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <?= $this->Html->script('validations/jquery.validate.min'); ?>
    <?= $this->Html->script('validations/additional-methods.min'); ?>
    <?= $this->Html->script('common'); ?>
    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.js"></script>   
   
</head>
<style>

</style
<?php //echo $this->element('header');
$controller = $this->request->params['controller'];
$action = $this->request->params['action'];

$tablename = TableRegistry::get("Notifications");
			$query = $tablename->query()->where(['user_id'=>$user_id]);
            $notification_count=0; 
			foreach ($query as $notification) {
			if($notification->read_flag==0)
				{
					$notification_count++;
				}	
			}
			
$user = TableRegistry::get("Users");
$query2 = $user->query()->where(['id'=>$user_id]);			
$coin_balance = 0;
	foreach($query2 as $meuser)
	{
			$coin_balance = $meuser->coin_balance;	
			$img_name = $meuser->img_path;	
	}

$img_location  = $_SERVER['SERVER_NAME'] . '/users/profile_photos/';
if($notification_count>0)
{
	$msg= "You have got notifications";
} else
{
	$msg =" You have no notification";
}
if($coin_balance>0)
{
    $coin_tooltip = " You have earnings";
} else
{
    $coin_tooltip = " ";
}
?>

<body>
<div class="wrapper">
    <div class="sidebar" data-background-color="white" data-active-color="danger">
        <div class="sidebar-wrapper" style="overflow:auto;">
            <div class="logo">
                <?php echo $this->Html->link('<p><img src="/img/demo_logo.png" width="70" height="70"></p>', ['controller' => 'backlogs', 'action' => 'index'], array('class' => 'simple-text', 'escape' => false)); ?>
			</div>
            <ul class="nav">
                <li class="<?php if($controller == 'Backlogs' && $action=='index'){ echo 'active';}?>">
                    <?php echo $this->Html->link('<i class="fas fa-home"></i><p>Backlogs</p>', ['controller' => 'backlogs', 'action' => 'index'], array('class' => 'help-text color-green', 'escape' => false)); ?>
                </li>
				<li class="<?php if($controller == 'Backlogs' &&$action=='projects'){ echo 'active';}?>"><?php echo $this->Html->link('<i class="fas fa-home"></i><p>Projects</p>', ['controller' => 'backlogs', 'action' => 'projects'], array('class' => 'help-text color-green', 'escape' => false)); ?>
				</li>
                <li class="<?php if($controller == 'Activities'){ echo 'active';}?>">
                    <?php echo $this->Html->link('<i class="far fa-folder-open"></i><p>Activity</p>', ['controller' => 'activities', 'action' => 'index'], array('class' => 'help-text color-green', 'escape' => false)); ?>
                </li>
                
				<li class="<?php if($controller == 'Feedback' && ($action == 'feedbackWrite')){ echo 'active';}?>">
                    <?php echo $this->Html->link('<i class="fas fa-rss-square"></i><p>Feedback</p>', ['controller' => 'feedback', 'action' => 'feedbackWrite'], array('class' => 'help-text color-green', 'escape' => false)); ?>
				</li>

                <li class="<?php if($controller == 'Users' && ($action == 'account')){ echo 'active';}?>">

                    <?php echo $this->Html->link('<i class="far fa-user-circle"></i><p>Account</p>', ['controller' => 'users', 'action' => 'account'], array('class' => 'help-text color-green', 'escape' => false)); ?>
                </li>

                <li class="<?php if($controller == 'Users' && ($action == 'editProfile')){ echo 'active';}?>">

                    <?php echo $this->Html->link('<i class="ti-settings"></i><p>Settings</p>', ['controller' => 'users', 'action' => 'editProfile'], array('class' => 'help-text color-green', 'escape' => false)); ?>
                </li>

                <li class="active">
                    <?php echo $this->Html->link('<i class="fas fa-exclamation-circle"></i><p>Logout</p>', ['controller' => 'users', 'action' => 'logout'], array('class' => 'help-text color-green', 'escape' => false)); ?>
                </li>
            </ul>
        </div>
    </div>

    <div class="main-panel">
       
		<nav id="header_bar" class="navbar navbar-light bg-light">
  <!-- Navbar content -->
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle">
                        <span class="sr-only">Toggle navigation</span>                       
                        <span class="icon-bar bar2"></span>
                        <span class="icon-bar bar3"></span>
                    </button>                    
			       <a class="navbar-brand" href="javascript: void(0);" onclick="window.location.reload()"><i class="orange fas fa-refresh refresh"></i></a>
              	   <a class="navbar-brand" href="/about">Dashboard</a>
				   
  				   

				  <?php 

					echo $this->Html->link('<i class="fas fa-envelope fa-2x"></i>
					Notifications <span class="badge badge-light">' . $notification_count .'</span>',['controller' => 'notifications', 'action' => 'index'], array('class' => 'btn btn-blue','escape'=>false,'data-toggle'=>'tooltip','data-placement'=>'bottom','title'=>$msg,'style'=>'background-color:#fff;color:#000;')); ?>


				  <?php echo $this->Html->link('<i class="fas fa-hand-holding-usd fa-2x"></i>
					Coins <span class="badge badge-light">'. number_format($coin_balance) .'</span>',['controller'=>'', 'action'=>''], array('class' => 'btn btn-blue','escape'=>false,'style'=>'background-color:#fff;color:#000;','data-toggle'=>'tooltip','data-placement'=>'bottom','title'=>$coin_tooltip));?>
</div>
                <div class="collapse navbar-collapse">
                    <ul class="nav navbar-nav navbar-right">
                        <li>
                            <?php echo $this->Html->link("<p><img src="."/users/profile_photos/" . $img_name .' width="25" height="25"> '.$authUser['username'].'</p>', ['controller' => 'users', 'action' => 'editProfile'], array('class' => 'btn btn-blue navbar-brand', 'escape' => false,'style'=>'background-color:#fff;color:#000;','data-toggle'=>'tooltip','data-placement'=>'bottom','title'=>'Edit your Profile')); ?>
                       </li>
                   </ul>
                </div>
            
		</nav>
        <div class="content">
		
            <div class="container-fluid">
                <?= $this->Flash->render() ?>
                <?= $this->fetch('content') ?>
            </div><!---end panel-->
            
        </div><!--end main panel-->
		<div class="navbar-footer">
                <div class="container-fluid">
                    <div class="row">
                         <div class="col-lg-2 text-left"><a href="#">Terms & Conditions</a></div>
                        <div class="col-lg-2 text-center"><a href="#">Privacy Policy</a></div>
                        <div class="col-lg-2 text-center"><a href="#">Help & Support</a></div>
                        <div class="col-lg-2 text-right"><a href="#">&copy; Commenticode 2020</a></div>
                    </div>
                </div>
		</div>
    </div><!---end wrapper-->
	



<!-- Modal 

<div id="taskModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-sm">

        <form id="taskForm" onsubmit="return false">
        <!-- Modal content-->
       <!-- <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Add Task</h4>
            </div>
            <div class="modal-body">
                <textarea name="task" class="txtarea" id="jsProjectTask" required="required"></textarea>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success" id="jsAddTask">Add</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
        </form>
    </div>
</div> -->
<!-- End Modal -->

<!-- winnersModal -->
<div class="modal fade in" id="winnersModal" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">×</button>
                <h4 class="modal-title padding-modal-title heading-new">Winners</h4>
            </div>
            <div class="modal-body" id="jsWinnersContent"></div>
        </div>
    </div>
</div>
<!-- End winnersModal -->
<!-- voteModal -->
<div class="modal fade in" id="voteModal" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">×</button>
                <h4 class="modal-title padding-modal-title heading-new">Vote</h4>
            </div>
            <div class="modal-body" id="jsVoteContent"></div>
			<div class="modal-footer">
               
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- End voteModal -->
<?php if(isset($userRole) && $userRole != 'A'){ ?>
<!-- winnersModal -->
<div class="modal fade in" id="backlogsLeftModal" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">×</button>
                <h4 class="modal-title padding-modal-title heading-new">Notice</h4>
            </div>
            <div class="modal-body">You can add <?php echo isset($totalUserBacklogLeft) ? $totalUserBacklogLeft : '0';?> more backlog.</div>
            <div class="modal-footer">
                <?php echo $this->Html->link('OK', ['controller' => 'backlogs', 'action' => 'addEdit'], array('class' => 'btn btn-success', 'title' => '', 'escape' => false)); ?>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- End winnersModal -->
<?php } ?>


<?= $this->Html->script('bootstrap.min'); ?>
<?= $this->Html->script('bootstrap-checkbox-radio'); ?>
<?= $this->Html->script('chartist.min'); ?>
<?= $this->Html->script('bootstrap-notify'); ?>
<?= $this->Html->script('paper-dashboard'); ?>
<?php
if(isset($scripts)) {
    foreach ($scripts as $script) {
        echo $this->Html->script($script);
    }
}?>
<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
<?= $this->Html->script('html5shiv.min'); ?>
<?= $this->Html->script('respond.min'); ?>
<![endif]-->
<?= $this->fetch('script') ?>

</body>
<script>
$(function () {
  $('[data-toggle="tooltip"]').tooltip()
})
</script>

</html>