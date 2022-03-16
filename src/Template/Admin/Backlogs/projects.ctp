<!-- Page Heading -->
<div class="row">
    <div class="col-xs-12">
        <h1 class="page-header">
            <?= $backlogId ? __('Projects under "'.$backlog->title.'"') : 'Projects' ?>
        </h1>
        <ol class="breadcrumb">
            <li>
                <i class="fa fa-fw fa-dashboard"></i> <?= $this->Html->link(__("Dashboard"), ['controller' => 'users', 'action' => 'dashboard'], ['escape' => false]) ?>
            </li>
            <?php if($backlogId){ ?>
            <li>
                <i class="fa fa-fw fa-dashboard"></i> <?= $this->Html->link(__("Backlogs"), ['controller' => 'backlogs', 'action' => 'index'], ['escape' => false]) ?>
            </li>
            <?php }?>
            <li class="active">
                <i class="fa fa-fw fa-file"></i> <?= __('Projects') ?>
            </li>
        </ol>
    </div>
</div>
<!-- /.row -->
<div class="row filter">
    <div class="col-xs-9">
        <?= $this->Form->create('', ['type' => 'get']) ?>
        <fieldset>
            <?php echo $this->Form->input('title', ['value' => $this->request->query('title'), 'placeholder' => 'Search...']); ?>
            <?= $this->Form->button(__('Filter'), ["class" => "btn-spacing btn btn-success"]) ?>
        </fieldset>
        <?= $this->Form->end() ?>
    </div>
    <?php /*if($backlogId){  ?>
    <div class="col-xs-3">
        <?= $this->Html->link(__('Add new project'), ['action' => 'addEditProject', $backlogId], array("class" => "btn-spacing btn btn-success", 'title' => 'Add new project')) ?>
    </div>
    <?php } */ ?>
</div>
<div class="row">
    <div class="col-xs-12">
        <?php if (count($data)) { ?>
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead>
                    <tr>
                        <th><?= $this->Paginator->sort('name') ?></th>
                        <th><?= $this->Paginator->sort('backlog_id') ?></th>
                        <th><?= $this->Paginator->sort('Projects.created_by_id', 'Created By') ?></th>
                        <th><?= $this->Paginator->sort('up_vote') ?></th>
                        <th><?= $this->Paginator->sort('down_vote') ?></th>
                        <th>Created</th>
                        <th class="actions"><?= __('Actions') ?></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($data as $row): ?>
                        <tr>
                            <td><?= h($row->name) ?></td>
                            <td><?= h($row->backlog->title) ?></td>
                            <td><?= h($row->created_by->first_name) ?></td>
                            <td><?= h($row->up_vote) ?></td>
                            <td><?= h($row->down_vote) ?></td>
                            <td><?= h($row->created) ?></td>
                            <td class="actions" align="center">
                                <?= $this->Html->link(__('Edit'), ['action' => 'viewProject', $backlogId, $row->id], array("class" => "icon icon-view", 'alt' => 'View', 'title' => 'View')) ?>
                                <?php /* $this->Html->link(__('Edit'), ['action' => 'addEditProject', $backlogId, $row->id], array("class" => "icon icon-edit", 'alt' => 'Edit', 'title' => 'Edit')) */ ?>
                                <?php /* $this->Form->postLink(__('Delete'), ['action' => 'deleteProject', $backlogId, $row->id], ['confirm' => __('Do you really want to delete this project? \n The Github repo will also be deleted.'), 'class' => 'icon icon-delete'])*/ ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
                <?php if ($this->Paginator->hasPage(2)) { ?>
                    <div class="paginator">
                        <ul class="pagination">
                            <?= $this->Paginator->prev('< ' . __('previous')) ?>
                            <?= $this->Paginator->numbers() ?>
                            <?= $this->Paginator->next(__('next') . ' >') ?>
                        </ul>
                    </div>
                <?php } ?>
            </div>
        <?php } else { ?>
            <div class="alert alert-info">No record available.</div>
        <?php } ?>
    </div>
</div>
