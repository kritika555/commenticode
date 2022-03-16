<div class="row">
    <div class="card padding">
        <div><span class="heading-new">Create a new Backlog</span></div>
        <hr>
        <?php echo $this->Form->create($backlog, ['enctype'=>'multipart/form-data', 'id'=>'backlog-form']);
        $this->Form->templates([
            'inputContainer' => '{{content}}'
        ]);
        ?>
        <div class="">
            <p class="font-weight">Title</p>
            <div class="shadow white project-title">
                <?=$this->Form->input('title', ['label'=>false]);?>
            </div>
        </div>
		 <div class="">
            <p class="font-weight">Repository Name</p>
            <div class="shadow white project-title">
                <?=$this->Form->input('repository_name', ['label'=>false]);?>
            </div>
        </div>
        <div class="margin-top">
            <p class="font-weight">Description</p>
            <div class="shadow white description">
                <?=$this->Form->input('description', ['label'=>false]);?>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-3">
                <div class="attach-file margin-top"><?=$this->Form->file('code_base');?></div>
            </div>
            <div class="col-lg-3">
                <?= $this->Form->button(__('Send for approval'), array("class" => "btn btn-danger margin-top sent-btn")) ?>
            </div>
        </div>

    </div>
</div>