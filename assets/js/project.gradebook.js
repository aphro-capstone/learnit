

studs = [
			{ 
				name : 'Joemarie Arana',
				id : 1,
				imgPath : '',
				gradings : [ 
							{ title : 'assignment1', score : 1, over : 2}, 
							{ title : 'assignment2', score : 1, over : 2}, 
							{ title : 'assignment3', score : 1, over : 2}, 
							{ title : 'assignment4', score : 1, over : 2}, 
						]
			},
			{ 
				name : 'Joemarie Arana',
				id : 1,
				imgPath : '',
				gradings : [ 
							{ title : 'assignment1', score : 1, over : 2}, 
							{ title : 'assignment2', score : 1, over : 2}, 
							{ title : 'assignment3', score : 1, over : 2}, 
							{ title : 'assignment4', score : 1, over : 2}, 
						]
			},
			{ 
				name : 'Joemarie Arana',
				id : 1,
				imgPath : '',
				gradings : [ 
							{ title : 'assignment1', score : 1, over : 2}, 
							{ title : 'assignment2', score : 1, over : 2}, 
							{ title : 'assignment3', score : 1, over : 2}, 
							{ title : 'assignment4', score : 1, over : 2}, 
						]
			},

];


jQuery( ($) => {
	$('#gradebook-table').on( 'scroll', function(){
		console.log(1);
	});

	$('#addgradingperioud').on('click',function(){
		addgradingPeriod(2);
	});

	$('.classes-dropdown li a').on('click',function(e){
		e.preventDefault();
		$('.classes-dropdown li.active').removeClass('active');
		$(this).parent().addClass('active');
		$(this).closest('.dropdown').find('.data-toggle span').text( $(this).text() );
		getGradeBook( $(this).parent().attr('data-class-id') );
	});

	$(document).on('resize',function(){
		resize();
	});
	resize();
	getGradeBook( $('.classes-dropdown li.active').attr('data-class-id')  );
});


 

var resize = function(){

	let height = $(window).height() - 230;
	$('#gradebook-container').css('height', height ); 
	$('#gradebook-container .gradebook-grid').css('height',height - 83 ); 
}



var addgradingPeriod = (name = 2) => {

	var newGradingPeriod = function(){
		$('.periods li').removeClass('active');
		$('.periods li:last-child').before('<li class="ml-2 active"><button type="button" class="btn btn-sm btn-secondary"> '+ name +' </button></li>');
	};

	$.ajax({
		url : SITE_URL + 'teacher/gradebook',
		type : 'post',
		data : { 'action'  : 'addgradingperiod', name : name, class : classID },
		success: function(r){
			if( r !=0 ){ 
				notify('success', 'Grading Period Created');
				newGradingPeriod();
			}else{
				notify('Error', 'Grading Period Created');
			}
		},
		error : function(r){
			console.log(r);
		}
	});



}
 


var getGradeBook = (classid) => {
	this.classID = classid;
	this.studentsList ;
	let iii = this;
	let gbook = $('#gradebook-table');

	$('#gradebook-container .headpart button').prop('disabled',true);


	gbook.find('.grade-header').remove();
	gbook.find('tbody').html('');

	this.createStudentsList = (studs) => {
		let el = $('<td class="student-item table-header fixed-td">\
						<div class="d-flex position-relative ">\
							<div class="img-container image-circular"> <img src="http://localhost/learnit/assets/images/user.png"></div>\
							<span class="text">  </span>\
							<span class="percentage"> 23%</span>	\
						</div>\
					</td>'); 
		
		studs.forEach(stud => {
			let tr = $('<tr data-id="'+ stud.user_id +'"></tr>');	
			let aa = el.clone();
				aa.find( '.img-container img' ).attr('src', SITE_URL + stud.userimage);
				aa.find('.text').append( stud.name  );

				tr.append(aa); 
				gbook.find('tbody').append( tr );
		});
	}

	this.showGradingPeriods = function(r){
		let p = $('.periods');
			p.find('li:not(.addgradeli)').remove();
		let html = $('<li class="ml-2"><button type="button" class="btn btn-xs btn-primary"> 1 </button></li>');
		r.forEach( (el,K) => {
			let a= html.clone();
				a.find('button').text(el.cg_period_name); 
				a.on('click',function(){
					if( !$(this).hasClass('active') ){
						$('.periods li').removeClass('active');
						$(this).addClass('active');
						createTable( el.table );
					}
				});

				if( K == r.length -1){
					a.trigger('click');
				}
				
			p.find('li.addgradeli').before( a );
		
		});


	};

	this.createTable = ( tableData  ) => {  
		$('#gradebook-container .loading').css('display','flex');
		gbook.find('thead th.grade-header').remove();
		gbook.find('tbody td.grade-content-td').remove();


		var getGrading = function(i){
			let el = $('<td class="grade-content-td">\
							<div class="grade-content">\
								<input type="text" placeholder="Score" class="score"> <span class="ml-1 mr-1 mt-auto mb-auto"> / </span> <input type="text" name="" placeholder="Over" class="over">\
							</div>\
						</td>'); 
			return el;
		};

		var createGradeHeadings = () => { 
			
			tableData.forEach( el => {
				let aa;
				if( el.tsk_title != undefined ){
					aa = $('<th class="grade-header table-header task-grade" data-id="'+ el.tsk_id +'"><span class="m-auto">'+ el.tsk_title +'</span> </th>');
				}else{
					aa = $('<th class="grade-header table-header" data-id="'+ el.cgpc_id +'"><span class="m-auto">'+ el.cgg_name +'</span> </th>');
				}
				
				gbook.find('thead tr').append(aa);

				gbook.find('tbody tr').each( function(a,b){ 
					$(this).append( getGrading(a) )	;
				});
			});

			setTableData();
		};


		var setTableData = () => {


			gbook.find('thead .grade-header').each( function(a,b){ 
				// let studid = $(b).attr('data-id');
				let grades = tableData[a].grades;
				grades.forEach(e => {
					let td = gbook.find('tbody tr[data-id="'+ e.stud_id +'"] td.grade-content-td').eq(a);
					
					if( $(b).hasClass('task-grade') ){
						td.find('input.score').val( e.ass_grade );
						td.find('input.over').val( e.ass_over );
					}else{
						td.find('input.score').val( e.cgsg_score );
						td.find('input.over').val( e.cgsg_over );
					}
				});
			});
		}
		
		createGradeHeadings();
		$('#gradebook-container .loading').css('display','none');
	}
 
 
 

	$('#gradebook-container .loading').css('display','flex');

	$.ajax({
		url : SITE_URL + 'teacher/gradebook',
		type : 'post',
		data : { 'action'  : 'getgradingperiods', class : classid },
		dataType : 'json',
		success: function(r){  
			iii.createStudentsList( r.students );
			if( gbook.find('tbody tr').length > 0 ){
				iii.showGradingPeriods( r.periods  );
				$('#gradebook-container').removeClass('no-student');
				$('#gradebook-container .headpart button').prop('disabled',false); 
			}else{
				$('#gradebook-container').addClass('no-student');
				$('#gradebook-container .loading').css('display','none');
			}	
		},
		error : function(r){
			console.log(r);
		}
	});
}