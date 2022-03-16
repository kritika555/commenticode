<?php

?>
<div class="row">
    <div class="card padding">
        <div><span class="heading-new">Add Solution</span></div>
        <hr>
        <?php echo $this->Form->create($project, ['enctype'=>'multipart/form-data', 'id'=>'form-data']);
        $this->Form->templates([
            'inputContainer' => '{{content}}'
        ]);
        ?>
        <div class="">
            <p class="font-weight">Project Name</p>
            <div class="shadow white project-title">
                <? echo $this->Form->input('name', ['label'=>false]);?>
            </div>
        </div>
        <div class="margin-top"><p class="font-weight">Solution</p>
            <div class="shadow white description">
                <?=$this->Form->input('description', ['label'=>false]);?>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-3">
                <div class="attach-file margin-top"><?=$this->Form->file('code_base');?></div>
                <?php
                if(isset($project->github_file) && !empty($project->github_file)){
                    $file = json_decode($project->github_file); ?>
                    <div class=""><a href="<?=$file->content->download_url?>" target="_blank" title="Download File"><?=$file->content->name?></div>
                <?php
                }
                ?>
            </div>
            <div class="col-lg-3">
                <?= $this->Form->button(__('Submit'), array("class" => "btn btn-danger margin-top sent-btn")) ?>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <?php if(isset($project->id)){
                    echo $this->Html->link(__('Back'), ['controller' => 'activities'], array("class" => "btn btn-default margin-top", 'title' => 'Back'));
                }else{
                    echo $this->Html->link(__('Back'), ['action' => 'view', $backlogId], array("class" => "btn btn-default margin-top", 'title' => 'Back'));
                } ?>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
$(document).ready(function () {
    $("#form-data").validate({
        rules: {
            name: {
                required: true
            },
            description: {
                required: true
            },
            code_base:{
                <?php if(!isset($project->github_file) || empty($project->github_file)){ ?>
                required: f,
                <?php }?>
                extension: "zip"
            }
        },
        messages: {
            code_base:{
                extension: "Only zip file is allowed."
            }
        }
    });
});
</script>