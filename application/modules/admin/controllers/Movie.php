<? if (!defined('BASEPATH')) exit('No direct script access allowed');
class Movie extends CI_Controller {
	function __construct() {
		parent::__construct();
		//$this->load->model('order_model');
		$this->load->helper('common');
		$this->load-> library('pagination_custom_v3');
	}

	public function _remap($method) {
		$this->segs = $this->uri->segment_array();
		$auth_lv = $this->session->userdata('auth_lv');
		if($auth_lv < 7) alert('접근 권한이 안 됩니다.','/auth/login');

		if ($this -> input -> is_ajax_request()) {
			if (method_exists($this, $method)) {
				$this -> {"{$method}"}();
			}
		} else if(isset($this->segs[4]) && $this->segs[4] =="excel"){
			if (method_exists($this, $method))  $this -> {"{$method}"}();
		} else {//ajax가 아니면
			$this -> load -> view("/admin/common/header_admin");
			$this -> load -> view("/admin/common/aside_left_admin");
			if (method_exists($this, $method)) {
				$this -> {"{$method}"}();
			}
			$this -> load -> view("/admin/common/footer_admin");
			//$this->output->enable_profiler(true);
		}
	}

	function index(){}//end index

	function maker_list()
	{
		$input = array();
		foreach($this->input->post_get(NULL, TRUE) as $key => $val) $input["{$key}"]  = $val;
		if(!isset($input["page"])) $input["page"] = 1;
		if(!isset($input["pagelist"])) $input["pagelist"] = 30;
		$input["table"] = "tb_movie_maker";
		$data = $this->_temp_pagen("movie_model","maker_list", $input, $linkCnt=3);
		$data['input'] = $input;
		$this->load->view("/movie/maker_list_v",$data);
	}
	
	function store_list()
	{
		$input = array();
		foreach($this->input->post_get(NULL, TRUE) as $key => $val) $input["{$key}"]  = $val;
		if(!isset($input["page"])) $input["page"] = 1;
		if(!isset($input["pagelist"])) $input["pagelist"] = 30;
		$input["table"] = "tb_movie_store";
		$data = $this->_temp_pagen("movie_model","store_list", $input, $linkCnt=3);
		$data['input'] = $input;
		$this->load->view("/movie/store_list_v",$data);
	}
	
	
	function _temp_pagen($model,$model_func, $input, $linkCnt)
	{
		$this->load->model("{$model}");
		$db_data = $this->{$model}->{$model_func}($input);
		if($linkCnt) {
			$i = 1; $link_url="";
			while($linkCnt >= $i) {
				$link_url = $link_url."/".$this->segs[$i];  
				$i++;
			}
		}
		$total_count = $db_data['total_cnt'];
		$data['total_count'] = $total_count;
		$config = $this->pagination_custom_v3->pagenation_bootstrap($input["page"], $total_count, $input["pagelist"], $link_url, $linkCnt++, $num_link=3);		
		$this->pagination_custom_v3->initialize($config);
		$data['page_nation'] = $this->pagination_custom_v3->create_links();
		$data['lists'] = $db_data['page_list_m'];
		return $data;
	}

}//end
