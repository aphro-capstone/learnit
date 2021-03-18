<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Common extends MY_Controller 
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();

        if( getSessionData('sess_userRole') == '' ){
            redirect('/home');
        }
    }
    
    public function profile(){
        $action = $this->input->post('action');  

        if($action == 'saveProfile') $this->profile___save_();
        else if($action == 'updatephoto') $this->profile___update_photo();
        else{
            $vars = array();
            $vars['projectCss']		= array('../../plugins/Cropper/cropper.min');
            $vars['projectScripts']	=  array( 
                'project.profile',
                '../plugins/Cropper/cropper.min' ); 

            $getDataArgs = array(
                                'from' => 'userinfo ui',
                                'where' => array( array('field' => 'cred_id','value' => getUserID() ) )
            );

            $data = $this->prepare_query( $getDataArgs )->result_array();
            $data = $data[0];
            $data['ui_profile_data'] = json_decode($data['ui_profile_data'],true);
            

            if( isset($data['ui_profile_data']['ui_profile_image_path'])){
                $data['ui_profile_data']['ui_profile_image_path'] = __USER_IMAGE_UPLOAD_PATH__ . $data['ui_profile_data']['ui_profile_image_path'];
            }

            $vars['UI'] = $data; 

            $this->load->template("shared/profile", $vars); 
        }
        
    }

    private function profile___save_(){
        
        echo $this->UM->updateUser();
    }
    
    private function profile___update_photo(){


        $file = $_FILES['attachFile'];
         
		$dbPath = date('Y') . '\\' . date('m') . '\\';

        clearstatcache();   
        $filename__ = $file['name'];
        $filext = explode('.', $filename__ );
        $filext = end( $filext );
        $fileName = 'learnit_it_user_image_user_'.getUserID() .'.'. $filext;  
		$fileName = preg_replace('/\s+/', '', $fileName);
        $tempFile = $file['tmp_name'];
		$targetFile = getcwd() . __USER_IMAGE_UPLOAD_PATH__ . $fileName;
		if(  move_uploaded_file($tempFile, $targetFile)  ){  
             
            // update DB
            $this->UM->updateUserImage( $fileName );
            $this->returnResponse('Successfully Updated Profile picture.', null, array( 'path' =>  __USER_IMAGE_UPLOAD_PATH__ . $fileName ) );
		}else{
			$this->returnResponse(null, 'failed uploading video');
        }
        

    }
  
    public function logout(){
       
        $this->UM->setUserOnlineStats(0);

        $this->session->sess_destroy();
        redirect('home');
    }
    
}
?>