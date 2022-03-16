<?php


?>

<div class="row text-center"><h3 style="font-weight: 600;">Settings</h3></div>
<div class="row">
	 <div class="col-md-2 text-center"></div>
    <div class="col-md-8 text-center">
        <div class="row border tab-set">
            <div class="col-md-4 tabs-btn active-tabs">
                <?= $this->Html->link('Edit Profile', ['controller' => 'Users', 'action' => 'editProfile'], array('class' => '')) ?>
            </div>
            <div class="col-md-4 tabs-btn">
                <?= $this->Html->link('Change Password', ['controller' => 'Users', 'action' => 'changePassword'], array('class' => '')) ?>
            </div>
			<div class="col-md-4 tabs-btn">
                <?= $this->Html->link('Portfolio', ['controller' => 'Users', 'action' => 'changePortfolio'], array('class' => '')) ?>
            </div>
        </div>
		 
        <div class="form-setting text-center">
            <?php echo $this->Form->create($user, ['class' => 'data-form','type'=>'post','enctype' => 'multipart/form-data']); ?>
            
			
			<div class="modal" id="test" role="dialog">
				   <div class="modal-dialog">
					<div class="modal-content">
							<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal">×</button>
							<h4 class="modal-title padding-modal-title heading-new">Edit profile Picture </h4>
							</div>
							<div class="modal-body">
								<?php
									echo $this->Form->input('profile_photo',['onchange'=>'showMyImage(this)','type'=>'file','id'=>'changed_pic','placeholder'=>'Profile Photo','label'=>'Select Image']);
								?>
								<br/>
								<img id="thumbnil" style="width:40%;margin-top:10px;"  src="" alt="Preview"/>
								<div onclick ="clearPic()" id="clear"><i class="fas fa-trash-alt"></i></div>
												
								
							</div>
							<div class="modal-footer">
							<div onclick="changePic()" class="btn btn-info" id="confirm">Edit</div>
							<?php //echo $this->Html->link('Change', ['controller' => '', 'action' => ''], array('class' => 'btn btn-success', 'title' => '', 'escape' => false)); ?>
							<!--<button type="button" class="btn btn-default" data-dismiss="modal">OK</button>-->
							</div>
					</div>
						 <div class="col-md-2 text-center"></div>
					</div>
</div>
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			<div class="row">
                <div class="col-md-10">
                    <label class="margin-top-for">Email</label><br>
                    <?=$this->Form->input('email', ['label'=>false, 'placeholder'=>'example@example.com', 'disabled'=>"disabled"])?>
                </div>
                <div class="col-md-2 "></div>
            </div>

            <div class="row">
                <div class="col-md-10">
                    <label class="margin-top-for">UserName</label><br>
                    <?=$this->Form->input('username', ['label'=>false, 'placeholder'=>'UserName', 'disabled'=>"disabled"])?>
                </div>
                <div class="col-md-2 "></div>
            </div>
			
			
			<div class="row">
					<div class="col-md-12">
					 <?php if($user['img_path']){ ?>
							<img id="pp_image" src="<?php echo 'profile_photos/'.$user['img_path']; ?>" alt="Profile image" width="200" height="200">
					 <?php }?>
									
				 <div class="upload" data-toggle="modal" data-target="#test">
					<i class="fas fa-edit add-depository"></i>Edit Picture			
				  </div>		
					</div>
            </div>			
            
			<div class="row">
                <div class="col-md-10">
                    <label class="margin-top-for">First Name</label><br>
                    <?=$this->Form->input('first_name', ['label'=>false, 'placeholder'=>'First Name'])?>
                </div>
                <div class="col-md-2"></div>
            </div>

            <div class="row">
                <div class="col-md-10">
                    <label class="margin-top-for">Last Name</label><br>
                    <?=$this->Form->input('last_name', ['label'=>false, 'placeholder'=>'Last Name'])?>
                </div>
                <div class="col-md-2"></div>
            </div>

            <div class="row">
                <div class="col-md-10">
                    <label class="margin-top-for">Ethereum Address</label><br>
                    <?=$this->Form->input('ethereum_public_address', ['label'=>false, 'placeholder'=>'Ethereum Address'])?>
                </div>
                <div class="col-md-2"></div>
            </div>
			<div class="row">
			
			
			
			<div class="col-md-12">
			 <?php //echo $this->Form->create($user, ['class' => 'data-form','type'=>'file','enctype' => 'multipart/form-data']); ?>
                <?php
                   // echo $this->Form->input('profile_photo',['type'=>'file','placeholder'=>'Profile Photo','label'=>'Select Image']);?>
					<? //echo $this->Form->button(__('Upload'), array('type'=>"submit","class" => "btn margin-top-for button-setting")); ?>	
                
			</div>
            </div>			
            <div class="row">
                <div class="col-md-10">
                    <?= $this->Form->button(__('Save Change'), array("id"=>"save" ,"class" => "btn margin-top-for button-setting")) ?>
                </div>
                <div class="col-md-2 "></div>
            </div>
			
            <?= $this->Form->end() ?>
        </div>

    </div>
	
			   
   
	       
		   
		   
		   
		   
		   
		   
		   
		   

</div>

