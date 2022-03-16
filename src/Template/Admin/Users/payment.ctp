<?php 
//echo 'payment page';
//prd($results);
?>
<div class="row">
    <div class="col-xs-12">
        <h1 class="page-header">
            <?= __('Coin Payment for Winners') ?>
        </h1>
        <ol class="breadcrumb">
            <li>
                <i class="fa fa-fw fa-dashboard"></i> <?/*= $this->Html->link(__("Dashboard"), ['controller' => 'users', 'action' => 'dashboard'], ['escape' => false]) */?>
            </li>
           <li class="active">
                <i class="fa"></i> <?= __('Coin Payments') ?>
            </li>
        </ol>
    </div>
</div>
<div class="row">
    <div class="col-sm-2">        
      <b><?= __("Project ID") ?></b>   
      </div>
	<div class="col-sm-2">        
       <b><?= __("Project Name") ?></b>    
       
    </div>
	<div class="col-sm-1">        
           <b><?= __("Backlog ID") ?></b>
		            
    </div>
	<div class="col-sm-2">       
            <b><?= __("Backlog Title") ?></b>    
    </div>
	<div class="col-sm-1">        
           <b><?= __("User ID") ?></b>         
    </div>
	<div class="col-sm-2">        
       <b><?= __("Created") ?></b>    
    </div>
	<div class="col-sm-1">        
            <b><?= __("Total Upvotes") ?></b>          
    </div>
	<div class="col-sm-1">
			<b><?=__("Status")?></b>
	</div>
</div>
<?php foreach($results as $key) { ?>
<div class="row form-group">
   <div class="col-sm-2">        
      <?= $key['project_id']; ?>
      </div>
	<div class="col-sm-2">        
       <?= $key['project_name'];?>    
       
    </div>
	<div class="col-sm-1">        
           <?= $key['backlog_id']; ?>
		            
    </div>
	<div class="col-sm-2">       
            <?= $key['backlog_title']; ?>         
    </div>
	<div class="col-sm-1">        
          <?= $key['user_id']; ?>           
	       
    </div>
	<div class="col-sm-2">
        <?= $key['created']; ?>      
    </div>
	<div class="col-sm-1">
        
            <b><?= $key['total_upvotes']; ?></b>
          
    </div>
		<div class="col-sm-1">	    
	      <?php $editlink = 'test'; ?>
			<?php //echo $this->Html->link('PAY', ''.$edit_link.'', array('class' => 'btn btn-primary btn-icon glyphicons circle_plus'));?>
		
	</div>
	
</div>

<?php } ?> 

<script>
    
</script>
