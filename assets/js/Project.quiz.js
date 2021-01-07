

let questions = [];

const formcontainer = $('#questions-list');

function quizItem(QuestionNum){
	this.qnum = QuestionNum;
	this.selectionTypes = [ 
			'True/False',
			'Multiple Choice',
			'Short Answer',
			'Fill in the blanks',
			'Matching',
			'Multiple Answers',
	];

	this.Selection = undefined;
	this.Question	 = '';
	this.Note = '';
	this.responses = '';
	this.grading = '';
	this.selectedType = 0;
	this.selectedTypeString = '';
	this.QuestionItem = $('<div class="question-item"></div>');
	this.QuestionsListContainer = $('#questions-list');
	this.questionPoints = 1;
	this.attachments = [];

	this.predefinedQuestion = (questionObject) => {
		console.log(questionObject);
	};
	this.setNum = (num) => {
		this.qnum = num;
		this.QuestionItem.find('.question-number').text( this.qnum );
	}


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
			right_full.append( this.createAttachmentSection() );
			right_full.append( this.createResponsesSection() );
			right_full.append( this.createGradingSection() );
			right.append(collapsibletoggle);
			right.append(right_full);
			right.append(right_coll);


		this.QuestionItem.append(left);
		this.QuestionItem.append(right);
		this.QuestionsListContainer.append(this.QuestionItem);

		this.QuestionItem.find('[name="quiztype"]').trigger('change');
		
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
		this.createInputBoxes = (x,useRadio = true) => {
			let a =  $('<div class="custom_field text-boxes d-flex full-width img-capable mt-2 response-item"></div>'),
				b =  $('<input type="text" placeholder="Enter Answer">'),
				c =  $('<span class="inputImage m-auto"></span>'),
				d =  $('<input type="file" class="d-none" accept="image/x-png,image/gif,image/jpeg">'),
				e =  $('<span class="fa fa-image inputfileBtn clickable-content" data-toggle="tooltip" data-placement="left" data-original-title="Add an image to your Answer"></span>'),
				f =  $('<div class="radioboxinput mr-2 m-auto pull-right"><div class="frontend"></div> <input type="radio" name="question_1_response_multiple_choice"> </div>');
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

				if(x == 0){
					a.addClass('selected');
					g.addClass('checked');
					g.find('input').prop('checked',true); 
				}


				a.append(b);
				c.append(d);
				c.append(e);
				a.append(c);
				a.append( useRadio ? f : g);

				return a;
		};

		this.createTrueFalseResponse = () =>{
			return '<div class="row true_false_response response-div">\
		        		<div class="col col-lg-6 col-md-6 col-sm-12">\
		        			<div class="custom_field radioboxinput-container p-3 d-table full-width response-item selected" >\
		        				<span class="text pull-left"> True </span>\
		        				<div class="radioboxinput mr-2 m-auto pull-right checked">\
					                <div class="frontend"></div>\
					                <input type="radio" name="question_1_response" value="true" checked>\
					            </div>\
		        			</div>\
		        		</div>\
		        		<div class="col col-lg-6 col-md-6 col-sm-12">\
		        			<div class="custom_field radioboxinput-container p-3 d-table full-width response-item" >\
		        				<span class="text pull-left"> False </span>\
		        				<div class="radioboxinput mr-2 m-auto pull-right">\
					                <div class="frontend"></div>\
					                <input type="radio" name="question_1_response" value="false">\
					            </div>\
		        			</div>\
		        		</div>\
		        	</div>';
		};

		this.createMultipleChoiceResponse = () => {
			let a = $('<div class="multiple_choice_response mt-3 response-div"></div>');
			let i = this;
			for(let x = 0;x < 3; x++){
				a.append( this.createInputBoxes(x) );
			}
			


			let button = $('<button class="btn btn-primary mt-2"> <i class="fa fa-plus"></i> Add Response</button>');
		
				button.click(function(){
					i.createInputBoxes().insertBefore( button );
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
		let i = this;
		let response;

		if( this.selectedType == 0 ) 		response =  this.createTrueFalseResponse();
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
			input = $('<input type="number" value="1" min="1" class="form-control" name="points" style="width:60px;display: initial;">'),
			btnClone = $('<button class="btn btn-info mr-2"> <i class="fa fa-clone"></i> Duplicate Question </button>'),
			btnDel = $('<button class="btn btn-danger"> <i class="fa fa-trash"></i> Delete Question </button>'),
			i = this;


			gradingDiv.append('<p class="normal-title"> Grading </p>');
			left.append('<span> Points per correct answer : </span>');

			input.on('input',function(){
				i.questionPoints = parseInt( $(this).val() );
				getTotals();
			});

			btnClone.click(function(){
				// console.log('-------------------');
				let newitem = Object.assign(Object.create(Object.getPrototypeOf(i)), i) ;

					newitem.setNum( i.qnum + 1 );
				questions.splice( i.qnum, 0, newitem );

				i.QuestionItem.after(newitem.QuestionItem ); 
			});

			btnDel.click(function(){
				i.QuestionItem.remove();
			});


			left.append(input);
			right.append(btnClone);
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
			points : this.questionPoints
		};  

		if( obj.type == 0 ){
			obj['responses'] = this.QuestionItem.find('[name="question_'+ this.qnum +'_response"]').val();
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
	$.ajax({
		url: SITE_URL + USER_ROLE + '/creatTask/0',
		type: 'post',
		dataType : 'json',
		data: dataSend,
		success: function(Response) {
			if( Response.Error == null ){
				$('.modal').modal('hide');
				notify('success', Response.msg, () => {
					window.location.href=  SITE_URL + USER_ROLE + '/classes/class-' + activeClass;
				});
			}
	   },error:function(e){
		   alert('error occured, see console.');
		   console.log(e.responseText);
	   }
   });
}


const iniQuiz = () => {
	if( isQuizview ){

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


		iniQuizQuestions();
	}else{
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
			$('#submitQuiz').modal('show');
		});
	
		$('.submitQuiz').on('click',function(){
			submitQuiz();
		});
		
		$('.addAnotherQuestion').trigger('click');

		$('.jumptoinput').on('input',(e) => { 
			let a = $(e.target).val(); 
			if( questions[a - 1] ){
				$('html, body').animate({
					scrollTop: questions[a - 1].QuestionItem.offset().top - 80
				}, 300);
			}
		});
		
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

	this.createForm = (b) => {
		this.createInputBoxes = ( b ,useRadio = true,index) => {
			let a =  $('<div class="custom_field text-boxes d-flex full-width img-capable mt-2 response-item"> \
							<p class=""><strong class="mr-1">'+ ( String.fromCharCode( index + 65 )  ) +'.</strong> ' +  b.text  +'</p>\
						</div>'),
				f =  $('<div class="radioboxinput mr-3 mt-auto mb-auto"><div class="frontend"></div> <input type="radio" name="question_1_response_multiple_choice"> </div>');
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

				return a;
		};

		this.createTrueFalseResponse = ( R ) =>{
			return '<div class="row true_false_response response-div">\
		        		<div class="col col-lg-6 col-md-6 col-sm-12">\
		        			<div class="custom_field radioboxinput-container p-3 d-table full-width response-item" >\
		        				<span class="text pull-left"> True </span>\
		        				<div class="radioboxinput mr-2 m-auto pull-right">\
					                <div class="frontend"></div>\
					                <input type="radio" name="question_1_response" value="true">\
					            </div>\
		        			</div>\
		        		</div>\
		        		<div class="col col-lg-6 col-md-6 col-sm-12">\
		        			<div class="custom_field radioboxinput-container p-3 d-table full-width response-item" >\
		        				<span class="text pull-left"> False </span>\
		        				<div class="radioboxinput mr-2 m-auto pull-right">\
					                <div class="frontend"></div>\
					                <input type="radio" name="question_1_response" value="false">\
					            </div>\
		        			</div>\
		        		</div>\
		        	</div>';
		};

		this.createMultipleChoiceResponse = ( R ) => {
			let a = $('<div class="multiple_choice_response mt-3 response-div"></div>');
			let i = this;

			R.forEach( (b,c) => {
				a.append( this.createInputBoxes(b,true,c ) );
			}); 

			return a;
		};

		this.createFillTheBlanksResponse = ( R ) => {
			let text  = R
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

			return a;
		};

		this.createMatchingResponse = ( R ) => {
			this.creatematchingItem = (a) => {
				let b = $('<div class="matching-item">\
							<div class="box"> <p class="m-auto"> '+ a +' </p> </div>\
							<div class="connector"> <i class="fa fa-arrows-h m-auto"></i> </div>\
						</div>');
				let c = $('<div class="box empty droppable-box">  </div>');

					c.droppable({
						accept: '.draggable-box',
						over: function(event, ui) {
							console.log('OVERRRRRRRR');
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
					  
						  console.log(draggedElement.position());
						},
					  })



					b.append(c);
				return b; 
			};

			this.createAsnwersColumn = (a) => {
				let b = $('<div class="draggable-box"> <i class="fa fa-ellipsis-v mr-1"></i> <i class="fa fa-ellipsis-v"></i> <p class="m-auto"> '+ a +' </p> </div>');
					b.draggable({
						revert: 'valid', 
						helper: 'clone',
						opacity: '0.7',
						stop: function(event, ui) {
							console.log(event);
							console.log(ui);
						  //Move back element to dropped position
						//   $(draggedElement).css('top', yPos).css('left', xPos);
						}
					  });
				return b;
			};
			

			let a = $('<div class="matching mt-3 response-div"></div>');
				a.append()
				 a.append('<div class="row">\
								<div class="col-sm-8">\
									<p class="small"> Drag and drop items the answer columns to match Column A </p>\
									 <div class="matching-columns"></div>\
								</div>\
								<div class="col-sm-4">\
									<p class="small	"> Answer Choices</p>\
									<div class="draggable-answers"></div>\
								</div>\
							</div>');
									
			let i = this;
			let colA = [];
			let colB = [];

			R.matches.forEach( b => {
				colA.push(b[0]);
				colB.push(b[1] );
			});

			R.fakes.forEach( b => {
				colB.push(b);
			});
			

			colA.forEach( bb => {
				a.find('.matching-columns').append( this.creatematchingItem(bb) );
			});

			colB.forEach( bb => {
				a.find('.draggable-answers').append( this.createAsnwersColumn(bb) );
			});
			  
			a.append(b);

			return a;
		};

		this.createMultipleAnswerResponse = ( R ) => {
			let a = $('<div class="multiple_answer mt-3 response-div"></div>');
			let i = this;

			R.forEach( (b,c) => {
				a.append( this.createInputBoxes(b,false,c ) );
			});  

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

		this.createShortAnswerResponse = () => {
			let a = $('<div class="response-div">');
				b = $('<div class="short-answer-response-item act-as-textarea" contenteditable="true" placeholder="Place your answer here"> Place your answer here </div>');
				

				b.on('focus',function(){ 
					console.log($(this).attr('placeholder'));
					if( $(this).text().trim() == $(this).attr('placeholder') ){
						$(this).text('');
					}  
				}).on('blur',function(){
					if( $(this).text().trim() == '' ){
						$(this).text( $(this).attr('placeholder') );
					}
				});
				
				a.append(b);
			return a;	
		}

		if( b.type == 0 ) return this.createTrueFalseResponse( b.responses ) ;
		else if( b.type == 1 ) return this.createMultipleChoiceResponse( b.responses ) ;
		else if( b.type == 3 ) return this.createFillTheBlanksResponse( b.Question ) ;
		else if( b.type == 4 ) return this.createMatchingResponse( b.responses ) ;
		else if( b.type == 5 ) return this.createMultipleAnswerResponse( b.responses ) ;
		else if( b.type == 2 ) return this.createShortAnswerResponse();  

		
	}

	const ins = this;
	const types = [  
		'Select True or False',
		'Multiple Choice',
		'Short Answer Question',
		'Complete the sentence by filling out the blanks',
		'Match column A with column B',
		'Multiple Answer ::  Select all that appplies'];
	
	
	$.each( __q__,function(a,b){
		let aa = $('<div class="question-item"></div>');
		aa.append('<p class=" mb-2 direction"> <strong>Direction : </strong>'+ types[ b.type ] +'</p>');
		
		
		if( b.type != 3 ){
			aa.append('<p class="question-question mb-3"> <strong>Question : </strong>'+ b.Question +'</p>');
		}

		if( a == 0 ){
			aa.addClass('active');
		}
		aa.append( ins.createForm(b) )	; 
		$('#questions-list-frontend').append( aa );
	});

}

