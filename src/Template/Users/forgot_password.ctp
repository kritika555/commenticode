<div class="register-form ">
    <?php echo $this->Form->create('User', ['class'=>'login-form']); ?>
    <?= $this->Flash->render() ?>
    <h3 class="form-heading">Reset Your Password</h3>

    <p class="para">Enter your Registered email address and we will send you a link to reset your password.</p>

    <?php
    echo $this->Form->input('email', ['maxlength' => 250, 'label'=>false, 'placeholder'=>"Enter Your Email", 'templates' => [
        'inputContainer' => '<div class="row">{{content}}</div>'
    ]]);?>

    <div class=" row">
        <?php echo $this->Form->button('Send password reset email', array('type' => 'submit', 'escape' => true, "class" => "send-button"));?>
    </div>
    <div class="row margin-top">
        <?php echo $this->Html->link('Login', ['controller' => 'users', 'action' => 'login'], array('class' => 'help-text color-green')); ?>
        ||
        <?php echo $this->Html->link('Not Registered?', ['controller' => 'users', 'action' => 'register'], array('class' => 'help-text color-green')); ?>
    </div>
    <?= $this->Form->end() ?>
</div>

<script>
    $(document).ready(function () {
        $(".login-form").validate({
            rules: {
                email: {
                    required: true,
                    email: true
                }
            },
            messages: {
                email: {
                    required: "Please enter your email address.",
                    email: "Please enter a valid email address."
                }
            }
        });
    });
</script>
