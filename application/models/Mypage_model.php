<?
class Mypage_model extends CI_Model {
	function __construct(){
        parent::__construct();
    }
	
	function movie_list($page=1, $pagelist = 20, $user){		
		if(is_numeric($page) == false) $page = 1;
		if($page < 0) $page = 1; 
		$limit_ofset = ($page-1) * $pagelist;
		
		
		 $query = "SELECT  SQL_CALC_FOUND_ROWS   
		  		*
			FROM (
				SELECT 
					M1.createDatetime, M1.orderId, M1.id, startDatetime, tb_order.price,  tb_order.beforeStatus, tb_order.status, 
					tb_order_item.imageMfile AS imagefile, tb_order_item.name, tb_order_item.id AS item_id, tb_movie_store.isDelete, 
					tb_movie_store.fileName AS storeFile, tb_product.id as pid, tb_movie_store.filePath,
					M1.isComplete
					,M1.reset_avail

				
				FROM `tb_movie_maker` as M1
				INNER JOIN tb_order ON tb_order.id = M1.orderId
				INNER JOIN tb_order_item ON tb_order_item.id = M1.orderItemId
				LEFT JOIN tb_movie_store ON tb_movie_store.movieMakerId = M1.id
				
				INNER JOIN tb_product ON tb_order_item.productId = tb_product.id
				
				WHERE `tb_order`.`memberEmail` = '".$this->db->escape_str($user)."' AND tb_order.status != '07' and tb_order.status != '08' AND tb_order.status != '09' and tb_order.enable=true
							
				
			) AS A
			 
			 ORDER BY A.orderId DESC
			 limit $limit_ofset, $pagelist
			 ";
		$result['movie_list'] = $this->db->query($query,false)->result_array();
		$result['total_cnt'] =$this->db->query("SELECT FOUND_ROWS() AS total_cnt;")->row()->total_cnt;
		
		return $result;
	}

