

jQuery( ($) => {
	iniAssignment();
});







var iniAssignment = function(){
	if( USER_ROLE == 'teacher' ){
		this.submitAss = () => {
			var fd = new FormData( $('#uploadformelement')[0]  );  

			let modal = $('#assignmentModal');
			let dataSend = getTaskDataObject( modal );

			if( typeof tid !== 'undefined' ){
				fd.append('tid',tid);
				fd.append('aid',aid);
			}
			dataSend = JSON.stringify( dataSend);

			fd.append('data', dataSend);
			console.log(attachmentlist);
			for (var x = 0; x < attachmentlist.length; x++) {
				fd.append("attachFile[]", attachmentlist[x].f);
			}
			
			$.ajax({
				url: SITE_URL + USER_ROLE + '/creatTask/1',
				type: 'post',
				dataType : 'json',
                processData:false,
                contentType: false ,
                async: false,
				data: fd,
				success: function(Response) {
					console.log(Response);
					if( Response.Error == null ){
						$('.modal').modal('hide');
						notify('success', Response.msg, () => {
							window.location.reload();
						});
					}
			   },error:function(e){
				   alert('error occured, see console.');
				   console.log(e.responseText);
			   }
		   });
		}

		$('.createAssignment').on('click',function(){
			submitAss();
		});

			
		$('#setGradebtn').on('click',function(){	
			let score = $('#setGrade [name="score"]').val();
			let over = $('#setGrade [name="over"]').val();
			console.log(score,over);
			if( over == ''  || score == '' ){
				notify('error','A field is empty, please check.',undefined,false);
				return;
			}else if ( parseFloat(over) > parseFloat(over) ){
				notify('error','Score cannot be greater than the over!',undefined,false);
				return;
			}

			let grade = { 
							score : score, 
							over :  over,
							tsaid : TSAID,
							tsk : tskID  };	

			$.ajax({
				url: SITE_URL + USER_ROLE + '/addGrade/assignment', 
				type: 'post',
				dataType : 'json',
				data: grade,
				success: function(Response) {
					if( Response.Error == null ){
						notify( 'success', Response.msg,() => {
							window.history.back();
						});
					}else{
						notify('error',Response.Error,undefined,false,3000);
					} 
				},error:function(e){
					console.error(e.responseText);
				}

			});
		});


		$('#setGrademodalbtn').on('click',function(e){
			e.preventDefault();
			let modal = $('#setGrade');
			if($(this).hasClass('update')){
				let vals = JSON.parse( $(this).attr('data-vals'));
				modal.find('.modal-title').text('Update given grade');
				modal.find('.modal-body .d-flex > .form-group:first-child input').val( vals[0] );				
				modal.find('.modal-body .d-flex > .form-group:last-child input').val( vals[1] );				
			}else{
				modal.find('.modal-title').text('Grade Assignment');
			}

			modal.modal('show');
		}); 



		
	}else if( USER_ROLE == 'student' ){
		

		this.submitAss = function(){	

			var fd = new FormData( $('#uploadformelement')[0]  ); 
			d = { 
				assid : assID,
				tskid : tskID,
				text :  $('textarea.add-text').val(),
				attachments : []
			};

			fd.append('data', JSON.stringify( d ));
			
			for (var x = 0; x < attachmentlist.length; x++) {
				fd.append("attachFile[]", attachmentlist[x].f);
			}

			$.ajax({
				url: SITE_URL + 'student/submitAssignment',
				type: 'post',
				dataType : 'json',
                processData:false,
                contentType: false ,
                async: false,
				data: fd,
				success: function(Response) {
					if( Response.Error == null ){
						notify('success', Response.msg, () => {
							window.location.reload();
						});
					}else{
						notify('error', Response.Error);
					}
			   },error:function(e){
				   alert('error occured, see console.');
				   console.log(e.responseText);
			   }
		   });
		}
 
		$('.add-text-btn').on('click',function(){
			$('.add-text').show();
		});

		$('.submitAssignment').on('click',function(){
			submitAss();
		})
 
	}
	
}





