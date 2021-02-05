let upload = undefined;
jQuery( ($) => {
	$('[data-toggle="tooltip"]').tooltip();
	$('.nav-toggle').on('click',function(){
		$('body > .container-wrapper').toggleClass('opennav');
	});



	$('.addForms').on('submit',function(e){
		e.preventDefault();
		let data = $(this).serialize();
		let action = $(this).attr('action');
		$.ajax({
             url: action,
             type: 'post',
             dataType : 'json',
             data: data,
             success: function(Response) {
             	if(Response.type == 'success'){
             		$('.modal').modal('hide');
             	}

             	notify( Response.type, Response.msg, () => {
             		window.location.reload();
             	});

            },error:function(e){
                console.log(e.responseText);
            }
        });

	});

	$('.removeItem').on('click',function(e){
		e.preventDefault();
		let key = $(this).closest('tr').attr('data-key');
		let val = $(this).closest('tr').attr('data-id');
		let setting = $(this).closest('[data-table]').attr('data-table');
		$.ajax({
             url: domainOrigin + '/admin/delete',
             type: 'post',
             dataType : 'json',
             data: { key : key, value : val, setting : setting },
             success: function(Response) {
             	notify( Response.type, Response.msg, () => {
             		window.location.reload();
             	});

            },error:function(e){
                console.log(e.responseText);
            }
        });
	});

	$('.modal').on('hidden.bs.modal',function(e){
		$(this).find('form').trigger('reset');
		$(this).find('form [name]:not(.noresettrigger)').each( (a,b) => {
			if($(b).attr('data-reset')){
				$(b).val( $(b).attr('data-reset') );
				$(b).find('option[value="' + $(b).attr('data-reset') + '"]').click();
			}else{
				$(b).val('');	
			}
		});
	});

	$('.editItem').on('click',function(e){
		e.preventDefault();

		let modal = $( $(this).closest('[data-modal]').attr('data-modal') );
		let dtr = $(this).closest('.data-row');
		modal.modal('show');

		dtr.find('[data-ref]').each( (a,b) => {
			let bb = $(b);
			let el = modal.find('[name="' + bb.attr('data-ref') + '"]');
			// console.log(bb.attr('data-ref'),bb.attr('data-ref-val'));
			if( bb.hasClass('notdirecttext')){
				let aa = bb.find('.gettext');
				if( $(aa).attr('data-original-title')){
					el.val( $(aa).attr('data-original-title') );
				}else{
					el.val( $(aa).text().trim());
				}
			}else if( bb.attr('data-ref-val') ){
				el.val( bb.attr('data-ref-val') );
			}else{
				el.val( bb.text().trim() );	
			}
		});
		

	});

	$('.toggle-subsubjects').on('click',function(){
		const id = $(this).closest('tr').toggleClass('open').attr('data-id');

		if( $(this).closest('tr').hasClass('open')){
			$(this).text('Hide Sub-subjects');
		}else{
			$(this).text('Show Sub-subjects');
		}

		$('.data-subsubject.visible:not([data-parent-id="'+ id +'"])').removeClass('visible');
		$('.data-subsubject[data-parent-id="'+ id +'"]').toggleClass('visible');

	});

	$('#uploadMultimedia button.select-file-upload').on('click',function(){
		$('#uploadMultimedia input[type="file"]').trigger('click');
	});
	$('#uploadMultimedia input[type="file"]').on('change',function(){
		previewUploadVid();
	});
	$('#uploadMultimedia .clearupload').on('click',function(){
		$('#uploadMultimedia input[type="file"]').val('');
		$('#uploadMultimedia .uploadshow').html('');
	});
	$('#uploadMultimedia .modal-footer button[type="submit"]').on('click',function(e){
		e.preventDefault();
		let allow = true;
		if( $('#uploadMultimedia input[name="title"]').val().trim() == '' ){  notify('error','No title provided',undefined,false); allow = false;}
		if( $('#uploadMultimedia textarea[name="desc"]').val().trim() == '' ){  notify('error','No description provided',undefined,false); allow = false;}
		if( $('#uploadMultimedia input[name="multimedia"]').val() == ''  ){  notify('error','No video selected',undefined,false); allow = false;}

		if( !allow ) return;

		$('#uploadMultimedia form').ajaxSubmit({
			beforeSubmit : function(formData, formObject, formOption){
				formData.push({ name: "size", required: false,type: "text",value: upload.s }); 
			},
			beforeSend : function(){
				 $('#uploadMultimedia').modal('hide');

				let template = '<div id="uploading-notif" data-notify="container" class="col-xs-11 col-sm-3 alert alert-{0}" role="alert">' +
						'<button type="button" aria-hidden="true" class="close" data-notify="dismiss"><i class="fa fa-times"></i></button>' +
						'<span data-notify="icon"></span> ' +
						'<span data-notify="title">{1}</span> ' +
						'<span data-notify="message">{2} <strong>( <span class="percent"></span> )</strong></span>' +
						'<div class="progress" data-notify="progressbar">' +
							'<div class="progress-bar progress-bar-striped progress-bar-animated progress-bar-{0}" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>' +
						'</div>' +
						'<a href="{3}" target="{4}" data-notify="url"></a>' +
					'</div>';

				$('[data-target="#uploadMultimedia"]').prop('disabled',true);
				 notify( 'success', 'Uploading Video',undefined,true,0,template);
			},uploadProgress : function(event,position,total,percentComplete){
				$('#uploading-notif .percent').text( percentComplete + '%' );
				$('#uploading-notif .progress-bar').css('width',(percentComplete + '%') );
				if(percentComplete == 100){
					setTimeout( () => {
						$('#uploading-notif').each( function(){
							$(this).remove();
						});
						$('[data-target="#uploadMultimedia"]').prop('disabled',false);
					},1000);
				}
			},success : function(r){
				r = JSON.parse(r);  
				 
				if( r.Error == null ){
					notify( 'success', r.msg,undefined,false );
					multimedias.push(r.data);
					createMultimediaTR(r.data,true);
				}else{
					notify('error', r.Error,undefined,false);
				}
			}, 
		});

	});

	$('#playModal').on('hidden.bs.modal',function(){
		$(this).find('video')[0].pause();
		$(this).find('video').attr('src','');
	});
	$('#uploadMultimedia').on('hidden.bs.modal',function(){
		$(this).find('form').trigger('reset');
		$(this).find('.uploadshow').html('');
	});
	

	showTables();

	$('.dataTable-container table').DataTable();  
});


