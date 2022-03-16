<?php
//pr(date('Y-m-4') .'<='. date('Y-m-d', strtotime($backlog->start_date)));
$editStartDate = date('Y-m-d') <= date('Y-m-d', strtotime($backlog->start_date));
//prd($editStartDate);
?>

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
                <i class="fa fa-fw fa-file"></i> <?= $this->Html->link(__("Backlogs"), ['controller' => 'backlogs', 'action' => 'index']) ?>
            </li>
            <li class="active">
                <i class="fa"></i> <?= __($action.' Backlog') ?>
            </li>
        </ol>
    </div>
</div>
<div class="pages form col-xs-12 content">
    <?= $this->Form->create($backlog, ['enctype'=>'multipart/form-data', 'id'=>'backlog-form','type'=>'post']) ?>
    <fieldset>
        <legend><?= __($action.' Backlog') ?></legend>
        <?php
            echo $this->Form->input('title');
            echo $this->Form->input('amount', ['label'=>'Amount (AGS)']);
            echo $this->Form->input('description');
            echo $this->Form->input('start_date', ['type'=>'date', 'id'=>'datepicker', 'readonly'=>'readonly']);
            echo $this->Form->input('end_date', ['type'=>'date', 'class'=>'datepicker', 'readonly'=>'readonly']);
            echo $this->Form->input('vote_start_date', ['label'=>'Voting Start Date', 'type'=>'date', 'class'=>'datepicker', 'readonly'=>'readonly']);
            echo $this->Form->input('vote_end_date', ['label'=>'Voting End Date', 'type'=>'date', 'class'=>'datepicker', 'readonly'=>'readonly']);
            if($action == 'Add' /*|| $this->viewVars['backlog']->created_by_id == $userId*/){
                echo $this->Form->file('code_base');
            }
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit'), ["class"=>"btn btn-success jsSubmit"]) ?>
	<?= $this->Html->link('Cancel', ['controller' => 'backlogs', 'action' => 'index'], ["class"=>"btn btn-default spacer-left-10"]); ?>
    <?= $this->Form->end() ?>
</div>

<script>

    $( function() {
        /*$('.datepicker').datepicker({
            //minDate:new Date()
        });*/

        $('.jsSubmit').click(function(){
            if( $("#backlog-form").valid()){
                showLoader();
            }
        });

        $("#backlog-form").validate({
            rules: {
                title: {
                    required: true
                },
                amount: {
                    required: true,
                    positiveNumber: true,
                    ethDecimal: true
                },
                description: {
                    required: true
                },
                start_date: {
                    required: true
                },
                end_date: {
                    required: true,
                    greaterThan: "#start-date"
                },
                vote_start_date: {
                    required: true,
                    greaterThan: "#end-date"
                },
                vote_end_date: {
                    required: true,
                    greaterThan: "#vote-start-date"
                },
                code_base:{
                    required: true,
                    extension: "zip"
                }
            },
            messages: {
                end_date: {
                    greaterThan: "Submission end date must be greater than submission start date."
                },
                vote_start_date: {
                    greaterThan: "Vote start date must be greater than submission end date."
                },
                vote_end_date: {
                    greaterThan: "Vote end date must be greater than vote start date."
                },
                code_base:{
                    extension: "Only zip file is allowed."
                }
            }
        });
    } );
</script>
