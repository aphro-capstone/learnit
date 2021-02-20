<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Student extends MY_Controller {


	public function __construct() {
        parent::__construct();
		$this->checkRole('student');
		if( !$this->session->userdata('user_profile_data') ){
			$this->setSessProfileData();
		}
    }
    
	public function index(){
		$vars = array();
		$vars['nav'] = array( 'menu' => 'home' );
		$vars['projectScripts'] = array(
										'../plugins/qrcode/instascan.min',
										'Project.post'
									);
		

		$vars['settings'] = $this->getSettings(); 

		// Get classes
		$classesArgs = array(
			'select' => 'lc.class_id, lc.class_name, lsc.sc_color',
			'from' => 'class_students as lcs',
			'join'	=> array( 
							array( 
									'table'	=> 'classes as lc', 
									'cond' 	=> 'lc.class_id = lcs.class_id'
							),
							array( 
									'table'	=> 'settings_colors as lsc', 
									'cond' 	=> 'lsc.sc_id = lc.color_id'
							),
						),
			'where'	=> array( 
							array(  'field' => 'lcs.student_id',  'value'  =>  getSessionData('sess_userID') ),
							array(  'field' => 'lcs.admission_status',  'value'  =>  1 ),
							array(  'field' => 'lc.class_status',  'value'  =>  1 ),
						),
			'limit'	=> 5
		);
		// echo getSessionData('sess_userID');

		$vars['classes'] = $this->prepare_query( $classesArgs )->result_array();

		$vars['modals'] = $this->projectModals();
		$vars['posts']	= $this->getPosts();
		$vars['duetasks'] = $this->getDueTask();

		$this->load->template('shared/home-page',$vars);
	}


	public function classes(){
		$sub = $this->uri->segment(3);

		if( strpos($sub, 'class') !== false ){
			$this->getClassInfo();
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
			if( $sub == 'previous'  ){
				$vars['archives_page'] = TRUE;
				$classStatus = 2;
			} 


			$classArgs = array(
				'select' => "lc.class_id,lc.class_name,lss.s_name,lsc.sc_color, lcs.cs_id, concat( ui_firstname,' ',ui_lastname ) as teachername",
				'from' => 'classes as lc',
				'join'	=> array(
								array( 'table'=> 'settings_subjects as lss', 'cond' => 'lc.subject_id = lss.s_id' ),
								array( 'table'=> 'settings_colors as lsc', 'cond' => 'lsc.sc_id = lc.color_id' ),
								array( 'table'=> 'class_students as lcs', 'cond' => 'lcs.class_id = lc.class_id' ),
								array( 'table'=> 'userinfo as ui', 'cond' => 'ui.cred_id = lc.teacher_id' ),
				),
				'where'	=> array( 
								array( 'field' => 'lcs.student_id', 'value'  =>  getSessionData('sess_userID') ),
								array( 'field' => 'lcs.admission_status', 'value'  =>  1 ),
								array( 'field' => 'lc.class_status', 'value'  =>  $classStatus ),
							),
				
			);

			$vars['classes'] = $this->prepare_query( $classArgs )->result_array();
			$vars['duetasks'] = $this->getDueTask();

			$this->load->template('teacher/class/classes-archive',$vars);	
		}



		
	}



	private function getClassInfo(){
		$sub = $this->uri->segment(3);
		$id = explode('-', $sub);
		$id = $id[1];

		$classSingularArgs = array(
							'select'	=> 'lc.class_id,
											lcs.cs_id as student_class_id,
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
											lsc.sc_text_color as tcolor,
											concat(ui_firstname,\' \', ui_lastname) as teachername',
							'from'		=> 'classes as lc',
							'join'		=> array(
											array( 'table' => 'settings_subjects as lss', 'cond' => 'lss.s_id = lc.subject_id'),
											array( 'table' => 'settings_yr_lvl as lsyl', 'cond' => 'lsyl.g_id = lc.grade_id'),
											array( 'table' => 'settings_colors as lsc', 'cond' => 'lsc.sc_id = lc.color_id'),
											array( 'table' => 'class_students as lcs', 'cond' => 'lcs.class_id = lc.class_id'),
											array( 'table' => 'userinfo as ui', 'cond' => 'ui.cred_id = lc.teacher_id')
							),
							'where'		=> array( 
													array( 'field' => 'lc.class_id', 'value' => $id ),
													array( 'field' => 'lcs.admission_status', 'value' => 1 ),
												)
		);

		$classesListArgs = array(  
							'select' 	=> 	'class_id,class_name,lsc.sc_color',
							'from'		=>	'classes as lc',
							'join'		=> array( array(	'table'	=>	'settings_colors as lsc',	'cond'	=>	'lsc.sc_id = lc.color_id' ) ),
							'where'		=> array( array( 	'field' => 'lc.teacher_id', 'value'  =>  getSessionData('sess_userID')) )
		);

		$classSingularInfo = $this->prepare_query( $classSingularArgs );


		if(  $classSingularInfo->num_rows() > 0 ){
			$classSingularInfo = $classSingularInfo->result_array()[0];
			$classes = $this->prepare_query( $classesListArgs )->result_array();

			$members = $this->GET_CLASS_STUDENTS($id,'cred_id as user_id, ui_profile_data, concat( ui_firstname, " ", ui_lastname )  as studname' );
			$dataPass = array(
							'classinfo' 	=> 	$classSingularInfo,
							'classesInfo'	=>	$classes, 
							'nav'			=> array( 'menu'	=> 'class' ),
							'pageTitle'		=> 'Class Information',
							'projectScripts'	=> array( 
														'project.class', 
														'project.library',
														'project.attachments',
														'project.assignment',
														'project.post'),
							'projectCss'		=> array('project.library'),
							'posts'			=> $this->getPosts(),
							'modals'		=>  $this->projectModals(),
							'duetasks'		=> $this->getDueTask( $id),
							'members'		=> $members
			); 

			
			

			$this->load->template('teacher/class/class-singular', $dataPass);
		}else{
			redirect('student/classes');
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


	public function progress(){
		$vars = array();
		$vars['nav'] = array( 
					'menu' => 'Classes',
					'sub-menu'	=> 'Progress',
				 );

				 
		$vars['duetasks'] = $this->getDueTask();

		$segment = $this->uri->segment(3);
		

		if(strpos($segment, 'details:') !== false){
			$vars['projectCss'] = array('project.classdue'	);
			$this->load->template('student/progress/item-details',$vars);
		}else{
			$this->load->template('student/progress/progress-archive',$vars);	
		}
	}



	private function checkStudSubmission($quizid){
		
		$task = 'quiz';
 
		$args =  array(
				'select'	=> '*',
				'from'		=> 'quizzes as q',
				'join'		=> array(
									array( 'table' => 'tasks as tsk', 'cond' => 'q.task_id = tsk.tsk_id'),
									array( 'table' => 'task_submissions as ts', 'cond' => 'ts.task_id = tsk.tsk_id'),
								 ),
				'where'		=> array( 
									array( 'field' => 'quiz_id', 'value' => $quizid ),
									array( 'field' => 'student_id', 'value' => getUserID() ),
							)
		);

		return $this->prepare_query( $args )->num_rows() > 0;
	}


	public function quiz($quizID = null){
		if($quizID){
			$var['projectScripts'] = array(	'Project.quiz', 'project.attachments' );
			
			$id = explode(':', $quizID);
			$pref = $id[0];
			$id = $id[1]; 


			$quizDetails =  array(
					'select'	=> 'quiz_questions,
									quiz_count,
									quiz_duration,
									tsk_duedate,  
									total_points as quiz_total,
									tsk_title,
									tsk_id,
									timestamp_created',
					'from'		=> 'tasks as tsk',
					'join'		=> array(  array( 'table' => 'quizzes as q', 'cond' => 'q.task_id = tsk.tsk_id'), ),
					'where'		=> array( array( 'field' => 'q.quiz_id', 'value' => $id ) )
			);
			
			if($pref == 'view'){
				$quizDetails['select'] = $quizDetails['select'] . ',quiz_score,ts.datetime_submitted,duration_consumed,quiz_answers';
				$quizDetails['join'][] = array( 'table' => 'task_submissions as ts', 'cond' => 'ts.task_id = tsk.tsk_id');
				$quizDetails['join'][] = array( 'table' => 'task_submission_quiz as tsq', 'cond' => 'tsq.ts_id = ts.ts_id');
				$quizDetails['where'][] = array( 'field' => 'ts.student_id', 'value' => getUserID() );
			}else if( $this->checkStudSubmission($id) ){
				redirect('/student/quiz/view:' . $id, 'location');
			}

			$quizDetails = $this->prepare_query( $quizDetails )->result_array();
			
			

			



			if(!empty( $quizDetails )){
				$var['QSD'] = $quizDetails[0];
				$var['isView'] = $pref == 'view' ? TRUE : FALSE;
				$var['quizid'] = $id;
				$var['pageTitle']	= 'Quiz';
				// var_dump( $var['QSD'] ); 
				// var_dump($var['QSD']);
				$this->load->template('student/quiz-template', $var);
			}else{
				show_404();
			}
		}else{
			show_404();
		}
	}

	public function assignment($assID = null){ 
		if($assID){
			$var['projectCss'] = array( 'project.library',
											'../../plugins/dropzone-5.7.0/dist/min/dropzone.min',
										);
			$var['projectScripts'] = array(
											'../plugins/dropzone-5.7.0/dist/min/dropzone.min',
											'project.dragdrop',
											'project.library',
											'project.assignment');
			$var['pageTitle']	= 'Assignment';
			$id = explode(':', $assID);
			$id = $id[1]; 
			// Get assignmentDetails

			$assD =  array(
					'select'	=> 'a.task_id,
									ass_attachments,
									ass_id,
									tsk_duedate,
									tsk_instruction,
									tsk_title,
									concat(ui_firstname," ", ui_lastname) as teachername,
									class_name,c.class_id',
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
				$var['studentview'] = true;
				$var['AD'][ 'submissions' ] = $this->getTaskSubmissions($assD[0]['task_id'], getUserID() );

				if( count($var['AD'][ 'submissions' ]) == 0 ){
					unset( $var['AD'][ 'submissions' ] );
				}else{
					$var['AD'][ 'submissions' ] = $var['AD'][ 'submissions' ][0];
				}

				$this->load->template('student/assignment-template',$var);
			}else{
				show_404();
			}
		}else{
			show_404();
		}
	}

	public function postAttachment(){
		var_dump( $_POST);
	}

	public function joinClass(){
		$classCode = $this->input->post('classcode');
		$rejoin = $this->input->post('isRejoin');



		// if($classcode){
			// Get classes
			$classesArgs = array(
				'select' => 'class_id,class_name,teacher_id',
				'from' => 'classes',
				'where'	=> array(
								 array( 'field' => 'code_status', 'value'  => '1'  ),
								 array( 'field' => 'class_code', 'value'  => $classCode ),
								  ),
			);

			$class_id = $this->prepare_query( $classesArgs );

			//  CHeck if code exist
			if(  $class_id->num_rows() > 0  ){
				$class_id = $class_id->result_array();
				$class_id = $class_id[0];


				$classname = $class_id['class_name'];
				$class = $class_id['class_id'];
				$teacher_id = $class_id['teacher_id'];
				
				$argsCheck = array(
					'select' => 'cs_id,admission_status',
					'from'	=> 'class_students',
					'where'	=> array( 
										array( 'field' => 'student_id', 'value'  =>  getUserID() ),
										array( 'field' => 'class_id', 'value'  =>  $class),
					)
				);

				


				$cs = $this->prepare_query( $argsCheck );

				if( $cs->num_rows() > 0 ){
					$cs = $cs->result_array()[0];

					if( $cs['admission_status'] == 0 ){

						//  RE ENROLL
						
						if(  $rejoin == 'true' ){
							$whereArray = array( 'cs_id' => $cs['cs_id']);
							$dataUpdate	= array( 'admission_status'	=> 1);
							$this->JSONENCODE_CONDITION(  
												$this->ProjectModel->update( $whereArray, 'class_students', $dataUpdate),
												'Successfully re-enrolled to the class.',
												'Re-enroll process failed, contact admin.'  );
							$this->notifyNewSubjectEnroll($classname,4);
							$this->addnotificationLogs($teacher_id, 'Student \'' . getUserName() .'\' had rejoined your class \''. $classname .'\'','my-student-log');
						}else{
							echo json_encode( array( 'type' => 'confirmation')); 
						}
						
					}else{
						echo json_encode( array( 'type' => 'error', 'msg' => 'Sorry,  can\'t enroll to a subject which you are already a member'));
					}

				}else{
					$dataToinsert = array(
						'student_id' 	=> getUserID(),								
						'class_id' 		=> $class,								
					);

					$this->ProjectModel->insert_CI_Query( $dataToinsert, 'class_students' );
					$this->notifyNewSubjectEnroll($classname,3);
					$this->addnotificationLogs( $teacher_id,'A new student had joined your class \''. $classname .'\'');
					echo json_encode( array( 'type' => 'success', 'msg' => 'Successfuly joined class.'));
				}



			}else{
				echo json_encode( array( 'type' => 'error' , 'msg'	=> 'Class code do not exist!'  ) );
			}
		// }else{
		// 	show_404();
		// }

		


	}


	public function withdrawClass(){
		$classID = $this->input->post('classID');

		if($classID){
			$whereArray = array( 'cs_id' => $classID);
			$dataUpdate	= array( 'admission_status'	=> 0);
			$this->JSONENCODE_CONDITION(  
								$this->ProjectModel->update( $whereArray, 'class_students', $dataUpdate),
								'Successfully withdrawn from class.',
								'Withdrawn process unsuccesful.'  );
			 
								
			$class = $this->prepare_query(  array( 
														'select' => 'class_name,teacher_id',
														'from' => 'class_students as lcs',
														'join' => array( array(  'table'	=> 'classes as lc',  'cond' 	=> 'lc.class_id = lcs.class_id' ),  ),
														'where' => array(  array(  'field' => 'lcs.cs_id',  'value'  =>  $classID )   ) ))->result_array();
			$this->notifyNewSubjectEnroll( $class[0]['class_name'], 5 );
			$this->addnotificationLogs($class[0]['teacher_id'] ,'A Student had withdrawn from class \''. $class[0]['class_name'] .'\'','my-student-log' );
		}else{
			show_404();
		}
	}


 



	public function tasks(){
		$this->load->template('student/tasks.php');
	}


	public function library(){
		$this->getLibrary();
	}

	public function messages(){
		$this->getMessages();
	}

	public function addPost(){
		$this->_addPost();
	}

	public function addComment(){
		$this->_addComment();
	}

	public function downloadfile($id,$type__ = null,$type2 = null){
		$this->getDownloadFile( $id,$type__,$type2 );
	}

	public function activities( $game = null){
		$this->getActivities($game);
	}
	


	public function logout(){
        $this->logout_();
	}
	


	private function getStudents_classlist($select = 'lc.class_id'){
		// Get classes
		$classesArgs = array(
			'select' => $select,
			'from' => 'class_students as lcs',
			'join'	=> array( 
							array( 
									'table'	=> 'classes as lc', 
									'cond' 	=> 'lc.class_id = lcs.class_id'
							), 
						),
			'where'	=> array( 
							array(  'field' => 'lcs.student_id',  'value'  =>  getUserID() ),
							array(  'field' => 'lcs.admission_status',  'value'  =>  1 ),
						)
		);
		// echo getSessionData('sess_userID');

		return $this->prepare_query( $classesArgs );
	}


	private function setSessProfileData() {
		$PD = array(
			'select' => 'ui_profile_data',
			'from' => 	'userinfo', 
			'where'	=> array(  array( 'field' => 'cred_id', 'value'  =>  getUserID()) ,  ),
		);

		$PD = $this->prepare_query( $PD )->result_array()[0];
		$PD = json_decode($PD['ui_profile_data'],true);

		$this->session->set_userdata( 'user_profile_data',$PD );
	}

 
	
	public function notifyNewSubjectEnroll($classname,$option = 3){
		$data = array(
			'receiver'  =>  getSessionData('sess_userEmail')  ,
			'template'  => 'shared/email-templates/new-student-email',
			'subject'   => ($option == 3 ? 'Enrollment' : ( $option == 4 ? 'Reenrollment' : 'Withdrawal' )) . ' Notification',
		);

		$content = array( 
						'studname' 	=> getUserName(),
						'classname' => $classname, 
						'option'	=> $option
					);
		 
		$this->sendEmail($data, $content );

		// $SMSMESSAGE = 'Mr./Ms. ' . ucwords( getUserName() ) . ' has successfully enrolled to class ' . $classname; 
        // $msg = $this->sendSMS(getSessionData('ui_guardian_phone','ui_profile_data'), $SMSMESSAGE);  //  ALREADY WORKING !!  UNCOMMENT TO CHECK/   Commented to prevent from spending the credits. 
	}

	public function post($postID){

		if( isset($postID) ){
			$var = array( 'body_class' => 'single-post' );

			$var['post'] = $this->getSinglePost($postID);




			$this->load->template('shared/posts/post-template',$var ); 
		}else{
			show_404();
		}
		
	}

	public function submitAssignment(){
		$data = $this->input->post('data');
		$data = json_decode($data,true);
		$id =  $data['assid'];  
		$tskid = $data['tskid']; 
		$txt = $data['text'];
		$attchments = $data['attachments'];
		// TasksubmissionTable 
		$A = array(
			'task_id' 			=> $tskid,								
			'student_id' 		=> getUserID(),								
		); 
		
		$tsID = $this->ProjectModel->insert_CI_Query( $A, 'task_submissions',true );


		$SC = array();
		
		if( $txt ) $SC['text'] = $txt;
		$SC['attchments'] = $this->getAttachmentsJSON();
		
		$A = array(
			'ts_id' 				=> $tsID,								
			'submission_content' 	=> json_encode( $SC ),								
		);

		if( $this->ProjectModel->insert_CI_Query( $A, 'task_submission_ass',true ) ){
			echo json_encode(array( 'Error' => null, 'msg' => 'Successfuly submitted assignment' ));

			$args  = array( 'select'  => 'teacher_id,tsk_title',
							'from' => 'task_submissions ts',
							'join'	=> array(
											array( 'table' => 'task_class_assignees as tca','cond' => 'tca.task_id = ts.task_id '),
											array( 'table' => 'tasks as tsk','cond' => 'tsk.tsk_id = ts.task_id'),
											array( 'table' => 'class_students cs','cond' => 'cs.class_id = tca.class_id'),
											array( 'table' => 'classes c','cond' => 'c.class_id = cs.class_id'),
							),'where' => array(  
											array( 'field' => 'ts.student_id', 'value' => getUserID() ),
											array( 'field' => 'cs.student_id', 'value' => getUserID() ),
											array( 'field' => 'ts.ts_id', 'value' => $tsID ),
							)
						);
			$t = $this->prepare_query( $args )->result_array();
			$t = $t[0];

			$this->addNotificationLogs( $t['teacher_id'] ,'Student \''. getUserName() .'\' had submitted an answer for assignment : ' . $t['tsk_title'] );
			die();
		}

		echo json_encode(array( 'Error' => 'Failed to submit assignment', 'msg' => null ));
		die();
	}


	public function getTaskSubmissions($taskID, $studID = null,$submission_suffix = 'ass'){

		$args = array(
			'select' => '*',
			'from' => 'task_submissions as ts',
			'join'	=> array(  array(  'table'	=> 'task_submission_' . $submission_suffix . ' as si',  'cond' 	=> 'si.ts_id = ts.ts_id' ) ),
			'where'	=> array(  array(  'field' => 'ts.task_id',  'value'  =>  $taskID )),
		);

		if( $studID ) 
			$args['where'][] = array( 'field' => 'ts.student_id', 'value' => $studID  );

		return $this->prepare_query( $args )->result_array();
	}



	public function submitQuizAnswers(){
		$answers = $this->input->post('answers');
		$quizID = $this->input->post('quiz');
		$tsk = $this->input->post('task');
		$duration = $this->input->post('duration');
		$A = array(
			'task_id' 			=> $tsk,								
			'student_id' 		=> getUserID(),								
		);

		$tsID = $this->ProjectModel->insert_CI_Query( $A, 'task_submissions',true );



		$A = array(
			'ts_id' 			=> $tsID,								
			'quiz_answers' 		=> json_encode($answers),
			'duration_consumed' => $duration,
			'quiz_score'		=> $this->checkQuizAnswers($quizID,json_decode($answers),true)					
		);

		if( $this->ProjectModel->insert_CI_Query( $A, 'task_submission_quiz',true ) ){

			$args  = array( 'select'  => 'teacher_id,tsk_title',
							'from' => 'task_submissions ts',
							'join'	=> array(
											array( 'table' => 'task_class_assignees as tca','cond' => 'tca.task_id = ts.task_id '),
											array( 'table' => 'tasks as tsk','cond' => 'tsk.tsk_id = ts.task_id'),
											array( 'table' => 'class_students cs','cond' => 'cs.class_id = tca.class_id'),
											array( 'table' => 'classes c','cond' => 'c.class_id = cs.class_id'),
							),'where' => array(  
											array( 'field' => 'ts.student_id', 'value' => getUserID() ),
											array( 'field' => 'cs.student_id', 'value' => getUserID() ),
											array( 'field' => 'ts.ts_id', 'value' => $tsID ),
							)
						);
			$t = $this->prepare_query( $args )->result_array();
			$t = $t[0];

			$this->addNotificationLogs( $t['teacher_id'] ,'Student \''. getUserName() .'\' had taken th quiz : ' . $t['tsk_title'] );

			echo 1;
			die();
		}

		echo 0;

	}


	private function checkQuizAnswers($quizid, $answers,$returnScore = false){
		
		$args = array(
			'select' => 'quiz_questions',
			'from' => 'quizzes',
			'where'	=> array( 
							array(  'field' => 'quiz_id',  'value'  =>  $quizid ),
						)
		);


		// echo getSessionData('sess_userID');

		$questions = $this->prepare_query( $args )->result_array(); 
		$questions = json_decode( $questions[0]['quiz_questions'] ,true);
		$hasShortAnswer  = false;

		$score = 0; 	
		// var_dump($answers);
		for ($i=0; $i < count($questions); $i++) { 
			// echo '<br>---------------------------------------------------------------------------<br><br>';
			$question = $questions[$i];
			
			
			// if( !isset( $answers[$i] ) ) continue;
			$answer = $answers[$i]; 
			
			$responses = $question['responses'] ;

			if( $question['type'] == 0 &&  $responses == $answer[0] ){   // TRUE OR FALSE
				$score += intval( $question['points'] );
			}else if( $question['type'] == 1 ){    // Mulitple Choice
				$correctAnswerindex = null;

				for($x = 0; $x < count( $responses ); $x++):
					if( $responses[$x]['ischecked'] == 'true' ):
						$correctAnswerindex = $x;
						break;
					endif;
				endfor;
				
				if( $correctAnswerindex == $answer[0] ){ $score+= intval( $question['points'] ); };	
			}else if ($question['type'] == 2 ){ // Short Answer/ Essay
				$hasShortAnswer = true;
			}else if( $question['type'] == 3 ){  // Fill in the blanks
				for($x = 0; $x < count( $responses ) ; $x++ ){
					if( $responses[$x] == $answer[$x] ) { $score +=  intval( $question['points'] ); };
				}
			}else  if ( $question['type'] == 4 ){   // matching type
				$matches = $question['responses']['matches'];
				for( $x = 0; $x < count($answer); $x++ ){
					if(is_object($answer[$x]))  $answer[$x] = json_decode(json_encode( $answer[$x] ),true);
					if($answer[$x]['right'] == $matches[$x][1]){
						$score+= intval( $question['points'] ); 
					}
				}
			}
			else if( $question['type'] == 5 ){   // multiple answers
				$answer = array_values( $answer );

				$correct = 0;
				$mistake = 0;
				// $question['toSub_mistakes'] = true;   //    MUST DELETE LATER,   ONLY FOR TESTING PURPOSES
	
				for($x = 0; $x < count( $answer ); $x++):
					if(in_array($x,$answer )) :
						if( $responses[$x]['ischecked'] == 'true' ){
							$correct++;
						}else{
							$mistake++;
						}
					endif;
				endfor; 	

				$left = $correct - $mistake;
				if($left < 0) $left = 0;
				$score +=  $left * intval( $question['points'] ); 
			}
		}  

		
		return $score;

	}


	public function postAction(){
		$id = $this->input->post('postid');
		$action = $this->input->post('action'); 
		// $actpo = $this->uri->segment(3);
		echo $this->userPostSetting_($action,$id) ;
		die();
	}


	private function getDueTask($classid = null){
		return $this->_getDueTasks('shared/side-due-task/side-due-template',$classid);
	}  

	public function games($type){
		$this->games__( $type );
	}

	public function videoplayurl($id){
		$this->soloVideo($id);
	}


	
 	
	public function getDownloadablefiles($ID){
		$this->load->library('zip');

		$folderID = $this->input->post('folder');
		
		if( isset( $ID )){
			$folderID = $ID;
		}
		
		$args = array('from' => 'library_folders','where' => array( array( 'field'=>'lf_id','value'	=> $folderID ) ));
		$folder = $this->prepare_query( $args )->result_array();


		$files = array( 'from' => 'library_folder_files' ,'where' => array( array( 'field' => 'folder_id', 'value' => $folderID ) ));
		$f_files = $this->prepare_query( $files )->result_array();
 

		$filename = 'testing.zip';
		$this->zip->add_dir('files');
		$path1 = getcwd() . '/assets/uploads/library/';
		foreach( $f_files as $file ){
			$fileto = $file['file_path'];

			$fileto = explode('\\',$fileto);
			$fileto = end($fileto);


			$this->zip->read_file( $path1 . $file['file_path'] ); 
		}

		$myFile = "index-learnit.html"; // or .php   
		$fh = fopen($myFile, 'w'); // or die("error");  
		$stringData = "your html code php code goes here";   
		$html = $this->load->view('student/standalone-template', array( 'folder' => $folder, 'files' => $f_files  ),true);
		fwrite($fh, $html);
		fclose($fh);
		$this->zip->read_file( $myFile); 
		$this->zip->download($filename);   
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



