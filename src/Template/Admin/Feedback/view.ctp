
<nav class="col-xs-12 side-nav" id="actions-sidebar">
    <h2 class="heading"><?= __('Actions') ?></h2>
    <ul class="side-nav">        
        <li><?= $this->Form->postLink(__('Delete Page'), ['action' => 'delete', $feedback->id], ['confirm' => __('Are you sure you want to delete # {0}?', $feedback->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Pages'), ['action' => 'index']) ?> </li>        
    </ul>
</nav>
<div class="pages view col-xs-12 content">
    <h3><?= h($feedback->id) ?></h3>
<table class="table vertical-table">
    <tr>
    <th colspan="3"><h1>Feedback Details</h1></th>
    </tr>
    <tr>      
       <th><?= __('ID') ?></th>
       <td><?= h($feedback->id) ?></td>
    </tr>
    <tr>
        <th><?= __('Message') ?></th>
        <td><?= h($feedback->message) ?></td>
    </tr>
	<tr>
        <th><?= __('Star Rating') ?></th>
        <td><input disabled id="star_rating" name="star_rating" class="rating rating-loading" value="<?php echo $feedback->star_rating;?>" data-min="0" data-max="5" data-step="0.5" data-size="xs"> 
							</td>
    </tr>
    <tr>
        <th><?= __('Username') ?></th>
        <td><?= h($users[$feedback->user_id]) ?></td>
    </tr>
        
    
     <tr>
        <td colspan="3" align="center"> <?= $this->Html->link('Back', ['controller' => 'Feedback','action' => 'index']) ?></td>       
    </tr>
</table>

</div>