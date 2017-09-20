<?
class Customer_model extends MY_Model {
	function __construct(){
        parent::__construct();
    }

	function notice_list($page=1, $pagelist = 20,$type,$stx){		
		if(is_numeric($page) == false) $page = 1;
		if($page < 0) $page = 1; 
		$limit_ofset = ($page-1) * $pagelist;
		
		$this->db->select('SQL_CALC_FOUND_ROWS *',false);
		$this->db->from('tb_notice');
		if($type) $this->db->where('type',$stx);
		if($stx){
			//검색 텍스트가 있으면
			$this->db->like('title', $stx, 'both'); // % text $
			$this->db->or_like('content', $stx, 'both');
		}
		
		$this->db->limit($pagelist,$limit_ofset);

		$result['page_list_m']= $this->db->get()->result_array();
		$result['total_cnt'] =$this->db->query("SELECT FOUND_ROWS() AS total_cnt;")->row()->total_cnt;
		return $result;
		
		
		
	}
	
	function notice_view($idx,$sfl,$stx){
		$this->db->select('SQL_CALC_FOUND_ROWS *',false);
		$this->db->from('tb_notice');
		$this->db->where('id',$idx);
		
		
		$this->db->limit(1);
		$result['page_view_m']= $this->db->get()->row_array();		
		return $result;
	}
	
	function faq_list($page=1, $pagelist = 20,$type,$stx){		
		if(is_numeric($page) == false) $page = 1;
		if($page < 0) $page = 1; 
		$limit_ofset = ($page-1) * $pagelist;
		
		$this->db->select('SQL_CALC_FOUND_ROWS *',false);
		$this->db->from('tb_vfaq');
		if($type) $this->db->where('type',$stx);
		if($stx){
			//검색 텍스트가 있으면
			$this->db->like('title', $stx, 'both'); // % text $
			$this->db->or_like('content', $stx, 'both');
		}

		//$data = array('84', '78', '76', '56', '50', '79', '12', '19', '81');
		//$this->db->where_in('id', $data);


		$this->db->order_by('seq','asc');
		$this->db->limit($pagelist,$limit_ofset);

		$result['page_list_m']= $this->db->get()->result_array();
		$result['total_cnt'] =$this->db->query("SELECT FOUND_ROWS() AS total_cnt;")->row()->total_cnt;
		return $result;
		
	}
	
	function guest_movie_list($pass, $oid){
		 $query = "SELECT  SQL_CALC_FOUND_ROWS
		  		*
			FROM (
				SELECT 
					M1.createDatetime, M1.orderId, M1.id, startDatetime, tb_order.price,  tb_order.beforeStatus, tb_order.status,
					tb_order_item.imageMfile AS imagefile, tb_order_item.name, tb_order_item.id AS item_id, tb_movie_store.isDelete, 
					tb_movie_store.fileName AS storeFile, tb_product.id as pid, tb_movie_store.filePath,
					M1.isComplete

				
				FROM `tb_movie_maker` as M1
				INNER JOIN tb_order ON tb_order.id = M1.orderId
				INNER JOIN tb_order_item ON tb_order_item.id = M1.orderItemId
				LEFT JOIN tb_movie_store ON tb_movie_store.movieMakerId = M1.id
				
				INNER JOIN tb_product ON tb_order_item.productId = tb_product.id
				
				WHERE `tb_order`.`id` = '".$this->db->escape_str($oid)."' AND tb_order.status != '08' AND memberPassword = '".$this->db->escape_str($pass)."'
							
				
			) AS A
			 
			 ORDER BY A.orderId DESC
			 ";
		$result = $this->db->query($query,false)->result_array();
		return $result;
	}
	

}
