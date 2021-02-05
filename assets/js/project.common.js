


var fileinputcontainer = null;
var tempAttachments = {};
var attachmentlist = [];

jQuery.fn.placeholdercontent = function(){ 
	// This is the element

	return this.each( function(a,b){
		let o = $(b);
		o.on('focus',() =>{
			if( o.text().trim() == o.attr('placeholder')){
				o.text( '' );
			}
		});

		o.on('blur',() =>{
			if( o.text().trim() == ''){
				o.text( o.attr('placeholder') );
			}
		});
		o.trigger('blur');
	}); 
};



jQuery( ($) => {
	 $('[data-toggle="tooltip"]').tooltip();
	 $('.datepicker').datepicker({
		format: 'mm/dd/yyyy',
		autoclose: true,
		setDate: new Date(),
		minDate: 0,
	});
	$(".datepicker").datepicker("setDate", new Date()); 
	

	$(window).on('click', (e) => {
		windowClickedCheckings(e);
	});

	//   Trigger
	$('[data-trigger]').click( (e) => {
 		data_trigger_event( e );
	});

	$('[data-toggle="collapse"]').on('click',(e) => {
			$( $(e.currentTarget).attr('data-target') ).collapse();
	});

	$('#visibletolist .item').on('click',(e) => {
		let this_ = $(e.currentTarget);

		$('#visibletolist .item.active').removeClass('active');
		this_.addClass('active');

		$('#visibletolist .radioboxinput.checked').removeClass('checked'); 
		this_.find('.radioboxinput').addClass('checked');
		this_.find('.radioboxinput input[type="radio"]').prop('checked', true);
		$('.visibletoSection .viewstatic > i:first-child').removeClass().addClass( this_.find('label i').attr('class') );
		$('.visibletoSection .viewstatic .text').text( this_.find('label .text').text() );
		$('[data-target="#visibletolist"]').trigger('click')	;
	});


	


	$('[checkplaceholder]').placeholdercontent();
	
	$('.attachfilebutton').on('click',(e) => { 
		fileinputcontainer = $(e.currentTarget).closest('.file-input-container-wrapper').find('.file-input-container');
		$('#attachFile').trigger('click');
	});

	$('#attachFile').on('input', (e) => {  
		checkFile( e.target);
	});

	

	//  Click event for js generated elements
	$(document).click( function(e){
		let target = $(e.target);
		if( target.is($('.color-picker .color-preview')) ){
			target.closest('.color-picker').toggleClass('open');
		}else{
			$('.color-picker').removeClass('open');
		}

		if(target.is( $('.color-picker .color-item') )){
			target.closest('.color-picker').find('.color-preview').css({ 'background-color' : target.attr('data-value')});
			target.closest('.color-picker').find('.color-preview').attr({ 'data-value' : target.attr('data-value')});
			target.closest('.color-picker').find('input').val( target.attr('data-id'));
			$('.color-picker').removeClass('open');
		}


		let conditions = [
						{cond : '.radioboxinput', func : radioBoxevent}, 
						{cond : '.radioboxinput-container', func : radioBoxevent}, 
						{cond : '.inputfileBtn', func : inputBtnClick}, 
						{cond : '.custom-checkbox-container', func : customCheckboxClick}, 
						{cond : '.custom-checkbox .checkbox', func : customCheckboxClick}, 
		];



		for(let x = 0 ; x < conditions.length; x++ ){
			if( target.is( $(conditions[x].cond) ) || $(conditions[x].cond).has(target).length > 0 ) {
				conditions[x].func( target );
				break;
			}	
		}
	});  

	$(document).on('change','[data-dependent-name]',function(){
		let dependentName = $(this).attr('data-dependent-name');
		let dependentKey = $(this).attr('data-dependent-key');
		let v = $(this).val();
		let i = $(this).find('option:selected').index() - 1 ;
		$('[name="'+ dependentName +'"]').hide();
		$('[name="'+ dependentName +'"] option:not([value=""])').remove();
		let jsonObject = subjects; 

		if( v ){
			let	newVals = $.grep( jsonObject,function(a,b){
							    return a.subject.id == v;
							});
				newVals = newVals[0];
				newVals = newVals[ dependentKey ];

			if(newVals.length == 0){return;}

			$('[name="'+ dependentName +'"]').show();
			newVals.forEach( ( a ) => {
				$('[name="'+ dependentName +'"]').append('<option value="'+ a.id +'">'+ a.name +'</option');
			} );
		} 


	});

	$('#prompboxnormal').on('hidden.bs.modal', function () {
	   $('#prompboxnormal .modal-dialog').removeClass('modal-lg');
	   $('#prompboxnormal .modal-dialog').removeClass('modal-sm');
	});


	$('[data-toggle="href"]').on('click',function(){
		let link = $(this).attr('href');
		let target = $(this).attr('data-target');
		if(!link){
			link = $(this).attr('data-href');
		}

		if( target){
			window.open(link,target);
		}else{
			window.location.href = link;	
		}
		
	});

	$('.stop-propagate').on('click',function(e){
		e.preventDefault();
		e.stopPropagation();
		$(this).parent().find('.dropdown-menu').toggle();
	});

	

	$('.toggleQRCodeScanner').on('click',function(){
		let cont = $(this).closest('.scantoggle-container');
			cont.find('.code-container').toggle();
			cont.find('.scanner-container').toggle();
			cont.toggleClass('scan');

		if(cont.hasClass('scan')){
			scanQRCODE();
		}
	});

	$('.search.custom-search-layout input').on('focus',function(){
        $(this).parent().addClass('focus');
    }).on('blur',function(){
        $(this).parent().removeClass('focus');
    });


    $('.data-dismiss-toggle').on('click',function(){
    	const target = $(this).attr('data-target');
    	$('.modal').modal('hide');
    	setTimeout( () => {
    		$(target).modal('show');
    	},500);
    });
    $('[data-toggle="side-popup"]').on('click',function(){
    	$(this).closest('.side-popup-container').toggleClass('show')
    });
	 
	$('.downloadable').on('click',function(e){
		doDownload( $(this) );
	});


	$('[data-toggle="tooltip"]').tooltip();

});




