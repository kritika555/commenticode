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

    <?= $this->Html->css('font-awesome/css/font-awesome.min') ?>
    <?= $this->Html->css('bootstrap.min') ?>
    <?= $this->Html->css('sb-admin') ?>
    <?= $this->Html->css('custom_admin') ?>
    <?= $this->Html->script('jquery'); ?>
    <?= $this->Html->script('bootstrap.min'); ?>

    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>
</head>
<body>
<div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-inverse navbar-fixed-top text-center" role="navigation">
            <!-- Brand and toggle get grouped for better mobile display -->
						
            <div class="navbar-header float-left">
                <a href="<?php echo $this->Url->build(["controller" => "Users", "action" => "login", "prefix"=>'admin']); ?>"><!--<?php echo $this->Html->image('branding/logo.png', ['alt' => $cakeDescription, 'class' => 'logo']);?>--></a>
                <span align="center" class="admin-heading admin-loginheading">Commenticode Administration</span>
            </div>
            <!-- Top Menu Items -->

            <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->

            <!-- /.navbar-collapse -->
        </nav>

        <div id="">

            <div class="container-fluid">
				<?= $this->fetch('content') ?>
			</div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->
   
</body>
</html>
