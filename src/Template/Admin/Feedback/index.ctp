<?php

?>
<html>
<head>
</head>

<body>
    
    <!-- Page Heading -->
<div class="row">
    <div class="col-xs-12">
        <h1 class="page-header">
            <?= __('Feedback') ?>
        </h1>
        <ol class="breadcrumb">
            <li>
				<i class="fa fa-fw fa-dashboard"></i> <?= $this->Html->link(__("Dashboard"), ['controller' => 'users', 'action' => 'dashboard'], ['escape' => false]) ?>
			</li>
            <li class="active">
                <i class="fa fa-fw fa-file"></i> <?= __('Feedback') ?>
            </li>
        </ol>
    </div>
</div>
<!--Table-->
<div class="row">
    <div class="col-xs-12">
        <?php if (count($feedback)) { ?>
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead>
                    <tr>
                        <th><?= $this->Paginator->sort('id') ?></th>
                        <th>Message</th>
						<th>Star Rating</th>
                        <th>Posted By</th>
                       
                        <th class="actions"><?= __('Actions') ?></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($feedback as $fd): ?>                       
                        <tr>
                            <td><?= h($fd->id) ?></td>
                            <td><?= h($fd->message) ?></td>
							<td><?= h($fd->star_rating)?>
							<td>
							<input disabled id="star_rating" name="star_rating" class="rating rating-loading" value="<?php echo $fd->star_rating;?>" data-min="0" data-max="5" data-step="0.5" data-size="xs"> 
							</td>
							
                            <td><?= h($user[$fd->user_id]) ?></td>
                             <td>           
                           <?= $this->Html->link('View', ['action' => 'view', $fd->id]) ?>
                            <?= $this->Form->postLink(
                                'Delete',
                                ['action' => 'delete', $fd->id],
                                ['confirm' => 'Are you sure?'])
                            ?>
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

</body>
</html>