
<div class="card padding-new" style="min-height: 550px;">
<div class="row">
    <div class="col-md-1 align text-center">
        <?php if(isset($userRole) && $userRole == 'A'){ ?>
        <?php echo $this->Html->link('<i class="fas fa-plus add-depository"></i>',
            ['controller' => 'backlogs', 'action' => 'addEdit'], array('class' => '', 'title' => 'Add New Backlog', 'escape' => false)); ?>
        <?php }else{ ?>
        <a class="" href="javascript:void(0);" data-toggle="modal" data-target="#backlogsLeftModal">
            <i class="fas fa-plus add-depository"></i>
        </a>
        <?php } ?>
    </div>

    <div class="col-md-3 media-center">
        <div class="dropdown">
            <button onclick="myFunction()" class="dropbtn"><?=ucfirst($filter)?> Backlogs<i class="fa fa-caret-down caret-margin" aria-hidden="true"></i></button>
            <div id="myDropdown" class="dropdown-content">
                <?php echo $this->Html->link('All Backlogs', ['controller' => 'backlogs', 'action' => 'index']); ?>
                <?php echo $this->Html->link('My backlogs', ['controller' => 'backlogs', 'action' => 'index', 'my']); ?>
            </div>
        </div>
    </div>
    <div class="col-md-4 text-center">
        <div class="row border tab-set">
            <div class="col-md-4 tabs-btn <?=$type=='doing'?'active-tabs':''?>"><?php echo $this->Html->link('Doing', ['controller' => 'backlogs', 'action' => 'index', $filter, 'doing']); ?></div>
            <div class="col-md-4 tabs-btn border1 <?=$type=='done'?'active-tabs-3':''?>"><?php echo $this->Html->link('Done', ['controller' => 'backlogs', 'action' => 'index', $filter, 'done']); ?></div>
            <div class="col-md-4 tabs-btn <?=$type=='close'?'active-tabs-2':''?>"><?php echo $this->Html->link('Close', ['controller' => 'backlogs', 'action' => 'index', $filter, 'close']); ?></div>
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

<div class="row margin-top">
    <div class="content table-responsive table-full-width">
        <?php if (count($backlogs)) { ?>
        <table class="table table-striped">
            <thead>
            <th><?= $this->Paginator->sort('title', ['label'=>'Backlog Name']) ?></th>
            <th>Username</th>
            <th><?= $this->Paginator->sort('amount') ?></th>
            <?php if($type == 'doing'){ ?>
                <th><?= $this->Paginator->sort('start_date') ?></th>
            <?php }?>
            <?php if($type == 'doing' || $type == 'close'){ ?>
                <th><?= $this->Paginator->sort('end_date') ?></th>
            <?php }?>
			
            <?php if($type == 'done'){ ?>
                <th><?= $this->Paginator->sort('vote_start_date') ?></th>
                <th><?= $this->Paginator->sort('vote_end_date') ?></th>
            <?php }?>
            <?php if($type == 'done' || $type == 'close'){ ?>
                <th>Submissions</th>
            <?php }?>
            <?php if($type == 'close'){ ?>
                <td>Winners</td>
            <?php }?>
			 <th class="actions"><?= __('Status') ?></th>
            <th class="actions"><?= __('Detail') ?></th>
            </thead>
            <tbody>
            <?php foreach ($backlogs as $backlog):
                $totalSubmissions = count($backlog->projects);
                ?>
                <tr>
                    <td><?= h($backlog->title) ?></td>
                    <td><?= h($backlog->created_by->username) ?></td>
                    <!--<td><?= h($commonComponent->formatToken2($backlog->amount)) ?></td>-->
					<td><?= $backlog->amount ?></td>
                    <?php if($type == 'doing'){ ?>
                        <td><?= h($backlog->start_date) ?></td>
                    <?php }?>
                <?php if($type == 'doing' || $type == 'close'){ ?>
                    <?php /*<td>[ <?= $this->Html->link($totalSubmissions, ['action' => 'projects', $backlog->id], array('title' => 'Total Projects')) ?> ]</td>*/?>
                    <td><?= h($backlog->end_date) ?></td>
                <?php }?>
                <?php if($type == 'done'){ ?>
                    <td><?= h($backlog->vote_start_date) ?></td>
                    <td><?= h($backlog->vote_end_date) ?></td>
                <?php }?>
                <?php //if($type == 'done' || $type == 'close'){
                    if($totalSubmissions >= 3){
                        $color = 'green';
                        $title = 'Three or more submissions.';
                    }elseif($totalSubmissions == 2){
                        $color = 'yellow';
                        $title = 'Two submissions.';
                    }elseif($totalSubmissions == 1){
                        $color = 'orange';
                        $title = 'Only one submission.';
                    }else{
                        $color = 'red';
                        $title = 'No submission.';
                    }
                    ?>
                    <td><span title="<?=$title?>"><i class="fa fa-circle color-<?=$color?>" aria-hidden="true"></i></td>
                <?php // }?>
                <?php if($type == 'close'){
                        if(isset($winners[$backlog->id])){
                            $content = '<ol class="modal-list">';
                            foreach($winners[$backlog->id] as $winner){
                                $content .= '<li>'.$winner.'</li>';
                            }
                            $content .= '</ol>';
                        }else{
                            $content = 'Winners will be announced on '.$nextReleaseDate.'.';
                        }

                    ?>
                    <td><a class="jsWinners" href="javascript:void(0);" data-toggle="modal" data-target="#winnersModal"
                           data-content='<?=$content?>'>Winners</a></td>
                <?php } ?>
					<td>
					<?php if($backlog->status=='A'){?>
						<span style="color:green">Approved</span>
					<?php }
					else if($backlog->status=='P'){ ?>
					<span style="color:blue;font-style:bold">Pending</span>
					<?php }else { ?>
					<span style="color:red">Rejected</span>
					<?php }				
					
					?>	
					</td>
                    <td class="actions">
                        <?php
                        if($type == 'doing'){
                            $action = ['action' => 'view', $backlog->id];
                        }else{
                            $action = ['action' => 'projects', $backlog->id];
                        }
                        ?>
                        <?= $this->Html->link(__('View'), $action, array("class" => "icon icon-view", 'alt' => 'View', 'title' => 'View')) ?>
                        <?php
                        if($userId == $backlog->created_by_id && $type == 'doing' && $backlog->status == 'P'){
                            echo ' | '. $this->Html->link(__('Edit'), ['action' => 'addEdit', $backlog->id], array("class" => "icon icon-edit", 'alt' => 'Edit', 'title' => 'Edit'));
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
</div>


<script>
    /* When the user clicks on the button,
     toggle between hiding and showing the dropdown content */
    function myFunction() {
        document.getElementById("myDropdown").classList.toggle("show");
    }

    // Close the dropdown if the user clicks outside of it
    window.onclick = function(event) {
        if (!event.target.matches('.dropbtn') && (!event.target.matches('.dropbtn i'))) {

            var dropdowns = document.getElementsByClassName("dropdown-content");
            var i;
            for (i = 0; i < dropdowns.length; i++) {
                var openDropdown = dropdowns[i];
                if (openDropdown.classList.contains('show')) {
                    openDropdown.classList.remove('show');
                }
            }
        }
    }
    $(function(){
       $('.jsWinners').click(function(){
            $('#jsWinnersContent').html($( this ).data( "content" ));
       });
    });
</script>
