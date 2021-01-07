




//  temporary Data,  this should be coming from the server
const tempData = [
					{ 
						type : '0',
						question : 'Example True or False ....  Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud.',
						attachments  : [
											{name : 'Link Attachment',size :'',type :'link',link :'https://www.google.com'},
											{name : 'File Attachment',size: '17Mb',type : 'file', link : ''}
										]
					},
					{ 
						type : '1',
						question : 'Example Multiple Choices .... Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud.',
						responses : [ 
										{  text : 'Example Choice 1' },
										{  text : 'Example Choice 2' },
										{  text : 'Example Choice 3' },
										{  text : 'Example Choice 4' },
									]
					},
					{ 
						type : '2',
						question : 'Example Short Answer .... Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud.'
					},
					{
						type: '3',
						question : 'Example Fill in the blanks .. Lorem  _ ipsum dolor __ sit amet, _ consectetur adipiscing _ elit, sed do eiusmod tempor incididunt ut labore et dolore'
					},
					{
						type: '4',
						question : 'Example Matching .. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud.',
						responses : {
										left : [
												 { text : 'Example left Match 1' },
												 { text : 'Example left Match 2' },
												 { text : 'Example left Match 3' },
										],
										right : [
												  {  text : 'Eample right Match 1' },
												  {  text : 'Eample right Match 2' },
												  {  text : 'Eample right Match 3' },
												  {  text : 'Eample right Match 4' },
												  {  text : 'Eample right Match 5' },
										]
						}
					},
					{ 
						type : '5',
						question : 'Example Multiple Answer .... Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud.',
						responses : [ 
										{  text : 'Example Multiple Answer 1' },
										{  text : 'Example Multiple Answer 2' },
										{  text : 'Example Multiple Answer 3' },
										{  text : 'Example Multiple Answer 4' },
									]
					},
];




let questions = [];

let formcontainer = $('#questions-list');

