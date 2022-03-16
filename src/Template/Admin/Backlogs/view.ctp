<nav class="col-xs-12 side-nav" id="actions-sidebar">
    <h2 class="heading"><?= __('Actions') ?></h2>
    <ul class="side-nav">
        <li><?= $this->Html->link(__('Edit Page'), ['action' => 'edit', $backlog->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Page'), ['action' => 'delete', $backlog->id], ['confirm' => __('Are you sure you want to delete # {0}?', $backlog->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Pages'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Page'), ['action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="pages view col-xs-12 content">
	<h3><?= h($backlog->title) ?></h3>
    <table class="table vertical-table">
        <tr>
            <th><?= __('Title') ?></th>
            <td><?= h($backlog->title) ?></td>
        </tr>
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= $this->Number->format($backlog->id) ?></td>
        </tr>
        <tr>
            <th><?= __('Created') ?></th>
            <td><?= h($backlog->created) ?></td>
        </tr>
        <tr>
            <th><?= __('Updated') ?></th>
            <td><?= h($backlog->updated) ?></td>
        </tr>
        <tr>
         <th><?= __('Content') ?></th>
         <td><?= $this->Text->autoParagraph(h($backlog->description)); ?></td>
        </tr>
    </table>
	<?= $this->Html->link('Cancel', ['controller' => 'backlogs', 'action' => 'index'], ['class' => 'btn btn-default']); ?>
</div>
