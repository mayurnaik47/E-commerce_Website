<?php

function alphabeticSpace($value) {
	$reg = "/^[A-Za-z ]+$/";
	return preg_match($reg,$value);
}

function sqlMetaChars($value) {
	$reg = "/((\%3D)|(=))[^\n]*((\%27)|(\')|(\-\-)|(\%3B)|(;))/i";
	return preg_match($reg,$value);
}

function sqlInjection($value) {
	$reg = "/\w*((\%27)|(\'))((\%6F)|o|(\%4F))((\%72)|r|(\%52))/i";
	return preg_match($reg,$value);
}

function sqlInjectionUnion($value) {
	$reg = "/((\%27)|(\'))union/i";
	return preg_match($reg,$value);
}

function sqlInjectionSelect($value) {
	$reg = "/((\%27)|(\'));\s*select/i";
	return preg_match($reg,$value);
}

function sqlInjectionInsert($value) {
	$reg = "/((\%27)|(\'));\s*insert/i";
	return preg_match($reg,$value);
}

function sqlInjectionDelete($value) {
	$reg = "/((\%27)|(\'));\s*delete/i";
	return preg_match($reg,$value);
}

function sqlInjectionDrop($value) {
	$reg = "/((\%27)|(\'));\s*drop/i";
	return preg_match($reg,$value);
}

function sqlInjectionUpdate($value) {
	$reg = "/((\%27)|(\'));\s*update/i";
	return preg_match($reg,$value);
}

function crossSiteScripting($value) {
	$reg = "/((\%3C)|<)((\%2F)|\/)*[a-z0-9\%]+((\%3E)|>)/i";
	return preg_match($reg,$value);
}
    
// mm/dd/yyyy format
function date1($value) { 
	$reg = "/(0[1-9]|1[012])[- \/.](0[1-9]|[12][0-9]|3[01])[- \/.](19|20)\d\d/";
	return preg_match($reg,$value);
}

function crossSiteScriptingImg($value) {
	$reg = "/((\%3C)|<)((\%69)|i|(\%49))((\%6D)|m|(\%4D))((\%67)|g|(\%47))[^\n]+((\%3E)|>)/i";
	return preg_match($reg,$value);
}

function numbers($value) {
	$reg = "/^[0-9]+$/";
	return preg_match($reg,$value);
}

function numeric($value) {
	$reg = "/(^-?\d\d*\.\d*$)|(^-?\d\d*$)|(^-?\.\d\d*$)/";
	return preg_match($reg,$value);
}

function integer($value) {
	$reg = "/(^-?\d\d*$)/";
	return preg_match($reg,$value);
}

function decimal($value) {
	$reg = "/^[0-9]*\.[0-9]+$/";
	return preg_match($reg,$value);
}


function sanitizeString($var)
{
	$var = trim($var);
	$var = stripslashes($var);
	$var = htmlentities($var);
	$var = strip_tags($var);
	return $var;
}

?>