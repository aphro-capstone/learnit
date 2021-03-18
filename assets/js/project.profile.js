



jQuery( function($){
	$('.editprofileBtn,.saveProfileBtn').on('click',(e) =>{
		$(e.target).closest(".panel-content").toggleClass("editing");
		setAllInputEditable(  $(e.target).closest(".panel-content").hasClass('editing')  );
	});

	$('.avatar-profile-overlay').on('click',function(){
		$('.profile-avatar-main input').trigger('click')
	});
	$('.profile-avatar-main input').on('change',function(e){
		previewPhoto(e.target);
	});

	$('#savePhoto').on('click',function(){
		savePhoto();
	});

	displayInfo();
	iniCropper();
});	



var setAllInputEditable =  ( isReverse = false ) => {
	
	$('#about form input').each( function(a,b){
		$(b).prop('readonly', !isReverse);
	});
	if( !isReverse ){
		saveFields();
	}
};



var previewPhoto = (e) => {
	
	convertImagetoBase64(e.files[0], (image) => {
		console.log(image);
		 $('.profile-avatar-main .img-container img').attr('src',image);
		 $('#savePhoto').show();
	});
}



var savePhoto = function(){
	var fd = new FormData(  $('#savePhotoForm')[0] );
		fd.append('action','updatephoto');
		fd.append("attachFile", $('#savePhotoForm input')[0].files[0]);
	$.ajax({
		url: SITE_URL + '/common/profile', 
		type: 'post',
		dataType : 'json',
		processData:false,
		contentType: false ,
		async: false,
		data: fd,
		success: function(Response) {
			console.log(Response);
			if( Response.Error == null ){
				notify( 'success',Response.msg );

				$('.user-image-container').each(function(){
					console.log($(this));
					$(this).find('img').attr('src', SITE_URL + Response.path);
				});
			}
		},error:function(e){
			console.log(e.responseText);
		}
});
}

var displayInfo = function(){
	$('#about input[name="fname"]').val( ___D___.ui_firstname );
	$('#about input[name="mname"]').val( ___D___.ui_midname );
	$('#about input[name="lname"]').val( ___D___.ui_lastname );
	$('#about input[name="day_birth"]').val( ___D___.date_birth );
	$('#about input[name="email"]').val( ___D___.ui_email );

	$('#about input[name="gender"][value="'+ (___D___.gender == 0 ? 'Male' : 'Female') +'"]').prop('checked',true); 

	$('#about input[name="contact"]').val( ___D___.ui_guardian_phone );

	if( ___D___.ui_profile_data.ui_guardian_name != undefined ) 
		$('#about input[name="guardian_name"]').val( ___D___.ui_profile_data.ui_guardian_name ); 

	if( ___D___.ui_profile_data.address != undefined ) 
		$('#about input[name="addr"]').val( ___D___.ui_profile_data.address );

	if( ___D___.ui_profile_data.ui_profile_image_path != undefined) 
		$('.profile-avatar-main .img-container img').attr('src', SITE_URL +  ___D___.ui_profile_data.ui_profile_image_path );
 
}

var saveFields = function(){
 

	$.ajax({
		url: SITE_URL + 'common/profile',
		type: 'post',
		data: $('#about form').serialize() + '&action=saveProfile' ,
		success: function(R) {
			if(R == 1){
				notify('success','profile updated successfully',function(){
					window.location.reload();
				});
			}else{
				notify('error','Something went wrong. Kindly try again.');
			}
			
	   },error:function(e){
		   alert('error occured, see console.');
		   console.log(e.responseText);
	   }
   });
}

var iniCropper = function(){
	return;

	const image = document.getElementById('profimage');
	const cropper = new Cropper(image, {
		aspectRatio: 16 / 9,
		crop(event) {
			console.log(event);
				console.log(event.detail.x);
				console.log(event.detail.y);
				console.log(event.detail.width);
				console.log(event.detail.height);
				console.log(event.detail.rotate);
				console.log(event.detail.scaleX);
				console.log(event.detail.scaleY);
			},
		preview : $('.profile-avatar-main img')[0]	
	});

	console.log(cropper);
}





