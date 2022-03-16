VoteController = {
    init : function() {
        this.bindClick();
    },

    bindClick: function(){
        var me = this;
        $('#jsVoteUp').on('click', function(){
			alert('up');
            me.vote('U')
        });

        $('#jsVoteDown').on('click', function(){
			alert('down');
            me.vote('D')
        });
    },

    vote: function(action){
        $.ajax({
            type: "POST",
            url: siteUrl+'backlogs/vote/',
            data: {project_id: $('#jsProjectId').val(), action: action},
            success: function(res){
                if(res > 0){
                    if(action == 'U'){
                        $('#jsUpVotes').html(res);
                    }else{
                        $('#jsDownVotes').html(res);
                    }
                }
            }
        });

    }
}.init();