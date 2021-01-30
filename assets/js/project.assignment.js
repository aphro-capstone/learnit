

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





