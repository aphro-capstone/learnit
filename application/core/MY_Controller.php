<?php
class MY_Controller extends CI_Controller
{


    function __construct()
    {
        parent::__construct();
    }

    protected function checkRole($callerController = ''){
        if( !empty(getSessionData('sess_userRole')) ){
            if ( getSessionData('sess_userRole') == 'teacher' && $callerController != 'teacher') {
                redirect('teacher');
            } else if ( getSessionData('sess_userRole') == 'student' && $callerController != 'student' ) {
                redirect('student');
            }else if ( getSessionData('sess_userRole') == 'admin' && $callerController != 'admin') {
                redirect('admin');
            }
        }else{
            if($callerController != 'home') redirect('home'); 
        }

        date_default_timezone_set('Asia/Manila');
    }
 	



 	protected function logout_() {
        // $this->SystemsModel->logout();
        $this->session->sess_destroy();
        redirect('home');
    }


    public function prepare_query($argss = null,$ci_query = true){
        
        extract($argss);

        $this->load->model('ProjectModel');

            // 
        if ($ci_query){
            $args = array(
                            'select'        =>      (isset($select)? $select:'*'),
                            'from'          =>      $from,
                            // 'db'            =>      (isset($db)? $db:'default')
                        );
            if(isset($where)){
                $args['where']  =   $where;
            }
            if(isset($join)){
                $args['join']   =   $join;
            }
            if(isset($like)){
                $args['like']   =   $like;
            }
            if (isset($order)){
                $args['order']  =   $order;
            }

            if ( isset($limit) ){
                $args['limit']  = $limit;
            }

            return $this->ProjectModel->do_CI_Query($args);
        }else{
            $query = 'SELECT ' . (isset($select)? $select:'*') .' FROM ' . $table . (isset($join) ? " inner join $join on $join_cond " : '') . ((isset($cond)) ? 'WHERE ' . $cond : '') . ((isset($ord)) ? ' order by ' . $ord : '' ). (isset($path) ? ' ' .$path : ' asc');
        }
    }

    protected function removeSetting($value,$field,$setting){
        $table ='';
        $key = $field;
        $value = $value;
        
        if( $setting == 'color' ) $table = 'settings_colors';
        else if ( $setting == 'grade') $table = 'settings_yr_lvl';
        else if ( $setting == 'subject') $table = 'settings_subjects';

        return $this->ProjectModel->delete( $value, $key, $table);
    }



    // Parameters
    // 1st : args for checking 
    // 2nd : args to insert
    // 3rd : message if echo
    // 4th : whether to return or echo
    protected function insertIfnotexist($args,$toInsert,$messageToreturn,$returnNotEcho = FALSE,$returnLatestID = FALSE){
        $data = $this->prepare_query( $args );
        if( $data->num_rows() == 0 ){
            $temp = $this->ProjectModel->insert_CI_Query( $toInsert['data'], $toInsert['table'],$returnLatestID);
            if( $returnNotEcho ){
                return $temp;
            }

            echo json_encode( array( 'type'  => 'success',  'msg'   => $messageToreturn['success'] ));    
        }else{
            if($returnNotEcho){
                return false;
            }

            echo json_encode( array(  'type'  => 'error',  'msg'   => $messageToreturn['error'] ));
        }
    }
 	

    protected function JSONENCODE_CONDITION( $condition,$success,$error,$otherArrVals = array() ){
        if($condition){
            echo json_encode( 
                    array_merge( 
                        array(  'type'  =>  'success', 'msg'   =>  $success),
                        $otherArrVals
                    )
                );
        }else{
            echo json_encode( 
                    array_merge( 
                        array(  'type'  =>  'error', 'msg'   =>  $error),
                        $otherArrVals
                    )
                );
        }
    }




    protected function getUserinfo($id){
        $args = array(
                    'select'    => '*',
                    'from'      => 'userinfo',
                    'where'     => array(  array( 'field' => 'cred_id', 'value'  =>  $id ))
        ); 
        return $this->prepare_query($args);
    }



 

    protected function getSettings($exclude = []){

        $settings = [];

        if( !in_array('subjects',$exclude)) $settings['subjects'] = $this->prepare_query( array('select' => 's_id,s_name,s_parent_sub',   'from'    => 'settings_subjects' ) )->result_array(); 
        if( !in_array('grades',$exclude)) $settings['grades'] = $this->prepare_query( array('select' => 'g_name,g_id',                  'from'    => 'settings_yr_lvl' ) )->result_array(); 
        if( !in_array('colors',$exclude)) $settings['colors'] = $this->prepare_query( array('select' => 'sc_name,sc_color,sc_id,sc_text_color',     'from'    => 'settings_colors' ) )->result_array(); 

 
        return $settings;
    }

