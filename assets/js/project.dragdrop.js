
	


jQuery( function($){


	$('.custom_drag-drop').on('click',function(e){

		if( $(e.target).closest('.drag-drop-item').length == 0 ){
			let a = $('<input type="file" name="attachFile" multiple="true" class="d-none" accept="video/*, image/*, .pdf, .doc, .docx, .xls, .xlsx, .ppt, .pptx,.txt">');
			a.trigger('click');
			a.on('input',function(e){ 
				checkFile(e.target,undefined, true );

				if( attachmentlist.length > 0 ){
					$('#drop-item-box .dz-message.placeholder').hide();
				}else{
					$('#drop-item-box .dz-message.placeholder').hide();
				}
			});
		}
		
	});
}); 