function quizFormStudent(qNum,Question,Type,Response,Note,QPN,attachments){
	this.qnum = qNum;
	this.Question = Question;
	this.Note = '';
	this.responses = Response;
	this.selectedType = Type;
	this.QuestionItem = $('<div class="question-item"></div>');
	this.QuestionsListContainer = $('#questions-list');
	this.pointNote = QPN;
	this.attachments = attachments;
	this.selectionTypes = [ 
			'True/False',
			'Multiple Choice',
			'Short Answer',
			'Fill in the blanks',
			'Matching',
			'Multiple Answers',
	];
	this.rightContent = '';

 
	this.createQuestion = () => {
		let left = $('<div class="left">\
						<div class="ribbon left-ribbon ribbon-primary ribbon1">\
							<div class="content">\
								<span class="question-number"> '+ this.qnum +'</span> </div>\
							</div>\
						</div>' );
		rightContent = $('<div class="right"></div>');
		rightContent.append( this.createQuestionSection() );
		rightContent.append( this.createAttachmentSection() );
		rightContent.append( this.createResponsesSection() );


		this.QuestionItem.append(left);
		this.QuestionItem.append(rightContent);
		this.QuestionsListContainer.append(this.QuestionItem);
	};

	this.createQuestionSection = () => {
		let a = $('<div class="form-group question-question">\
						<div class="d-flex">\
							<div>\
								<span class="nowrap d-block font-bold">Type : </span>\
							</div>\
							<div>\
								<span class="d-block font-bold"> '+  this.selectionTypes[ this.selectedType ]  +' </span>	\
							</div>\
						</div>\
					</div>');

		if( this.selectedType != 3 ){
			let b = '<span class="font-bold mr-3 nowrap question-left"> Question : </span>';
			let c = '<p class="question-right">'+ this.Question +'</p>';

			a.find(' > div > div:first-child').append(b);
			a.find(' > div > div:last-child').append(c);
		}
			

		return a;
	};

	this.createAttachmentSection = () => {
		if( this.attachments ){
			let attachmentsDiv	= $('<div class="attachment-list mt-3"></div>');
				attachmentsDiv.append('<small class="small-title font-italic"> Attachments ::  </small>');
				this.attachments.forEach( (a) => {
					let b = new Attachment(a.name, a.size, a.type, a.link);
					attachmentsDiv.append( b.createAttachmentFrontend() );
				});
				

			return  attachmentsDiv;
		}

		return '';
		
	}

	this.createResponsesSection = () => {
		let createChoiceBoxes = (ind,data, useRadio = true) => {
			let cont = $('<div class="col-sm-12 col-md-6 col-lg-6 mb-2"></div>');

			let a =  $('<div class="custom_field text-boxes d-flex img-capable clickable-content">\
							<span class="font-bold big-text mr-2"> '+ String.fromCharCode( ind + 65 ) +'. </span>\
							<span class="m-auto ml-0">'+ data.text +'</div\
					</div>'),
				f =  $('<div class="radioboxinput m-auto mr-0"><div class="frontend"></div> <input type="radio" name="question_'+ this.qnum +'_response_multiple_choice"> </div>');
				g =  $('<div class="custom-checkbox mr-0"><input type="checkbox" name=""><span class="checkbox fa fa-check"></span></div>');



				a.addClass( useRadio ? 'radioboxinput-container' : 'custom-checkbox-container');

				a.click(function(){
					if( useRadio ){
						$(this).addClass('selected-option');
						$(this).parent().siblings().find('.custom_field').removeClass('selected-option');
					}else{
						$(this).toggleClass('selected-option');
					}
				});

				

				a.append( useRadio ? f : g);
				cont.append(a);
				return cont;
		};

		let createTrueFalseResponse = () =>{
			return '<div class="row true_false_response response-div">\
		        		<div class="col col-lg-6 col-md-6 col-sm-12">\
		        			<div class="custom_field radioboxinput-container p-3 d-table full-width" >\
		        				<span class="text pull-left"> True </span>\
		        				<div class="radioboxinput mr-2 m-auto pull-right">\
					                <div class="frontend"></div>\
					                <input type="radio" name="question_1_response">\
					            </div>\
		        			</div>\
		        		</div>\
		        		<div class="col col-lg-6 col-md-6 col-sm-12">\
		        			<div class="custom_field radioboxinput-container p-3 d-table full-width" >\
		        				<span class="text pull-left"> False </span>\
		        				<div class="radioboxinput mr-2 m-auto pull-right">\
					                <div class="frontend"></div>\
					                <input type="radio" name="question_1_response">\
					            </div>\
		        			</div>\
		        		</div>\
		        	</div>';
		};

		let createMultipleChoiceResponse = () => {
			let a = $('<div class="multiple_choice_response mt-3 response-div"></div>');
			let r = $('<div class="row"></div>');
			let i = this;

			this.responses.forEach( (b,c) => {
				r.append( createChoiceBoxes(c,b) );
			});
			a.append(r);

			return a;
		};

		let createFillTheBlanksResponse = () => {
			let text  = this.Question

			let a = $('<div class="fill_in_the_blanks mt-3 response-div"></div>'),
				b = $('<div class="text"></div>'),
				ispreviousUnderscore = false,
				lastTextUnderscore = text.trim().charAt(text.length - 1) == '_' ;

				text = text.split('_').filter(item => item).join('_');
				text = text.replace(/_/g, '<input type="text" placeholder="Enter Answer">');

				if( lastTextUnderscore ){
					text += '<input type="text" placeholder="Enter Answer">';
				}

				b.append(text);
				a.append(b);
				a.append('<small class="font-italic text-danger mt-3"> <span class="font-bold"> Note : </span> Students will have to answer in the exact order for the question to be marked as correct.</small>');

			return a;
		};

		let createMatchingResponse = () => {
			let createresponseItem = (selection,data,key,column = 'left') => {
				let item = $('<div class="matching-item d-flex mb-2"></div>');
				let prefix = key + 1;
					if(selection){
						item.append( $('<div class="selection"></div>').append(selection) );
					}

					if(column == 'right') prefix = String.fromCharCode( key + 65 );

					item.append('<div class="text"><span class="big-text font-bold"> '+ prefix +'. </span> <span> '+ data.text +' </span></div>')

				return item;

			};

			let a = $('<div class="matching mt-3 response-div"></div>'),
				b = $('<div class="row"></div>'),
				left = $('<div class="col-sm-12 col-md-7 col-lg-7"><h3 class="text-center large-text font-bold"> Column A </h3> <div class="contents"></div></div>'),
				right = $('<div class="col-sm-12 col-md-5 col-lg-5"> <h3 class="text-center large-text font-bold"> Column B </h3> <div class="contents"></div> </div>'),
				selection = $('<select><option></option></select>');

			this.responses.right.forEach( (rV,rK) =>{
				selection.append('<option value="'+ rK +'">'+ String.fromCharCode( rK + 65 ) +'</option>');
				right.append( createresponseItem( undefined, rV, rK, 'right') );
			});

			selection.on('change',function(){
				console.log('change');

			});


			this.responses.left.forEach( (lV,lK) => {
				console.log(selection.find('option').length);
				left.append( createresponseItem(selection.clone(),lV, lK) );
			});


			b.append(left);
			b.append(right);
			a.append(b);
			return a;
		};

		let createMultipleAnswerResponse = () => {
			let a = $('<div class="multiple_answer mt-3 response-div"></div>');
			let r = $('<div class="row"></div>');
			let i = this;

			this.responses.forEach( (b,c) => {
				r.append( createChoiceBoxes(c,b,false) );
			});
			a.append(r);

			return a;
		};
		let createShortAnswerResponse = () => {
			let a = $('<div class="short_answer mt-3 response-div">\
						<textarea class="short-answer-input" placeholder="Place your answer here..."></textarea>\
						</div>');

			return a;
		};


		let responseDiv = $('<div class="quiz-responses mt-3"></div>');
			
		if( this.selectedType != 3 ){
			responseDiv.append('<p class="normal-title"> Responses </p>');
		}


		let i = this;
		let response;

		if( this.selectedType == 0 ){
			response =  createTrueFalseResponse();
		}else if(this.selectedType == 1){
			response =  createMultipleChoiceResponse()
		}else if( this.selectedType == 2 ){
			response = createShortAnswerResponse();
		}else if( this.selectedType == 3 ){
			response = createFillTheBlanksResponse();
		}else if( this.selectedType == 4 ){
			response = createMatchingResponse();
		}else if( this.selectedType == 5 ){
			response = createMultipleAnswerResponse();
		}

		
		responseDiv.append(response);
		return responseDiv;
		

	};
}

	

jQuery(  () =>{
	iniQuizStudent();
});


var iniQuizStudent = () => {
	tempData.forEach( (a,b) => {
		console.log();
		let quizItemObject = new quizFormStudent(  b+1, a.question, a.type, a.responses, a.note, a.qpn, a.attachments );
			questions.push(quizItemObject);
			quizItemObject.createQuestion();
	});
} 