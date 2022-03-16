<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">
            <?= __('Settings') ?>
        </h1>
        <ol class="breadcrumb">
            <!--<li>
                <i class="fa fa-fw fa-dashboard"></i> <?/*= $this->Html->link(__("Dashboard"), ['controller' => 'users', 'action' => 'dashboard'], ['escape' => false]) */?>
            </li>-->
            <li class="active">
                <i class="fa fa-cog"></i> <?= __('Settings') ?>
            </li>
        </ol>
    </div>
</div>
<div class="row filter">
    <div class="col-xs-12">
        <?= $this->Form->create('', ['type' => 'get']) ?>
        <fieldset>
            <?php echo $this->Form->input('title', ['label'=>'Title/Key/Value','type' => 'text', 'placeholder' => 'Search...', 'value' => $this->request->query('title')]); ?>
            <?= $this->Form->button(__('Filter'), ["class" => "btn-spacing btn btn-success"]) ?>
        </fieldset>
        <?= $this->Form->end() ?>
    </div>
</div>
<!-- /.row -->
<div class="row">
    <div class="col-lg-12">

        <?php if (count($configurations)) { ?>
            <div class="table-responsive">
                <table cellpadding="0" cellspacing="0" class="table table-bordered table-hover">
                    <thead>
                    <tr>
                        <th><?= $this->Paginator->sort('title') ?></th>
                        <th><?= $this->Paginator->sort('conf_key','Key') ?></th>
                        <th><?= $this->Paginator->sort('conf_value','Value') ?></th>
                        <th class="actions"><?= __('Actions') ?></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($configurations as $configuration): ?>
                        <tr>
                            <td><?= h($configuration->title) ?></td>
                            <td><?= h($configuration->conf_key) ?></td>
                            <td><?= h($configuration->conf_value) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('Edit'), ['action' => 'add-edit', $configuration->id], ["class" => "icon icon-edit", 'alt' => 'Edit', 'title' => 'Edit']) ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php } else { ?>
            <div class="alert alert-info">No record available.</div>
        <?php } ?>
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
</div>
