activeFolder = 0;

activefolderArrs = [{  key : 0, name : 'Folders'}];

jQuery(function(){
	$('.clickableFolder').on('click',function(e){
		$('#folder-panel1').hide();
		$('#folder-panel2').show();
	});
	$('.returnFolder').on('click',function(e){
		
		activefolderArrs.splice( activefolderArrs.length -1, 1 ); 
		activeFolder = activefolderArrs[ activefolderArrs.length - 1 ].key;
		
		$('#folder-panel1 .foldername').text( activefolderArrs[ activefolderArrs.length - 1 ].name );
		
		getFoldercontent();
	});

	$('.folder-panel .search input').on('focus',function(){
        $(this).parent().addClass('focus');
    }).on('blur',function(){
        $(this).parent().removeClass('focus');
    });


    $('.folder-details').on('click',function(){
    	$(this).toggleClass('selected');
	});
	
	$('#Addfolder').on('hidden.bs.modal',function(){
		$(this).find('input').val('');
	});


	$('.btnaddfolder').on('click',function(){
		let foldername = $('#Addfolder input[name="foldername"]').val();
		$.ajax({
			url : SITE_URL + 'teacher/folder',
			type : 'post',
			data : { action : 'addfolder',  foldername : foldername , parent : activeFolder },
			dataType : 'json',
			success: function(r){  
				if( r.Error == null){
					notify('success', r.msg); 
					$('.modal').modal('hide');
					getFoldercontent();
				}else{
					notify('error',r.Error);
				}
			},
			error : function(r){
				console.error(r);
			}
		});
	});

	$('#uploadFileslibrary').on('click',function(){
		var fd = new FormData( $('#uploadformelement')[0]  ); 
			fd.append('folder_id', activeFolder );
			fd.append('action', 'uploadlibraryfiles' );
			
			for (var x = 0; x < attachmentlist.length; x++) {
				fd.append("attachFile[]", attachmentlist[x].f);
			}

			$.ajax({
				url: SITE_URL + 'teacher/folder',
				type: 'post',
				dataType : 'json',
                processData:false,
                contentType: false ,
                async: false,
				data: fd,
				success: function(Response) {
					if( Response.Error == null ){
						notify('success', Response.msg);
						$('.modal').modal('hide');
						getFoldercontent();
					}else{
						notify('error', Response.Error);
					}
			   },error:function(e){
				   alert('error occured, see console.');
				   console.log(e.responseText);
			   }
		   });
	});

	$('#sharefolderlib').on('click',function(){
		let assignedids = $('#libraryfoldershareupload select').val();
		let folderid = $('#libraryfoldershareupload select').attr('data-folder-id');
		$.ajax({
			url : SITE_URL + 'teacher/folder',
			type : 'post',
			data : { action : 'shareFolder',  assignedids : assignedids, folderid : folderid},
			dataType : 'json',
			success: function(r){  
				if( r.Error == null){
					notify('success', r.msg); 
					$('.modal').modal('hide');
					getFoldercontent();
				}else{
					notify('error',r.Error);
				}
			},
			error : function(r){
				console.error(r);
			}
		});
	});

	$('#downloadStandalone').on('click',function(){
		window.open(SITE_URL + USER_ROLE +  '/getDownloadablefiles/' +  activeFolder);
	});

	getFoldercontent();
});

 
  
