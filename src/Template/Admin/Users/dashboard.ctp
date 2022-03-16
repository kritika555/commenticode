 
 <html>
 <body>
 <!-- Page Heading -->
<div class="row">
    <div class="col-xs-12">
        <h1 class="page-header text-center">
		<?= __('Welcome to website administration.') ?>
        </h1>
        <ol class="breadcrumb">
            <li>
				<i class="fa fa-fw fa-dashboard"></i> <?= $this->Html->link(__("Dashboard"), ['controller' => 'users', 'action' => 'dashboard'], ['escape' => false]) ?>
			</li>
            <li class="active">
                <i class="fa fa-fw fa-file"></i> <?= __('Dashboard') ?>
            </li>
        </ol>
    </div>
</div>
 <div class="row">  
	<div class="row">
	      <div class="col-md-2 col-sm-4 hidden-xs">
	        <div class="widget">
	          <div class="panel panel-primary">
	            <div class="panel-heading">Users</div>
	            <div class="panel-body">

	              <ul class="panel-list margin-top-1">
	                <li><i class="glyphicon glyphicon-pencil"></i>Info1</li>
	                <li><i class="fa fa-graduation-cap"></i>Info1</li>
	                <li><i class="fa fa-warning"></i>Info1</li>
	            </div>
	          </div>
	        </div>
	      </div>
	      <div class="col-md-2 col-sm-4 hidden-xs">
	        <div class="widget">
	          <div class="panel panel-primary">
	            <div class="panel-heading">Backlogs</div>
	            <div class="panel-body">

	              <ul class="panel-list margin-top-1">
	                <li><i class="glyphicon glyphicon-pencil"></i>Info2</li>
	                <li><i class="fa fa-graduation-cap"></i>Info2</li>
	                <li><i class="fa fa-warning"></i>Info2</li>
	            </div>
	          </div>
	        </div>
	      </div>
	      <div class="col-md-2 col-sm-4 hidden-xs">
	        <div class="widget">
	          <div class="panel panel-primary">
	            <div class="panel-heading">Projects</div>
	            <div class="panel-body">

	              <ul class="panel-list margin-top-1">
	                <li><i class="glyphicon glyphicon-pencil"></i>Info2</li>
	                <li><i class="fa fa-graduation-cap"></i>Info2</li>
	                <li><i class="fa fa-warning"></i>Info2</li>
	            </div>
	          </div>
	        </div>
	      </div>

	      <div class="col-md-2 col-sm-4 hidden-xs">
	        <div class="widget">
	          <div class="panel panel-primary">
	            <div class="panel-heading">Feedback</div>
	            <div class="panel-body">

	              <ul class="panel-list margin-top-1">
	                <li><i class="glyphicon glyphicon-pencil"></i>Info2</li>
	                <li><i class="fa fa-graduation-cap"></i>Info2</li>
	                <li><i class="fa fa-warning"></i>Info2</li>
	            </div>
	          </div>
	        </div>
	      </div>
    </div>
    <div class="row">
  	 <div class="col-md-2 col-sm-4 hidden-xs">
	        <div class="widget">
	          <div class="panel panel-primary">
	            <div class="panel-heading">Pending approvals</div>
	            <div class="panel-body">

	              <ul class="panel-list margin-top-1">
	                <li><i class="glyphicon glyphicon-pencil"></i>Info2</li>
	                <li><i class="fa fa-graduation-cap"></i>Info2</li>
	                <li><i class="fa fa-warning"></i>Info2</li>
	            </div>
	          </div>
	        </div>
	      </div>

     	<div class="col-md-2 col-sm-4 hidden-xs">
	        <div class="widget">
	          <div class="panel panel-primary">
	            <div class="panel-heading">Transactions</div>
	            <div class="panel-body">

	              <ul class="panel-list margin-top-1">
	                <li><i class="glyphicon glyphicon-pencil"></i>Info2</li>
	                <li><i class="fa fa-graduation-cap"></i>Info2</li>
	                <li><i class="fa fa-warning"></i>Info2</li>
	            </div>
	          </div>
	        </div>
	 	</div>

  	</div>
  	</div>

</div>
</body>
</html>