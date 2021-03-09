activeMessageID = null;
var lastSenderid = 1;
jQuery( ($) => {

    $('[name="search_messages"]').on('focus',() => {
        $('#left-div .conversations').removeClass('show');
        $('#left-div .contacts').addClass('show');
        
        showFriendList( $('[name="search_messages"]').val() );
    }).on('blur',() => {
        // $('#left-div .conversations').addClass('show');
        // $('#left-div .contacts').removeClass('show');
    });

    $(window).on('resize',function(){
        iniHeights();
    })
    iniHeights();
   

    $('[name="inputmsg"]').on('keypress',function(e){
        var keyCode = e.keyCode || e.which;
        if(keyCode === 13){
            e.preventDefault();
           
            inputMessage( e.target.value );
            $(this).val('');
            return false;
        }
    });

    iniMessage();
});



var iniHeights = () => {
    let winheight = window.innerHeight;
    let nav = $('header')[0].offsetHeight;
    let leftheading = $('#left-div .heading')[0].offsetHeight;
    let leftcontenttop = $('#left-div .search-message')[0].offsetHeight;
    let leftcontent = (winheight  - (nav + leftheading + leftcontenttop)) + 'px';
    let rightheading = $('#conversation-div .heading')[0].offsetHeight;
    let rightfooter = $('#conversation-div .footer')[0].offsetHeight;
    let rightcontent = (winheight - ( nav + rightheading + rightfooter)) + 'px';


    $('#left-div .conversations').css('height', leftcontent);
    $('#left-div .contacts').css('height', leftcontent);
    $('#conversation-div .conversation-content').css('height', rightcontent);
    
};


var iniMessage = () => {
    getChats();
}


var inputMessage = (msg) => {
    let displayedMsg = displayMessages(msg,true,true);
    $.ajax({
        url: SITE_URL + USER_ROLE + '/messages',
        type: 'POST',
        data : { action : 'sendM', msg : msg, cg : activeMessageID,replyFrom : null},
        dataType: 'json',
        success: function(R) {
            console.log(R); 
            displayedMsg.attr('data-id',R.msg);
       },error:function(e){
           console.log(e);
           notify( 'error', e.responseText );
       }
   });
}

var showFriendList = (name) => {
    let ff = f; 
    $('.contacts .contact-item').remove();

    let str = '<div class="contact-item" data-user-id> <div class="img-container convo-image"><img src=""></div> <div class="contactname"></div> </div>';



    if( name != '' ){
        ff.find( (a) => { 
            return a.friend_name.toLowerCase().includes( name );
        });
    }
   
    ff.forEach( fff => {
        let d = JSON.parse(fff.ui_profile_data);
        let ss = $(str);
            ss.attr('data-user-id', fff.user_id);
            ss.find('img').attr('src', BASE_URL +  ( d.userImage != undefined ? d.userImage : 'assets/images/avatars/user2.png'  ) );
            ss.find('.contactname').html( fff.friend_name );
            $('.contacts').append(ss);
            ss.on('click',function(){
                $('#left-div .conversations').addClass('show');
                $('#left-div .contacts').removeClass('show');
                getMessages(fff, $(this).attr('data-user-id')  );
            }); 
    });     


    
}

var getChats = () => {
    var displayChats = function(chats){
        str = '<div class="convo-item">\
                    <div class="img-container contact-image">\
                        <img src="'+ BASE_URL +'assets/images/avatars/user2.png">\
                    </div>\
                    <div class="convoname">\
                        <span class="convo-name d-block"> Jesther Gonzales </span>\
                        <div class="conversion-msg"> <span class="msg"> </span> <i class="separator"></i> <span class="timestamp">  </span> </div>\
                    </div>\
                    <div class="dropdown option">\
                        <span data-toggle="dropdown"> <i class="fa fa-ellipsis-h"></i></span>\
                        <ul class="dropdown-menu no-wrap" >\
                            <li> <a href="#"> <i class="fa fa-volume-off text-primary"></I> Mute </a></li>\
                            <hr class="mt-1 mb-1">\
                            <li> <a href="#"> <i class="fa fa-eye-slash text-info"></i> Hide </a></li>\
                            <li> <a href="#"> <i class="fa fa-trash text-danger" ></i> Delete </a></li>\
                            <li> <a href="#"> <i class="fa fa-envelope text-info"></i> Mark as unread </a></li>\
                        </ul>\
                    </div>\
                </div>';
        

        $('.conversations').html();
        chats.forEach( (c,i) => { 
            let msgContent = JSON.parse( c.msg_content );
            let d = JSON.parse(c.otherMember.ui_profile_data);
            let aa = $(str);
                aa.find('.conversion-msg .msg').html( (c.sender == UCI ? 'You : ' : '') + msgContent.c );
                aa.find('.timestamp').html(getDateDifference( new Date(c.timestamp), new Date() ));
                aa.find('.convo-name').text(c.otherMember.friend_name);
                if( d.userImage != undefined ){
                    aa.find('img').attr('src', BASE_URL +   d.userImage );
                }

                aa.on('click',function(){
                    if( aa.hasClass('active')) return;

                    aa.siblings().removeClass('active');
                    aa.addClass('active');
                    getMessages(c.otherMember,c.otherMember.user_id);
                });

            $('.conversations').html(aa);

            if(i == 0 ) aa.trigger('click');
        });
    }

    
    $.ajax({
        url: SITE_URL + USER_ROLE + '/messages',
        type: 'POST',
        data : { action : 'getC'},
        dataType: 'json',
        success: function(R) {
            console.log(R);
            displayChats( R );
       },error:function(e){
           notify( 'error', e.responseText );
       }
   });
}

