<?php
use Cake\Core\Configure;

$status = Configure::read('BacklogStatus');
$filters = Configure::read('BacklogFilters');
?>
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
                <i class="fa fa-fw fa-file"></i> <?= __('Backlogs') ?>
            </li>
        </ol>
    </div>
</div>
<!-- /.row -->
<div class="row filter">
    <div class="col-xs-12">
        <?= $this->Form->create('', ['type' => 'get']) ?>
        <fieldset>
            <?php echo $this->Form->input('title', ['value' => $this->request->query('title'), 'placeholder' => 'Search...']); ?>
            <div class="input select">
                <label for="title">Status</label>
                <?php echo $this->Form->select('status', $filters,
                    ['empty' => 'All', 'default' => $this->request->query('status')]); ?>
            </div>
            <div class="input select">
                <label for="title">Backlog</label>
                <?php echo $this->Form->select('backlog', ['all' => 'All Backlogs', 'my' => 'My Backlogs'],
                    ['default' => $this->request->query('backlog')]); ?>
            </div>
            <div class="input select">
                <label for="title">Type</label>
                <?php echo $this->Form->select('type', ['doing' => 'Doing', 'done' => 'Done', 'close' => 'Close'],
                    ['empty' => 'All', 'default' => $this->request->query('type')]); ?>
            </div>
            <?= $this->Form->button(__('Filter'), ["class" => "btn-spacing btn btn-success"]) ?>
            <?= $this->Html->link(__('Clear Filter'), ['controller' => 'backlogs', 'action' => 'index', '_full' => true], ["class" => "btn-spacing btn"]) ?>
        </fieldset>
        <?= $this->Form->end() ?>
    </div>
</div>
<div class="row">
    <div class="col-xs-12">
        <?php if (count($backlogs)) { ?>
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead>
                    <tr>
                        <th><?= $this->Paginator->sort('title') ?></th>
                        <th>Owner</th>
                        <th><?= $this->Paginator->sort('amount') ?></th>
                        <th>Projects</th>
                        <th>Repo</th>
                        <th><?= $this->Paginator->sort('start_date') ?></th>
                        <th><?= $this->Paginator->sort('end_date') ?></th>
                        <th><?= $this->Paginator->sort('Backlogs.status', 'Status') ?></th>
                        <th class="actions"><?= __('Actions') ?></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($backlogs as $backlog): ?>
					  <?php //prd($backlog); ?>
                        <span class="hide jsVoteStartDate<?= $backlog->id ?>"><?= h($backlog->vote_start_date) ?></span>
                        <span class="hide jsVoteEndDate<?= $backlog->id ?>"><?= h($backlog->vote_end_date) ?></span>
                        <tr>
                            <td><?= h($backlog->title) ?></td>
                            <td><?= h($backlog->created_by['username']) ?></td>
                            <td class="jsAmount"><?= h($commonComponent->formatToken2($backlog->amount)) ?></td>
                            <td>
                                [ <?= $this->Html->link(count($backlog->projects), ['action' => 'projects', $backlog->id], array('title' => 'Total Projects')) ?>
                                ]
                            </td>
                            <!-- <td> <?php //if (!empty($backlog->github_file)) { -->
                                    //$file = json_decode($backlog->github_file)->content; -->
                                     //echo '<a href="' . $file->download_url . '" target="_blank">' . $file->name . '</a>' -->;
                               // } ?></td> -->
							   <td>
							     <?php echo $backlog->repository_name; ?>
							   </td>
                            <td class="jsStartDate<?= $backlog->id ?>"><?= h($backlog->start_date) ?></td>
                            <td class="jsEndDate<?= $backlog->id ?>"><?= h($backlog->end_date) ?></td>
                            <td class="jsStatus<?= $backlog->id ?>">
                                <?= $backlog->status ?></td>

                            <td class="actions" style="position: relative;">
                                <?php // $this->Html->link(__('Preview'), ['action' => 'view', $backlog->id], array("class" => "icon icon-view", 'alt' => 'View', 'title' => 'View', 'onclick' => 'showAlert("Under Construction"); return false')) ?>
                                <?= $this->Html->link(__('Edit'), ['action' => 'addEdit', $backlog->id], array("class" => "icon icon-edit", 'alt' => 'Edit', 'title' => 'Edit')) ?>
                                <?php if ($backlog->vote_end_date == null || $backlog->vote_start_date > date('Y-m-d')) { ?>
                                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $backlog->id], ['confirm' => __('Are you sure you want to delete?'), 'class' => 'icon icon-delete', 'title' => 'Delete']) ?>
                                <?php } ?>
                                <br/>
                                <?php if ($backlog->status == 'P') {
                                    $approve = 'block';
                                    $reject = 'block';
                                } elseif ($backlog->status == 'R') {
                                    $approve = 'block';
                                    $reject = 'none';
                                } elseif ($backlog->status == 'A') {
                                    $approve = 'none';
                                    $reject = 'none';
                                }
                                ?>
                                <a style="display: <?= $approve ?>; color: #000; margin-top: 10px; float: left;"
                                   title="Approve" class="jsApprove glyphicon glyphicon-ok" href="javascript: void(0);"
                                   data-id="<?= $backlog->id ?>" data-status="A"></a>
                                <a style="display: <?= $reject ?>; color: #000; margin: 10px 0 0 17px; float: left;"
                                   title="Reject" class="jsReject glyphicon glyphicon-remove"
                                   href="javascript: void(0);" data-id="<?= $backlog->id ?>" data-status="R"></a>
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
<script>
    $(function () {
        $('.jsApprove, .jsReject').on('click', function () {
            var id = $(this).data("id"),
                status = $(this).data("status"),
                me = $(this);

            //$(this).parent().append($("<img src='" + siteUrl + "img/loading.gif' class='ajaxLoad' style='position:absolute; top:0px; right:0px;' />"));
            if (status == 'A' && ($('.jsStartDate' + id).html() == '' || $('.jsEndDate' + id).html() == ''
                || $('.jsVoteStartDate' + id).html() == '' || $('.jsVoteEndDate' + id).html() == '' || $('.jsAmount' + id).html() == '0')) {
                showAlert('Please select the backlog start/end date, vote start/end date and amount.');
                $("#myModal").on("hidden.bs.modal", function () {
                    window.location = siteUrl + 'admin/backlogs/add-edit/' + id + '?status=A';
                });

                return false;
            }
            showLoader();
            $.ajax({
                type: "POST",
                url: siteUrl + 'admin/backlogs/setBacklogStatus/',
                data: {id: id, status: status},
                dataType:"json",
                success: function (res) {
                    if (res.success == 1) {
                        var s = '';
                        if (status == 'A') {
                            s = 'Approved';
                        } else if (status == 'R') {
                            s = 'Rejected';
                        } else {
                            s = 'Pending';
                        }
                        $('.jsStatus' + id).html(s);
                        me.hide();

                        showAlert('Backlog status has been changed to ' + s);
                    } else {
                        if (status == 'A') {
                            showAlert(res.message);
                        } else {
                            showAlert('Action can not be performed, please try again.');
                        }

                    }
                    hideLoader();
                },
				complete:function()
				{
					hideLoader();
					 window.location.reload();
				}	
            });

        });
    });
</script>