var doDownload = (this_) => {
	let type1__ = this_.attr('data-type'); 
	let filename =  this_.attr('data-name') ;
	var link;
	if( type1__ == 'post' ){
		var id = this_.closest('.post-panel').attr('data-post-id');
		var type2 = this_.closest('.post-panel').attr('data-id-2');
		link = SITE_URL + USER_ROLE + '/downloadfile/'+ id + '/' +type1__ + '/' + type2+ '?filename=' +  encodeURIComponent(filename);
	}else{
		var id = this_.attr('data-id');
		var type2 = this_.attr('data-id-2');
		link = SITE_URL + USER_ROLE + '/downloadfile/'+ id + '/' +type1__ + '/' + '?filename=' +  encodeURIComponent(filename);
	
	} 
	window.open(link ,'Download'); 
}


var windowClickedCheckings = (e) => {
	let arr_to_check = [];

	if( $('#main-content').hasClass('show-focused') )  arr_to_check.push('focused');
	if( $('.expanded').length > 0 ) arr_to_check.push('expanded');

	if( $(e.target).attr('id') == 'attachFile') return;

	arr_to_check.forEach( ( a ) => {
		if( a == 'focused' ){
			if(  !($(e.target).hasClass('focused-content') ||  $('.focused-content').has( $(e.target) ).length > 0 ) ){
				$('.focused-content').removeClass('focused-content');
				$('#main-content').removeClass('show-focused');
			}
		}
		if( a == 'expanded' ){

			if(  !($(e.target).hasClass('expanded') ||  $('.expanded').has( $(e.target) ).length > 0 ) ){
				$('.expanded:not(.no-popup)').removeClass('expanded'); 
			}
		}

	} );

};

var data_trigger_event = ( e ) => {
	let this_ = $(e.currentTarget),
		toTrigger = this_.attr('data-trigger'),
		toTarget = this_.attr('data-target'),
		target_classess = [],
		main_classess = [];
	

	toTrigger = toTrigger.split(',');
	

	toTrigger.forEach( (trigger) => {
		if(trigger == 'expand')  target_classess.push('expanded');
		if(trigger == 'focus'){
			target_classess.push( 'focused-content' );
			main_classess.push( 'show-focused' );
		}
	});
	
	if( toTrigger == 'href' ){
		window.location.href = toTarget;
	}

	this_.closest(toTarget).addClass( target_classess.join(' '));
	$('#main-content').addClass( main_classess  );
}



