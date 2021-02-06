

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
	
	getGradeBook( $('.classes-dropdown li.active').attr('data-class-id')  );
});


 



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
		var getGrading = function(grading,i){
			let el = $('<td class="grade-content-td">\
							<div class="grade-content">\
								<input type="text" placeholder="Score"> / <input type="text" name="" placeholder="Over">\
							</div>\
						</td>');
			return el;
		};

		var createGradeHeadings = () => { 
			tableData.forEach( el => {
				let aa = $('<th class="grade-header table-header" data-id="'+ el.cgpc_id +'">'+ el.cgg_name +' </th>');
				gbook.find('thead tr').append(aa);

				gbook.find('tbody tr').each( function(){
					$(this).append( getGrading() );
				} );



			});
		};

		console.log(tableData);
		createGradeHeadings();
	}



		
		


	// 	for( let x = 0; x < studs.length;x++ ){
	// 		let stud = studs[x];
			
	// 		let tr = $('<tr data-id="'+ stud.id +'"></tr>');
	// 			tr.append( getStudTH(stud,x) );

			
	// 		// for( let y = 0; y < stud.gradings.length ;y++ ){
	// 		// 	tr.append( getGrading(stud.gradings[y],y) );
	// 		// }  

	// 		console.log(stud);
	// 		$('#gradebook-table tbody').append(tr);
	// 	}
	// }
 

	
 

	$('.grading-content').addClass('isloading');

	$.ajax({
		url : SITE_URL + 'teacher/gradebook',
		type : 'post',
		data : { 'action'  : 'getgradingperiods', class : classid },
		dataType : 'json',
		success: function(r){  
			iii.createStudentsList( r.students );
			iii.showGradingPeriods( r.periods  ); 
			$('.grading-content').removeClass('isloading');
		},
		error : function(r){
			console.log(r);
		}
	});
}