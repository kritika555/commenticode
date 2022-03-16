<div class="container-fluid">
    <?php echo $this->element('project_tabs');
    $arrows = '';
    ?>
    <div class="row">
        <div class="card padding-new" style="min-height: 550px;">
            <div class="row collaboration">
                <div class="col-lg-4">
                    <div class="task">
                        <div class="row">
                            <div class="col-lg-6">To Do</div>
                            <div class="col-lg-6 text-right">
                                <i class="fas fa-plus add-depository" data-toggle="modal" data-target="#taskModal"></i>
                            </div>
                        </div>
                        <div class="jsNew">
                        <?php if(isset($tasks['New'])){
                        foreach($tasks['New'] as $task){ ?>
                        <div class="mov_card">
                            <p><?=$task['task']?></p>
                            <p class="move_arr text-center">
                                <a data-id="<?=$task['id']?>" href="javascript: void(0);" class="jsMoveLeft"><i class="fa fa-arrow-circle-left" aria-hidden="true"></i></a>
                                <a data-id="<?=$task['id']?>" href="javascript: void(0);" class="jsMoveRight"><i class="fa fa-arrow-circle-right" aria-hidden="true"></i></a></p>
                        </div>
                        <?php }} ?>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="task">
                        <div>Doing</div>
                        <div class="jsDoing">
                        <?php if(isset($tasks['Doing'])){
                            foreach($tasks['Doing'] as $task){ ?>
                                <div class="mov_card">
                                    <p><?=$task['task']?></p>
                                    <p class="move_arr text-center">
                                        <a data-id="<?=$task['id']?>" href="javascript: void(0);" class="jsMoveLeft"><i class="fa fa-arrow-circle-left" aria-hidden="true"></i></a>
                                        <a data-id="<?=$task['id']?>" href="javascript: void(0);" class="jsMoveRight"><i class="fa fa-arrow-circle-right" aria-hidden="true"></i></a></p>
                                </div>
                            <?php }} ?>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="task">
                        <div>Done</div>
                        <div class="jsDone">
                        <?php if(isset($tasks['Done'])){
                            foreach($tasks['Done'] as $task){ ?>
                                <div class="mov_card">
                                    <p><?=$task['task']?></p>
                                    <p class="move_arr text-center">
                                        <a data-id="<?=$task['id']?>" href="javascript: void(0);" class="jsMoveLeft"><i class="fa fa-arrow-circle-left" aria-hidden="true"></i></a>
                                        <a data-id="<?=$task['id']?>" href="javascript: void(0);" class="jsMoveRight"><i class="fa fa-arrow-circle-right" aria-hidden="true"></i></a></p>
                                </div>
                            <?php }} ?>
                        </div>
                    </div>
                </div>
            </div><!---end row-->
        </div><!----end card-->
    </div>
</div><!---end container-fluid-->
<input type="hidden" id="jsProjectId" value="<?=$id?>" />


