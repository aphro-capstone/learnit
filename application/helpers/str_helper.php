<?php 


function check_value($var = "",$valueifEmpty = ''){
	return (empty($var) ? $valueifEmpty  : $var);
}


function checkVal( $var,$RV = '' ){
	return isset($var) && !empty($var) && !is_null($var) ? $var : ( $RV ? $RV : ''); 
}