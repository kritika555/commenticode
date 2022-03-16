<div class="row">
    <div class="col-xs-12">
        <h1 class="page-header">
            <?= __('Users') ?>
        </h1>
        <ol class="breadcrumb">
            <!--<li>
                <i class="fa fa-fw fa-dashboard"></i> <?/*= $this->Html->link(__("Dashboard"), ['controller' => 'users', 'action' => 'dashboard'], ['escape' => false]) */?>
            </li>-->
            <li class="active">
                <i class="fa fa-fw fa-file"></i> <?= $this->Html->link(__("Users"), ['controller' => 'users', 'action' => 'index']) ?>
            </li>
            <li class="active">
                <i class="fa"></i> <?= __($action.' User') ?>
            </li>
        </ol>
    </div>
</div>
<div class="pages form col-xs-12 content">
    <?= $this->Form->create($user,['type'=>'post']) ?>
    <fieldset>
        <legend><?= __($action.' User') ?></legend>
        <?php
            echo $this->Form->input('first_name');
            echo $this->Form->input('last_name');
            echo $this->Form->input('username');
            echo $this->Form->input('email', ['readonly'=>true]);
            echo $this->Form->input('status');
        if($action == 'Add'){
            echo $this->Form->input('password', ['type'=>'text']);
        }
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit'), ["class"=>"btn btn-success"]) ?>
	<?= $this->Html->link('Cancel', ['controller' => 'users', 'action' => 'index'], ["class"=>"btn btn-default spacer-left-10"]); ?>
    <?= $this->Form->end() ?>
</div>
