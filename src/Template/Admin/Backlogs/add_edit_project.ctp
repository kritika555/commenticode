<div class="row">
    <div class="col-xs-12">
        <h1 class="page-header">
            <?= __('Projects') ?>
        </h1>
        <ol class="breadcrumb">
            <!--<li>
                <i class="fa fa-fw fa-dashboard"></i> <?/*= $this->Html->link(__("Dashboard"), ['controller' => 'users', 'action' => 'dashboard'], ['escape' => false]) */?>
            </li>-->
            <?php if($backlogId){ ?>
            <li class="active">
                <i class="fa fa-fw fa-file"></i> <?= $this->Html->link(__("Backlogs"), ['controller' => 'backlogs', 'action' => 'index']) ?>
            </li>
            <li class="active">
                <i class="fa fa-fw fa-file"></i> <?= $this->Html->link(__("Project Under '".$backlog->title."'"), ['controller' => 'backlogs', 'action' => 'projects', $backlogId]) ?>
            </li>
            <?php }else{ ?>
                <li class="active">
                    <i class="fa fa-fw fa-file"></i> <?= $this->Html->link(__("Projects"), ['controller' => 'backlogs', 'action' => 'projects']) ?>
                </li>
            <?php }?>
            <li class="active">
                <i class="fa"></i> <?= __($action.' Project') ?>
            </li>
        </ol>
    </div>
</div>
<div class="pages form col-xs-12 content">
    <?= $this->Form->create($project) ?>
    <fieldset>
        <legend><?= __($action.' Project '); if($backlogId){ echo 'Under "'.$backlog->title.'"'; }?></legend>
        <?php
            echo $this->Form->input('name');
            echo $this->Form->input('description');
            //echo $this->Form->input('status');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit'), ["class"=>"btn btn-success"]) ?>
	<?= $this->Html->link('Cancel', ['controller' => 'backlogs', 'action' => 'projects', $backlogId], ["class"=>"btn btn-default spacer-left-10"]); ?>
    <?= $this->Form->end() ?>
</div>
