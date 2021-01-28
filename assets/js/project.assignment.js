

jQuery( ($) => {
	iniAssignment();
});







var iniAssignment = function(){
	if( USER_ROLE == 'teacher' ){
		this.submitAss = () => {
			let modal = $('#assignmentModal');
			let dataSend = getTaskDataObject( modal );

			if( typeof tid !== 'undefined' ){
				dataSend['tid'] = tid;
				dataSend['aid'] = aid;
			}
 
			$.ajax({
				url: SITE_URL + USER_ROLE + '/creatTask/1',
				type: 'post',
				dataType : 'json',
				data: dataSend,
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
			d = { 
						assid : assID,
						tskid : tskID,
						text :  $('textarea.add-text').val(),
						attachments : []
					};
			$.ajax({
				url: SITE_URL + 'student/submitAssignment',
				type: 'post',
				dataType : 'json',
				data: d,
				success: function(Response) {
					if( Response.error == 1 ){
						notify('success', 'Successfully Submitted Assignment');
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