var notify = (type, msg,callback,showProgress = true, time = 1000,template ) => {
	
	if(type == 'error') type = 'danger';
	if(type == 'success') type = 'info';
	
	let json = {
		type: type,
		allow_dismiss: true,
	};

	if( time > -1 ) json['delay'] = time;
	if( showProgress )  json['showProgressbar'] =  true;
	if(callback != null || callback != undefined) json['onClose'] = callback; 
	
	if( template != undefined ) json['template'] = template;

	$.notify( { message :  msg } ,json );
};

var checkadminPass = function(callback,action,did){
	this.apiCheckadminpass = function(d){ 
		return new Promise( function(resolve, reject){
			$.ajax({
				url: domainOrigin + '/admin/checkAdmin',
				type: 'post',
				data : { data : d,action:action, did:did },
				success: function(r) {  
					resolve( r );
				},error:function(e){
					reject(e);
				}
			});
		});
	}

	$.confirm({
		title: 'Enter Admin password ',
		type : 'orange',
		content: '<div class="form-group">\
					<input autofocus="" type="password" placeholder="" class="form-control">\
					</div>',
		buttons: {
			sayMyName: {
				text: 'Get Credentials',
				btnClass: 'btn-orange',
				action: function(){
					var input = this.$content.find('[type="password"]');
					var errorText = this.$content.find('.text-danger');
					if(!input.val().trim()){
						$.alert({
							content: "Password cannot be empty",
							type: 'red'
						});
						return false;
					}else{
						let success = false;
						apiCheckadminpass( input.val().trim() ).then(r => {
							r = JSON.parse(r);
							if( r.Error == null){
								callback( r.data ); 
							}else{
								$.alert({
									content: "Wrong admin pasword",
									type: 'red'
								});
							}
						}, e => {
							$.alert({
								content: "An error had occured, check internet connection or contact support",
								type: 'red'
							}); 
						});
					}
				}
			},
			close : function(){

			}
		}
	});


	
}
 