var displayMessages = (msgs,isReturn = false,isincomplete = false) => {
    let str = '<div class="msg-item new-msg">\
        <div class="user-img img-container img-circular">\
            <img src="http://localhost/learnit/assets/images/avatars/user2.png" alt="">\
        </div>\
        <div class="msg-content">\
            <div class="content" data-toggle="tooltip" data-placement="top" data-original-title="10:31 AM"> Hey </div>\
            <div class="actions">\
                <div class="reaction-div d-flex">\
                    <div class="reactions">\
                        <div class="">\
                            <div class="reaction-item reaction-like "></div>\
                            <div class="reaction-item reaction-love "></div>\
                            <div class="reaction-item reaction-haha "></div>\
                            <div class="reaction-item reaction-wow "></div>\
                            <div class="reaction-item reaction-sad "></div>\
                            <div class="reaction-item reaction-angry "></div>\
                        </div>\
                    </div>\
                    <span class="icon reaction-trigger"> <i class="fa fa-smile-o"></i> </span>\
                </div>\
                <span class="icon"> <i class="fa fa-reply"></i> </span>\
                <div class="dropdown more">\
                    <span data-toggle="dropdown" class="icon"> <i class="fa fa-ellipsis-h" data-toggle="tooltip" data-placement="bottom" data-original-title="More"></i>\  </span>\
                    <ul class="dropdown-menu no-wrap normal-padding-dd">\
                        <li> <a href="#"> <i class="fa fa-tr`ash text-danger"></i> Remove </a></li>\
                    </ul>\
                </div>\
            </div>\
        </div>\
        </div>';

    if( isReturn ){
        let aa = $(str); 
        aa.addClass('sender-msg');
        aa.find('.user-img').remove();
        aa.find('.content').html(msgs).attr('data-original-title',moment().format('h:mm a'));
        if( lastSenderid == UCI ){
            aa.addClass('continueous-msg');
        }

        $('.conversation-content').append( aa  );
        $('[data-toggle="tooltip"]').tooltip();
        lastSenderid = UCI;
        $('.conversation-content').animate({
            scrollTop: document.querySelector('.conversation-content').scrollHeight
        }, 300);
        return aa;
    }else{
        msgs.forEach(e => {
            let aa = $(str);  
    
            aa.addClass( e.sender == UCI ? 'sender-msg' : 'receiver-msg' );
            if( e.sender == UCI ){
                aa.find('.user-img').remove();
            } 
    
            if( lastSenderid == e.sender ){
                aa.addClass('continueous-msg');
            }
    
            aa.attr('data-id',e.msg);
            aa.find('.content').html(e.content.c).attr('data-original-title',moment(e.datetime).format('h:mm a'));
    
            $('.conversation-content').append( aa  );
            lastSenderid = e.sender;
        });
        $('[data-toggle="tooltip"]').tooltip();
        $('.conversation-content').animate({
            scrollTop: document.querySelector('.conversation-content').scrollHeight
        }, 300);
    } 
}

var getMessages = (fff,userid) => { 
    let d = JSON.parse(fff.ui_profile_data);
    let div = $('#conversation-div');

        div.find('.heading .name').html( fff.friend_name );
        div.find('.heading img').attr('src', BASE_URL + ( d.userImage != undefined ? d.userImage : 'assets/images/avatars/user2.png'  ) );
        $('.conversation-content').addClass('loading-convo')
        $('.conversation-content .msg-item').remove();

     

    $.ajax({
        url: SITE_URL + USER_ROLE + '/messages',
        type: 'POST',
        data : { action : 'getCM', userid : userid},
         dataType: 'json',
        success: function(R) {
            displayMessages( R.msgs );
            activeMessageID = R.cg_id;
       },error:function(e){
           console.log(e);
           notify( 'error', e.responseText );
       }
   });
}