<?php

function get_template_part($template_url,$array = array() ){
	$CI =& get_instance();
	return $CI->load->view($template_url,$array);
}

function get_header(){
	$CI =& get_instance();
	echo $CI->load->view('headfoot/header');
}


function get_footer(){
	$CI =& get_instance();
	echo $CI->load->view('headfoot/footer');
}

function getSubSubject($id){
	$CI =& get_instance();
	$args = array(
                'select'    => '*',
                'from'      => 'settings_subjects',
                'where'     => array( 
                					array( 'field' => 's_parent_sub', 'value'  =>  $id )
                					)
                );
	$data = $CI->prepare_query( $args );
	return $data;
}


function getSessionData($subkey,$key = null){
	$CI =& get_instance();
	if($key == null) $key = 'userdata';
	
	$data = $CI->session->userdata($key);
	
	if( $data ) return $data[$subkey];
	return '';
	// var_dump($CI->session->userdata($key));
	// return $CI->session->userdata($key)[$subkey];
}

function getRole(){
	return getSessionData('sess_userRole');
}

function getUserID(){
	return getSessionData('sess_userID');
}

function getUserName(){
	$CI =& get_instance();
	$arr =  array( 
				getSessionData('sess_userfName'), 
				getSessionData('sess_userlName'),
			) ;

	return implode(' ',$arr );
}


function getUserImage(){
	return base_url() . getSessionData('sess_userImage');
}

function getSiteLink ($suffix= ''){
	return site_url( getRole() .'/'. $suffix); 
}

function getActiveClass(){
	$CI =& get_instance();
	return $CI->session->userdata('activeClass');
}

function getTimeDifference($timestamp,$isshort = false, $suffix = ''){

	$timestamp = new DateTime($timestamp);
	$dateDiff = date_diff(new DateTime(),$timestamp);
	if( $dateDiff->m == 0 && $dateDiff->d == 0  ){
		if( $dateDiff->h !== 0 ) $diffDisplay = $dateDiff->h . ($isshort ? 'h ': ' hours ') .$suffix;
		else if( $dateDiff->i !== 0 ) $diffDisplay = $dateDiff->i . ($isshort ? 'm ': ' minutes ')  .$suffix;
		else $diffDisplay = $dateDiff->s . ($isshort ? 's ': ' seconds ') .$suffix;

	}else{
		$diffDisplay = date_format ( $timestamp , 'F j, Y') .' at '. date_format ( $timestamp , 'h:i A' ) ;
		
	}  

	return $diffDisplay ;
}

function computeAttachmentSize($bytes, $precision = 4){
	$units = array('B', 'KB', 'MB', 'GB', 'TB'); 

    $bytes = max($bytes, 0); 
    $pow = floor(($bytes ? log($bytes) : 0) / log(1024)); 
    $pow = min($pow, count($units) - 1); 

    // Uncomment one of the following alternatives
    // $bytes /= pow(1024, $pow);
    // $bytes /= (1 << (10 * $pow)); 
	$size = round($bytes, $precision);
	$unit = $units[$pow];
	if( $size > 999999 ){
		$size = $size /1000000;
		$unit ='Mb';
	}else if($size > 999){
		$size = $size/1000;
		$unit = 'Kb';
	}else{
		$unit = 'Byte';
	}

    return $size . ' '. $unit; 
}


function getdataFromprof( $prof, $key ){
	$prof = json_decode( $prof,true );
	return $prof[$key];
}