    protected function Error404( $msg ){
        echo 'Error : ' .  $msg;
    }

    protected function generateCode($length, $Existdatacheck,$key){

        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $codes = array();
        foreach ($Existdatacheck as $row) {
            $codes[] = $row[ $key ];
        }
        while(true){
            $randomString = '';
            for ($i = 0; $i < $length; $i++) {
                $randomString .= $characters[rand(0, $charactersLength - 1)];
            }

            if(!in_array($randomString, $codes )){
                break;
            }
        }
        return $randomString;
    }



    protected function projectModals( $page = '',$includeModal = array()){
        $modalList = array(
                'attachlinkModal',
                'addLibraryModal',
                'foldermanageModal',
                'addFolderModal',
                'gradebookModals',
                'assignModals',
                'quizModals',
                'joinClassModal'
         ); 

         $modalList = array_merge( $modalList, $includeModal );



        //  TODO  filter modals to only include the ones the is used per page. 

        return $modalList;
    }


    protected function getLibrary(){
        
        $vars = array(
                'nav'	=> array( 'menu' => 'library' ),
                'pageTitle'	=> 'Library',
                'projectCss'	=> array('project.library'),
                'projectScripts'	=> array(  'project.library' )
        );

        $this->load->template('shared/library',$vars);
    }
    protected function getMessages(){
        $vars = array(
                'nav'	=> array( 'menu' => 'messages' ),
                'pageTitle'	=> 'Messages',
                'projectCss'	=> array('project.messages'),
                'projectScripts'	=> array(  'project.messages','../plugins/emoji.button-picker' )
        );

        $this->load->template('shared/messages',$vars);
    }

    protected function sendSMS($mobile = '',$message = ''){
        // return true;
        // $API_CODE = 'TR-JOEMA376172_W2AQI';
        // $API_PWD = '7@{(m5%hme';

         $API_CODE = 'TR-JOEMA030922_5L3J3';
         $API_PWD = '2g#nh2gq1s';



        $ch = curl_init();
        $itexmo = array(
                        '1' => $mobile, 
                        '2' => $message, 
                        '3' => $API_CODE, 
                        'passwd' => $API_PWD);
        $textAPI =  "https://www.itexmo.com/php_api/api.php";


        curl_setopt($ch, CURLOPT_URL,$textAPI);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, 
                http_build_query($itexmo));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $res = curl_exec ($ch);
        
        if ($res == "" ){
            return  "iTexMo: No response from server!!!
            Please check the METHOD used (CURL or CURL-LESS). If you are using CURL then try CURL-LESS and vice versa.	
            Please CONTACT US for help. ";  
        }else if ($res == 0){
            return true;
        } else{	
            return  "Error Num ". $res . " was encountered!" ;
        } 


