<?  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Customer extends CI_Controller {
	function __construct()	{
		parent::__construct();
		
		$this->load->database('default');		
		$this->load->model('common_model');
		$this->load->model('customer_model');
		
		$this->load->helper('form');
		$this->load->helper('url');
		
		$this->load->helper('alert');

		$this->load->library('pagination_custom'); 
		
		$this->load->helper('left_menus');

		$this->segs = $this->uri->segment_array();		
	}
	
	public function _remap($method){
		$this->segs = $this->uri->segment_array();
		$location = $this->session->userdata('location');
		if(!$location) $location = "ko";
		$data = array();
		$data['location'] = $location;

		if($this->input->is_ajax_request()){
			if( method_exists($this, $method) ){
				$this->{"{$method}"}($location); 
			}
		}else{ //ajax가 아니면
			$this->load->view($location."/common/header2",$data);
			if( method_exists($this, $method) ){
				$this->{"{$method}"}($location);
			}
			$this->load->view($location."/common/footer2");
			//$this->output->enable_profiler(true);
		}
	}
	
	//faq 이미지 1개
	function index($location){
		redirect(BASE_URL."/customer/faq/");
		//$this->load->view($location."/customer/index_v");
 	}//end index
	
	//회사소개
	function info($location){
		$this->load->view($location."/customer/info_v");
	}
	//이용약관
	function policy($location){
		$this->load->view($location."/customer/policy_v");
	}
	//개인정보보호 방침
	function privacy($location){
		$this->load->view($location."/customer/privacy_v");
	}
	//협력제휴
	function partner($location){
		$this->load->view($location."/customer/partner_v");
	}
	function partner_post($location){
		$type = $this->input->post('type',true);
		$name = $this->input->post('name',true);
		$position = $this->input->post('position',true);
		$company = $this->input->post('company',true);
		
		$tel_1 = $this->input->post('tel_1',true);
		$tel_2 = $this->input->post('tel_2',true);
		$tel_3 = $this->input->post('tel_3',true);
		$tel =  $tel_1."-".$tel_2."-".$tel_3;
		
		
		$mobile_1 = $this->input->post('mobile_1',true);
		$mobile_2 = $this->input->post('mobile_2',true);
		$mobile_3 = $this->input->post('mobile_3',true);
		$mobile =  $mobile_1."-".$mobile_2."-".$mobile_3;
		
		//$mail_id = $this->input->post('mail_id',true);
		//$mail_domain = $this->input->post('mail_domain',true);
		//$email = $mail_id."@".$mail_domain;
		$email = $this->input->post('email',true);
		
		$content = $this->input->post('content',true);
		$department = $this->input->post('department',true);
		
		
		//업로드 설정
			$config['upload_path'] = './resources/uploads/partner/';
			$config['allowed_types'] = 'gif|jpg|png|jpeg|bmp|zip|alz|rar|hwp';
			$config['max_size']	= 0;
			//$config['max_width']  = '1024';
			//$config['max_height']  = '768';
			$config['encrypt_name'] = true;
			$config['remove_spaces'] = true;

			$this->load->library('upload', $config);
			$this->upload->initialize($config);		

			if (!$this->upload->do_upload())
			{
				$error = array('error' => $this->upload->display_errors());
				//print_r($error);
				$result['message'] = $error;
				$fileName = null;
			}
			else
			{
				$file_data = array('upload_data' => $this->upload->data(), 'error' => '');			
				$fileName = $file_data['upload_data']['file_name'];
				
				
			}			
			$createDatetime = date('Y-m-d H:i:s');
			
			$data = array(
				'type'=>$type,
				'name'=>$name,
				'position'=>$position,
				'company'=>$company,
				'tel'=>$tel,
				'mobile'=>$mobile,
				'email'=>$email,
				'content'=>$content,
				'department'=>$department,
				'fileName'=>$fileName,
				'createDatetime'=>$createDatetime				
			);
			
			$this->common_model->insert('tb_partner_offer',$data);
			alert('신청 완료 되었습니다.');
			
		
	}
	
	
	//
	function notice($location){
		$page = $this->input->get("page",true);//페이지번호		
		$type = $this->input->get("type",true);
		$stx =	$this->input->get("stx",true);
		$pagelist= 5;//페이지사이즈
		
		$db_data = $this->customer_model->notice_list($page,$pagelist,$type,$stx);
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
		$data['lists'] = $db_data['page_list_m'];
		$data['page_nation'] = $this->pagination_custom->create_links();		
		
		$this->load->view($location."/customer/notice_list_v",$data);
	}
	
	
	
	function notice_view($location){		
		$idx = $this->segs[3];
		$sfl = $this->input->get('sfl', true);
		$stx = $this->input->get('stx', true);
		$db_data = $this->customer_model->notice_view($idx,$sfl,$stx);
		
		
		$data = array();
		$data['notice'] = $db_data['page_view_m'];
		
		//print_r($data);
		$this->load->view($location."/customer/notice_detail_v",$data);
	}
	
	//faq 
	function faq($location){
		
		$page = $this->input->get("page",true);//페이지번호		
		$type = $this->input->get("type",true);
		$stx =	$this->input->get("stx",true);
		$pagelist= 30;//페이지사이즈
		
		$db_data = $this->customer_model->faq_list($page,$pagelist,$type,$stx);
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
		$data['faq'] = $db_data['page_list_m'];
		$data['page_nation'] = $this->pagination_custom->create_links();
		
		$this->load->view($location."/customer/faq_list_v",$data);
	}
	
	//이메일 문의
	function emailaq_view($location)
	{
		$data = array();
		$this->load->view($location."/customer/email_qa_v",$data);
	}
	
	function email_post($location)
	{
		$username = $this->input->post('username',true);
		$email = $this->input->post('email',true);
		$title = $this->input->post('title',true);
		$content = $this->input->post('content',true);
		
		//echo "<br><br><br><br><br>";
		//echo "email = ".$email; 
		


		$content = $username."님 (".$email.")이 보내주신 이메일 입니다. <br />".$content;
		//리턴 상태 코드
			$result = array();
			$result['status'] = "F";
			$result['message'] = "";
			$result['code'] = "E404";

			//업로드 설정
			$config = array();
			$config['upload_path']   = FCPATH . 'resources/uploads/email/';
			$config['overwrite']     = false;
			$config['allowed_types'] = 'gif|jpg|png|jpeg|bmp|zip|alz|rar|hwp';
			$config['max_size']	= 0;
			//$config['max_width']  = '1024';
			//$config['max_height']  = '768';
			$config['encrypt_name'] = true;
			$config['remove_spaces'] = true;

			$this->load->library('upload', $config);
			$this->upload->initialize($config);		

			if (!$this->upload->do_upload())
			{
				$error = array('error' => $this->upload->display_errors());
				//print_r($error);
				$result['message'] = $error;
				$fileName = null;
			}
			else
			{
				$file_data = array('upload_data' => $this->upload->data(), 'error' => '');			
				$fileName = $file_data['upload_data']['file_name'];
				
				
			}

		//이메일 문의 저장

		$insert = array();
		$insert['type'] = '99';
		$insert['isSmsAlram'] = false;
		$insert['title'] = false;
		$insert['content'] = false;
		$insert['createDatetime'] = date('Y-m-d H:i:s');
		$table = "tb_member";
		$where = array();
		if($this->session->userdata('email')){
			$where['email'] = $this->session->userdata('email');
		}else{
			$where['email'] = 'admin@thedays.co.kr';
		}

		$db = $this->customer_model->select_one($table,$where); //core 상속된거다 찾지마라

		//print_r($db);

		$insert['memberId'] = $db['rows']['id'];
		$insert['memberName'] = $db['rows']['name'];
		$insert['memberUserId'] = $db['rows']['userId'];
		$insert['memberEmail'] = $db['rows']['email'];
		$insert['memberMobile'] = $db['rows']['mobile'];

		$insert['title'] = $title;
		$insert['content'] = $content;
		//print_r($insert);
		//exit;

		//비회원일 경우
		if(!$this->session->userdata('email')) $insert['memberName'] = $username;
		if(!$this->session->userdata('email')) $insert['memberEmail'] = $email;
		$this->customer_model->insert('tb_email_inquiry',$insert);  //core 상속된거다 찾지마라


		$this->load->library('email');
		//$this->email->initialize($config);
		
		$this->email->from($email, $username);
		$this->email->to(MAIL_TO);
		
		
//		$this->email->cc('another@another-example.com'); 
//		$this->email->bcc('them@their-example.com'); 
		
		$this->email->subject($title);
		$this->email->message($content);
		
		//$this->email->message($this->load->view('email/'.$type.'-html', $data, TRUE)); //메세지
		//$this->email->set_alt_message($this->load->view('email/'.$type.'-txt', $data, TRUE)); //html 메일을 못받는 경우 txt 파일로 대체
			
		//$this->email->attach($config['upload_path'].$fileName);
		if($fileName) $this->email->attach($config['upload_path'].$fileName);

		//print_r($fileName);

		$status = $this->email->send();
		
		if($status){
			alert('이메일이 정상적으로 보내 졌습니다.','/customer/emailaq_view/');	
		}else{
			alert('이메일 전송 실패 하였습니다.','/customer/emailaq_view/');
		}
	}
	
	//비회원 주문
	function guest_movie($location){
		
		if(!$this->session->userdata('guest_oid')) alert('비회원 로그인 전용 입니다.','/auth/login');
		 $oid = $this->session->userdata['guest_oid'];
		 $password = $this->session->userdata['guest_password'];
		//$this->output->enable_profiler(true);
		
		$page = $this->input->get("page",true);//페이지번호		
		$pagelist= 20;//페이지사이즈
		
		$db_data = $this->customer_model->guest_movie_list(md5($password), $oid);
		
		//$link_url = "/".$this->segs[1]."/".$this->segs[2]."/";
		//$total_count = $db_data['total_cnt'];
		//$config = $this->pagination_custom->pagenation_b($page,$total_count,$pagelist,$link_url,$segment=3,$num_link=3);
		//$config['base_url'] = BASE_URL.$link_url;
		//$config['page_query_string'] = true; //쿼리 스트링
		//$config['query_string_segment'] = 'page';
		//$this->pagination_custom->initialize($config);

		$data = array();
		$data['lists'] = $db_data;

		//print_r($db_data);
		//$data['page_nation'] = $this->pagination_custom->create_links();
		
		$this->load->view($location."/customer/guest_movie_v",$data);
	}

//회사소개
	function company($location){
		$data = array();
		
		$this->load->view($location."/company_v",$data);
		
	}
	
}

	
