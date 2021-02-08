 

let activePeriod;
let activeColumn;
let isColumnedit = false;

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

	$('.deleteperiod').on('click',function(){
		$.confirm({
			title : 'Are you sure ? ',
			type : 'red',
			buttons : {
				confirm : function(){
					deletePeriod();
				},close: function(){}
			}
		});
	});

	$('.createGradebookBtn').on('click',function(){
		addGradingColumn();
	});

	$('#createGradebook').on('hidden.bs.modal',function(){
		$(this).find('.modal-title').html('Add Grade Collumn');
		$(this).find('.createGradebookBtn').html('Add Grade');
		$(this).find('input').val('');
	});

 

	$(document).on('resize',function(){
		resize();
	});

	$(document).on('click',function(e){
		if(  !($('.dropdowndivs').has( $(e.target) ).length > 0 || $('.dropdowndivs').is( $(e.target) )) &&
				!( $('.grade-header').is( $(e.target)) || $('.grade-header').has( $(e.target) ).length > 0 ) ){
			$('.grade-header.open').removeClass('open');
		}
	});

	$('.export-gradebook').on('click',function(){
		let classid = $('.classes-dropdown li.active').attr('data-class-id');
		let link = SITE_URL + 'teacher/exportgradebook/' + activePeriod+'/'+classid;
		window.open(link,'_blank');
	});


	resize();
	getGradeBook( $('.classes-dropdown li.active').attr('data-class-id')  );
});


 

var resize = function(){

	let height = $(window).height() - 230;
	$('#gradebook-container').css('height', height ); 
	$('#gradebook-container .gradebook-grid').css('height',height - 83 ); 
}


var deletePeriod  = () => {
	$.ajax({
		url : SITE_URL + 'teacher/gradebook',
		type : 'post',
		data : { 'action'  : 'delPeriod',cgp : activePeriod },
		dataType : 'json',
		success: function(r){  
			if( r.Error == null){
				notify('success', r.msg);
				let aa = $('.periods li[data-cgp="'+activePeriod+'"]');

				if( !aa.next().hasClass('addgradeli') ){
					let nxt = aa.next();
						aa.remove();
						nxt.trigger('click');
				}else{
					let prv = aa.prev();
						aa.remove();
						prv.trigger('click');
				}
					
			}else{
				notify('error',r.Error);
			}
		},
		error : function(r){
			console.error(r);
		}
	});
}

