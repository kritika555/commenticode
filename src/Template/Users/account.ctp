<div class="card padding-new" style="min-height: 550px;">
    <div class="row">
        <div class="col-md-4 media-center"><p class="heading-new heading-padd">Account</p></div>
        <div class="col-md-4 text-center">

        </div>
        <?php /*
        <div class="col-md-4 text-center media-center">
            <form class="search-form">

                <input type="text" placeholder="Search...">
                <button type="submit"><i class="fa fa-search"></i></button>

            </form>
        </div> */?>

    </div>
    <div class="row margin-top-for">
	<div class="col-md-6 text-right media-left" style="padding-right: 90px;"><strong>Total coins : <?=$coin_balance?></strong></div>
        <div class="col-md-6 media-center" style="padding-left: 70px;"><strong>Ethereum Address : </strong>
        <form action="">
        <select name="address" onchange="this.form.submit();">
            <?php
            foreach($addresses as $row){
                if(isset($_GET['address']) && !empty($_GET['address'])){
                    $address = $_GET['address'];
                }
                $selected = $row->address == $address ? 'selected="selected"' : '';
                ?>
                <option value="<?=$row->address?>" <?=$selected?>><?=$row->address?></option>
            <?php }
            ?>
        </select>
        </form>
        </div>
        
    </div>
    <hr />
    <div class="row">

        <div class="content table-responsive table-full-width">
            <?php if(count($transactions) > 0){ ?>
            <table class="table table-striped">

                <thead>
                <tr>
                    <th>Date</th>
                    <th>Coin</th>
                    <th>Project</th>
                    <th>Received Address</th>
                    <th>Rewards</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach($transactions as $tran) {
                    $purpose['BO'] = 'Transfer';
                    $purpose['W'] = 'Code Contribution';
                    $purpose['V'] = 'Voting/Review';
                    ?>
                <tr>
                    <td><?=date('m-d-Y', strtotime($tran->created))?></td>
                    <td><?=$commonComponent->formatToken($tran->amount)?></td>
                    <td><?=isset($tran->project) ? $tran->project->name : 'NA'?></td>
                    <td><?=$tran->address?></td>
                    <td><?=$purpose[$tran->type];?></td>
                </tr>
                <?php } ?>
                </tbody>
            </table>

            <?php  if ($this->Paginator->hasPage(2)) { ?>
                <div class="paginator" style="padding-left: 70px;">
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

    </div><!---end row-->
</div>
