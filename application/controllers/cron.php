<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Cron extends CI_Controller 
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Cron_Model');
    }
    
    /**
     * This function is used to update the age of users automatically
     * This function is called by cron job once in a day at midnight 00:00
     */
    public function updateAge()
    {            
        

    }

    public function removeVerificationCode(){

        $vcodes = $this->Cron_Model->getVerificationCodes()->result_array();
        $codestoDelete =  array();
        $dateNow = new DateTime();
        foreach ($vcodes as $code) {
            $t = new DateTime( date($code['timestamp']) );
            if( $dateNow->diff( $t )->d > 0){
               $codestoDelete[] = $code['vc_code']; 
            }
        }
        $this->Cron_Model->delete($codestoDelete);
    }

}
?>