var createForms = (data,toReturn = true) => {
	//  Data params
	   // name : String			 == name of the field
	   // placeholder : String    == placeholder of the field
	   // dependent : Object     == for the dependent
	   			// key
	   			// name
	   // isdependentv 
	strToreturn = '';
	data.forEach( (bb) => { 


		let arrBB = bb;


		if(bb.constructor == Object){
			arrBB = [ bb ];
		}

		let temp = '<div class="row">';

		arrBB.forEach( (a) => {

			let width = 'col-md-' + (typeof a.width === 'undefined' ? 12 : a.width ); 
			temp += '<div class="'+width+'">';


			temp += 	 '<div class="form-group">';

			if(a.label) temp += ' <label for="staticEmail" class="col-sm-2 col-form-label">'+ a.label +'</label>';
			
			let classes_ = ['form-control'];
			let atts = [];

			if( a.isdependent ) classes_.push('isdependent');
			if( a.dependent ) atts.push( 'data-dependent-name="'+  a.dependent.name +'"' );
			if( a.dependent ) atts.push( 'data-dependent-key="'+  a.dependent.key +'"' );
			if( a.placeholder ) atts.push( 'placeholder="'+  a.placeholder +'"' );
			if( a.name ) atts.push( 'name="'+  a.name +'"' );
			if( a.attr){
				$.each( a.attr, (b,c) => {
					atts.push(b+ '="' + c +'"');
				});
			}  

			if(a.type == 'select'){
				temp += '<select name="'+ a.name +'" class="'+ classes_.join(' ') +'" '+ atts.join(' ') +'>';
				temp += '<option value="">'+ a.placeholder +'</option>';

				let v = a.value;
				for(let x = 0; x < v.length ; x++){
					let tempObject = v[x];
					if( a.key){
						tempObject = v[x][a.key]; 
					}
					temp += '<option value="'+ tempObject.id  +'">'+ tempObject.name +'</option>';
				}  
				temp += '</select>';
			}else if (a.type == 'rangeselect'){
				temp += '<select name="'+ a.name +'" class="'+ classes_.join(' ') +'" '+ atts.join(' ') +'>';
				temp += '<option value="">'+ a.placeholder +'</option>';

				let v = a.value;
				let min = 0;
				let max = 10;
				let maxRange = false;

				if( a.min )  min = a.min;
				if( a.max ){
					max = a.max;
					console.log(max);
					if(a.max.startsWith('+')){
						maxRange = true;
						max = parseInt(a.max.replace('+'));
					}
				}
				console.log(min,max);
				for(let x = min; x < max ; x++){
					temp += '<option value="'+ x +'">'+ ( x + ' - '+ x+1 ) +'</option>';
				}  
				temp += '</select>';
			}else if (a.type == 'textarea'){
				temp += '<textarea class="'+ classes_.join(' ') +'" '+ atts.join(' ') +'></textarea>';
			}else if(a.type == 'color'){
				temp += '<div class="color-picker"  '+ atts.join(' ') +'>';
				temp += '<input type="hidden" '+ atts.join(' ') +'  value="'+ ( a.value[0] ? a.value[0].id : '' ) +'">'
				temp +=	'	<div class="color d-flex"> <span>Color :</span> <span class="color-preview ml-1" style="background-color:'+ a.value[0].color +'"></span></div>';
				temp += '	<div class="color-list">';
				for(let x = 0; x < a.value.length; x++){
					temp += '<div class="color-item" data-id="'+a.value[x].id +'" data-value="'+ a.value[x].color +'" style="background-color:'+ a.value[x].color +'"></div>';
				}
								
				temp += '</div></div>';
			}else{
				temp += '<input type="'+ a.type +'" class="'+ classes_.join(' ') +'"  '+ atts.join(' ') +'>';
			}

			temp += '</div>';


			temp += '</div>';

		});

		temp += '</div>'; // endrow



		// console.log(a);
		
		strToreturn += temp;
	});

	return strToreturn;
};

var createButtons = (data,toReturn = true) => {
	strToreturn = '';
	
	data.forEach( (a) => {
		let icon = '';
		let attrs  = [];

		if(a.atts) attrs = a.atts;
		if( a.icon ) icon = '<i class="'+  a.icon + '"></i>';
		if(a.type == 'submit' || a.type == 'button'){
			strToreturn += '<button type="'+ a.type +'" class="btn ' + a.class + '" '+ attrs.join(' ') +'>' + icon + ' ' +  a.text  +'</button>';	
		}
	});

	return strToreturn;
};





var notify = (type, msg,callback,showProgress = true, time = 1000 ) => {

	if(type == 'error') type = 'danger';
	if(type == 'success') type = 'info';
	
	let json = {
		type: type,
		allow_dismiss: true,
	};

	if( time > 0 ) json['delay'] = time;
	if( showProgress )  json['showProgressbar'] =  true;
	if(callback != null || callback != undefined) json['onClose'] = callback; 

	$.notify( msg ,json );
};