	function point_list($page = 1, $pagelist = 20, $email){
		if(is_numeric($page) == false) $page = 1;
		if($page < 0) $page = 1; 
		$limit_ofset = ($page-1) * $pagelist;
		
		$this->db->select('
			SQL_CALC_FOUND_ROWS tb_member_saved_money.*,
			(SELECT SUM(money) FROM tb_member_saved_money WHERE memberId = tb_member.id AND money > 0 ) AS sumplus,
			(SELECT SUM(money) FROM tb_member_saved_money WHERE memberId = tb_member.id AND money < 0 ) AS summus
			',false);
		$this->db->from('tb_member_saved_money');
		$this->db->join('tb_member','tb_member_saved_money.memberId = tb_member.id','inner');
		$this->db->where('tb_member.email',$email);
		$this->db->order_by('tb_member_saved_money.id','desc');
		$this->db->limit($pagelist,$limit_ofset);
		
		
		$result['point_list'] = $this->db->get()->result_array();
		$result['total_cnt'] =$this->db->query("SELECT FOUND_ROWS() AS total_cnt;")->row()->total_cnt;
		return $result;
	}
	
	function refund_list($page=1, $pagelist = 20, $user){
		if(is_numeric($page) == false) $page = 1;
		if($page < 0) $page = 1; 
		$limit_ofset = ($page-1) * $pagelist;
		
		
		 $query = "SELECT  SQL_CALC_FOUND_ROWS  *
			FROM (
				SELECT  M1.*, O.price, O.beforeStatus,  O.status as orderStatus,
				tb_order_item.imageMfile AS imagefile,
				tb_order_item.name, tb_order_item.id AS item_id, tb_movie_store.isDelete, tb_movie_store.fileName AS storeFile

				FROM `tb_movie_maker` AS M1
				INNER JOIN tb_order AS O ON O.id = M1.orderId
				INNER JOIN tb_order_item ON tb_order_item.id = M1.orderItemId
				LEFT JOIN tb_movie_store ON tb_movie_store.movieMakerId = M1.id
				WHERE  O.`memberEmail` = '".$this->db->escape_str($user)."'
				HAVING orderStatus = '02'
				
			) AS A
			 
			 ORDER BY A.orderId DESC
			 limit $limit_ofset, $pagelist
			 ";

		$result['refund_list'] = $this->db->query($query,false)->result_array();
		$result['total_cnt'] =$this->db->query("SELECT FOUND_ROWS() AS total_cnt;")->row()->total_cnt;
		
		return $result;
		
	}

	function refund_app_list($page=1, $pagelist = 20, $user){
		if(is_numeric($page) == false) $page = 1;
		if($page < 0) $page = 1; 
		$limit_ofset = ($page-1) * $pagelist;
		
		
		 $query = "SELECT  SQL_CALC_FOUND_ROWS  *
			FROM (
				SELECT  M1.*, O.price, O.beforeStatus,  O.status as orderStatus,
				tb_order_item.imageMfile AS imagefile,
				tb_order_item.name, tb_order_item.id AS item_id, tb_movie_store.isDelete, tb_movie_store.fileName AS storeFile

				FROM `tb_movie_maker` AS M1
				INNER JOIN tb_order AS O ON O.id = M1.orderId
				INNER JOIN tb_order_item ON tb_order_item.id = M1.orderItemId
				LEFT JOIN tb_movie_store ON tb_movie_store.movieMakerId = M1.id
				WHERE  O.`memberEmail` = '".$this->db->escape_str($user)."'
				HAVING orderStatus = '07' or orderStatus = '08'  or orderStatus = '09'
				
			) AS A
			 
			 ORDER BY A.orderId DESC
			 limit $limit_ofset, $pagelist
			 ";
		$result['refund_list'] = $this->db->query($query,false)->result_array();
		$result['total_cnt'] =$this->db->query("SELECT FOUND_ROWS() AS total_cnt;")->row()->total_cnt;
		
		return $result;
		
	}

	function _couponMake($couponId, $userId){
		$this->db->from("tb_coupon");
		$this->db->where("id",$couponId);
		$coupon = $this->db->get()->row_array();

		$data = array("memberId"=>$userId,
					  "couponId"=>$couponId,
					  "type"=>$coupon['type'],
					  "name"=>$coupon['name'],
					  "description"=>$coupon['description'],
					  "price"=>$coupon['price'],
					  "priceType"=>$coupon['priceType'],
					  "startDatetime"=>$coupon['startDatetime'],
					  "endDatetime"=>$coupon['endDatetime'],
					  "useProductType"=>$coupon['useProductType'],
					  "productId"=>$coupon['productId'],
					  "useCategoryType"=>$coupon['useCategoryType'],
					  "categoryId"=>$coupon['categoryId'],
					  "createDatetime"=>date('Y-m-d H:i:s')
		);
		return $this->db->insert("tb_member_coupon",$data);

	}
	function coupon_reg($key,$tiket,$userId){
		
		$query = "
			SELECT *, T.id, T.ticketNo, T.rechargeDatetime  , count(*) as cnt  
			FROM tb_voucher_ticket AS T
 			INNER JOIN tb_voucher_episode AS E ON T.episodeId = E.id
 			WHERE T.ticketNo = HEX(AES_ENCRYPT('".$tiket."', MD5('thedays')) )
			AND T.rechargeDatetime IS NULL 
		";
		$sql = $this->db->query($query);
		//print_r($sql);
		$row = $sql->row_array();		
		if ($row['cnt'] > 0){
			
			//useType    thedays, ecoupon
			//voucherType = SAVED_MONEY, DISCOUNT_PAYMENT
			//amount    15 , 100, 10000

			//트랜잭션 스타트
			//$this->db->trans_start();

			//Ecoupon 인 경우
			if($row['useType'] == 'ecoupon'){
				$this->_couponMake($row['couponId'], $userId);
			}else{
				if($row['voucherType'] == 'DISCOUNT_PAYMENT'){
					$this->_couponMake($row['couponId'], $userId);
				}else{
					///적립금 지급 일경우
					$data = array('memberId'=>$userId, 'name'=>'적립금쿠폰 등록', 'money'=>$row['amount'],'createDatetime'=>date('Y-m-d H:i:s'));
					$this->db->insert('tb_member_saved_money',$data);
				}
			}
			
			//사용처리
			$data = array('rechargeDatetime'=>date('Y-m-d H:i:s'),'rechargeMemberId'=>$userId);
			$this->db->where('id',$row['id']);
			$this->db->update('tb_voucher_ticket',$data);
			
			//$this->db->trans_complete();
			//트랜잭션 엔드
			
			$status = true;
			
			
			
		}else{
			//없음
			$date = date('Y-m-d H:i:s');
			$ip =  $this->input->ip_address();
			$bro = $this->input->user_agent();
			$query = "
				  
				INSERT INTO `thedays`.`tb_voucher_recharge` 
				( 
				`ticketNo`, 
				`memberid`, 
				`memberName`, 
				`userIp`, 
				`userAgent`, 
				`rechargeType`, 
				`createDatetime`
				)
				VALUES
				( 
				HEX(AES_ENCRYPT('".$tiket."', MD5('thedays')) ), 
				'".$userId."', 
				'', 
				'".$ip."', 
				'".$bro."', 
				'rechargeType', 
				'".$date."'
				);
			";
			$this->db->query($query);
			$status = false;
		}
		
		return $status;
	}

	function ajax_find_coupon($tiket){
		$query = "
			SELECT *, T.id, T.ticketNo, T.rechargeDatetime  , count(*) as cnt
			FROM tb_voucher_ticket AS T
 			INNER JOIN tb_voucher_episode AS E ON T.episodeId = E.id
 			WHERE T.ticketNo = HEX(AES_ENCRYPT('".$tiket."', MD5('thedays')) )
		";
		$sql = $this->db->query($query);
		return $sql->row_array();
	}

	function coupon_list($page,$pagelist,$email,$type){
		if(is_numeric($page) == false) $page = 1;
		if($page < 0) $page = 1; 
		$limit_ofset = ($page-1) * $pagelist;
		
		
		$this->db->select('SQL_CALC_FOUND_ROWS tb_member_coupon.*',false);
		$this->db->from('tb_member_coupon');
		$this->db->join('tb_member','tb_member_coupon.memberId = tb_member.id','inner');
		$this->db->where('tb_member.email',$email);
		if(!$type){
			$this->db->where('tb_member_coupon.useDatetime is null'); //null 사용가능, not null 사용함
		}else{
			$this->db->where('tb_member_coupon.useDatetime is not null'); //null 사용가능, not null 사용함
		}
		$this->db->order_by('tb_member_coupon.id','desc');
		$this->db->limit($pagelist,$limit_ofset);
		
		$result['coupon_list'] = $this->db->get()->result_array();
		$result['total_cnt'] =$this->db->query("SELECT FOUND_ROWS() AS total_cnt;")->row()->total_cnt;
		
		return $result;
	}
	
	function select_movie($id){
		$this->db->from('tb_movie_store');
		$this->db->where('movieMakerId',$id);
		return $this->db->get();
	}



	function myqa_list($input){
		if(is_numeric($input["page"]) == false) $input["page"] = 1;
		if($input["page"] < 0) $input["page"] = 1;

		$limit_ofset = ($input["page"]-1) * $input["pagelist"];

		//$this->db->select('SQL_CALC_FOUND_ROWS T1.*, C.name as cate_name',false);
		$this->db->from($input['table']." as T1");
		$this->db->where("memberEmail", $input['email']);

		$this->db->limit($input["pagelist"],$limit_ofset);

		$result['page_list_m']= $this->db->get()->result_array();
		$result['total_cnt'] =$this->db->query("SELECT FOUND_ROWS() AS total_cnt;")->row()->total_cnt;

		return $result;

	}

	function myqa_views($input){
		$this->db->select('T1.*, R.content as reply',false);
		$this->db->from($input['table']." as T1");
		$this->db->join("tb_email_reply as R","T1.id = R.emailInquiryId","inner");
		$this->db->where("T1.memberEmail", $input['email']);
		return $this->db->get()->row_array();

	}

}
