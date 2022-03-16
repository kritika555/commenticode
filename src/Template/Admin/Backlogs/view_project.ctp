<div class="row">
    <div class="col-xs-12">
        <h1 class="page-header">
            <?= __('Projects') ?>
        </h1>
        <ol class="breadcrumb">
           <!-- <li>
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
                <i class="fa"></i> <?= __('View Project') ?>
            </li>
        </ol>
    </div>
</div>
<div class="pages view col-xs-12 content">
	<h3>Project - <?= h($project->name) ?></h3>
    <table class="table vertical-table">
        <tr>
            <th width="20%"><?= __('Title') ?></th>
            <td width="80%"><?= h($project->name) ?></td>
        </tr>
        <tr>
            <th width="20%"><?= __('Download URL') ?></th>
            <td width="80%">
                <?php if(!empty($project->github_file)){ ?>
                <a href="<?= h(json_decode($project->github_file)->content->download_url) ?>" target="_blank" class="btn-spacing btn btn-success">Click to download</a></td>
                <?php }else { echo 'NA';} ?>
        </tr>
        <tr>
            <th><?= __('Description') ?></th>
            <td><?= nl2br($project->description) ?></td>
        </tr>
        <tr>
            <th><?= __('Up Vote') ?></th>
            <td><?= $project->up_vote ?></td>
        </tr>
        <tr>
            <th><?= __('Down Vote') ?></th>
            <td><?= $project->down_vote ?></td>
        </tr>
        <tr>
            <th><?= __('Status') ?></th>
            <td><?= $project->status ? 'Active' : 'Inactive' ?></td>
        </tr>
        <tr>
            <th><?= __('Created') ?></th>
            <td><?= h($project->created) ?></td>
        </tr>
        <tr>
            <th><?= __('Updated') ?></th>
            <td><?= h($project->updated ? $project->updated : 'Not updated yet.') ?></td>
        </tr>
    </table>

    <h3>Comments</h3>
    <table class="table vertical-table">
        <?php if (count($projectComments)) { ?>
            <tr>
                <th width="20%">Commented By</th>
                <th width="80%">Comment</th>
            </tr>
        <?php foreach ($projectComments as $comment){ ?>
        <tr>
            <td><?= h($comment->user->first_name.' '.$comment->user->last_name); ?></td>
            <td><?= $this->Text->autoParagraph(h($comment->comment)); ?></td>
        </tr>
        <?php } }else{?>
        <tr>
            <th>No Comments</th>
        </tr>
        <?php }?>
    </table>

    <?php  if ($this->Paginator->hasPage(2)) { ?>
        <div class="paginator">
            <ul class="pagination">
                <?= $this->Paginator->prev('< ' . __('previous')) ?>
                <?= $this->Paginator->numbers() ?>
                <?= $this->Paginator->next(__('next') . ' >') ?>
            </ul>
        </div>
    <?php } ?>

    <?= $this->Html->link('Back', ['controller' => 'backlogs', 'action' => 'projects', $backlogId], ["class"=>"btn btn-default spacer-left-10"]); ?>

</div>
