TaskController = {
    init : function() {
        this.showHideArrows();
        this.bindClick();
        var me = this;
        $('#jsAddTask').on('click', function(){
            var task = $('#jsProjectTask').val();
            $.ajax({
                type: "POST",
                url: siteUrl+'backlogs/saveTask/',
                data: {project_id: $('#jsProjectId').val(), task: task},
                success: function(res){
                    $('.jsNew').prepend('<div class="mov_card"><p>'+task+'</p>' +
                    '<p class="move_arr text-center">' +
                    '<a data-id="'+res+'" href="javascript: void(0);" class="jsMoveLeft"><i class="fa fa-arrow-circle-left" aria-hidden="true"></i></a>' +
                    '<a data-id="'+res+'" href="javascript: void(0);" class="jsMoveRight"><i class="fa fa-arrow-circle-right" aria-hidden="true"></i></a>' +
                    '</p></div>');
                    $('#taskModal').modal('hide');
                    $('#jsProjectTask').val('');
                    me.bindClick();
                    me.showHideArrows();
                }
            });
        });
    },

    bindClick: function(){
        var me = this;
        $('.jsNew .jsMoveRight').off('click');
        $('.jsNew .jsMoveRight').on('click', function(){
            me.changeStatus(this, 'Doing')
        });

        $('.jsDoing .jsMoveLeft').off('click');
        $('.jsDoing .jsMoveLeft').on('click', function(){
            me.changeStatus(this, 'New')
        });

        $('.jsDoing .jsMoveRight').off('click');
        $('.jsDoing .jsMoveRight').on('click', function(){
            me.changeStatus(this, 'Done')
        });

        $('.jsDone .jsMoveLeft').off('click');
        $('.jsDone .jsMoveLeft').on('click', function(){
            me.changeStatus(this, 'Doing')
        });
    },

    changeStatus: function(me, target){
        var id = $(me).data("id"),
            task = $(me).parent().parent();
        task.prependTo('.js'+target);
        this.showHideArrows();
        this.bindClick();

        $.ajax({
            type: "POST",
            url: siteUrl+'backlogs/setTaskStatus/',
            data: {id: id, status: target},
            success: function(){}
        });

    },
    showHideArrows: function(){
        $('.jsMoveLeft, .jsMoveRight').show();
        $('.jsNew .jsMoveLeft').hide();
        $('.jsDone .jsMoveRight').hide();
    }

}.init();