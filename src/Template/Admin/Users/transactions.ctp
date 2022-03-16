<!-- Page Heading -->
<div class="row">
    <div class="col-xs-12">
        <h1 class="page-header">
            <?= __('Backlogs') ?>
        </h1>
        <ol class="breadcrumb">
            <li>
                <i class="fa fa-fw fa-dashboard"></i> <?/*= $this->Html->link(__("Dashboard"), ['controller' => 'users', 'action' => 'dashboard'], ['escape' => false]) */?>
            </li>
            <li class="active">
                <i class="fa fa-fw fa-file"></i> <?= __('Users') ?>
            </li>
        </ol>
    </div>
</div>
<div class="row">
    <div class="col-xs-6"><b>Initial Supply:</b> <?= $data['balance'] ?></div>
    <div class="col-xs-6"><b>Reserved Coins:</b> <?= $data['total_reserved'] ?></div>
    <div class="col-xs-6"><b>Business Account Balance:</b> <?= $data['balance_business'] ?></div>
    <div class="col-xs-6"><b>Development Account Balance:</b> <?= $data['balance_dev'] ?></div>
</div>
<!-- /.row -->
<div class="row filter">
    <div class="col-xs-6" style="padding:15px;">
        <?= $this->Form->create('', ['type' => 'get']) ?>
        <fieldset>
            <?php /*echo $this->Form->input('keyword', ['value' => $this->request->query('keyword'), 'placeholder'=>'Search...']); ?>
            <?= $this->Form->button(__('Filter'), ["class" => "btn-spacing btn btn-success"]) */ ?>
            <select name="status" onchange="this.form.submit();">
                <option value="1" <?php if (isset($_GET['status']) && $_GET['status'] == 1) {
                    echo 'selected="selected"';
                } ?>>Transactions
                </option>
                <option value="0" <?php if (isset($_GET['status']) && $_GET['status'] == 0) {
                    echo 'selected="selected"';
                } ?>>Failed Transactions
                </option>
                <option value="BO" <?php if (isset($_GET['status']) && $_GET['status'] == 'BO') {
                    echo 'selected="selected"';
                } ?>>Business to Other
                </option>
                <option value="BD" <?php if (isset($_GET['status']) && $_GET['status'] == 'BD') {
                    echo 'selected="selected"';
                } ?>>Business to Development
                </option>
                <option value="DB" <?php if (isset($_GET['status']) && $_GET['status'] == 'DB') {
                    echo 'selected="selected"';
                } ?>>Development to Business
                </option>
            </select>
        </fieldset>
        <?= $this->Form->end() ?>
    </div>
    <?php if (isset($_GET['status']) && $_GET['status'] == '0') { ?>
    <div class="col-xs-3">
        <?= $this->Html->link(__("Process Failed Transactions"), ['controller' => 'crons', 'action' => 'processFailedTransactions',true], ['class' => 'btn-spacing btn btn-success']) ?>
    </div>
    <?php } ?>
</div>
<div class="row">
    <div class="col-xs-12">
        <?php if (count($transactions)) { ?>
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead>
                    <tr>
                        <th>Date</th>
            <?php if (!isset($_GET['status']) || $_GET['status'] != '0') { ?>
                        <th>Coin</th>
                <?php } ?>
                        <th>Purpose</th>
                        <?php if (!isset($_GET['status']) || ($_GET['status'] != 'BD' && $_GET['status'] != 'DB')) { ?>
                         <th>Address</th>
                        <?php } ?>
                        <?php if (!isset($_GET['status']) || ($_GET['status'] != 'BO' && $_GET['status'] != 'BD' && $_GET['status'] != 'DB')) { ?>
                            <th>Project</th>
                        <?php } ?>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($transactions as $tran):
                        $purpose['BO'] = 'Business to Other';
                        $purpose['BD'] = 'Business to Development';
                        $purpose['DB'] = 'Development to Business';
                        $purpose['W'] = 'Code Contribution';
                        $purpose['V'] = 'Voting/Review';
                        ?>
                        <tr>
                            <td><?= date('m-d-Y', strtotime($tran->created)) ?></td>
                <?php if (!isset($_GET['status']) || $_GET['status'] != '0') { ?>
                            <td><?= $tran->amount ? $commonComponent->formatToken($tran->amount) : $tran->amount ?></td>
                <?php } ?>
                            <td><?=$purpose[$tran->type] ?></td>
                            <?php if (!isset($_GET['status']) || ($_GET['status'] != 'BD' && $_GET['status'] != 'DB')) { ?>
                                <td><?= $tran->address ?></td>
                            <?php } ?>
                            <?php if (!isset($_GET['status']) || ($_GET['status'] != 'BO' && $_GET['status'] != 'BD' && $_GET['status'] != 'DB')) { ?>
                                <td><?= $tran->project->name ?></td>
                            <?php } ?>
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
