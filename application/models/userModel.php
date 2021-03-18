<?php

 
class userModel extends CI_Model {
 
    
    public $ui_firstname;
    public $ui_midname;
    public $ui_lastname;
    public $date_birth;
    public $gender;
    public $ui_guardian_phone; 
    public $ui_email;
    public $ui_profile_data = array();


    public function __construct() {
        parent::__construct();
       
    }


    public function setUserOnlineStats($status){
        $whereArray = array( 'user_id' => getUserID());
        $dataUpdate	= array( 'online_status'	=> $status);
  
        $this->db->where($whereArray);
        return $this->db->update('users', $dataUpdate);
    }

    public function updateUser(){
        $this->ui_firstname = $this->input->post('fname');
        $this->ui_midname = $this->input->post('mname');
        $this->ui_lastname = $this->input->post('lname');
        $this->date_birth = $this->input->post('day_birth');
        $this->gender = $this->input->post('gender');
        $this->ui_guardian_phone = $this->input->post('contact');
        $this->ui_email = $this->input->post('email');

        $addr = $this->input->post('addr');
        $gname = $this->input->post('guardian_name');
        
        if( $addr != ''){
            $this->ui_profile_data['address'] = $addr;
        }
        if(getRole() == 'student'){
            $this->ui_profile_data['ui_guardian_name'] = $gname;
        }

        $this->ui_profile_data = json_encode( $this->ui_profile_data );

        $this->db->where(array( 'cred_id' => getUserID() ));
        return $this->db->update('userinfo', $this);


    }

    public function updateUserImage($path){
        $this->db->select('ui_profile_data');
        $this->db->from('userinfo');
        $this->db->where('cred_id', getUserID());
        $a = $this->db->get()->result_array();
        $a = json_decode($a[0]['ui_profile_data'],true);

        $a['ui_profile_image_path'] = $path;

        $this->db->where('cred_id', getUserID());
        $this->db->update('userinfo', array('ui_profile_data' => json_encode($a)));
 
    }

    
}
