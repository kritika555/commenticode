<?php
prd('feedback');
?>

<div class="row">
	<h2 class="heading">Feedback Page</h2>
	<div class="row">
		<div class="col-md-1 align text-center">
		   Your Feedback
		</div>
	</div>
	
	 <?php echo $this->Form->create($feedback, ['id'=>'feedback-form']);
        $this->Form->templates([
            'inputContainer' => '{{content}}'
        ]);
        ?>
        <div class="row">
            <p class="font-weight">Message</p>
            <div class="shadow white project-title">
                <?=$this->Form->input('message', ['label'=>false]);?>
            </div>
        </div>
		
		<div class="col-lg-3">
                <?= $this->Form->button(__('Submit'), array("class" => "btn btn-danger margin-top sent-btn")) ?>
            </div>

</div>