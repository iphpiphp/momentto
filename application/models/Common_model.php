<?
class Common_model extends CI_Model {
	function __construct(){
        parent::__construct();
    }
	
	function movie_cnt(){
		$query = "SELECT COUNT(*) as cnt FROM tb_movie_maker  WHERE renderStartDate IS NOT NULL LIMIT 1";
		
		return $this->db->query($query,false)->row()->cnt;
	}
	function init_status($mid,$email){
		$query = "
			SELECT 
				(SELECT COUNT(*) FROM zd_cart_lib WHERE  email = '".$email."') AS data1 								/*장바구니*/
				,(SELECT COUNT(*) FROM tb_order WHERE  memberId = '".$mid."' ) AS data2 								/*주문접수*/
				,(SELECT COUNT(*) FROM tb_order WHERE  memberId = '".$mid."' AND STATUS >= 2) AS data3 					/*결제완료접수*/
				,(SELECT COUNT(*) FROM tb_order WHERE  memberId = '".$mid."' AND STATUS >= 3 AND STATUS <= 7) AS data4 	/*무비진행중*/
				,(SELECT COUNT(*) FROM tb_order WHERE  memberId = '".$mid."' AND STATUS >= 10) AS data5 				/*무비완료*/
				,(SELECT COUNT(*) FROM tb_order WHERE  memberId = '".$mid."' AND STATUS = '08') AS data6 				/*취소환불*/
		";
		$sql = $this->db->query($query,false);
		return $sql->row_array();
		
	}
	
	
	function cate_list($cate=null)
	{
		$this->db->from("tb_category");
		if($cate) $this->db->where('id',$cate);
		return $this->db->get()->result_array();
		
	}

	function product_info($product_id){
		$this->db->select(' *, (select name from tb_category where id = P.categoryId) as cateName',false);
		$this->db->from('tb_product as P');
		$this->db->where('P.id',$product_id);
		return $this->db->get()->row_array();
	}

	function main_product_list($location, $page=1,$pagelist = 20){
		if(is_numeric($page) == false) $page = 1;
		if($page < 0) $page = 1; 
		$limit_ofset = ($page-1) * $pagelist;
		
		$this->db->select('SQL_CALC_FOUND_ROWS *',false);
		$this->db->from('tb_product');
		$this->db->where('isDisplay','1');
		//$this->db->order_by('id','desc');
		$this->db->order_by('id','RANDOM');
		$this->db->limit($pagelist,$limit_ofset);

		$result['product_list']= $this->db->get()->result_array();
		$result['total_cnt'] =$this->db->query("SELECT FOUND_ROWS() AS total_cnt;")->row()->total_cnt;
		return $result;
		
	}
	
	function product_list($location, $page=1,$pagelist = 20, $cate_id, $keyword){
		if(is_numeric($page) == false) $page = 1;
		if($page < 0) $page = 1; 
		$limit_ofset = ($page-1) * $pagelist;
		if($cate_id == "all") $cate_id = null;
		
		$this->db->select('SQL_CALC_FOUND_ROWS P.*',false);
		$this->db->from('tb_product AS P');
		$this->db->join('tb_product_keyword AS PK','P.id = PK.productId','inner');
		$this->db->join('tb_keyword AS K','PK.keywordId = K.id','inner');
		
		$this->db->where('P.isDisplay','1');
		$this->db->where('P.id !=','119');
		
		
		if($keyword) $this->db->like('K.name',$keyword);
		if($keyword) $this->db->or_like('P.name',$keyword);

		if($cate_id) $this->db->where('P.categoryId',$cate_id); 
		//$this->db->order_by('id','desc');
		//$this->db->order_by('id','RANDOM');
		//$this->db->order_by('id','desc');
		$this->db->order_by('P.sort','desc');
		$this->db->group_by('P.id');		
		$this->db->limit($pagelist,$limit_ofset);

		$result['product_list'] = $this->db->get()->result_array();
		$result['total_cnt'] =$this->db->query("SELECT FOUND_ROWS() AS total_cnt;")->row()->total_cnt;
		return $result;
		
	}
	
	function product_keywords($id){
		$this->db->select('K.name');
		$this->db->from('tb_product_keyword as PK');
		$this->db->join('tb_keyword as K','PK.keywordId=K.id','inner');
		$this->db->where('PK.productId',$id);
		return $this->db->get()->result_array();
	}

	function product_genre($id){
		$this->db->select('K.name');
		$this->db->from('tb_product_genre as PK');
		$this->db->join('tb_genre as K','PK.genreId=K.id','inner');
		$this->db->where('PK.productId',$id);
		return $this->db->get()->result_array();
	}

