<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends MY_Controller {

	public function __construct() {
        parent::__construct();
        $this->checkRole('admin');
    }


	public function index(){
		$data_pass = array(
							'pagetitle' => 'Welcome back Administrator',
							'pagesub'	=> 'A dashboard of all the records in the system',
							'nav_active' => 'dashboard'
						);
		$this->load->template('admin/pages/dashboard', $data_pass,false,'admin');
	}

	public function datatables(){
		$var = array(
							'pagetitle' => 'Admin Datatables',
							'pagesub'	=> 'List of data\'s in table format',
							'nav_active' => 'datatable'
						);
		$studsArgs = array( 'select' => 'user_id,concat( ui_firstname, " ", ui_lastname ) as name,
										ui_email,role,
										application_status,
										user_status,
										ui_guardian_phone,
										u.timestamp_created,
										u.datetime_inactive as inactive_active_datetime',
							'from' => 'userinfo ui',
							'join'	=> array( array( 'table'=> 'users u', 'cond' => 'u.user_id = ui.cred_id' ) ),
							'where'	=> array(  array( 'field'	=> 'role','type' => 'wherein', 'value'=> array( 'teacher','student' )), )
		);

		$classArgs = array( 'select' => "c.class_id,
										class_name,
										class_code,
										class_status,
										code_status,
										ui.cred_id as teacherid,
										class_sy_from,
										class_sy_to,
										c.timestamp_created as class_created,
										concat( ui_firstname, ' ', ui_lastname ) as teachername,
										(select count(cs_id) from li_class_students where class_id= c.class_id and admission_status = 1 ) as studentcount,
										",
							'from' => 'classes c',
							'join'	=> array( array( 'table'=> 'userinfo ui', 'cond' => 'ui.cred_id = c.teacher_id' ) ),
		);



		$users = $this->prepare_query( $studsArgs )->result_array();
		$classlist = $this->prepare_query( $classArgs )->result_array();

		$users = array_map(function($a){
			if( $a['role'] == 'teacher' ){
				$args = array( 'select' => 'class_id,class_name,class_status',
										'from' => 'classes',
										'where'	=> array(  array( 'field'	=> 'teacher_id', 'value'=> $a['user_id']))
				);

				$a['classes'] = $this->prepare_query( $args )->result_array();
			}else if( $a['role'] == 'student' ){ 
				$args = array( 'select' => 'c.class_id,class_name',
										'from' => 'class_students cs',
										'join'	=> array( array( 'table' => 'classes c' , 'cond' => 'c.class_id = cs.class_id') ),
										'where'	=> array(  array( 'field'	=> 'student_id', 'value'=> $a['user_id']))
				);

				$a['classes'] = $this->prepare_query( $args )->result_array();
			}

			return $a;
		},$users);





		$var['userlist'] =  $users;
		$var['classlist'] =  $classlist;
	


		$this->load->template('admin/pages/datatables', $var,false,'admin');
	} 

	public function multimedia(){
		$var = array(
							'pagetitle' => 'Admin Multimedia',
							'pagesub'	=> 'List of data\'s in table format',
							'nav_active' => 'multimedia'
						);
		
		$args = array( 'from' => 'multimedia' );
		$var['m'] = $this->prepare_query($args)->result_array();
		

		$this->load->template('admin/pages/multimedia', $var , false,'admin');
	}

	public function settings(){

		$args_for_grades 	=	array( 'from' => 'settings_yr_lvl' );
		$args_for_colors 	=	array( 'from' => 'settings_colors' );
		$args_for_subjects 	=	array( 'from' => 'settings_subjects', 
									   'where' => array( array('field' => 's_parent_sub', 'value' => 0) )
								);
		$args_for_postavailability 	=	array( 'from' => 'settings_post_availability' );

		$data_pass = array(
							'grades' => $this->prepare_query( $args_for_grades )->result_array(),
							'colors' => $this->prepare_query( $args_for_colors )->result_array(),
							'subject' => $this->prepare_query( $args_for_subjects )->result_array() ,
							'postavailability' => $this->prepare_query( $args_for_postavailability )->result_array() ,
							'pagetitle' => 'Admin Settings',
							'pagesub'	=> 'Set the system settings in this page.',
							'nav_active' => 'settings-nav'
						);

		$this->load->template('admin/pages/settings', $data_pass,false,'admin');
	}

	public function addForms(){

		$form = $this->input->post('form');
		$id = $this->input->post('id');
		if($form == 'grade'){
			$this->addGrade($id);
		}else if ( $form == 'color' ){
			$this->addColor($id);
		}else if( $form == 'subject' ){
			$this->addSubject($id);
		}else if( $form == 'postavailablity' ){
			$this->addPostAvailability();
		}
	}

	private function addColor($id){
		$colorName = $this->input->post('name');
		$color = $this->input->post('color');
		$tcolor = $this->input->post('tcolor');

		$dataSet = array(  'sc_name' => $colorName, 'sc_color' => $color,'sc_text_color' => $tcolor  );

		if(empty($id)){
			$args = array(
		                'select'    => '*',
		                'from'      => 'settings_colors',
		                'where'     => array( 
		                					array( 'field' => 'sc_name', 'value'  =>  trim($colorName) ),
		                					array( 'field' => 'sc_color', 'value'  =>  trim($color) ),
		                					)
		                );

			$this->insertIfnotexist( $args,
									 array(  
									 		'data' => $dataSet,
									 		'table' => 'settings_colors'
									 ),
									 array(
									 		'success' 	=> 'Successfully Added Color',
									 		'error'		=> 'Failed to add color,  already exist'
									 ));
		}else{
			$whereArray = array( 'sc_id' => $id);
			$this->JSONENCODE_CONDITION( 
										$this->ProjectModel->update( $whereArray, 'settings_colors', $dataSet),
										'Successfully updated color with ID ' . $id,
										'Failed to update color,  something went wrong.'
									);
		}
		
	}

	private function addGrade($id){
		$gradeName = $this->input->post('grade');

		$dataSet = array( 'g_name' => $gradeName );


		if( empty($id) ){
			$args = array(
		                'select'    => '*',
		                'from'      => 'settings_yr_lvl',
		                'where'     => array( array( 'field' => 'g_name', 'value'  =>  trim($gradeName) ) )
		                );
		  	
		  	$this->insertIfnotexist( $args,
									 array(  
									 		'data' => $dataSet,
									 		'table' => 'settings_yr_lvl'
									 ),
									 array(
									 		'success' 	=> 'Successfully Added Grade',
									 		'error'		=> 'Failed to add grade, grade already exists'
									 ));
		}else{
			$whereArray = array( 'g_id' => $id);
			$this->JSONENCODE_CONDITION( 
										$this->ProjectModel->update( $whereArray, 'settings_yr_lvl', $dataSet),
										'Successfully update Grade with ID ' . $id,
										'Failed to update grade,  something went wrong.'
									);
		}
 		
	}

	private function addSubject($id){
		$parentID = $this->input->post('parentSubject');
		$subname = $this->input->post('name');
		$subAbbr = $this->input->post('abbre');
		$subDesc = $this->input->post('desc');

		$dataSet = array( 	's_parent_sub' 	=> $parentID,
							's_name' 		=> $subname,
							's_abbre' 		=> $subAbbr,
							's_desc' 		=> $subDesc,
							 );


		if( empty($id) ){
			$args = array(
	                'select'    => '*',
	                'from'      => 'settings_subjects',
	                'where'     => array( 
	                					array( 'field' => 's_parent_sub', 'value'  =>  $parentID ),
	                					array( 'field' => 's_name', 'value'  =>  trim($subname ) ),
	                					)
	                );
	  	
	  				$this->insertIfnotexist( $args,
								 array(  
								 		'data' => $dataSet,
								 		'table' => 'settings_subjects'
								 ),
								 array(
								 		'success' 	=> 'Successfully Added Subject',
								 		'error'		=> 'Failed to add subject, subject already exists'
								 ));	
		}else{
			$whereArray = array( 's_id' => $id);
			$this->JSONENCODE_CONDITION( 
										$this->ProjectModel->update( $whereArray, 'settings_subjects', $dataSet),
										'Successfully update Subject with ID ' . $id,
										'Failed to update subject,  something went wrong.'
									);
		}
 		
	} 


	private function addPostAvailability($id){
		$spaName 	= $this->input->post('name');
		$spaRoles 	= $this->input->post('roles');
		$spaDesc 	= $this->input->post('desc');

		$dataSet = array( 	'spa_name' 		=> $spaName,
							'spa_roles' 	=> $spaRoles,
							'spa_desc' 		=> $spaDesc,
							 );


		if( empty($id) ){
			$args = array(
	                'select'    => '*',
	                'from'      => 'settings_post_availability',
	                'where'     => array(  array( 'field' => 'spa_name', 'value'  =>  $spaName ), )
	                );
	  	
	  				$this->insertIfnotexist( $args,
								 array(  
								 		'data' => $dataSet,
								 		'table' => 'settings_post_availability'
								 ),
								 array(
								 		'success' 	=> 'Successfully Added availability',
								 		'error'		=> 'Failed to add availability, already exists'
								 ));	
		}else{
			$whereArray = array( 'spa_id ' => $id);
			$this->JSONENCODE_CONDITION( 
										$this->ProjectModel->update( $whereArray, 'settings_post_availability', $dataSet),
										'Successfully update Subject with ID ' . $id,
										'Failed to update availability,  something went wrong.'
									);
		}
	}


	public function delete(){

        $value = $this->input->post('value');
        $key = $this->input->post('key');
        $setting = $this->input->post('setting');

        if( !$value ){ return; }

        if( $this->removeSetting($value, $key, $setting) > 0 ){
        	echo json_encode(  array( 'type' => 'success', 'msg' => 'Successfully deleted item' )  );
        }else{
        	echo json_encode( array( 'type' => 'error', 'msg' => 'Failed to delete item.' ) );
        }
        
    }


	public function logout(){
        $this->logout_();
	}
	

	public function checkAdmin(){
		$data = $this->input->post('data');
		$action = $this->input->post('action'); 

		$args = array(  'from' => 'users' , 
						'where' => array( 
										array('field' => 'user_id', 'value'=> getUserID() ),
										array('field' => 'role', 'value'=> 'admin' ),
										array('field' => 'pass', 'value'=> base64_encode( $data ) ),
										 ) 
					);
		
		if( $this->prepare_query( $args )->num_rows()  > 0){
			if( $action == 'credentials' ){
				$did = $this->input->post('did');
				$this->getCredentials( $did );
			}else if( $action == 'endschoolyear'){
				$this->endSchoolYear();
			}
			echo 1;
		}else{
			echo 0;
		}
		die();
	}

	private function getCredentials($id){
		
		$this->load->library('encryption'); 
		
		$args = array(  'select' => 'uname,pass',
						'from' => 'users' , 
						'where' => array( array('field' => 'user_id', 'value'=> $id ) ) );
		$d = $this->prepare_query( $args )->result_array();
 

		$d = $d[0];
		$d['pass'] = base64_decode( $d['pass'] ); 
		
		$this->returnResponse(null,null, array( 'data' => $d ));

		die();
	}

	public function addmultimedia(){
		$title = $this->input->post('title');
		$desc = $this->input->post('desc');
		$size = $this->input->post('size');
		$snapshot = $this->input->post( 'snapshot' );
 
		$filePath = 'assets\multimedia\\';
		$dbPath = date('Y') . '\\' . date('m') . '\\';

		clearstatcache();   

		if (!file_exists( __MULTIMEDIA_UPLOAD_PATH__ )) {
			mkdir( __MULTIMEDIA_UPLOAD_PATH__ , 0777, true);
		}
		
		if( $_FILES['multimedia']['name'] == '' ){  return json_encode(array()); }
		if( is_array($_FILES['multimedia']['name']) && count( $_FILES['multimedia']['name'] ) == 0 ){ return json_encode(array());  }

		$filename__ = $_FILES['multimedia']['name'];
		$filename__ = md5( $filename__ );
		$fileName = 'learnit_it_media-'. uniqid(). $filename__; 

		$fileName = preg_replace('/\s+/', '', $fileName);

		$tempFile = $_FILES['multimedia']['tmp_name'];
		$targetFile = getcwd() . __MULTIMEDIA_UPLOAD_PATH__ . $fileName;
	   
		if(  move_uploaded_file($tempFile, $targetFile)  ){  
			$data = str_replace('[removed]','',$snapshot);
			$m_add = array(
				'm_title'	=>  $title,
				'm_desc'	=>	$desc,
				'size'		=> 	$size,
				'm_path'	=>  $fileName,
				'snapshot'	=> $data

			);
			$id = $this->ProjectModel->insert_CI_Query( $m_add, 'multimedia',true );     // Add Post

			$args = array( 'from' => 'multimedia' , 'where' => array( array( 'field'	=> 'm_id', 'value' => $id  ) ));
			$item = $this->prepare_query( $args )->result_array();

			echo json_encode( array('Error' => null, 'msg' => 'Successfully Uploaded video', 'data' => $item[0] ) );
		}else{
			$this->returnResponse(null, 'failed uploading video');
		}
		 
	}

	public function stream(){

		clearstatcache();   
		$dirname =  'assets\multimedia\snapshots' ;
		var_dump( $dirname );

		rmdir($dirname);
		mkdir($dirname, 0777, true);
		echo substr(sprintf('%o', fileperms($dirname)), -4);
		$ifp = fopen( getcwd(). '\assets\multimedia\snapshots' , 'wb' ); 
	}


	public function removeMultimedia(){
		$id = $this->input->post('id');
		$filepath = $this->input->post('path');
		unlink( getcwd() . $filepath );
		if( $this->ProjectModel->delete( $id, 'm_id', 'multimedia') ){
			$this->returnResponse('Successfully deleted the video');
		}else{
			$this->returnResponse('Failed to delete the video');
		}
	}

	public function assignteacher(){
		$classid = $this->input->post('classid');
		$ntid = $this->input->post('NTid');
		$ptid = $this->input->post('PTid');
		$classname = $this->input->post('classname');


		if( $this->ProjectModel->update( array( 'class_id' => $classid) , 'classes', array('teacher_id' => $ntid)) ){
			
			$reassignmentLogfields = array(
								'classid' =>  $classid,
								'new_teacher_id' =>  $ntid,
								'prev_teacher_id' =>  $ptid,
							);

			$this->ProjectModel->insert_CI_Query( $reassignmentLogfields, 'class_teacher_transition_log' );
			

			$this->addnotificationLogs($ntid,'The class ' . $classname . ' has been reassigned to you.', 'reassignment');
			$this->returnResponse('Successfuly reassigned class');
		}else{
			$this->returnResponse( null,'Failed to reassign class' );
		}
	}

	public function updateuser(){
		$userid = $this->input->post('userid');
		$stats = $this->input->post('stats');
		$role = $this->input->post('role');

		if( $stats == 1 ) $stats = 0;
		else if( $stats == 0 ) $stats = 1;
		$datetimeinactive = date_format(new Datetime(), 'Y-m-d H:i:s');



		if( $this->ProjectModel->update( array( 'user_id' => $userid) , 'users', array('user_status' => $stats,'datetime_inactive' => $datetimeinactive )) ){

			if( $role == 'student'){
				$this->ProjectModel->update( array('student_id' => $userid) , 'class_students', array('admission_status' => 0));
			}else{

			}


			$this->returnResponse('Successfuly updated user status');
		}else{
			$this->returnResponse( null,'Failed to reassign class' );
		}
	}
	

	private function createTeacherReport(){

		
		$studsArgs = array(
						'select' => 'user_id,ui_firstname,ui_midname, ui_lastname,
									ui_email,
									user_status,
									ui_guardian_phone,
									u.timestamp_created',
						'from' => 'userinfo ui',
						'join'	=> array( array( 'table'=> 'users u', 'cond' => 'u.user_id = ui.cred_id' ) ),
						'where'	=> array(  array( 'field'	=> 'role', 'value'=>'teacher' ), ) );

		$teachers = $this->prepare_query( $studsArgs )->result_array();

		$teachers = array_map(function($a){
			$args = array( 'select' => 'class_id,class_name,class_status',
										'from' => 'classes',
										'where'	=> array(  array( 'field'	=> 'teacher_id', 'value'=> $a['user_id']))
				);

				$a['classes'] = $this->prepare_query( $args )->result_array();

			return $a;
		},$teachers);
	

		ob_start();    
		$content="";
		$normalout=true;

		$header = array( 'ID','First Name', 'Middle Name', 'Last Name' ,'EMAIL', 'Registered Date', 'Contact', 'Status', '# of classes handled','# of active classes', 'Active Classes','All classes handled');
		$header = implode("\t", $header);
	 
		// i guess if some condition is true...
		
		$content=ob_get_clean();
		$normalout=false;
		header( "Content-Type: application/vnd.ms-excel" );
		header( "Content-disposition: attachment; filename=learnit_teachers_list.xls" );
		echo $header. "\r\n";

		foreach( $teachers as $teacher ){
			$row = array();
 
			$row[] =  $teacher['user_id'];
			$row[] =  $teacher['ui_firstname'];
			$row[] =  $teacher['ui_midname'];
			$row[] =  $teacher['ui_lastname'];
			$row[] =  $teacher['ui_email'];
			$row[] =  date_format( new Datetime( $teacher['timestamp_created'] ), 'Y-m-d h:i:s'  );
			$row[] =  $teacher['ui_guardian_phone'];
			$row[] =  $teacher['user_status'] == '1' ? 'Active' : 'Inactive';
			$row[] = count($teacher['classes']);

			$activeClasses = 0;
			$activeClasslist = array();
			$allClassList = array();

			if( count( $teacher['classes'] ) > 0 ){
				foreach( $teacher['classes'] as $class ){
					$allClassList[] = $class['class_name'];
					if( $class['class_status'] == '1' ){
						$activeClasslist[] = $class['class_name'];
						$activeClasses++;
					}
				}
			}
			$row[] = $activeClasses;
			$row[] = implode(', ', $activeClasslist);
			$row[] = implode(', ', $allClassList);

			echo implode("\t", $row) . "\r\n"; 
		} 

		die(); 
	}

	private function createStudReport(){
		$studsArgs = array(
			'select' => 'user_id,ui_firstname,ui_midname, ui_lastname,
						ui_email,
						user_status,
						ui_guardian_phone,
						u.timestamp_created,
						ui_profile_data',
			'from' => 'userinfo ui',
			'join'	=> array( array( 'table'=> 'users u', 'cond' => 'u.user_id = ui.cred_id' ) ),
			'where'	=> array(  array( 'field'	=> 'role', 'value'=>'student' ), ) );

		$studs = $this->prepare_query( $studsArgs )->result_array();

		$studs = array_map(function($a){
						$args = array( 'select' => 'c.class_id,class_name,class_status',
									'from' => 'class_students cs',
									'join'	=> array( array( 'table' => 'classes c' , 'cond' => 'c.class_id = cs.class_id') ),
									'where'	=> array(  array( 'field'	=> 'student_id', 'value'=> $a['user_id']))
						);

						$a['classes'] = $this->prepare_query( $args )->result_array();

			return $a;
		},$studs);


		ob_start();    
		$content="";
		$normalout=true;

		$header = array( 'ID','First Name', 'Middle Name', 'Last Name' ,'Status', 'Email', 'Registered Date', '# of active classes', 'Active Classes', 'Guardian contact','Guardian Name',);
		$header = implode("\t", $header);

		// i guess if some condition is true...

		$content=ob_get_clean();
		$normalout=false;
		header( "Content-Type: application/vnd.ms-excel" );
		header( "Content-disposition: attachment; filename=learnit_students_list.xls" );
		echo $header. "\r\n";

		foreach( $studs as $stud ){
		$row = array();

		$row[] =  $stud['user_id'];
		$row[] =  $stud['ui_firstname'];
		$row[] =  $stud['ui_midname'];
		$row[] =  $stud['ui_lastname'];
		$row[] =  $stud['user_status'] == '1' ? 'Active' : 'Inactive';
		$row[] =  $stud['ui_email'];
		$row[] =  date_format( new Datetime( $stud['timestamp_created'] ), 'Y-m-d h:i:s'  );
		

		$activeClasses = 0;
		$activeClasslist = array();
		$allClassList = array();

		if( count( $stud['classes'] ) > 0 ){
			foreach( $stud['classes'] as $class ){ 
				if( $class['class_status'] == '1' ){
					$activeClasslist[] = $class['class_name'];
					$activeClasses++;
				}
			}
		}
		$row[] = $activeClasses;
		$row[] = implode(', ', $activeClasslist); 
		$row[] =  $stud['ui_guardian_phone'];

		$profdata = json_decode( $stud['ui_profile_data'],true );
		$row[] = $profdata['ui_guardian_name'];
		echo implode("\t", $row) . "\r\n"; 
		} 

		die(); 
	}

	private function createClassListReport(){
		$classArgs = array( 'select' => "c.class_id,
										class_name,
										class_code,
										class_status,
										code_status,
										ui.cred_id as teacherid,
										class_sy_from,
										class_sy_to,
										c.timestamp_created as class_created,
										concat( ui_firstname, ' ', ui_lastname ) as teachername,
										(select count(cs_id) from li_class_students where class_id= c.class_id and admission_status = 1 ) as studentcount,
										",
							'from' => 'classes c',
							'join'	=> array( array( 'table'=> 'userinfo ui', 'cond' => 'ui.cred_id = c.teacher_id' ) ),
		);

		$classlist = $this->prepare_query( $classArgs )->result_array();
 
		
		ob_start();    
		$content="";
		$normalout=true;

		$header = array( 'ID','Classname', 'Class Status', 'Code' ,'Code Status', 'School Year', 'Teacher', '# of students', 'Date Created');
		$header = implode("\t", $header);

		// i guess if some condition is true...

		$content=ob_get_clean();
		$normalout=false;
		header( "Content-Type: application/vnd.ms-excel" );
		header( "Content-disposition: attachment; filename=learnit_class_list.xls" );
		echo $header. "\r\n";

		foreach( $classlist as $class ){
		$row = array();

		$row[] =  $class['class_id'];
		$row[] =  $class['class_name'];
		$row[] =  $class['class_status'] == 1 ? 'Active' : 'Inactive/Archived';
		$row[] =  $class['class_code'];
		$row[] =  $class['code_status'] == 1 ? 'Open' : 'Closed';
		$row[] =  $class['class_sy_from'] . ' - ' . $class['class_sy_to'];
		$row[] =  $class['teachername'];
		$row[] =  $class['studentcount'];
		$row[] =  date_format( new Datetime( $class['class_created'] ), 'Y-m-d H:i:s'  );
		 
		echo implode("\t", $row) . "\r\n"; 
		} 

		die(); 
	}

	public function reportExcel($type){
		if( $type == 'teacherlist' ){
			$this->createTeacherReport();
		}else if( $type == 'studlist' ){
			$this->createStudReport();
		}else if( $type == 'classlist' ){
			$this->createClassListReport();
		} 
	}



	private function endSchoolYear(){
		$curdate = new Datetime();
		$curmonth = date('m');
		$curyear = date('Y');

		$query_year_from;
		$query_year_to;
		
		if( $curmonth > __SCHOOL_YEAR_MONTH_START__  ){
			$query_year_to = $curyear + 1;
			$query_year_from = $curyear;
		}else{
			$query_year_to = $curyear;
			$query_year_from = $curyear - 1;
		}
 
		$whereArray = array( 'class_sy_from' => $query_year_from, 'class_sy_to' => $query_year_to );
		$this->ProjectModel->update( $whereArray, 'classes', array( 'class_status' => 2 ));
	}

}
