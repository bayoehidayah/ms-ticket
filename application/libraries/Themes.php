<?php

if(!defined('BASEPATH')) exit('no file allowed');

class Themes{

    protected $_ci;

     function __construct(){
        $this->_ci =& get_instance();
    }

    function login($theme, $data=null){
        $data['login'] = true;
        $data['error'] = false;
        $this->adminlte($theme, $data);
    }
    
    function primary($theme, $data=null){
        $data['login'] = false;
        $data['error'] = false;
        $this->adminlte($theme, $data);
    }

    function error_404(){
        $data['login'] = false;
        $data['error'] = true;
        $this->adminlte("error_404", $data);
    }

    function adminlte($theme, $data=null){
        if(!$data['login']){
            $data['id'] = $this->_ci->session->userdata("id");
            $data['tipe'] = $this->_ci->session->userdata("tipe");
        }
        $data['content']=$this->_ci->load->view($theme,$data,true);
        $data['header']=$this->_ci->load->view('template/navbar.php',$data,true);
        $data['footer']=$this->_ci->load->view('template/footer.php',$data,true);
        $this->_ci->load->view('theme_config', $data);
    }
}
