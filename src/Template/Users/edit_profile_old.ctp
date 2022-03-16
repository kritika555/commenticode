<div class="row text-center"><h3 style="font-weight: 600;">Settings</h3></div>
<div class="row">
    <div class="col-md-4 align"></div>
    <div class="col-md-4 text-center">
        <div class="row border tab-set">
            <div class="col-md-6 tabs-btn active-tabs">
                <?= $this->Html->link('Edit Profile', ['controller' => 'Users', 'action' => 'editProfile'], array('class' => '')) ?>
            </div>
            <div class="col-md-6 tabs-btn">
                <?= $this->Html->link('Change Password', ['controller' => 'Users', 'action' => 'changePassword'], array('class' => '')) ?>
            </div>
        </div>
        <div class="form-setting text-center">
            <?php echo $this->Form->create($user, ['class' => 'data-form']); ?>
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
                <div class="col-md-10">
                    <?= $this->Form->button(__('Save Change'), array("class" => "btn margin-top-for button-setting")) ?>
                </div>
                <div class="col-md-2 "></div>
            </div>
            <?= $this->Form->end() ?>
        </div>

    </div>
    <div class="col-md-4">

    </div>
</div>

