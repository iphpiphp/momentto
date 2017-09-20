<?
class Movie_model extends MY_Model {
	function __construct(){
        parent::__construct();
    }

	function maker_list($input){
		if(is_numeric($input["page"]) == false) $input["page"] = 1;
		if($input["page"] < 0) $input["page"] = 1;

		$limit_ofset = ($input["page"]-1) * $input["pagelist"];

		$this->db->select('SQL_CALC_FOUND_ROWS T1.*,
			T1.status, P.name as productName, O.memberName, O.memberEmail

		',false);
		$this->db->from($input['table']." as T1");
		$this->db->join("tb_order as O","O.id = T1.orderId","inner");
		$this->db->join("tb_order_item as I","I.id = T1.orderItemId","inner");
		$this->db->join("tb_product as P","P.id = I.productId","inner");


		$this->db->where("O.status !=", "00");

		if(isset($input["sfl"]) && $input["sfl"] && $input["stx"] && $input["stx"]){
			if($input["sfl"] == "productName") $this->db->like("P.productName", $input["stx"]);
			if($input["sfl"] == "memberName") $this->db->like("O.memberName", $input["stx"]);
			if($input["sfl"] == "movieMakerId") $this->db->like("T1.id", $input["stx"]);
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

	function store_list($input){
		if(is_numeric($input["page"]) == false) $input["page"] = 1;
		if($input["page"] < 0) $input["page"] = 1;
		
		$limit_ofset = ($input["page"]-1) * $input["pagelist"];
		
		$this->db->select('SQL_CALC_FOUND_ROWS T1.*, 		',false);
		$this->db->from($input['table']." as T1");
		//$this->db->join("tb_order as O","O.id = T1.orderId","inner");
		//$this->db->join("tb_order_item as I","I.id = T1.orderItemId","inner");
		//$this->db->join("tb_product as P","P.id = I.productId","inner");
		
		if(isset($input["sfl"]) && $input["sfl"] && $input["stx"] && $input["stx"]){			
			if($input["sfl"] == "productName") $this->db->like("P.productName", $input["stx"]);
			if($input["sfl"] == "memberName") $this->db->like("T1.memberName", $input["stx"]);

			if($input["sfl"] == "movieMakerId") $this->db->like("T1.movieMakerId", $input["stx"]);
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
