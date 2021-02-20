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
		$vars['duetasks'] = $this->getDueTask();

 

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
			$vars['duetasks'] = $this->getDueTask();

			

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

			


			$classid = $this->insertIfnotexist( 	
				$argsCheck, array( 'data' => $dataToinsert, 'table' => 'classes' ), array(),
			  	TRUE,
			  	TRUE);
			
			
			$this->JSONENCODE_CONDITION( 
				$classid,
				"Your class $className has been created.",
				'Failed to create class,  something went wrong.',
				array( 'code' => $classCode,'id'	=> $classid  )
			);

			if( $classid ){
				$postAdd = array(
					'class_id'			=>  $classid,
					'cg_period_name'	=>	1, 
				);
				$this->ProjectModel->insert_CI_Query( $postAdd, 'class_grading_periods' );
			}

 
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
		$classSingularInfo = $this->prepare_query( $classSingularArgs )->result_array();
		$classSingularInfo = $classSingularInfo[0];

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
		
		$members = $this->GET_CLASS_STUDENTS($id,'cred_id as user_id, ui_profile_data, concat( ui_firstname, " ", ui_lastname )  as studname' );
		
		$dataPass = array(
						'classinfo' 	=> 	$classSingularInfo,
						'classesInfo'	=>	$classes,
						'modals'		=> 	$this->projectModals('class-singular',array('codemodal')),
						'nav'			=> array( 'menu'	=> 'class' ),
						'pageTitle'		=> 'Class Information',
						'projectScripts'	=> array(
													'../plugins/jszip.min',
													'../plugins/jszip-utils.min',
													'../plugins/FileSaver.min',
													'project.class', 
													'project.library',
													'project.attachments',
													'project.assignment',
													'project.post'),
						'projectCss'		=> array('project.library'),
						'posts'			=> $this->getPosts($id),
						'duetasks'		=> $this->getDueTask( $id ),
						'members'		=> $members

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
						'select'	=> 'tsk_title, tsk_id,tsk_type,tsk_duedate,timestamp_created as assigned_date,tsk_status,is_reviewed',
						'from'		=> 'tasks as tsk',
						'where'		=> array( 
									array( 'field' => '(select count(c.class_id) from li_classes c join li_task_class_assignees tca on tca.class_id = c.class_id  where c.teacher_id = '. getUserID() .') >', 'value' => 0 ) ),
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
							'select'	=> 'class_name,sc_color,c.class_id',
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
				'projectScripts'	=> array(  'Project.gradebook' ),
				'modals' 			=> $this->projectModals('gradebookModals'),
				// 'classlist'			=> $this->getClass
		);

		$classlist = array(
					'select'	=> 'class_id,class_name,sc_color',
					'from'		=> 'classes as c',
					'join'		=> array(  array( 'table' => 'settings_colors as sc', 'cond' => 'sc.sc_id = c.color_id') ),
					'where'		=> array( array( 'field' => 'teacher_id', 'value' => getUserID() ) )
		);

		$var['classlist']	= $this->prepare_query( $classlist )->result_array();

		$this->load->template('teacher/class/gradebook',$var);
	}

	private function Quizzes(){
		$seg = $this->uri->segment(4);
		$var = array( 'nav' => array( 'menu' => 'class') );
		// $seg = strpos($seg, ':') !== false ? explode(':',$seg) : $seg;

	 

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

		}else if( strpos($seg, 'view') !== false ){
			$var['pageTitle']	= 'View Quiz ';
			$var['projectScripts'] = array(	'Project.quiz', 'project.attachments' );
			$id = explode(':', $seg);
			$id = $id[1];
			$quizDetails =  array(
					'select'	=> 'quiz_questions,
									quiz_count,
									quiz_duration,
									tsk_duedate,  
									total_points as quiz_total,
									tsk_title,
									tsk_id,
									tsk_instruction,
									timestamp_created',
					'from'		=> 'tasks as tsk',
					'join'		=> array(  array( 'table' => 'quizzes as q', 'cond' => 'q.task_id = tsk.tsk_id'), ),
					'where'		=> array( array( 'field' => 'q.quiz_id', 'value' => $id ) )
			);

			$quizDetails = $this->prepare_query( $quizDetails )->result_array();

			 
			if(!empty( $quizDetails )){
				$var['QSD'] = $quizDetails[0];
				$var['isView'] = TRUE;
				$var['quizid'] = $id;
				$var['VQWS_'] = false;
				$this->load->template('student/quiz-template', $var);
			}else{
				show_404();
			} 
		}else if( strpos($seg, 'edit') !== false){
			$var['pageTitle']	= 'Create Quiz';
			$var['projectScripts'] = array('Project.quiz', 'project.attachments');
			$var['modals'] = $this->projectModals('create-quiz');
			$id = explode(':', $seg);
			$id = $id[1];

			$classesListArgs = array(  
							'select' 	=> 	'class_id,class_name',
							'from'		=>	'classes as lc',
							'where'		=> array( array( 'field' => 'lc.teacher_id', 'value'  =>  getSessionData('sess_userID')),
							array( 'field' => 'lc.class_status', 'value'  =>  1) )
			);

			$tskArgs =  array(
					'select'	=> '*',
					'from'		=> 'tasks as tsk',
					'join'		=> array( array( 'table' => 'quizzes as q', 'cond' => 'tsk.tsk_id = q.task_id') ),
					'where'		=> array( array( 'field' => 'quiz_id', 'value' => $id ) )
			);



			$task = $this->prepare_query( $tskArgs )->result_array();	

			if( !empty($task) ){
				$task = $task[0];
				$assigneeArgs = array(
					'select'	=> 'class_id',
					'from'		=> 'task_class_assignees as tca',
					'where'		=> array( array( 'field' => 'tca.task_id', 'value' => $task['tsk_id'] ) ));

				$var['assignees'] = $this->prepare_query( $assigneeArgs )->result_array();
			
				$var['classList'] = $this->prepare_query( $classesListArgs )->result_array();
				$var['TI'] = $task;
				$var['TE'] = 'true';
			
				$this->load->template('teacher/class/class-quiz', $var);
			}else{
				show_404();
			}
		}else if(strpos($seg, 'quiz') !== false ){
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
							'select'	=> 'tsq_id, duration_consumed,quiz_score,ts.ts_id,status,datetime_submitted,total_points, concat( ui_firstname," ", ui_lastname ) as studname',
							'from'		=> 'task_submissions as ts',
							'join'		=> array( 
												array( 'table' => 'task_submission_quiz as tsq', 'cond' => 'tsq.ts_id = ts.ts_id'),
												array( 'table' => 'userinfo as ui', 'cond' => 'ui.cred_id = ts.student_id'),
												array( 'table' => 'quizzes as q', 'cond' => 'q.task_id = ts.task_id'),
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
		}else if( strpos($seg, 'submission') !== false ){
			$var['projectScripts'] = array(	'Project.quiz', 'project.attachments' );
			$var['pageTitle']	= 'Submitted Quiz';
			$id = explode(':', $seg);
			$id = $id[1];

			$quizsubmissiondetaisArgs =  array(
					'select'	=> 'tsk_id,
									quiz_questions,
									quiz_count,
									quiz_id,
									quiz_duration,
									tsk_duedate,
									quiz_answers,
									duration_consumed,
									quiz_score,
									datetime_submitted,
									total_points as quiz_total,
									tsk_title,
									concat(ui_firstname," ", ui_lastname ) as studname',
					'from'		=> 'tasks as tsk',
					'join'		=> array( 
										array( 'table' => 'quizzes as q', 'cond' => 'q.task_id = tsk.tsk_id'),
										array( 'table' => 'task_submissions as ts', 'cond' => 'ts.task_id = tsk.tsk_id'),
										array( 'table' => 'userinfo as ui', 'cond' => 'ui.cred_id = ts.student_id'),
										array( 'table' => 'task_submission_quiz as tsq', 'cond' => 'tsq.ts_id = ts.ts_id')
									),
					'where'		=> array( array( 'field' => 'ts.ts_id', 'value' => $id ) )
			);

			$quizsubmissiondetais = $this->prepare_query( $quizsubmissiondetaisArgs )->result_array();

			if(!empty( $quizsubmissiondetais )){
				$var['QSD'] = $quizsubmissiondetais[0];
				$var['isView'] =  TRUE ; 
				$var['teacherView'] = true;
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
					'projectScripts'	=> array(  'project.classdue','project.assignment' ),
					'projectCss'		=> array('project.classdue'),
					'pageTitle'			=> 'Assignment Overview',
					'modals'			=> $this->projectModals()
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
							'select'	=> 'ts.ts_id,status,cred_id as userid, ass_over,datetime_submitted, tsa_id,tsa_status, ass_grade, concat( ui_firstname," ", ui_lastname ) as studname',
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

				$classesListArgs = array(  
								'select' 	=> 	'class_id,class_name',
								'from'		=>	'classes as lc',
								'where'		=> array( array( 'field' => 'lc.teacher_id', 'value'  =>  getSessionData('sess_userID')),
								array( 'field' => 'lc.class_status', 'value'  =>  1) )
				);


				


				$submissions = $this->prepare_query( $submissionArgs )->result_array();	
				$assignees = $this->prepare_query( $assigneeArgs )->result_array();	

				$submissions = array_map(function($a){
					$args = array(
								'select'	=> 'class_id',
								'from'		=> 'class_students as cs', 
								'where'		=> array( array( 'field' => 'student_id', 'value' => $a['userid'] ) )
					);
					$a['studclasses'] = $this->prepare_query( $args )->result_array();
					return $a;
				}, $submissions);

				$var['taskinfo'] = $task; 
				 $var['submissions'] = $submissions;
				 $var['assignees'] = $assignees;
				 $var['classesInfo'] = $this->prepare_query( $classesListArgs )->result_array();
				 $var['TE'] = 'true'; 
				
				$this->load->template('teacher/class/assignment-details',$var);	
			}else{
				show_404();	
			}
			
		}else if( strpos($seg, 'view') !== false ){
			 
			$var['projectCss'] = array(  'project.library' );
			$var['projectScripts'] = array(
											'../plugins/dropzone-5.7.0/dist/min/dropzone.min',
											'project.dragdrop',
											'project.library',
											'project.assignment');
			$var['pageTitle']	= 'Assignment';							
			$id = explode(':', $seg);
			$id = $id[1];


			$assD =  array(
					'select'	=> '*',
					'from'		=> 'tasks as tsk',
					'join'		=> array(  
											array( 'table' => 'assignments as a', 'cond' => 'a.task_id = tsk.tsk_id'),
											array( 'table' => 'task_class_assignees as tca', 'cond' => 'tca.task_id = tsk.tsk_id'),
											array( 'table' => 'classes c', 'cond' => 'c.class_id = tca.class_id'),
											array( 'table' => 'userinfo ui', 'cond' => 'ui.cred_id = c.teacher_id'),
										),
					'where'		=> array( array( 'field' => 'a.ass_id', 'value' => $id ) )
			);

			$assD = $this->prepare_query( $assD )->result_array();

			
			if(!empty( $assD )){
				$var['AD'] = $assD[0];
				$var['teacherview'] = true;
				$this->load->template('student/assignment-template',$var);
			}else{
				show_404();
			}

		}else if( strpos($seg, 'submission') !== false ){
			$id = explode(':', $seg);
			$id = $id[1];
			$var['projectCss'] = array( 'project.library',
											'../../plugins/dropzone-5.7.0/dist/min/dropzone.min',
										);
			$var['projectScripts'] = array(
											'../plugins/dropzone-5.7.0/dist/min/dropzone.min',
											'project.dragdrop',
											'project.library',
											'project.assignment');
			$var['pageTitle']	= 'Assignment';
			$assD =  array(
					'select'	=> 'a.task_id,
									ass_attachments,
									ass_id,
									tsk_duedate,
									tsk_instruction,
									tsk_title,
									student_id,
									(select  concat(ui_firstname, " ", ui_lastname) from li_userinfo where cred_id = ts.student_id) as studname',
					'from'		=> 'tasks as tsk',
					'join'		=> array(  
											array( 'table' => 'task_submissions ts', 'cond' => 'ts.task_id = tsk.tsk_id'),
											array( 'table' => 'assignments as a', 'cond' => 'a.task_id = tsk.tsk_id'),
										),
					'where'		=> array( array( 'field' => 'ts.ts_id', 'value' => $id ) )
			);
			
		
		$assD = $this->prepare_query( $assD )->result_array(); 
		$var['AD'] = $assD[0];
		$var['submissionCheck'] = true;
		$var['AD'][ 'submissions' ] = $this->getTaskSubmissions($assD[0] );
		$var['AD']['submissions']	= $var['AD'][ 'submissions' ][0];
		
		$this->load->template('student/assignment-template',$var);
			
		}else{
			show_404();	
		}
	}

	public function getTaskSubmissions($task,$submission_suffix = 'ass'){
		$args = array(
			'select' => '*',
			'from' => 'task_submissions as ts',
			'join'	=> array(  array(  'table'	=> 'task_submission_' . $submission_suffix . ' as si',  'cond' 	=> 'si.ts_id = ts.ts_id' ) ),
			'where'	=> array(  
								array(  'field' => 'ts.task_id',  'value'  =>  $task['task_id'] ),
								array(  'field' => 'ts.student_id',  'value'  =>  $task['student_id'] ),
							),
		); 

		return $this->prepare_query( $args )->result_array();
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

		$data = $this->input->post('data');

		$data = json_decode( $data,true );
 
		$title = $data['tasktitle'];
		$instruction = $data['instruction'];
		$otheroptions = $data['otheroptions'];
		$assignIDs = $data['assignIDs'];
		$due = $data['due'];
		$tid = $this->input->post('tid'); 



		$taskAdd = array(
					'tsk_type'			=>  $type,   // 0 = quiz, 1 = assignment
					'tsk_title'			=>	$title,
					'tsk_instruction'	=>	$instruction,
					'tsk_duedate'		=>	$due['datetime'],
					'tsk_status'		=>	1,
					'tsk_lock_on_due'		=>  $due['islockondue'] == 'true'  ? 1 : 0,
					'tsk_options'		=>  json_encode($otheroptions)
		); 

		
		if( isset( $tid ) && !is_null( $tid ) ){
			$whereArray = array( 'tsk_id' => $tid); 
			$this->ProjectModel->update($whereArray,'tasks',$taskAdd);
			$postID = null; 
			$taskID = $tid;

			$assigneeAdd = array(); 

			$ids = implode(',',$assignIDs);
			$query = 'delete from li_task_class_assignees where class_id not in ('. $ids .') and task_id = ' . $taskID;
			$this->ProjectModel->customQuery( $query );

			
			foreach( $assignIDs as $id ){
				$assigneeAdd =  array( 
					'task_id' => $taskID,
					'class_id'	=> intval($id)
				); 
				$args = array(
							'from' => 'task_class_assignees',
							'where'	=> array(
											array( 'field'	=> 'task_id', 'value' => $taskID ),
											array( 'field'	=> 'class_id', 'value' => $id )
							)
				);
				
				$this->insertIfnotexist( $args,array( 'data' => $assigneeAdd, 'table' => 'task_class_assignees' ),'Success assigned classes to task',true);
			}; 


		}else{
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
		}

		//     Check whether to add to gradebook or delte if exist
		$tskid = isset($tid) ? $tid : $taskID;
		if( $otheroptions['isaddtogradebook']  || $otheroptions['isaddtogradebook'] == 'true' ){
			$this->taskAddRemoveTaskFromGradebook($tskid,$assignIDs,'add');
		}else{
			$this->taskAddRemoveTaskFromGradebook($tskid,null,'remove');
		}
 

		if( $type == 0 ){
			$this->createQuiz($taskID,$postID,$data);
		}else{
			$this->createAssignment($taskID,$postID,$data);
		}


	}
	private function createQuiz($taskID,$postID,$data){
		 
		$duration = $data['duration'];
		$questions = $data['questions'];
		$total_points = $data['totalpoints'];
		$qid = $this->input->post('qid');


		$quizAdd = array(
					'task_id'			=> $taskID,
					'quiz_questions'	=> json_encode($questions),
					'quiz_duration'		=> $duration,
					'quiz_count'		=> count( $questions ),
					'total_points'		=> intval($total_points)
		);
		
		if( isset($qid) && !is_null($qid) ){
			$whereArray = array( 'quiz_id' => $qid); 
			$this->ProjectModel->update($whereArray,'quizzes',$quizAdd);
			$this->returnResponse('Successfully updated the quiz.'); 
		}else{
			$quizID = $this->ProjectModel->insert_CI_Query( $quizAdd, 'quizzes',true );    // Add Quiz datails
			$this->sendnewTasksEmail('Quiz',$taskID,$postID);
			$this->returnResponse('Successfully created the quiz.'); 
		}
	}

	private function createAssignment($taskID,$postID,$data){
		$aid = $this->input->post('aid');
		$assAdd = array(
			'task_id'			=> $taskID,
			'ass_attachments'	=> $this->getAttachmentsJSON()
		);

		if(  isset($aid) && !is_null($aid) ){
			$whereArray = array( 'ass_id' => $aid); 
			$this->ProjectModel->update($whereArray,'assignments',$assAdd);
			$this->returnResponse('Successfully updated the Assignment.');
		}else{
			if( $this->ProjectModel->insert_CI_Query( $assAdd, 'assignments',true ) ){
				$this->sendnewTasksEmail('Assignment',$taskID,$postID);
				$this->returnResponse('Successfully created the assignment.');
			}
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
						'select'	=> "cred_id as userid, concat(ui.ui_firstname, ' ',ui.ui_lastname) as stud_name, ui.ui_email,ui_profile_data",
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
				
				$this->addnotificationLogs( $sl['userid'], 'A new '. $taskType .' has been assigned on ' . $class['class_name'],'new-task' );

				$this->sendEmail($data, $content );
			endforeach; 
			
		endforeach; 
       
    }

	public function downloadfile($id,$type__ = null,$type2 = null){
		$this->getDownloadFile( $id,$type__,$type2 );
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
		$vars = array();
		$vars['projectScripts']	=  array( 'project.profile');
		
		$this->load->template("shared/profile", $vars);
	}

	public function postAction(){
		$id = $this->input->post('postid');
		$action = $this->input->post('action'); 
		// $actpo = $this->uri->segment(3);
		echo $this->userPostSetting_($action,$id) ;
		die();
	}

	private function getDueTask( $classID = null ){
		return $this->_getDueTasks('shared/side-due-task/die-due-template',$classID);
	}  


	public function task(){
		$action = $this->input->post('action');
		$tid = $this->input->post('tid'); 
		$whereArray = array( 'tsk_id' => $tid);
		$msg = '';

		if( $action == 'review' ){
			$reviewVal = $this->input->post('val');			
			$dataUpdate	= array( 'is_reviewed'	=> $reviewVal); 
			$msg = 'Update successful';
		}else if( $action == 'lockondue' ){
			$reviewVal = $this->input->post('val');	
			$dataUpdate	= array( 'tsk_lock_on_due'	=> $reviewVal); 
			$msg = 'Update successful';
		}else{

			$dataVal = $this->input->post('val');
			$val = isset( $dataVal ) && $dataVal != null ? $dataVal : 0;

			$dataUpdate	= array( 'tsk_status'	=> $val );
			$msg =  'Task closed succesfully';
		}

		if($this->ProjectModel->update($whereArray,'tasks',$dataUpdate)){
			if(  $action == 'review' && $reviewVal == 1 ){
				$dataUpdate	= array( 'tsk_status'	=> 0 );
				$this->ProjectModel->update($whereArray,'tasks',$dataUpdate);
			}
			echo json_encode( array( 'Error' => null, 'msg' => $msg) );
		}else{
			echo json_encode( array( 'Error' => 'An error occured, please contact support.' ) );
		}
	} 



	public function asyncSendEmail(){
		$data = $this->input->post('data');
		$content = $this->input->post('content');
		$this->sendEmail($data, $content );
	}

	public function games($type){
		$this->games__( $type );
	}
	 
	public function addGrade($type){
		$tskID = $this->input->post('tsk');
		if( $type == 'assignment' ){
			$tsaid = $this->input->post('tsaid');
			$score = $this->input->post('score');
			$over = $this->input->post('over');
			$whereArray = array( 'tsa_id' => $tsaid);
			$dataUpdate	= array( 'ass_grade'	=> $score, 'ass_over' => $over );
			if( $this->ProjectModel->update( $whereArray, 'task_submission_ass', $dataUpdate) ){
				echo json_encode( array( 'Error' => null, 'msg' => 'Successfully graded assignment'  ) );
			}else{
				echo json_encode( array( 'Error' => 'Failed to grade assignment', 'msg' => ''  ) );
			}
		}
	}

	public function videoplayurl($id){
		$this->soloVideo($id);
	}
 

	public function gradebook(){
		$action = $this->input->post('action');

		if( $action == 'addgradingperiod' ) 		$this->addgradingperiod();
		else if( $action == 'addgradeitem' ) 		$this->addgradeitem();
		else if( $action == 'getgradingperiods' ) 	$this->getClassPeriods();
		else if ( $action == 'delPeriod' ) 			$this->deleteCurrentPeriod();
		else if ( $action == 'addGradingColumn' ) 	$this->addgradingcolumn();
		else if( $action == 'getperiodtabledata' ) 	$this->getGradebooktabledata();
		else if( $action == 'delColumn' ) 			$this->delColumn();
		else if( $action == 'changePeriod' )		$this->changeColumnPeriod();
		else if( $action == 'editGrade' )			$this->updateGrades();
	}
	
	private function updateGrades(){
		$cgpc = $this->input->post('cgpc');	
		$stud = $this->input->post('stud');	
		$score = $this->input->post('score');	
		$over = $this->input->post('over');	
		
		// if( $type1 == 'manual' ){'cgpc_id' => $cgpc_stask_id, 'stud_id' =>$stud 
		$args = array( 'select' => 'cgsg_id','from' => 'class_grading_student_grades',
						'where'	=> array( 
											array( 'field' => 'cgpc_id', 'value' => $cgpc),
											array( 'field' => 'stud_id', 'value' => $stud),
										)
						);
		
		$dataInsert = array( 
							'cgpc_id' => $cgpc,
							'stud_id' => $stud,
							'cgsg_score' => $score,
							'cgsg_over' => $over, 
						);

		$t = $this->prepare_query( $args );

		if(  $t->num_rows() > 0){
			// update
			$t = $t->result_array();
			$t = $t[0];
			$whereArray = array( 'cgsg_id' => $t['cgsg_id']);  

			if($this->ProjectModel->update($whereArray,'class_grading_student_grades',$dataInsert)){
				$this->returnResponse( 'Successfully updated grade' );
			}else{
				$this->returnResponse( 'Failed to update grade' );
			}
		}else{
			// insert
			if( $this->ProjectModel->insert_CI_Query( $dataInsert, 'class_grading_student_grades',true ) ){
				$this->returnResponse( 'Successfully updated grade' );
			}else{
				$this->returnResponse( 'Failed to update grade' );
			}
			
		}
			
		// }
	}


	private function getGradebooktabledata( $cgp_id = null,$isReturn = false){
		$periodID = $this->input->post('cgp');

		if( isset($cgp_id) &&  !is_null( $cgp_id ) ){
			$periodID = $cgp_id;
		}



		$args1 = array( 'from' => 'class_grading_period_columns', 
						'where' => array( array( 'field' => 'cgp_id', 'value' => $periodID ) ) );


		$args2 = array( 'select' => 'tsk_title,tsk_options,tsk.timestamp_created,tsk_type,tsk_id,tsk_duedate',
						'from'	=> 'class_grading_period_tasks cgp',
						'join'	=>  array( array(	'table'	=>	'tasks tsk',	'cond'	=>	'tsk.tsk_id = cgp.task_id' ) ),  
						'where'	=> array( array( 'field' => 'cgp_id', 'value' =>  $periodID) ),
					);
		$headers = $this->prepare_query( $args1 )->result_array();
		$headersTasks = $this->prepare_query( $args2 )->result_array();
		
		$headersTasks = array_filter( $headersTasks,function($a){ 
			$options = json_decode($a['tsk_options'],true);

			return $options['isaddtogradebook'] || $options['isaddtogradebook'] == 'true';
		},ARRAY_FILTER_USE_BOTH);


		$headers = array_merge( $headers,$headersTasks ); 
		$headers = array_map( function($a){
			if( isset($a['tsk_title']) ){
				 $args = array( 
					 			'select'	=> 'status,student_id as stud_id,ts.ts_id',
								'from' => 'task_submissions ts',
								'join'	=> array(),
								'where'	=> array( array( 'field' => 'task_id','value'=> $a['tsk_id'] ) ));
				if( $a['tsk_type'] == 0 ){
					// fetch quiz submission info
					$args['select']	= $args['select'] . ',quiz_score,(select total_points from li_quizzes where task_id = ts.task_id ) as total_point';
					$args['join'][] = array( 'table' => 'task_submission_quiz tsq', 'cond'	=> 'tsq.ts_id = ts.ts_id' );
				}else{
					//  fetch assignment sub info
					$args['select']	= $args['select'] . ',ass_grade,ass_over';
					$args['join'][] = array( 'table' => 'task_submission_ass tsa', 'cond'	=> 'tsa.ts_id = ts.ts_id' );
				}
				unset( $a['tsk_options'] );
				// unset( $a['tsk_type'] );
				$a['grades'] = $this->prepare_query( $args )->result_array();
			}else{
				$args = array(
								'from' => 'class_grading_student_grades cgsg',
								'where'	=> array( array( 'field' => 'cgpc_id', 'value'=> $a['cgpc_id']  ) )
				);
				$a['grades'] = $this->prepare_query( $args )->result_array();
			}
			
			return $a;
		},$headers);

		// Set Order
		usort($headers, function($a, $b) { 
			return new Datetime( $b['timestamp_created'] ) > new Datetime( $a['timestamp_created'] );
		});
		
		if( !$isReturn ){
			echo json_encode($headers);
			die();
		}
		return $headers;
		
	}

	private function delColumn(){
		$cgpcID = $this->input->post('cgpc');
		if( $this->ProjectModel->delete( $cgpcID, 'cgpc_id', 'class_grading_period_columns') ){
			$this->returnResponse( 'Successfully removed column.' );
		}else{
			$this->returnResponse( null,'Failed to remove column' );
		}
	}

	private function getClassPeriods(){
		$classid = $this->input->post('class');
		
		$args = array( 'from' => 'class_grading_periods', 'where' => array(  array('field' => 'class_id', 'value' => $classid) ) );
		$data = $this->prepare_query( $args )->result_array();
	 
		$studs = $this->GET_CLASS_STUDENTS( $classid,'cred_id as user_id, concat(ui_firstname," ",ui_lastname ) as name, ui_profile_data as userimage' );
		$studs = array_map( function($a){
			$a['userimage'] = json_decode( $a['userimage'],true );
			$a['userimage'] = isset( $a['userimage']['ui_profile_image_path'] ) ? $a['userimage']['ui_profile_image_path'] : 'assets/images/user.png';
			return $a;
		},$studs);

		$var = array( 
						'periods' => $data,
						'students' => $studs
					);

		echo json_encode( $var  );
	}

	private function addgradingperiod(){
		$name = $this->input->post( 'name');
		$classid = $this->input->post( 'class');
		

		$add = array(
			'class_id '			=>  $classid,
			'cg_period_name'	=>	$name, 
		);
		$periodid = $this->ProjectModel->insert_CI_Query( $add, 'class_grading_periods',true );     // Add Post	
		
		if( $periodid ){
			echo $periodid;
			die();
		}
		echo 0;
		die();
	}

	private function addgradingcolumn(){
		$name = $this->input->post('name');
		$cgpid = $this->input->post('cgp');
		$defaultover = $this->input->post('defaultover');
		$cgpc = $this->input->post('cgpc');

		$args = array( 
						'from' => 'class_grading_period_columns',
						'where'	=> array( 
											array( 'field' =>  'cgp_id','value' => $cgpid  ),
											array( 'field' =>  'cgg_name', 'value' => $name  )
										)
					);

		$args2 = array( 'cgp_id' => $cgpid,'cgg_name' => $name ,'default_over' => $defaultover );

		
		if( isset( $cgpc )  ){
			$whereArray = array( 'cgpc_id' => $cgpc);  
			if($this->ProjectModel->update($whereArray,'class_grading_period_columns',$args2)){
				$this->returnResponse( 'Successfully updated column' );
			}else{
				$this->returnResponse( 'Failed to update column' );
			}
		}else{
			$cgpc_id = $this->insertIfnotexist( 	
					$args, array( 'data' => $args2, 'table' => 'class_grading_period_columns' ), array(),
					TRUE, TRUE);

			if( $cgpc_id ){
				$this->returnResponse('Successfully added grading column');
			}else {
				$this->returnResponse( 'Failed to add grading column' );
			}
		}


		
	}

	public function exportgradebook($periodID,$classID){
		 
		$data = $this->getGradebooktabledata( $periodID, true );
		$classStuds = $this->GET_CLASS_STUDENTS( $classID, 'cred_id as user_id, concat(ui_firstname," ",ui_lastname ) as name' ) ;
	 
		$headers = array(  'Student\'s Name' );
		
		// get header

		$rows = array();
		$totals = array();
 
		foreach( $classStuds as $stud ){
			$row = array( $stud['name'], );
			
			foreach( $data as $d ){
				
				$score = '';
				 
				if(  isset($d['tsk_id'])  ){
					
					if( !in_array( $d[ 'tsk_title' ], $headers ) ){
						$title =  $d[ 'tsk_title' ];
						if( isset( $d['grades'][0] ) ){
							if( $d['tsk_type'] == 0 ){
								$title .= ' ( ' . ( $d['grades'][0]['total_point'] ) . ' )';
								$totals[] = $d['grades'][0]['total_point'];
							}else{
								$title .= ' ( ' . ( $d['grades'][0]['ass_over'] ) . ' )';
								$totals[] = $d['grades'][0]['ass_over'];
							}
						}
						$headers[] =$title;
					}

					$grades = $d['grades'];
					if( count( $grades ) > 0 ){ 
						$id = $stud['user_id'];
						$grade = array_filter($grades, function($k) use ($id)  {
						 
							return $k['stud_id'] == $id ;
						}, ARRAY_FILTER_USE_BOTH);

						$score =  $d['tsk_type'] == 0 ? $grade[0]['quiz_score']: $grade[0]['ass_grade'];
					}
				}else{

					if( !in_array( $d[ 'cgg_name' ], $headers ) ){
						$title =  $d[ 'cgg_name' ];
						if( isset( $d['grades'][0] ) ){
							$title .= ' ( ' . ( $d['grades'][0]['cgsg_over'] ) . ' )';
							$totals[] = $d['grades'][0]['cgsg_over'];
						}

						$headers[] =$title;
					} 


					$grades = $d['grades'];
					if( count( $grades ) > 0 ){ 
						$id = $stud['user_id'];
						$grade = array_filter($grades, function($k) use ($id)  {
						 
							return $k['stud_id'] == $id ;
						}, ARRAY_FILTER_USE_BOTH);

						$score =  $grade[0]['cgsg_score'];
					}
				}

				$row[] = $score;
			}
			$rows[] = $row;
		}
		$headers[] = 'Grade';
		$headers = implode("\t", $headers);
		

		$content=ob_get_clean();
		$normalout=false;
		header( "Content-Type: application/vnd.ms-excel" );
		header( "Content-disposition: attachment; filename=learnit_gradebook_c-".$classID."_p-". $periodID ."_list.xls" );
		echo $headers. "\r\n";
		
		// var_dump($totals);
		for($x = 0; $x < count($rows); $x++){
			$row = $rows[$x];
			$totalScore = 0;
			$counter = 0;
			$totalOver = 0;
			// $totalOver = 0;
			
			for($y = 1; $y < count($row); $y++){
				$counter++;
				if( is_numeric( $row[$y] ) ) $totalScore+= intval( $row[$y] );
			}

			for($y = 0; $y < count($totals); $y++){
				$counter++;
				if( is_numeric( $totals[$y] ) ) $totalOver+= intval( $totals[$y] );
			}
			
			$rows[$x][] = number_format(( ($totalScore / $totalOver   ) * 100 ),0 ) . '%';
		} 
 
		foreach( $rows as $row ){
			echo implode("\t", $row) . "\r\n"; 
		} 

		die(); 
	}



	private function deleteCurrentPeriod(){
		$cgpid = $this->input->post( 'cgp' );

		if( $this->ProjectModel->delete( $cgpid, 'cgp_id', 'class_grading_periods') ){
			$this->returnResponse('Successfull removed class period');
		}else{
			$this->returnResponse(null,'Failed to remove class period');
		}
	}


	private function changeColumnPeriod(){
		$cgpc = $this->input->post('cgpc');
		$cgp = $this->input->post('cgp');

		$whereArray = array( 'cgpc_id' => $cgpc);  
		if($this->ProjectModel->update($whereArray,'class_grading_period_columns',array( 'cgp_id' => $cgp )  )){
			$this->returnResponse( 'Successfully updated column' );
		}else{
			$this->returnResponse( 'Failed to update column' );
		}
	}

	private function GET_CLASS_STUDENTS ($classID,$select = null,$admission = 1) {
		$members = array(  
					'select' 	=> 	!is_null($select) ? $select : '*',
					'from'		=>	'userinfo ui',
					'where'		=> array( 
										array( 'field' => 'cs.class_id', 'value'  =>  $classID),
										array( 'field' => 'cs.admission_status', 'value'  => $admission),
									),
					'join'		=> array( array(	'table'	=>	'class_students cs',	'cond'	=>	'cs.student_id = ui.cred_id' ) )
		);

		return $this->prepare_query( $members )->result_array();
	}
	



	private function taskAddRemoveTaskFromGradebook($taskid,$classids = null,$action){

		if( $action == 'add' ){
			foreach( $classids as $cid ){
				$args = array( 
									'select' => 'cgp_id',
									'from' => 'class_grading_periods', 
									'where' => array( array('field'	=> 'class_id', 'value' => $cid)),
									'order' => array( array( 'by' => 'cgp_id', 'path' => 'desc') ),
									'limit' => '1'
							);
				$periodID = $this->prepare_query( $args )->result_array();

				$periodID = $periodID[0]['cgp_id'];
							
				$this->ProjectModel->insert_CI_Query( array('cgp_id' => $periodID,'task_id' => $taskid), 'class_grading_period_tasks',true );     // Add Post
			}
		}else{
			$this->ProjectModel->delete( $taskid, 'task_id', 'class_grading_period_tasks');			
		}
	}



	public function folder(){
		$action = $this->input->post('action');

		if( $action == 'addfolder' ) $this->addFolder(); 
		else if ( $action == 'fetchfolder') $this->getFolder();
		else if( $action == 'uploadlibraryfiles' )  $this->uploadlibraryfiles();
		else if( $action == 'removeFolder' )  $this->removeFolderFile();
		else if( $action == 'shareFolder' ) $this->shareFolder();
		else if( $action == 'fetchAssignees' ) $this->fetchAssignees();
	}

	
	

	  


}

