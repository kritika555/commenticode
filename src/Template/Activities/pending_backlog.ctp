<?php
use Cake\Core\Configure;
?>
<div class="card padding-new" style="min-height: 550px;">
    <div class="row">
        <div class="col-md-1 padding-left"><span class="heading-new"></span></div>
        <div class="col-md-7 text-center">
            <div class="row border tab-set">
                <div class="col-md-3 tabs-btn border1"><?php echo $this->Html->link('My Projects', ['controller' => 'activities', 'action' => 'index', 'projects']); ?></div>
                <div class="col-md-3 tabs-btn border1"><?php echo $this->Html->link('Comments', ['controller' => 'activities', 'action' => 'index', 'comments']); ?></div>
                <div class="col-md-3 tabs-btn border1"><?php echo $this->Html->link('Votes', ['controller' => 'activities', 'action' => 'index', 'votes']); ?></div>
                <div class="col-md-3 tabs-btn active-tabs-2"><?php echo $this->Html->link('Pending Backlogs', ['controller' => 'activities', 'action' => 'pendingBacklog']); ?></div>
            </div>
        </div>
        <div class="col-md-4 text-center">
            <?= $this->Form->create('', ['type' => 'get', 'class' => 'search-form']);
            $this->Form->templates([
                'inputContainer' => '{{content}}'
            ]); ?>
            <?php echo $this->Form->input('title', ['label' => false, 'value' => $this->request->query('title'), 'placeholder'=>'Search...']); ?>
            <?= $this->Form->button(__('<i class="fa fa-search"></i>'), ["class" => ""]) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
    <hr />
    <div id="London" class="tabcontent">
        <div class="content table-responsive table-full-width">
            <?php if (count($data)) { ?>
            <table class="table table-striped">
                <thead>
                <th>Backlog</th>
                <th>Status</th>
                <th>Detail</th>
                </thead>
                <tbody>
                <?php

                $status = Configure::read('BacklogStatus');
                foreach ($data as $row):  ?>
                <tr>
                    <td><?= h($row->title) ?></td>
                    <td><?=$status[$row->status]?></td>
                    <td>
                        <?= $this->Html->link(__('View'), ['controller' => 'backlogs', 'action' => 'view', $row->id], array("class" => "icon icon-view", 'alt' => 'View', 'title' => 'View')) ?>
                    </td>
                </tr>
                
                <?php endforeach; ?>
                </tbody>
            </table>
                <?php  if ($this->Paginator->hasPage(2)) {     ?>
                    <div class="paginator">
                        <ul class="pagination">
                            <?= $this->Paginator->prev('< ' . __('previous')) ?>
                            <?= $this->Paginator->numbers() ?>
                            <?= $this->Paginator->next(__('next') . ' >') ?>
                        </ul>
                    </div>
                <?php } ?>
            <?php } else { ?>
                <div class="alert alert-info">No record available.</div>
            <?php } ?>
        </div>
    </div>
</div><!----end card-->
</div>