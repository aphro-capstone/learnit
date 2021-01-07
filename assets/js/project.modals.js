


const ADD_CLASS_API = "/teacher/addClass"; 



const createUpdateClass = (classInfo) => {
	$('#prompboxnormal .modal-title').text( 'Create a Class' );
	$('#prompboxnormal .modal-dialog').addClass( 'modal-md' );
	// Event Handlers
	let inputDefaultClasses = [''];
	let inputs = [];
	let buttons = [];
	if( classInfo ){
		inputs = [
						{ type : 'text' , 		name : 'class_name', placeholder : 'Name of your class', required: true, },
						[ { type : 'text' , 		name : 'abbr', placeholder : 'Abbreviation ( Optional ) ',width:6 },
						  { type : 'select' , 	name : 'grade', value : grades , placeholder : 'Select Grade', required: true,width:6 },],
						[ { type : 'select' , 	name : 'subject', value : subjects, key : 'subject' , dependent : { name : 'sub_subject', key : 'pre-sub' }, placeholder : 'Select a Subject', required: true, attr : { 'data-dependent-array': 'subjects' },width : 6},
						  { type : 'select' , 	name : 'sub_subject', value : [], isdependent : true, placeholder : 'Select a sub-subject', required: true, width: 6 }],
						{ type : 'textarea' , 	name : 'desc_class', placeholder : 'Describe your Class', class : '', required: true},
		];

		buttons = [
					{ type:'submit', text : 'Save Settings', class : 'btn-primary pull-right' },
					{ type:'button', text : 'Delete', class : 'btn-danger pull-left mr-2' },
					{ type:'button', text : 'Archive', class : 'btn-info pull-left' }
		];

	}else{
		inputs = [
						{ type : 'text' , 		name : 'class_name', placeholder : 'Name of your class', required: true},
						{ type : 'text' , 		name : 'abbr', placeholder : 'Abbreviation ( Optional ) '},
						{ type : 'textarea' , 	name : 'desc_class', placeholder : 'Describe your Class', class : '', required: true},
						{ type : 'select' , 	name : 'grade', value : grades , placeholder : 'Select Grade', required: true},
						{ type : 'select' , 	name : 'subject', value : subjects, key : 'subject' , dependent : { name : 'sub_subject', key : 'pre-sub' }, placeholder : 'Select a Subject', required: true, attr : { 'data-dependent-array': 'subjects' }},
						{ type : 'select' , 	name : 'sub_subject', value : [], isdependent : true, placeholder : 'Select a sub-subject', required: true},
						// { type : 'rangeselect' , 	name : 'sy', range :1, min : (new Date()).getFullYear(), max :'+50', placeholder : 'School Year', required: true},
						{ type : 'color' , 		name: 'class_color', 	value : availableColors},
		];

		buttons = [

					{ type:'button', text : 'Close', class : 'btn-secondary', atts : ['data-dismiss="modal"'] },
					{ type:'submit', text : 'Submit', class : 'btn-primary pull-right' },
		];
	}

	

	let createsubmit = (id) => {
		let dataSend = $('#prompboxnormal form').serialize();
		$.ajax({
             url: SITE_URL + ADD_CLASS_API,
             type: 'post',
             dataType : 'json',
             data: dataSend,
             success: function(Response) {
             	notify( Response.type, Response.msg, () => {
             		window.location.href = SITE_URL + 'teacher/classes/class-' + Response.id;
             	});

            },error:function(e){
                console.log(e.responseText);
            }
        });
	};




	let body  = '<form>';
		body += createForms( inputs );
		body  += '<form>';
	
	let footerButtons = createButtons( buttons );

	$('#prompboxnormal .modal-footer .additionalButtons').html(footerButtons);
	$('#prompboxnormal .modal-body').html(body);
	$('#prompboxnormal').modal('show');

	$('#prompboxnormal button[type="submit"]').on('click',function(e){
		createsubmit()
	});

}; 

const createInviteModal = () => {
	console.log('createInviteModal');
	$('#prompboxnormal .modal-title').text( 'Invite people to Testclassname' );
	$('#prompboxnormal .modal-dialog').addClass( 'modal-md' );
	
	// let body  = '<div class=""></div>';

	

	let buttons = [
				{ type:'button', text : 'Done', class : 'btn-primary', atts : ['data-dismiss="modal"','aria-label="Close"'] }
	];
	let footerButtons = createButtons( buttons );

	$('#prompboxnormal .modal-footer .additionalButtons').html(footerButtons);
	// $('#prompboxnormal .modal-body').html(body);
	$('#prompboxnormal').modal('show');
}