	function main_product_list2($location, $page=1,$pagelist = 20){
		if(is_numeric($page) == false) $page = 1;
		if($page < 0) $page = 1; 
		$limit_ofset = ($page-1) * $pagelist;
		
		
		$this->db->from('zd_main_product_list');
		$this->db->join('tb_product','tb_product.id = zd_main_product_list.productId','inner');
		$this->db->where('tb_product.isDisplay','1');
		$this->db->order_by('zd_main_product_list.seq','asc');
		$this->db->limit($pagelist,$limit_ofset);
		
		$result['product_list2']= $this->db->get()->result_array();		
		return $result;
		
	}
	
	function main_list($cate, $keyword){
		
		$this->db->from('tb_product');
		
		if($cate =="all") $cate = null;
		if($cate)	$this->db->where('categoryId',$cate);
		if($keyword) {
			$this->db->like('keyword',$keyword);
			
		}
		
		$this->db->order_by('id','desc');
		//$this->db->limit(12);
		$result['product_list']= $this->db->get()->result_array();		
		return $result;
	}
	
	function main_product_keyword($location){
		$this->db->from('zd_main_product_keyword');
		$this->db->order_by('seq','asc');
		$result['keyword_list'] = $this->db->get()->result_array();
		return $result;	
	}
	
	function main_bnr_list($location){
		$this->db->from('zd_main_bnr');
		$this->db->order_by('zmb_seq','asc');
		$result= $this->db->get()->result_array();
		return $result;
		
	}
	
	 //단일 테이블 단일 로우 검색
    function select_one($table,$data){
        $this->db->from($table);
        $this->db->where($data);
        $result['rows']= $this->db->get()->row_array();
        return $result;
    }
	
	function select_get($table, $data = false, $orderby = false, $limit = false){
        $this->db->from($table);
        if($data) $this->db->where($data);
		if($orderby) $this->db->order_by(key($orderby), $orderby[key($orderby)]);
		if($limit) $this->db->limit($limit);
        return $this->db->get();
    }
    
    //인서트
    function insert($table,$data){
        $result['status'] =  $this->db->insert($table, $data);		
        $result['insert_id'] = $this->db->insert_id();
        return $result;
    }

	//test - 서버용인서트
    function test_insert($table,$data){
    	$TEST = $this->load->database("test", TRUE);//test 고정    	
        $result['status'] =  $TEST->insert($table, $data);
        $result['insert_id'] = $TEST->insert_id();
        return $result;
    }
    
    //삭제
    function delete($table,$data){		
        return $this->db->delete($table, $data); 
    }
    
    function update_plus($table, $field, $id, $id_name){
        $this->db->set($field, $field ."+1", FALSE);		
        $this->db->where($id_name, $id);		
        $this->db->update($table);
    }
    
    function update($table, $field, $data, $id){
        $this->db->where($field, $id);
        $this->db->update($table, $data); 
    }
	
	function login_chk($email, $pass){		
		$this->db->where('email',$email);
		$this->db->where('password',$pass);		
		$query = $this->db->get('tb_member');
		
		if ($query->num_rows() == 1) return $query->row();
		return NULL;		
	}
	function guest_login_chk($pass, $oid){
		
		$this->db->from('tb_order');
		$this->db->where('id',$oid);
		$this->db->where('memberPassword',$pass);
		$this->db->limit(1);
		$sql  = $this->db->get();
		
		if ($sql->num_rows() == 1) {
			return $sql->row();
		}
		return NULL;
	}
	
	function cart_list($product_id){
		$this->db->from('tb_product');
		$this->db->where_in("id",$product_id);
		$this->db->order_by('id','desc');
		$result['cart_list']= $this->db->get()->result_array();
		return $result;
	}

	function cart_list2($session_id, $email){
		
		//로그인 하면, 비 로그인으로 저장해둔 세션을 전부 더한다
		if($email) {
			$table = 'zd_cart_lib';
			$data = array('email'=>$email);
			$this->db->where('ciss_id',$session_id);
			$this->db->update($table,$data);
		}
		
		$this->db->from('zd_cart_lib');
		$this->db->join('tb_product','tb_product.id = zd_cart_lib.product_id','inner');
		
		
		if($email) {
			$this->db->where("zd_cart_lib.email",$email);
		}else{
			$this->db->where("zd_cart_lib.ciss_id",$session_id);
		}
		$result['cart_list']= $this->db->get()->result_array();
		return $result;
	}

	// by ykshin : 2015.09.22
	function auth_chk($email, $key){
		$data=array(
				'is_auth' => 1
		);
		$this->db->where('auth_key', $key);
		$this->db->where('email', $email);
		$this->db->update('tb_member', $data);
		
		if($this->db->affected_rows()>0) {
			return true;
		}
		
		return false;
	}
	
