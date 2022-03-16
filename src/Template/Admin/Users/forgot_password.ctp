<div id="loginInfo" class="col-md-4 col-md-offset-3 col-xs-12 col-sm-8 login-box">
    <div class="titleHeading">Forgot Password</div>
    <div class="listedData">
        <table class="login_form">
            <?php echo $this->Form->create('User'); ?>
            <tr><td colspan="3"><?= $this->Flash->render() ?></td></tr>
            <tr>
                <td colspan="2" class="head">
                    <?php echo $this->Form->input('email', array('type' => 'email', 'required' => 'true')); ?>
                </td>
            </tr>
            <tr>
                <td colspan="2"><label>&nbsp;</label>
                    <?php echo $this->Form->button('Submit', array('type' => 'submit', 'escape' => true, "class" => "btn btn-success"));
                    echo $this->Html->link('Cancel', ['controller' => 'users', 'action' => 'login'], array('class' => 'btn btn-default spacer-left-10'));?>
                </td>
            </tr>
        </table>

    </div>
</div>
<script>
    $(document).ready(function () {
        $("#email").focus();
    });
</script>

