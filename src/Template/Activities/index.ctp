<div class="card padding-new" style="min-height: 550px;">
    <div class="row">
        <div class="col-md-1 padding-left"><span class="heading-new"></span></div>
        <div class="col-md-7 text-center">
            <div class="row border tab-set">
                <div class="col-md-3 tabs-btn border1 <?=$type=='projects'?'active-tabs':''?>"><?php echo $this->Html->link('My Projects', ['controller' => 'activities', 'action' => 'index', 'projects']); ?></div>
                <div class="col-md-3 tabs-btn border1 <?=$type=='comments'?'active-tabs-3':''?>"><?php echo $this->Html->link('Comments', ['controller' => 'activities', 'action' => 'index', 'comments']); ?></div>
                <div class="col-md-3 tabs-btn border1 <?=$type=='votes'?'active-tabs-3':''?>"><?php echo $this->Html->link('Votes', ['controller' => 'activities', 'action' => 'index', 'votes']); ?></div>
                <div class="col-md-3 tabs-btn"><?php echo $this->Html->link('Pending Backlogs', ['controller' => 'activities', 'action' => 'pendingBacklog']); ?></div>
            </div>
        </div>
        <div class="col-md-4 text-center">
            <?= $this->Form->create('', ['type' => 'get', 'class' => 'search-form']);
            $this->Form->templates([
                'inputContainer' => '{{content}}'
            ]); ?>
            <?php echo $this->Form->input('title', ['label' => false, 'value' => $this->request->query('title'), 'placeholder'=>'Search...']); ?>
            <?= $this->Form->button(__('<i class="fa fa-search"></i>'), ["class" => ""]) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
    <hr />
    <div id="London" class="tabcontent">
        <div class="content table-responsive table-full-width">
            <?php if (count($data)) { ?>
            <table class="table table-striped">
                <thead>
                <th>Project</th>
                <th>Date</th>
                <th>Backlogs</th>
            <?php if($type == 'votes'): ?>
                <th>Vote</th>
            <?php endif; ?>
              <?php /*  <th>Status</th> */?>
                <th>Detail</th>
                </thead>
                <tbody>
                <?php foreach ($data as $row): ?>
                <tr>
                    <td><?= h($row->name) ?></td>
                    <td><?= date('m/d/Y', strtotime($row->created)) ?></td>
                    <td><?= h($row->backlog->title) ?></td>
                <?php if($type == 'votes'): ?>
                    <td><?=$votes[$row->id] == 'U' ? '<i class="fas fa-arrow-up arrow-margin green"></i> Upvote'
                            : '<i class="fas fa-arrow-down arrow-margin red"></i> Downvote'?></td>
                <?php endif; ?>
                  <?php
                  $doing = false;
                  if($row->backlog->bc_status == 1){
                      $doing = true;
                  }

                  /*  <td>
                        <?php
 $today = date('Y-m-d');
                        if($row->backlog->start_date <= $today && $row->backlog->end_date >= $today){
                            echo 'Doing';
                            $doing = true;
                        }elseif($row->backlog->end_date <= $today && $row->backlog->vote_end_date >= $today){
                            echo 'Done';
                        }elseif($row->backlog->vote_end_date < $today){
                            echo 'Close';
                        }
                        ?>
                    </td> */ ?>
                    <td>
                        <?php
                        if($type == 'comments'){
                            $action = ['controller' => 'backlogs', 'action' => 'comments', $row->backlog->id, $row->id];
                        }else{
                            $action = ['controller' => 'backlogs', 'action' => 'view-project', $row->backlog->id, $row->id];
                        }

                        ?>
                        <?= $this->Html->link(__('View'), $action, array("class" => "icon icon-view", 'alt' => 'View', 'title' => 'View')) ?>
                        <?php
                        if($type == 'projects' && $userId == $row->created_by_id && $doing){
                            echo ' | '. $this->Html->link(__('Edit'), ['controller'=>'backlogs', 'action' => 'addEditProject', $row->backlog->id, $row->id], array("class" => "icon icon-edit", 'alt' => 'Edit', 'title' => 'Edit'));
                        } ?>
                    </td>
                </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
                <?php  if ($this->Paginator->hasPage(2)) { ?>
                    <div class="paginator">
                        <ul class="pagination">
                            <?= $this->Paginator->prev('< ' . __('previous')) ?>
                            <?= $this->Paginator->numbers() ?>
                            <?= $this->Paginator->next(__('next') . ' >') ?>
                        </ul>
                    </div>
                <?php } ?>
            <?php } else { ?>
                <div class="alert alert-info">No record available.</div>
            <?php } ?>
        </div>
    </div>
</div><!----end card-->
</div>