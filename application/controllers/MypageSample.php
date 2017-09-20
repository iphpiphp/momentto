<?  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class MypageSample extends CI_Controller {
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
	}
	public function _remap($method){
		$this->segs = $this->uri->segment_array();
		$location = $this->session->userdata('location');
			
		
		$data = array();
		if($this->input->is_ajax_request()){
			if( method_exists($this, $method) ) {
				$this->{"{$method}"}($location);
			}else{
				//없는 메소드 호출
			}
		}else{ //ajax가 아니면

			$this->load->view($location."/common/header");
			if( method_exists($this, $method) ) $this->{"{$method}"}($location);
			$this->load->view($location."/common/footer");
			//$this->output->enable_profiler(true);

		}
	}
	
	function index($location){
		//$email = $this->session->userdata('email');
		$email = "sample@thedays.co.kr";
		
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
					
		$this->load->view($location."/mypage/Sampleindex_v",$data);
 	}

	

} //end class

	
