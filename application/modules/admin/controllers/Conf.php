<? if (!defined('BASEPATH')) exit('No direct script access allowed');
class Conf extends CI_Controller {
	function __construct() {
		parent::__construct();
		$this->load-> library('pagination_custom_v3');
		$this->load->model("conf_model");
	}

	public function _remap($method) 
	{
		$this->segs = $this->uri->segment_array();
		$auth_lv = $this->session->userdata('auth_lv');
		if($auth_lv < 7) alert('접근 권한이 안 됩니다.','/auth/login');

		if ($this->input->is_ajax_request()) {
			
			if (method_exists($this, $method)) {
				$this -> {"{$method}"}();
			}
		} else if(isset($this->segs[4]) && $this->segs[4] =="excel"){
			if (method_exists($this, $method))  $this -> {"{$method}"}();
		} else {//ajax가 아니면
			
			$this->load->view("/admin/common/header_admin");
			$this->load->view("/admin/common/aside_left_admin");
			if (method_exists($this, $method)) {
				$this -> {"{$method}"}();
			}
			$this->load->view("/admin/common/footer_admin");
			//$this->output->enable_profiler(true);
		}
	}

	//모바일용 키워드 설정
	function mobile_keyword()
	{
		$input = array();
		foreach($this->input->post_get(NULL, TRUE) as $key => $val) $input["{$key}"]  = $val;
		if(!isset($input["page"])) $input["page"] = 1;
		if(!isset($input["pagelist"])) $input["pagelist"] = 30;
		$input["table"] = "zd_main_product_keyword";
		$data = $this->_temp_pagen("conf_model","mobile_keyword", $input, $linkCnt=3);
		$data['input'] = $input;
		$this->load->view("/conf/mobile_keyword_v",$data);
		
	}
	
	function faq_conf_list()
	{
		$input = array();
		foreach($this->input->post_get(NULL, TRUE) as $key => $val) $input["{$key}"]  = $val;
		if(!isset($input["page"])) $input["page"] = 1;
		if(!isset($input["pagelist"])) $input["pagelist"] = 30;
		$input["table"] = "tb_vfaq";
		$data = $this->_temp_pagen("conf_model","faq_conf_list", $input, $linkCnt=3);
		$data['input'] = $input;
		$this->load->view("/conf/faq_conf_list_v",$data);
	}

	function faq_conf_insert()
	{
		$data = array();
		$input["table"] = "tb_vfaq";

		//$db = $this->conf_model->select_one($input["table"],array("id"=>$this->segs[4]));
		$data['id'] = 0;
		$data['title'] = false;
		$data['content'] = false;
		$data['seq'] = 1;
		$data['mode'] = "insert";

		//print_r($data);
		$this->load->view("/conf/faq_conf_edit_v",$data);
	}

	function faq_conf_edit()
	{
		$data = array();
		$input["table"] = "tb_vfaq";

		$db = $this->conf_model->select_one($input["table"],array("id"=>$this->segs[4]));
		$data = $db['rows'];
		$data['mode'] = "modify";

		//print_r($data);
		$this->load->view("/conf/faq_conf_edit_v",$data);
	}

	function faq_conf_crud()
	{
		foreach($this->input->post(NULL, false) as $key => $val) $input["{$key}"]  = $val;
		if($this->segs[4] == "insert"){
			$data = array("seq"=>$input['seq'],
						  "title"=>$input['title'],
						  "content"=>$input['content']
						 );
			$st = $this->conf_model->insert("tb_vfaq",$data);
			alert("추가되었습니다.","/admin/conf/faq_conf_list");
		}
		if($this->segs[4] == "modify"){
			$data = array("seq"=>$input['seq'],
						  "title"=>$input['title'],
						  "content"=>$input['content']
			);
			$where_set = array("field"=>"id", "id"=>$input["id"]);
			$st = $this->conf_model->update("tb_vfaq",$where_set, $data);
			alert("수정되었습니다.","/admin/conf/faq_conf_list");
		}
	}

	//temp pagen
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
	

}
