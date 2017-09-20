<?
class Conf_model extends MY_Model {
	function __construct(){
        parent::__construct();
    }
	
	function mobile_keyword($input)
	{
		if(is_numeric($input["page"]) == false) $input["page"] = 1;
		if($input["page"] < 0) $input["page"] = 1;
		
		$limit_ofset = ($input["page"]-1) * $input["pagelist"];
		
		//$this->db->select('SQL_CALC_FOUND_ROWS T1.*, C.name as cate_name',false);
		$this->db->from($input['table']." as T1");
		//$this->db->join('tb_category as C','T1.categoryid = C.id','inner');
		//$this->db->where("T1.isDisplay ", true);
		
		
		if(isset($input["sfl"]) && $input["sfl"] && $input["stx"] && $input["stx"]){			
			if($input["sfl"] == "productName") $this->db->like("T1.productName", $input["stx"]);
		}
		$this->db->order_by("T1.seq","ASC");
		$this->db->limit($input["pagelist"],$limit_ofset);

		$result['page_list_m']= $this->db->get()->result_array();
		$result['total_cnt'] =$this->db->query("SELECT FOUND_ROWS() AS total_cnt;")->row()->total_cnt;

		return $result;
	}
	
	function faq_conf_list($input)
	{
		if(is_numeric($input["page"]) == false) $input["page"] = 1;
		if($input["page"] < 0) $input["page"] = 1;

		$limit_ofset = ($input["page"]-1) * $input["pagelist"];

		//$this->db->select('SQL_CALC_FOUND_ROWS T1.*, C.name as cate_name',false);
		$this->db->from($input['table']." as T1");
		//$this->db->join('tb_category as C','T1.categoryid = C.id','inner');
		//$this->db->where("T1.isDisplay ", true);


		if(isset($input["sfl"]) && $input["sfl"] && $input["stx"] && $input["stx"]){
			if($input["sfl"] == "productName") $this->db->like("T1.productName", $input["stx"]);
		}
		$this->db->order_by("T1.seq","ASC");
		$this->db->limit($input["pagelist"],$limit_ofset);

		$result['page_list_m']= $this->db->get()->result_array();
		$result['total_cnt'] =$this->db->query("SELECT FOUND_ROWS() AS total_cnt;")->row()->total_cnt;

		return $result;
	}



}
