<div class="row">
    <div class="col-xs-12">
        <h1 class="page-header">
            <?= __('Set Coins') ?>
        </h1>
        <ol class="breadcrumb">
            <li>
                <i class="fa fa-fw fa-dashboard"></i> <?/*= $this->Html->link(__("Dashboard"), ['controller' => 'users', 'action' => 'dashboard'], ['escape' => false]) */?>
            </li>
            <li class="active">
                <i class="fa"></i> <?= __('Set Number of Coins') ?>
            </li>
        </ol>
    </div>
</div>
<div class="row">
    <div class="col-xs-12">
	<fieldset>
            <legend><?= __("Current Number of Coins") ?></legend>
            <?php
                echo $current_coins;  
				
            ?>
        </fieldset>
		
        <?= $this->Form->create('coins', ['class'=>'data-form']) ?>
		<input type="hidden" name="id" value="1" />	
        <fieldset>
            <legend><?= __("Set number of Coins") ?></legend>
            <?php
                echo $this->Form->input('number_coins', ['type'=>'number_coins']);  
				
            ?>
        </fieldset>
		
        <?= $this->Form->button(__('Submit'), array("class"=>"btn btn-success spacer-top-10")) ?>
        <?= $this->Form->end() ?>
    </div>
</div>
<script>
    $(document).ready(function () {
        $(".data-form").validate({
            rules: {
                number_coins: {
                    required: true,
					minlength: 2
                },                
            },           
        });
    });
</script>
