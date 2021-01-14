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


    
	$('.delete-post').on('click',function(e){
		e.preventDefault();
        let id = $(this).closest('.post-panel').attr('data-post-id');
        // let jsquery = jQuery;

		jQuery.ajax({
            url: SITE_URL + USER_ROLE + '/delPost', 
                type: 'post',
                dataType : 'json',
                data: {postid : id},
                success: function(Response) {
                    console.log(Response);
                    if( Response.Error == null ){
                        notify('success','Post deleted successfully');
                    }else{
                        notify('error',Response.Error,undefined,false,3000);
                    } 
                },error:function(e){
                    console.error(e.responseText);
                }
        });
		// jConfirm( 'red', 'Are you sure?',function(){ doajax2(); } );
    });
    
});


var postItem = () => {
	var fd = new FormData(  $('#uploadformelement')[0] );    
		// fd.append( 'files', attachmentlist );
        fd.append( 'content', $('#yourPosts textarea').val());

        if(typeof classID !== 'undefined')  fd.append('classid', classID);
       

		for (var x = 0; x < attachmentlist.length; x++) {
			fd.append("attachFile[]", attachmentlist[x]);
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

        if(ID == undefined) ID = post.ass_id;

       

        $('.view-quiz-result-student').attr('href', SITE_URL + 'student/' + 'quiz/view:'+ ID ); 

        $('.take-quiz-student').attr('href', SITE_URL + 'student/' + viewLink+ ID ); 
        $('.view-assignment-student').attr('href', SITE_URL + 'student/' + viewLink+ ID ); 
        
        if( post.student_sub_count != undefined && post.student_sub_count  > 0 ){
            $('.take-quiz-student').hide();
        }else{
            $('.take-quiz-student').show();
        }


    }
    
    $('#taskInstruction').modal('show');
};