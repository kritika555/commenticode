<div id="loginInfo" class="col-md-4 col-md-offset-3 col-xs-12 col-sm-8 login-box">
    <div class="titleHeading">Login</div>
    <div class="listedData">
        <table class="login_form">
            <?php echo $this->Form->create('User'); ?>
            <tr>
                <td colspan="3"><?= $this->Flash->render() ?></td>
            </tr>
            <tr class="input">
                <td colspan="2" class="head">
                    <?php
                    echo $this->Form->input('username', array('required' => 'true'));?>
                </td>
            <tr class="input">
                <td colspan="2" class="head">
                    <?php echo $this->Form->input('password', array('required' => 'true'));
                    echo $this->Form->input('remember', array('label' => 'Remember me', 'type' => 'checkbox', 'div' => array('class' => 'rememberDiv')));
                    ?>
                </td>
            </tr>
            <tr class="input">
                <td colspan="2" class="text-center">
                    <?php

                    echo $this->Form->button('Login', array('type' => 'submit', 'escape' => true, "class" => "btn btn-success"));
                    echo $this->Html->link('Forgot your password?', ['controller' => 'users', 'action' => 'forgotPassword'], array('class' => 'forgot-text'));?>
                </td>
            </tr>
        </table>
    </div>
</div>
<script>
    $(document).ready(function () {
        $("#username").focus();
    });
</script>	
