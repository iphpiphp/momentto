<?  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Main extends CI_Controller {
	function Main()	{
		parent::__construct();
		
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->helper('alert');
		$this->load->helper('common');
		$this->load->helper('lang');
		
		
		$this->load->library('pagination_custom'); 
		$this->load->database('default');		
		$this->load->model('common_model');
		$this->load->model('product_model');

		$this->segs = $this->uri->segment_array();
		//$this->output->enable_profiler(true);		
	}
	public function _remap($method){
		$this->segs = $this->uri->segment_array();
		$location = $this->session->userdata('location');
		if(!$location) $location = "ko";
		$member = $this->session->userdata('email');
		if(!$member) $member = null;
		$data = array();
		$data['location'] = $location;
		$data['email'] = $member;
		
		
		
		
		
		if( method_exists($this, $method) ) $this->{"{$method}"}($location); 
		
	}
		
	function index($location){
		
		//로그인 상태이면
		if($this->session->userdata['mid']){
			$db_data = $this->common_model->init_status($this->session->userdata['mid'],$this->session->userdata['email']);
			$data['data1'] = $db_data['data1'];
			$data['data2'] = $db_data['data2'];
			$data['data3'] = $db_data['data3'];
			$data['data4'] = $db_data['data4'];
			$data['data5'] = $db_data['data5'];
			$data['data6'] = $db_data['data6'];
		}
		
		$page = $this->uri->segment(3);
		$pagelist= 100;
		$db_data = $this->common_model->main_product_list($location,$page,$pagelist);
		$db_data2 = $this->common_model->main_product_list2($location,$page,$pagelist);
		$db_data3 = $this->common_model->main_product_keyword($location);		
		
		$link_url = "/";
		$total_count = $db_data['total_cnt'];
		$config = $this->pagination_custom->pagenation_b($page,$total_count,$pagelist,$link_url,$segment=3,$num_link=3);
		$this->pagination_custom->initialize($config);
		

		$data['product_list'] = $db_data['product_list'];
		$data['bnr_list'] = $this->common_model->main_bnr_list($location);
		$data['page_nation'] = $this->pagination_custom->create_links();
		
		
		$data['product_list2'] = $db_data2['product_list2'];		
		$data['keyword_list'] = $db_data3['keyword_list'];
		
		
		//강제
		$this->load->view($location."/common/header2",$data);
		$this->load->view($location."/m_main_v2",$data);
		$this->load->view($location."/common/footer2");
		
		/*
		if($this->agent->is_mobile()){
			$this->load->view($location."/common/header",$data);
			$this->load->view($location."/m_main_v",$data);
			$this->load->view($location."/common/footer");
		}else{
			$this->load->view($location."/common/header",$data);
			$this->load->view($location."/main_v",$data);
			$this->load->view($location."/common/footer");
		}
		 
		*/
 	}//end index
	
	function ajax_index($location){
		$page = $this->input->post("page",true);
		$pagelist= 100;
		$data = $this->common_model->main_product_list($location,$page,$pagelist);
		
		$total_count = $data['total_cnt'];
		$endpage = false;
		if($total_count >0){
			$div_count = ceil($total_count / $pagelist);
			if($page >= $div_count) $endpage = true;			
		}
				
		$msg = "true";
		$data['msg'] = $msg;
		$data['endpage'] = $endpage;
		
		$data['div_count'] = $div_count;
		$data['total_count'] = $total_count;
		$data['page'] = $page;
		
		$json_data = json_encode($data);
		print_r($json_data);
	}
	
	//리스트 그려넣기 - 초기 상태
	function main_list_html($location){
		$cate = $this->uri->segment(3);
		$i = $this->uri->segment(4);
		$keyword = $this->uri->segment(5);
		
		if($cate == 'all') $cate = null;		
		if($keyword) $keyword = urldecode($keyword);
		
		$db_data = $this->common_model->main_list($cate, $keyword);
		$data['product_list'] = $db_data['product_list'];
		$data['i'] = $i;
		$this->load->view($location."/main_list_html_v",$data);
		
				
	}
	
	//리스트 추가 - 페이지네이션용 추가
	function main_list_add(){
		
	}
	
	function test(){
		echo "<br><br><br><br><br><br>";
		$lang = "ko";
		$this->lang->load('common', $lang);
		//$this->load->helper('language');
		echo "test!";
		echo $this->lang->line('head_alt_1');
		echo $this->lang->line('common_alt_2');
		
	}
	
	//헬퍼
	function helper($location){
		
		$data = array();
		$this->load->view($location."/common/header",$data);		
		$this->load->view($location."/helper_v",$data);
		
		$this->load->view($location."/common/footer",$data);
		
	}	
	
	function helper_send($location){
		//$this->output->enable_profiler(true);
		
		$subject = $this->input->post('subject',true);
		$message = $this->input->post('message');
		$mail_from = $this->input->post('mail_from');
		
		$this->load->library('form_validation');		
		$this->form_validation->set_rules('mail_from', 'Email', 'trim|required|valid_email');//빈 값, 자름, 이메일형식
		
		if ($this->form_validation->run() == FALSE) alert('이메일 형식이 올바르지 않습니다.');
		
		$this->load->library('email');
			
		$this->email->from($mail_from,'thedays');
		$this->email->to(MAIL_TO); 
		
		//		$this->email->cc('another@another-example.com'); 
		//		$this->email->bcc('them@their-example.com'); 
		
		$this->email->subject($subject);
		$this->email->message(nl2br($message));
		
		//$this->email->message($this->load->view('email/'.$type.'-html', $data, TRUE)); //메세지
		//$this->email->set_alt_message($this->load->view('email/'.$type.'-txt', $data, TRUE)); //html 메일을 못받는 경우 txt 파일로 대체
			
		
		$status = $this->email->send();
		if($status){
			alert('헬퍼 신청이 정상적으로 신청 되셨습니다.');
		}else{
			alert('신청이 실패 하였습니다.');
		}		
	}

	//체험하기
	function experience($location){
		$data = array();
		$this->load->view($location."/common/header",$data);
		$this->load->view($location."/experience_v",$data);
		$this->load->view($location."/common/footer",$data);
	}
	
	//메뉴얼
	function menual($location){
		$data = array();
		$this->load->view($location."/common/header",$data);
		$this->load->view($location."/menual_v",$data);
		$this->load->view($location."/common/footer",$data);
	}
	
	function mail_test($location){
		$data = array();
		$this->load->view($location."/common/header",$data);
		$this->load->view($location."/mailTemplate/order",$data);
		$this->load->view($location."/common/footer",$data);
	}	
	
}