<?  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends CI_Controller {
	function __construct()	{
		parent::__construct();
		$this->load->library('pagination_custom');
		$this->load->model('common_model');
		$this->segs = $this->uri->segment_array();
		//$this->output->enable_profiler(true);
	}
	public function _remap($method){
		$this->segs = $this->uri->segment_array();
			
		$location = $this->session->userdata('location');
		
		$auth_lv = $this->session->userdata('auth_lv');

		if($auth_lv <= 7) alert('접근 권한이 안 됩니다.','/auth/login');

		if($this->input->is_ajax_request()){
			if( method_exists($this, $method) ){
				$this->{"{$method}"}(); 
			}
		}else{ //ajax가 아니면
			$this->load->view("/admin/common/header_admin");
			$this->load->view("/admin/common/aside_left_admin");
			if( method_exists($this, $method) ){
				$this->{"{$method}"}();
			}
			$this->load->view("/admin/common/footer_admin");
			//$this->output->enable_profiler(true);
		}
	}
	
	function index()
	{
		$data = array();
		$data = $this->common_model->analytics();
		//print_r($data['db']);
		$this->load->view("/admin/index_v",$data);
 	}//end index 	

 	
}

	
