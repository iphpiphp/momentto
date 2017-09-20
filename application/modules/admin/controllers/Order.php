<? if (!defined('BASEPATH')) exit('No direct script access allowed');
class Order extends CI_Controller {
	function __construct() {
		parent::__construct();
		//$this->load->model('order_model');
		$this->load-> library('pagination_custom_v3');
		$this->load-> helper('common');
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
	
	//주문리스트
	function order_list()
	{
		$input = array();
		foreach($this->input->post_get(NULL, TRUE) as $key => $val) $input["{$key}"]  = $val;
		if(!isset($input["page"])) $input["page"] = 1;
		if(!isset($input["pagelist"])) $input["pagelist"] = 30;
		$input["table"] = "tb_order";
		$data = $this->_temp_pagen("order_model","order_list", $input, $linkCnt=3);
		$data['input'] = $input;
		$this->load->view("/order/order_list_v",$data);
	}
	
	//환불리스트
	function refund_list()
	{
		$input = array();
		foreach($this->input->post_get(NULL, TRUE) as $key => $val) $input["{$key}"]  = $val;
		if(!isset($input["page"])) $input["page"] = 1;
		if(!isset($input["pagelist"])) $input["pagelist"] = 30;
		$input["table"] = "tb_order";
		$data = $this->_temp_pagen("order_model","refund_list", $input, $linkCnt=3);
		$data['input'] = $input;
		$this->load->view("/order/refund_list_v",$data);
	}
	
	//충전 [결제] 리스트
	function charge_list()
	{
		$input = array();
		foreach($this->input->post_get(NULL, TRUE) as $key => $val) $input["{$key}"]  = $val;
		if(!isset($input["page"])) $input["page"] = 1;
		if(!isset($input["pagelist"])) $input["pagelist"] = 30;
		$input["table"] = "tb_point_log";
		$data = $this->_temp_pagen("order_model","charge_list", $input, $linkCnt=3);
		$data['input'] = $input;
		$this->load->view("/order/charge_list_v",$data);
	}
	
	function movie_list()
	{
		$input = array();
		foreach($this->input->post_get(NULL, TRUE) as $key => $val) $input["{$key}"]  = $val;
		if(!isset($input["page"])) $input["page"] = 1;
		if(!isset($input["pagelist"])) $input["pagelist"] = 30;
		$data['input'] = $input;
		$input["table"] = "tb_order";
		
		$data = $this->_temp_pagen("order_model","order_list", $input, $linkCnt=3);
		$this->load->view("/order/order_list_v",$data);
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

	function email_send_list(){
		$input = array();
		foreach($this->input->post_get(NULL, TRUE) as $key => $val) $input["{$key}"]  = $val;
		if(!isset($input["page"])) $input["page"] = 1;
		if(!isset($input["pagelist"])) $input["pagelist"] = 30;
		$data['input'] = $input;

		$db_data = $this->common_model->email_send_list($input);

		$link_url = "/".$this->segs[1]."/".$this->segs[2]."/".$this->segs[3]."/";
		$total_count = $db_data['total_cnt'];
		$data['total_count'] = $total_count;

		$config = $this->pagination_custom2->pagenation_b($input["page"], $total_count, $input["pagelist"], $link_url, $segment=4, $num_link=3);
		$config['base_url'] = BASE_URL.$link_url;
		$config['page_query_string'] = true; //쿼리 스트링
		$config['query_string_segment'] = 'page';
		$config['display_always'] = TRUE;
		$config['use_fixed_page'] = TRUE;
		$config['fixed_page_num'] = 10;
		$this->pagination_custom2->initialize($config);

		$data['page_nation'] = $this->pagination_custom2->create_links();
		$data['lists'] = $db_data['page_list_m'];
		$this->load->view("/admin/email/list_v",$data);
	}

	function xls_coupon(){
		$input = array();
		foreach($this->input->get (NULL, TRUE) as $key => $val) $input["{$key}"]  = $val;
		foreach($this->input->post(NULL, TRUE) as $key => $val) $input["{$key}"]  = $val;
		if(!isset($input["page"])) $input["page"] = 1;
		if(!isset($input["pagelist"])) $input["pagelist"] = 30;
		$data['input'] = $input;

		$db_data = $this->common_model->xls_coupon($input);
		$data['xls'] = $db_data['xls'];
		$data['total_count'] = $db_data['total_cnt'];
		$this->load->view("/admin/coupon/xls_list_v",$data);
	}

}
