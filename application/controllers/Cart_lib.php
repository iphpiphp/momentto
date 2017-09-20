<?php

class Cart_lib extends CI_Controller {
    function __construct() {
        parent::__construct();
 		
		$this->load->model('common_model');
		
        // Cart Lib load        
        $this->load->library('cart');
        $this->load->helper('url');
        $this->load->helper('form');
	$this->load->helper('alert');
		$this->load->helper('common');
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
     
    function index() {
    	$location = $this->session->userdata('location');    	
        $this->load->view($location.'/cart/cart_detail_v');
		
		
    }
	
	function test(){
		echo "<br><br><br>";
		print_r($this->cart->contents());
	}
	
	/**
	 * 카트에서 1개 삭제
	 * rowid 를 기준으로 삭제한다
	 */
	function one_del($location){
		$cart_data = array();
        $idx = $this->uri->segment(3);
		
		//$arr = $this->uri->segment(4);
		//$rowid= "3c59dc048e8850243be8079a5c74d079";
		//$arr = 0;
		
		//$cart_data = array('qty' => 0, 'rowid' => $rowid);
        //$this->cart->update($cart_data);
        
        $cart_data = array('idx'=>$idx);
        $this->common_model->delete("zd_cart_lib",$cart_data);
		//redirect('/cart_lib/lists');
		$this->_go_cart();
	}
	
	
	
	
	/**
	 *카트 리스트
	 *   세션용 - 위시용 호환 됨
	 */
	function lists($location){
		//회원이상이면 위시리스트
		$data = array();
		$db_data = array();
		
		
			
		if($this->session->userdata['auth_lv']>=4){
			$session_id = $_COOKIE['ci_session'];
			$email = $this->session->userdata['email'];
			$db_data = $this->common_model->cart_list2($session_id, $email);
			
		}else{
			$session_id = $_COOKIE['ci_session'];
			$email = 0;
			$db_data = $this->common_model->cart_list2($session_id, $email);	
		}
		
		//rowid 맵핑
		/*		
		if($db_data){
			foreach($db_data['cart_list'] as $key => $cart){
				foreach($this->cart->contents() as $items){
					if($cart['id']== $items['id']) {
						$db_data['cart_list'][$key]['rowid'] = $items['rowid'];
						$db_data['cart_list'][$key]['qty'] = $items['qty'];
					}
				}
			}
		}
		 * 
		 */
		
		$data['cart_list'] = $db_data['cart_list'];
		
		
		//print_r($data['cart_list']);
		$this->load->view($location.'/cart/cart_list_v',$data);
		
	}
	
	//단일 상품 카트에 담기
	function cart_one_add($location){
		
		$product_id = $this->input->get('product_id',true);		
		$session_id = $_COOKIE['ci_session'];
		$email = $this->session->userdata['email'];
		$date = date("Y-m-d H:i:s");
		
		
		$cart_data = array('ciss_id'=>$session_id,'email'=>$email,'product_id'=>$product_id,'creatdatetime'=>$date);
		$this->common_model->insert('zd_cart_lib',$cart_data);
		alert('상품이 추가 되었습니다.');
	}
	
	//링크로 단일 상품 추가
	function link_one_add($location){
		$this->cart->destroy(); //일단 지우고
		$cart_data = array(
               'id'      => $this->input->get('product_id',true),
               'qty'     => 1,
               'price'   => 0,
               'name'    => '0',
               'img' =>''
            );
			
        $this->cart->insert($cart_data);
		redirect(BASE_URL.'/order/form/');
		//$cnt = count($this->cart->contents());
	}
	
	//카트에서 여러상품 담기
	function mut_add($location){
		$this->cart->destroy(); //일단 지우고
		
		$chk_id = $this->input->post('chk_id',true);		
		$cart_data = array();
		
		//alert(count($chk_id));
		
		if(count($chk_id)>=10) {
			alert('10개 이상 주문 하실 수 없습니다.');
			exit;
		}
		
		if(count($chk_id)>=1){
			$i=0;
			foreach ($chk_id as $value) {			
				$cart_data[$i]['id'] = $value;
				$cart_data[$i]['qty'] = 1;
				$cart_data[$i]['price'] = 0;
				$cart_data[$i]['name'] = 0;
				$i++;
			}
			/*			
			echo "<pre>";
			print_r($cart_data);
			echo "</pre>";
			 * 
			 */
			$this->cart->insert($cart_data);
		
	        //$this->cart->insert($cart_data);
	        //print_r($this->cart->contents());
			
		}else{
			alert('선택 하신 상품이 없습니다.');
		}
		
		redirect(BASE_URL.'/order/form/');
	}
	
	     
    // Cart Add
    function add() {
        $cart_data = array(
			'id'        => $this->input->post('id',true),
			'qty'       => $this->input->post('qty',true),
			'price'     => $this->input->post('price',true),
			'name'      => $this->input->post('name',true),
			'options'   => array(
			'Size' => $this->input->post('size'),
			'Color' => $this->input->post('color')
            )
        );
         
        $this->cart->insert($cart_data);
        $this->_go_cart();
    }
 
    // Cart Update
    function update() {
        $cart_data = array();
        $qty = $this->input->post('qty');
        $rowid = $this->input->post('rowid');
        $del = $this->input->post('del');
         
        for($i=0; $i < count($del); $i++) {
            $qty[$del[$i]] = 0;
        }
         
        for($i=0; $i < count($rowid); $i++) {
            $cart_data[$i] = array('qty' => $qty[$i], 'rowid' => $rowid[$i]);
        }
         
        $this->cart->update($cart_data);
        $this->_go_cart();
    }
     
    // Cart Destory
    function destroy($location) {
        $this->cart->destroy();
        $this->_go_cart();
    }
     
    // Display Cart
    function _go_cart($location) {
        redirect(BASE_URL.'/cart_lib/lists');
    }
}
