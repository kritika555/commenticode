<div class="row">
    <div class="col-xs-12">
        <h1 class="page-header">
            <?= __('Edit Profile') ?>
        </h1>
        <ol class="breadcrumb">
            <!--<li>
                <i class="fa fa-fw fa-dashboard"></i> <?/*= $this->Html->link(__("Dashboard"), ['controller' => 'users', 'action' => 'dashboard'], ['escape' => false]) */?>
            </li>-->
           <li class="active">
                <i class="fa"></i> <?= __('Edit Profile') ?>
            </li>
        </ol>
    </div>
</div>
<div class="row">
    <div class="col-xs-12">
        <?= $this->Form->create($admin, ['class'=>'data-form']) ?>
        <fieldset>
            <legend><?= __("Edit Profile") ?></legend>
            <?php
            echo $this->Form->input('username', ['disabled'=>true]);
            echo $this->Form->input('email', ['disabled'=>true]);
            echo $this->Form->input('first_name');
            echo $this->Form->input('last_name');
            /*echo $this->Form->input('ethereum_public_address');
            echo $this->Form->input('ethereum_private_address', ['type'=>'password']);
            echo $this->Form->input('confirm_ethereum_private_address', ['type'=>'password']);*/
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
                first_name: {
                    required: true,
                    noSpace: true,
                    lettersonly: true
                },
                last_name: {
                    required: true,
                    noSpace: true,
                    lettersonly: true
                },
                ethereum_public_address: {
                    validEth: true,
                    required: true
                },
                ethereum_private_address: {
                    validEth: true,
                    required: true
                },
                confirm_ethereum_private_address: {
                    equalTo: "#ethereum-private-address"
                }
            },
            messages: {
                confirm_ethereum_private_address: {
                    equalTo: "Confirm ethereum private address should be same as ethereum private address."
                }
            }
        });
    });
</script>
