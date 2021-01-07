

const  UPDATE_CODESTATUS_API = '/UpdateCodeStatus';

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

	$('.removebtnConfirm').on('click',function(e){
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
            			this.closest('.item').remove();;
            		}
		        },
		        close: function(){
		        }
		    }
        });
	})
  
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
