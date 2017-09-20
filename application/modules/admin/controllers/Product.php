<? if (!defined('BASEPATH')) exit('No direct script access allowed');

class Product extends CI_Controller {
	function __construct() {
		parent::__construct();
		$this->load->model('product_model');
		$this->load-> library('pagination_custom_v3');
		$this->load-> library('aws');
		$this->load->helper(array('form', 'url'));
		
		
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
		
	//상품리스트
	function product_list()
	{
		$input = array();
		foreach($this->input->post_get(NULL, TRUE) as $key => $val) $input["{$key}"]  = $val;
		if(!isset($input["page"])) $input["page"] = 1;
		if(!isset($input["pagelist"])) $input["pagelist"] = 30;
		$input["table"] = "tb_product";
		$data = $this->_temp_pagen("product_model","product_list", $input, $linkCnt=3);
		$data['input'] = $input;
		$this->load->view("/product/product_list_v",$data);
	}
	
	//미진열 상품리스트
	function product_hidden_list()
	{
		$input = array();
		foreach($this->input->post_get(NULL, TRUE) as $key => $val) $input["{$key}"]  = $val;
		if(!isset($input["page"])) $input["page"] = 1;
		if(!isset($input["pagelist"])) $input["pagelist"] = 30;
		$input["table"] = "tb_product";
		$data = $this->_temp_pagen("product_model","product_hidden_list", $input, $linkCnt=3);
		$data['input'] = $input;
		$this->load->view("/product/product_hidden_list_v",$data);
	}
	
	//상품 추가 페이지
	function product_add()
	{
		$data = array();
		$this->load->view("/product/product_add_v",$data);
	}
	
	//상품 수정 페이지
	function product_edit()
	{
		$input = array();
		$data = array();
		foreach($this->input->post_get(NULL, TRUE) as $key => $val) $input["{$key}"]  = $val;
		if(!isset($input["no"])) alert('not select product Id');
		
		$db = $this->product_model->select_one("tb_product", array("id"=>$input["no"]));
		//$db_img = $this->product_model->select_get("tb_product_content", array("productId"=>$input["no"], "meta"=>"L")); //스몰사이즈로
		$db_img = $this->product_model->select_get("tb_product_content", array("productId"=>$input["no"])); //스몰사이즈로
		$data['input'] = $input;
		$data['product'] = $db['rows'];
		$data['product_content'] = $db_img->result_array();
		$this->load->view("/product/product_edit_v",$data);
	}
	
	//상품 crud
	function product_crud()
	{
		$input = array();
		$file = array();
		foreach($this->input->post(NULL, TRUE) as $key => $val) $input["{$key}"]  = $val;
		
		$img = null;
		if(!isset($input['imagePath'])) $input['imagePath'] = null;
		$mode = $this->uri->segment(4);
		
		//print_r($input);		exit;
		if($mode == "add"){
			//insert mode
			$insert = array(
				'categoryId'=>$input['categoryId'], 
				'name'=>$input['productName'],
				'runtime'=>$input['runtime'], 
				'imageText'=>$input['imageText'], 
				'movieText'=>$input['movieText'], 
				'production'=>null, 
				'originalMusic'=>$input['originalMusic'], 
				'recommendMusic'=>$input['recommendMusic'], 
				'resolutionId' => $input['resolutionId'],
				'price'=>$input['price'], 
				'eventPrice'=>$input['eventPrice'], 
				'isDisplay'=>false, 
				'sort'=>$input['sort'],
				'movieVimeoId'=>$input['movieVimeoId'],
				'imagePath'=>'/resources/uploads/product/image', 
				'img'=>$img, 
				'preset1'=>$input['preset1'],
				'exText'=>$input['exText'], 
				'createDatetime'=>date('Y-m-d H:i:s')
			);

			$db = $this->product_model->insert('tb_product',$insert); //모델에 들어가서 찾지마라. MY 에서 상속된거다

			if($db){

				if($_FILES['uploadMainImage1']) {
					$file=$this->_do_upload_multi('uploadMainImage1', $db['insert_id']);
					//$img = $file['ObjectURL'];
				}
				if($_FILES['uploadMainImage2']) {
					$file=$this->_do_upload_multi('uploadMainImage2',$db['insert_id']);
				}
				if($_FILES['uploadMainImage3']) {
					$file=$this->_do_upload_multi('uploadMainImage3',$db['insert_id']);
				}

				return true;
			}
		}
		
		if($mode == "modify"){
			//modify
			$update = array();
			if(isset($input['categoryId'])) $update['categoryId'] = $input['categoryId'];
			if(isset($input['name'])) $update['name'] = $input['name'];
			if(isset($input['runtime'])) $update['runtime'] = $input['runtime'];
			if(isset($input['imageText'])) $update['imageText'] = $input['imageText'];
			if(isset($input['movieText'])) $update['movieText'] = $input['movieText'];
			if(isset($input['production'])) $update['production'] = $input['production'];
			if(isset($input['originalMusic'])) $update['originalMusic'] = $input['originalMusic'];
			if(isset($input['recommendMusic'])) $update['recommendMusic'] = $input['recommendMusic'];
			if(isset($input['price'])) $update['price'] = $input['price'];
			if(isset($input['eventPrice'])) $update['eventPrice'] = $input['eventPrice'];
			if(isset($input['usd'])) $update['usd'] = $input['usd'];

			if(isset($input['isDisplay'])) $update['isDisplay'] = $input['isDisplay'];
			if(isset($input['sort'])) $update['sort'] = $input['sort'];
			if(isset($input['movieVimeoId'])) $update['movieVimeoId'] = $input['movieVimeoId'];
			if(isset($input['preset1'])) $update['preset1'] = $input['preset1'];
			if(isset($input['exText'])) $update['exText'] = $input['exText'];
			if(isset($input['keyword'])) $update['keyword'] = $input['keyword'];



			//$table, $where_set, $data
			$db = $this->product_model->update('tb_product',array("field"=>"id","id"=>$input["productId"]),$update); //모델에 들어가서 찾지마라. MY 에서 상속된거다
			
			if($db){
				//echo "<pre>";print_r($_FILES);echo "</pre>";
				if(isset($_FILES['uploadMainImage1'])) {
					if($_FILES['uploadMainImage1']['size'][0]>=1) $file=$this->_do_upload_multi('uploadMainImage1', $input['productId']);
					//$img = $file['ObjectURL'];
				}
				if(isset($_FILES['uploadMainImage2'])) {
					if($_FILES['uploadMainImage2']['size'][0]>=1) $file=$this->_do_upload_multi('uploadMainImage2', $input['productId']);
				}
				if(isset($_FILES['uploadMainImage3'])) {
					if($_FILES['uploadMainImage3']['size'][0]>=1) $file=$this->_do_upload_multi('uploadMainImage3', $input['productId']);
				}

				alert('Product Data Update!','/admin/product/product_list');

				//return true;
			}
			
		}
		if($mode == "del"){}
	}

	function _do_upload_multi($target_file, $insertId = null)
	{       
		$this->load->library('upload');
		$files = $_FILES;
		//echo "'$target_file'";		
		$cpt = count($_FILES["$target_file"]['name']);
		$target_file_temp = $target_file."_temp";
		for($i=0; $i<$cpt; $i++) {
			$_FILES["$target_file_temp"]['name']   =	$files["$target_file"]['name'][$i];
			$_FILES["$target_file_temp"]['type'] = 		$files["$target_file"]['type'][$i];
			$_FILES["$target_file_temp"]['tmp_name'] = 	$files["$target_file"]['tmp_name'][$i];
			$_FILES["$target_file_temp"]['error'] =		$files["$target_file"]['error'][$i];
			$_FILES["$target_file_temp"]['size'] = 		$files["$target_file"]['size'][$i];
			
			$this->upload->initialize($this->set_upload_options());						
			if ( !$this->upload->do_upload($target_file_temp)) {
			  	$error = array('error' => $this->upload->display_errors());
				print_r($error);
				return false;
			
			} else {
				//echo "<br><br><br><br><br><br>ok";
				$data = array('upload_data' => $this->upload->data());
				//print_r($data);
				$s3 = $this->aws->s3_upload($data["upload_data"]["file_name"],null,null); //field name, s3path, filepath
				unlink($data['upload_data']['full_path']); //file delete
				//print_r($s3);
				
				//대표이미지 저장- 업데이트
				if($s3['status'] == true && ($target_file == 'uploadMainImage1') ) {
					//how to use...  table, where_set, data
					$this->product_model->update('tb_product', array("field"=>"id", "id"=>$insertId), array('img'=>$data["upload_data"]["file_name"]));
				}
				//슬라이드 이미지 저장
				if($s3['status'] == true && ($target_file == 'uploadMainImage3' || $target_file == 'uploadMainImage4') ) {
					$insert = array('id'=>null,'productId'=>$insertId,'sort'=>$i,'meta'=>'L','image'=>$data["upload_data"]["file_name"], 'createDatetime'=>date('Y-m-d H:i:s'));
					$this->product_model->insert('tb_product_content',$insert);
				}
				
			}
		}
		return $s3;
	}
 
	function set_upload_options()
	{   
		//upload an image options
		$config = array();
		$config['upload_path']   = FCPATH . 'resources/uploads/product/temp/';
		$config['allowed_types'] = 'gif|jpg|png';
		$config['max_size']      = '1000';
		$config['overwrite']     = false;
		return $config;
	}
	
	
	function _temp_pagen($model,$model_func, $input, $linkCnt)
	{
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

	function xls_down(){
		dirname(__FILE__) . APPPATH.'/libraries/PHPExcel.php';

		error_reporting(E_ALL);
		ini_set('display_errors', TRUE);
		ini_set('display_startup_errors', TRUE);
		date_default_timezone_set('Europe/London');

		if (PHP_SAPI == 'cli')
			die('This example should only be run from a Web Browser');

		/** Include PHPExcel */
		//require_once dirname(__FILE__) . '/../Classes/PHPExcel.php';


		// Create new PHPExcel object
		$objPHPExcel = new PHPExcel();

		// Set document properties
		$objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
									 ->setLastModifiedBy("Maarten Balliauw")
									 ->setTitle("Office 2007 XLSX Test Document")
									 ->setSubject("Office 2007 XLSX Test Document")
									 ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
									 ->setKeywords("office 2007 openxml php")
									 ->setCategory("Test result file");


		// Add some data
		$objPHPExcel->setActiveSheetIndex(0)
					->setCellValue('A1', 'Hello')
					->setCellValue('B2', 'world!')
					->setCellValue('C1', 'Hello')
					->setCellValue('D2', 'world!');

		// Miscellaneous glyphs, UTF-8
		$objPHPExcel->setActiveSheetIndex(0)
					->setCellValue('A4', 'Miscellaneous glyphs')
					->setCellValue('A5', 'éàèùâêîôûëïüÿäöüç');

		// Rename worksheet
		$objPHPExcel->getActiveSheet()->setTitle('Simple');


		// Set active sheet index to the first sheet, so Excel opens this as the first sheet
		$objPHPExcel->setActiveSheetIndex(0);


		// Redirect output to a client’s web browser (Excel5)
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="01simple.xls"');
		header('Cache-Control: max-age=0');
		// If you're serving to IE 9, then the following may be needed
		header('Cache-Control: max-age=1');

		// If you're serving to IE over SSL, then the following may be needed
		header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
		header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
		header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
		header ('Pragma: public'); // HTTP/1.0

		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		$objWriter->save('php://output');
		exit;


	}

}
