<?  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Gate extends CI_Controller {
	function __construct()	{
		parent::__construct();		
		$this->load->helper('url');		
	}
	function index(){
		redirect("/gate/change/ko");
 	}//end index
 	
 	function change(){
 		$location = $this->uri->segment(3);
		$uri = $this->input->get("uri",true);
		$getstring = $this->input->get("get",true);
		$this->session->set_userdata('location',$location);
		//echo "-->".$this->session->userdata('location');
		//echo "/".$uri."?".$getstring;
		//$this->index();
		redirect(BASE_URL.$uri."?".$getstring);
	
 	}
	
	

}

