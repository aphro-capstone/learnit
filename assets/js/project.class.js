

const  UPDATE_CODESTATUS_API = '/UpdateCodeStatus';
const  REMOVE_STUDENT_API = '/removeStudent';

jQuery(function($){
	$('.add-small-group').on('click',function(){
		$('#create-small-group').modal('show');
	});
	$('.code-btn').on('click',function(e){

		const code = $(this).attr('data-code');

		$(this).toggleClass('qrcodedisplay').toggleClass('btn-primary').toggleClass('btn-info');
		
		$('#share-code .code-wrapper').toggleClass('qrcodedisplay');
		
		if($(this).hasClass('qrcodedisplay')){
			$(this).html( '<i class="fa fa-code"> Text Code'  );
			createQRCode( code, $('#qrcode')[0] );
		}else{
			$(this).html(' <i class="fa fa-qrcode"></i>  QRCode ');
		}
	});

	$('.lock-btn').on('click',function(){
		$(this).toggleClass('locked btn-primary btn-warning');
		let status = 'unlocked';
		if( $(this).text().trim() == 'Lock Code' ){
			$(this).html('<i class="fa fa-unlock"></i> Unlock Code');
			status = 'locked';
		}else{
			$(this).html('<i class="fa fa-lock"></i> Lock Code');
		}

		$('.message-lock,.message-unlock').toggleClass('show');
		// $('#share-code .code-wrapper').toggleClass('qrcodedisplay');
		 setCodeStatus( status );
	});

	$('.copycode').on('click',function(){
		$(this).attr('data-original-title','Copied to clipboard');
		$(this).tooltip('hide').tooltip('show');
		let textarea = $('<textarea></textarea>');
			textarea.val( $('#code-div').text().trim() );
			// textarea.addClass('d-none');
			$('body').append(textarea);
			textarea.select();
			document.execCommand('copy');
			textarea.remove();	
		setTimeout(() => { $(this).attr('data-original-title','Copy'); $(this).tooltip('hide').tooltip('show'); }, 2500);
	});

	
	
	showMembersList();
});






const createQRCode = (text,container) => {
	$(container).html('');
	let color = '#7997E1';

	if($(container).attr('data-code-color')){
		color = $(container).attr('data-code-color');
		var c = color.substring(1);      // strip #
		var rgb = parseInt(c, 16);   // convert rrggbb to decimal
		var r = (rgb >> 16) & 0xff;  // extract red
		var g = (rgb >>  8) & 0xff;  // extract green
		var b = (rgb >>  0) & 0xff;  // extract blue
		var luma = 0.2126 * r + 0.7152 * g + 0.0722 * b; // per ITU-R BT.709

		if(luma > 230){
			color = '#7997E1';
		}
	}

	var qrcode = new QRCode( container , {
	    text: text,
	    colorDark: color,
	    // colorLight: "#ffffff",
	    logo: "../../assets/images/logo light.png"
	});
};


const setCodeStatus = (status) => {
	$.ajax({
         url: SITE_URL + USER_ROLE + UPDATE_CODESTATUS_API,
         type: 'POST',
         dataType : 'json',
         data : { classid : classID, status : status},
         success: function(R) {
         	console.log(R);
        },error:function(e){
        	console.log(e);
        	notify( 'error', e.responseText );
        }
    });
}



const updateColors = () => {
	$('.colorlist').html('');
	$.each(availableColors, (a,b)=>{
		let colorElement = $('<div class="color-item mb-2" data-id="'+ b.id +'" data-tcolor-val="'+b.tcolor+'" data-value="'+b.color+'" style="background-color:'+b.color+'"></div>');
			colorElement.on('click',function(e){
				const bcolor = $(this).attr('data-value');
				const tcolor = $(this).attr('data-tcolor-val');
				updateClassColor(  $(this).attr('data-id') );

				$('.changeable-color').each( function(k,e){
					$(e).css({'background': bcolor, 'color' : tcolor });
				} );

			});

		$('.colorlist').append(colorElement);
	});
};


var updateClassColor = (colorID) => {
	$.ajax({
			url: SITE_URL + 'teacher/UpdateCodeColor',
             type: 'post',
			 dataType : 'json',
             data: { 'classid' : classID, 'colorid' : colorID },
             success: function(Response) {
				console.log(Response);
            },error:function(e){
                console.log(e.responseText);
            }
	});
};

var showMembersList = function(find = ''){
	let tmp_members = members;
	$('#members_list .user-item').remove();

	$('#student-count').html( members.length );

	var str = '<div class="user-item item" data-user-id="169">\
				<div class="user-image img-container">\
					<img src="http://localhost/learnit/assets/images/user1.jfif">\
				</div>\
				<div class="user-info">\
					<a href="#"><span class="user-name"></span></a>\
				</div>\
				<div class="dropdown user-menu-dd">\
					<span class="mr-2" data-toggle="dropdown" aria-expanded="false"> <i class="fa fa-chevron-down"></i> </span>\
					<ul class="dropdown-menu start-from-right" style="">\
						<li> <a href="#"> <i class="fa fa-eye text-info"></i> View Progress  </a>  </li>\
						<li> <a href="#"> <i class="fa fa-key text-warning"></i> Change student\'s password  </a>  </li>\
						<li> <a href="#" class="removebtnConfirm"> <i class="fa fa-trash text-danger"></i> Remove from class</a></li>\
					</ul>\
				</div>\
			</div>';
	
	if( find != ''){
		tmp_members = tmp_members.find( (a,b) => {
			return a.studname.includes(find);
		});
	}

	if( tmp_members.length > 0 ){
		$('#members_list').removeClass('empty');
	}else{
		$('#members_list').addClass('empty');
	}

	tmp_members.forEach(m => {
		let data = JSON.parse( m.ui_profile_data );
		let aa = str;
			aa = $(aa);
		
		aa.attr('data-user-id', m.user_id);
		aa.find( '.user-image img' ).attr('src', BASE_URL + ( data.userImage == undefined ? 'assets/images/user1.jfif' : data.userImage )  );
		aa.find( '.user-info a' ).attr('href', 'http://localhost/learnit/teacher/profile/'  + m.user_id  );
		aa.find( '.user-info .user-name' ).html( m.studname );

		if( USER_ROLE != 'teacher' ){
			aa.find('.user-menu-dd').remove();
		}

		aa.find('.removebtnConfirm').on('click',function(e){
			e.preventDefault(e);
			let this_ = $(this);
			$.confirm({
				icon: 'fa fa-trash-o',
				title : 'Remove',
				content: 'are you sure you want to remove this member?',
				theme: 'modern',
				closeIcon: true,
				animation: 'scale',
				type: 'red',
				buttons: {
					p : {
						   text: 'Proceed',
						btnClass: 'btn-red',
						action : () => {
							let studid = this_.closest('[data-user-id]').attr('data-user-id');
							$.ajax({
								url: SITE_URL + USER_ROLE + REMOVE_STUDENT_API,
								type: 'POST',
								dataType : 'json',
								data : { classid : classID, studid : studid},
								success: function(R) {
									if( R.Error == null ){
										notify( 'success', R.msg );
										members = $.grep(members, function(e){ 
												return e.user_id != studid; 
										});
										showMembersList(find);
									}
							   },error:function(e){
								   console.log(e);
								   notify( 'error', e.responseText );
							   }
						   });
						}
					},
					close: function(){
					}
				}
			});
		});
		

		$('#members_list').append(aa);
	}); 


 
}

