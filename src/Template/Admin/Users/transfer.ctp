<div class="row">
    <div class="col-xs-12">
        <h1 class="page-header">
            <?= __('Transfer') ?>
        </h1>
        <ol class="breadcrumb">
            <!--<li>
                <i class="fa fa-fw fa-dashboard"></i> <?/*= $this->Html->link(__("Dashboard"), ['controller' => 'users', 'action' => 'dashboard'], ['escape' => false]) */?>
            </li>-->
            <li class="active">
                <i class="fa fa-fw fa-file"></i> <?= $this->Html->link(__("Users"), ['controller' => 'users', 'action' => 'index']) ?>
            </li>
            <li class="active">
                <i class="fa"></i> <?= __('Transfer') ?>
            </li>
        </ol>
    </div>
</div>
<div class="pages form col-xs-12 content">
    <form name="frm" method="post" action="" id="frmTransfer">
    <fieldset>
        <legend><?= __('Transfer') ?></legend>
        <?php echo $this->Form->input('from_account', ['type'=>'select', 'options'=>['dev'=>'Development', 'business'=>'Business']]); ?>
        <div id="jsBusinessAccount">
        <?php echo $this->Form->input('business_account', ['value'=>'Business', 'disabled'=>true, 'label'=>'To Account']); ?>
        </div>
        <div id="jsToAccountType" style="display: none;">
        <?php echo $this->Form->input('to_account_type', ['type'=>'select', 'options'=>['dev'=>'Development', 'other'=>'Other']]); ?>
        </div>
        <div id="jsToAccount" style="display: none;">
        <?php echo $this->Form->input('to_account'); ?>
        </div>
        <div id="jsToAddress" style="display: none;">
        <?php echo $this->Form->input('to_address'); ?>
        </div>
        <?php echo $this->Form->input('coin'); ?>
    </fieldset>
    <?= $this->Form->button(__('Submit'), ["class"=>"btn btn-success jsSubmit"]) ?>
    </form>
</div>

<script>
$(function(){
    $("#frmTransfer").validate({
        rules: {
            coin: {
                required: true,
                positiveNumber: true,
                ethDecimal: true
            },
            to_address: {
                required: true,
                validEth: true
            }
        },
        messages: {
        }
    });

    $('.jsSubmit').click(function(){
        if( $("#frmTransfer").valid()){
            showLoader();
        }
    });

    function fromAccountChange(){
        if($('#from-account').val() == 'dev'){
            $('#jsBusinessAccount').show();
            $('#jsToAccountType').hide();
            $('#jsToAccount').hide();
            $('#jsToAddress').hide();
        }else{
            $('#jsBusinessAccount').hide();
            $('#jsToAccountType').show();
            $('#jsToAccount').hide();
            $('#jsToAddress').hide();
        }
    }

    function accountTypeChange(){
        if($('#to-account-type').val() == 'dev'){
            $('#jsToAddress').hide();
        }else{
            $('#jsToAddress').show();
        }
    }

    $('#from-account').change(fromAccountChange);
    $('#to-account-type').change(accountTypeChange);
    fromAccountChange();
    accountTypeChange();

})
</script>
