<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Teacher extends MY_Controller {


	public function __construct() {
        parent::__construct();
        $this->checkRole('teacher');
    }


	
	public function index(){
		$vars = array();
		$vars['nav'] = array( 'menu' => 'home' );


		$vars['settings'] = $this->getSettings(); 

		// Get classes
		$classesArgs = array(
			'select' => 'lc.class_id, lc.class_name, lsc.sc_color',
			'from' => 'classes as lc',
			'where'	=> array( 
						array( 'field' => 'lc.teacher_id', 'value'  =>  getSessionData('sess_userID')),
						array( 'field' => 'lc.class_status', 'value'  =>  1),
				 ),
			'join'	=> array( array( 'table'=> 'settings_colors as lsc', 'cond' => 'lsc.sc_id = lc.color_id' ) ),
			'limit'	=> 5
		);
		// echo getSessionData('sess_userID');

		$vars['classes'] = $this->prepare_query( $classesArgs )->result_array();
		$vars['projectScripts']	=  array( 
										'project.attachments',
										'Project.post');
		$vars['modals'] = $this->projectModals();
		$vars['posts']	= $this->getPosts();

 

		//  TODO  -- GET personal info
		//  TODO  -- GET Groups
		//  TODO  get POSTS


		$this->load->template('shared/home-page',$vars);
	}

	public function classes(){
		$sub = $this->uri->segment(3);
		if( strpos($sub, 'class') !== false ){
			$this->getClassInfo();
		}else if( $sub == 'whats-due'  ){
			$this->getClassDue();
		}else if ($sub == 'gradebook'){
			$this->getClassGradebook();
		}else if($sub == 'quiz'){
			$this->Quizzes();
		}else if ( $sub == 'assignment'){
			$this->Assignments();
		}else{
			$vars = array( 
					'nav'		=> array( 'menu' => 'class') ,
					'pageTitle'	=> 'Classes',
					'modals'	=> $this->projectModals(),
					'archives_page' => FALSE
			);

			$classStatus = 1;
			if( $sub == 'archives'  ){
				$vars['archives_page'] = TRUE;
				$classStatus = 2;
			} 

			 
			$classArgs = array(
				'select' => 'lc.class_id,lc.class_name,lss.s_name,lsc.sc_color',
				'from' => 'classes as lc',
				'where'	=> array( 
								array( 'field' => 'lc.teacher_id', 'value'  =>  getSessionData('sess_userID') ),
								array( 'field' => 'lc.class_status', 'value'  =>  $classStatus ),
							 ),
				'join'	=> array(
								array( 'table'=> 'settings_subjects as lss', 'cond' => 'lc.subject_id = lss.s_id' ),
								array( 'table'=> 'settings_colors as lsc', 'cond' => 'lsc.sc_id = lc.color_id' )
				)
			);
			$vars[ 'classes' ] =  $this->prepare_query( $classArgs )->result_array();

			

			$this->load->template('teacher/class/classes-archive',$vars);	
		}

		
	}
	
	public function explore(){
		$this->load->view('teacher/explore');
	}

	public function library(){
		$this->getLibrary();
	}

	public function messages(){
		$this->getMessages();
	}
	




	public function addClass($id = null){
		try{
			$className 	= $this->input->post('class_name');
			$classAbbr 	= $this->input->post('abbr');
			$classDesc 	= $this->input->post('desc_class');
			$classGrade = $this->input->post('grade');
			$classSub 	= $this->input->post('subject');
			$classSSub 	= $this->input->post('sub_subject');
			$classColor = $this->input->post('class_color');	
			$teacherID  = getSessionData('sess_userID' );
			$classCode = $this->generateCode(
				10,
				$this->prepare_query( array( 'select' => 'class_code' , 'from' => 'classes' ))->result_array(),
				'class_code'
			);

			$argsCheck = array(
				'select' => '*',
				'from'	=> 'classes',
				'where'	=> array( 
									array( 'field' => 'class_name', 'value'  =>  $className),
									array( 'field' => 'teacher_id', 'value'  =>  $teacherID),
				)
			);

			$dataToinsert = array(
				'teacher_id' 	=> $teacherID,								
				'grade_id' 		=> $classGrade,								
				'subject_id' 	=> empty($classSSub) ? $classSub : $classSSub,								
				'color_id' 		=> $classColor,								
				'class_name' 	=> $className,								
				'class_abbr' 	=> $classAbbr,								
				'class_desc' 	=> $classDesc,								
				'class_code' 	=> $classCode,								
			);

			


			$query = $this->insertIfnotexist( 	
				$argsCheck,
			  	array( 'data' => $dataToinsert, 'table' => 'classes' ),
			  	array(),
			  	TRUE,
			  	TRUE);

			$this->JSONENCODE_CONDITION( 
				$query,
				"Your class $className has been created.",
				'Failed to update color,  something went wrong.',
				array( 'code' => $classCode,'id'	=> $query  )
			);

 
		} catch( Exception $e ){
			$this->Error404($e);			
		}
	}

	public function EditClass($action = 'r', $id = null,$statusVal){
		$this->checkAjaxRequest();

		if( $id == null ){
			$this->returnResponse(null,'Invalid class ID');
		}
		
		if( $action == 'r' ){   // remove class
			
			// check if there are studentd currently enrolled in the class.  if so,  action cancelled.

			$classStudsArgs = array(
				'select' => 'cs_id',
				'from' => 'class_students',
				'where'	=> array( array( 'field' => 'class_id', 'value'  =>  $id ) ),
			); 

			$classStuds = $this->prepare_query( $classStudsArgs );

			if( $classStuds->num_rows() > 0 ){
				$this->returnResponse(null,'Class needs to have no students to be able to delete it.');
			}

			if( $this->ProjectModel->delete( $id, 'class_id', 'classes') ){
				$this->returnResponse('Successfully deleted the class');
			}else{
				$this->returnResponse(null,'Error occurred when deleting class,  try again in a few minutes or contact support.');
			}

		}else if( $action == 'u' ){   //Update
			$whereArray = array( 'class_id' => $id);
			$dataUpdate	= array( 'class_status'	=> $statusVal );
			$action = $statusVal == 2? 'archiving' : 'reactivating';

			if($this->ProjectModel->update($whereArray,'classes',$dataUpdate)){
				$this->returnResponse(ucfirst($action. ' the class successfull.'));
			}else{
				$this->returnResponse(null,'Error occurred while '. $action .' the class,  try again in a few minutes or contact support.');
			}
		}

	}





	private function getClassInfo(){
		$sub = $this->uri->segment(3);
		$id = explode('-', $sub);
		$id = $id[1];
		$this->session->set_userdata( array( 'activeClass' => $id ) );

		$classSingularArgs = array(
							'select'	=> 'lc.class_id,
											lc.class_name,
											lc.class_code,
											lc.class_desc,
											lc.code_status,
											lc.class_status,
										    lsyl.g_name as grade, 
										    lss.s_name as subject, 
										    lss.s_abbre as subject_abbr,
										    lss.s_desc as subject_desc,
										    lsc.sc_color as color,
										    lsc.sc_text_color as tcolor',
							'from'		=> 'classes as lc',
							'join'		=> array(
											array( 'table' => 'settings_subjects as lss', 'cond' => 'lss.s_id = lc.subject_id'),
											array( 'table' => 'settings_yr_lvl as lsyl', 'cond' => 'lsyl.g_id = lc.grade_id'),
											array( 'table' => 'settings_colors as lsc', 'cond' => 'lsc.sc_id = lc.color_id')
							),
							'where'		=> array( array( 'field' => 'lc.class_id', 'value' => $id ) )
		);

		

		$classSingularInfo = $this->prepare_query( $classSingularArgs )->result_array()[0];

		$classesListArgs = array(  
							'select' 	=> 	'class_id,class_name,lsc.sc_color',
							'from'		=>	'classes as lc',
							'where'		=> array( 
												array( 'field' => 'lc.teacher_id', 'value'  =>  getSessionData('sess_userID')),
												array( 'field' => 'lc.class_status', 'value'  =>   1),
											 ),
							'join'		=> array(
											array(	'table'	=>	'settings_colors as lsc',	'cond'	=>	'lsc.sc_id = lc.color_id' )
							)
		);
		$classes = $this->prepare_query( $classesListArgs )->result_array();
 
		$dataPass = array(
						'classinfo' 	=> 	$classSingularInfo,
						'classesInfo'	=>	$classes,
						'modals'		=> 	$this->projectModals('class-singular',array('codemodal')),
						'nav'			=> array( 'menu'	=> 'class' ),
						'pageTitle'		=> 'Class Information',
						'projectScripts'	=> array( 
													'project.class', 
													'project.library',
													'project.attachments',
													'project.assignment',
													'project.post'),
						'projectCss'		=> array('project.library'),
						'posts'			=> $this->getPosts($id)

		);

		$this->load->template('teacher/class/class-singular', $dataPass);
	}

	private function getClassDue(){
		$var = array(
				'nav'	=> array( 'menu' => 'class', 'sub-menu'	=> 'whats-due' ),
				'pageTitle'	=> 'Class Dues',
				'projectCss'	=> array('project.classdue'),
				'projectScripts'	=> array( 'project.classdue')

		);

		$datetime = date_format(new Datetime(), 'Y-m-d H:i:s');
		
		$tasksArgs = array(
						'select'	=> 'tsk_title, tsk_id,tsk_type,tsk_duedate,tsk_status',
						'from'		=> 'tasks as tsk',
						'where'		=> array( array( 'field' => 'tsk_duedate > ', 'value' => $datetime ) )
			);

		$classlist = array(
						'select'	=> 'class_id,class_name,sc_color',
						'from'		=> 'classes as c',
						'join'		=> array(  array( 'table' => 'settings_colors as sc', 'cond' => 'sc.sc_id = c.color_id') ),
						'where'		=> array( array( 'field' => 'teacher_id', 'value' => getUserID() ) )
			);

		
		$tasks = $this->prepare_query( $tasksArgs )->result_array();
		$classlist = $this->prepare_query( $classlist )->result_array();

		if( !empty($tasks) ){ 

		 
			$tasks = array_map(function($a){

				$submissionArgs = array(
							'select'	=> 'count(ts_id) as submission_count',
							'from'		=> 'task_submissions as ts',
							'where'		=> array( array( 'field' => 'task_id', 'value' => $a['tsk_id'] ) )
				);

				$assignee = array(
							'select'	=> 'class_name,sc_color',
							'from'		=> 'task_class_assignees as tca',
							'join'		=> array( 
												array( 'table' => 'classes as c', 'cond' => 'tca.class_id = c.class_id'),
												array( 'table' => 'settings_colors as sc', 'cond' => 'sc.sc_id = c.color_id'),
										),
							'where'		=> array( array( 'field' => 'tca.task_id', 'value' => $a['tsk_id'] ) )
				);
				

				$a['submissions_count'] = $this->prepare_query( $submissionArgs )->result_array();
				$a['assignee'] = $this->prepare_query( $assignee )->result_array();
				return $a;
			},$tasks);
			$var['tasks'] = $tasks;
			$var['classlist'] = $classlist;
		}else{
			$var['tasks'] = array();
		}
		$this->load->template('teacher/class/whats-due',$var);
	}

	private function getClassGradebook(){
		$var = array(
				'nav'	=> array( 'menu' => 'class', 'sub-menu'	=> 'gradebook' ),
				'pageTitle'	=> 'GradeBook',
				'projectCss'	=> array('project.gradebook'),
				'projectScripts'	=> array(  'Project.gradebook' )
		);
		$this->load->template('teacher/class/gradebook',$var);
	}

	private function Quizzes(){
		$seg = $this->uri->segment(4);
		$var = array( 'nav' => array( 'menu' => 'class') );

		if ( $seg == 'createquiz'){
			$classesListArgs = array(  
							'select' 	=> 	'class_id,class_name',
							'from'		=>	'classes as lc',
							'where'		=> array( array( 'field' => 'lc.teacher_id', 'value'  =>  getSessionData('sess_userID')),
							array( 'field' => 'lc.class_status', 'value'  =>  1) )
			);

			$var['projectScripts'] = array('Project.quiz', 'project.attachments');
			$var['classList'] = $this->prepare_query( $classesListArgs )->result_array();
			$var['pageTitle']	= 'Create Quiz';
			$var['modals'] = $this->projectModals('create-quiz');
			$this->load->template('teacher/class/class-quiz', $var);

		}else if( strpos($seg, 'quiz') !== false ){
			$var['projectScripts'] = array('project.classdue');
			$var['projectCss']	= array('project.classdue');
			$var['pageTitle']	= 'Quiz Details';
			$id = explode(':', $seg);
			$id = $id[1];

			$tskArgs =  array(
						'select'	=> '*',
						'from'		=> 'tasks as tsk',
						'join'		=> array( array( 'table' => 'quizzes as q', 'cond' => 'tsk.tsk_id = q.task_id') ),
						'where'		=> array( array( 'field' => 'tsk.tsk_id', 'value' => $id ) )
				);

			$task = $this->prepare_query( $tskArgs )->result_array();	 
			if( !empty( $task ) ){
				$task = $task[0];
				$submissionArgs =  array(
							'select'	=> 'tsq_id, duration_consumed,quiz_score,ts.ts_id,status,datetime_submitted, concat( ui_firstname," ", ui_lastname ) as studname',
							'from'		=> 'task_submissions as ts',
							'join'		=> array( 
												array( 'table' => 'task_submission_quiz as tsq', 'cond' => 'tsq.ts_id = ts.ts_id'),
												array( 'table' => 'userinfo as ui', 'cond' => 'ui.cred_id = ts.student_id'),
											),
							'where'		=> array( array( 'field' => 'ts.task_id', 'value' => $task['tsk_id'] ) )
					);

				$assigneeArgs = array(
							'select'	=> 'sc.sc_color,c.class_id,class_name',
							'from'		=> 'task_class_assignees as tca',
							'join'		=> array( 
													array( 'table' => 'classes as c', 'cond' => 'c.class_id = tca.class_id'),
													array( 'table' => 'settings_colors as sc', 'cond' => 'sc.sc_id = c.color_id'),
							),
							'where'		=> array( array( 'field' => 'tca.task_id', 'value' => $task['tsk_id'] ) )
				);

				$submissions = $this->prepare_query( $submissionArgs )->result_array();	
				$assignees = $this->prepare_query( $assigneeArgs )->result_array();	

				$var['taskinfo'] = $task;
				$var['submissions'] = $submissions;
				$var['assignees'] = $assignees;


				$this->load->template('teacher/class/quiz-details', $var);
			}else{
				show_404();
			}
		}else if( strpos($seg, 'submission') !== false  ){
			$var['projectScripts'] = array(	'Project.quiz', 'project.attachments' );
			$var['pageTitle']	= 'Create Quiz';
			$id = explode(':', $seg);
			$id = $id[1];

			$quizsubmissiondetaisArgs =  array(
					'select'	=> 'ts.task_id,
									quiz_questions,
									quiz_count,
									quiz_duration,
									tsk_duedate,
									quiz_answers,
									duration_consumed,
									quiz_score,
									datetime_submitted,
									total_points as quiz_total,
									tsk_title',
					'from'		=> 'tasks as tsk',
					'join'		=> array( 
										array( 'table' => 'quizzes as q', 'cond' => 'q.task_id = tsk.tsk_id'),
										array( 'table' => 'task_submissions as ts', 'cond' => 'ts.task_id = tsk.tsk_id'),
										array( 'table' => 'task_submission_quiz as tsq', 'cond' => 'tsq.ts_id = ts.ts_id')
									),
					'where'		=> array( array( 'field' => 'ts.ts_id', 'value' => $id ) )
			);

			$quizsubmissiondetais = $this->prepare_query( $quizsubmissiondetaisArgs )->result_array();

			if(!empty( $quizsubmissiondetais )){
				$var['QSD'] = $quizsubmissiondetais[0];
				$this->load->template('student/quiz-template', $var);
			}else{
				show_404();
			}
		}else{
			show_404();
		}
	}

	private function Assignments(){
		$seg = $this->uri->segment(4); 
		if( strpos($seg, 'assignment') !== false ){
			$var = array(
					'nav'			=> array( 'menu' => 'class'),
					'projectScripts'	=> array(  'project.classdue' ),
					'projectCss'		=> array('project.classdue'),
					'pageTitle'			=> 'Assignment Overview'
			);	

			$id = explode(':', $seg);
			$id = $id[1];
			$tskArgs =  array(
							'select'	=> '*',
							'from'		=> 'tasks as tsk',
							'join'		=> array( array( 'table' => 'assignments as ass', 'cond' => 'tsk.tsk_id = ass.task_id') ),
							'where'		=> array( array( 'field' => 'tsk.tsk_id', 'value' => $id ) )
					);

			$task = $this->prepare_query( $tskArgs )->result_array();	
			if( !empty($task) ){
				$task = $task[0];

				$submissionArgs =  array(
							'select'	=> 'ts.ts_id,status, datetime_submitted, tsa_id,tsa_status, ass_grade, concat( ui_firstname," ", ui_lastname ) as studname',
							'from'		=> 'task_submissions as ts',
							'join'		=> array( 
												array( 'table' => 'task_submission_ass as tsa', 'cond' => 'tsa.ts_id = ts.ts_id'),
												array( 'table' => 'userinfo as ui', 'cond' => 'ui.cred_id = ts.student_id'),
											 ),
							'where'		=> array( array( 'field' => 'ts.task_id', 'value' => $task['tsk_id'] ) )
					);
				$assigneeArgs = array(
							'select'	=> 'sc.sc_color,c.class_id,class_name',
							'from'		=> 'task_class_assignees as tca',
							'join'		=> array( 
													array( 'table' => 'classes as c', 'cond' => 'c.class_id = tca.class_id'),
													array( 'table' => 'settings_colors as sc', 'cond' => 'sc.sc_id = c.color_id'),
							),
							'where'		=> array( array( 'field' => 'tca.task_id', 'value' => $task['tsk_id'] ) )
				);

				$submissions = $this->prepare_query( $submissionArgs )->result_array();	
				$assignees = $this->prepare_query( $assigneeArgs )->result_array();	

				 $var['taskinfo'] = $task;
				 $var['submissions'] = $submissions;
				 $var['assignees'] = $assignees;
				
				$this->load->template('teacher/class/assignment-details',$var);	
			}else{
				show_404();	
			}
			
		}else if( strpos($seg, 'submission') !== false ){
			
		}else{
			show_404();	
		}
	}



	public function remove(){
		$form = $this->input->post('form');
	}


	public function getSetting(){
		echo json_encode( $this->getSettings() );
	}

	public function UpdateCodeStatus (){
		$classid = $this->input->post('classid');
		$classid = intval($classid);
		$status = $this->input->post('status');
		$status = $status == 'unlocked' ? 1 : 0;

		$whereArray = array( 'class_id' => $classid);
		$dataUpdate	= array( 'code_status'	=> $status );
		$this->JSONENCODE_CONDITION(  $this->ProjectModel->update( $whereArray, 'classes', $dataUpdate), '', '' );
	}


	public function UpdateCodeColor (){
		$classid = $this->input->post('classid'); 
		$colorID = $this->input->post('colorid');

		$whereArray = array( 'class_id' => $classid);
		$dataUpdate	= array( 'color_id'	=> $colorID );
		$this->JSONENCODE_CONDITION(  $this->ProjectModel->update( $whereArray, 'classes', $dataUpdate), '', '' );
	}
 

	public function creatTask( $type ){
		$title = $this->input->post('tasktitle');
		$instruction = $this->input->post('instruction');
		$otheroptions = $this->input->post('otheroptions');
		$assignIDs = $this->input->post('assignIDs');
		$due = $this->input->post('due');
		
		$taskAdd = array(
					'tsk_type'			=>  $type,   // 0 = quiz, 1 = assignment
					'tsk_title'			=>	$title,
					'tsk_instruction'	=>	$instruction,
					'tsk_duedate'		=>	$due['datetime'],
					'tsk_status'		=>	1,
					'tsk_lock_on_due'		=>  $due['islockondue'] == true ? 1 : 0,
					'tsk_options'		=>  json_encode($otheroptions)
		);
		$taskID = $this->ProjectModel->insert_CI_Query( $taskAdd, 'tasks',true );
		

		$postAdd = array(
			'user_id'			=>  getUserID(),
			'post_info_ref_id'	=>	$taskID,
			'post_ref_type'		=> 	1  
		);

		$postID = $this->ProjectModel->insert_CI_Query( $postAdd, 'posts',true );     // Add Post

		//  Add Task assigned classes
		$assigneeAdd = array(); 
		foreach( $assignIDs as $id ){
			$assigneeAdd[] =  array( 
				'task_id' => $taskID,
				'class_id'	=> intval($id)
			); 
		} 

		$this->ProjectModel->insert_CI_Query( $assigneeAdd, 'task_class_assignees',false,true );

		if( $type == 0 ){
			$this->createQuiz($taskID,$postID);
		}else{
			$this->createAssignment($taskID,$postID);
		}


	}
	private function createQuiz($taskID,$postID){
		 
		$duration = $this->input->post('duration');
		$questions = $this->input->post('questions'); 
		$total_points = $this->input->post( 'totalpoints' );
		$quizAdd = array(
					'task_id'			=> $taskID,
					'quiz_questions'	=> json_encode($questions),
					'quiz_duration'		=> $duration,
					'quiz_count'		=> count( $questions ),
					'total_points'		=> intval($total_points)
		);
		
		$quizID = $this->ProjectModel->insert_CI_Query( $quizAdd, 'quizzes',true );    // Add Quiz datails
		$this->sendnewTasksEmail('Quiz',$taskID,$postID);
		$this->returnResponse('Successfully created the quiz.'); 
		
	}

	private function createAssignment($taskID,$postID){
		$assAdd = array(
			'task_id'			=> $taskID,
			'ass_attachments'	=> json_encode( array() )
		);

		if( $this->ProjectModel->insert_CI_Query( $assAdd, 'assignments',true ) ){
			$this->sendnewTasksEmail('Assignment',$taskID,$postID);
			$this->returnResponse('Successfully created the assignment.');
			
		}
		
	}

	public function sendnewTasksEmail($taskType,$taskID,$postID){	

		$classListArgs =  array(
					'select'	=> 'lc.class_id,lc.class_name',
					'from'		=> 'task_class_assignees as tca', 
					'join'		=> array(  array( 'table' => 'classes as lc', 'cond' => 'lc.class_id = tca.class_id') ),
					'where'		=> array( array( 'field' => 'tca.task_id', 'value' => $taskID ) )
		);
		$classList = $this->prepare_query( $classListArgs )->result_array();

		foreach($classList as $class):
			
			$studentsEmailsLists = array();

			$SLA =  array(
						'select'	=> "concat(ui.ui_firstname, ' ',ui.ui_lastname) as stud_name, ui.ui_email,ui_profile_data",
						'from'		=> 'class_students as cs', 
						'join'		=> array(  array( 'table' => 'userinfo as ui', 'cond' => 'ui.cred_id = cs.student_id') ),
						'where'		=> array( 
										array( 'field' => 'cs.class_id', 'value' => $class['class_id'] ),
										array( 'field' => 'cs.admission_status', 'value' => 1 ),
									)
			);

			$SL = $this->prepare_query($SLA)->result_array();
			
			
			foreach( $SL as $sl ):
				$stud_data = json_decode($sl['ui_profile_data'],true);
				$data = array(
							'receiver'  => $sl['ui_email'],
							'template'  => 'shared/email-templates/new-tasks-email',
							'subject'   => 'New '. $taskType .' Notification',
				);

				$content = array( 
								'studname' 	=> $sl['stud_name'],
								'taskname'  => $taskType, 
								'classname' => $class['class_name'], 
								'postID' 	=> $postID,
								'guardian_name'	=> $stud_data['ui_guardian_name']
							);

				$this->sendEmail($data, $content );
			endforeach;
	 
			
			
		endforeach;



       
    }

	public function downloadfile($id,$type__,$type2){
		// $id = $this->input->post('id');
		// $type__ = $this->input->post('type__');
		// $type2 = $this->input->post('type2');
		$filename = $_GET['filename'] ;
		
		 
		if($type__ == 'post'){
			$fileargs =  array(
						'from'		=> 'posts as p', 
						'where'		=> array( array( 'field' => 'p.p_id', 'value' => $id ) )
			);

			if( $type2 == 0){
				$fileargs['select']	= 'p_content';
				$fileargs['join'] =  array(  array( 'table' => 'normal_posts as np', 'cond' => 'np.np_id = p.post_info_ref_id') );
			}

			$file = $this->prepare_query( $fileargs )->result_array();
			$file = json_decode($file[0]['p_content'],true); 
			$file = $file['a'];
			$selectedfile  = array();
			foreach( $file as $f ){
				if($f['name'] == $filename){ $selectedfile = $f; }
			}
			
			$this->doDownload($selectedfile);
		} 


	
	}

	
	public function addPost(){
		$this->_addPost();
	}

	public function addComment(){
		$this->_addComment();
	}


	public function logout(){
        $this->logout_();
	}
	

	public function activities( $game = null){
		$this->getActivities($game);
	}



	public function profile(){
		$this->load->template("shared/profile");
	}








}
