<?php  
//if ( ! defined('BASEPATH')) exit('No direct script access allowed' );

class Header_init extends CI_Controller {
	private $CI;

    function __construct()
    {
        $this->CI =& get_instance();

        if(!isset($this->CI->session)){  //Check if session lib is loaded or not
              $this->CI->load->library('session');  //If not loaded, then load it here
        }
    }

	/*
	function __construct(){
	    parent::__construct();
	}
	 * */
	public function inits(){
	
		$CI =& get_instance();
		$CI->load->library('session');	
		
		if(!$CI->session->userdata('location')) $CI->session->set_userdata('location','jp');
		if(!$CI->session->userdata('mid')) $CI->session->set_userdata('mid',false);
		if(!$CI->session->userdata('email')) $CI->session->set_userdata('email',false);
		if(!$CI->session->userdata('username')) $CI->session->set_userdata('username',false);
		if(!$CI->session->userdata('tel')) $CI->session->set_userdata('tel',false);
		if(!$CI->session->userdata('password')) $CI->session->set_userdata('password',false);
		if(!$CI->session->userdata('auth_lv')) $CI->session->set_userdata('auth_lv',false);
		
		if(!$CI->session->userdata('redirect')) $CI->session->set_userdata('redirect',false);
		if(!$CI->session->userdata('profile_img')) $CI->session->set_userdata('profile_img',false);
		
		if(!$CI->session->userdata('mobile')) $CI->session->set_userdata('mobile',"01011112222");
		
		if(!$CI->session->userdata('member_user_id')) $CI->session->set_userdata('member_user_id',false);
		
		
		
		
	}
}
