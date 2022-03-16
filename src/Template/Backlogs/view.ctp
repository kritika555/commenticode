<?php
$file = !empty($backlog->github_file) ? json_decode($backlog->github_file)->content->download_url : '';
?>

<div class="row">
	<div class="row">
		<div class="panel panel-info">
		<div class="panel-heading">Rewards</div>
		<div class="panel-body">The winner with highest votes will recieve 60% coins, the second highest votes would get 30% coins and 10% for the 3rd place. </div>
    </div>
                
    </div>
	
    <div class="card padding">
        <div class="row">
            <div class="col-lg-8 media-center"><span class="heading-new">Backlog Detail</span></div>
            <div class="col-lg-4 text-right media-center">
                <?php
                if($backlog->status == 'A') {
                    echo $this->Html->link('<i class="fas fa-plus add-depository"></i>',
                        ['controller' => 'backlogs', 'action' => 'addEditProject', $backlog->id], array('class' => '', 'title' => 'Add Solution', 'escape' => false));
                } ?>
        </div>
        <hr>
        <div class="media-center"><p class="font-weight">Title</p></div>
        <div class="shadow white project-title">
            <div class="div-padding"><?= h($backlog->title) ?></div>
        </div>
        <div class="margin-top media-center"><p class="font-weight">Description</p></div>
        <div class="shadow white description">
            <div class="div-padding1"><?= h($backlog->description) ?></div>
        </div>
        <?php 
            $repo_url = 'https://api.github.com/repos/' . $githubOwner .'/'. $backlog->backlog_repo_name . '/zipball/master'; 
         ?>
        <div class="row padding-card">
            <div class="col-lg-3">
                <span class="file-icon"><i class="fa fa-file-archive-o" aria-hidden="true"></i></span>
                <a class="btn btn-danger margin-top sent-btn" href="<?= h($repo_url) ?>" target="_self">Download File</a>
            </div>
        </div>        

        <div class="row">
            <div class="col-lg-12">
                <?= $this->Html->link(__('Back'), ['action' => 'index'], array("class" => "btn btn-default margin-top", 'title' => 'Back')) ?>
            </div>
        </div>
    </div>
</div>