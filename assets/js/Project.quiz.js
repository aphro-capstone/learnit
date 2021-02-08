

let questions = [];
const formcontainer = $('#questions-list');
let quizStarted = false;



function quizItem(QuestionNum, Question = '',Selection = null,preRep,points = 1){
	this.qnum = QuestionNum;
	this.selectionTypes = [ 
			'True/False',
			'Multiple Choice',
			'Short Answer',
			'Fill in the blanks',
			'Matching',
			'Multiple Answers',
	];

	this.Selection = Selection;
	this.Question = Question;
	this.Note = '';
	this.responses = '';
	this.grading = '';
	this.selectedType = 0;
	this.selectedTypeString = '';
	this.QuestionItem = $('<div class="question-item"></div>');
	this.QuestionsListContainer = $('#questions-list');
	this.questionPoints = points;
	this.attachments = [];
	this.preResponses = preRep;

	 
	this.setNum = (num) => {
		this.qnum = num;
		this.QuestionItem.find('.question-number').text( this.qnum );
	}

	this.placeAnswers = () => {
		let i = this;
		if( i.selectedType == 0 ){
			i.responses.find('input[value="'+ i.preResponses +'"]').closest('.response-item').trigger('click');
		}else if( i.selectedType == 1 || i.selectedType == 5 ){
			i.preResponses.forEach((v,K) => {
				if( i.responses.find('.response-item').eq( K ).length == 0 )  i.responses.find('.btn.btn-primary').trigger('click');
				
				let el = i.responses.find('.response-item').eq(K);
					el.find('input[type="text"]').val(v.text);
				
				if( v.ischecked == 'true' ){
					el.find( i.selectedType == 1 ? '.radioboxinput' : '.custom-checkbox .checkbox' ).trigger('click');
				}
			});
		}else if( i.selectedType  == 4){
			i.preResponses.matches.forEach((v,K) => {
				if( i.responses.find('> .response-item').eq( K ).length == 0 )  i.responses.find('> .btn.btn-primary').trigger('click');
				
				let el = i.responses.find('.response-item').eq(K);
					el.find('.custom_field').eq(0).find('input[type="text"]').val(v[0]);
					el.find('.custom_field').eq(1).find('input[type="text"]').val(v[1]);
			});
			i.preResponses.fakes.forEach((v,K) => {
				if( i.responses.find('> .additional-answers .response-item').eq( K ).length == 0 )  i.responses.find('> .additional-answers .btn.btn-primary').trigger('click');
			
				i.responses.find('> .additional-answers .response-item').eq( K ).find('input[type="text"]').val( v );
			});
		}else if( i.selectedType == 3 ){
			 i.preResponses.forEach( (v,K) => {
				i.responses.find('input').eq(K).val( v );
			 });
		}
	};

	this.createForm = () => {
		let this_ = this;
		let left = $('<div class="left">\
						<div class="ribbon left-ribbon ribbon-primary ribbon1">\
							<div class="content">\
								<span class="question-number"> '+ this.qnum +'</span> </div>\
							</div>\
						</div>' );
		let right = $('<div class="right"></div>');
		let right_full = $('<div class="full-view"></div>');
		let right_coll = $('<div class="collapsed-view"> <p class="mb-1"> <strong> Question : </strong> <span class="question">Question : </span> </p><p class="mb-0"> <strong> Type : </strong> <span class="type"> Type </span> </p>  </div>');
		
		let collapsibletoggle = $('<a href="#" class="collapsible-toggle"> <i class="fa fa-chevron-up"></i> </a>');
			collapsibletoggle.on('click',function(e){
				e.preventDefault();
				this_.QuestionItem.toggleClass('collapsed');
			});
		
			right_full.append( this.createTypeSelectionSection() );
			right_full.append( this.createQuestionSection() );
			// right_full.append( this.createAttachmentSection() );
			right_full.append( this.createResponsesSection() );
			right_full.append( this.createGradingSection() );
			right.append(collapsibletoggle);
			right.append(right_full);
			right.append(right_coll);
 


		this.QuestionItem.append(left);
		this.QuestionItem.append(right);
		this.QuestionsListContainer.append(this.QuestionItem);
		
		if( this.Selection == null ){
			this.QuestionItem.find('[name="quiztype"]').trigger('change');
		}else{
			this.QuestionItem.find('[name="quiztype"]').val(this.Selection).trigger('change');

			this.placeAnswers();
			getTotals();
 
		}
	};



	this.createTypeSelectionSection = () => {
		var container = $('<div class="form-group col-lg-4 pl-0"></div>');
		var select = $('<select class="form-control" name="quiztype"></select>');
		let instance = this;
		this.selectionTypes.forEach( (a,b) => {
			select.append('<option value="'+ b +'"> '+ a +'</option>');
		});

		select.change(function(e){
			instance.selectedType = $(this).val();
			instance.selectedTypeString = $(this).find('option:selected').text().trim();
			instance.createResponsesSection(true);
			instance.updateForm();
		});
 
		

		container.append(select);
		return container;
	};

	this.createQuestionSection = () => {
		let a = $('<div class="form-group question-question"></div>'),
			b = $('<textarea class="form-control question-textarea" placeholder="Question"></textarea>'),
			i = this;
			b.text( this.Question );	
			b.on('input',function(){
				if( i.selectedType == 3 ){
					 i.Question = $(this).val() ;
					 i.createResponsesSection(true);
					 i.updateForm();
				}else{
					i.Question = $(this).val();
					i.QuestionItem.find('.collapsed-view .question').text( $(this).val() );
				}
			});
		
		

		a.append(b);
		return a;
	};

	this.createAttachmentSection = () => {
		const i 			= this;
		const addFile 		= $('<a href="#" class="btn btn-xs btn-outline-secondary pull-right ml-2"> <i class="fa fa-paperclip"> </i> Attach File </a>');
		const addLink 		= $('<a href="#" class="btn btn-xs btn-outline-secondary pull-right ml-2"> <i class="fa fa-link"> </i> Add Link </a>');
		const addLibrary 	= $('<a href="#" class="btn btn-xs btn-outline-secondary pull-right ml-2"> <i class="fa fa-book"> </i> Add from Library </a>');
		let cont = $('<div class="d-table full-width"></div>');
		let cont1 = $('<div class="d-table mb-2"></div>');
		let attachmentsDiv	= $('<div class="attachment-list mt-3"></div>');
		let head = $('<div class="d-table"><small class="small-title font-italic pull-left"> Attachments ::  </small><div class="pull-right"></div></div>');


			addFile.click(function(e){
				e.preventDefault();

				let a = new Attachment('sample attachment', '17Kb', 'document', 'https://tenisradlice.cz/wp-content/uploads/2014/05/image-5.jpg');
				i.attachments.push(a);
				attachmentsDiv.append( a.createAttachmentFrontend() );
				$('#attachFile').trigger('click');
			});

			addLink.click(function(e){
				e.preventDefault();
				let a = new Attachment('sample attachment', '17Kb', 'link', 'https://www.google.com/');
				i.attachments.push(a);
				attachmentsDiv.append( a.createAttachmentFrontend() );
				$('#attachlink').modal('show');
			});

			addLibrary.click(function(e){
				e.preventDefault();
				$('#addLibrary').modal('show');
			});



			cont1.append(addLibrary);
			cont1.append(addLink);
			cont1.append(addFile);
			head.find('.pull-right').append(cont1); 
			attachmentsDiv.append(head);
			cont.append(attachmentsDiv);

		return cont;
	}

	this.updateForm = () => {
		this.QuestionItem.find('.quiz-responses .response-div').remove();
		let noteCont = this.QuestionItem.find('.question-question');

		if(this.selectedType == 3){
			if(noteCont.find('.fillintheblanksnote').length == 0){
				let note = '<small class="note font-italic fillintheblanksnote text-info"> Use underscore ( \'_\' ) to specify where you would like a blank to appear in the text below</small>';
				noteCont.append(note);	
			}
			
		}else{
			noteCont.find('.note').remove();
		}
		
		this.QuestionItem.find('.quiz-responses').append(this.responses);
		this.QuestionItem.find('.collapsed-view .question').text( this.Question );
		this.QuestionItem.find('.collapsed-view .type').text(this.selectedTypeString);
	}


	this.createResponsesSection = (isUpdate = false) => {
		let i = this;

		this.createInputBoxes = (x,useRadio = true,uuid = '') => {
			let a =  $('<div class="custom_field text-boxes d-flex full-width img-capable mt-2 response-item"></div>'),
				b =  $('<input type="text" placeholder="Enter Answer">'),
				c =  $('<span class="inputImage m-auto"></span>'),
				d =  $('<input type="file" class="d-none" accept="image/x-png,image/gif,image/jpeg">'),
				e =  $('<span class="fa fa-image inputfileBtn clickable-content" data-toggle="tooltip" data-placement="left" data-original-title="Add an image to your Answer"></span>'),
				f =  $('<div class="radioboxinput mr-2 m-auto pull-right"><div class="frontend"></div> <input type="radio" name="question_'+ uuid +'_response_multiple_choice"> </div>');
				g =  $('<div class="custom-checkbox"><input type="checkbox" name=""><span class="checkbox fa fa-check"></span></div>');

				e.tooltip();
				
				d.change(function(){
					console.log('change');
				});

				g.on('click',() => {
					setTimeout( () => {
						getTotals();
					},100);
				});

				a.append(b);
				c.append(d);
				c.append(e);
				a.append(c);
				a.append( useRadio ? f : g);

				return a;
		};

		this.createTrueFalseResponse = ( qnam) =>{
			let uuid = create_UUID().replace(/-/g, "");
			let a = $('<div class="row true_false_response response-div">\
						<div class="col col-lg-6 col-md-6 col-sm-12">\
							<div class="custom_field radioboxinput-container p-3 d-table full-width response-item " >\
								<span class="text pull-left"> True </span>\
								<div class="radioboxinput mr-2 m-auto pull-right">\
									<div class="frontend"></div>\
									<input type="radio" name="question_'+ uuid +'_response" value="true">\
								</div>\
							</div>\
						</div>\
						<div class="col col-lg-6 col-md-6 col-sm-12">\
							<div class="custom_field radioboxinput-container p-3 d-table full-width response-item" >\
								<span class="text pull-left"> False </span>\
								<div class="radioboxinput mr-2 m-auto pull-right">\
									<div class="frontend"></div>\
									<input type="radio" name="question_'+ uuid +'_response" value="false">\
								</div>\
							</div>\
						</div>\
					</div>'); 
			return a;
		};

		this.createMultipleChoiceResponse = () => {
			let a = $('<div class="multiple_choice_response mt-3 response-div"></div>');
			let i = this;

			let uuid = create_UUID().replace(/-/g, "");

			for(let x = 0;x < 3; x++){
				a.append( this.createInputBoxes(x,true,uuid) );
			}
			


			let button = $('<button class="btn btn-primary mt-2"> <i class="fa fa-plus"></i> Add Response</button>');
		
				button.click(function(){
					i.createInputBoxes(undefined,true,uuid).insertBefore( button );
				});

			a.append(button);

			return a;
		};

		this.createFillTheBlanksResponse = () => {
			let text  = this.Question
			let a = $('<div class="fill_in_the_blanks mt-3 response-div"></div>'),
				b = $('<div class="text"></div>'),
				lastTextUnderscore = text.trim().charAt(text.length - 1) == '_' ;

				text = text.split('_').filter(item => item).join('_');
				text = text.replace(/_/g, '<input type="text" placeholder="Enter Answer">');

				if( lastTextUnderscore ){
					text += '<input type="text" placeholder="Enter Answer">';
				}

				b.append(text);
				a.append(b);
				a.append('<small class="font-italic text-info">Students will have to answer in the exact order for the question to be marked as correct.</small>');

			return a;
		};

		this.createMatchingResponse = () => {
			let createresponseItem = (complete = true) => {
				let btnDelCont = $('<div class="removeBtn"></div>');
				let btnDel = $('<i class="fa fa-times m-auto clickable-content"></i>');
				let item = $('<div class="response-item d-flex mb-2"></div>');
					item.append( '<div class="custom_field text-boxes d-table full-width" > <input type="text" class="full-width" placeholder="Enter Answer"> </div>' );
					if(complete){
						item.append( '<div class="arrow"> <i class="fa fa-arrows-h m-auto"></i></div>' );
						item.append( '<div class="custom_field text-boxes d-table full-width" > <input type="text" class="full-width" placeholder="Enter Answer"> </div>' );
					}
					
					btnDel.click(function(){
						item.remove();
					});

					btnDelCont.append(btnDel);
					item.append(btnDelCont);

				return item;

			};

			let a = $('<div class="matching mt-3 response-div"></div>');
			let b = $('<div class="mt-5 additional-answers">');
				b.append('<h3 class="normal-title"> Additional Answers </h3>');
				b.append('<small class="font-italic text-info" > Addtional answers can be provided to increase the difficulty of a matching question </small>');
									
			let i = this;

			for(let x = 0;x < 3; x++){
				a.append( createresponseItem() );
			}


			let button = $('<button class="btn btn-primary mt-2"> <i class="fa fa-plus"></i> Add Response</button>');
			let button2 = $('<button class="btn btn-primary mt-2"> <i class="fa fa-plus"></i> Add Additional Answer</button>');
		
				button.click(function(){
					createresponseItem().insertBefore( button );
				});

				button2.click(function(){
					createresponseItem(false).insertBefore(button2);
				});

			b.append( createresponseItem(false) );
			b.append(button2);
			a.append(button);
			a.append(b);

			return a;
		};

		this.createMultipleAnswerResponse = () => {
			let a = $('<div class="multiple_answer mt-3 response-div"></div>');
			let i = this;
			for(let x = 0;x < 3; x++){
				a.append( this.createInputBoxes(x,false) );
			}

			setTimeout( () => {
				getTotals();
			},100)


			let button = $('<button class="btn btn-primary mt-2"> <i class="fa fa-plus"></i> Add Response</button>');
		
				button.click(function(){
					i.createInputBoxes(undefined,false).insertBefore( button );
				});

			a.append(button);

			return a;
		};


		let responseDiv = $('<div class="quiz-responses mt-3"></div>');
			responseDiv.append('<p class="normal-title"> Responses </p>');
		
		let response;
		
		
		if( this.selectedType == 0 ) 		response =  this.createTrueFalseResponse(i.qnum);
		else if(this.selectedType == 1) 	response =  this.createMultipleChoiceResponse()
		else if( this.selectedType == 3 ) 	response =  this.createFillTheBlanksResponse();
		else if( this.selectedType == 4 ) 	response =  this.createMatchingResponse();
		else if( this.selectedType == 5 ) 	response =  this.createMultipleAnswerResponse();

		this.responses = response;
		if( !isUpdate ){
			responseDiv.append(response);
			return responseDiv;
		}

	};

	this.createGradingSection = () =>{

		let gradingDiv = $('<div class="grading d-table full-width mt-5"></div>'),
			left = $('<div class="pull-left form-group"></div>'),
			right = $('<div class="pull-right"></div>'),
			input = $('<input type="number" value="1" min="1" class="form-control" name="points" style="width:70px;display: initial;">'),
			btnClone = $('<button class="btn btn-info mr-2"> <i class="fa fa-clone"></i> Duplicate Question </button>'),
			btnDel = $('<button class="btn btn-danger"> <i class="fa fa-trash"></i> Delete Question </button>'),
			i = this;


			gradingDiv.append('<p class="normal-title"> Grading </p>');
			left.append('<span> Points per correct answer : </span>');

			input.val( i.questionPoints );


			input.on('input',function(){
				i.questionPoints = parseInt( $(this).val() );
				getTotals();
			});

			btnClone.click(function(){
				// console.log('-------------------');
				let newitem = Object.assign(Object.create(Object.getPrototypeOf(i)), i) ;
					
					newitem.setNum( i.qnum + 1 );
				// questions.splice( i.qnum, 0, newitem );
				console.log(newitem);
				i.QuestionItem.after(newitem.QuestionItem ); 
			});

			btnDel.click(function(){
				i.QuestionItem.remove();
				questions.splice( i.qnum - 1, 1);
				updateQuestionNumbers();
			});


			left.append(input);
			// right.append(btnClone);
			right.append(btnDel);

			gradingDiv.append(left);
			gradingDiv.append(right);

			this.grading = gradingDiv;
			return this.grading;

	};

	

	this.getJSONObject = () => {
		let obj = {
			type  : this.selectedType,
			Question  : this.Question,
			attachments : [],
			questionPoints : this.questionPoints,
			responses : '',
			points : this.questionPoints,
			total_points : this.getTotalPoints()
		};  

		if( obj.type == 0 ){
			obj['responses'] = this.QuestionItem.find('.response-item.selected input').val();
		}else if( obj.type == 1 || obj.type == 5 ){
			obj['responses'] = [];
			this.QuestionItem.find('.response-item').each(function(a,b){
				obj['responses'].push( {
					text : $(b).find('input[type="text"]').val(),
					ischecked : $(b).find('input[type="'+  ( obj.type == 1 ? 'radio' : 'checkbox' )  +'"]').is(':checked')
				} );
			});
		}else if ( obj.type == 4 ){
			obj['responses'] = {  matches : [] , fakes : []  }; 
			this.QuestionItem.find('.response-div > .response-item').each(function(a,b){
				let aaa = [];
				$(b).find('.custom_field').each(function(c,d){
					aaa.push( $(d).find('input').val() );
				});
				obj['responses']['matches'].push(aaa);
			});

			this.QuestionItem.find('.response-div > .additional-answers > .response-item').each(function(a,b){
				obj['responses']['fakes'].push( $(b).find('.text-boxes input').val());
			});
		}else if( obj.type == 3 ){
			obj['responses'] = [];
			this.QuestionItem.find('.fill_in_the_blanks input[type="text"]').each(function(a,b){
				obj['responses'].push($(b).val());
			});
		}
		


		return obj;
	};

	this.getTotalPoints = () => {
		let pointMultiplier = 0;
		if(this.selectedType >= 0 && this.selectedType <= 2) pointMultiplier = 1;
		else if( this.selectedType == 3) pointMultiplier = this.QuestionItem.find('.fill_in_the_blanks input').length;
		else if ( this.selectedType == 4 ) pointMultiplier = this.QuestionItem.find('.matching.response-div > .response-item').length; 
		else if( this.selectedType ==  5) {
			this.QuestionItem.find('.response-item').each(function(a,b){
				 pointMultiplier += $(b).find('input[type="checkbox"]').is(':checked') ? 1: 0;
			});
		}
		return this.questionPoints * pointMultiplier;
	}


} 

 
jQuery(function($){
	
	
	iniQuiz();
}); 

