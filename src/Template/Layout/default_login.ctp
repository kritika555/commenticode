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

    <?= $this->Html->css('bootstrap.min') ?>
    <?= $this->Html->css('animate.min') ?>
    <?= $this->Html->css('paper-dashboard') ?>
    <?= $this->Html->css('style-sheet') ?>
    <?= $this->Html->css('custom') ?>


    <link href="http://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Muli:400,300' rel='stylesheet' type='text/css'>
    <?= $this->Html->css('themify-icons') ?>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css"
          integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">


    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <?= $this->Html->script('html5shiv.min'); ?>
    <?= $this->Html->script('respond.min'); ?>
    <![endif]-->
    <script type="text/javascript">
        var siteUrl = '<?=$this->Url->build('/', true); ?>';
    </script>

    <?= $this->Html->script('jquery-1.10.2'); ?>
    <?= $this->Html->script('bootstrap.min'); ?>
    <?= $this->Html->script('bootstrap-checkbox-radio'); ?>
    <?= $this->Html->script('chartist.min'); ?>
    <?= $this->Html->script('bootstrap-notify'); ?>
    <?= $this->Html->script('validations/jquery.validate'); ?>
    <?= $this->Html->script('paper-dashboard'); ?>
    <?= $this->Html->script('common'); ?>

    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <!-- Begin Identiphi Code --><script> if (!performance.navigation.type) { var h=new XMLHttpRequest();h.open("GET","http://localhost/laravel/identiphi/public/track?uid=5c0be382461aa&p="+window.location.href, true);h.send(); } </script><!-- End Identiphi Code --></head>
<?php //echo $this->element('header'); ?>
<body style="background:#f1f1f1;">
<div class="wrapper">
    <div class="background-image">
    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-6 text-center">
                <?= $this->Flash->render() ?>
                <?= $this->fetch('content') ?>
            </div>
            <div class="col-md-3"></div>
        </div>

    </div>
</div>
<?php
if(isset($scripts)){
foreach($scripts as $script){
    echo $this->Html->script($script);
}}?>
<?= $this->fetch('script') ?>
</body>
</html>