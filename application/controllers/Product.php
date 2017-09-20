<?  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Product extends CI_Controller {
	function __construct()	{
		parent::__construct();
		
		$this->load->database('default');		
		$this->load->model('common_model');
		$this->load->model('product_model');
		
		$this->load->helper('form');
		$this->load->helper('url');
				
		$this->load->helper('alert');
		$this->load->helper('common');
		
		$this->load->library('user_agent');

		$this->load->library('pagination_custom');
		$this->segs = $this->uri->segment_array();
		//date_default_timezone_set('Asia/Seoul');
	}
	public function _remap($method){
		$this->segs = $this->uri->segment_array();
		$location = $this->session->userdata('location');
		if(!$location) $location = "ko";
		$data = array();
		$data['location'] = $location;
		//$this->output->enable_profiler(true);
		
		if($this->input->is_ajax_request()){
			if( method_exists($this, $method) ){
				$this->{"{$method}"}($location); 
			}
		}else{ //ajax가 아니면
		
			if($method == "movieMake"){
				$this->{"{$method}"}($location);
			} elseif ($method == "movieMakeSample"){
				$this->{"{$method}"}($location);
			} elseif ($method == "detail"){
				$this->load->view($location."/common/header2");
				$this->{"{$method}"}($location);
				$this->load->view($location."/common/footer2");
			} elseif ($method == "lists"){
				$this->load->view($location."/common/header2");
				$this->{"{$method}"}($location);
				$this->load->view($location."/common/footer2");			
			}else{
				$this->load->view($location."/common/header2");
				if( method_exists($this, $method) ){
					$this->{"{$method}"}($location);
				}
				$this->load->view($location."/common/footer2");
				
			}
		}
	}
	function index(){
		redirect(BASE_URL."/product/lists");
 	}//end index
	
	function lists($location){
		$page = $this->input->get("page",true);//페이지번호
		$cate_id = $this->input->get("cate_id",true);//카테고리번호 
		$keyword = $this->input->get("keyword",true);//키워드
		$pagelist= 100;
		
		
		$db_data = $this->common_model->product_list($location,$page,$pagelist , $cate_id, $keyword);

		//$db_data3 = $this->common_model->main_product_keyword($location);

		foreach($db_data['product_list'] as $key => $val){
			//$db_data['product_list'][$key]['keywords'] = $this->common_model->product_genre($val['id']);

		}

		//print_r($db_data['product_list']);
		//exit;
		
		$link_url = "/";
		$total_count = $db_data['total_cnt'];
		$config = $this->pagination_custom->pagenation_b($page,$total_count,$pagelist,$link_url,$segment=3,$num_link=3);
		$this->pagination_custom->initialize($config);
		

		$data['product_list'] = $db_data['product_list'];		
		$data['page_nation'] = $this->pagination_custom->create_links();		
		//$data['keyword_list'] = $db_data3['keyword_list'];
		
		$this->load->view($location."/product/lists_v",$data);
	}
	
	function detail($location){
		
		$mid = $this->session->userdata('mid');
		
		$product_id = $this->segs[3];
		$db_data = $this->product_model->product_view($product_id, $mid);
		$data['product'] = $db_data['product'];
		$data['product_content'] = $db_data['product_list'];
		$data['product_chain_list'] = $db_data['product_chain_list'];
		$data['product_review_list'] = $db_data['product_review_list'];
		$data['product_review_list_total'] =		$db_data['product_review_list_total'];
		
		$data['review_oner'] =  $db_data['review_oner']; //true flase
		
		$db_data3 = $this->common_model->main_product_keyword($location);
		$data['keyword_list'] = $db_data3['keyword_list'];
		
		$this->load->view($location."/product/detail_v2",$data);
		//print_r($data);
	}
	
	function orderby($location){
		$cate_id = $this->uri->segment(3);
		$productId = $this->product_model->product_orderby($cate_id);
		
		
		//alert('','/product/detail/'+$productId);
		if($cate_id == 'all')
		 	redirect(BASE_URL."/product/detail/".$productId."/all");
		else
			redirect(BASE_URL."/product/detail/".$productId);
		
	}

	function filedown($location){
		
		$filename = $this->uri->segment(3);
		$newfilename = $this->uri->segment(4);
		
		$this->load->helper('download');
		$data = file_get_contents(FCPATH . "resources/set_zip/".$filename); // Read the file's contents    
 
        force_download($newfilename, $data);


		//$data = file_get_contents(FCPATH."/resources/set_zip/".$filename); // Read the file's contents
		//force_download($newfilename, $data);
	}
	


	function movieMake($location)

	{


		$orderId = $this->input->get('orderId',true);

		$orderItemId = $this->input->get('orderItemId',true);
		
		if(!$orderId) $orderId = $this->input->post('orderId',true);

		if(!$orderItemId) $orderItemId = $this->input->post('orderItemId',true);




		$db_data = $this->product_model->movieMake($orderId,$orderItemId);

		$data['movieMake'] =$db_data['movieMake'];
		$this->load->view($location."/product/movieMake_v",$data);
	}

	function movieMakeSample($location)

	{

		$productId = $this->input->get('productId',true);

		if(!$productId) $productId = $this->input->post('productId',true);


		$db_data = $this->product_model->movieMakeSample($productId);

		$data['movieMake'] =$db_data['movieMake'];



		$this->load->view($location."/product/movieMakeSample_v",$data);

	}


}
