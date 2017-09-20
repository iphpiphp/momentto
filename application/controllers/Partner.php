<?  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Partner extends CI_Controller {
	function __construct()	{
		parent::__construct();
		
		$this->load->database('default');		
		$this->load->model('common_model');
		
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->helper('common');
		$this->load->helper('alert');

		$this->load->library('pagination_custom');
		$this->segs = $this->uri->segment_array();		
	}
	
	public function _remap($method){
		$this->segs = $this->uri->segment_array();
		
		/*
		$location = $this->session->userdata('location');
		if(!$location) $location = "ko";
		$member = $this->session->userdata('email');
		if(!$member) $member = null;
		$data = array();
		$data['location'] = $location;
		$data['email'] = $member;
		*/
		$location = "partner";
		if( method_exists($this, $method) ) $this->{"{$method}"}($location);
		
	}
	
	
		
	function index($location){
					
 	}//end index
 	
 	//메인페이지
 	function main($location){
 		
 	}
	//카트페이지
 	function cart($location){
 		
 	}
	
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

	
