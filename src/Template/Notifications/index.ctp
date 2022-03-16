<html>
<head>
</head>

<body>
<div class="card padding-new" style="min-height: 550px;">
    <!-- Page Heading -->
<div class="row">
    <div class="col-xs-12">
        <h1 class="page-header">
            <?= __('Notifications') ?>
        </h1>       
    </div>
</div>
<!--Table-->
<div class="row">
    <div class="col-xs-12">
        <?php if (count($notifications_list)) { ?>
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead>
                    <tr>                        
                        <th>Message</th>
                        <th>Winning Project</th>
						<th>Amount </th>
						<th>Pay Date</th>
						<th>Backlog</th>                       
                        <th class="actions"><?= __('Actions') ?></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($notifications_list as $nt):
						
						$backlog_id = $nt['backlog_id'];						
							if(array_key_exists($backlog_id,$backlogs_list)) {
								$backlog_title = $backlogs_list[$backlog_id];
							}else {
								$backlog_title = " ";
							}
						
						?>
                        <tr>
                            <td><?= h($nt['message']) ?></td>
                            <td><?= h($nt['project_name']) ?></td>
							<td><?= h($nt['amount']) ?> </td>
                            <td><?= h($nt['pay_date']) ?></td>
							<td><?= h($backlog_title) ?></td> 
                            <td><p>Paid <p> </td>                                               
                          
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
</div>
</body>
</html>