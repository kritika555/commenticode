VoteController = {
    init : function() {
        this.bindClick();
    },

    bindClick: function(){
	var me = this;
        $('#jsVoteUp').on('click', function(){
          
            me.vote('U');
			 showVoteAlert('You have voted up');
        });

        $('#jsVoteDown').on('click', function(){
           //showVoteAlert('vote down');
            me.vote('D');
        });
    },

    vote: function(action){
        $.ajax({
            type: "POST",
            url: siteUrl+'backlogs/vote/',
            data: {project_id: $('#jsProjectId').val(), action: action},
            success: function(res) {
                if(res === parseInt(res, 10)){
					if(res > 0){
						if(action == 'U'){
							showVoteAlert('You have voted up');
							
							$('#jsUpVotes').html(res);
							location.reload(true);
							
						}else{
							showVoteAlert('You have voted down');
							$('#jsDownVotes').html(res);
						}
					}
				} else {
					if(res=="NA")
					{
						showVoteAlert('You cannot vote more than twice for the same project');
						
					}				
				}
				
            }
        });

    }
}.init();