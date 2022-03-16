<?php 

print_r($user['portfolio']);
exit();
?>

<div class="row text-center"><h3 style="font-weight: 600;">Settings</h3></div>
<div class="row">
	 <div class="col-md-2 text-center"></div>
    <div class="col-md-8 text-center">
        <div class="row border tab-set">
            <div class="col-md-4 tabs-btn">
                <?= $this->Html->link('Edit Profile', ['controller' => 'Users', 'action' => 'editProfile'], array('class' => '')) ?>
            </div>
            <div class="col-md-4 tabs-btn">
                <?= $this->Html->link('Change Password', ['controller' => 'Users', 'action' => 'changePassword'], array('class' => '')) ?>
            </div>
			<div class="col-md-4 tabs-btn active-tabs">
                <?= $this->Html->link('Portfolio', ['controller' => 'Users', 'action' => 'changePortfolio'], array('class' => '')) ?>
            </div>
        </div>
		 
        <div class="form-setting text-center">
            <?php echo $this->Form->create($user, ['class' => 'data-form','type'=>'post','enctype' => 'multipart/form-data']); ?>       	
					
						
            <?= $this->Form->end() ?>
        </div>

    </div>
	
			   
   
	       
		   
		   
		   
		   
		   
		   
		   
		   

</div>

