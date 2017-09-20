<?
class Order_model extends CI_Model {
	function __construct(){
        parent::__construct();
    }
	function product($product_id) {
		foreach ($product_id as $key => $id) {
			$this -> db -> select('tb_product.*');
			$this -> db -> from('tb_product');
			$this -> db -> where('tb_product.id', $id);			
			$this -> db -> limit(1);
			$result[$key]['product'] = $this -> db -> get() -> row_array();			
			$genres = $this->genres($id);
			$result[$key]['product']['genres'] = $genres['genres_name'];
			$keywords = $this->keywords($id);
			$result[$key]['product']['keywords'] = $keywords['keywords_name'];
		}
		return $result;
	}
	
	function genres($product_id){
		$this -> db -> from('tb_product_genre');
		$this -> db -> join('tb_genre','tb_genre.id = tb_product_genre.genreId','inner');
		$this -> db -> where('productId', $product_id);
		$result['genres'] = $this -> db -> get() -> result_array();
		$genres_name = false;		
		foreach($result['genres'] as $key => $val){
			
			$genres_name .=  "/".$val['name'];				
		}
		if($genres_name) $genres_name = substr($genres_name,1); //앞자리 1개 자름 /
		$result['genres_name'] = $genres_name;
		return $result;
	}
	
	function keywords($product_id){
		$this -> db -> from('tb_product_keyword');
		$this -> db -> join('tb_keyword','tb_keyword.id = tb_product_keyword.keywordId','inner');
		$this -> db -> where('productId', $product_id);
		$result['keywords'] = $this -> db -> get() -> result_array();
		$keywords_name = false;
		foreach($result['keywords'] as $key => $val){
			$keywords_name .=  "/".$val['name'];				
		}
		if($keywords_name) $keywords_name = substr($keywords_name,1); //앞자리 1개 자름 /
		$result['keywords_name'] = $keywords_name; // 1,2,3,4 형태로 담기
		return $result;
	}

	function orderitems($order_id){
		$this->db->from('tb_order_item');
		$this -> db -> where('orderId', $order_id);
		$result = $this -> db -> get() -> row_array();
		return $result;
	}

	function page_list_m($page=1,$pagelist = 20){
		if(is_numeric($page) == false) $page = 1;
		if($page < 0) $page = 1; 
		$limit_ofset = ($page-1) * $pagelist;
		
		$this->db->select('SQL_CALC_FOUND_ROWS *',false);
		$this->db->from('tb_order');
		$this->db->order_by('id','desc');
		$this->db->limit($pagelist,$limit_ofset);

		$result['page_list_m']= $this->db->get()->result_array();
		$result['total_cnt'] =$this->db->query("SELECT FOUND_ROWS() AS total_cnt;")->row()->total_cnt;
		return $result;
		
	}
		
	function order_list($page=1,$pagelist = 20){
		if(is_numeric($page) == false) $page = 1;
		if($page < 0) $page = 1; 
		$limit_ofset = ($page-1) * $pagelist;
		
		$this->db->select('SQL_CALC_FOUND_ROWS tb_order.*, 
							tb_order_item.name as iname, 
							(select count(*) from tb_order_item where orderId= tb_order.id) as order_cnt,
							(select payMethod from tb_order_payment where orderId= tb_order.id) as payMethod,
							(select confirmDatetime from tb_order_payment where orderId= tb_order.id) as confirmDatetime
							',false);
		$this->db->from('tb_order');
		$this->db->join('tb_order_item','tb_order_item.orderId = tb_order.id','inner');
		$this->db->group_by('tb_order.id');
		$this->db->order_by('tb_order.id','desc');
		$this->db->limit($pagelist,$limit_ofset);

		$result['page_list_m']= $this->db->get()->result_array();
		$result['total_cnt'] =$this->db->query("SELECT FOUND_ROWS() AS total_cnt;")->row()->total_cnt;
		return $result;
		
	}
	function order_nbank_list($page=1,$pagelist = 20){
		if(is_numeric($page) == false) $page = 1;
		if($page < 0) $page = 1; 
		$limit_ofset = ($page-1) * $pagelist;
		
		$this->db->select('SQL_CALC_FOUND_ROWS tb_order.*, 
							tb_order_item.name as iname, 
							(select count(*) from tb_order_item where orderId= tb_order.id) as order_cnt,
							(select payMethod from tb_order_payment where orderId= tb_order.id) as payMethod,
							(select confirmDatetime from tb_order_payment where orderId= tb_order.id) as confirmDatetime
							',false);
		$this->db->from('tb_order');
		$this->db->join('tb_order_item','tb_order_item.orderId = tb_order.id','inner');
		$this->db->where('tb_order.status =','01');
		$this->db->group_by('tb_order.id');
		$this->db->order_by('tb_order.id','desc');
		$this->db->limit($pagelist,$limit_ofset);

		$result['page_list_m']= $this->db->get()->result_array();
		$result['total_cnt'] =$this->db->query("SELECT FOUND_ROWS() AS total_cnt;")->row()->total_cnt;
		return $result;
		
	}
	
	/**
	 * 무통장 입금 처리
	 */
	function nts_nb_cfr($id,$i){
		$order_items = $this->orderitems($id);
		
		//C id 
		$data = array(
					'id'=>'C'.$id.$i, 
					'orderId'=>$id, 
					'orderItemId'=>$order_items['id'], 
					'memberId'=>null,
					'fileName'=>null, 
					'modifyDatetime'=>null, 
					'storeDatetime'=>null, 
					'completeDatetime'=>null, 
					'isComplete'=>0, 
					'extendMemberId'=>null, 
					'extendMessage'=>null, 
					'createDatetime'=>date("Y-m-d H:i:s"), 
					'isBgmChange'=>null, 
					'startDatetime'=>null, 
					'renderServerName'=>null, 
					'renderStartDate'=>null
		);
	
		//무비메이크 생성
		$this->db->insert('tb_movie_maker',$data); 
		
		//페이 업데이트
		$data_pay = array('isSuccess'=>1,'confirmDatetime'=>date("YmdHis"));
		$this->db->where('orderId', $id);				
		$this->db->update('tb_order_payment', $data_pay);
		 
		//주문 정보 준비 상태로 업데이트
		$data_order = array('status'=>'02','beforeStatus'=>'02');
		$this->db->where('id', $id);
		$this->db->update('tb_order', $data_order);
		
		return true;

	}
	
	
	

}
?>