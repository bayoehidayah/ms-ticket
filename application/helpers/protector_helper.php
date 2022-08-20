<?php
if(!defined('BASEPATH')) exit('no file allowed');
function check_login(){
	$Ci =& get_instance();
	$Ci->load->library('Session'); 
	$session = $Ci->session->userdata('status_login');
	if($session){
		redirect("home");
	}
}

function check_session(){
	$Ci =& get_instance();
	$Ci->load->library('Session'); 
	$session = $Ci->session->userdata('status_login');
	if(!$session){
		redirect(base_url());
	}
}

function isLoggedIn(){
	$Ci =& get_instance();
	$Ci->load->library('Session'); 
	$session = $Ci->session->userdata('status_login');
	return $session == true ? true : false;
}

function isItSupport(){
	$Ci =& get_instance();
	$Ci->load->library('Session'); 
	$session = $Ci->session->userdata('tipe');
	return $session == "it_support" ? true : false;
}

function getIDAuth(){
	if(isLoggedIn()){
		$Ci =& get_instance();
		$Ci->load->library('Session'); 
		$session = $Ci->session->userdata('id');
		return $session ? $session : null;
	}

	return null;
}

function getUser(){
	if(isLoggedIn()){
		$Ci =& get_instance();
		$Ci->load->library('Session'); 
		$session = $Ci->session->userdata();
		return $session ? $session : null;
	}

	return null;
}
?>
