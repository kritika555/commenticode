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

$cakeDescription = $siteTitle;
?>
<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?= $cakeDescription ?>:
        <?= $this->fetch('title') ?>
    </title>
    <?= $this->Html->meta('icon') ?>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <?= $this->Html->css('font-awesome/css/font-awesome.min') ?>
    <?= $this->Html->css('bootstrap.min') ?>
    <?= $this->Html->css('sb-admin') ?>
    <?= $this->Html->css('custom_admin') ?>
    <?= $this->Html->css('HoldOn.min') ?>

    <script type="text/javascript">
        var siteUrl = '<?=$this->Url->build('/', true); ?>';
    </script>
    <?= $this->Html->script('jquery'); ?>
    <?= $this->Html->script('validations/jquery.validate.min'); ?>
    <?= $this->Html->script('validations/additional-methods.min'); ?>
    <?= $this->Html->script('bootstrap.min'); ?>
    <?= $this->Html->script('custom_admin'); ?>
    <?= $this->Html->script('common'); ?>
    <?= $this->Html->script('HoldOn.min'); ?>

    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>
	  
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-star-rating/4.0.2/css/star-rating.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-star-rating/4.0.2/js/star-rating.min.js"></script>
</head>
<body>
<?php
$controller = $this->request->params['controller'];
$action = $this->request->params['action'];
$add = isset($this->request->params['pass'][0]) ? false : true;
?>
<div id="wrapper">
        <!-- Navigation -->
        <nav class="navbar navbar-inverse navbar-fixed-top text-center" role="navigation">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="<?php echo $this->Url->build(["controller" => "Users", "action" => "login", "prefix"=>'admin']); ?>">Commenticode<?php echo $this->Html->image('branding/logo.png', ['alt' => $cakeDescription, 'class' => 'logo']);?></a>
            </div>.
            <span class="admin-heading">Administration</span>
            <!-- Top Menu Items -->
            <ul class="nav navbar-right top-nav mob-right">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> Hello <?= $authUser['first_name']?> <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li>
                            <?= $this->Html->link(__("<i class=\"fa fa-fw fa-gear\"></i> Profile"), ['controller' => 'users', 'action' => 'edit-profile'], ['escape' => false]) ?>
                        </li>
                       <li>
                            <?= $this->Html->link(__("<i class=\"fa fa-fw fa-gear\"></i> Change Password"), ['controller' => 'users', 'action' => 'change-password'], ['escape' => false]) ?>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <?= $this->Html->link(__("<i class=\"fa fa-fw fa-power-off\"></i> Log Out"), ['controller' => 'users', 'action' => 'logout'], ['escape' => false]) ?>
                        </li>
                    </ul>
                </li>
            </ul>
            <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
            <div class="collapse navbar-collapse navbar-ex1-collapse">
                <ul id="main-nav" class="nav navbar-nav side-nav">
                    <li class="navbar-item <?php if($controller == 'Backlogs'){ echo 'active';}?>">
                        <?= $this->Html->link(__("<i class=\"fa fa-fw fa-file   \"></i> Backlogs <i class=\"fa fa-fw fa-caret-down\"></i>"), ['controller' => 'backlogs', 'action' => 'index'], ['data-toggle'=>'collapse', 'data-target'=>"#backlog", 'escape' => false, 'onclick'=>'return false']) ?>

                        <ul id="backlog" class="<?php if($controller != 'Backlogs'){ echo 'collapse';}?> sub-menu">
                            <li <?php if($controller == 'Backlogs' && $action == 'index' && ($this->request->query('status') != 'P')){ echo 'class="active"';}?>><?= $this->Html->link(__('All Backlogs'), ['controller' => 'backlogs', 'action' => 'index']) ?></li>
                            <li <?php if($add && $controller == 'Backlogs' && $action == 'addEdit'){ echo 'class="active"';}?>><?= $this->Html->link(__('Add Backlog'), ['controller' => 'backlogs', 'action' => 'addEdit']) ?></li>
                            <li <?php if($controller == 'Backlogs' && $action == 'index' && $this->request->query('status') == 'P'){ echo 'class="active"';}?>><?= $this->Html->link(__('Pending Approvals'), ['controller' => 'backlogs', 'action' => 'index', '?'=>['status'=>'P']]) ?></li>
                            <li <?php if($add && $controller == 'Backlogs' && $action == 'projects'){ echo 'class="active"';}?>><?= $this->Html->link(__('Projects'), ['controller' => 'backlogs', 'action' => 'projects']) ?></li>
                        </ul>
                    </li>

                    <li class="navbar-item <?php if($controller == 'Users'){ echo 'active';}?>">
                        <?= $this->Html->link(__("<i class=\"fa fa-fw fa-file   \"></i> Users <i class=\"fa fa-fw fa-caret-down\"></i>"), ['controller' => 'users', 'action' => 'index'], ['data-toggle'=>'collapse', 'data-target'=>"#user", 'escape' => false, 'onclick'=>'return false']) ?>

                        <ul id="user" class="<?php if($controller != 'Users'){ echo 'collapse';}?> sub-menu">
                            <li <?php if($controller == 'Users' && $action == 'index'){ echo 'class="active"';}?>><?= $this->Html->link(__('All Users'), ['controller' => 'users', 'action' => 'index']) ?></li>
                            <?php /*<li <?php if($add && $controller == 'Users' && $action == 'addEdit'){ echo 'class="active"';}?>><?= $this->Html->link(__('Add User'), ['controller' => 'users', 'action' => 'addEdit']) ?></li>*/?>
                            <li <?php if($controller == 'Users' && $action == 'account'){ echo 'class="active"';}?>><?= $this->Html->link(__('Account'), ['controller' => 'users', 'action' => 'account']) ?></li>
                            <li <?php if($controller == 'Users' && $action == 'transfer'){ echo 'class="active"';}?>><?= $this->Html->link(__('Transfer'), ['controller' => 'users', 'action' => 'transfer']) ?></li>
                           <!-- <li <?php if($controller == 'Users' && $action == 'percentage'){ echo 'class="active"';}?>><?= $this->Html->link(__('Percentage'), ['controller' => 'users', 'action' => 'percentage']) ?></li>-->
                            <!-- li <?php if($controller == 'Users' && $action == 'minting'){ echo 'class="active"';}?>><?= $this->Html->link(__('Minting'), ['controller' => 'users', 'action' => 'minting']) ?></li -->
                            <li <?php if($controller == 'Users' && $action == 'percentagew'){ echo 'class="active"';}?>><?= $this->Html->link(__('Percentage'), ['controller' => 'users', 'action' => 'percentagew']) ?></li>
							<li <?php if($controller == 'Users' && $action == 'coins'){ echo 'class="active"';}?>><?= $this->Html->link(__('Coins'), ['controller' => 'users', 'action' => 'coins']) ?></li>
							<li <?php if($controller == 'Users' && $action == 'payment' && (!isset($_GET['status']) || $_GET['status'] != 0)){ echo 'class="active"';}?>><?= $this->Html->link(__('Payment'), ['controller' => 'users', 'action' => 'payment']) ?></li>
							
							<li <?php if($controller == 'Users' && $action == 'transactions' && (!isset($_GET['status']) || $_GET['status'] != 0)){ echo 'class="active"';}?>><?= $this->Html->link(__('Transactions'), ['controller' => 'users', 'action' => 'transactions']) ?></li>
                            <li <?php if($controller == 'Users' && $action == 'transactions' && isset($_GET['status']) && $_GET['status'] == 0){ echo 'class="active"';}?>><?= $this->Html->link(__('Failure Transactions ('.$failedTransactionsCount.')'), ['controller' => 'users', 'action' => 'transactions', 'status'=>0]) ?></li>
                        </ul>
                    </li>

                    <li class="navbar-item <?php if($controller == 'Configurations'){ echo 'active';}?>">
                        <?= $this->Html->link(__("<i class=\"fa fa-fw fa-cog   \"></i> Settings <i class=\"fa fa-fw \"></i>"), ['controller' => 'Configurations', 'action' => 'index'], ['escape' => false]) ?>
                    </li>
					
					<li class="navbar-item <?php if($controller == 'Feedback'){ echo 'active';}?>">
                        <?= $this->Html->link(__("<i class=\"fa fa-fw fa-rss   \"></i> Feedback <i class=\"fa fa-fw \"></i>"), ['controller' => 'Feedback', 'action' => 'index'], ['escape' => false]) ?>
                    </li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </nav>

        <div id="page-wrapper">

            <div class="container-fluid">
				<?= $this->Flash->render() ?>
				<?= $this->fetch('content') ?>
			</div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Alert</h4>
            </div>
            <div class="modal-body">
                <p id="jsModalText"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">OK</button>
            </div>
        </div>
    </div>
</div>


<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
</body>
</html>
