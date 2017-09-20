<?
class Product_model extends CI_Model {
	function __construct(){
        parent::__construct();
    }



	function product_view($product_id, $mid){
		//상품 조회
		$this->db->select('tb_product.*');		
		$this->db->from('tb_product');
		$this->db->join('tb_category', 'tb_product.categoryId = tb_category.id','inner');		
		$this->db->where('tb_product.id',$product_id);		
		$this->db->limit(1);
		$result['product'] = $this->db->get()->row_array();
		$product_review_list_total = 0; //리뷰 총 갯수
		
		//연관 검색
		$result['product_chain_list'] = array();
		if ($result['product']) {
			//연관검색
			$categoryId = $result['product']['categoryId'];
			$this->db->select('*');		
			$this->db->from('tb_product');
			$this->db->where('tb_product.categoryId',$categoryId);
			$this->db->where('tb_product.id !=',$product_id);
			$this->db->order_by('tb_product.id','desc');
			$result['product_chain_list'] = $this->db->get()->result_array();
			
			//해당 상품 리뷰
			$this->db->select('SQL_CALC_FOUND_ROWS R.*, P.name as product_name',false);
			$this->db->from('tb_product_review as R');
			$this->db->join('tb_product as P','R.productId = P.id','inner');
			$this->db->where('R.productId',$product_id);
			$this->db->order_by('R.createDatetime','desc');
			$result['product_review_list'] = $this->db->get()->result_array();
			
			//리뷰 토탈
			$result['product_review_list_total'] =  $this->db->query("SELECT FOUND_ROWS() AS total_cnt;")->row()->total_cnt;
		}
		
		//상품 이미지 조회				
		$this->db->from('tb_product_content');
		$this->db->where('productId',$product_id);
		$result['product_list']= $this->db->get()->result_array();
		
		
		
		//review_oner		
		$this->db->from('tb_order_item');
		$this->db->join('tb_order','tb_order_item.orderId = tb_order.id','inner');
		$this->db->where('tb_order_item.productId',$product_id);
		$this->db->where('tb_order.memberId',$mid);
		
		$result['review_oner']= $this->db->get()->num_rows();
		
		return $result;
	}
	
	//연관 상품 조회
	function chin_product_list($product_id){
		$this->db->select('*');		
		$this->db->from('tb_product');
		$this->db->where('productId !=',$product_id);
		$this->db->where('categoryId',$cate);
		
		
		$result['product_chain_list']= $this->db->get()->result_array();
		return $result;
	}
	
	//
	function product_orderby($cate){
		$this->db->select('id');		
		$this->db->from('tb_product');
		$this->db->where('isDisplay',1);
		
		if($cate == 'all'){
			$this->db->order_by('id','desc');
		}else{
			$this->db->where('categoryId',$cate);
			$this->db->order_by('id','desc');	
		}
		$id = $this->db->get()->row()->id;
		return $id;
		
		
	}
	
	//리뷰 상품 리스트
	function review_list($page=1,$pagelist = 30){
		//cate id
		if(is_numeric($page) == false) $page = 1;
		if($page < 0) $page = 1; 
		$limit_ofset = ($page-1) * $pagelist;
		
		$this->db->select('SQL_CALC_FOUND_ROWS tb_product_review.*, tb_product.name , tb_category.name as cate_name',false);
		$this->db->from('tb_product_review');
		$this->db->join('tb_product','tb_product_review.productId = tb_product.id','inner');
		$this->db->join('tb_category','tb_product.categoryId = tb_category.id','inner');
				
		$this->db->order_by("id", "desc");
		$this->db->limit($pagelist,$limit_ofset);

		$result['page_list_m']= $this->db->get()->result_array();
		$result['total_cnt'] =$this->db->query("SELECT FOUND_ROWS() AS total_cnt;")->row()->total_cnt;
		
		$this->db->from('tb_product_review_reply');
		if(count($result['page_list_m'])>0){
			foreach($result['page_list_m'] as $key => $val){
				$in[$key] = $val['id']; 
			}
			$this->db->where_in($in);
		}
		$this->db->order_by("idx", "desc");
		$result['reply']= $this->db->get()->result_array();
		//echo "<br><br><br><br>";
		//print_r($result['reply']);
		return $result;
	}
	
