<?
class Test_model extends CI_Model {
	function __construct(){
        parent::__construct();
    }

	function page_list_m($page=1,$pagelist = 20){
		if(is_numeric($page) == false) $page = 1;
		if($page < 0) $page = 1; 
		$limit_ofset = ($page-1) * $pagelist;
		
		$this->db->select('SQL_CALC_FOUND_ROWS *',false);
		$this->db->from('test');
		$this->db->limit($pagelist,$limit_ofset);

		$result['page_list_m']= $this->db->get()->result_array();
		$result['total_cnt'] =$this->db->query("SELECT FOUND_ROWS() AS total_cnt;")->row()->total_cnt;
		return $result;
		
	}
	
	function test_m($item,$value){
		$this->db->select("*");
		$this->db->from("tb_product");
		$this->db->or_where($item,$value);
		$this->db->like($item,$value,'both');
		$this->db->order_by("id","desc");
		$result = $this->db->get()->result_array();
		print_r($result);
		
	}

}
?>