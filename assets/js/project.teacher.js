



let grades = [];
let subjects = [];
let availableColors = [];
let availabletoview_group = [
					{ option : 'Private to Members', role : [ 'student','teacher' ] },
					{ option : 'Public to all', role : [ 'student','teacher' ] },
					{ option : 'Public to teachers', role : [ 'teacher' ] },
					{ option : 'Public to School Staff', role : [ 'teacher' ] },
					{ option : 'Public to Distric Staff', role : [ 'teacher' ] },
];




function Teacher(){

	this.deleteClass = function(id,el){
		$.ajax({
			url: SITE_URL + USER_ROLE + '/EditClass/r/' + id,
			type: 'post',
			dataType : 'json',
			success: function(Response) {
				if( Response.Error == null ){
					notify( 'success', Response.msg,undefined,false)
					el.fadeOut(300,()=>{
						$(this).remove();
					});
				}else{
					notify('error', Response.Error);
				}
				

		   },error:function(e){
			   console.log(e.responseText);
		   }
	   });
	}

	this.updateStatus = function (id,val,el){
		$.ajax({
			url: SITE_URL + USER_ROLE + '/EditClass/u/' + id + '/' + val,
			type: 'post',
			dataType : 'json',
			success: function(Response) {
				if( Response.Error == null ){
					notify( 'success', Response.msg,undefined,false)
					el.fadeOut(300,()=>{
						$(this).remove();
					});
				}else{
					notify('error', Response.Error);
				}
				

		   },error:function(e){
			   console.log(e.responseText);
		   }
	   });
	} 
}





var teacher = new Teacher();
jQuery(function($){ 

	$('.createClassModal').on('click',function(e){
		e.preventDefault();
		createUpdateClass();
	});

	$('.showInviteModal').on('click',() => {
		createInviteModal();
	});

	$('.updateClassModal').on('click',function(e){
		e.preventDefault();
		createUpdateClass(1);
	});

	$('.deleteClass').on('click',function(e){
		e.preventDefault();  
		teacher.deleteClass(  $(this).closest('[data-id]').attr('data-id'),$(this).closest('[data-id]'));
	});

	$('.archiveClass').on('click',function(e){
		e.preventDefault();  
		teacher.updateStatus(  $(this).closest('[data-id]').attr('data-id'),2,$(this).closest('[data-id]'));
	});

	$('.unarchiveClass').on('click',function(e){
		e.preventDefault();  
		teacher.updateStatus(  $(this).closest('[data-id]').attr('data-id'),1,$(this).closest('[data-id]'));
	});


	ini();
});

function ini(){
	getSettings();
}





var getSettings = () => {
	$.ajax({
         url: SITE_URL + USER_ROLE + '/getSetting',
         type: 'get',
         dataType : 'json',
         success: function(Response) {
         	setValues(Response);
        },error:function(e){
        	notify( 'error', e.responseText );
        }
    });
};




var setValues = ( Responds ) => {
	$.each(Responds, (a,b) => {
		if( a == 'subjects' ){
			subjects = [];
			for( var bb of b ){
				if( bb.s_parent_sub  != '0' ) continue;
				
				let temp = { 'subject' : {  'id' : bb.s_id, 'name' : bb.s_name  }, 'pre-sub' : [] };
				let presub = [];

				for( var bbb of b ){
					if( bbb.s_parent_sub == '0' || bbb.s_parent_sub != bb.s_id  ) continue;
					presub.push( {  'id' : bbb.s_id, 'name' : bbb.s_name } );
				}

				temp['pre-sub'] = presub;
				subjects.push(temp);
			}
		}else if ( a == 'grades'){
			grades = [];
			for( var bb of b ){ grades.push( { 'id' : bb.g_id, 'name' : bb.g_name} ); }  
		}else if ( a == 'colors' ){
			availableColors = [];
			for( var bb of b ){ availableColors.push( { 'id' : bb.sc_id, 'label' : bb.sc_name, 'color': bb.sc_color, tcolor : bb.sc_text_color } ); }  
		}
	});

	if(typeof updateColors !== 'undefined'){
		updateColors( );
	}
};
 