var showTables = function( table = '' ){
	if(page != 'datatables') return; 
	this.countStud = 0;
	this.countTeacher= 0;
	this.tables = { studtable : $('#studtable tbody'), teachertable : $('#teachertable tbody'), classtable : $('#classtable tbody') };
	let i = this; 
	let availableteacherList = [];

	this.getCredentials = function(v,d){
		console.log('getCredentials',v,d);
		$.confirm({
			title: 'User Credentials',
			type : 'blue',
			icon : 'fa fa-smile',
			content: '<dl>\
						<dt> Name : </dt>\
						<dd>'+ v.name  +'</dd>\
						<dt>Email : </dt>\
						<dd>'+ v.ui_email +'</dd>\
						<dt>Username : </dt>\
						<dd>'+ d.uname +'</dd>\
						<dt>Password : </dt>\
						<dd>'+ d.pass +'</dd>\
					</dl>', 
		});
	};
	
	this.reassignClass = function(val,id){

	};

	this.createTeacherStudTR = (v,appendTo) => {
		let el = $('<tr> <td></td> <td></td> <td></td><td class="text-center"></td> <td class="text-center"></td><td class="text-center position-relative"></td><td ></td><td class="text-center"></td> </tr>');
		let appstatus = v.application_status;
		let status = '-';

		if( appstatus == 1 )  appstatus = 'Pending';
		else if( appstatus == 2 ){
			appstatus = 'Approved';
			status = 'Active';
		}
		else if( appstatus == 3 )  appstatus = 'Pending';





		el.find('td').eq(0).text( v.user_id );	
		el.find('td').eq(1).text( v.name );	
		el.find('td').eq(2).text( v.ui_email );	
		el.find('td').eq(3).text( status );	
		el.find('td').eq(4).text( appstatus );	
		el.find('td').eq(5).html( v.classes.length  );
	
	 
		if( v.classes.length > 0 ){
			let viewClasses = $('<span class="btn btn-xs btn-primary pull-right tooltip-trigger"> <i class="fa fa-info"></i> </span>')
			let allClasses = $('<ul class="all-classes custom-tooltip"></ul>');
			v.classes.forEach( ee => {
				allClasses.append('<li>'+ ee.class_name +'</li>');
			});

			viewClasses.append( allClasses );
	
			el.find('td').eq(5).append( viewClasses );
		}
			



		el.find('td').eq(6).text( moment( v.timestamp_created ).format('MMM DD, YYYY H:mm:ss a') );	
		 
		credbtn = $('<button class="btn btn-xs btn-info btn-3d"> <i	class="fa fa-lock"> </i> Login Creds </button>');
		viewallinfo = $('<button class="btn btn-xs btn-danger ml-1 btn-3d"> <i class="fa fa-edit"></i> Change Status </button>');

		credbtn.on('click',function(){
			checkadminPass( (d) => {
				i.getCredentials( v ,d );
			}, 'credentials', v.user_id );
		});


		el.find('td').eq(7).append( credbtn);	 
		el.find('td').eq(7).append( viewallinfo);	 


		appendTo.append(el); 
	};

	this.createClassListTR = (v) =>{
		this.el = $(  '<tr>\
							<td></td>\
							<td></td>\
							<td class="text-center"></td>\
							<td class="text-center"></td>\
							<td class="text-center"></td>\
							<td class="text-center"></td>\
							<td class="teacher-td"></td>\
							<td class="text-center"></td>\
							<td></td>\
							<td class="text-center"></td>\
						</tr>' ); 


		el.find('td').eq(0).text( v.class_id );	
		el.find('td').eq(1).text( v.class_name );	
		el.find('td').eq(2).text( v.class_status );	
		el.find('td').eq(3).text( v.class_code );	
		el.find('td').eq(4).text( v.code_status );	
		el.find('td').eq(5).text( v.s_y );	
		
		el.find('td').eq(7).text( v.studentcount );	
		el.find('td').eq(8).html( moment(v.class_created).format('MMM DD, YYYY H:mm:ss a')  );


		changestatusBtn = $('<button class="btn btn-danger btn-xs btn-3d" > <i class="fa fa-edit"></i> Change Class status </button>');
		reassignbtn = $('<button class="btn btn-warning btn-xs btn-3d mr-1" > <i class="fa fa-edit"></i> <span>Reassign</span> </button>');
		
		let select = $('<select class="select select2"></select>');
		availableteacherList.forEach(  (tl) => {
			select.append('<option value="'+ tl.id +'"> '+ tl.name +' </option>');
		});

		select.select2();

		el.find('td').eq(6).html( select );

		reassignbtn.on('click',function(){
			let td = $(this).closest('tr').find('td').eq(6);
			if( $(this).text().trim() == 'Save New Assignment' ){
				$(this).find('span').text('Reassign');
				

				let val = td.find('select').val();
				td.find('select').remove();
				td.find('.select2-container').remove();
				td.removeClass('activeEdit');



			}else{
				$(this).find('span').text('Save New Assignment');
				td.addClass('activeEdit').append(select);
				
				
			}
			

			
		});

		el.find('td').eq(9).append(reassignbtn);
		el.find('td').eq(9).append(changestatusBtn);

		i.tables.classtable.append( el );
	};

	users.forEach(el => {
		if(el.role == 'teacher') {
			i.createTeacherStudTR( el,i.tables.teachertable ); 
			availableteacherList.push( { id : el.user_id,name: el.name, stat : el.application_status } );
		}
		else  i.createTeacherStudTR ( el,i.tables.studtable );
	});

	classlist.forEach(el => { 
		createClassListTR(el);
	}); 
 
	
}

