<?  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Mypage extends CI_Controller {
	function __construct()	{
		parent::__construct();
		
		$this->load->database('default');		
		$this->load->model('common_model');
		$this->load->model('mypage_model');
		
		
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->helper('alert');
		$this->load->helper('left_menus');
		$this->load->library('user_agent');
		
		$this->load->library('pagination_custom');
		$this->load->library('pagination_custom_v3');
	}
	public function _remap($method){
		$this->segs = $this->uri->segment_array();
		$location = $this->session->userdata('location');
		
		if(!$this->session->userdata('email')){
			//alert("로그인이 필요합니다.","/auth/return_login/?uri=mypage");
			alert("로그인이 필요합니다.","/auth/login/");
		}
		
		$data = array();
		if($this->input->is_ajax_request()){
			if( method_exists($this, $method) ) {
				$this->{"{$method}"}($location);
			}else{
				//없는 메소드 호출
			}
		}else{ //ajax가 아니면

			$this->load->view($location."/common/header2");
			if( method_exists($this, $method) ) $this->{"{$method}"}($location);
			$this->load->view($location."/common/footer2");
			//$this->output->enable_profiler(true);

		}
	}
	
	function index($location){
		$email = $this->session->userdata('email');
		
		$page = $this->input->get("page",true);//페이지번호		
		$pagelist= 20;//페이지사이즈
		
		if(!$this->uri->segment(2)){
			$this->segs[2] = "";			
		}
		
		$db_data = $this->mypage_model->movie_list($page,$pagelist,$email);		
		$link_url = "/".$this->segs[1]."/".$this->segs[2]."/";
		$total_count = $db_data['total_cnt'];
		
		$config = $this->pagination_custom->pagenation_b($page,$total_count,$pagelist,$link_url,$segment=3,$num_link=3);
		$config['base_url'] = BASE_URL.$link_url;
		//if (count($_GET) > 0) $config['suffix'] = '&cate_id='.$cate_id;
		//$config['first_url'] = $config['base_url'].'?page=1';
		$config['page_query_string'] = true; //쿼리 스트링
		$config['query_string_segment'] = 'page';
		$this->pagination_custom->initialize($config);
		
		//print_r($db_data['movie_list']);
		//print_r($db_data['movie_item_list']);
		
		/*
		foreach($db_data['movie_list'] as $key => $val){
			foreach($db_data['movie_item_list'] as $key2 => $val2){
				echo "<br>".$val['id']."---".$val2['id'];
				if($val['id'] == $val2['id']) {
					
					$db_data['movie_list'][$key]['imageSfile'] = $val2['imageSfile'];
				}
			}
		}
		 * 
		 */
		$data = array();
		$data['lists'] = $db_data['movie_list'];
		$data['page_nation'] = $this->pagination_custom->create_links();
					
		$this->load->view($location."/mypage/index_v",$data);
 	}

	function point($location){
		$email = $this->session->userdata('email');
		
		$page = $this->input->get("page",true);//페이지번호		
		$pagelist= 10;//페이지사이즈
		
		$db_data = $this->mypage_model->point_list($page,$pagelist,$email);		
		$link_url = "/".$this->segs[1]."/".$this->segs[2]."/";
		$total_count = $db_data['total_cnt'];		
		
		$config = $this->pagination_custom->pagenation_b($page,$total_count,$pagelist,$link_url,$segment=3,$num_link=3);
		$config['base_url'] = BASE_URL.$link_url;
		//if (count($_GET) > 0) $config['suffix'] = '&cate_id='.$cate_id;
		//$config['first_url'] = $config['base_url'].'?page=1';
		$config['page_query_string'] = true; //쿼리 스트링
		$config['query_string_segment'] = 'page';
		$this->pagination_custom->initialize($config);
		
		
		$data = array();
		$data['point_list'] = $db_data['point_list'];
		$data['page_nation'] = $this->pagination_custom->create_links();
		$this->load->view($location."/mypage/point_v",$data);
		
	}
	
	function refund($location){
		$email = $this->session->userdata('email');
		
		$page = $this->input->get("page",true);//페이지번호		
		$pagelist= 20;//페이지사이즈
		
				
		$db_data = $this->mypage_model->refund_list($page,$pagelist,$email);		
		$link_url = "/".$this->segs[1]."/".$this->segs[2]."/";
		$total_count = $db_data['total_cnt'];		
		
		$config = $this->pagination_custom->pagenation_b($page,$total_count,$pagelist,$link_url,$segment=3,$num_link=3);
		$config['base_url'] = BASE_URL.$link_url;
		//if (count($_GET) > 0) $config['suffix'] = '&cate_id='.$cate_id;
		//$config['first_url'] = $config['base_url'].'?page=1';
		$config['page_query_string'] = true; //쿼리 스트링
		$config['query_string_segment'] = 'page';
		$this->pagination_custom->initialize($config);
			
		$data = array();
		$data['lists'] = $db_data['refund_list'];
		$data['page_nation'] = $this->pagination_custom->create_links();
					
		$this->load->view($location."/mypage/refund_v",$data);	
	}
	
	function refund_app($location){
		$email = $this->session->userdata('email');
		
		$page = $this->input->get("page",true);//페이지번호		
		$pagelist= 20;//페이지사이즈
		
				
		$db_data = $this->mypage_model->refund_app_list($page,$pagelist,$email);		
		$link_url = "/".$this->segs[1]."/".$this->segs[2]."/";
		$total_count = $db_data['total_cnt'];		
		
		$config = $this->pagination_custom->pagenation_b($page,$total_count,$pagelist,$link_url,$segment=3,$num_link=3);
		$config['base_url'] = BASE_URL.$link_url;
		//if (count($_GET) > 0) $config['suffix'] = '&cate_id='.$cate_id;
		//$config['first_url'] = $config['base_url'].'?page=1';
		$config['page_query_string'] = true; //쿼리 스트링
		$config['query_string_segment'] = 'page';
		$this->pagination_custom->initialize($config);
			
		$data = array();
		$data['lists'] = $db_data['refund_list'];
		$data['page_nation'] = $this->pagination_custom->create_links();
					
		$this->load->view($location."/mypage/refund_app_v",$data);	
	}
	
	
	
		
	function coupon($location){
		$email = $this->session->userdata('email');
		
		$page = $this->input->get("page",true);//페이지번호		
		$pagelist= 5;//페이지사이즈
				
		$type = null; //사용안함. 즉 사용가능.
				
		$db_data = $this->mypage_model->coupon_list($page,$pagelist,$email, $type);		
		$link_url = "/".$this->segs[1]."/".$this->segs[2]."/";
		$total_count = $db_data['total_cnt'];		
		
		$config = $this->pagination_custom->pagenation_b($page,$total_count,$pagelist,$link_url,$segment=3,$num_link=3);
		$config['base_url'] = BASE_URL.$link_url;
		//if (count($_GET) > 0) $config['suffix'] = '&cate_id='.$cate_id;
		//$config['first_url'] = $config['base_url'].'?page=1';
		$config['page_query_string'] = true; //쿼리 스트링
		$config['query_string_segment'] = 'page';
		$this->pagination_custom->initialize($config);
			
		$data = array();
		$data['lists'] = $db_data['coupon_list'];
		$data['page_nation'] = $this->pagination_custom->create_links();
		$this->load->view($location."/mypage/coupon_v",$data);
	}
	
	function coupon_fin($location){
		$email = $this->session->userdata('email');
		
		$page = $this->input->get("page",true);//페이지번호		
		$pagelist= 5;//페이지사이즈
				
		$type = 1; //사용준비
				
		$db_data = $this->mypage_model->coupon_list($page,$pagelist,$email, $type);		
		$link_url = "/".$this->segs[1]."/".$this->segs[2]."/";
		$total_count = $db_data['total_cnt'];		
		
		$config = $this->pagination_custom->pagenation_b($page,$total_count,$pagelist,$link_url,$segment=3,$num_link=3);
		$config['base_url'] = BASE_URL.$link_url;
		//if (count($_GET) > 0) $config['suffix'] = '&cate_id='.$cate_id;
		//$config['first_url'] = $config['base_url'].'?page=1';
		$config['page_query_string'] = true; //쿼리 스트링
		$config['query_string_segment'] = 'page';
		$this->pagination_custom->initialize($config);
			
		$data = array();
		$data['lists'] = $db_data['coupon_list'];
		$data['page_nation'] = $this->pagination_custom->create_links();
		$this->load->view($location."/mypage/coupon_v",$data);
	}
	
	
	function ajax_coupon_chk(){
		
		
		$userId = $this->session->userdata('mid');
		
		$pin_num1 = $this->input->post('pin_num1',true);
		$pin_num2 = $this->input->post('pin_num2',true);
		$pin_num3 = $this->input->post('pin_num3',true);
		$pin_num4 = $this->input->post('pin_num4',true);
		
		
		if(!$pin_num1 || !$pin_num2 ||!$pin_num3 || !$pin_num4) {
			
			$data['status'] = "false";
			$data['message'] = "번호를 전부 입력해 주세요.";
			
			$json_data = json_encode($data);
			print_r($json_data);
			exit;
		}
		
		
		$key = false;
		$tiket = false;
		$db_status = false;
		
		
			//각 넘버의 맨 앞자리 1개씩 뺀다
			$key = substr($pin_num1, 0,1);
			$key = $key.substr($pin_num2, 0,1);
			$key = $key.substr($pin_num3, 0,1);
			$key = $key.substr($pin_num4, 0,1);
			//나머지 3자리씩 9개를 만든다
			$tiket = substr($pin_num1, 1,3);
			$tiket = $tiket.substr($pin_num2, 1,3);
			$tiket = $tiket.substr($pin_num3, 1,3);
			$tiket = $tiket.substr($pin_num4, 1,3);
			//각각 암호화를 시켜서 조회 한다
			

			$db_status = $this->mypage_model->coupon_reg($key,$tiket,$userId);
			
			//$db_status = true;
		
		
		if($db_status){
			$status = "true";
			$msg = "정상 등록 되었습니다.";
		}else{
			$status = "false";
			$msg = "해당 쿠폰 정보가 없습니다."; 
		}
		
		$data['status'] = $status;
		$data['message'] = $msg;
		
		$json_data = json_encode($data);
		print_r($json_data);
	}
	
	function coupon_reg($location){
		
		
	}
	
	
	//회원정보 재입력
	function mylogin($location){
		$data = array();
		$this->load->view($location."/mypage/mylogin_v",$data);
	}
	
	//회원정보 수정
	function myinfo($location){
		$email = $this->input->post("email", TRUE);
		$pass = $this->input->post("password", TRUE);

		if (!$email)
			alert('이메일을 입력해 주세요');
		if (!$pass)
			alert('패스워드를 입력해 주세요');
		
		$pass = md5($pass);
		/*
		if($this->common_model->new_user_chk($email)) {
			$pass = hash("sha512", $pass);
		} else {
			$pass = md5($pass);
		}
		*/
		//echo "<br><br><br><br><br><br>$pass";
		$db_data = $this->common_model->login_chk($email, $pass);
		//var_dump($db_data);
		if ($db_data) {
			
			//$newdata = array('myinfo' => true);			
			//$this->session->set_userdata($newdata);			
			//redirect("/mypage/myinfo");
			$data['memberId'] = $db_data->id;
			$data['userId'] = $db_data->userId;
			$data['mobile'] = $db_data->mobile;
			
			$this->load->view($location."/mypage/myinfo_v",$data);
			
		}else{
			alert('아이디와 패스워드가 맞지 않습니다.');
		}
	}
	
	//회원정보 수정
	function myinfo_save($location){
		
		$pass = $this->input->post("password", TRUE);
		$mobile = $this->input->post("mobile", TRUE);
		$message = "변경 사항이 없습니다.";


		if($pass || $mobile){
			$email = $this->session->userdata['email'];
			
			$table= 'tb_member';
			$field = 'email';
			$where = $email;

			

			if(!$mobile) $mobile = "010";
			if(is_numeric($mobile) == false) $mobile = "010";

			$password = hash("md5", $pass);

			$data['mobile'] = $mobile;
			if($pass) $data['password'] = $password;
			$this->common_model->update($table, $field, $data, $where);

			$message = "요청하신 정보가 변경 되었습니다.";
		}
		///echo $message;
		alert($message,BASE_URL."/mypage");
	}

	function myqa($location)
	{
		$data = array();

		if($this->segs[3] == "lists"){
			$input = array();
			foreach($this->input->post_get(NULL, TRUE) as $key => $val) $input["{$key}"]  = $val;
			if(!isset($input["page"])) $input["page"] = 1;
			if(!isset($input["pagelist"])) $input["pagelist"] = 30;
			$input["table"] = "tb_email_inquiry";
			$input["email"] = $this->session->userdata['email'];

			$data = $this->_temp_pagen("mypage_model","myqa_list", $input, $linkCnt=3);
			$data['input'] = $input;

			$this->load->view($location."/mypage/myqa_lists_v",$data);
		}

		if($this->segs[3] == "views"){
			$input["table"] = "tb_email_inquiry";
			$input["email"] = $this->session->userdata['email'];
			$db=$this->mypage_model->myqa_views($input);
			$data['myqa'] = $db;
			$this->load->view($location."/mypage/myqa_views_v",$data);
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


} //end class

	