var jConfirm = (type = 'red', 	msg = 'Are you sure ?', confirmCallback = ()=>{} , cancelCallback = () => { } ) => {
	$.confirm({
        icon: 'fa fa-smile-o',
        theme: 'modern',
        closeIcon: true,
        animation: 'scale',
        type: type,
        content : msg,
        buttons : {
        	confirm : confirmCallback,
        	cancel : cancelCallback
        }
    });
};



var radioBoxevent = (_this) => { 
	let radioboxinput = _this;

	if(_this.closest('.response-item') && _this.closest('.response-item').hasClass('unclickable') ) return;



	if(radioboxinput.hasClass('radioboxinput-container')){
		radioboxinput = _this.find('.radioboxinput');
	}else if ( $('.radioboxinput-container').has(_this).length > 0 ){
		radioboxinput = _this.closest('.radioboxinput-container').find('.radioboxinput');
	}else if(!radioboxinput.hasClass('radioboxinput')){
		radioboxinput = radioboxinput.closest('.radioboxinput');
	}

	let inputName = radioboxinput.find('input[type="radio"]').attr('name');

	$('[name="'+ inputName +'"]').each(function(k,e){
		$(e).prop('checked',false);
		$(e).closest('.radioboxinput').removeClass('checked'); 
		$(e).closest('.response-item').removeClass('selected');
	});

	radioboxinput.addClass('checked');
	radioboxinput.closest('.response-item').addClass('selected');

	radioboxinput.find('input[type="radio"]').prop('checked',true);
}

var inputBtnClick = (_this) => {
	let btn = _this;

	if(!btn.hasClass('inputfileBtn')){
		btn = btn.find('.inputfileBtn');
	}

	btn.parent().find('input').trigger('click');
}

var customCheckboxClick  = (_this) => {
	let btn = _this;
	
	//
	if( btn.closest('.response-item') && btn.closest('.response-item').hasClass('unclickable') ) return;

	if( $('.custom-checkbox').has(_this).length > 0 ){
		btn = _this.closest('.custom-checkbox');
	}else if( _this.hasClass('custom-checkbox-container') ){
		btn = $(_this).find('.custom-checkbox');
	}

	btn.toggleClass('checked');
	btn.closest('.response-item').toggleClass('selected');
	btn.find('input').prop('checked', !btn.find('input').prop('checked'));
}

var scanQRCODE = () => {
    scanner = new Instascan.Scanner({ video: document.getElementById('preview'), scanPeriod: 5, mirror: false });
        scanner.addListener('scan',function(content){
            $('[name="qrCodetext"]').val( content );
            $('.toggleQRCodeScanner').trigger('click');
            //window.location.href=content;
            scanner.stop();
        });
        Instascan.Camera.getCameras().then(function (cameras){
            if(cameras.length>0){
                scanner.start(cameras[0]);
                $('[name="options"]').on('change',function(){
                    if($(this).val()==1){
                        if(cameras[0]!=""){
                            scanner.start(cameras[0]);
                        }else{
                            alert('No Front camera found!');
                        }
                    }else if($(this).val()==2){
                        if(cameras[1]!=""){
                            scanner.start(cameras[1]);
                        }else{
                            alert('No Back camera found!');
                        }
                    }
                });
            }else{
                console.error('No cameras found.');
                alert('No cameras found.');
            }
        }).catch(function(e){
            console.error(e);
            alert(e);
        });
}



