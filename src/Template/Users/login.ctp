<div class="register-form">
    <?php echo $this->Form->create('', ['id' => 'reLogin', 'class' => '']); ?>
    <?= $this->Flash->render() ?>
        <h3 class="form-heading">Login</h3>
    <?php
    echo $this->Form->input('username', ['maxlength' => 250, 'label'=>false, 'placeholder'=>"Username/Email", 'templates' => [
        'inputContainer' => '<div class="row">{{content}}</div>'
    ]]);
    echo $this->Form->input('password', ['maxlength' => 250, 'label'=>false, 'placeholder'=>"Password", 'templates' => [
        'inputContainer' => '<div class="row">{{content}}</div>'
    ]]);
    ?>

        <div class="row">
            <?php echo $this->Form->button('Login', array('type' => 'submit', 'escape' => true, "class" => "send-button"));?>
        </div>
        <div class="row margin-top">
            <?php echo $this->Html->link('Not Registered?', ['controller' => 'users', 'action' => 'register'], array('class' => 'help-text color-green')); ?>
            ||
            <?php echo $this->Html->link('Forgot Password', ['controller' => 'users', 'action' => 'forgotPassword'], array('class' => 'help-text color-green')); ?>
        </div>

    <?= $this->Form->end() ?>
</div>

<script>
    $(document).ready(function () {
        $("#username").focus();
        $("#reLogin").validate({
            rules: {
                username: {
                    required: true
                },
                password: {
                    required: true
                }
            },
            messages: {
                username: {
                    required: "Please enter your Username/Email."
                },
                password: {
                    required: "Please enter your password."
                }
            }
        });
    });
</script>	