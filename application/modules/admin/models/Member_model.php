<?
class Member_model extends MY_Model {
	function __construct(){
        parent::__construct();
    }

	function page_list_m($page=1,$pagelist = 20)
	{
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

	function member_list($input)
	{
		if(is_numeric($input["page"]) == false) $input["page"] = 1;
		if($input["page"] < 0) $input["page"] = 1;
		
		$limit_ofset = ($input["page"]-1) * $input["pagelist"];
		
		$this->db->select('SQL_CALC_FOUND_ROWS T1.* ',false);
		$this->db->from($input['table']." as T1");
		
		if(isset($input["sfl"]) && $input["sfl"] && $input["stx"] && $input["stx"]){			
			if($input["sfl"] == "memberEmail") $this->db->like("T1.email", $input["stx"]);
			if($input["sfl"] == "memberName") $this->db->like("T1.name", $input["stx"]);
			if($input["sfl"] == "mobile") $this->db->like("T1.mobile", $input["stx"]);

		}
		
		if(isset($input["sdate"]) && $input["sdate"]) $this->db->where("T1.createDatetime >=", $input["sdate"]);
		if(isset($input["edate"]) && $input["edate"]) $this->db->where("T1.createDatetime <=", date('Y-m-d', strtotime($input["edate"].'+1 day')));
		
		//if(!isset($input["groupby"])) $this->db->group_by("cdate");
		//if(!isset($input["groupby"])) $this->db->group_by("T1.memberId");
		$this->db->order_by("T1.createDatetime","desc");
		
		$this->db->limit($input["pagelist"],$limit_ofset);

		$result['page_list_m']= $this->db->get()->result_array();
		$result['total_cnt'] =$this->db->query("SELECT FOUND_ROWS() AS total_cnt;")->row()->total_cnt;
		return $result;
	}
	
	function mycoupon($input)
	{
		
		if(is_numeric($input["page"]) == false) $input["page"] = 1;
		if($input["page"] < 0) $input["page"] = 1;
		
		$limit_ofset = ($input["page"]-1) * $input["pagelist"];
		//SELECT * FROM tb_member_coupon WHERE memberId = 2971
		$this->db->select('SQL_CALC_FOUND_ROWS T1.* ',false);
		$this->db->from($input['table']." as T1");
		$this->db->where("T1.memberId",$input['memberId']);
		$this->db->order_by("T1.createDatetime","desc");
		
		$this->db->limit($input["pagelist"],$limit_ofset);

		$result['page_list_m']= $this->db->get()->result_array();
		$result['total_cnt'] =$this->db->query("SELECT FOUND_ROWS() AS total_cnt;")->row()->total_cnt;
		
		//print_r($result);
		return $result;
		
		
	}
	

}
