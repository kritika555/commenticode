<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit User'), ['action' => 'edit', $user->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete User'), ['action' => 'delete', $user->id], ['confirm' => __('Are you sure you want to delete # {0}?', $user->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Users'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New User'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Applications'), ['controller' => 'Applications', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Application'), ['controller' => 'Applications', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Buyers'), ['controller' => 'Buyers', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Buyer'), ['controller' => 'Buyers', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="users view large-9 medium-8 columns content">
    <h3><?= h($user->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th><?= __('Email') ?></th>
            <td><?= h($user->email) ?></td>
        </tr>
        <tr>
            <th><?= __('Password') ?></th>
            <td><?= h($user->password) ?></td>
        </tr>
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= $this->Number->format($user->id) ?></td>
        </tr>
        <tr>
            <th><?= __('Created') ?></th>
            <td><?= h($user->created) ?></td>
        </tr>
        <tr>
            <th><?= __('Updated') ?></th>
            <td><?= h($user->updated) ?></td>
        </tr>
        <tr>
            <th><?= __('Status') ?></th>
            <td><?= $user->status ? __('Yes') : __('No'); ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Related Applications') ?></h4>
        <?php if (!empty($user->applications)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th><?= __('Id') ?></th>
                <th><?= __('User Id') ?></th>
                <th><?= __('Type') ?></th>
                <th><?= __('No Of Person') ?></th>
                <th><?= __('Person1 First Name') ?></th>
                <th><?= __('Person2 First Name') ?></th>
                <th><?= __('Applying Jointly') ?></th>
                <th><?= __('Created') ?></th>
                <th><?= __('Updated') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($user->applications as $applications): ?>
            <tr>
                <td><?= h($applications->id) ?></td>
                <td><?= h($applications->user_id) ?></td>
                <td><?= h($applications->type) ?></td>
                <td><?= h($applications->no_of_person) ?></td>
                <td><?= h($applications->person1_first_name) ?></td>
                <td><?= h($applications->person2_first_name) ?></td>
                <td><?= h($applications->applying_jointly) ?></td>
                <td><?= h($applications->created) ?></td>
                <td><?= h($applications->updated) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Applications', 'action' => 'view', $applications->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Applications', 'action' => 'edit', $applications->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Applications', 'action' => 'delete', $applications->id], ['confirm' => __('Are you sure you want to delete # {0}?', $applications->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
    <div class="related">
        <h4><?= __('Related Buyers') ?></h4>
        <?php if (!empty($user->buyers)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th><?= __('Id') ?></th>
                <th><?= __('User Id') ?></th>
                <th><?= __('Application Id') ?></th>
                <th><?= __('No Of Jobs') ?></th>
                <th><?= __('Secondary Job Years') ?></th>
                <th><?= __('Email') ?></th>
                <th><?= __('First Name') ?></th>
                <th><?= __('Last Name') ?></th>
                <th><?= __('Ssn') ?></th>
                <th><?= __('Dob') ?></th>
                <th><?= __('Phone') ?></th>
                <th><?= __('Created') ?></th>
                <th><?= __('Updated') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($user->buyers as $buyers): ?>
            <tr>
                <td><?= h($buyers->id) ?></td>
                <td><?= h($buyers->user_id) ?></td>
                <td><?= h($buyers->application_id) ?></td>
                <td><?= h($buyers->no_of_jobs) ?></td>
                <td><?= h($buyers->secondary_job_years) ?></td>
                <td><?= h($buyers->email) ?></td>
                <td><?= h($buyers->first_name) ?></td>
                <td><?= h($buyers->last_name) ?></td>
                <td><?= h($buyers->ssn) ?></td>
                <td><?= h($buyers->dob) ?></td>
                <td><?= h($buyers->phone) ?></td>
                <td><?= h($buyers->created) ?></td>
                <td><?= h($buyers->updated) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Buyers', 'action' => 'view', $buyers->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Buyers', 'action' => 'edit', $buyers->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Buyers', 'action' => 'delete', $buyers->id], ['confirm' => __('Are you sure you want to delete # {0}?', $buyers->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
