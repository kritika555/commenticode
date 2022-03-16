<?php //prd($backlogId);exit(); ?>
<div class="card padding-new" style="min-height: 550px;">
<div class="row">
    <div class="col-md-4 padding-left media-center"><span class="heading-new">Projects</span></div>
    <div class="col-md-4 text-center"></div>
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
<div class="row">
    <div class="content table-responsive table-full-width">
    <?php if (count($data)) { ?>
        <table class="table table-striped">
            <thead>
            <th>Project</th>
			<th>Backlog</th>
            <th>Date</th>
            <th>Upvote</th>
            <th>Downvote</th>
            <th>Owner</th>
            <th>Status</th>
            </thead>
            <tbody>
        <?php foreach ($data as $row): ?>
        <?php // prd($row); ?>
            <tr>
                <td><?= h($row->name) ?></td>
				<td><?=h($row->backlog->title) ?></td>
                <td><?= h($row->created) ?></td>
                <td><i class="fas fa-thumbs-up arrow-margin green"></i><?= h($row->up_vote) ?></td>
                <td><i class="fas fa-thumbs-down arrow-margin red"></i><?= h($row->down_vote) ?></td>
                <td><?= h($row->created_by->first_name) ?></td>
                <td><?= $this->Html->link(__('View'), ['action' => 'viewProject', $row->backlog_id, $row->id], array("class" => "icon icon-view", 'alt' => 'View', 'title' => 'View')) ?></td>
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
        <?php } else { ?>
            <div class="alert alert-info">No record available.</div>
        <?php } ?>
    </div>
    <div class="row padding-card">
        <div class="col-lg-12">
            <?= $this->Html->link(__('Back'), ['action' => 'index'], array("class" => "btn btn-default margin-top", 'title' => 'Back')) ?>
        </div>
    </div>
</div><!---end row-->
</div>