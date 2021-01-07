<?php 


function check_value($var = "",$valueifEmpty = ''){
	return (empty($var) ? $valueifEmpty  : $var);
}