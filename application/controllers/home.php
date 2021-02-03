<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Home extends MY_Controller {

    var $currentDomain = '';


	public function __construct() {
        parent::__construct();
        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
        $this->currentDomain = $protocol . $_SERVER['HTTP_HOST'] .'/learnit'; 
        
        $this->checkRole('home');
        
    }

	public function index(){
		$this->load->view('home/index');
	}


	public function login(){
        $this->load->library('encryption');

		$uname  = $this->input->post('uname');
        $pass   =  $this->input->post('pass');
        $pass   =  base64_encode( $pass );
        // $pass = $this->encryption->encrypt($pass);
        // $pass = md5($pass);
        if($uname){

            //  args using "uname"
            $args = array(
                        'select'    => 'user_id,role',
                        'from'      => 'users',
                        'where'     => array(
                                            array( 'field' => 'uname', 'value'  =>  trim($uname) ),
                                            array( 'field' => 'pass', 'value'  =>  trim($pass) ),
                                            array( 'field' => 'application_status', 'value' => 2 )
                        )
            );

            // TODO args for user's email or user's phone

            $data = $this->prepare_query( $args );
            if($data->num_rows() > 0){
                $d = $data->result_array()[0];
                $udata = array(
                                'sess_userID'         => $d['user_id'],
                                'sess_userRole'       => $d['role']
                );
                //  Get user info if not admin
                if( $d['role'] !== 'admin' ){
                    $userData = $this->getUserinfo( $d['user_id'] )->result_array();
                    $userData = $userData[0];


                    $uprofileData = !empty( $userData['ui_profile_data'] ) ? json_decode($userData['ui_profile_data'],true)  : null;

                    $udata['sess_userfName'] = check_value( $userData['ui_firstname'], 'User' );
                    $udata['sess_usermName'] = check_value( $userData['ui_midname'], 'M.' );
                    $udata['sess_userlName'] = check_value( $userData['ui_lastname'], 'Lastname' );
                    $udata['sess_userEmail'] = check_value( $userData['ui_email']);


                    if(!empty( $uprofileData )){
                        $udata['sess_userImage'] = isset($uprofileData['ui_profile_image_path']) ? $uprofileData['ui_profile_image_path'] : 'assets/images/user.png' ; 
                    }else{
                        $udata['sess_userImage'] = 'assets/images/user.png';
                    }
                }

                $this->session->set_userdata( array( 'userdata' => $udata ) );
                echo json_encode( array(
                                        'type'  => 'success', 
                                        'msg'   => 'Successfully logged in', 
                                        'link'  =>  $this->currentDomain .'/'. $d['role'],
                                        'responseType'  => 1
                                    ));
            }else{
                echo json_encode( array( 'type' => 'error', 'msg' => "Sorry, credentials not found." ) );
            }
        }
     }
 
    public function registration(){
        $this->load->library('encryption');
        $form = $this->input->post( 'form' );

        if(empty($form)){ return; }


        

        $this->userRegistration($form);

    } 

    private function userRegistration($role){
        $uname = $this->input->post('uname');
        $pass =  $this->input->post('password');
        $pass = base64_encode( uniqid() . $pass);
        $email = $this->input->post('email');
        $classcode = $this->input->post('qrCodetext');
        
        $dataSet = array( 'uname' => $email,  'pass' => $pass, 'role' => $role );
        $args = array(
                    'select'    => '*',
                    'from'      => 'users',
                    'where'     => array(   array( 'field' => 'uname', 'value'  =>  $email ))
                    );

        if($role == 'student'){ 
            $dataSet['uname'] = $uname;
            // $dataSet['application_status'] = 2;
            $args['where'][0]['value'] = $uname;

            //  Check the classcode first before proceeding
            // Get Class ID from classcode START
            // $classArgs = array(
            //                 'select'    => 'class_id,class_name,ui_email',
            //                 'from'      => 'classes as c',
            //                 'join'      => array( array( 'table' => 'userinfo as ui', 'cond' => 'ui.cred_id = c.teacher_id') ),
            //                 'where'     => array(   
            //                                     array( 'field' => 'class_code', 'value'  =>  $classcode ),
            //                                     array( 'field' => 'class_status', 'value'  =>  1 ),
            //                                 )
            //             );


            // $classInfo = $this->prepare_query( $classArgs );
            // // Get Class ID from classcode END

            // if( $classInfo->num_rows() == 0 ){
            //     echo json_encode( array( 'type' => 'error', 'msg' => 'Class code invalid! Either it does not exist or it has been closed already. Kindly try again or ask you teacher for verification of the code.' ) );
            //     return;
            // }else{
                // $classInfo = $classInfo->result_array()[0];
            // }

        }

        

        $t = $this->insertIfnotexist( $args,
                                 array(  
                                        'data' => $dataSet,
                                        'table' => 'users'
                                 ),
                                 array(),
                                 TRUE);
        if($t > 0){

            $newRecord = $this->prepare_query(  $args )->result_array()[0];
            $id = $newRecord['user_id'];

            if($role == 'student'){
                
                $v_code = $this->generateCode( 
                        6,
                        $this->prepare_query( array( 'select' => 'vc_code', 'from' => 'verification_codes'  ) )->result_array(),
                        'vc_code'
                );
        
                $this->ProjectModel->insert_CI_Query(  array(  'vc_code' => $v_code, 'user_id' => $id ), 'verification_codes');

                $this->addStudentInfo( $id, $v_code );
              

            }else{
                $v_code = $this->generateCode( 
                        30,
                        $this->prepare_query( array( 'select' => 'vc_code', 'from' => 'verification_codes'  ) )->result_array(),
                        'vc_code'
                );
                $fname = $this->input->post('fname');
                $lname = $this->input->post('lname');


                // Saved verification code to DB
                $this->ProjectModel->insert_CI_Query(  array(  'vc_code' => $v_code, 'user_id' => $id ), 'verification_codes');
               
                $this->ProjectModel->insert_CI_Query( array( 
                                                            'cred_id' => $id,
                                                            'ui_firstname' => $fname, 
                                                            'ui_lastname' => $lname ,
                                                            'ui_email'  => $email  ), 'userinfo' );
               
                // Send email verification
                $sendEmail =  $this->sendEmailVerificaiton(   $email, array( 'code' => $v_code ));
                if( $sendEmail ){
                    echo json_encode( array( 'type' => 'success', 'msg' => 'Registration successful, kindly check your email for verification.' ) );
                }else{
                    echo json_encode( array( 'type' => 'error', 'msg' => 'Failed to register,  email not sent.' ) );    
                }
            }
        }else{
            echo json_encode( array( 'type' => 'error', 'msg' => 'Sorry, registration failed. Email/username is already registered' ) );
        }

    }

    private function addStudentInfo($id,$vcode){
        $fname  = $this->input->post('fname');
        $lname = $this->input->post('lname');
        $guardianphone = $this->input->post('guardianphone');
        $guardianname = $this->input->post('guardianname');
        $email = $this->input->post('email');

       


        // for Userinfo table



        $userProfileData = array( 
                            'ui_guardian_phone' =>  $guardianphone,
                            'ui_guardian_name'  =>  $guardianname);

        $DTS_1 = array(
                        'cred_id'               => $id,
                        'ui_firstname'          => $fname,
                        'ui_lastname'           => $lname,
                        'ui_profile_data'       => json_encode($userProfileData),
                        'ui_email'              => $email,
        );
        // // for Class Students table
        // $DTS_2 = array(
        //                 'student_id'    => $id,
        //                 'class_id'    => $classInfo['class_id'],

        // );

        $this->ProjectModel->insert_CI_Query( $DTS_1, 'userinfo');
        // $this->ProjectModel->insert_CI_Query( $DTS_2, 'class_students');

        $err = [] ;

        if( !( is_bool( $msg ) && $msg ) )    $err[] = $msg; 

        if( !( is_bool( $email ) && $email ) )   $err[] = $email; 
        
        if( !empty( $err ) ){
            $err = implode(' ; ', $err);
        }else{ $err = null; }

        echo json_encode( array( 'type' => 'success', 'msg' => 'Check your guardian\'s mobile/email for the verification code.', 'error' => $err,'time'=> 3000 ) );

        // Send Message
        // $SMSMESSAGE = 'Mr./Ms. ' . ucwords($fname . ' ' . $lname ) . ' has successfully registered to LearnIT as a student.';
        $SMSMESSAGE = 'This is from LearnIT. Use this key to verify account : '. $vcode . '.'; 
        
        $msg = $this->sendSMS($guardianphone, $SMSMESSAGE);  //  ALREADY WORKING !!  UNCOMMENT TO CHECK/   Commented to prevent from spending the credits. 
        
        // Send Email
        if( isset($email) ){
            $email = $this->sendStudentVerification( $email, array( 'code' => $vcode) );
        }
        // $email = $this->sendNewStudentEmail( array( 'fname'  => $fname, 'lname'  => $lname, 'classname'  => $classInfo['class_name']), $classInfo['ui_email'] );
         
    }

    public function sendEmailVerificaiton($emailReciever = '', $content = array() ){
        $data = array(
                'receiver'      => $emailReciever,
                'template'      =>  'shared/email-templates/registration-email',
                'subject'       => 'Registration Email Verification '
        );

        return  $this->sendEmail( $data,$content ) ;
    }

    public function sendNewStudentEmail($studentInfo, $reciever){

        $data = array(
                    'receiver'  => $reciever,
                    'template'  => 'shared/email-templates/new-student-email',
                    'subject'   => 'New Student Notification'
        );

        return $this->sendEmail($data,$studentInfo);
    }

    private function  sendStudentVerification($reciever,$content){
        $data = array(
            'receiver'  => $reciever,
            'template'  => 'shared/email-templates/registration-email',
            'subject'   => 'Student\'s Guardian\' Email Verification'
        );
 
        return $this->sendEmail($data,$content);
    }

    public function verifyEmail( $token = null ){
        if( !empty($token) ){
            $message = '';
            $approved = false;
            $args = array(
                    'select'    => '*',
                    'from'      => 'verification_codes',
                    'where'     => array(  array( 'field' => 'vc_code', 'value'  =>  $token ))
                );
            $temp = $this->prepare_query( $args );

            if( $temp->num_rows() > 0 ){
                $temp = $temp->result_array()[0];
                $this->ProjectModel->delete( $token, 'vc_code', 'verification_codes' );
                $this->ProjectModel->update( 
                                            array('user_id' => $temp[ 'user_id' ] ),
                                            'users',
                                            array( 'application_status' => 2 )  );

                // VIEW SHOW APPLICATION APPROVEd
                $message =  'Email has been verified, you can now login to the website.';
                $approved = TRUE;
            }else{
                $message = 'Sorry, the code you used is not a valid code anymore. Please ';
            }
            $this->load->view('home/account-verification', array( 'message' => $message, 'approved' => $approved ));
        }else{
            show_404();
        }
        


    }

    public function verifyStudentMobile(){
      
            $message = '';
            $approved = false;
            $code = $this->input->post('code');
            $args = array(
                    'select'    => '*',
                    'from'      => 'verification_codes',
                    'where'     => array(  array( 'field' => 'vc_code', 'value'  =>  $code ))
                );
            $temp = $this->prepare_query( $args );

            if( $temp->num_rows() > 0 ){
                $temp = $temp->result_array()[0];
                $this->ProjectModel->delete( $code, 'vc_code', 'verification_codes' );
                $this->ProjectModel->update( 
                                            array('user_id' => $temp[ 'user_id' ] ),
                                            'users',
                                            array( 'application_status' => 2 )  );

                // VIEW SHOW APPLICATION APPROVEd
                $message =  'Email has been verified, you can now login to the website.';
                $approved = TRUE;    
                
                // $SMSMESSAGE = 'Mr./Ms. ' . ucwords($fname . ' ' . $lname ) . ' has successfully registered to LearnIT as a student.';
                // $this->sendSMS($guardianphone, $SMSMESSAGE);
                
            }else{
                $message = 'Sorry, the code you used is not a valid code anymore. Please ';
            }

            echo json_encode( array('msg' => $message,'approved' => $approved,   ) ) ; 
        
    }


    public function testEmail(){
        // $this->sendNewStudentEmail(
        //                 array( 'fname'  => 'Joemarie' , 'lname'  => 'arana', 'classname'  => 'classroom1' ) , 
        //                 'aranajoemarie@gmail.com' );

        $this->sendSMS('09464023418','testing text');
        
    }

    public function forgotPassword(){
        $input = $this->input->post('email_num');

        
    }


    public function encrypt__(){
		$this->load->library('encryption');
		$t = 'testing1234';

		echo base64_encode(  $t);
	}


}
