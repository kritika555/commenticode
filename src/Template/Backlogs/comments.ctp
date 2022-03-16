<div class="container-fluid">
    <?php echo $this->element('project_tabs'); ?>
    <div class="row margin-top-n">
        <div class="card padding-new" style="min-height: 550px;">
            <div class="container2">
                <div class="row comment">
                    <div class="col-lg-11">
                        <div class="row">
                            <div class="col-lg-6">
                                <p class="com_own"><?=$name?></p>
                            </div>

                            <div class="col-lg-6 text-right">
                                <p><?=date('m-d-y')?></p>
                            </div>
                        </div>
                        <?php echo $this->Form->create($projectComment); ?>
                        <?=$this->Form->input('comment');?>
                        <div class="text-right">
                            <?= $this->Form->button(__('POST'), array("class" => "com_btn")) ?>
                        </div>
                        <?= $this->Form->end() ?>
                    </div>
                </div>
                <?php if(count($data) > 0) {
                    foreach($data as $row){
                    ?>
                <div class="row comment">
                    <div class="col-lg-11">
                        <div class="row">
                            <div class="col-lg-6">
                                <p class="com_own"><?=$row['user']['first_name'].' '.$row['user']['last_name']?></p>
                            </div>
                            <div class="col-lg-6 text-right">
                                <p><?=date('m-d-Y', strtotime($row['created']))?></p>
                            </div>
                        </div>
                        <p class="comm_txt text-justify"><?=nl2br($row['comment'])?></p>
                    </div>
                </div>
                <?php }
                    if ($this->Paginator->hasPage(2)) { ?>
                        <div class="paginator">
                            <ul class="pagination">
                                <?= $this->Paginator->prev('< ' . __('previous')) ?>
                                <?= $this->Paginator->numbers() ?>
                                <?= $this->Paginator->next(__('next') . ' >') ?>
                            </ul>
                        </div>
                    <?php } ?>
                <?php } else { ?>
                    <div class="alert alert-info">No comment.</div>
                <?php } ?>
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
            <!---end container-fluid-->
        </div>

    </div>
</div><!---end container-fluid-->