var checkFile = (input,style = 0,isdragdrop = false) => {
	tempAttachments = input.files; 
	let skippedFiles = [];
	let maxSize = 25; 

	const removeAttachment = (identifier) =>{
		attachmentlist.splice( attachmentlist.findIndex( a => {
					return a.key == identifier;
				}),1);

		if(isdragdrop){
			if( attachmentlist.length > 0 ){
				$('#drop-item-box .dz-message.placeholder').hide();
			}else{
				$('#drop-item-box .dz-message.placeholder').show();
			}
		}
	};
 
	$.each( input.files, (a,b) => { 

		var filesize = ((b.size/1024)/1024).toFixed(2); // MB
		if( filesize > maxSize ){
			skippedFiles.push({name: b.name, size : filesize});
			return true;
		}
		let i = attachmentlist.length; 
		let filetype = b.name.split('.');	
			filetype = filetype[ filetype.length  -  1 ];  

		let filename =  b.name.split('.');
			filename.pop();
			filename = filename.join(); 
		
		let identifier = create_UUID();
		
		attachmentlist.push({key : identifier, f : b});

		if( b.type.indexOf('image') > -1 ){
			convertImagetoBase64(b, (image) => {
				if( isdragdrop ){
					let aa = $('<div class="drag-drop-item dragdrop-img">\
								<div class="img-container"><image src="'+ image +'"></div>\
								<p class="dragdrop-file-name">'+ b.name +'</p>\
								</div>');


					let r = $('<div class="remove"><span class="m-auto">x</span></div>');
					r.on('click',function(){
						setTimeout(function(){
							aa.remove();
							removeAttachment( identifier );
						},100);
					});
					aa.append(r);
					$('#drop-item-box').append(aa);	
				}else{
					let aa = $('<div class="attachment-image-big"><div class="img-container"><image src="'+ image +'"></div></div>');
					let r = $('<div class="remove"><span class="m-auto">x</span></div>');
						r.on('click',function(){
							setTimeout(function(){
								aa.remove();
								removeAttachment( identifier );
							},100);
						});
						aa.append(r);
					fileinputcontainer.find('.images').append(aa);
				}
				
			});
		}else if (b.type.indexOf('video') > -1){
			let aa = $('<div class="attachment-video">\
							<video width="400" controls>\
								<source src="mov_bbb.mp4" id="video_here">\
								Your browser does not support HTML5 video.\
							</video>\
						</div>');

			let r = $('<div class="remove">x</div>');
				r.on('click',function(){
					setTimeout(function(){
						aa.remove();
						removeAttachment( identifier );
					},100);
				});
				aa.append(r);
				fileinputcontainer.find('.images').append(aa);

				aa.find('video source').attr('src',URL.createObjectURL(b) );
				aa.find('video')[0].load();

			
		}else{
			if( isdragdrop ){
				let aa = $('<div class="drag-drop-item drag-drop-file">\
								<div class="icon-file"> <i class="fa fa-file"></i></div>\
								<p class="dragdrop-file-name">'+ b.name +'</p>\
							</div>');
				let r = $('<div class="remove"><span class="m-auto">x</span></div>');
				r.on('click',function(){
					setTimeout(function(){
						aa.remove();
						removeAttachment( identifier );
					},100);
				});

				aa.append(r);

				$('#drop-item-box').append(aa);	

			}else{
				let aa  = new Attachment(filename, filesize+' mb', filetype, '', () => {
					removeAttachment( identifier );
				});
				fileinputcontainer.find('.files').append( aa.createAttachmentFrontend() );
			}
			
		}
	});

	if(skippedFiles.length > 0){
		skippedFiles.forEach( (a,b) => {
			notify('error','Cannot upload file : ' + a.name +', size ' + a.size +' Mb is greater than max size ' + maxSize + ' Mb.',undefined,false,5000) ;
		});
	}
};



var convertImagetoBase64 = (file,callback) => {

	var reader = new FileReader();
	reader.readAsDataURL(file);

	reader.onload = function () {
		if(typeof callback !== 'undefined'){
			callback(reader.result);
		}
	};
	reader.onerror = function (error) {
		console.log('Error: ', error);
	};
};



var getTaskDataObject = function(form){
	let dataSend = {
		tasktitle : $('[name="title"]').val(),
		instruction : $('[name="instruction"]').val(),
		otheroptions : {},
		assignIDs : form.find('select[name="assignIds"]').val(),
		due : { 
				datetime : '',
				islockondue :  form.find('[name="islockondue"]').is(':checked'),
			}
	};

	form.find('.other-option-div').each(function(a,b){
		let input = $(b).find('input');
		dataSend['otheroptions'][ input.attr('name') ] = input.is(':checked');
	});

	let date = form.find('input.datepicker').val();
	let time_h = parseInt(form.find('[name="time_h"]').val());

	if( form.find('[name="time_a"]').val() == 'pm' ) time_h+= 12;
	if(time_h == 24) time_h = '00';
	time = time_h + ':' + form.find('[name="time_m"]').val() + ':00';
	date = moment(date,'MM/DD/YYYY').format('YYYY-MM-DD') ;

	dataSend['due']['datetime'] = date + ' ' + time;

	return dataSend;
}

 


function create_UUID(){
    var dt = new Date().getTime();
    var uuid = 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function(c) {
        var r = (dt + Math.random()*16)%16 | 0;
        dt = Math.floor(dt/16);
        return (c=='x' ? r :(r&0x3|0x8)).toString(16);
    });
    return uuid;
} 