var getFoldercontent = function(){
	this.folderCont = $('#folders_list');
	this.folderCont.html('');

	let folder = '<div class="folder-item item">\
				<div class="folder-icon"> <i class="fa fa-folder folder-item-el"> </i><i class="fa fa-file file-item-el"> </i></div>\
				<div class="folder-info">\
					<div class="folder-name file-item-el"></div>\
					<div class="folder-name clickableFolder folder-item-el"></div>\
					<div class="author"> Author : <span class="authorname"></span></div>\
				</div>\
				<div class="folder-date"> <span>  </span> </div>\
				<div class="dropdown folder-menu-dd">\
					<div class="dropdown pull-right">\
						<span class="btn btn-default" data-toggle="dropdown" aria-expanded="false"> <i class="fa fa-chevron-down"></i> </span>\
						<ul class="dropdown-menu start-from-right" style="">\
							<li class="edit"> <a href="#"> <i class="fa fa-edit text-info"></i> Edit  </a>  </li>\
							<li class="share"> <a href="#"> <i class="fa fa-share-alt text-primary"></i> Share  </a>  </li>\
							<li class="delete"> <a href="#"> <i class="fa fa-trash text-danger"></i> Delete  </a>  </li>\
							<li class="unshare"> <a href="#"> <i class="fa fa-trash text-danger"></i> Unshare  </a>  </li>\
						</ul>\
					</div>\
				</div>\
			</div>'; 

	this.fileremove = (id,type) => { 
		$.ajax({
			url : SITE_URL + 'teacher/folder',
			type : 'post',
			data : { action : 'removeFolder',  id : id,type : type },
			dataType : 'json',
			success: function(r){
				if( r.Error == null ){
					notify('success', r.msg);
					getFoldercontent();
				}else{
					notify( 'error', r.Error );
				}
			},
			error : function(r){
				console.error(r);
			}
		});	
	};

	this.shareBtnClicked = (ee) => {
		$('#libraryfoldershareupload .modal-body').html('');
		let setClasses = function( r ){
			let select = $('<select class="form-control selectpicker btn-primary" title="Please Select" multiple name="assignIds" data-folder-id="'+ee+'"></select>');

			r.classes.forEach( function(eee){
				let isInAssignment = false;
				
				for(var x = 0; x < r.assignees.length; x++){
					if( r.assignees[x].class_id == eee.class_id ){
						isInAssignment = true;
						break;
					}
				}
				select.append( '<option value="'+ eee.class_id +'" '+ (isInAssignment?'selected':'') +'> '+ eee.class_name +' </option>' );
			});

			$('#libraryfoldershareupload .modal-body').append(select);
			select.selectpicker();
			$('#libraryfoldershareupload').modal('show');
		};
		$.ajax({
			url : SITE_URL + 'teacher/folder',
			type : 'post',
			data : { action : 'fetchAssignees', folder : ee },
			dataType : 'json',
			success: function(r){ 
				setClasses(r);
			},
			error : function(r){
				console.error(r);
			}
		});	




		$('#libraryfoldershareupload').modal('show');
	};

	this.createFolderContent = (r) =>{ 
		r.folders.forEach( function(e){
			let div = $(folder);
				div.find('.file-item-el').remove();
				div.attr('data-id', e.lf_id );
				div.find('.authorname').text(e.author_name);
				div.find('.folder-name').text(e.lf_name);
				div.find('.folder-date').text( moment( e.timestamp_created ).format('MMM DD, YYYY  h:m a') );
			folderCont.append(div);


			div.find('.folder-name').on('click',function(aa){
				

				$('#folder-panel1 .foldername').text( $(this).text() );
				activeFolder = e.lf_id;
				activefolderArrs.push({ key : activeFolder, name : $(this).text() });

				getFoldercontent();
			});

			div.find('li.delete a').on('click', function(){
				fileremove( $(this).closest('.folder-item').attr('data-id'),'folder' );
			});

			div.find('li.share a').on('click',function(){
				shareBtnClicked( $(this).closest('.folder-item').attr('data-id') );
			});
		});

		r.files.forEach(  function(e){
			let div = $(folder);
				div.find('.folder-item-el').remove();
				div.attr('data-id', e.lff_id );
				div.find('.authorname').text(e.author_name);
				div.find('.folder-name').text(e.file_name);
				div.find('.folder-date').text( moment( e.timestamp_created ).format('MMM DD, YYYY  h:m a') );
			
			div.find('li.share').remove();
			div.find('li.unshare').remove();

			folderCont.append(div);

			div.find('li.delete a').on('click', function(){
				fileremove( $(this).closest('.folder-item').attr('data-id'),'file' );
			});
		});
	}
	if( activeFolder == 0){
		$('#folder-panel1').addClass('type1-panel');
		$('#folder-panel1').removeClass('type2-panel');
	}else{
		$('#folder-panel1').removeClass('type1-panel');
		$('#folder-panel1').addClass('type2-panel');
	}

	let data = { action : 'fetchfolder',  parent : activeFolder };

	if( typeof classID !== 'undefined'  )  data['classid'] = classID;
 
	$.ajax({
		url : SITE_URL + USER_ROLE + '/folder',
		type : 'post',
		data : data,
		dataType : 'json',
		success: function(r){
			createFolderContent(r);
			if( r.folders.length > 0 || r.files.length > 0){
				$('.folders-panel').removeClass('no-show');
			}else{
				$('.folders-panel').addClass('no-show');
			}
		},
		error : function(r){
			console.error(r);
		}
	});
}