<div class="row">
    <div class="col-xs-12">
        <h1 class="page-header">
            <?= __('Settings') ?>
        </h1>
        <ol class="breadcrumb">
            <!--<li>
                <i class="fa fa-fw fa-dashboard"></i> <?/*= $this->Html->link(__("Dashboard"), ['controller' => 'users', 'action' => 'dashboard'], ['escape' => false]) */?>
            </li>-->
            <li class="active">
                <i class="fa fa-cog"></i> <?= $this->Html->link(__("Settings"), ['controller' => 'configurations', 'action' => 'index']) ?>
            </li>
            <li class="active">
                <i class="fa"></i> <?= __($action.' Setting') ?>
            </li>
        </ol>
    </div>
</div>
<div class="row">
    <div class="col-xs-12">
        <?= $this->Form->create($configuration, ['id'=>'frm']) ?>
        <fieldset>
            <legend><?= __($action.' Configuration "'.$configuration->conf_key.'"') ?></legend>
            <?php
            echo $this->Form->input('title', ['readonly'=>true]);
            echo $this->Form->input('conf_value',['label'=>'Value']);
            ?>
        </fieldset>

        <?= $this->Form->button(__('Submit'), ["class"=>"btn btn-success jsSubmit"]) ?>
        <?= $this->Html->link('Cancel', ['controller' => 'configurations', 'action' => 'index'], ["class"=>"btn btn-default spacer-left-10"]); ?>
        <?= $this->Form->end() ?>
    </div>
</div>

<script>
$( function() {
    $('.jsSubmit').click(function(){
        if( $("#frm").valid()){
            showLoader();
        }
    });

    $("#frm").validate({
        rules: {
            conf_value: {
                required: true
            }
        }
    });
});
</script>
