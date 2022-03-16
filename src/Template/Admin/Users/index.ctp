<!-- Page Heading -->
<div class="row">
    <div class="col-xs-12">
        <h1 class="page-header">
            <?= __('Backlogs') ?>
        </h1>
        <ol class="breadcrumb">
            <li>
                <i class="fa fa-fw fa-dashboard"></i> <?= $this->Html->link(__("Dashboard"), ['controller' => 'users', 'action' => 'dashboard'], ['escape' => false]) ?>
            </li>
            <li class="active">
                <i class="fa fa-fw fa-file"></i> <?= __('Users') ?>
            </li>
        </ol>
    </div>
</div>
<!-- /.row -->
<div class="row filter">
    <div class="col-xs-12">
        <?= $this->Form->create('', ['type' => 'get']) ?>
        <fieldset>
            <?php echo $this->Form->input('keyword', ['value' => $this->request->query('keyword'), 'placeholder'=>'Search...']); ?>
            <?= $this->Form->button(__('Filter'), ["class" => "btn-spacing btn btn-success"]) ?>
        </fieldset>
        <?= $this->Form->end() ?>
    </div>
</div>
<div class="row">
    <div class="col-xs-12">
        <?php if (count($users)) { ?>
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead>
                    <tr>
                        <th><?= $this->Paginator->sort('id') ?></th>
                        <th><?= $this->Paginator->sort('first_name') ?></th>
                        <th><?= $this->Paginator->sort('last_name') ?></th>
                        <th><?= $this->Paginator->sort('email') ?></th>
                        <th><?= $this->Paginator->sort('ethereum_public_address') ?></th>
                        <th><?= $this->Paginator->sort('status') ?></th>
                        <th class="actions"><?= __('Actions') ?></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($users as $user): ?>
                        <tr>
                            <td><?= $this->Number->format($user->id) ?></td>
                            <td><?= h($user->first_name) ?></td>
                            <td><?= h($user->last_name) ?></td>
                            <td><a href="mailto:<?=$user->email?>"><?= h($user->email) ?></a></td>
                            <td><?= h($user->ethereum_public_address) ?></td>
                            <td><?= h($user->status ? 'Active' : 'Inactive') ?></td>
                            <td class="actions" align="center">
                                <?= $this->Html->link(__('Edit'), ['action' => 'addEdit', $user->id], array("class" => "icon icon-edit", 'alt' => 'Edit', 'title' => 'Edit')) ?>
                                <?php // $this->Form->postLink(__('Delete'), ['action' => 'delete', $user->id], ['confirm' => __('Are you sure you want to delete?'), 'class' => 'icon icon-delete']) ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
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
            </div>
        <?php } else { ?>
            <div class="alert alert-info">No record available.</div>
        <?php } ?>
    </div>
</div>
