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
 	

    protected function JSONENCODE_CONDITION( $condition,$success,$error,$otherArrVals = array(),$callback = null ){
        if($condition){
            echo json_encode( 
                    array_merge( 
                        array(  'type'  =>  'success', 'msg'   =>  $success),
                        $otherArrVals
                    )
                );
            if( !is_null( $callback ) ){
                call_user_func($callback);
            }
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
                'projectScripts'	=> array(  'project.library','project.dragdrop' ),
                'modals'     => $this->projectModals( )
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

         $API_CODE = 'TR-CAPST489354_BLECI';
         $API_PWD = '2ia%@8i[]@';



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
            $response = array_merge( $add_data,$response ); 
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
                                        user_id as author_id,
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
						'where'     => array( 
                                            array( 'field'    => 'post_ref_type', 'value' =>  0 ),
                                            array( 'field'    => '( SELECT COUNT(post_id) as existing from li_user_utility_hidden_posts_log where user_id = '. getUserID() .' and post_id = p.p_id  ) = ' , 'value' => 0 ),

                                        ),
						'order'		=> array( array( 'by'	=> 'p.timestamp_created', 'path'	=> 'desc' ))
					); 
        
                    
		$taskArgs =  array(
						'select'    => 'p.p_id,user_id as author_id,
												p.post_ref_type,
												p.spa_id,
                                                p.timestamp_created,
												tsk_id,
												tsk_type,
												tsk_type,
												tsk_title,
												tsk_instruction,
												tsk_duedate,' .
                                                // tsk_status,
                                                'concat( ui_firstname, " ",ui_midname," ", ui_lastname ) as poster_name,
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
						'where'     => array(  
                                            array( 'field'    => 'post_ref_type', 'value' =>  1 ),
                                            array( 'field'    => '( SELECT COUNT(post_id) as existing from li_user_utility_hidden_posts_log where user_id = '. getUserID() .' and post_id = p.p_id  ) = ' , 'value' => 0 )    
                                        ),
						'order'		=> array( array( 'by'	=> 'p.timestamp_created', 'path'	=> 'desc' ))
                    ); 
                    

        if( getRole() == 'teacher' ){
            if( $classID  != 0){
                $npArgs['join'][] =  array( 'table' => 'classes as c', 'cond' => 'c.class_id = np.class_id');
                $npArgs['where'][] = array( 'field'    => 'c.teacher_id', 'value' =>  getUserID() );
            } 
        } else if( getRole() == 'student' ){
            $taskArgs['select'] = $taskArgs['select'] . '(select count(ts_id) from li_task_submissions as ltsk where ltsk.task_id = tsk.tsk_id and ltsk.student_id = '. getUserID() .' ) as student_sub_count';
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
                    'select' => 'concat(ui_firstname,\' \', ui_lastname) as poster_name, user_id as author_id,p_id,post_info_ref_id,post_ref_type,spa_id,p.timestamp_created',
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
        $newPost['author_id'] = intval( getUserID() );

        // var_dump()
		$newPost = $this->load->view('shared/posts/post-template',array('post' => $newPost),true); 

        $this->returnResponse( 'New Post added.',null,array('newpost' => $newPost) ); 
    }
    

    protected function getAttachmentsJSON($returnArray = false,$postID = 0,$prefix = ''){
        $attachments_arr = array();
        
        
        $filePath = 'assets\uploads\\' . date('Y') . '\\' . date('m') ;
        $dbPath = date('Y') . '\\' . date('m') . '\\';

        clearstatcache();   

        //  ERROR HERE DEC 1,2020
        if (!file_exists($filePath)) {
			mkdir($filePath, 0777, true);
		}
         
 
        if( $_FILES['attachFile']['name'] == '' ){  return json_encode(array()); }
 
        if( count( $_FILES['attachFile']['name'] ) == 0 ){ return json_encode(array());  }
        $count = count($_FILES['attachFile']['name']);

        
        $dataToinsert = []; 
		for ($i = 0; $i < $count; $i++) { 
			$fileName = $prefix .$postID .'_' . $_FILES['attachFile']['name'][$i]; 
            $tempFile = $_FILES['attachFile']['tmp_name'][$i];
            $targetFile = getcwd() .'\\'. $filePath .'\\'. $fileName;

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


    protected function getDownloadFile($id,$type__ = null,$type2 = null){
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
		}else if( $type__ == 'ass_attach'){
			$args = array(
				'from'	=> 'assignments',
				'where'	=> array( array( 'field' => 'ass_id', 'value' =>  $id ) )
			);

			$file = $this->prepare_query( $args )->result_array();
			$file = json_decode($file[0]['ass_attachments'],true); 
			
			$selectedfile  = array();
			foreach( $file as $f ){
				if($f['name'] == $filename){ $selectedfile = $f; }
			}

			$this->doDownload($selectedfile);
		}else if( $type__ == 'ass_submit' ){
			$args = array(
				'from'	=> 'task_submission_ass',
				'where'	=> array( array( 'field' => 'tsa_id', 'value' =>  $id ) )
			);

			
			$file = $this->prepare_query( $args )->result_array();
			$file = json_decode($file[0]['submission_content'],true);
			$file = json_decode( $file['attchments'],true );

			$selectedfile  = array();
			foreach( $file as $f ){
				if($f['name'] == $filename){ $selectedfile = $f; }
			}

			$this->doDownload($selectedfile); 
		}


    }

    private function doDownload($file){
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
                                        'project.activity',
                                        '../../plugins/slick-1.8.1/slick',
                                        '../../plugins/slick-1.8.1/slick-theme'
                                ),
                "projectScripts" => array(
                                        'project.interactive',
                                        '../plugins/slick-1.8.1/slick.min'
                )
            );  
        $videosArgs = array( 'from' => 'multimedia' );
        $dataPass['multimedia'] =$this->prepare_query($videosArgs)->result_array();
    $this->load->template( 'shared/activities',$dataPass);
   }


   private function removePost($postID){
    
    if( !isset($postID) && $postID ) return false;

    $args = array(
            'select'    => '*',
            'from'      => 'posts',
            'where'     => array(  array( 'field' => 'p_id', 'value'  =>  $postID ))
    ); 

    $post = $this->prepare_query($args);
    
    if( $post->num_rows() == 0 )  return false;
    
    $post = $post->result_array();
    $post = $post[0];

    if($post['post_ref_type'] == 0){
        $this->ProjectModel->delete( $postID, 'p_id', 'posts');
        $this->ProjectModel->delete( $post['post_info_ref_id'], 'np_id', 'normal_posts');
        echo json_encode( array( 'Error' => null) );
    }else{
        // check if there are already submissions
        $args = array(
                'select'    => 'count(ts_id) as submissions',
                'from'      => 'task_submissions',
                'where'     => array(  array( 'field' => 'task_id', 'value'  =>  $post['post_info_ref_id'] ))
        ); 


        $s = $this->prepare_query( $args )->result_array();
        $s = $s[0];

        if( $s['submissions'] > 0 ){
            return json_encode(  array('Error' => 'Cannot delete post. It is connected to a task that has submissions.' )  );
        }else{
            $this->ProjectModel->delete( $postID, 'p_id', 'posts');
            $this->ProjectModel->delete( $post['post_info_ref_id'], 'tsk_type', 'tasks');
            return json_encode( array( 'Error' => null) );
        }
    }
   }

   private function postNotification($postID,$type){
       if($type == 2 ){
            return $this->ProjectModel->delete( 
                array( 
                        'userid'   => getUserID(), 
                        'postid'   => $postID  
                    ), null, 'user_utility_post_notification');
       }else{
            $args = array(
                'userid'			=>  getUserID(), 
                'postid'			=>	$postID, 
            );
            return $this->ProjectModel->insert_CI_Query($args, 'user_utility_post_notification');
       }
   }


   private function postHidden($postID,$type){
        if( $type == 2 ){
            return $this->ProjectModel->delete( 
                    array( 
                            'user_id'   => getUserID(), 
                            'post_id'   => $postID  
                        ), null, 'user_utility_hidden_posts_log');
        }else{ 
            $args = array(
                            'user_id'			=>  getUserID(), 
                            'post_id'			=>	$postID, 
                        );
            return $this->ProjectModel->insert_CI_Query($args, 'user_utility_hidden_posts_log');
        }
    
   }

   protected function userPostSetting_($action, $postID){
       if($action == 1) return $this->removePost($postID);
       else if ($action == 3) return $this->postHidden($postID,1);
       else if ($action == 4) return $this->postHidden($postID,2);
       else if( $action == 5 ) return $this->postNotification( $postID,1 );
       else if( $action == 6 ) return $this->postNotification( $postID,2 );
        else  show_404(); 
   }




   
   protected function _getDueTasks($template,$classID = null, $returnTemplate = false){

       

       $args = array( 
                'select'    => 'tsk_title,tsk_id,tsk_duedate,tsk_status,tsk_type, tsk_type,
                                 (Select count(ts_id) from li_task_submissions as ts where ts.task_id = tsk_id) as sub_count',
                'from'      => 'tasks as tsk',
                'where'     => array( 
                                    array( 'field' => 'tsk_duedate >= DATE_ADD(CURDATE(), INTERVAL - WEEKDAY(CURDATE()) DAY)' ),
                                    array( 'field' => 'tsk_duedate <= DATE_ADD( DATE_ADD(CURDATE(), INTERVAL - WEEKDAY(CURDATE()) DAY) , INTERVAL 1 week)' ),
                                    )
       );

        if( getRole() == 'teacher' ){
            $args['where'][] = array( 'field' => '(select count(c.class_id) from li_classes c join li_task_class_assignees tca on tca.class_id = c.class_id  where c.teacher_id = '. getUserID() .') >', 'value' => 0 );
        }else{
            $args['where'][] = array('field' => '( select count(cs.class_id) from li_classes c join li_class_students as cs on cs.class_id = c.class_id where cs.admission_status = 1 and student_id = '. getUserID() .') > ', 'value'=> 0 );
            $args['select'] = $args['select'] . ',(select quiz_id from li_quizzes where task_id = tsk_id) as quiz_id,
                                                    (select ass_id from li_assignments where task_id = tsk_id) as as_id';
        } 

        if( isset($classID) ){
            $args['where'][] = array( 'field' => '(select count(ta_id) from li_task_class_assignees tca where tca.task_id = tsk.tsk_id and class_id = '. $classID .') > ', 'value'  => 0  );
        } 


        
        $dto = new DateTime(); 
        $dto->setISODate($dto->format("Y"), $dto->format("W"));
        $ret['week_start'] = $dto->format('Y-m-d 00:00:00');
        $dto->modify('+6 days');
        $ret['week_end'] = $dto->format('Y-m-d 23:59:59');
 
        $res = $this->prepare_query($args)->result_array();
        
        $res = array_map(function($a){
            $assignee = array(
                        'select'	=> 'class_name',
                        'from'		=> 'task_class_assignees as tca',
                        'join'		=> array( 
                                            array( 'table' => 'classes as c', 'cond' => 'tca.class_id = c.class_id'),
                                    ),
                        'where'		=> array( array( 'field' => 'tca.task_id', 'value' => $a['tsk_id'] ) )
            );
            
            if( getRole() == 'student' ){
                $assignee['where'][] = array('field' => '(select count(cs_id) from li_class_students as cs where cs.class_id = c.class_id and student_id = '. getUserID() .' ) > ', 'value' => 0);
            } 
            
            $ass = $this->prepare_query( $assignee )->result_array();
            
            $assignees = array();
            foreach( $ass as $t ){ 
                $assignees[] = $t['class_name'];
            }
            
            $a['assignees'] = implode(',',$assignees);
            return $a;
        },$res); 


        $d1 =  new DateTime( $ret['week_start']);
        $d2 =  new DateTime( $ret['week_end']);

        $range1 = $d1->format( 'F d')   ;
        $range2 = $d2->format('d'  );


        $daterange = array(
                                    'month_start' => $d1->format('F'),
                                    'year_start' => $d1->format('Y'),
                                    'month_end' => $d2->format('F'),
                                    'year_end' => $d2->format('Y'),
        );

        if( $daterange['month_start'] != $daterange['month_end'] ){
            $range2 .= $daterange['month_start'] . ' ' . $range2;
        } 


        if( $daterange['year_start'] != $daterange['year_end'] ){
            $range1 .= ', ' . $daterange['year_start'];
            $range2 .= ',' . $daterange['year_end'];
        }

        $var['daterange'] = implode(' - ', array( $range1,$range2 ));
      
        


        //  Check Remarks if late/submitted/or today

        $curDate = new DateTime();
        for($x = 0; $x < count($res);$x++){
            $duedate = new DateTime( $res[$x]['tsk_duedate'] ); 


            if( $res[$x]['tsk_status'] == 0 )  $res[$x]['remark'] = 'closed';
            else if ( $duedate->format('Y-m-d') == $curDate->format('Y-m-d')) $res[$x]['remark'] = 'today';
            else if( $curDate < $duedate  ) $res[$x]['remark'] = 'active';
            else if ($curDate > $duedate ) {
                if( getRole() == 'student' && $res[$x]['sub_count'] > 0 ) $res[$x]['remark'] = 'submitted';
                else $res[$x]['remark'] = 'late';
            }
           
        }
        

        
        
        $var['result'] = $res;

        if( $returnTemplate ){
            return $this->load->view( $template,$var,$returnTemplate );
        }
        return $var;
   }



   protected function setPostReaction($reactiontype,$postid){

   }

   protected function games__($type){
        $this->load->view("shared/interactive/games/". $type);
        // if ($type=="typing-it" ){       
        //     $this->load->view("shared/interactive/games/typing-it");
        // }else if ( $type == 'quiz-it' ){
        //     $this->load->view("shared/interactive/games/quiz-it");
        // }else if ( $type == 'scrabble-it' ){
        //     $this->load->view('shared/interactive/games/scrabble-it');
        // }else if ( $type == 'hangman' ){
        //     $this->
        // }
   }



   protected function createNotification(){

   }
 

   protected function addnotificationLogs($userid,$msg,$logtype = ''){
        $notificationlogs = array(
            'user_id' =>  $userid,
            'notification_msg' =>  $msg,
            'log_type' =>  $logtype,
        );

        $this->ProjectModel->insert_CI_Query( $notificationlogs, 'user_utility_notification_logs' );
   }

   protected function soloVideo($id){
        if( isset($id) && !is_null($id)){
            $args = array('from' => 'multimedia', 'where' => array( array( 'field' => 'm_id','value' => $id ) ));
            
            $video = $this->prepare_query(  $args );
           
            if( $video->num_rows() > 0 ){
                $var = array( 'video' =>  ($video->result_array())[0] );
                $this->load->template('shared/interactive/video-solo',$var );
            }else{
                show_404();
            }

        }else{
            show_404();
        }


   }


    protected function addFolder(){
        $foldername = $this->input->post('foldername');
        $parent = $this->input->post('parent');

        if( !isset($parent) ){
            $parent = 0;
        }

        $args = array(
                        'from' 		=> 'library_folders',
                        'where'		=> array( 
                                            array( 'field' => 'lf_name' , 'value' => $foldername),
                                            array( 'field' => 'lf_parent_folder' , 'value' => $parent),
                                    )
        ); 

        $args2 = array(
                'lf_name'	=> $foldername,
                'lf_parent_folder'	=> $parent,
                'author_id' => getUserID()
        ); 

        $folder_id = $this->insertIfnotexist( 	
            $args, array( 'data' => $args2, 'table' => 'library_folders' ), array(),
            TRUE, TRUE);
        
        if( $folder_id ){
            $this->returnResponse( 'Successly added folder' );
        }else{
            $this->returnResponse( 'Failed to add folder' );
        }


    }


    protected function getFolder(){
        $folderid = $this->input->post('parent');
        $classid = $this->input->post( 'classid' );


        $folders = array( 
                'select' => 'lf_name,lf.timestamp_created, concat(ui_firstname, " ", ui_lastname ) as author_name,lf_id',
                'from' => 'library_folders lf',
                'join'  => array( array( 'table'    => 'userinfo ui', 'cond' => 'ui.cred_id = lf.author_id'  ) ),
                'where' => array(  array( 'field' => 'lf_parent_folder','value' => $folderid ), )
            );
        if( getRole() == 'teacher' ){
            $folders['where'][] =  array( 'field' => 'author_id','value' => getUserID() );
        }
        

        if( isset($classid) ){
            $folders['join'][] = array( 'table' => 'library_class_shares lcs', 'cond' => 'lcs.folder_id = lf.lf_id' );
            $folders['where'][] = array( 'field' => 'lcs.class_id', 'value' => $classid );
        }



        
        $folders = $this->prepare_query( $folders )->result_array(); 

        $files = array( 
            'select' => 'lff_id,folder_id,file_name,file_path,lff.timestamp_created,  concat(ui_firstname, " ", ui_lastname ) as author_name',
            'from' => 'library_folder_files lff',
            'join'  => array( array( 'table'    => 'userinfo ui', 'cond' => 'ui.cred_id = lff.author_id'  ) ),
            'where' => array( 
                            array( 'field' => 'folder_id','value' => $folderid ),
                        )
        );

        $files = $this->prepare_query( $files )->result_array();
        echo json_encode( array( 'folders'=> $folders, 'files' => $files ));
    }

    protected function uploadlibraryfiles(){
        $folder_id = $this->input->post('folder_id');
        
        
        $filePath = 'assets\uploads\library\\' . date('Y') . '\\' . date('m') ;
        $dbPath = date('Y') . '\\' . date('m') . '\\';

        if (!file_exists($filePath)) {
            mkdir($filePath, 0777, true);
        }


        $counter = count( $_FILES['attachFile']['name'] );
        
        for ($i = 0; $i < $counter; $i++) { 
        
            $fileName = 'f_' . $folder_id .'_'. $_FILES['attachFile']['name'][$i]; 
            $tempFile = $_FILES['attachFile']['tmp_name'][$i];
            $targetFile = getcwd() .'\\'. $filePath .'\\'. $fileName;

            if( move_uploaded_file($tempFile, $targetFile) ){
                $args = array( 'folder_id' => $folder_id  );
                $name = $_FILES['attachFile']['name'][$i];
                $name = explode('.',$name); // explode with the '.'
                unset( $name[ count($name) - 1 ] );  // remove xtention
                $name = implode(' ', $name );  //glued together without name
                $name = preg_replace("/[\s-_]+/", " ", $name); 
                $args['file_name'] = $name;
                $args['file_path'] = $dbPath . $fileName;
                $args['author_id'] = getUserID();
                
            $this->ProjectModel->insert_CI_Query( $args, 'library_folder_files' );
            } 
            
        }
        
        $this->returnResponse( 'Files Uploaded' );
    }

    protected function removeFolderFile(){
        $id = $this->input->post('id');
        $type = $this->input->post('type');
        
        $table = 'library_folder_files';
        $field = 'lff_id';

        if( $type == 'folder' ){
            $table = 'library_folders';
            $field = 'lf_id';
        }

        if( $this->ProjectModel->delete( $id, $field, $table) ){
            $this->returnResponse( 'Successfully removed the item.');
        }else{
            $this->returnResponse('Failed to remove item.' );
        }

    }

    protected function shareFolder(){
        $assignids = $this->input->post('assignedids');
        $folderid = $this->input->post('folderid');
        
        $list = array();

        $idslist = implode(',',$assignids);
        $query = 'delete from li_library_class_shares where class_id not in ('. $idslist .') and folder_id = ' . $folderid;
        $this->ProjectModel->customQuery( $query );



        foreach($assignids as $id){
            $args = array( 'class_id'	=> $id, 'folder_id'	=> $folderid );
            $args2 = array('from'=> 'library_class_shares',
                            'where'	=> array( 
                                array( 'field' => 'class_id','value'=>$id),
                                array( 'field' => 'folder_id','value'=>$folderid),
                            ));
            $this->insertIfnotexist( $args2,array( 'data' => $args, 'table' => 'library_class_shares' ),null,true );
        }

        $this->returnResponse('Successfully updated assignees');
    }


    protected function fetchAssignees(){
        $folder_id = $this->input->post('folder');

        $args = array( 'from' => 'library_class_shares', 'where' => array( array('field' => 'folder_id', 'value' => $folder_id ) ) );

        $args2 = array( 'select' => 'class_id,class_name',
                        'from'	=> 'classes',
                        'where'	=> array( 
                                        array( 'field' => 'teacher_id', 'value' => getUserID() ),
                                        array( 'field' => 'class_status', 'value' => 1 ),
                                    )
                );

        $vars = array( 
                    'assignees' => $this->prepare_query( $args )->result_array(),
                    'classes' => $this->prepare_query( $args2 )->result_array(),
        );

        echo json_encode($vars);
    }
}
