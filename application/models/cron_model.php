<?php

 
class Cron_Model extends CI_Model {

    // var $_db = null;


    public function __construct() {
        parent::__construct();
       
    }



    public function getVerificationCodes(){
    	return $this->db->get('verification_codes');
    }

    
    public function delete($data){
    	$this->db->where_in('vc_code', $data);
        $this->db->delete('verification_codes');
        return $this->db->affected_rows();
    }
}