createMultimediaTR = function(el,additional = false){ 
	let str = $('<tr>\
						<td class="text-center"></td>\
						<td></td>\
						<td></td>\
						<td class="text-center"></td>\
						<td></td>\
						<td class="text-center"></td>\
				</tr>');

	str.find('td').eq(0).html(el.m_id);
	str.find('td').eq(1).html(el.m_title);
	str.find('td').eq(2).html(el.m_desc);
	str.find('td').eq(3).html(el.size);
	str.find('td').eq(4).html( moment( el.datetime_created ).format('MMM DD, YYYY H:mm:s a') );

	playbtn = $('<button class="btn btn-xs btn-3d btn-info mr-1 ml-1"> <i class="fa fa-play"></i> Play </button>');
	delBtn = $('<button class="btn btn-xs btn-3d btn-danger mr-1 ml-1 "> <i class="fa fa-trash"></i> Delete </button>');

	delBtn.on('click',function(){
		$.confirm({
			title: 'Are you sure ?',
			type : 'red',
			icon : 'fa fa-trash',
			buttons: {
				confirm: function () {
					$.ajax({
						url: domainOrigin + 'admin/removeMultimedia',
						type: 'post',
						dataType : 'json',
						data: {id : el.m_id,path : el.m_path},
						success: function(R) {
							if( R.Error == null){

								let dTable = $('#multimediatable').DataTable();
									dTable.row( str ).remove().draw(); 

								let i = multimedias.findIndex( (a,b) => {
										return a.m_id == el.m_id;
								});

								multimedias.splice(i,1);	 
								notify( 'success', R.msg,undefined,false);
							}else{
								notify( 'error', R.Error,undefined,false);
							}
					   },error:function(e){
						   console.log(e.responseText);
					   }
				   });
				},
				cancel: function () {  }
			}
		});  
		
	});

	playbtn.on('click',function(){
		$('#playModal video').attr('src', ( domainOrigin + el.m_path  ));
		$('#playModal').modal('show');
	});

	str.find('td').eq(5).append(playbtn);
	str.find('td').eq(5).append(delBtn);



	if( additional ){
		$('#multimediatable').DataTable().row.add(str).draw();
	}else{
		$('#multimediatable tbody').append( str );
	}
};

var showMultimedia = function(){
	if( page != 'multimedia' ) return; 
 

	$('#multimediatable tbody').html('');
	multimedias.forEach( (el,k) => {
		createMultimediaTR(el);
	} );

}

var previewUploadVid = function(){
	let input = $('#uploadMultimedia input[type="file"]')[0];
	upload = undefined;	
	let file = input.files;
		 file = file[0];
		 
	if( file ){

		
		$('.select-file-upload span').text('Change file');
		
		var filesize = ((file.size/1024)/1024).toFixed(2); // MB
 
		if( filesize > 1024 ){
			notify('error','Cannot upload videos greater than 1Gb');
			$('#uploadMultimedia input[type="file"]').val('');
			$('#uploadMultimedia .uploadshow').html('');
			return;
		}

		let filetype = file.name.split('.');
			fileext	 = filetype[ filetype.length  -  1 ]; 	
			
			filetype = file.type.split('/');
			filetype = filetype[0];  
			 

		let filename =  file.name.split('.');
			filename.pop();
			filename = filename.join();
		
		upload = { s : (filesize + 'Mb'), f : file }; 
 
		if( filetype == 'video' ){
			 
			let aa = $('<div class="attachment-video">\
				<video class="full-width" controls>\
					<source src="mov_bbb.mp4" id="video_here">\
					Your browser does not support HTML5 video.\
				</video>\
			</div>');
			$('#uploadMultimedia .uploadshow').html( aa ); 

			aa.find('video source').attr('src',URL.createObjectURL(file) );
			aa.find('video')[0].load(); 
		}
		
	}else{
		$('.select-file-upload span').text('Select upload file');
	}
}