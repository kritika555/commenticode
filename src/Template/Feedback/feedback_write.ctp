<div class="card padding-new" style="min-height: 550px;">
<h3>Please leave your feedback</h3>
<div class="card padding-new row">
<?php
	echo $this->Form->create($feedback); ?>
	<div class="">
	<p class="font-weight">Feedback</p>

	 <input id="star_rating" name="star_rating" class="rating rating-loading" value="0" data-min="0" data-max="5" data-step="0.5" data-size="sm"> 
	<br/> 

	<p class="font-weight">Message</p>
	<?php echo $this->Form->input('message',['rows' => '4','label'=>false]); ?>
	</div>	
	<br/> 

	<?php echo $this->Form->input('user_id', array('type'=>'hidden','value'=>$user_id));?>
	<?php echo $this->Form->button(__('Submit Feedback'), array("class" => "btn btn-danger margin-top sent-btn"));

	echo $this->Form->end();
?>
</div>
</div>

