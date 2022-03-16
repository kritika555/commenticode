Hi <?php echo (isset($user['first_name']) && $user['first_name'] !='') ? $user['first_name'] : 'There'  ?>,

Please <?php echo $this->Html->link('click here', ['controller'=>'Users','action'=>'reset_password',$token,'_full' => true]); ?>
 to reset your password.

<?php echo $this->element('email_signature');?>
