<div class="row">
    <div class="col-xs-12">
        <h1 class="page-header">
            <?= __('Account') ?>
        </h1>
        <ol class="breadcrumb">
            <li>
                <i class="fa fa-fw fa-dashboard"></i> <?/*= $this->Html->link(__("Dashboard"), ['controller' => 'users', 'action' => 'dashboard'], ['escape' => false]) ?>
            </li>-->
            <li class="active">
                <i class="fa fa-fw fa-file"></i> <?= $this->Html->link(__("Users"), ['controller' => 'users', 'action' => 'index']) ?>
            </li>
            <li class="active">
                <i class="fa"></i> <?= __('Account') ?>
            </li>
        </ol>
    </div>
</div>
<div class="pages form col-xs-12 content">
    <?php /*= $this->Form->create($data, []) */?>
    <fieldset>
        <legend><?= __('Account') ?></legend>
        <?php
        echo $this->Form->input('total_coin', ['value'=>$data['balance'], 'label'=>['text'=>'Initial Supply <a href="https://etherscan.io/token/0xD37A4D18bd742fa03b164d9D824c3D36e23a9eB0" target="_blank">Click</a>', 'escape'=>false], 'readonly'=>true]);
        
        echo $this->Form->input('business_coin', ['value'=>$data['ags_balance_business'],'label'=>['text'=>'Business Coin <a href="https://etherscan.io/address/0xD37A4D18bd742fa03b164d9D824c3D36e23a9eB0" target="_blank">Click</a>', 'escape'=>false], 'readonly'=>true]);
        
		echo $this->Form->input('ether_balance_business', ['value'=>$data['ether_balance_business'],'label'=>['text'=>'ETH (Business)<a href="https://etherscan.io/address/0xD37A4D18bd742fa03b164d9D824c3D36e23a9eB0" target="_blank">Click</a>', 'escape'=>false], 'readonly'=>true]);
		
        echo $this->Form->input('development_coin', ['value'=>$data['ags_balance_dev'],'label'=>['text'=>'Development Coin <a href="https://etherscan.io/address/0xD37A4D18bd742fa03b164d9D824c3D36e23a9eB0" target="_blank">Click</a>', 'escape'=>false], 'readonly'=>true]);
        
        echo $this->Form->input('ether_balance_dev', ['value'=>$data['ether_balance_dev'],'label'=>['text'=>'ETH (Development)<a href="https://etherscan.io/address/0xD37A4D18bd742fa03b164d9D824c3D36e23a9eB0" target="_blank">Click</a>', 'escape'=>false], 'readonly'=>true]);

        
        
        echo $this->Form->input('reserved_coin', ['value'=>$data['total_reserved'], 'readonly'=>true]);
        echo $this->Form->input('remaining_tokens', ['value'=>$data['remaining_tokens'], 'readonly'=>true]);
        ?>
    </fieldset>

</div>
