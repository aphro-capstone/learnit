
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

	

	showTables();

	$('.dataTable-container table').DataTable();


});

var notify = (type, msg,callback = () => {} ) => {
	$.notify( msg , {
		type: type,
		delay: 1000,
		showProgressbar: true,
		onClose : callback
	});
};

var checkadminPass = function(callback){

	this.apiCheckadminpass = function(d){ 
		return new Promise( function(resolve, reject){
			$.ajax({
				url: domainOrigin + '/admin/checkAdmin',
				type: 'post',
				data : { data : d  },
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
							if( r == 1){
								callback(r); 
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

	this.getCredentials = function(v){
		$.ajax({
			url: domainOrigin + '/admin/getCredentials',
			type: 'post',
			data : { d : v.user_id},
			success: function(r) {  
				r = JSON.parse(r);
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
								<dd>'+ r.uname +'</dd>\
								<dt>Password : </dt>\
								<dd>'+ r.pass +'</dd>\
							</dl>', 
				});
			},error:function(e){
				console.error(e);
				// reject(e);
			}
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
			checkadminPass( () => {
				i.getCredentials( v );
			});
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

var showMultimedia = function(){
	if( page != 'multimedia' ) return;

	this.createTR = function(){
		
	};



}