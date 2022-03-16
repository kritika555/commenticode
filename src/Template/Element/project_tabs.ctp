<?php

$action = $this->request->params['action'];
$projectTab = $action == 'viewProject' ? 'active_tab' : '';
$collaboration = $action == 'collaboration' ? 'active_tab' : '';
$comments = $action == 'comments' ? 'active_tab' : '';
$today = date('Y-m-d');

$backlog_id = $this->request->params['pass']['0'];

$stDate = date('Y-m-d', strtotime($backlog->vote_start_date));
$edDate = date('Y-m-d', strtotime($backlog->vote_end_date));
$allowVote = ($stDate <= $today && $edDate >= $today);

?>
<div class="row">
    <?php if($allowVote!=1){?>
  <div class="well well-sm" style="background-color:#FFFACD;">
  Voting end date has been passed. You are not allowed to vote.
</div>
    <?php } ?>
    <div class="col-lg-8 col-md-4 col-sm-4 text-left m_tabs">
        <ul class="tab-list" id="myDIV">
            <?= $this->Html->link(__('<li class="'.$projectTab.'"><i class="fa fa-bars" aria-hidden="true"></i>'.$project->name.'</li>'),
                ['controller' => 'backlogs', 'action' => 'viewProject', $project->backlog_id, $project->id], ['escape' => false]) ?>
            <?php /*= $this->Html->link(__('<li class="'.$collaboration.'"><i class="fa fa-users" aria-hidden="true"></i>Collaboration</li>'),
                ['controller' => 'backlogs', 'action' => 'collaboration', $project->backlog_id, $project->id], ['escape' => false]) */ ?>
            <?= $this->Html->link(__('<li class="'.$comments.'"><i class="fa fa-commenting-o" aria-hidden="true"></i>Comments</li>'),
                ['controller' => 'backlogs', 'action' => 'comments', $project->backlog_id, $project->id], ['escape' => false]) ?>
        </ul>
    </div>
    <div class="col-lg-4 text-right">
        <button class="voting-button" id="<?=$allowVote ? 'jsVoteUp' : ''?>"><span style="color:#189100;"><i
                    class="fa fa-long-arrow-up"></i>Vote</span><span id="jsUpVotes" style="margin-left: 13px;"><?= $project->up_vote ?></span></button>

        <button class="voting-button1" id="<?=$allowVote ? 'jsVoteDown' : ''?>"><span style="color:#f61a1a;"><i class="fa fa-long-arrow-down"></i>Vote</span><span
                style="margin-left: 13px;" id="jsDownVotes"><?= $project->down_vote ?></span></button>
    </div>
</div>
<input type="hidden" id="jsProjectId" value="<?=$project->id?>" />