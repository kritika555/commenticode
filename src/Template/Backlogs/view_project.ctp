<div class="container-fluid">
    <?php echo $this->element('project_tabs');?>
	
    <div class="row margin-top-n">
    <div class="card padding-new" style="min-height: 550px;">
        <div class="row">
		 <div class="col-md-12 padding-left media-center"><span class="heading-new">testcase3</span></div><br>
            <div class="padding-card"><p class="font-weight">Solution - <?= h($project->name) ?></p>
                <div class="shadow white description">
                    <div rows="10" cols="50" readonly="readonly"><?= h($project->description) ?></div>
                </div>
            </div>
        </div><!---end row-->

        <?php 
         //$repo_name = Configure::read('githubOwner') ."addBacklog/$id/$token/$jwtToken";
         $repo_url = 'https://api.github.com/repos/' . $githubOwner .'/'. $project->repo_name . '/zipball/master'; 

         ?>
        <div class="row padding-card">
            <div class="col-lg-3">
                <span class="file-icon"><i class="fa fa-file-archive-o" aria-hidden="true"></i></span>
                <a class="btn btn-danger margin-top sent-btn" href="<?= h($repo_url) ?>" target="_blank">Download File</a>
            </div>
        </div>
        <div class="row padding-card">
            <div class="col-lg-12">
                <?php
                if($backAction == 'projects'){
                    $redirect = ['action' => 'projects', $backlogId];
                }else{
                    $redirect = ['controller'=>'activities', 'action' => 'index'];
                }
                ?>
                <?= $this->Html->link(__('Back'), $redirect, array("class" => "btn btn-default margin-top", 'title' => 'Back')) ?>
            </div>
        </div>
    </div><!----end card-->

</div>