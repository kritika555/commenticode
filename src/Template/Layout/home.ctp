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
    <?= $this->Html->css('bootstrap-theme.min') ?>
    <?= $this->Html->css('custom') ?>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <?= $this->Html->script('html5shiv.min'); ?>
    <?= $this->Html->script('respond.min'); ?>
    <![endif]-->
    <script type="text/javascript">
        var siteUrl = '<?=$this->Url->build('/', true); ?>';
    </script>

    <?= $this->Html->script('jquery'); ?>
    <?= $this->Html->script('common'); ?>
    <?= $this->Html->script('validations/jquery.validate'); ?>
    <?= $this->Html->script('bootstrap.min'); ?>
	<?= $this->Html->script('home'); ?>
    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>
</head>
<body>

<?php echo $this->element('header'); ?>
<div class="bg-white home-banner-top">
    <?= $this->Flash->render() ?>
     <?= $this->fetch('content') ?>
</div>
<div class="footer">
    <?php echo $this->element('footer'); ?>
</div>
<script type="text/javascript">
    $(document).ready(function () {
		<?php if(isset($stepsCompleted) && $stepsCompleted != ''){ ?>
            CommonFunctions.setMenuItems(<?=$stepsCompleted?>);
        <?php }?>
    });
</script>
</body>
</html>