	//리뷰 상세	
	function review_info($review_id){
		//리뷰 아이디로 해당 정보를 완성
		$this->db->select("R.*, P.name as product_name, C.name as cate_name",false);
		$this->db->from('tb_product_review as R');
		$this->db->join('tb_product as P', 'R.productId = P.id','left');
		$this->db->join('tb_category as C', 'P.categoryId = C.id','left');
		$this->db->where('R.id',$review_id);
		$result['review_info']= $this->db->get()->row_array();
		
		
		//
		$this->db->select('SQL_CALC_FOUND_ROWS * ',false);
		$this->db->from('tb_product_review_reply');
		$this->db->where('reviewId',$review_id);
		$result['reply']= $this->db->get()->result_array();
		$result['reply_cnt'] =$this->db->query("SELECT FOUND_ROWS() AS total_cnt;")->row()->total_cnt;
		
		return $result;
		
		
	}
	
	
	//리얼전용 상품 리스트
	function contents_list($page=1,$pagelist = 30){
		$REAL = $this->load->database('real', TRUE);//리얼 DB 로드 고정
		
		//cate id
		if(is_numeric($page) == false) $page = 1;
		if($page < 0) $page = 1; 
		$limit_ofset = ($page-1) * $pagelist;
		
		$REAL->select('SQL_CALC_FOUND_ROWS tb_product_review.*, tb_product.name , tb_category.name as cate_name',false);
		$REAL->from('tb_product_review');
		$REAL->join('tb_product','tb_product_review.productId = tb_product.id','inner');
		$REAL->join('tb_category','tb_product.categoryId = tb_category.id','inner');
				
		$REAL->order_by("id", "desc");
		$REAL->limit($pagelist,$limit_ofset);

		$result['page_list_m']= $REAL->get()->result_array();
		$result['total_cnt'] =$REAL->query("SELECT FOUND_ROWS() AS total_cnt;")->row()->total_cnt;
		
		$REAL->from('tb_product_review_reply');
		if(count($result['page_list_m'])>0){
			foreach($result['page_list_m'] as $key => $val){
				$in[$key] = $val['id']; 
			}
			$REAL->where_in($in);
		}
		$REAL->order_by("idx", "desc");
		$result['reply']= $REAL->get()->result_array();
		//echo "<br><br><br><br>";
		//print_r($result['reply']);
		return $result;
	}
	
	//리얼 전용 상세	
	function content_info($review_id){
		$REAL = $this->load->database('real', TRUE);//리얼 DB 로드 고정
		//리뷰 아이디로 해당 정보를 완성
		$REAL->from('tb_product_review');
		$REAL->where('id',$review_id);
		$result['review_info']= $REAL->get()->row_array();

		//
		$REAL->select('SQL_CALC_FOUND_ROWS * ',false);
		$REAL->from('tb_product_review_reply');
		$REAL->where('reviewId',$review_id);
		$result['reply']= $REAL->get()->result_array();
		$result['reply_cnt'] = $REAL->query("SELECT FOUND_ROWS() AS total_cnt;")->row()->total_cnt;		
		return $result;
	}
	
	
	//무비메이커
	function movieMake($orderId,$orderItemId){
		//$orderId $orderItemId
		$this->db->select('*, tb_movie_maker.id as movieId, tb_movie_maker.fileName as movieFileName, tb_member.name as username , tb_member.email as email ',false);
		$this->db->from('tb_movie_maker');
		$this->db->join('tb_order_item','tb_order_item.id = tb_movie_maker.orderItemId','inner');
		$this->db->join('tb_member','tb_member.id = tb_movie_maker.memberId','left');
				
		$this->db->where('tb_order_item.id',$orderItemId);
		$result['movieMake'] = $this->db->get()->row_array();
		return $result;
		
	}

	//
	function movieMakeSample($productId)
	{

		$this->db->select('*', false);

		$this->db->from('tb_product as P');

		$this->db->where('P.id',$productId);

		$result['movieMake'] = $this->db->get()->row_array();

		return $result;

	}

	
	

}
?>
