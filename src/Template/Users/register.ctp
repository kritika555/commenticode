<div>
<!--<div style="background-color:#fff;" class="shadow white description" role="alert">
  Sorry!Incoming registrations are closed!
</div>-->
<div class="register-form ">

    <?= $this->Form->create($user, ['autocomplete' => 'off', 'id' => 'register', 'class' => '']) ?>
    <?= $this->Flash->render() ?>
    <h3 class="form-heading">Register</h3>
	<!--disabled fr now 4/09/2020 -->
    <?php
    echo $this->Form->input('first_name', ['maxlength' => 250, 'label' => false, 'placeholder' => "First Name",'disabled'=>'false','templates' => ['inputContainer' => '<div class="row">{{content}}</div>']]);
    echo $this->Form->input('last_name', ['maxlength' => 250, 'label' => false, 'placeholder' => "Last Name",'disabled'=>false,'templates' => ['inputContainer' => '<div class="row">{{content}}</div>']]);
    echo $this->Form->input('username', ['maxlength' => 250, 'label' => false, 'placeholder' => "Username",'disabled'=>false,'templates' => ['inputContainer' => '<div class="row">{{content}}</div>']]);
    echo $this->Form->input('email', ['maxlength' => 250, 'label' => false, 'placeholder' => "Email",'disabled'=>false,'templates' => ['inputContainer' => '<div class="row">{{content}}</div>']]);
    echo $this->Form->input('password', ['maxlength' => 250, 'label' => false, 'placeholder' => "Password",'disabled'=>false,'templates' => ['inputContainer' => '<div class="row">{{content}}</div>']]);
    echo $this->Form->input('confirm_password', ['maxlength' => 250, 'label' => false, 'type' => 'password','disabled'=>false,'placeholder' => "Confirm Password", 'templates' => ['inputContainer' => '<div class="row">{{content}}</div>']]);
    echo $this->Form->input('ethereum_public_address', ['maxlength' => 250, 'label' => false, 'placeholder' => "Ethereum Address",'disabled'=>'false','templates' => ['inputContainer' => '<div class="row">{{content}}</div>']]);
    ?>
    <div class="row">
        <?= $this->Form->button(__('Submit'), ['type' => 'submit', 'escape' => true, "class" => "send-button"]) ?>
    </div>
    <div class="row margin-top">
        <?php echo $this->Html->link('Login', ['controller' => 'users', 'action' => 'login'], array('class' => 'help-text color-green')); ?>
        ||
        <?php echo $this->Html->link('Forgot Password', ['controller' => 'users', 'action' => 'forgotPassword'], array('class' => 'help-text color-green')); ?>
    </div>
    <?= $this->Form->end() ?>
</div>
</div>
