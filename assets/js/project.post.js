jQuery(($) => {
    $(document,window).on('click',function(e){
        // e.preventDefault();
        
        const target = $(e.target);

        if( target.is( $('.post-panel .comment-toggle') )){
            e.preventDefault();
            target.closest('.panel-content').find('.comments-section').toggleClass('allowcomments');
        } else if( target.is( $('.reply-comment') ) ){
            e.preventDefault(); 
            target.closest('.sub-comments').addClass('showinput');
        } 
    })

 
    
    $('#postBtn').on('click',() => {
		this.postItem();
    });
    
    $('.post-panel .attachment-element').on('click',function(e){
		if( !$(e.target).hasClass('attachment-button') ){
            displayTaskModal( $(this).closest('.post-panel').attr('data-post-id'), $(this) );
		}
    });
    
    $('.user-comment-input .text-input').on('keypress',function(e){
        // console.log(e);
        if(e.which == 13 && !e.shiftKey){
            writeComment(this,$(this).text(),$(this).closest('.post-panel').attr('data-post-id'),$(this).closest('.comment').attr('data-id') );
            $(this).html('Write a comment').trigger('focusout');
        }
    });


    

    $(document).on('click','.post-option',function(e){
        console.log(e);
        e.preventDefault();
        let action  = null;
        let id = $(this).closest('.post-panel').attr('data-post-id');
        // let jsquery = jQuery;
        let ths_ = $(this);

        let ajaxAction = function(){
            jQuery.ajax({
                url: SITE_URL + USER_ROLE + '/postAction', 
                    type: 'post',
                    dataType : 'json',
                    data: {postid : id,action : action},
                    success: function(Response) {
                        if( Response.Error == null ){
                            if( action == 1 ){
                                ths_.closest('.post-panel').remove();
                                notify('success','Post deleted successfully');
                            }else if( action == 3 ){
                                ths_.closest('.post-panel').hide().before('<div class="successful-hidden panel panel2 p-3 post-panel" data-post-id="'+ id +'">Post successfully hidden, click <span class="undo-hide post-option text-primary"> here </span> to undo action </div>');
                            }else if( action == 4 ){ 
                                notify('successful-hidden','Post showed');
                                $('.post-panel[data-post-id="'+ id +'"]').show();
                                ths_.closest('.successful-hidden').remove();
                            }
                            else if( action == 5 ){
                                notify('success','Notification Turned Off for this post');
                                ths_.replaceWith('<a href="#" class="post-option turn-off-notification"> \
                                                    <i class="fa fa-bell text-danger"></i> \
                                                        Turn off notification for this post\
                                                    </a>');
                            }
                            else if( action == 6 ){
                                notify('success','Notification Turned off for this post');
                                ths_.replaceWith('<a href="#" class="post-option turn-on-notification"> \
                                                    <i class="fa fa-bell text-info"></i> \
                                                        Turn on notification for this post\
                                                    </a>');
                            } 
                            
                        }else{
                            notify('error',Response.Error,undefined,false,3000);
                        } 
                    },error:function(e){
                        console.error(e.responseText);
                    }
            });
        };


        if( $(this).hasClass('delete-post') ) {
            action = 1
            jConfirm( 'red', 'Are you sure?',ajaxAction );
            return;
        }
        else if ( $(this).hasClass('edit-post') ) action = 2;
        else if ( $(this).hasClass('hide-post') ) action = 3;
        else if ( $(this).hasClass('undo-hide') ) action = 4;
        else if ( $(this).hasClass('turn-on-notification') ) action = 5;
        else if ( $(this).hasClass('turn-off-notification') ) action = 6;
        ajaxAction();
    });


 
 
});


var postItem = () => {
	var fd = new FormData(  $('#uploadformelement')[0] );    
		// fd.append( 'files', attachmentlist );
        fd.append( 'content', $('#yourPosts textarea').val());

        if(typeof classID !== 'undefined')  fd.append('classid', classID);
       
		for (var x = 0; x < attachmentlist.length; x++) {
			fd.append("attachFile[]", attachmentlist[x].f);
        }
        
        $.ajax({
                url: SITE_URL + USER_ROLE + '/addPost', 
                type: 'post',
                dataType : 'json',
                processData:false,
                contentType: false ,
                async: false,
                data: fd,
                success: function(Response) {
                    console.log(Response);
                    if( Response.Error == null ){ 
                        $(document).trigger('click');

                        $('#posts').prepend($(Response.newpost));

                        $('#yourPosts textarea').val('');
                        attachmentlist = [];
                    }else{
                        notify('error',Response.Error);
                    }
                    
                    attachmentlist = [];
                },error:function(e){
                    console.log(e.responseText);
                }
        });
};



const getPosts = () => {
    
}
 
const writeComment = (this_,value,postID,commentID) => {
    let data = {
            postid : postID,
            commentID : commentID,
            content : { t : value }
    };

    $.ajax({
        url: SITE_URL + USER_ROLE + '/addComment', 
         type: 'post',
         data: data,
         success: function(Response) {
            if( commentID == undefined ){
                $(this_).closest('.comments-section').find('.comments-list').append(Response);
            }else{
                $(this_).closest('.comment').find('.sub-comments').append(Response);
            }
        },error:function(e){
            console.log(e.responseText);
            alert('error found.  see console');
        }
    });
}


const displayTaskModal = (postID,this_) =>{
    
    const post = posts.find(x => x.p_id === postID); 
    let viewLink = '';

    const modal = $('#taskInstruction');
          modal.find('.title').html( post.tsk_title );
          modal.find('.due-date').html( moment(post.tsk_duedate).format('MMMM D, YYYY') ); 
          modal.find('.instructions').html( post.tsk_instruction.replace(/\n\r?/g, '<br />') ); 

    if(  post.tsk_type == 1){
        modal.find('.ass-info').show();
        modal.find('.quiz-info').hide();

        viewLink = 'assignment/assignment:';
    }else{
        modal.find('.quiz-info').show();
        modal.find('.ass-info').hide();
        modal.find('.question-count').html( post.quiz_count );
        modal.find('.total-points').html( post.total_point )
        modal.find('.duration').text( post.duration );
        viewLink = 'quiz/quiz:'; 
    }

    if(USER_ROLE == 'teacher'){
        $('.view-quiz-teacher').attr('href', SITE_URL + 'teacher/classes/' + viewLink+ post.tsk_id );
    }else if(USER_ROLE == 'student'){

        let ID = post.quiz_id;
        let str = 'Quiz';
        if(ID == undefined) {
            ID = post.ass_id;
            str = 'Assignment';
        }

       
        $('.view-quiz-result-student').attr('href', SITE_URL + 'student/' + 'quiz/view:'+ ID ); 

        $('.take-quiz-student').attr('href', SITE_URL + 'student/' + viewLink+ ID ); 
        $('.view-assignment-student').attr('href', SITE_URL + 'student/' + viewLink+ ID ); 
        $('.take-quiz-student').text('Take ' + str);


        if( post.submissionCount != undefined && post.submissionCount  > 0 ){
            $('.take-quiz-student').hide();
            $('.take-quiz-student').hide();
        }else{
            $('.view-quiz-result-student').hide(); 
            $('.view-assignment-student').hide();
            $('.take-quiz-student').show();
            modal.find('.hasTaken').html('');
        }


    }
    
    $('#taskInstruction').modal('show');
};