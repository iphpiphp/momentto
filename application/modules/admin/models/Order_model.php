<?
class Order_model extends MY_Model {
	function __construct(){
        parent::__construct();
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
		
	function order_list($input)
	{
		if(is_numeric($input["page"]) == false) $input["page"] = 1;
		if($input["page"] < 0) $input["page"] = 1;
		
		$limit_ofset = ($input["page"]-1) * $input["pagelist"];
		
		$this->db->select('SQL_CALC_FOUND_ROWS T1.*
		, (SELECT NAME FROM tb_order_item AS I WHERE I.orderId = T1.id  LIMIT 1) AS productName
		',false);
		$this->db->from($input['table']." as T1");

		$this->db->where("T1.status >=","01");
		//$this->db->join("tb_member as M","T1.memberId = M.id","left");
		//$this->db->join("tb_product as P","T1.productId = P.id","left");
		
		if(isset($input["sfl"]) && $input["sfl"] && $input["stx"] && $input["stx"]){			
			if($input["sfl"] == "productName") $this->db->like("P.productName", $input["stx"]);
			if($input["sfl"] == "memberName") $this->db->like("T1.memberName", $input["stx"]);
			if($input["sfl"] == "memberEmail") $this->db->like("T1.memberEmail", $input["stx"]);
		}
		
		if(isset($input["guest"])) $this->db->where("T1.memberId IS NULL");
		if(isset($input["open_market"])) $this->db->where("T1.open_market IS NOT NULL");

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
	
	function refund_list($input)
	{
		if(is_numeric($input["page"]) == false) $input["page"] = 1;
		if($input["page"] < 0) $input["page"] = 1;
		
		$limit_ofset = ($input["page"]-1) * $input["pagelist"];
		
		$this->db->select('SQL_CALC_FOUND_ROWS T1.*
		, R.createDatetime as refundDate
		, (SELECT NAME FROM tb_order_item AS I WHERE I.orderId = T1.id  LIMIT 1) AS productName
		, PT.paymethod
		',false);
		$this->db->from($input['table']." as T1");
		$this->db->join("tb_order_payment as PT","T1.id = PT.orderId","inner");
		$this->db->join("tb_order_refund as R","T1.id = R.orderId","left");

		
		$this->db->where("T1.status =", "07");
		
		if(isset($input["sfl"]) && $input["sfl"] && $input["stx"] && $input["stx"]){			
			//if($input["sfl"] == "productName") $this->db->like("P.productName", $input["stx"]);
			if($input["sfl"] == "memberName") $this->db->like("T1.memberName", $input["stx"]);
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
	



}
