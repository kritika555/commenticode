<div class="row">

    <div class="col-xs-12">
        <h1 class="page-header">
            <?= __('Percentage Winner') ?>
        </h1>
        
    </div>
</div>
<div class="pages form col-xs-12 content">    
    <form name="frm" method="post" action="" id="frmWinner">
        <input type="hidden" name="winners" value="1" />
        <fieldset>
            <legend><?= __('Set percentage for Winner') ?></legend>
            <?php
            echo $this->Form->input('winner1', ['value'=>$data['winner1']]);
            echo $this->Form->input('winner2', ['value'=>$data['winner2']]);
            echo $this->Form->input('winner3', ['value'=>$data['winner3']]);
            ?>
        </fieldset>
        <?= $this->Form->button(__('Submit'), ["class"=>"btn btn-success jsSubmitWinner"]) ?>
    </form>
</div>
<script>

   $( "#frmWinner" ).validate({
        rules: {
            winner1: {
                required: true,
                number: true
            },
            winner2: {
                required: true,
                number: true
            },
            winner3: {
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