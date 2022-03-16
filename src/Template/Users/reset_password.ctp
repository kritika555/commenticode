<div class="register-form ">
    <?php
    if (isset($user)) {
        echo $this->Form->create($user, ['class' => 'form-custom login-form row']);
    } else {
        echo $this->Form->create('Users', ['class' => 'form-custom login-form row']);
    }
    ?>
        <h3 class="form-heading">Set Password</h3>
        <?php /*<p class="para">Password must contain one lowercase letter, one uppercase, one number, and be at least 7 characters long.</p> */ ?>
        <?php
        echo $this->Form->input('password', ['maxlength' => 250, 'label' => false, 'placeholder' => "Password", 'templates' => ['inputContainer' => '<div class="row">{{content}}</div>']]);
        echo $this->Form->input('confirm_password', ['maxlength' => 250, 'label' => false, 'type' => 'password', 'placeholder' => "Confirm Password", 'templates' => ['inputContainer' => '<div class="row">{{content}}</div>']]);
        ?>
        <div class="row">
            <?php echo $this->Form->button('Change Password', array('type' => 'submit', 'escape' => true, "class" => "send-button"));?>
        </div>

    <?= $this->Form->end() ?>
</div>
<script>
    $(document).ready(function () {
        $(".login-form").validate({
            rules: {
                password: {
                    validPassword: true,
                    required: true,
                    minlength: 8
                },
                confirm_password: {
                    required: true,
                    equalTo: "#password"
                }
            },
            messages: {
                confirm_password: {
                    equalTo: "Confirm password should be same as password."
                }
            }
        });
    });
</script>

