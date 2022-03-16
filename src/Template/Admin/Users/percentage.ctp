<div class="row">
    <div class="col-xs-12">
        <h1 class="page-header">
            <?= __('Percentage') ?>
        </h1>
        <ol class="breadcrumb">
            <!--<li>
                <i class="fa fa-fw fa-dashboard"></i> <?/*= $this->Html->link(__("Dashboard"), ['controller' => 'users', 'action' => 'dashboard'], ['escape' => false]) */?>
            </li>-->
            <li class="active">
                <i class="fa fa-fw fa-file"></i> <?= $this->Html->link(__("Users"), ['controller' => 'users', 'action' => 'index']) ?>
            </li>
            <li class="active">
                <i class="fa"></i> <?= __('Percentage') ?>
            </li>
        </ol>
    </div>
</div>
<div class="pages form col-xs-12 content">
    <form name="frm" method="post" action="" id="frmDev">
        <input type="hidden" name="dev_business" value="1" />
    <fieldset>
        <legend><?= __('Set percentage for Coins') ?></legend>
        <?php
        echo $this->Form->input('development', ['value'=>$data['DevBusiPct'][0]]);
        echo $this->Form->input('business', ['value'=>$data['DevBusiPct'][1]]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit'), ["class"=>"btn btn-success jsSubmitDev"]) ?>
    </form><br /><br />

    <form name="frm" method="post" action="" id="frmVoter">
        <input type="hidden" name="dev_voter" value="1" />
        <fieldset>
            <legend><?= __('Set percentage for Reward') ?></legend>
            <?php
            echo $this->Form->input('developer', ['value'=>$data['DevVoterPct'][0]]);
            echo $this->Form->input('viewer', ['value'=>$data['DevVoterPct'][1]]);
            ?>
        </fieldset>
        <?= $this->Form->button(__('Submit'), ["class"=>"btn btn-success jsSubmitVote"]) ?>
    </form><br /><br />

    <form name="frm" method="post" action="" id="frmWinner">
        <input type="hidden" name="winners" value="1" />
        <fieldset>
            <legend><?= __('Set percentage for Winner') ?></legend>
            <?php
            echo $this->Form->input('winner_1', ['value'=>$data['WinnerPct'][0]]);
            echo $this->Form->input('winner_2', ['value'=>$data['WinnerPct'][1]]);
            echo $this->Form->input('winner_3', ['value'=>$data['WinnerPct'][2]]);
            ?>
        </fieldset>
        <?= $this->Form->button(__('Submit'), ["class"=>"btn btn-success jsSubmitWinner"]) ?>
    </form>
</div>
<script>

    $( "#frmDev" ).validate({
        rules: {
            development: {
                required: true,
                number: true
            },
            business: {
                required: true,
                number: true
            }
        }
    });
    $('.jsSubmitDev').click(function(){
        if( $("#frmDev").valid()){
            showLoader();
        }
    });

    $( "#frmVoter" ).validate({
        rules: {
            developer: {
                required: true,
                number: true
            },
            viewer: {
                required: true,
                number: true
            }
        }
    });
    $('.jsSubmitVote').click(function(){
        if( $("#frmVoter").valid()){
            showLoader();
        }
    });

    $( "#frmWinner" ).validate({
        rules: {
            winner_1: {
                required: true,
                number: true
            },
            winner_2: {
                required: true,
                number: true
            },
            winner_3: {
                required: true,
                number: true
            }
        }
    });
    $('.jsSubmitWinner').click(function(){
        if( $("#frmWinner").valid()){
            showLoader();
        }
    });
</script>