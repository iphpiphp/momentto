<? if (!defined('BASEPATH')) exit('No direct script access allowed');
class Member extends CI_Controller {
	function __construct() {
		parent::__construct();
		$this->load-> library('pagination_custom_v3');
		$this->load->helper('common');
		$this->load->model("member_model");
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

	function member_list()
	{
		$input = array();
		foreach($this->input->post_get(NULL, TRUE) as $key => $val) $input["{$key}"]  = $val;
		if(!isset($input["page"])) $input["page"] = 1;
		if(!isset($input["pagelist"])) $input["pagelist"] = 30;
		$input["table"] = "tb_member";
		
		if(isset($input["sfl"]) && $input["sfl"] == "mobile") $input["stx"] = str_replace(" ","",str_replace("-","",$input["stx"]));
		$data = $this->_temp_pagen("member_model","member_list", $input, "get");
		$data['input'] = $input;
		$this->load->view("/member/member_list_v",$data);
	}
	
	function member_modify()
	{
		$input = array();
		if(!isset($input["page"])) $input["page"] = 1;
		if(!isset($input["pagelist"])) $input["pagelist"] = 5;
		//foreach($this->input->post_get(NULL, TRUE) as $key => $val) $input["{$key}"]  = $val;
		//$this->segs[4]; 회원아이디
		$data = array("id"=>$this->segs[4]);
		$input["table"] = "tb_member";
		$input["memberId"] = $this->segs[4];
		
		$db = $this->member_model->select_one($input["table"],array("id"=>$this->segs[4]));
		$data['member'] = $db['rows'];
		$data['money'] = $this->member_model->select_sum("tb_member_saved_money", array("memberId"=>$this->segs[4]), "money");
		
		$input["table"] = "tb_member_coupon";
		
		
		
		//$db_coupon = $this->member_model->mycoupon($input); //memberId 만 넘김
		
		$data['mycoupon'] = $this->_temp_pagen("member_model","mycoupon", $input, "get");
		
		//print_r($data['mycoupon']);
		
		//$db_coupon = $this->member_model->mycoupon($this->segs[4]); //memberId 만 넘김
		
		$this->load->view("/member/member_modify_v",$data);
	}
	
	function member_crud()
	{
		//일단 수정만..
		if($this->segs[4])
		{
			$input = array();
			foreach($this->input->post(NULL, TRUE) as $key => $val) $input["{$key}"]  = $val;

			//print_r($input);

			$update = array();
			if(isset($input['name'])) $update['name'] = $input['name'];
			if(isset($input['password']) && $input['password']) $update['password'] = md5($input['password']); //값이 있을때만 업데이트
			if(isset($input['auth_lv'])) $update['auth_lv'] = $input['auth_lv'];
			if(isset($input['mobile'])) $update['mobile'] = $input['mobile'];
			//$table, $where_set, $data

			//print_r($update);

			//if($update['password']) $update['password'] = md5($update['password']);
			$db = $this->member_model->update('tb_member',array("field"=>"id","id"=>$input["memberId"]),$update); //모델에 들어가서 찾지마라. MY 에서 상속된거다
			alert("수정되었습니다.","/admin/member/member_list");
		}else{

		}
	}

	function ajax_point_update()
	{


		//echo $this->input->post('name',null);	exit;

		$input = array();
		foreach($this->input->post(NULL, TRUE) as $key => $val) $input["{$key}"]  = $val;
		$insert = array();
		if(isset($input['memberId'])) $insert['memberId'] = $input['memberId'];
		if(isset($input['money'])) $insert['money'] = $input['money'];
		if(isset($input['name'])) $insert['name'] = $input['name'];

		//print_r($insert);
		//exit;
		$db = $this->member_model->insert('tb_member_saved_money',$insert); //모델에 들어가서 찾지마라. MY 에서 상속된거다
		if($db['status']){
			echo "<script>alert('수정되었습니다.'); window.location.reload(true);</script>";
		}else{
			echo "<script>alert('수정실패!');</script>";
		}

	}

	function _temp_common_model($model,$model_func, $seg, $input)
	{
		$this->load->model("{$model}");
		$db_data = $this->{$model}->{$model_func}($input);
		return $db_data;
	}
	function _temp_model($model,$model_func, $input){
		$this->load->model("{$model}");
		$db_data = $this->{$model}->{$model_func}($input);
		return $db_data;
	}
	function _temp_pagen($model,$model_func, $input, $method = "get", $linkCnt = 3)
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
		
		
		if($method == "segment") $config['page_query_string'] = false; //쿼리 스트링 on off
		$config['page_query_string'] = false;
		
		
		$this->pagination_custom_v3->initialize($config);
		$data['page_nation'] = $this->pagination_custom_v3->create_links();
		$data['lists'] = $db_data['page_list_m'];
		
		//print_r($data['page_nation']);
		return $data;
	}

}//end
