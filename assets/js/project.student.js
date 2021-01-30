jQuery( function($){


	$('.joinClassButton').on('click',() => {
		joinClass();
	});

	$('.withdrawClass').on('click',function(e){
		e.preventDefault();
		let id;
		let reload = false;
		if( $(this).attr('data-attr-id') ){
			id = $(this).attr('data-attr-id');
			reload = true;
		}else{
			id = $(this).closest('[data-id]').attr('data-id');
		}

		withdrawClass(  id ,reload  );
	});
});





var joinClass = (isRejoin = false) => {
	const classCode = $('#joinClass input[name="qrCodetext"]').val();

	if( classCode != '' ){
		const dataTosend = {  classcode : classCode, isRejoin : isRejoin };
		$.ajax({
	            url: SITE_URL +  USER_ROLE + '/joinclass',
	            type: 'post',	
	            dataType : 'json',
	            data: dataTosend,
	            success: function(Response) {

	             	if(Response.type == 'confirmation'){
	             		jConfirm(
	             				'blue',
	             				'You have withdrawn from this class,  do you wish to re-enroll ?',
	             				() => { joinClass(true); },
	             				() => { $('#joinClass').modal('hide'); }
	             		);
	             	}else{
	             		notify( Response.type, Response.msg, () => {
		             		if(Response.type == 'success'){
		             			if( window.location.pathname.indexOf('classes') > -1 ){
		             				window.location.reload();
		             			}else{
		             				window.location.href = SITE_URL + USER_ROLE + '/classes';
		             			}
		             		}
		             	});	
	             	}
	             	

	            },error:function(e){
	                notify( 'error','Error occured,  kindly contact support');
	                console.log(e.responseText);
	                $('.loading').removeClass('show');
	            }
	        });
	}else{
 		notify('error', 'Empty Class Code');
	}

	
};
// 0HwXLtPlmi

var withdrawClass = (id,returntoManagement) => {
	$.ajax({
             url: SITE_URL +  USER_ROLE + '/withdrawClass',
             type: 'post',	
             dataType : 'json',
             data: {  classID : id },
             success: function(Response) {
             	notify( Response.type, Response.msg, () => {
             		if(Response.type == 'success'){
             			if( !returntoManagement ){
             				window.location.reload();
             			}else{
             				window.location.href =  SITE_URL  + USER_ROLE +'/classes';
             			}
             			
             		}
             	});

            },error:function(e){
                notify( 'error','Error occured,  kindly contact support');
                $('.loading').removeClass('show');
            }
        });
}