const submitQuiz = () => {
	let form = $('#submitQuiz');
	let dataSend = getTaskDataObject(form);
	dataSend['duration'] = form.find('input[name="duration"]').val();
	dataSend['questions'] = [];
	questions.forEach(e => {
		dataSend['questions'].push(e.getJSONObject());
	});

	dataSend['totalpoints'] = 0;
	dataSend['questions'].forEach(function(a){
		dataSend['totalpoints'] = dataSend.totalpoints + a.total_points;
	});

	let data = { data: JSON.stringify(dataSend)  };
	
	if( teacherEdit ){
		data['tid'] = TI.tsk_id;
		data['qid'] = TI.quiz_id;
	}

	$.ajax({
		url: SITE_URL + USER_ROLE + '/creatTask/0',
		type: 'post',
		dataType : 'json',
		data: data,
		success: function(Response) {
			if( Response.Error == null ){
				$('.modal').modal('hide');
				
				notify('success', Response.msg, () => {
					if( teacherEdit ){
						window.location.reload();
					}else{
						window.location.href=  SITE_URL + USER_ROLE + '/classes/class-' + activeClass;
					}
					
				});
			}
	   },error:function(e){
		   alert('error occured, see console.');
		   console.log(e.responseText);
	   }
   });
}


const iniQuiz = () => {

	const inst = this;

	if( isQuizview ){
		let countdownInterval;
		let timer_min = quiz_duration - 1;
		let timer_sec = 59;
		
		this.countdowntimer = () => {
			countdownInterval = setInterval( () => {
				if( timer_min < 10 ) timer_min = '0'+timer_min;
				if( timer_sec < 10 ) timer_sec = '0'+timer_sec;


				$('.countdown-timer strong').html( timer_min + ':' + timer_sec );

				 timer_min = Number(timer_min);
				 timer_sec = Number( timer_sec );
				
				
				if( timer_min == 0 && timer_sec == 0 ){
							notify('error','Time is up',undefined,false,5000);
							inst.submitQuiz();
				} else if(  ( 
						(timer_min % 5 == 0 && timer_sec == 0 ) && timer_min < 20 ) ||  
						( timer_min == 1 && timer_sec == 0 )
					) notify('warning', 'Remaining time :' + timer_min +' minutes',undefined, false,5000);
				 

				if(timer_sec == 0){
					timer_min--;
					timer_sec = 10;
				}
				timer_sec--; 
			},1000);
		}

		this.submitQuiz = () => { 
			clearInterval( countdownInterval ); 
			$('#student-quiz-view .overlay-loading').css('display','flex');
			$('.submitQuiz').prop('disabled',true);

			let quizResponses = [];

			$('#questions-list-frontend .question-item').each(function(a){
				let answers = [];
				let dataType = parseInt($(this).attr('data-type'));
				if( [0,1,5].indexOf( dataType ) > -1 ){
					$(this).find('.response-item.selected').each(function(){
						if( $(this).attr('data-index') ){
							answers.push(   $(this).attr('data-index')   );
						}
					});
				}else if( dataType == 2 ){
					answers.push( $(this).find('.short-answer-response-item').text().trim('Place your answer here').trim() );
				}else if( dataType == 3 ){
					$(this).find('.response-div input').each( function(){
						answers.push(   $(this).val()   );
					});
				}else if( dataType == 4 ){
					$(this).find('.matching-item').each(function(){
						left = $(this).find('.box').first().text().trim();
						right = $(this).find('.box').last().text().trim();
						answers.push({ left : left, right : right });
					});
				}
				 
				quizResponses[a] = answers;
			}); 

			let durationconsumed =  quiz_duration - timer_min;
			let durationconsumed_sec = (59 - timer_sec);

			if(timer_sec != 0 ){
				durationconsumed-= 1;
				
				if( durationconsumed < 10 )  durationconsumed = '0'+ durationconsumed;
				if( durationconsumed_sec < 10 )  durationconsumed = '0'+ durationconsumed_sec;

				durationconsumed =  durationconsumed + ':' + durationconsumed_sec; 
			}else{
				if( durationconsumed < 10 )  durationconsumed = '0'+ durationconsumed;
				durationconsumed = durationconsumed + ':00';
			}
 
			console.log({ answers : quizResponses, quiz : quiz,task: task,duration : durationconsumed });
			// submit to backend
			$.ajax({
				url: SITE_URL + 'student/submitQuizAnswers',
				type: 'post',
				dataType : 'json',
				data: { answers : JSON.stringify(quizResponses), quiz : quiz,task: task,duration : durationconsumed },
				success: function(Response) {
					console.log(Response);
					if( Response.Error == null ){
						$('.modal').modal('hide');
						notify('success','Quiz has been Submitted,  you will be redirected to view page in a few minutes. ',() => {
							window.location.href = SITE_URL + USER_ROLE + '/quiz/view:' + quiz;
						},true,5000);
					}
			   },error:function(e){
				   alert('error occured, see console.'); 
			   }
		   }); 


			
		};
		$('.control-btn').on('click',function(){
			 
			if($(this).hasClass('disabled')) return;

			let ind = $('#questions-list-frontend .question-item.active').index();

			if( $(this).hasClass('prev-btn') ){
				ind -= 1;
			}else{
				ind += 1;
			} 

			$('#questions-list-frontend .question-item').removeClass('active');
			$('#questions-list-frontend .question-item').eq(ind).addClass('active');

			$('.question-number').text( ind + 1 );
 
			if( ind == 0 ){
				$('.prev-btn').addClass('disabled');
			}else if(ind == __q__.length - 1){
				$('.nxt-btn').addClass('disabled');
			}else{
				$('.prev-btn,.nxt-btn').removeClass('disabled');
			}
		});
		
		$('.startquiz').on('click',function(e){
			e.preventDefault();
			$('#student-quiz-view .overlay-loading').css('display','none');
			$(this).hide();
			$('.submitQuiz').show();
			$('#student-quiz-view .panel-footer .pull-right').show();
			countdowntimer();
			quizStarted = true;
		});

		$('.submitQuiz').on('click',function(e){
			e.preventDefault();
			
			inst.submitQuiz();
		});

		iniQuizQuestions();
	}else{
		this.checkQuestions = () => {
			let noerror = true;

			if($('input[name="title"]').val() == '' ){
				notify('error', 'Test title unspecified');
				return false;
			}else if( $('input[name="instruction"]').val() == '' ){
				notify('error', 'Instruction unspecified');
				return false;
			}

			$('#questions-list .question-item').each( function(a,b){
				let item = $(this);
				let eltoScroll = undefined;
				if(item.find('.question-textarea').val() == ''){
					item.find('.question-textarea').addClass('error');
					eltoScroll = item.find('.question-textarea');
					notify('error', 'No question specified on question #' + (a + 1) + '. Please remove if not needed' );
				}else{
					let qtype = item.find('select[name="quiztype"]').val();
					if((qtype == 0 || qtype == 1 || qtype == 5) && item.find('.response-item.selected').length == 0){
						notify('error', 'No Response selected/given on question #' + (a + 1) );
						eltoScroll = item.find('.response-div');
					}else if ( qtype == 3){
						console.log(item.find('.question-textarea').val().indexOf('_'));
						if( item.find('.question-textarea').val().indexOf('_') == -1 ){
							item.find('.question-textarea').addClass('error');
							eltoScroll = item.find('.question-textarea');
							notify('error', 'Not a proper question on question #' + (a + 1) );
						}else{
							let hasvalue = false;
							item.find('.response-div input').each(function(){
								if($(this).val() != '') { hasvalue = true; return false;}
							});

						
							if( !hasvalue ){
								eltoScroll = item.find('.response-div');
								notify('error', 'No Response selected/given on question #' + (a + 1) );
							}  
						}
						
					}else if ( qtype == 4 ){
						item.find(' .response-div > .response-item').each(function(){
							if( $(this).find('.custom_field').eq(0).find('input').val() == '' || $(this).find('.custom_field').eq(1).find('input').val() == '' ){
								eltoScroll = $(this).find('.custom_field').eq(0);
								notify('error', 'There is an improper match on question #' + (a + 1) );
								return false;
							} 
						});
					}

				}

				if( eltoScroll && eltoScroll.length > 0 ){
					noerror = false;
					$('html, body').animate({
						scrollTop: eltoScroll.offset().top - 80
					}, 300);
					return false;
				}

			});
			console.log(noerror);
			return noerror;

			
		};

		this.setUpSubmitModalEdits = () => {
			let modal = $('#submitQuiz');
			let duedate = moment( TI.tsk_duedate );

			modal.find('.duedate-fg input.datepicker').datepicker('setDate', duedate.toDate());
			modal.find('.duedate-fg [name="time_h"]').val( duedate.format('h'));
			modal.find('.duedate-fg [name="time_m"]').val( duedate.format('m'));
			modal.find('.duedate-fg [name="time_a"]').val( duedate.format('a'));
			modal.find('[name="duration"]').val( TI.quiz_duration );

			modal.find('.bootstrap-select button').prop('disabled',true);

			if( TI.tsk_lock_on_due == 1 ){
				modal.find('[name="islockondue"]').parent().addClass('checked');
				modal.find('[name="islockondue"]').parent().find('input').prop('checked',true);

			}else{
				modal.find('[name="islockondue"]').parent().removeClass('checked');
				modal.find('[name="islockondue"]').parent().find('input').prop('checked',false);
			}

			let options = JSON.parse( TI.tsk_options );

			if( options.isaddtogradebook == 'true'  ){
				modal.find('[name="isaddtogradebook"]').parent().addClass('checked');
				modal.find('[name="isaddtogradebook"]').parent().find('input').prop('checked',true);
			}else{
				modal.find('[name="isaddtogradebook"]').parent().removeClass('checked');
				modal.find('[name="isaddtogradebook"]').parent().find('input').prop('checked',false);
			}

			if( options.israndomize   == 'true'){
				modal.find('[name="israndomize"]').parent().addClass('checked');
				modal.find('[name="israndomize"]').parent().find('input').prop('checked',true);
			}else{
				modal.find('[name="israndomize"]').parent().removeClass('checked');
				modal.find('[name="israndomize"]').parent().find('input').prop('checked',false);
			}

			if( options.ishowresult  == 'true' ){
				modal.find('[name="ishowresult"]').parent().addClass('checked');
				modal.find('[name="ishowresult"]').parent().find('input').prop('checked',true);
			}else{
				modal.find('[name="ishowresult"]').parent().removeClass('checked');
				modal.find('[name="ishowresult"]').parent().find('input').prop('checked',false);
			}





		};

		$('.addAnotherQuestion').on('click',function(){
			let newQuestionnum = questions.length + 1;
			let newQuestion = new quizItem( newQuestionnum );
			questions.push(newQuestion);
			newQuestion.createForm();
			setTimeout(() => {
				getTotals();
			},100);
		});
	
		$('.createQuiz').on('click',function(){
			if( inst.checkQuestions() ){
				if( teacherEdit ){
					inst.setUpSubmitModalEdits();
				}

				$('#submitQuiz').modal('show');
			}
		});

		



	
		$('.submitQuiz').on('click',function(){
			submitQuiz();
		});
		
		

		$('.jumptoinput').on('input',(e) => { 
			let a = $(e.target).val(); 
			if( questions[a - 1] ){
				$('html, body').animate({
					scrollTop: questions[a - 1].QuestionItem.offset().top - 80
				}, 300);
			}
		});
		
		if( teacherEdit){
			quiz_questions.forEach( function(v,K){
				let newQuestion = new quizItem( (K+1), v.Question, v.type,v.responses, v.points );
				questions.push(newQuestion);
				newQuestion.createForm();
			});
		}else{
			$('.addAnotherQuestion').trigger('click');
		}
		
		
	}
} 