	function user_exist($email) {
        $this->db->where('email', $email);
        $query = $this->db->get('tb_member');
        
        if($query->num_rows()>=1) {
            return true;
        }
        return false;
    }
	
	function new_user_chk($email) {
		$this->db->where('email',$email);
		$query = $this->db->get('tb_member');
		
		if($query->num_rows()>=1) {
			$row=$query->result();
			if($row!=null && $row[0]->isNew==1) {
				return true;
			}		
		}
		return false;
	}
	
	function check_denied($email) {
		$this->db->where('userId', $email);
		$query=$this->db->get('tb_member_stmp');
		if($query->num_rows()>=1) {
			return true;
		}
		return false;
	}
	
	
	//가지고있는 포인트 체크
	function use_point($email){
		$this->db->where('email',$email);		
		$query = $this->db->get('tb_member');
		
		if ($query->num_rows() == 1) {
			$memberId = $query->row()->id;
			
			$this->db->select_sum('money');
			$this->db->where('memberId',$memberId);
			$query2 = $this->db->get('tb_member_saved_money');				
			if ($query2->num_rows() == 1) return $query2->row()->money;
		}else{
			return 0;
		}		
	}
	
	function exchange($type){
		$this->db->where('type',$type);		
		$query = $this->db->get('zd_money');
		
		
		if ($query->num_rows() >= 1) {
			
			return $query->row()->money;			
			
		}else{
			return 1;
		}
	}
	
	//sns용 회원 정보 체크
	function sns_user_chk($email){		
		$TEST = $this->load->database(SNS_DB, TRUE);//test 고정
		$TEST->where('email',$email);
						
		$query = $TEST->get('tb_member');
		if ($query->num_rows() == 1) {
			$result['status'] = true; 
			$result['data'] = $query->row();
			
		}else{
			$result['status'] = false;
		}
		
		$result['num_rows'] = $query->num_rows();
		
		return $result;
	}
	
	//sns용 회원 정보
	function sns_login_chk($email){
		$TEST = $this->load->database(SNS_DB, TRUE);//test 고정
		$TEST->where('email',$email);
		$TEST->where('isExit',false);				
		$query = $TEST->get('tb_member');
		
		if ($query->num_rows() == 1) return $query->row();
		return NULL;
	}
	
	//
	function sns_token($email){
		$TEST = $this->load->database(SNS_DB, TRUE);//test 고정
		$data = array('link_token'=>'1');
		$TEST->where('email', $email);
       	$TEST->update('tb_member', $data); 
	}
	
	
	//test	
	function test_sns_user_chk($email){		
		$TEST = $this->load->database("test", TRUE);//test 고정
		$TEST->where('email',$email);
						
		$query = $TEST->get('tb_member');
		if ($query->num_rows() == 1) {
			$result['status'] = true; 
			$result['data'] = $query->row();
			
		}else{
			$result['status'] = false;
		}
		
		$result['num_rows'] = $query->num_rows();
		
		return $result;
	}
	
	//test sns용 회원 정보
	function test_sns_login_chk($email){
		$TEST = $this->load->database("test", TRUE);//test 고정
		$TEST->where('email',$email);
		$TEST->where('isExit',false);
		$query = $TEST->get('tb_member');
		
		if ($query->num_rows() == 1) return $query->row();
		return NULL;
	}
	
	//test - 
	function test_sns_token($email){
		$TEST = $this->load->database("test", TRUE);//test 고정
		$data = array('link_token'=>'1');
		$TEST->where('email', $email);
       	$TEST->update('tb_member', $data); 
	}

	function find_member($input){
		if(is_numeric($input["page"]) == false) $input["page"] = 1;
		if($input["page"] < 0) $input["page"] = 1;

		$limit_ofset = ($input["page"]-1) * $input["pagelist"];
		$table = "tb_member";

		$this->db->select('SQL_CALC_FOUND_ROWS BP.*',false);
		$this->db->from($table." as BP");

		if(isset($input["sfl"]) && $input["sfl"] && $input["stx"] && $input["stx"]){
			$this->db->like($input["sfl"], $input["stx"]);
		}

		//if(isset($input["sdate"]) && $input["sdate"]) $this->db->where("BP.createDatetime >=", $input["sdate"]);
		//if(isset($input["edate"]) && $input["edate"]) $this->db->where("BP.createDatetime <=", $input["edate"]);

		$this->db->order_by("BP.id","desc");

		$this->db->limit($input["pagelist"],$limit_ofset);

		$result['page_list_m']= $this->db->get()->result_array();
		$result['total_cnt'] =$this->db->query("SELECT FOUND_ROWS() AS total_cnt;")->row()->total_cnt;
		return $result;
	}


	
}//end
