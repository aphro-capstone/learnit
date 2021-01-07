
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
             	console.log(Response);
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
});

var notify = (type, msg,callback = () => {} ) => {
	$.notify( msg , {
		type: type,
		delay: 1000,
		showProgressbar: true,
		onClose : callback
	});
};