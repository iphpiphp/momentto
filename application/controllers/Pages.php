<?  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Pages extends CI_Controller {
	function __construct()	{
		parent::__construct();
		
		
		$this->output->enable_profiler(true);		
	}
	function index(){
		//get_ wp 함수들
		

 	}//end index
 	
 	function sha(){
 		$txt = $this->input->get('txt');
		echo hash('sha512', $txt);
		//$pass = hash("sha512", $pass);
 	}
	
	function times(){
		echo date("Y-m-d H:i:s");
	}

	function uniqid(){
		echo uniqid();
	}
	
	function login(){
		
		$this->load->view("page_login_v");
	}
	function ten(){
		$this->load->view("page/ten_v");
	}
	
	//테섭 인터넷 쿠폰 테스트
	function test_coupon(){
		
	}
	
	function test_m(){
		$item = "name";
		$value = "Love";
		$this->load->database('default');		
		$this->load->model('test_model');
		$this->test_model->test_m($item,$value);
		
	}
	

}