var addGradingColumn = () =>{
	let name = $('#createGradebook input[name="name"]').val();
	let defaultover = $('#createGradebook input[name="default-over"]').val();
	let data = { 'action'  : 'addGradingColumn',cgp : activePeriod,name : name, defaultover:defaultover };

	if(isColumnedit){
		data['cgpc'] = activeColumn;
	}
	$.ajax({
		url : SITE_URL + 'teacher/gradebook',
		type : 'post',
		data : data,
		dataType : 'json',
		success: function(r){  
			if( r.Error == null){
				notify('success', r.msg);
				$('#createGradebook').modal('hide');
				$('#createGradebook input').val('');

				$('.periods li.active').trigger('click');
					
			}else{
				notify('error',r.Error);
			}
		},
		error : function(r){
			console.error(r);
		}
	});

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
	this.periods ;
	this.gbook = $('#gradebook-table');

	$('#gradebook-container .headpart button').prop('disabled',true);


	iii.gbook.find('.grade-header').remove();
	iii.gbook.find('tbody').html('');

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
				iii.gbook.find('tbody').append( tr );
		});
	}

	this.showGradingPeriods = function(r){
		iii.periods = r;
		let p = $('.periods');
			p.find('li:not(.addgradeli)').remove();
		let html = $('<li class="ml-2"><button type="button" class="btn btn-xs btn-primary"> 1 </button></li>');
		r.forEach( (el,K) => {
			let a= html.clone();
				a.find('button').text(el.cg_period_name); 
				a.attr('data-cgp', el.cgp_id);
				a.on('click',function(){
						activePeriod = $(this).attr('data-cgp');
						$('.periods li').removeClass('active');
						$(this).addClass('active');
						iii.getAjaxTabledata();
				});

				if( K == r.length -1){
					a.trigger('click');
				}
				
			p.find('li.addgradeli').before( a );
		
		});
 
	};

	this.getAjaxTabledata = () => {
		$('#gradebook-container .loading').css('display','flex'); 
		$.ajax({
			url : SITE_URL + 'teacher/gradebook',
			type : 'post',
			data : { 'action'  : 'getperiodtabledata', cgp : activePeriod },
			dataType : 'json',
			success: function(r){  
				console.log(r);
				createTable(r);
			},
			error : function(r){
				console.log(r);
			}
		});
	}

	this.calculateScorePercent = () => {
		iii.gbook.find('tbody tr').each(function(){
			totalScore = 0;
			totalOver = 0;
			$(this).find('td.grade-content-td').each( function(){
				scoreinput = $(this).find('.score').val();
				overinput = $(this).find('.over').val();
				if( scoreinput != '' ){
					totalScore += parseInt(scoreinput);
					totalOver += parseInt(overinput);
				}
			});
			$(this).find('td.student-item .percentage').text( ( (totalScore/totalOver) * 100 ).toFixed(0) + '%'  );
		});

		iii.gbook.find('thead th.grade-header').each( function(k,V){ 
			totalScore = 0;
			totalOver = 0;
			total_graded = 0;
			counter = 0;
			iii.gbook.find('tbody td:nth-child('+ ($(V).index()+1) +')').each(function(kk,Vv){
				counter++;
				inputscore = $(Vv).find('.score').val();
				inputover = $(Vv).find('.over').val();
				if( inputscore != '' ){
					total_graded++;
					totalScore += parseInt(inputscore);
					totalOver += parseInt(inputover);
				}
			});

			$(V).find('.graded').text( total_graded + '/' + counter );
			$(V).find('.average').text( ( ( totalScore / totalOver ) * 100).toFixed(0) + '%' );
		});

	}


	this.createTable = ( tableData  ) => {  
		
		iii.gbook.find('thead th.grade-header').remove();
		iii.gbook.find('tbody td.grade-content-td').remove();

		var getGrading = function(i,e){
			let inputChange = (TD) => {
				let cgp = TD.index() - 1;
					cgp = gbook.find('thead th.grade-header').eq( cgp ).attr('data-id');
				let data = { 
							'action'  : 'editGrade',
							cgpc : cgp,
							stud: TD.closest('tr').attr('data-id'), 
							score: TD.find('.score').val(), 
							over : TD.find('.over').val()
						 };
				$.ajax({
					url : SITE_URL + 'teacher/gradebook',
					type : 'post',
					data : data,
					dataType : 'json',
					success: function(r){  
						if( r.Error == null){
							notify('success', r.msg);
							iii.calculateScorePercent();
						}else{
							notify('error',r.Error);
						}
					},
					error : function(r){
						console.error(r);
					}
				});
			};
 
			let el = $('<td class="grade-content-td">\
							<div class="grade-content">\
								<input type="text" placeholder="Score" class="score"> <span class="ml-1 mr-1 mt-auto mb-auto"> / </span> <input type="text" name="" placeholder="Over" class="over">\
							</div>\
						</td>'); 

			 
			if( e.default_over != undefined){
				el.find('.over').val( e.default_over );
			}else{ 
				el.find('input').prop('readonly',true).on('click',function(){
					$.confirm({
						type : 'blue',
						icon : 'fa fa-info',
						title : 'Hi',
						content : e.tsk_type == 0 ? 'Quiz grades cannot be editted once submitted' :'Assignment grades can be edited in the task\'s review page'
					});
				});
			}

			el.find('input').on('keyup',function(e){
				if(e.which == 39){
					$(this).closest('td').next().find('input.score').focus();
				}else if(e.which == 37){
					$(this).closest('td').prev().find('input.score').focus();
				}
			});

			el.find('input').on('change',function(){
				inputChange( $(this).closest('td') );
			});

			
			return el;
		};

		var createGradeHeadings = () => {
			let deleteColumn = (aa,el) => {
				$.ajax({
					url : SITE_URL + 'teacher/gradebook',
					type : 'post',
					data : { 'action'  : 'delColumn',cgpc : el.cgpc_id },
					dataType : 'json',
					success: function(r){  
						if( r.Error == null){
							notify('success', r.msg);
							$('.periods li.active').trigger('click');
						}else{
							notify('error',r.Error);
						}
					},
					error : function(r){
						console.error(r);
					}
				});

			};

			let editColumn = (aa,el) =>{
				let modal = $('#createGradebook');
				modal.find('.modal-title').html('Edit grade column');
				modal.find('input[name="name"]').val(  el.cgg_name );
				modal.find('input[name="default-over"]').val(  el.default_over );
				modal.find('.createGradebookBtn').text('Edit');
				modal.modal('show');
				isColumnedit = true;
			}
		 	let changePeriod = (cgp,cgpc) => {
				$.ajax({
					url : SITE_URL + 'teacher/gradebook',
					type : 'post',
					data : { 'action'  : 'changePeriod',cgp : cgp,cgpc : cgpc },
					dataType : 'json',
					success: function(r){  
						if( r.Error == null){
							notify('success', r.msg);
							$('.periods li.active').trigger('click');
						}else{
							notify('error',r.Error);
						}
					},
					error : function(r){
						console.error(r);
					}
				});
			};
			

			tableData.forEach( el => { 
				let aa = $('<th class="grade-header table-header" data-id="">\
								<span class="m-auto"></span>\
								<div class="dropdowndivs">\
									<div class="toppart">\
										<span class="title d-block mb-2" style="font-weight:700">Tetst</span>\
										<span class="d-block mb-1 added"> <i class="fa fa-clock-o"></i> <small></small> </span>\
										<span class="due d-block mb-1 due"> <i class="fa fa-clock-o"></i> <small></small>  </span>\
										<select class="select select2" style="width:80px"></select>\
									</div>\
									<hr class="m-0" />\
									<div class="stats">\
										<p><small>Stats</small> <span class="text-danger pull-right action action-del">Delete</span><span class="text-info pull-right mr-1 action action-edit">Edit</span> </p>\
										<p class="mb-0"> Graded  <span class="pull-right bold faded graded"> 1/1 </span></p>\
										<p class="mb-0"> Average  <span class="pull-right bold faded average"> 1/1 </span></p>\
									</div>\
								</div>\
							</th>'); 


				let d = moment(el.timestamp_created).format('MMM DD, YYYY  H:m a');
				aa.find('.added small').html( 'Added on ' + d );


				if( el.tsk_title != undefined ){
					aa.addClass('task-grade').attr('data-id', el.tsk_id).find('> span').html(el.tsk_title);
					aa.find('.title').html(el.tsk_title);
					
					let d = moment(el.tsk_duedate).format('MMM DD, YYYY  H:m a');
					aa.find('.due small').html( 'Due on ' + d );
					
					aa.find('.dropdowndivs .action').remove();
				}else{
					aa.attr('data-id', el.cgpc_id).find('>span').html(el.cgg_name);
					aa.find('.title').html(el.cgg_name);
					aa.find('.dropdowndivs .due').remove();
					aa.find('.dropdowndivs .action').on('click',function(){
						if( $(this).hasClass('action-del') ){
							deleteColumn(aa,el);
						}else{
							editColumn(aa,el);
						}
					});
				}
				periods.forEach((eee) => {
					aa.find('select').append('<option value="'+  eee.cgp_id +'" '+ ( eee.cgp_id == activePeriod? 'selected':'' ) +'>'+ eee.cg_period_name +'</option>');
				});


				aa.find('select').on('change',function(){
					changePeriod($(this).val(), el.cgpc_id);
				});

				aa.on('click',function(){
					$('.grade-header.open').removeClass('open');
					$(this).toggleClass('open'); 
					activeColumn = $(this).attr('data-id');
				});

				
				
				iii.gbook.find('thead tr').append(aa);

				iii.gbook.find('tbody tr').each( function(a,b){ 
					$(this).append( getGrading(a,el) )	;
				});
			});

			setTableData();
		};


		var setTableData = () => {
			iii.gbook.find('thead .grade-header').each( function(a,b){ 
				// let studid = $(b).attr('data-id');
				let grades = tableData[a].grades;
				grades.forEach(e => {
					let td = iii.gbook.find('tbody tr[data-id="'+ e.stud_id +'"] td.grade-content-td').eq(a);
					
					if( $(b).hasClass('task-grade') ){
						console.log( tableData[a]);
						if( tableData[a].tsk_type == 0){
							td.find('input.score').val( e.quiz_score );
							td.find('input.over').val( e.total_point );
						}else{
							td.find('input.score').val( e.ass_grade );
							td.find('input.over').val( e.ass_over );
						}
					}else{
						td.find('input.score').val( e.cgsg_score );
						td.find('input.over').val( e.cgsg_over );
					}
				});
			});

			iii.calculateScorePercent();
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
			if( iii.gbook.find('tbody tr').length > 0 ){
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