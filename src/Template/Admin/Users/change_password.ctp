<div class="row">
    <div class="col-xs-12">
        <h1 class="page-header">
            <?= __('Change Password') ?>
        </h1>
        <ol class="breadcrumb">
            <li>
                <i class="fa fa-fw fa-dashboard"></i> <?/*= $this->Html->link(__("Dashboard"), ['controller' => 'users', 'action' => 'dashboard'], ['escape' => false]) */?>
            </li>
            <li class="active">
                <i class="fa"></i> <?= __('Change Password') ?>
            </li>
        </ol>
    </div>
</div>
<div class="row">
    <div class="col-xs-12">
        <?= $this->Form->create($admin, ['class'=>'data-form']) ?>
        <fieldset>
            <legend><?= __("Change Password") ?></legend>
            <?php
                echo $this->Form->input('current_password', ['type'=>'password']);
                echo $this->Form->input('password', ['label'=>'New Password']);
                echo $this->Form->input('confirm_password', ['type'=>'password']);
            ?>
        </fieldset>
        <?= $this->Form->button(__('Submit'), array("class"=>"btn btn-success spacer-top-10")) ?>
        <?= $this->Form->end() ?>
    </div>
</div>
<script>
    $(document).ready(function () {
        $(".data-form").validate({
            rules: {
                current_password: {
                    required: true
                },
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
                    required: "Please enter confirm password.",
                    equalTo: "Confirm password should be same as password."
                }
            }
        });
    });
</script>