const getTotals = () => {
	$('.total-question').html( questions.length );
	let totalPoint = 0;

	questions.forEach( (a) => {
		totalPoint+= a.getTotalPoints();
	});

	$('.total-point').html( totalPoint);

};

const updateQuestionNumbers = () => {
	questions.forEach( (a,b) => {
		a.setNum(b+1);
	});
}


const iniQuizQuestions = ( )=> {
	this.createForm = (b,answer) => {
		this.createInputBoxes = ( b ,useRadio = true,index,uuid) => {
			let a =  $('<div class="custom_field text-boxes d-flex full-width img-capable mt-2 response-item" data-index="'+index +'">	 \
							<p class=""><strong class="mr-1">'+ ( String.fromCharCode( index + 65 )  ) +'.</strong> ' +  b.text  +'</p>\
						</div>'),
				f =  $('<div class="radioboxinput mr-3 mt-auto mb-auto"><div class="frontend"></div> <input type="radio" name="question__'+  uuid +'_response_multiple_choice"> </div>');
				g =  $('<div class="custom-checkbox mr-3 mt-auto mb-auto"><input type="checkbox" name=""><span class="checkbox fa fa-check"></span></div>');

				a.append(b);
				a.prepend( useRadio ? f : g);

				a.click(function(e){
					if( useRadio && (!(a.find('.radioboxinput').is( $(e.target) ) || a.find('.radioboxinput').has( $(e.target) ).length > 0 ))) {
						a.find('.radioboxinput').trigger('click');
					}else if( !(a.find('.custom-checkbox').is( $(e.target) ) || a.find('.custom-checkbox').has( $(e.target) ).length > 0 ) ){
						a.find('.custom-checkbox .checkbox').trigger('click');
					}
				});

				if( (studQuizView && answer) || !VQWS ){

					let score = { c: 0 ,o : 0,m : 0};
					a.addClass('unclickable');
					if( answer && answer.indexOf( (index).toString() ) > -1 ){
						a.addClass( 'selected-answer' );
						f.addClass('checked');
						f.find('input').prop('checked',true);
						g.addClass('checked');
						g.find('input').prop('checked',true);
						
						if(b.ischecked == 'true') score['c'] = score.c + 1;
						else score['m'] = score.m + 1;
					} 

					if(b.ischecked == 'true'){
						a.addClass('correct-answer');
						score['o'] = score.o + 1;
					}

					return { el : a, sc : score };
				}


				return a;
		};

		this.createTrueFalseResponse = ( R ) =>{
			let uuid = create_UUID().replace(/-/g, "");
			let sc = { c: 0 , o : 1 };

			temp = $('<div class="row true_false_response response-div">\
					<div class="col col-lg-6 col-md-6 col-sm-12">\
						<div class="custom_field radioboxinput-container p-3 d-table full-width response-item" data-index="true" >\
							<span class="text pull-left"> True </span>\
							<div class="radioboxinput mr-2 m-auto pull-right">\
								<div class="frontend"></div>\
								<input type="radio" name="question_'+ uuid +'_response" value="true">\
							</div>\
						</div>\
					</div>\
					<div class="col col-lg-6 col-md-6 col-sm-12">\
						<div class="custom_field radioboxinput-container p-3 d-table full-width response-item" data-index="false" >\
							<span class="text pull-left"> False </span>\
							<div class="radioboxinput mr-2 m-auto pull-right">\
								<div class="frontend"></div>\
								<input type="radio" name="question_'+uuid +'_response" value="false">\
							</div>\
						</div>\
					</div>\
				</div>');
			 
			if( answer ){
				temp.find('.response-item').addClass('unclickable');
				temp.find('[data-index="'+ answer[0] +'"]').addClass('selected-answer'); 
				temp.find('[data-index="'+ answer[0] +'"] .radioboxinput').addClass('checked');
				temp.find('[data-index="'+ answer[0] +'"] .radioboxinput input').prop('checked',true);

				if( answer[0] == b.responses ) { 
					temp.find('.selected-answer').addClass('correct-answer');
					sc['c'] = 1;
				}else{
					temp.find('[data-index="'+ b.responses +'"]').addClass('correct-answer');
					temp.find('.selected-answer').addClass('incorrect-answer');
				}

				return  { el : temp, sc : sc };
			}else if( !VQWS ){
				temp.find('[data-index="'+ b.responses +'"]').addClass('correct-answer');
				temp.find('.response-item').addClass('unclickable');
			}
			return temp;
		};

		this.createMultipleChoiceResponse = ( R ) => {
			let a = $('<div class="multiple_choice_response mt-3 response-div"></div>');
			let i = this;
			let score = { c:0,o:0 };
			let uuid = create_UUID().replace(/-/g, "");
			R.forEach( (b,c) => {
				let aaa = this.createInputBoxes(b,true,c ,uuid);
				a.append( aaa.el ? aaa.el : aaa );
				if( studQuizView && answer ){
					score['c'] = score.c + aaa.sc.c;
					score['o'] = score.o + aaa.sc.o;
				}

			});  

			if( studQuizView && answer ) return { el : a, sc : score};
			return a;
		};

		this.createFillTheBlanksResponse = ( R,RR ) => {
			let text  = R
			
			
			let a = $('<div class="fill_in_the_blanks mt-3 response-div"></div>'),
				b = $('<div class="text"></div>'),
				 
				lastTextUnderscore = text.trim().charAt(text.length - 1) == '_' ;

				text = text.split('_').filter(item => item).join('_');

				let temp = text;

				text = text.replace(/_/g, '<input type="text" placeholder="Enter Answer">');

				if( lastTextUnderscore ){
					text += '<input type="text" placeholder="Enter Answer">';
					temp += '_';
				}

				b.append(text);
				a.append(b);

				if( !VQWS ){
					b.find('input').each( (c,d) => {
						$(d).val( RR[c] ).prop('readonly',true);
					 });
				}else if( studQuizView && answer ){
					strFullSentence = '';
					let score = { c: 0, o : RR.length};

					b.find('input').each( (c,d) => { 
						$(d).attr('readonly',true);
						if( answer[c] != undefined ){
							$(d).val( answer[c] != undefined ? answer[c]: '' );
							
							if(answer[c] == RR[c]){
								$(d).addClass( 'correct-answer');
								score['c'] = score.c + 1;
							}else{
								$(d).addClass( 'incorrect-answer');
							} 
							
						}else{
							$(d).addClass(  'incorrect-answer');
						}
					});

					//  show full sentence
					tempcounter = 0;
					for( var x = 0; x <temp.length;x++){
						
						if( temp.charAt(x) == '_' ){
							strFullSentence += '<strong> '+ RR[tempcounter] +' </strong>';
							tempcounter++;
							continue;
						}
						strFullSentence += temp.charAt(x);
					}

					return { el : a, sc:score, cb : () => {
						a.append('<p class="ml-3"><strong> Full Text: </strong> '+ strFullSentence +'</p>');
					}};
				}
			return a 
		};

		this.createMatchingResponse = ( R ) => {	
			this.creatematchingItem = (a,right,i) => {
				let b = $('<div class="matching-item">\
							<div class="box"> <p class="m-auto"> '+ a +' </p> </div>\
							<div class="connector"> <i class="fa fa-arrows-h m-auto"></i> </div>\
						</div>');
				let c = $('<div class="box empty droppable-box">  </div>');

				if((studQuizView && answer )){
					c.addClass('has-answer');
					c.append('<div class="answer m-auto">'+ right +'</div>');
					b.append(c);

					if( R.matches[i][1] == right ){
						b.addClass('correct-answer');
						return {el : b, c : 1 };
					}
					return {el : b, c : 0 };
					
				}else{
					c.droppable({
						accept: '.draggable-box',
						over: function(event, ui) {
							// console.log('OVERRRRRRRR');
						},
						drop: function(event, ui) { 
						  //Get dragged Element (checked)
						  draggedElement = $(ui.draggable);
					  
						  //Get dropZone where element is dropped (checked)
						  dropZone = $(event.target);
					  
						  //Move element from list, to dropZone (Change Parent, Checked)
						  $(dropZone).append(draggedElement);
					  
						  //Get current position of draggable (relative to document)
						  var offset = $(ui.helper).offset();
						  xPos = offset.left;
						  yPos = offset.top;
						  $('#posX').text('x: ' + xPos);
						  $('#posY').text('y: ' + yPos);
						  
						  //Move back element to dropped position
						  $(draggedElement).css('top', yPos).css('left', xPos);
					  
						//   console.log(draggedElement.position());
						},
					  })
					  b.append(c);
					  if( right ){
						c.append('<div class="answer m-auto">'+ right +'</div>');
					  }
					return b; 
				}
			};

			this.createAsnwersColumn = (a) => {
				let b = $('<div class="draggable-box" data-value=""> <i class="fa fa-ellipsis-v mr-1"></i> <i class="fa fa-ellipsis-v"></i> <p class="m-auto"> '+ a +' </p> </div>');
					b.draggable({
						revert: function(){

						}, 
						helper: 'clone',
						opacity: '0.7',
						stop: function(event, ui) {
							console.log('STOPPPPPP');
							console.log(event,ui);
							// console.log(event);
							// console.log(ui);
						  //Move back element to dropped position
						//   $(draggedElement).css('top', yPos).css('left', xPos);
						}
					  });
				return b;
			};
			

			let a = $('<div class="matching mt-3 response-div"></div>');
				a.append()
				 a.append('<div class="row">\
								<div class="col-sm-8 matching-div">\
									<p class="small"> Drag and drop items the answer columns to match Column A </p>\
									 <div class="matching-columns"></div>\
								</div>\
								<div class="col-sm-4 answers-div">\
									<p class="small	"> Answer Choices</p>\
									\
								</div>\
							</div>');
			let dropablebox = $('<div class="draggable-answers"></div>');
				dropablebox.droppable({
							accept: '.draggable-box',
							over: function(event, ui) {
								// console.log('OVERRRRRRRR');
							},
							drop: function(event, ui) { 
							//Get dragged Element (checked)
							draggedElement = $(ui.draggable);
						
							//Get dropZone where element is dropped (checked)
							dropZone = $(event.target);
						
							//Move element from list, to dropZone (Change Parent, Checked)
							$(dropZone).append(draggedElement);
						
							//Get current position of draggable (relative to document)
							var offset = $(ui.helper).offset();
							xPos = offset.left;
							yPos = offset.top;
							$('#posX').text('x: ' + xPos);
							$('#posY').text('y: ' + yPos);
							
							//Move back element to dropped position
							$(draggedElement).css('top', yPos).css('left', xPos);
						
							//   console.log(draggedElement.position());
							},
						})
				a.find('.answers-div').append(dropablebox);
									
			let i = this;
			let colA = [];
			let colB = [];
			let colAns = [];
			if( (studQuizView && answer)){
				let score = {c :0, o :answer.length};
				answer.forEach( (b,c) => {
					let aaa = this.creatematchingItem(b.left,b.right,c);
					score['c'] = score.c + aaa.c;
					a.find('.matching-columns').append( aaa.el );
				});
				a.append(b);
				return  { el : a, sc : score };
			}else{
				 
				R.matches.forEach( b => {
					colA.push(b[0]);
					colB.push(b[1] );
					colAns.push(b[1]);
				});
	
				R.fakes.forEach( b => {
					colB.push(b);
				});
				
				 
				colA.forEach( (bb,cc) => {
					if( !VQWS ){
						a.find('.matching-columns').append( this.creatematchingItem(bb,colAns[cc],cc) );
					}else{
						a.find('.matching-columns').append( this.creatematchingItem(bb) );
					}
				
				});

				colB.forEach( bb => {
					a.find('.draggable-answers').append( this.createAsnwersColumn(bb) );
				});

				a.append(b);
			 
				return a;
			}
			
			
			  
			
		};

		this.createMultipleAnswerResponse = ( R ) => {
			let a = $('<div class="multiple_answer mt-3 response-div"></div>');
			let i = this;
			let score = {c : 0,o : 0, m : 0};
			let uuid = create_UUID().replace(/-/g, "");
			R.forEach( (b,c) => {
				let aaa = this.createInputBoxes(b,false,c ,uuid);
				a.append( aaa.el ? aaa.el : aaa );
				if( studQuizView && answer ){
					score['c'] = score.c + aaa.sc.c;
					score['o'] = score.o + aaa.sc.o;
					score['m'] = score.m + aaa.sc.m;
				}
			});  

			setTimeout( () => {
				getTotals();
			},100)
			 
			if( studQuizView && answer ){
				return  { el : a, sc : score };
			}
 

			return a;
		};

		this.createShortAnswerResponse = () => {
			let a = $('<div class="response-div">');
				b = $('<div class="short-answer-response-item act-as-textarea" contenteditable="true" placeholder="Place your answer here"> Place your answer here </div>');
				

				b.on('focus',function(){ 

					if( $(this).text().trim() == $(this).attr('placeholder') ){
						$(this).text('');
					}  
				}).on('blur',function(){
					if( $(this).text().trim() == '' ){
						$(this).text( $(this).attr('placeholder') );
					}
				});
				if( studQuizView ){
					b.prop('contenteditable',false);
					if( answer ) b.text( answer[0] );
				}

				a.append(b);
			return a;	
		}
		 
		if( b.type == 0 ) return this.createTrueFalseResponse( b.responses ) ;
		else if( b.type == 1 ) return this.createMultipleChoiceResponse( b.responses ) ;
		else if( b.type == 3 ) return this.createFillTheBlanksResponse( b.Question,b.responses ) ;
		else if( b.type == 4 ) return this.createMatchingResponse( b.responses ) ;
		else if( b.type == 5 ) return this.createMultipleAnswerResponse( b.responses ) ;
		else if( b.type == 2 ) return this.createShortAnswerResponse();  
	}


	this.createQuizFn = () => {

	}
	

	const ins = this;
	const types = [  
		'Select True or False',
		'Multiple Choice',
		'Short Answer Question',
		'Complete the sentence by filling out the blanks',
		'Match column A with column B',
		'Multiple Answer ::  Select all that appplies'];
	
	$('.overview-items .overview-item').remove();

	let totalPoints = { c: 0, o :0};
	$.each( __q__,function(a,b){
		let aa = $('<div class="question-item"></div>');
		let left = $('<div class="left" style="border-right: none; left: -15px; position: relative; margin-left: -15px;">\
						<div class="ribbon left-ribbon ribbon-primary ribbon1">\
							<div class="content">\
								<span class="" style="font-size: 23px; font-weight: 700;">Q. </span><span class="question-number" style="padding:0;"> 1</span>\
							</div>\
						</div>\
					</div>');
		let right = $('<div class="right"></div>');
		
		right.append('<p class=" mb-1	direction"> <strong>Direction : </strong>'+ types[ b.type ] +'</p>');
		
		 
		if( b.type != 3 ){
			right.append('<p class="question-question mb-1"> <strong>Question : </strong>'+ b.Question +'</p>');
		}

		right.append('<p class=" mb-1 points"> <strong>Points/answer : </strong>'+ b.points +'</p>');

		if( a == 0 ){
			aa.addClass('active');
		}

		let dflex = $('<div class="question-info"></div>');
		dflex.append(left);
		dflex.append(right);
		aa.append(dflex	);	

		 
		if( typeof quiz_answers !== 'undefined' ){
			var FR = ins.createForm(b, studQuizView && quiz_answers[a] ? quiz_answers[a] : undefined);
		}else{
			var FR = ins.createForm(b);
		}
		
		let callback = FR.cb; 
		let score = FR.sc; 

		if( score ){
			let p = (score.c * b.points);
			if( b.type == 5 ){
				m = (score.c - score.m) < 0 ? 0 : score.c - score.m;
				p = (m * b.points); 
				right.append('<p class=" mb-1 points"> <strong>Correct answer : </strong>'+ score.c +'</p>');
				right.append('<p class=" mb-1 points"> <strong>Wrong answer : </strong>'+ score.m +'</p>');
			}
		
			right.append('<p class=" mb-1 points"> <strong>Points earned : </strong>'+ p +'</p>');
		}


		FR = FR.el ? FR.el : FR;
					
		aa.append( FR ); 
		aa.attr('data-type',b.type);
		$('#questions-list-frontend').append( aa );
		 

		if( !studQuizView ){
			if( b.type == 0 || b.type == 1 ){
				FR.find('.custom_field').on('click', () => {
					 $('.overview-items .overview-item').eq( a ).removeClass('unanswered'); });
			}else if ( b.type == 2 ){
				FR.find('.short-answer-response-item').on('input',function(){
					if($(this).text().trim() != '' )  $('.overview-items .overview-item').eq( a ).removeClass('unanswered'); 
					else $('.overview-items .overview-item').eq( a ).addClass('unanswered');
				});
			}else if ( b.type == 3 ){
				let inputs = FR.find('input[type="text"]');
			
				inputs.on('change',function(){ 
					let has1Value = false;
					inputs.each( function(){  
						if($(this).val() !== ''){
							has1Value = true;
							return false;
						}
					 } );
	
					if( has1Value ) $('.overview-items .overview-item').eq( a ).removeClass('unanswered');
					else $('.overview-items .overview-item').eq( a ).addClass('unanswered');
				});
				
			}else if ( b.type == 4 ){
				FR.find('.draggable-answers .draggable-box').on('dragstop',function(){
					let hasAnswer = false;
					FR.find('.matching-columns .matching-item').each( function(){
							if($(this).find('.box.droppable-box').text().trim() != '') {
								hasAnswer = true; 
								return false;
							}
					}); 
					if( hasAnswer )  $('.overview-items .overview-item').eq( a ).removeClass('unanswered'); 
					else $('.overview-items .overview-item').eq( a ).addClass('unanswered');
				});
			}else if ( b.type == 5 ){
				FR.find('.custom_field').on('click',function(){ 
					if( FR.find('> .custom_field.selected').length > 0 ) $('.overview-items .overview-item').eq( a ).removeClass('unanswered'); 
					else $('.overview-items .overview-item').eq( a ).addClass('unanswered'); 
				});
			}
		}
		

		if(typeof callback == 'function'){
			callback();
		}

		
		// overview
		overviewitem = $('<li class="overview-item unanswered" > Question '+ (a+1) +' </li>');
	 
		if( studQuizView && b.type != 2 && typeof quiz_answers !== 'undefined' && quiz_answers[a] ){
			// compute Remarks  
			let r = score.c == score.o ? 1 : score.c == 0 ? 3: 2;
			overviewitem.removeClass('unanswered').addClass('remark-' + r);
			overviewitem.append('<span class="score">'+ score.c + '/' + score.o   +'</span>');
			 
		}


		overviewitem.on('click',function(){
			if( !quizStarted && !studQuizView ){  notify('error', 'Quiz has not started yet.',undefined,false ); return; }
			$('#questions-list-frontend .active').removeClass('active');
			$('#questions-list-frontend .question-item').eq(a).addClass('active');

			$('.question-number').text( a + 1 );
 
			if( a == 0 ){
				$('.prev-btn').addClass('disabled');
			}else if(a == __q__.length - 1){
				$('.nxt-btn').addClass('disabled');
			}else{
				$('.prev-btn,.nxt-btn').removeClass('disabled');
			}

		});
		$('.overview-items').append(overviewitem);
 

	});

	// $()
	 
}