        curl_close ($ch);
 
    } 



    protected function sendEmail($data,$content){
        $this->load->library('email');
        $config['protocol']    = 'smtp';
        $config['smtp_host']    = 'ssl://smtp.gmail.com';
        $config['smtp_port']    = '465';
        $config['smtp_timeout'] = '7';
        $config['smtp_user']    = 'capproj11234@gmail.com';
        $config['smtp_pass']    = 'Joemariemo2604';
        $config['charset']    = 'utf-8';
        $config['newline']    = "\r\n";
        $config['mailtype'] = 'html'; // or html
        $config['validation'] = TRUE; // bool whether to validate email or not     

        $this->email->initialize($config);
        $this->email->from('capproj11234@gmail.com', 'LearnIT Website');
        $this->email->to( $data['receiver'] );
        $this->email->subject( $data['subject'] );
        
        $filename = 'assets/images/logoblue2-big.png'; 
        $this->email->attach($filename);
        $content['cid'] =  $this->email->attachment_cid($filename);
        $this->email->message(   $this->load->view(  $data['template'] , $content  ,TRUE) );
        
        if( !$this->email->send() ){
            return 'Failed to send Email.';
        }else{
            return true;
        } 
    }

    protected function stdClassToArray($object){

        if( gettype($object) == 'string' ){
            $object = json_decode($object);
        }

        $arr = array();

        foreach ($object as $key => $value){
          if( gettype( $value ) == 'object' ){
            $arr[ $key ] = $this->stdClassToArray( $value );
            continue;
          }

          $arr[ $key ] = $value; 
        }

        return $arr;
  
    }

    protected function returnResponse($msg,$error = null,$add_data = array()){
        $response = array( 'Error' => $error, 'msg' => $msg );

        if(!empty( $add_data )){
            $response = array_merge( $add_data ); 
        }

        echo json_encode($response);
    }

    protected function getPostComments( $postID, $subcommentParentID = 0 ){

        // echo $subcommentParentID;
        $t = array(
            'select'    => 'c_id,p_id, c_parent_comment, commentor_id, c_content, pc.timestamp_created,
                            concat( lui.ui_firstname," ", lui.ui_lastname) as commentor_name',
            'from'      => 'post_comments as pc',
            'join'		=> array( array( 'table' => 'userinfo as lui', 'cond' => 'lui.cred_id = pc.commentor_id')),
            'where'     => array(  array( 'field'    => 'pc.p_id', 'value' => $postID ),
                                    array( 'field'    => 'pc.c_parent_comment', 'value' => $subcommentParentID )
                                 ),
        );
     
        

        return $this->prepare_query( $t )->result_array();
    }

    protected function getPostReactions( $postID ){
        return $this->prepare_query( array(
            'select'    => 'reaction_type, concat( lui.ui_firstname," ", lui.ui_lastname) as liker_name',
            'from'      => 'post_likes as pl',
            'join'		=> array( array( 'table' => 'userinfo as lui', 'cond' => 'lui.cred_id = pl.user_id')),
            'where'     => array( array( 'field'    => 'post_id', 'value' => $postID ) ),
        ) )->result_array();
    } 

    
	protected function getPosts($classID = 0, $offset = 0, $max = 10){


        
		$npArgs =  array(
                        'select'    => 'p.p_id,
                                        user_id,
                                        p.post_ref_type,
                                        p.spa_id,
                                        p.timestamp_created,
                                        np.class_id,
                                        np.p_content,
                                        concat( ui_firstname, " ",ui_midname," ", ui_lastname ) as poster_name,
                                        (select class_name from li_classes where class_id = np.class_id) as assignees',
						'from'      => 'posts as p',
                        'join'		=> array( 
                                            array( 'table' => 'normal_posts as np', 'cond' => 'np.np_id = p.post_info_ref_id'),
                                            array( 'table' => 'userinfo as ui', 'cond' => 'ui.cred_id = p.user_id')
                                        ),
						'where'     => array( array( 'field'    => 'post_ref_type', 'value' =>  0 ) ),
						'order'		=> array( array( 'by'	=> 'p.timestamp_created', 'path'	=> 'desc' ))
					); 
        
                    
		$taskArgs =  array(
						'select'    => 'p.p_id,user_id,
												p.post_ref_type,
												p.spa_id,
                                                p.timestamp_created,
												tsk_id,
												tsk_type,
												tsk_type,
												tsk_title,
												tsk_instruction,
												tsk_duedate,
                                                tsk_status,
                                                concat( ui_firstname, " ",ui_midname," ", ui_lastname ) as poster_name,
                                                (select count(ts_id) from li_task_submissions where task_id = tsk.tsk_id) as submissionCount,
                                                (select quiz_id from li_quizzes as q where q.task_id = tsk.tsk_id) as quiz_id,
                                                (select quiz_duration from li_quizzes as q where q.task_id = tsk.tsk_id) as duration,
                                                (select quiz_count from li_quizzes as q where q.task_id = tsk.tsk_id) as quiz_count,
                                                (select ass_id from li_assignments as a where a.task_id = tsk.tsk_id) as ass_id,
                                                (select total_points from li_quizzes as q where q.task_id = tsk.tsk_id) as total_point,',
						'from'      => 'posts as p',
						'join'		=> array( 
                                            array( 'table' => 'tasks as tsk', 'cond' => 'tsk.tsk_id = p.post_info_ref_id'),
                                            array( 'table' => 'userinfo as ui', 'cond' => 'ui.cred_id = p.user_id'),
                                        ),
						'where'     => array(  array( 'field'    => 'post_ref_type', 'value' =>  1 ) ),
						'order'		=> array( array( 'by'	=> 'p.timestamp_created', 'path'	=> 'desc' ))
                    ); 
                    

        if( getRole() == 'teacher' ){
            $npArgs['join'][] =  array( 'table' => 'classes as c', 'cond' => 'c.class_id = np.class_id');
            $npArgs['where'][] = array( 'field'    => 'c.teacher_id', 'value' =>  getUserID() );
        } else if( getRole() == 'student' ){

        }
        
        if( $classID != 0 ){
            $npArgs['where'][] =  array( 'field'    => 'np.class_id', 'value' =>  $classID );
        }             

        $tasks = $this->prepare_query( $taskArgs )->result_array();
        $np = $this->prepare_query( $npArgs )->result_array();

        $tasks = array_map(function($a){
                    $assigneeArgs = array(
                        'select'	=> 'c.class_id,class_name',
                        'from'		=> 'task_class_assignees as tca',
                        'join'		=> array( 
                                                array( 'table' => 'classes as c', 'cond' => 'c.class_id = tca.class_id'),
                        ),
                        'where'		=> array( array( 'field' => 'tca.task_id', 'value' => $a['tsk_id'] ) )
            );
            $a['assignees'] = $this->prepare_query( $assigneeArgs )->result_array();
            
			return $a;
        }, $tasks );	


        if( $classID != 0 ){
            foreach ($tasks as $k => $t) {
                $doUnset = true;
                foreach ($t['assignees'] as $tt) {
                    if(  $tt['class_id'] == $classID){
                        $doUnset = false;
                    }
                }

                if( $doUnset ) unset( $tasks[$k] );
            }
        }
        


		
		$postArray = [];
		 
		$temp = array_merge( $np,$tasks );

		usort($temp, function($a, $b) { 
			return new DateTime($b['timestamp_created']) <=> new DateTime($a['timestamp_created']);
		});

		$temp = array_map(function($a){

            $a['reactions'] = $this->getPostReactions( $a['p_id'] );
            $comments = $this->getPostComments( $a['p_id'] );

            if( !empty($comments) ){ 
                $comments = array_map( function($b){ 
                    $b['subcomments'] = $this->getPostComments( $b['p_id'], $b['c_id'] );
                    if( !empty($b['subcomments'])) {
                        $b['subcomments'] = array_map(function($c){
                            $c['c_content'] = json_decode($c['c_content'],true);
                            return $c;
                        }, $b['subcomments']); 
                    }

                    $b['c_content'] = json_decode($b['c_content'],true) ;
                    return $b;
                },$comments );
            }
            
            // echo $this->ProjectModel->printLastquery();
			$a['comments'] = $comments ;
             
            
            if(isset($a['p_content'] ) ) $a['p_content'] =  json_decode($a['p_content'],true)  ;  

			return $a;
        }, $temp );		 

		return $temp; 
    }
    

    protected function getSinglePost($id){
        
        $args = array(
                    'select' => 'concat(ui_firstname,\' \', ui_lastname) as poster_name, p_id,post_info_ref_id,post_ref_type,spa_id,p.timestamp_created',
                    'from'  => 'posts as p',
                    'join'  => array( array( 'table' => 'userinfo as ui', 'cond' => 'ui.cred_id = p.user_id') ),
                    'where' => array( array(  'field' => 'p_id',  'value'  => $id ) )
        );
        

        $post = $this->prepare_query( $args );

        if( $post->num_rows() > 0 ){
            $post = $post->result_array()[0];

            $args = array( 'select' => '*','where' => array() );
            

            if( $post['post_ref_type'] == 1 ){
                $args['from'] = 'tasks';
                $args['where'][] = array(  'field' => 'tsk_id',  'value'  => $post['post_info_ref_id'] );

 

            }else{

            }


            $postinfo = $this->prepare_query( $args )->result_array();



            $post = array_merge( $post ,$postinfo  );
            var_dump( $post );


            return $post;


        }else{
            show_404();
        }
        

    }


    protected function _addPost(){
		$attachments = $this->input->post('attachments');
		$content = $this->input->post('content');
		$classid = $this->input->post('classid') ;
		$spaid = $this->input->post('spaid');

		
		

         
		$normalpostAdd = array(
			'p_content' 	=> json_encode(array()),			 							
			'class_id' 		=> $classid ? $classid : 0,							
		);

		$npID = $this->ProjectModel->insert_CI_Query( $normalpostAdd, 'normal_posts',true );
        
        $postAdd = array(							
			'user_id' 				=> intval( getUserID() ),								
			'post_info_ref_id'	 	=> $npID,								
			'post_ref_type' 		=> 0,	
			'spa_id' 			    => $spaid ? $spaid : 0,								
        );
		$postID = $this->ProjectModel->insert_CI_Query( $postAdd, 'posts',true );

        
        $content = array( 't' => $content ,'a' => $this->getAttachmentsJSON(true,$postID,'np_') );
        $normalpostAdd['p_content'] = $content;
        $this->ProjectModel->update( 
                                    array( 'np_id' => $npID) , 
                                    'normal_posts', 
                                    array( 'p_content' => json_encode($content) ) );


        $newPost = array_merge( $normalpostAdd,$postAdd );
        $timestamp = new DateTime();
        $newPost['timestamp_created'] = $timestamp->format('Y-m-d H:i:s');
        $newPost['p_content'] =   $newPost['p_content'] ;
        $newPost['reaction'] = array();
        $newPost['comments'] = array();
        $newPost['p_id'] = $postID;
        $newPost['poster_name'] = getUserName();

        // var_dump()
		$newPost = $this->load->view('shared/posts/post-template',array('post' => $newPost),true); 

        $this->returnResponse( 'Successfuly joined class.',null,array('newpost' => $newPost) ); 
    }
    

    protected function getAttachmentsJSON($returnArray = false,$postID = 0,$prefix = ''){
        $attachments_arr = array();
        $filePath = '/assets/uploads/' . date('Y') . '/' . date('m') ;
        $dbPath = date('Y') . '/' . date('m') . '/';

        clearstatcache();   
        //  ERROR HERE DEC 1,2020
        if (!file_exists($filePath)) {
			mkdir($filePath, 0777, true);
		}
        
        if( $_FILES['attachFile']['name'] == '' ){  return array(); }

        if( count( $_FILES['attachFile']['name'] ) == 0 ){ return array();  }
        $count = count($_FILES['attachFile']['name']);

        
        $dataToinsert = []; 
		for ($i = 0; $i < $count; $i++) { 
			$fileName = $prefix .$postID .'_' . $_FILES['attachFile']['name'][$i]; 
            $tempFile = $_FILES['attachFile']['tmp_name'][$i];
            $targetFile = getcwd() . $filePath .'/'. $fileName;

            if( move_uploaded_file($tempFile, $targetFile) ){
                $ext = explode('.',$fileName);
                $attachments_arr[] = array(
                                    'type'  => end($ext),
                                    'path'  => $dbPath . $fileName,
                                    'name'  => $_FILES['attachFile']['name'][$i],
                                    'size'  => $_FILES['attachFile']['size'][$i]
                );
            }
            
        }

        if( $returnArray ){
            return $attachments_arr;
        }

        return json_encode( $attachments_arr );
    }

    protected function _addComment(){
        $postid = $this->input->post('postid');
        $commentid = $this->input->post('commentID');
        $content = $this->input->post( 'content' );

        $commentAdd = array(
                'p_id'  => $postid,
                'c_parent_comment' => $commentid | 0 ,
                'commentor_id'  => getUserID(),
                'c_content'     => json_encode($content)
        );
        $commentID = $this->ProjectModel->insert_CI_Query( $commentAdd, 'post_comments',true );
        
        $commentAdd['c_id'] = $commentID;
        $timestamp = new Datetime();
        $commentAdd['timestamp_created']    =  $timestamp->format('Y-m-d H:i:s');
        $commentAdd['commentor_name']       = getUserName();
        $commentAdd['subcomments']          = array();
        $commentAdd['c_content']            = $content;
        echo $this->load->view('shared/posts/comment-template', array('comment' => $commentAdd),true);
    }
    
    protected function getUserbyID( $id,$toget = null ){
        $select = '*';

        if($toget == 'name'){
            $select = "concat(ui_firstname,' ', ui_lastname)";
        }

        $Args =  array(
            'select'    => $select,
            'from'      => 'userinfo',
            'where'     => array( array( 'field'    => 'cred_id', 'value' =>  $id ) ),
        ); 

        return $this->prepare_query( $Args )->result_array();
    }

    protected function doDownload($file){
        $this->load->helper('download');
        $file_ = file_get_contents(getcwd() .  __SYSTEM_UPLOAD_PATH__ . $file['path']);
        $name =  __PROJECT_NAME__  . '_' . date('Y-m-d').'_' .$file['name'] ;
        force_download($name,$file_);
   }



   protected function checkAjaxRequest(){
     if (!$this->input->is_ajax_request()) {
        exit('No direct script access allowed');
     } 
   }

   protected function getActivities($game){
    $dataPass = array (
            'body_classes' => 'activities', 
            'projectCss'	=> array(
                                            'project.activity'
            ),"projectScripts" => array()
        ); 

    $template = 'activities';

    if( $game == 'typing-it' ){
        $template = 'interactive/Games/typing-it';
        $dataPass['projectScripts'][] = 'interactives/typeit';
    }elseif ($game == 'quiz-it'){
        $template = 'interactive/Games/quiz-it';
    }

    $this->load->template( 'shared/' . $template,$dataPass);
   }

}
