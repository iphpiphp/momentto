<?  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Review extends CI_Controller {
	function __construct()	{
		parent::__construct();
		
		$this->load->database('default');		
		$this->load->model('common_model');
		$this->load->model('product_model');
		
		$this->load->helper('form');
		$this->load->helper('url');
		
		$this->load->helper('alert');
		$this->load->helper('common');

		$this->load->library('pagination_custom');
		$this->load-> library('aws');
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
			if( substr($method,0,3) == "ifr" ){ //ifream 형식이면
				$this->{"{$method}"}($location);
			}else if(substr($method,0,4) == "cont"){
				$this->{"{$method}"}($location);
			}else{
				$this->load->view($location."/common/header2",$data);
				if( method_exists($this, $method) ){
					$this->{"{$method}"}($location);
				}
				$this->load->view($location."/common/footer2");
				//$this->output->enable_profiler(true);
			}
		}
	}
	function index(){
		redirect(BASE_URL."/product/lists");
 	}//end index
 	
 	function _update_click_up($id){
 		$table = "tb_product_review";		 //변경할 테이블		
		$id_name = "id"; //대상 아이디 이름
		$field = "viewCount"; //업 할 필드 명	
 		$this->common_model->update_plus($table, $field, $id, $id_name);
 	}
	
 	function ajax_update_click_up($location){
 		$table = "tb_product_review";		 //변경할 테이블
		$id = $this->input->post("id",true); //해당 아이디 번호
		$id_name = "id"; //대상 아이디 이름
		$field = "viewCount"; //업 할 필드 명		
 		echo $this->common_model->update_plus($table, $field, $id, $id_name);		
 	}
	//ajax 리뷰 등록
	function ajax_insert_review($location){

		if(!$this->uri->segment(3)) alert("잘못된 접근입니다.");
		if($this->uri->segment(3) == "insert"){
			if(!$this->session->userdata['email']){
				$result['status'] = "F";
				$result['message'] = "로그인이 필요 합니다.";
				$result['code'] = "504";
				$json_data = json_encode($result);
				print_r($json_data);
				exit;
			}

			//받은 값
			$title = $this->input->post('title',true);
			$content = $this->input->post('content',true);
			$score = $this->input->post('score',true);
			$productId = $this->input->post('productId',true);
			$email = $this->input->post('email',true);

			//리턴 상태 코드
			$result = array();
			$result['status'] = "F";
			$result['message'] = "";
			$result['code'] = "E404";

			//업로드 설정
			$config = array();
			$config['upload_path']   = FCPATH . 'resources/uploads/review/';
			$config['overwrite']     = false;
			$config['allowed_types'] = 'gif|jpg|png|jpeg|bmp';
			//$config["allowed_types"] = "video/x-msvideo|image/jpeg|image/png|video/mpeg|video/x-ms-wmv|bmp|jpg";
			//$config["allowed_types"] = "*";
			$config['max_size']	= '50480'; //kb... 50M   745967...?
			//$config['max_width']  = '1024';
			//$config['max_height']  = '768';
			$config['encrypt_name'] = true;

			$this->load->library('upload', $config);
			$this->upload->initialize($config);

			//print_r($_FILES);
			//print_r($this->upload->data());

			if (!$this->upload->do_upload())
			{
				$error = array('error' => $this->upload->display_errors());
				//print_r($error);
				//log_message("debug",$error);
				$result['message'] = $error;
				$fileName = null;
			}
			else
			{
				//upload
				$file_data = array('upload_data' => $this->upload->data(), 'error' => '');
				$fileName = $file_data['upload_data']['file_name'];
				//s3 upload
				//$file_data = array('upload_data' => $this->upload->data());
				//print_r($data);
				$s3 = $this->aws->s3_upload($file_data["upload_data"]["file_name"],'resources/uploads/review/', $config['upload_path']); //field name, s3path, realFilePath

				//print_r($s3);
				@unlink($file_data['upload_data']['full_path']); //file delete

			}

			$table = "tb_product_review";
			$date = date("Y-m-d h:i:s");
			$reg_ip = $this->input->ip_address();

			$email = explode('@',$this->session->userdata['email']);
			$mem_id = $email[0];
			$memberId = $this->session->userdata['mid'];
			if(!$memberId) $memberId = 0;

			$data = array(
				'productId'=> $productId,
				'orderId'=> '',
				'memberId'=>$memberId,
				'memberUserId'=>$mem_id,
				'memberName'=> $mem_id,
				'score' => $score,
				'title' => $title ,
				'content' => $content,
				'fileName' => $fileName,
				'viewCount' => 0,
				'createDatetime' => $date,
				'isBest' => 0
			);


			$return_status = $this->common_model->insert($table,$data);

			if($return_status['status'] == 1) {
				$result['status'] = "T";
				$result['message'] = "정상적으로 리뷰가 등록 되었습니다.";
				$result['code'] = "200";
			}else{
				$result['status'] = "F";
				$result['message'] = "등록에 실패 하였습니다.";
			}

			$json_data = json_encode($result);
			print_r($json_data);

		}
	}
	
	function lists($location){
		
		$page = $this->input->get("page",true);//페이지번호
		//$cate_id = $this->input->get("cate_id",true);//카테고리번호
		$pagelist= 10;//페이지사이즈
		
		
		$db_data = $this->product_model->review_list($page,$pagelist);
		$link_url = "/".$this->segs[1]."/".$this->segs[2]."/";
		$total_count = $db_data['total_cnt'];
		
		
		$config = $this->pagination_custom->pagenation_b($page,$total_count,$pagelist,$link_url,$segment=3,$num_link=3);
		$config['base_url'] = BASE_URL.$link_url;
		//if (count($_GET) > 0) $config['suffix'] = '&cate_id='.$cate_id;
		//$config['first_url'] = $config['base_url'].'?page=1';
		$config['page_query_string'] = true; //쿼리 스트링
		$config['query_string_segment'] = 'page';
		$this->pagination_custom->initialize($config);
		
		
		$data['reply'] = $db_data['reply'];
		$data['lists'] = $db_data['page_list_m'];
		$data['page_nation'] = $this->pagination_custom->create_links();
		$this->load->view($location."/review/lists_v",$data);

		//$this->load->view("common/header");

		//if($this->agent->is_mobile()){
		//	$this->load->view($location."/review/m_lists_v",$data);
		//}else{
		//	$this->load->view($location."/review/lists_v",$data);
		//}
	}
	
	function detail($location){
		
		
		$data = array();
		
		$review_id = $this->segs[3];
		$this->_update_click_up($review_id); //클릭수 업
				
		$db_data = $this->product_model->review_info($review_id);		
		$data['review_info'] = $db_data['review_info'];
		$data['reply'] = $db_data['reply'];
		$data['reply_cnt'] = $db_data['reply_cnt'];
		
		
		
		$this->load->view($location."/review/detail_v",$data);
		//print_r($data);
	}
	
	function ifr($location){
		$data = array();
		$this->load->view($location."/review/ifr_v",$data);
	}
	
	function review_reply($locaton){
		if(!$this->uri->segment(3)) alert("잘못된 접근입니다.");		
		if($this->uri->segment(3) == "insert"){
			
			if(!$this->session->userdata['email']){
				$result['status'] = "F";
				$result['message'] = "로그인이 필요 합니다.";
				$result['code'] = "504";
				$json_data = json_encode($result);
				print_r($json_data);
				exit;
			}
			
	
			//받은 값
			$title = $this->input->post('title',true);
			$content = $this->input->post('content',true);
			$score = $this->input->post('score',true);		 
			$productId = $this->input->post('productId',true);
			$email = $this->input->post('email',true);
			$reviewId = $this->input->post('reviewId',true);

			//리턴 상태 코드
			$result = array();
			$result['status'] = "F";
			$result['message'] = "";
			$result['code'] = "E404";
			

			//업로드 설정
			$config['upload_path'] = './resources/uploads/review/';
			$config['allowed_types'] = 'gif|jpg|png|jpeg|bmp';
			$config['max_size']	= '21945';
			$config['max_width']  = '1024';
			$config['max_height']  = '768';
			$config['encrypt_name'] = true;

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

			$table = "tb_product_review_reply";				
			$date = date("Y-m-d h:i:s");
			$reg_ip = $this->input->ip_address();

			
			$email = explode('@',$this->session->userdata['email']);
			$mem_id = $email[0];
			
			$memberId = $this->session->userdata['mid'];
			if(!$memberId) $memberId = 0;
			
			
			
			$data = array(
				'reviewId'=> $reviewId,
				'productId'=> $productId,
				'memberName'=> $mem_id,
				'title' => $title ,
				'content' => $content,
				'fileName' => $fileName,
				'createDatetime' => $date,
			);

			
			$return_status = $this->common_model->insert('tb_product_review_reply',$data);
			

			if($return_status['status'] == 1) {
				$result['status'] = "T";
				$result['message'] = "정상적으로 리뷰가 등록 되었습니다.";
				$result['code'] = "200";
				$where = array('idx'=>$return_status['insert_id']);
				$db_data = $this->common_model->select_one($table,$where);
				
				
				$result['productId'] = $productId;
				$result['reviewId'] = $reviewId;				
				$result['data'] =$db_data['rows']; 
				
			}else{
				$result['status'] = "F";
				$result['message'] = "등록에 실패 하였습니다.";
			}

			$json_data = json_encode($result);
			print_r($json_data);
		}
	}

	function contents($location){
		
		$page = $this->input->get("page",true);//페이지번호
		//$cate_id = $this->input->get("cate_id",true);//카테고리번호
		$pagelist= 30;//페이지사이즈
		
		
		$db_data = $this->product_model->contents_list($page,$pagelist);
		$link_url = "/".$this->segs[1]."/".$this->segs[2]."/";
		$total_count = $db_data['total_cnt'];
		
		
		$config = $this->pagination_custom->pagenation_b($page,$total_count,$pagelist,$link_url,$segment=3,$num_link=3);
		$config['base_url'] = BASE_URL.$link_url;
		//if (count($_GET) > 0) $config['suffix'] = '&cate_id='.$cate_id;
		//$config['first_url'] = $config['base_url'].'?page=1';
		$config['page_query_string'] = true; //쿼리 스트링
		$config['query_string_segment'] = 'page';
		$this->pagination_custom->initialize($config);
		
		
		$data['reply'] = $db_data['reply'];
		$data['lists'] = $db_data['page_list_m'];
		$data['page_nation'] = $this->pagination_custom->create_links();
				
		//$this->load->view("common/header");
		if($this->agent->is_mobile()){
			$this->load->view($location."/review/m_contents_v",$data);
		}else{
			$this->load->view($location."/review/contents_v",$data);
		}
	}

	function content($location){
		
		
		$data = array();
		
		$review_id = $this->segs[3];
		//$this->_update_click_up($review_id); //클릭수 업
				
		$db_data = $this->product_model->content_info($review_id);		
		$data['review_info'] = $db_data['review_info'];
		$data['reply'] = $db_data['reply'];
		$data['reply_cnt'] = $db_data['reply_cnt'];
		
		
		
		$this->load->view($location."/review/content_v",$data);
		//print_r($data);
	}
	
	
}
