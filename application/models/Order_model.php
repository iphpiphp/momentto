<?
class Order_model extends CI_Model {
	function __construct() {
		parent::__construct();
		$this->load->helper('bankcode'); //은행코드 로드
	}

	function _catename($caterogyId){
			$this -> db -> select('name');
			$this -> db -> from('tb_category');
			$this -> db -> where('id', $caterogyId);			
			$this -> db -> limit(1);
			return $this -> db -> get()->row()->name;
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

	//쿠폰 조회
	function coupon_vfx($user, $couponId){
		$this -> db -> from('tb_member_coupon');
		$this -> db -> where('tb_member_coupon.id', $couponId);
		$this -> db -> where('tb_member_coupon.memberId', $user);
		$this -> db -> limit(1);
		return $this -> db -> get() -> row_array();
	}
	
	//포인트 조회
	function point_vfx($user, $poin){
		$this -> db -> select_sum('money');
		$this -> db -> from('tb_member_saved_money');		
		$this -> db -> where('tb_member_saved_money.memberId', $user);
		$this -> db -> limit(1);
		return $this -> db -> get() -> row_array();
	}


	/** 무통장 입금 
	 * cart_data : cart list
	 * data : order
	 * 현재 사용 안함
	 */
	function nbank_insert($cart_data, $order_data) {
		//print_r($cart_data);
		//print_r($order_data);
		//$order_data = array();
		$total = 0;
		$couponPrice = 0; //쿠폰 사용금액
		$useSavedMoney = 0; //사용 포인트
		foreach ($cart_data['product'] as $key => $cart) {
			
			
			$total = $total + $cart['price']; //상품  전체 가격
			
			//쿠폰 아이디가 있으면
			if($order_data['couponId']){
				$total = $total - $couponPrice; //쿠폰 가격만큼 제함
			}
			
						
			$in_data_item = array(
				'id' =>null,
				'orderId'=>null,
				'productId'=>$cart['id'],
				'categoryId'=>$cart['categoryId'],
				'categoryName'=>$this->_catename($cart['categoryId']),
				'name'=>$cart['name'], 
				'setsType'=>$cart['setsType'], 
				'runtime'=>$cart['runtime'], 
				'imageText'=>$cart['imageText'], 
				'movieText'=>$cart['movieText'], 
				'production'=>$cart['production'], 
				'originalMusic'=>$cart['originalMusic'], 
				'recommendMusic'=>$cart['recommendMusic'], 
				'price'=>$cart['price'], 
				'eventPrice'=>$cart['eventPrice'], 
				'savedMoney'=>0, 
				'resolution'=>'null| 1280 HD (16:9)', 
				'grade'=>$cart['grade'], 
				'genres'=>$cart['genres'], 
				'keywords'=>$cart['keywords'], 
				'shootingPlaces'=>null, 
				'imagePath'=>$cart['imagePath'], 
				'imageLFile'=>$cart['imageLFile'], 
				'imageMFile'=>$cart['imageMFile'], 
				'imageSFile'=>$cart['imageSFile'], 
				'imageNFile'=>$cart['imageNFile'], 
				'createDatetime'=>date("Y-m-d H:i:s"), 
				'preset1'=>$cart['preset1'], 
				'movieVimeoId'=>$cart['movieVimeoId'], 
				'preset2'=>$cart['preset2'], 
				'preset3'=>$cart['preset3'], 
				'preset4'=>$cart['preset4'], 
				'preset5'=>$cart['preset5'], 
				'preset6'=>$cart['preset6'],
			);
			$order_item[$key] = $in_data_item;
		}
		
		$total =  $cart_data['total_price'];
		
		$memberId = $this->session->userdata['mid'];
		
		$order = array(
				'id'=>null,
				 'price'=>$total,
				 'savedMoney'=>0,
				 'useSavedMoney'=>$useSavedMoney,
				 'usePartnerPoint'=>0,
				 'couponId'=>$order_data['couponId'],
				 'couponPrice'=>$couponPrice,
				 'device'=>$order_data['device'],
				 'memberId'=>$memberId,
				 'memberUserId'=>'',
				 'memberPassword'=>$order_data['memberPassword'],
				 'memberName'=>$order_data['username'],
				 'memberTel'=>'',
				 'memberMobile'=>'',
				 'memberEmail'=>$order_data['email'],
				 'ip'=>$order_data['ip'],
				 'modifyDatetime'=>$order_data['modifyDatetime'],
				 'inflow'=>null,
				 'createDatetime'=>$order_data['createDatetime'],
				 'status'=>$order_data['status'],
				 'beforeStatus'=>$order_data['beforeStatus'],
				 'enable'=>1
 			);
			//echo $cart['id'];
		
		
		$order_payment = array(
							'id'=>null, 
							'oid'=>$order_data['oid'], 
							'orderId'=>0, 
							'payId'=>$order_data['payId'], 
							'payMethod'=>$order_data['payMethod'], 
							'price'=>$total, 
							'resultCode'=>'00', 
							'resultMessage'=>'무통장 입금', 
							'cardNo'=>'', 
							'cardCode'=>'', 
							'cardBankCode'=>'', 
							'cardInstallMent'=>'', 
							'bankCode'=>$order_data['pay_bank_code'], 
							'bankNo'=>$order_data['bankNo'], 
							'bankMemberName'=>$order_data['bankMemberName'], 
							'bankDepositName'=>$order_data['username'], 
							'bankDepositPrice'=>null, 
							'bankDepositBank'=>null, 
							'bankExpireDate'=>date("Ymd",strtotime("+7 day")), 
							'bankDepositCheckType'=>null, 
							'bankDepositDate'=>null, 
							'bankDepositTime'=>null, 
							'adminId'=>null,
							'memberName'=>null, 
							'memberMobile'=>null, 
							'memberEmail'=>null, 
							'confirmDatetime'=>date("YmdHis"), 
							'applyId'=>null, 
							'applyDate'=>date("Ymd"), 
							'applyTime'=>date("His"), 
							'cashReceiptIssueCode'=>null,
							'cashReceiptIssueResultCode'=>null, 
							'mobile'=>null, 
							'isSuccess'=>0, 
							'createDatetime'=>date("Y-m-d H:i:s")
						);


		//echo"order item =><br>";
		//echo "<pre>";
		//print_r($order_item);
		//echo "</pre>";
		//트랜잭션 시작
		
		$this->db->insert('tb_order', $order); //order
		$first_insert_id = $this->db->insert_id();
		
		//$first_insert_id = "000";
		
		foreach($order_item as $key => $item){
			$order_item[$key]['orderId'] = $first_insert_id;			
		}
		
		/*
		echo"order item =><br>";
		echo "<pre>";
		print_r($order_item);
		echo "</pre>";
		 */
		
		$order_payment['orderId'] = $first_insert_id;
		
		/*
		echo"<br>";
		echo "<pre>";
		print_r($order_payment);
		echo "</pre>";
		 * */
		
		$this->db->insert_batch('tb_order_item', $order_item); //order_item
		$this->db->insert('tb_order_payment', $order_payment); //order_payment
				
		//트랜잭션 엔드
		
		//oid 를 세션으로 전달 -- 리턴 페이지에서 찾기 위함
		$newdata = array(  'svae_oid'  => $first_insert_id);
		$this->session->set_userdata($newdata);
		
		
		$result['ststus'] = true;
		$result['oid'] = $order_payment['orderId'];		
		return $result;
	
	}
	
	//이니시스 채번식 리턴
	function m_inicis_return($oid){
		$this->db->from('tb_order_payment');
		$this->db->where('oid',$oid);
		$sql = $this->db->get();		
		$result['orderId'] = false;
		
		if($sql->num_rows() > 0){
			$orderId = $sql->row()->orderId;
			$result['orderId'] = $orderId;
			$this->db->from('tb_order');
			$this->db->where('id',$orderId);
			$result['order'] = $this->db->get()->row_array();
			
		}else{
			alert_parent("결제 처리에 오류가 발생 하였습니다. 결제 대금이 입금이 되셨을 경우, 문의해 주십시오.","/order/form");
		}
				
		if($result['orderId']){
			$oid = $result['orderId'];
			
			$this->db->from('tb_order as O');
			$this->db->join('tb_order_payment as P','O.id = P.orderId','left');
			$this->db->where('O.id',$orderId);
			$row = $this->db->get()->row_array();
			
			//기본정보
			$send_email = $row['memberEmail']; //받을 이메일
			
			//$point = 0; //사용포인트
			$pay_type = 'M_이니시스_'.$row['payMethod']; //결제 방법
			$payment = $row['price']; //최종결제액
			

			$fin_is_member = '비회원';
			if($this->session->userdata("mid")) $fin_is_member = '회원';
			
			//메일 발송		
			$this->temp_email->order_fin_mail_send($send_email, $oid, $point, $pay_type, $payment, $fin_is_member, $cart_data);			
		}

		return $result;
		
	}
	
	//이니시스 저장 웹표준 결재 방식
	function inicis_save($cart_data, $order_data, $resultMap) {
		
				//$resultMap["tid"] 			거래번호
				//$resultMap["payMethod"] 		결제방법 지불수단
				//$resultMap["resultCode"] 		결과코드 
				//$resultMap["resultMsg"] 		결과내용
				//$resultMap["TotPrice"]		결제완료금액
				//$resultMap["orderNumber"]		주문번호
				//$resultMap["applDate"]		승인날짜
				//$resultMap["applTime"]		승인시간
				
		$total = 0;
		$couponPrice = 0; //쿠폰 사용금액
		$useSavedMoney = 0; //사용 포인트		
		$total = $resultMap['TotPrice'];
		
		$memberId = null;
		if($this->session->userdata['mid']) $memberId = $this->session->userdata['mid'];
		
		//맴버 유저 아이디
		$memberUserId = $this->session->userdata('member_user_id');
		
		if($order_data['point'] > 0 ){
			$sum = $total - $order_data['point'];
			
			$this -> db -> select_sum('money');
			$this -> db -> from('tb_member_saved_money');		
			$this -> db -> where('tb_member_saved_money.memberId', $memberId);
			$this -> db -> limit(1);
			$row_point = $this -> db -> get() -> row_array();
			
			$sum2 = $row_point['money'] - $order_data['point'];
			
			$useSavedMoney = $sum2;
			if($sum2 < 0) alert('보유 포인트가 부족합니다.','/order/form/');	
			//if($sum > 0) alert('지불 포인트가 부족합니다.','/order/form/');
			if($sum < 0){
				 //초과 포인트는 상품 가격만 제외
				$useSavedMoney = $total;  
			} 
		
		}
		
		
		
		
		
		foreach ($cart_data['product'] as $key => $cart) {
			//이니시스는 쿠폰과 포인트를 사전 결제 끝내고 나서 계산된 토탈 금액으로 한다
			
						
			$in_data_item = array(
				'id' =>null,
				'orderId'=>null,
				'productId'=>$cart['id'],
				'categoryId'=>$cart['categoryId'],
				'categoryName'=>$this->_catename($cart['categoryId']),
				'name'=>$cart['name'], 
				'setsType'=>$cart['setsType'], 
				'runtime'=>$cart['runtime'], 
				'imageText'=>$cart['imageText'], 
				'movieText'=>$cart['movieText'], 
				'production'=>$cart['production'], 
				'originalMusic'=>$cart['originalMusic'], 
				'recommendMusic'=>$cart['recommendMusic'], 
				'price'=>$cart['price'], 
				'eventPrice'=>$cart['eventPrice'], 
				'savedMoney'=>0, 
				'resolution'=>'null| 1280 HD (16:9)', 
				'grade'=>$cart['grade'], 
				'genres'=>$cart['genres'], 
				'keywords'=>$cart['keywords'], 
				'shootingPlaces'=>null, 
				'imagePath'=>$cart['imagePath'], 
				'imageLFile'=>$cart['imageLFile'], 
				'imageMFile'=>$cart['imageMFile'], 
				'imageSFile'=>$cart['imageSFile'], 
				'imageNFile'=>$cart['imageNFile'], 
				'createDatetime'=>date("Y-m-d H:i:s"), 
				'preset1'=>$cart['preset1'], 
				'movieVimeoId'=>$cart['movieVimeoId'], 
				'preset2'=>$cart['preset2'], 
				'preset3'=>$cart['preset3'], 
				'preset4'=>$cart['preset4'], 
				'preset5'=>$cart['preset5'], 
				'preset6'=>$cart['preset6'],
			);
			$order_item[$key] = $in_data_item;
		}
		
		
		
		
		$order = array(
				'id'=>null,
				 'price'=>$total,
				 'savedMoney'=>0,
				 'useSavedMoney'=>-$order_data['point'],
				 'usePartnerPoint'=>0,
				 'couponId'=>$order_data['couponId'],
				 'couponPrice'=>$couponPrice,
				 'device'=>$order_data['device'],
				 'memberId'=>$memberId,
				 'memberUserId'=>$memberUserId,
				 'memberPassword'=>$order_data['memberPassword'],
				 'memberName'=>$order_data['username'],
				 'memberTel'=>'',
				 'memberMobile'=>$resultMap['buyerTel'],
				 'memberEmail'=>$order_data['email'],
				 'ip'=>$order_data['ip'],
				 'modifyDatetime'=>$order_data['modifyDatetime'],
				 'inflow'=>null,
				 'createDatetime'=>$order_data['createDatetime'],
				 'status'=>$order_data['status'],
				 'beforeStatus'=>$order_data['beforeStatus'],
				 'enable'=>1
 			);
			//echo $cart['id'];
		
		
			$isSuccess = true;
			$cardNo = "";
			$cardCode = "";
			$cardBankCode = "";
			$cardInstallMent = "";
			if($resultMap['payMethod'] == "Card"){
				$cardNo = $resultMap["CARD_Num"];
				$cardCode = $resultMap["CARD_Code"];
				$cardBankCode = $resultMap["CARD_BankCode"];
				$cardInstallMent = $resultMap["CARD_Interest"];
				$isSuccess = 1;
			}
			
			$bankCode = "";
			$bankNo = "";
			$bankMemberName = "주식회사 위드비디오";		//
			$bankDepositName = "";
			
			$bankDepositBank = "";		//이체 은행명
			$bankDepositCheckType = 2; //수동수신 
			
			if($resultMap['payMethod'] == "VBank"){
				$bankCode = 					$resultMap["VACT_BankCode"];
				$bankNo = 						$resultMap["VACT_Num"];				
				$bankDepositName = 				$resultMap["VACT_InputName"];
				$bankDepositBank =				$resultMap["vactBankName"];				
				$bankDepositCheckType =			1;//자동수신				
					//$resultMap["VACT_Num"] 				입금계좌번호
					//$resultMap["VACT_BankCode"] 			입금은행코드
					//$resultMap["vactBankName"]			입금은행명
					//$resultMap["VACT_Name"]				예금주 명
					//$resultMap["VACT_InputName"]			송금자 명
					//$resultMap["VACT_Date"]				송금일자
					//$resultMap["VACT_Time"]				송금시간
				$isSuccess = 0;
			}
			
			if($resultMap['payMethod'] == "DirectBank"){
				$bankCode = $resultMap["ACCT_BankCode"];
				//$resultMap["ACCT_BankCode"]			은행코드	
			}
			
			
		
		
		
		$order_payment = array(
							'id'=>null, 
							'oid'=>$order_data['oid'], 
							'orderId'=>0, 
							'payId'=>$order_data['payId'], 
							'payMethod'=>strtolower($order_data['payMethod']), 
							'price'=>$total, 
							'resultCode'=>$resultMap['resultCode'], 
							'resultMessage'=>$resultMap['resultMsg'], 
							'cardNo'=>$cardNo, 
							'cardCode'=>$cardCode, 
							'cardBankCode'=>$cardBankCode, 
							'cardInstallMent'=>$cardInstallMent, 
							'bankCode'=>$order_data['pay_bank_code'], 
							'bankNo'=>$order_data['bankNo'], 
							'bankMemberName'=>$bankMemberName, 
							'bankDepositName'=>$order_data['username'], 
							'bankDepositPrice'=>null, 
							'bankDepositBank'=>$bankDepositBank, 
							'bankExpireDate'=>date("Ymd",strtotime("+7 day")), 
							'bankDepositCheckType'=>$bankDepositCheckType, 
							'bankDepositDate'=>null, 
							'bankDepositTime'=>null, 
							'adminId'=>null,
							'memberName'=>null, 
							'memberMobile'=>null, 
							'memberEmail'=>null, 
							'confirmDatetime'=>date("YmdHis"), 
							'applyId'=>null, 
							'applyDate'=>date("Ymd"), 
							'applyTime'=>date("His"), 
							'cashReceiptIssueCode'=>null,
							'cashReceiptIssueResultCode'=>null, 
							'mobile'=>null, 
							'isSuccess'=>$isSuccess, 
							'createDatetime'=>date("Y-m-d H:i:s")
						);


		//echo"order item =><br>";
		//echo "<pre>";
		//print_r($order_item);
		//echo "</pre>";
		
		//트랜잭션 시작		
		$this->db->insert('tb_order', $order); //order
		$first_insert_id = $this->db->insert_id();
		foreach($order_item as $key => $item){
			$order_item[$key]['orderId'] = $first_insert_id;			
		}
		
		//echo"order item =><br>";
		//echo "<pre>";
		//print_r($order_item);
		//echo "</pre>";
		
		$order_payment['orderId'] = $first_insert_id;
		
		//echo"<br>";
		//echo "<pre>";
		//print_r($order_payment);
		//echo "</pre>";
		
		$this->db->insert_batch('tb_order_item', $order_item); //order_item
		$this->db->insert('tb_order_payment', $order_payment); //order_payment
		
		//무비 메이커 생성 -- 무조건 생성		
		$this->db->select("*");
		$this->db->from("tb_order_item");
		$this->db->where("orderId",$first_insert_id);
		$order_item_row_data = $this -> db -> get() -> result_array();
		
		$movie_maker = array();
		foreach($order_item_row_data as $key => $item){
			$movie_maker[$key]['id'] = "B".$first_insert_id.$key;
			$movie_maker[$key]['orderId'] = $first_insert_id;
			$movie_maker[$key]['orderItemId'] = $item['id'];
			$movie_maker[$key]['memberId'] = $memberId;
			$movie_maker[$key]['isComplete'] = 0;
			$movie_maker[$key]['createDatetime'] = date("Y-m-d H:i:s"); 
		}
		
		//print_r($movie_maker);
		$this->db->insert_batch('tb_movie_maker', $movie_maker); //order_payment
		
		//트랜잭션 엔드
		
		$date = date('Y-m-d H:i:s');
		//포인트 사용시 포인트 처리
		if($useSavedMoney){
			$point_data = array(
				'memberId'=>$memberId,
				'orderId'=>$first_insert_id,
				'name'=>'상품구매',
				'money'=> -$order_data['point'],
				'endDatetime'=>null,
				'createDatetime'=>$date
			);
			$this->db->insert('tb_member_saved_money',$point_data);
		}
				
		//트랜잭션 엔드
		
		$result['status'] = true;
		$result['oid'] = $order_payment['orderId'];
		return $result;			
					
	}
	
		
	//이니시스 모바일 저장 - 가상 계좌 밖에 안 씀...
	function m_inicis_save($cart_data, $order_data, $resultMap) {

		//모바일은 오브젝트로 받아옴				
		$total = 0;
		$couponPrice = 0; //쿠폰 사용금액
		$useSavedMoney = 0; //사용 포인트		
		$total = $resultMap->m_resultprice;
				
		$memberId = null;
		if($this->session->userdata['mid']) $memberId = $this->session->userdata['mid'];
		$memberUserId = $this->session->userdata('member_user_id');
		
		if($order_data['point'] > 0 ){
			$sum = $total - $order_data['point'];
			
			$this -> db -> select_sum('money');
			$this -> db -> from('tb_member_saved_money');		
			$this -> db -> where('tb_member_saved_money.memberId', $memberId);
			$this -> db -> limit(1);
			$row_point = $this -> db -> get() -> row_array();
			
			$sum2 = $row_point['money'] - $order_data['point'];
			
			if($sum2 < 0) alert('보유 포인트가 부족합니다.','/order/form/');	
			//if($sum > 0) alert('지불 포인트가 부족합니다.','/order/form/');
			if($sum < 0){
				 //초과 포인트는 상품 가격만 제외
				$useSavedMoney = $total;  
			} 
		
		}
		
		
		
		
		
		foreach ($cart_data['product'] as $key => $cart) {
			//이니시스는 쿠폰과 포인트를 사전 결제 끝내고 나서 계산된 토탈 금액으로 한다
			
						
			$in_data_item = array(
				'id' =>null,
				'orderId'=>null,
				'productId'=>$cart['id'],
				'categoryId'=>$cart['categoryId'],
				'categoryName'=>$this->_catename($cart['categoryId']),
				'name'=>$cart['name'], 
				'setsType'=>$cart['setsType'], 
				'runtime'=>$cart['runtime'], 
				'imageText'=>$cart['imageText'], 
				'movieText'=>$cart['movieText'], 
				'production'=>$cart['production'], 
				'originalMusic'=>$cart['originalMusic'], 
				'recommendMusic'=>$cart['recommendMusic'], 
				'price'=>$cart['price'], 
				'eventPrice'=>$cart['eventPrice'], 
				'savedMoney'=>0, 
				'resolution'=>'null| 1280 HD (16:9)', 
				'grade'=>$cart['grade'], 
				'genres'=>$cart['genres'], 
				'keywords'=>$cart['keywords'], 
				'shootingPlaces'=>null, 
				'imagePath'=>$cart['imagePath'], 
				'imageLFile'=>$cart['imageLFile'], 
				'imageMFile'=>$cart['imageMFile'], 
				'imageSFile'=>$cart['imageSFile'], 
				'imageNFile'=>$cart['imageNFile'], 
				'createDatetime'=>date("Y-m-d H:i:s"), 
				'preset1'=>$cart['preset1'], 
				'movieVimeoId'=>$cart['movieVimeoId'], 
				'preset2'=>$cart['preset2'], 
				'preset3'=>$cart['preset3'], 
				'preset4'=>$cart['preset4'], 
				'preset5'=>$cart['preset5'], 
				'preset6'=>$cart['preset6'],
			);
			$order_item[$key] = $in_data_item;
		}
		
		
		
		
		$order = array(
				'id'=>null,
				 'price'=>$total,
				 'savedMoney'=>0,
				 'useSavedMoney'=>-$order_data['point'],
				 'usePartnerPoint'=>0,
				 'couponId'=>$order_data['couponId'],
				 'couponPrice'=>$couponPrice,
				 'device'=>$order_data['device'],
				 'memberId'=>$memberId,
				 'memberUserId'=>$memberUserId,
				 'memberPassword'=>$order_data['memberPassword'],
				 'memberName'=>$order_data['username'],
				 'memberTel'=>'',
				 'memberMobile'=>'',
				 'memberEmail'=>$order_data['email'],
				 'ip'=>$order_data['ip'],
				 'modifyDatetime'=>$order_data['modifyDatetime'],
				 'inflow'=>null,
				 'createDatetime'=>$order_data['createDatetime'],
				 'status'=>$order_data['status'],
				 'beforeStatus'=>$order_data['beforeStatus'],
				 'enable'=>1
 			);
			//echo $cart['id'];
		
		
			$isSuccess = true;
			$cardNo = "";
			$cardCode = "";
			$cardBankCode = "";
			$cardInstallMent = "";

			//echo "<br><br><br><br> resultMap === > <br>"; print_r($resultMap);
			if($resultMap->m_payMethod == "CARD"){
				$cardNo = $resultMap->m_cardNum;
				$cardCode = $resultMap->m_cardCode;
				$cardBankCode = null;
				$cardInstallMent = null;
				$isSuccess = 1;
			}
			
			$bankCode = "";
			$bankNo = "";
			$bankMemberName = "주식회사 위드비디오";		//
			$bankDepositName = "";
			
			$bankDepositBank = "";		//이체 은행명
			$bankDepositCheckType = 2; //수동수신 
			
			if($resultMap->m_payMethod == "VBANK"){
					
				$bank_names = bank_names($resultMap->m_vcdbank); //헬퍼
				
				$bankCode = 					$resultMap->m_vacct;
				$bankNo = 						$resultMap->m_vcdbank;				
				$bankDepositName = 				$resultMap->m_nmvacct;
				$bankDepositBank =				$bank_names;				
				$bankDepositCheckType =			1;//자동수신
				$isSuccess = 0;
			}
			
			if($resultMap->m_payMethod == "BANK"){
				$bankCode = null;
				//$resultMap["ACCT_BankCode"]			은행코드	
			}
			
			
		
		
		
		$order_payment = array(
							'id'=>null, 
							'oid'=>$order_data['oid'], 
							'orderId'=>0, 
							'payId'=>$order_data['payId'], 
							'payMethod'=>strtolower($order_data['payMethod']), 
							'price'=>$total, 
							'resultCode'=>$resultMap->m_resultCode, 
							'resultMessage'=>$resultMap->m_resultMsg, 
							'cardNo'=>$cardNo, 
							'cardCode'=>$cardCode, 
							'cardBankCode'=>$cardBankCode, 
							'cardInstallMent'=>$cardInstallMent, 
							'bankCode'=>$order_data['pay_bank_code'], 
							'bankNo'=>$order_data['bankNo'], 
							'bankMemberName'=>$bankMemberName, 
							'bankDepositName'=>$order_data['username'], 
							'bankDepositPrice'=>null, 
							'bankDepositBank'=>$bankDepositBank, 
							'bankExpireDate'=>date("Ymd",strtotime("+7 day")), 
							'bankDepositCheckType'=>$bankDepositCheckType, 
							'bankDepositDate'=>null, 
							'bankDepositTime'=>null, 
							'adminId'=>null,
							'memberName'=>null, 
							'memberMobile'=>null, 
							'memberEmail'=>null, 
							'confirmDatetime'=>date("YmdHis"), 
							'applyId'=>null, 
							'applyDate'=>date("Ymd"), 
							'applyTime'=>date("His"), 
							'cashReceiptIssueCode'=>null,
							'cashReceiptIssueResultCode'=>null, 
							'mobile'=>null, 
							'isSuccess'=>$isSuccess, 
							'createDatetime'=>date("Y-m-d H:i:s")
						);


		//echo"order item =><br>";
		//echo "<pre>";
		//print_r($order_item);
		//echo "</pre>";
		
		//트랜잭션 시작		
		$this->db->insert('tb_order', $order); //order
		$first_insert_id = $this->db->insert_id();
		foreach($order_item as $key => $item){
			$order_item[$key]['orderId'] = $first_insert_id;			
		}
		
		//echo"order item =><br>";
		//echo "<pre>";
		//print_r($order_item);
		//echo "</pre>";
		
		$order_payment['orderId'] = $first_insert_id;
		
		//echo"<br>";
		//echo "<pre>";
		//print_r($order_payment);
		//echo "</pre>";
		
		$this->db->insert_batch('tb_order_item', $order_item); //order_item
		$this->db->insert('tb_order_payment', $order_payment); //order_payment
		
		//무비 메이커 생성 -- 무조건 생성		
		$this->db->select("*");
		$this->db->from("tb_order_item");
		$this->db->where("orderId",$first_insert_id);
		$order_item_row_data = $this -> db -> get() -> result_array();
		
		$movie_maker = array();
		foreach($order_item_row_data as $key => $item){
			$movie_maker[$key]['id'] = "B".$first_insert_id.$key;
			$movie_maker[$key]['orderId'] = $first_insert_id;
			$movie_maker[$key]['orderItemId'] = $item['id'];
			$movie_maker[$key]['memberId'] = $memberId;
			$movie_maker[$key]['isComplete'] = 0;
			$movie_maker[$key]['createDatetime'] = date("Y-m-d H:i:s"); 
		}
		
		//print_r($movie_maker);
		$this->db->insert_batch('tb_movie_maker', $movie_maker); //order_payment
		
		//트랜잭션 엔드
		
		$date = date('Y-m-d H:i:s');
		//포인트 사용시 포인트 처리
		if($useSavedMoney){
			$point_data = array(
				'memberId'=>$memberId,
				'orderId'=>$first_insert_id,
				'name'=>'상품구매',
				'money'=> -$order_data['point'],
				'endDatetime'=>null,
				'createDatetime'=>$date
			);
			$this->db->insert('tb_member_saved_money',$point_data);
		}
				
		//트랜잭션 엔드
		
		$result['status'] = true;
		$result['oid'] = $order_payment['orderId'];
		return $result;			
					
	}
	
	//kpay 채번 데이터 실제  저장 
	function m_inicis_noti_save($resultMap){
		
		$this->db->from('zd_pay_order');
		$this->db->where('p_oid', $resultMap['P_OID']);
		$pay_order = $this->db->get()->row_array();
		
		$this->db->from('zd_pay_order AS P');
		$this->db->join('zd_pay_order_item AS I', 'P.id = I.orderId','inner');
		$this->db->where('P.p_oid', $resultMap['P_OID']);
		$pay_order_item = $this->db->get()->result_array();
		
						
		$total = 0;
		$couponPrice = 0; //쿠폰 사용금액
		$useSavedMoney = $pay_order['useSavedMoney'];
		$total = $resultMap['P_AMT'];
		
		$memberId = $pay_order['memberId'];
		
		
		foreach ($pay_order_item as $key => $cart) {
			//이니시스는 쿠폰과 포인트를 사전 결제 끝내고 나서 계산된 토탈 금액으로 한다
			//-----??
						
			$in_data_item = array(
				'id' =>null,
				'orderId'=>null,
				'productId'=>$cart['productId'],
				'categoryId'=>$cart['categoryId'],
				'categoryName'=>$this->_catename($cart['categoryId']),
				'name'=>$cart['name'], 
				'setsType'=>$cart['setsType'], 
				'runtime'=>$cart['runtime'], 
				'imageText'=>$cart['imageText'], 
				'movieText'=>$cart['movieText'], 
				'production'=>$cart['production'], 
				'originalMusic'=>$cart['originalMusic'], 
				'recommendMusic'=>$cart['recommendMusic'], 
				'price'=>$cart['price'], 
				'eventPrice'=>$cart['eventPrice'], 
				'savedMoney'=>0, 
				'resolution'=>'null| 1280 HD (16:9)', 
				'grade'=>$cart['grade'], 
				'genres'=>$cart['genres'], 
				'keywords'=>$cart['keywords'], 
				'shootingPlaces'=>null, 
				'imagePath'=>$cart['imagePath'], 
				'imageLFile'=>$cart['imageLFile'], 
				'imageMFile'=>$cart['imageMFile'], 
				'imageSFile'=>$cart['imageSFile'], 
				'imageNFile'=>$cart['imageNFile'], 
				'createDatetime'=>date("Y-m-d H:i:s"), 
				'preset1'=>$cart['preset1'], 
				'movieVimeoId'=>$cart['movieVimeoId'], 
				'preset2'=>$cart['preset2'], 
				'preset3'=>$cart['preset3'], 
				'preset4'=>$cart['preset4'], 
				'preset5'=>$cart['preset5'], 
				'preset6'=>$cart['preset6'],
			);
			$order_item[$key] = $in_data_item;
		}
		
		$order = array(
				'id'=>null,
				 'price'=>$total,
				 'savedMoney'=>0,
				 'useSavedMoney'=>$useSavedMoney,
				 'usePartnerPoint'=>0,
				 'couponId'=>$pay_order['couponId'],
				 'couponPrice'=>$pay_order['couponPrice'],
				 'device'=>$pay_order['device'],
				 'memberId'=>$memberId,
				 'memberUserId'=>$pay_order['memberUserId'],
				 'memberPassword'=>$pay_order['memberPassword'],
				 'memberName'=>$pay_order['memberName'],
				 'memberTel'=>'',
				 'memberMobile'=>$pay_order['memberMobile'],
				 'memberEmail'=>$pay_order['memberEmail'],
				 'ip'=>$pay_order['ip'],
				 'modifyDatetime'=>$pay_order['modifyDatetime'],
				 'inflow'=>null,
				 'createDatetime'=>$pay_order['createDatetime'],
				 'status'=>$pay_order['status'],
				 'beforeStatus'=>$pay_order['beforeStatus'],
				 'enable'=>1
 			);
			//echo $cart['id'];
		
		
			$isSuccess = 0;
			$cardNo = "";
			$cardCode = "";
			$cardBankCode = "";
			$cardInstallMent = "";
			if($resultMap['P_TYPE'] == "CARD"){
				$cardNo = $resultMap['P_CARD_NUM'];
				$cardCode = $resultMap['P_CARD_ISSER_CODE'];
				$cardBankCode = null;
				$cardInstallMent = null;
				$isSuccess = 1;
			}
			
			$bankCode = "";
			$bankNo = "";
			$bankMemberName = "주식회사 위드비디오";		//
			$bankDepositName = "";
			
			$bankDepositBank = "";		//이체 은행명
			$bankDepositCheckType = 2; //수동수신 
			
			//가상계좌는 안받음
			
			if($resultMap['P_TYPE'] == "BANK"){
				$bankCode = $resultMap['P_FN_CD1'];
				//$resultMap["ACCT_BankCode"]			은행코드	
			}
			
		
		
		if($resultMap['P_TYPE'] == "MOBILE") $resultMap['P_TYPE'] = "hpp"; //규격 하나로 맞춤
		
		$order_payment = array(
							'id'=>null, 
							'oid'=>$pay_order['p_oid'], 
							'orderId'=>0, 
							'payId'=>$resultMap['P_TID'], 
							'payMethod'=>strtolower($resultMap['P_TYPE']), 
							'price'=>$pay_order['price'], 
							'resultCode'=>$resultMap['P_STATUS'], 
							'resultMessage'=>$resultMap['P_RMESG1'], 
							'cardNo'=>$cardNo, 
							'cardCode'=>$cardCode, 
							'cardBankCode'=>$cardBankCode, 
							'cardInstallMent'=>$cardInstallMent, 
							'bankCode'=>'', 
							'bankNo'=>'', 
							'bankMemberName'=>$bankMemberName, 
							'bankDepositName'=>$pay_order['memberName'], 
							'bankDepositPrice'=>null, 
							'bankDepositBank'=>$bankDepositBank, 
							'bankExpireDate'=>date("Ymd",strtotime("+7 day")), 
							'bankDepositCheckType'=>$bankDepositCheckType, 
							'bankDepositDate'=>null, 
							'bankDepositTime'=>null, 
							'adminId'=>null,
							'memberName'=>null, 
							'memberMobile'=>null, 
							'memberEmail'=>null, 
							'confirmDatetime'=>date("YmdHis"), 
							'applyId'=>null, 
							'applyDate'=>date("Ymd"), 
							'applyTime'=>date("His"), 
							'cashReceiptIssueCode'=>null,
							'cashReceiptIssueResultCode'=>null, 
							'mobile'=>null, 
							'isSuccess'=>$isSuccess, 
							'createDatetime'=>date("Y-m-d H:i:s")
						);


		//echo"order item =><br>";
		//echo "<pre>";
		//print_r($order_item);
		//echo "</pre>";
		
		//트랜잭션 시작		
		$this->db->insert('tb_order', $order); //order
		$first_insert_id = $this->db->insert_id();
		foreach($order_item as $key => $item){
			$order_item[$key]['orderId'] = $first_insert_id;			
		}
		
		//echo"order item =><br>";
		//echo "<pre>";
		//print_r($order_item);
		//echo "</pre>";
		
		$order_payment['orderId'] = $first_insert_id;
		
		//echo"<br>";
		//echo "<pre>";
		//print_r($order_payment);
		//echo "</pre>";
		
		$this->db->insert_batch('tb_order_item', $order_item); //order_item
		$this->db->insert('tb_order_payment', $order_payment); //order_payment
		
		//무비 메이커 생성 -- 무조건 생성		
		$this->db->select("*");
		$this->db->from("tb_order_item");
		$this->db->where("orderId",$first_insert_id);
		$order_item_row_data = $this -> db -> get() -> result_array();
		
		$movie_maker = array();
		foreach($order_item_row_data as $key => $item){
			$movie_maker[$key]['id'] = "B".$first_insert_id.$key;
			$movie_maker[$key]['orderId'] = $first_insert_id;
			$movie_maker[$key]['orderItemId'] = $item['id'];
			$movie_maker[$key]['memberId'] = $memberId;
			$movie_maker[$key]['isComplete'] = 0;
			$movie_maker[$key]['createDatetime'] = date("Y-m-d H:i:s"); 
		}
		
		//print_r($movie_maker);
		$this->db->insert_batch('tb_movie_maker', $movie_maker); //order_payment
		
		//트랜잭션 엔드
		
		$date = date('Y-m-d H:i:s');
		//포인트 사용시 포인트 처리
		if($useSavedMoney){
			$point_data = array(
				'memberId'=>$memberId,
				'orderId'=>$first_insert_id,
				'name'=>'상품구매',
				'money'=> -$pay_order['useSavedMoney'],
				'endDatetime'=>null,
				'createDatetime'=>$date
			);
			$this->db->insert('tb_member_saved_money',$point_data);
		}
				
		//트랜잭션 엔드
		
		$result['status'] = true;
		$result['oid'] = $order_payment['orderId'];
		return $result;
		
	}
	
	//kpay 채번용 저장 데이터 생성
	//ajax로 선 저장하고 이후 noti 를 비교해서 저장 하는 방식
	function ajax_minicis_init_save($cart_data, $order_data){		
		$total = 0;
		$couponPrice = 0; //쿠폰 사용금액
		$useSavedMoney = 0; //사용 포인트		
		$total = $order_data['total_price'];
		
		$memberId = null;
		if($this->session->userdata['mid']) $memberId = $this->session->userdata['mid'];
		$memberUserId = $this->session->userdata('member_user_id');
		
		$result['return_point'] = "T"; //포인트정상
		
		if($order_data['point'] > 0 ){
			$sum = $total - $order_data['point'];
			
			$this -> db -> select_sum('money');
			$this -> db -> from('tb_member_saved_money');
			$this -> db -> where('tb_member_saved_money.memberId', $memberId);
			$this -> db -> limit(1);
			$row_point = $this -> db -> get() -> row_array();
			
			$sum2 = $row_point['money'] - $order_data['point'];
			
			//if($sum2 < 0) alert('보유 포인트가 부족합니다.','/order/form/');
			
			if($sum2 < 0) $result['return_point'] = "F"; //포인트 부족 
			
			if($sum < 0){
				 //초과 포인트는 상품 가격만 제외
				$useSavedMoney = $total;  
			} 
		
		}
		
		foreach ($cart_data['product'] as $key => $cart) {
			//이니시스는 쿠폰과 포인트를 사전 결제 끝내고 나서 계산된 토탈 금액으로 한다
			
						
			$in_data_item = array(
				'id' =>null,
				'orderId'=>null,
				'productId'=>$cart['id'],
				'categoryId'=>$cart['categoryId'],
				'categoryName'=>$this->_catename($cart['categoryId']),
				'name'=>$cart['name'], 
				'setsType'=>$cart['setsType'], 
				'runtime'=>$cart['runtime'], 
				'imageText'=>$cart['imageText'], 
				'movieText'=>$cart['movieText'], 
				'production'=>$cart['production'], 
				'originalMusic'=>$cart['originalMusic'], 
				'recommendMusic'=>$cart['recommendMusic'], 
				'price'=>$cart['price'], 
				'eventPrice'=>$cart['eventPrice'], 
				'savedMoney'=>0, 
				'resolution'=>'null| 1280 HD (16:9)', 
				'grade'=>$cart['grade'], 
				'genres'=>$cart['genres'], 
				'keywords'=>$cart['keywords'], 
				'shootingPlaces'=>null, 
				'imagePath'=>$cart['imagePath'], 
				'imageLFile'=>$cart['imageLFile'], 
				'imageMFile'=>$cart['imageMFile'], 
				'imageSFile'=>$cart['imageSFile'], 
				'imageNFile'=>$cart['imageNFile'], 
				'createDatetime'=>date("Y-m-d H:i:s"), 
				'preset1'=>$cart['preset1'], 
				'movieVimeoId'=>$cart['movieVimeoId'], 
				'preset2'=>$cart['preset2'], 
				'preset3'=>$cart['preset3'], 
				'preset4'=>$cart['preset4'], 
				'preset5'=>$cart['preset5'], 
				'preset6'=>$cart['preset6'],
			);
			$order_item[$key] = $in_data_item;
		}
		
		$uniqid = uniqid(time());		
		
		$order = array(
				'id'=>							null,
				 'price'=>						$total,
				 'savedMoney'=>					0,
				 'useSavedMoney'=>				-$order_data['point'],
				 'usePartnerPoint'=>			0,
				 'couponId'=>					$order_data['couponId'],
				 'couponPrice'=>				$couponPrice,
				 'device'=>						$order_data['device'],
				 'memberId'=>					$memberId,
				 'memberUserId'=>				$memberUserId,
				 'memberPassword'=>				$order_data['memberPassword'],
				 'memberName'=>					$order_data['username'],
				 'memberTel'=>					'',
				 'memberMobile'=>				'',
				 'memberEmail'=>				$order_data['email'],
				 'ip'=>							$order_data['ip'],
				 'modifyDatetime'=>				$order_data['modifyDatetime'],
				 'inflow'=>						null,
				 'createDatetime'=>				$order_data['createDatetime'],
				 'status'=>						$order_data['status'],
				 'beforeStatus'=>				$order_data['beforeStatus'],
				 'enable'=>						1,
				 'p_oid' =>						$uniqid
 			);
			//echo $cart['id'];
		
		
			$isSuccess = 0;
			$cardNo = "";
			$cardCode = "";
			$cardBankCode = "";
			$cardInstallMent = "";
			
			
			$bankCode = "";
			$bankNo = "";
			$bankMemberName = "주식회사 위드비디오";		//
			$bankDepositName = "";
			
			$bankDepositBank = "";		//이체 은행명
			$bankDepositCheckType = 2; //수동수신 
		
		
			
		//트랜잭션 시작
		//주문 정보랑 아이템만 생성
		$this->db->insert('zd_pay_order', $order); //order
		$first_insert_id = $this->db->insert_id();
		foreach($order_item as $key => $item){
			$order_item[$key]['orderId'] = $first_insert_id;			
		}
		
		$this->db->insert_batch('zd_pay_order_item', $order_item); //order_item		
		//트랜잭션 엔드
		
		$result['status'] = true;
		$result['oid'] = $uniqid;
		return $result;
		
	}

	//포인트 구매
	function point_insert($cart_data, $order_data){
		$total = 0;
		$couponPrice = 0; //쿠폰 사용금액
		$useSavedMoney = 0; //사용 포인트
		$memberUserId = $this->session->userdata('member_user_id');
		$memberId = $this->session->userdata('mid');
		
		$i=0;
		foreach ($cart_data['product'] as $key => $cart) {
			
			//echo "i=>".$i++;
			
			//$cart_price = $cart['price'];
			//if($cart['eventPrice']>0) $cart_price = $cart['eventPrice'];
			
			$total = $total + $cart_data['total_price'];
			
			//쿠폰 아이디가 있으면
			if($order_data['couponId']){
				//$total = $total - $couponPrice; //쿠폰 가격만큼 제함
			}
			//포인트를 입력 했으면
			//쿠폰 제한 가격이 0원 이상 일때만
			if($order_data['point'] && $total > 0 ){
				//$total = $total - $order_data['point'];
								
				//총 가격 2000 포인트. 사용 10000만 일경우... 즉 포인트가 초과시
				if($total <0){
					//사용한 포인트에서 
					//남은 전채 금액을 제하면  사용 하고 남은 포인트
					//$useSavedMoney = $order_data['point'] - $total;
				}else{
					//그렇지 않으면 전액 사용됨
					//$useSavedMoney = $order_data['point']; 
				}
			}
			
			
			//포인트는 판매 가격이 0원임
			$in_data_item = array(
				'id' =>null,
				'orderId'=>null,
				'productId'=>$cart['id'],
				'categoryId'=>$cart['categoryId'],
				'categoryName'=>$this->_catename($cart['categoryId']),
				'name'=>$cart['name'], 
				'setsType'=>$cart['setsType'], 
				'runtime'=>$cart['runtime'], 
				'imageText'=>$cart['imageText'], 
				'movieText'=>$cart['movieText'], 
				'production'=>$cart['production'], 
				'originalMusic'=>$cart['originalMusic'], 
				'recommendMusic'=>$cart['recommendMusic'], 
				'price'=>$cart['price'], 
				'eventPrice'=>$cart['eventPrice'], 
				'savedMoney'=>0, 
				'resolution'=>'null| 1280 HD (16:9)', 
				'grade'=>$cart['grade'], 
				'genres'=>$cart['genres'], 
				'keywords'=>$cart['keywords'], 
				'shootingPlaces'=>null, 
				'imagePath'=>$cart['imagePath'], 
				'imageLFile'=>$cart['imageLFile'], 
				'imageMFile'=>$cart['imageMFile'], 
				'imageSFile'=>$cart['imageSFile'], 
				'imageNFile'=>$cart['imageNFile'], 
				'createDatetime'=>date("Y-m-d H:i:s"), 
				'preset1'=>$cart['preset1'], 
				'movieVimeoId'=>$cart['movieVimeoId'], 
				'preset2'=>$cart['preset2'], 
				'preset3'=>$cart['preset3'], 
				'preset4'=>$cart['preset4'], 
				'preset5'=>$cart['preset5'], 
				'preset6'=>$cart['preset6'],
			);
			$order_item[$key] = $in_data_item;
		}
		
		
		 
		 
		//echo "point=>".$order_data['point'];
		//echo "total=>".$total;
		if($order_data['point'] && $total > 0 ){
			$sum = $total - $order_data['point'];
		}
		
		
		$this -> db -> select_sum('money');
		$this -> db -> from('tb_member_saved_money');		
		$this -> db -> where('tb_member_saved_money.memberId', $memberId);
		$this -> db -> limit(1);
		$row_point = $this -> db -> get() -> row_array();
		
		$sum2 = $row_point['money'] - $order_data['point'];
		
		if($sum2 < 0) alert('보유 포인트가 부족합니다.','/order/form/');	
		if($sum > 0) alert('지불 포인트가 부족합니다.','/order/form/');
		if($sum < 0){
			 //초과 포인트는 상품 가격만 제외
			$useSavedMoney = $total;  
		}  
		
		
		$order = array(
				'id'=>null,
				 'price'=>0,
				 'savedMoney'=>0,
				 'useSavedMoney'=>$order_data['point'],
				 'usePartnerPoint'=>0,
				 'couponId'=>$order_data['couponId'],
				 'couponPrice'=>$couponPrice,
				 'device'=>$order_data['device'],
				 'memberId'=>$memberId,
				 'memberUserId'=>$memberUserId,
				 'memberPassword'=>$order_data['memberPassword'],
				 'memberName'=>$order_data['username'],
				 'memberTel'=>'',
				 'memberMobile'=>'',
				 'memberEmail'=>$order_data['email'],
				 'ip'=>$order_data['ip'],
				 'modifyDatetime'=>$order_data['modifyDatetime'],
				 'inflow'=>null,
				 'createDatetime'=>$order_data['createDatetime'],
				 'status'=>$order_data['status'],
				 'beforeStatus'=>$order_data['beforeStatus'],
				 'enable'=>1
 			);
			//echo $cart['id'];
		
		
		$order_payment = array(
							'id'=>null, 
							'oid'=>$order_data['oid'], 
							'orderId'=>0, 
							'payId'=>$order_data['payId'], 
							'payMethod'=>$order_data['payMethod'], 
							'price'=>0,
							'resultCode'=>'00', 
							'resultMessage'=>'point', 
							'cardNo'=>'', 
							'cardCode'=>'', 
							'cardBankCode'=>'', 
							'cardInstallMent'=>'', 
							'bankCode'=>$order_data['pay_bank_code'], 
							'bankNo'=>$order_data['bankNo'], 
							'bankMemberName'=>$order_data['bankMemberName'], 
							'bankDepositName'=>$order_data['username'], 
							'bankDepositPrice'=>null, 
							'bankDepositBank'=>null, 
							'bankExpireDate'=>date("Ymd",strtotime("+7 day")), 
							'bankDepositCheckType'=>null, 
							'bankDepositDate'=>null, 
							'bankDepositTime'=>null, 
							'adminId'=>null,
							'memberName'=>null, 
							'memberMobile'=>null, 
							'memberEmail'=>null, 
							'confirmDatetime'=>date("YmdHis"), 
							'applyId'=>null, 
							'applyDate'=>date("Ymd"), 
							'applyTime'=>date("His"), 
							'cashReceiptIssueCode'=>null,
							'cashReceiptIssueResultCode'=>null, 
							'mobile'=>null, 
							'isSuccess'=>1, 
							'createDatetime'=>date("Y-m-d H:i:s")
						);


		//echo"order item =><br>";
		//echo "<pre>";
		//print_r($order_item);
		//echo "</pre>";
		//트랜잭션 시작
		
		$this->db->insert('tb_order', $order); //order
		$first_insert_id = $this->db->insert_id();
		
		//$first_insert_id = "000";
		
		foreach($order_item as $key => $item){
			$order_item[$key]['orderId'] = $first_insert_id;			
		}
		
		/*
		echo"order item =><br>";
		echo "<pre>";
		print_r($order_item);
		echo "</pre>";
		 */
		
		$order_payment['orderId'] = $first_insert_id;
		
		/*
		echo"<br>";
		echo "<pre>";
		print_r($order_payment);
		echo "</pre>";
		 * */
		
		$this->db->insert_batch('tb_order_item', $order_item); //order_item
		$this->db->insert('tb_order_payment', $order_payment); //order_payment
		
		//무비메이커 생성
		$this->db->select("*");
		$this->db->from("tb_order_item");
		$this->db->where("orderId",$first_insert_id);
		$order_item_row_data = $this -> db -> get() -> result_array();
		
		$movie_maker = array();
		foreach($order_item_row_data as $key => $item){
			$movie_maker[$key]['id'] = "B".$first_insert_id.$key;
			$movie_maker[$key]['orderId'] = $first_insert_id;
			$movie_maker[$key]['orderItemId'] = $item['id'];
			$movie_maker[$key]['memberId'] = $memberId;
			$movie_maker[$key]['isComplete'] = 0;
			$movie_maker[$key]['createDatetime'] = date("Y-m-d H:i:s"); 
		}
		
		//print_r($movie_maker);
		$this->db->insert_batch('tb_movie_maker', $movie_maker); //order_payment
		
		$date = date('Y-m-d H:i:s');
		//포인트 사용시 포인트 처리 - 포인트 구매는 무조건 처리
		//if($useSavedMoney){
			$point_data = array(
				'memberId'=>$memberId,
				'orderId'=>$first_insert_id,
				'name'=>'상품구매',
				'money'=> -$order_data['point'],
				'endDatetime'=>null,
				'createDatetime'=>$date
			);
			$this->db->insert('tb_member_saved_money',$point_data);
		//}
				
		//트랜잭션 엔드
		
		
		$result['status'] = true;
		$result['oid'] = $order_payment['orderId'];
		return $result;
	}
	

	//kakao
	function kakao_insert($cart_data, $order_data){
		$total = 0;
		$couponPrice = 0; //쿠폰 사용금액
		$useSavedMoney = 0; //사용 포인트
		$memberUserId = $this->session->userdata('member_user_id');
		$memberId = $this->session->userdata('mid');

		$i=0;
		foreach ($cart_data['product'] as $key => $cart) {
			$total = $total + $cart_data['total_price'];
			//쿠폰 아이디가 있으면
			if($order_data['couponId']){
				//$total = $total - $couponPrice; //쿠폰 가격만큼 제함
			}
			//포인트를 입력 했으면
			//쿠폰 제한 가격이 0원 이상 일때만
			if($order_data['point'] && $total > 0 ){
				//$total = $total - $order_data['point'];

				//총 가격 2000 포인트. 사용 10000만 일경우... 즉 포인트가 초과시
				if($total <0){
					//사용한 포인트에서
					//남은 전채 금액을 제하면  사용 하고 남은 포인트
					//$useSavedMoney = $order_data['point'] - $total;
				}else{
					//그렇지 않으면 전액 사용됨
					//$useSavedMoney = $order_data['point'];
				}
			}



			$in_data_item = array(
				'id' =>null,
				'orderId'=>null,
				'productId'=>$cart['id'],
				'categoryId'=>$cart['categoryId'],
				'categoryName'=>$this->_catename($cart['categoryId']),
				'name'=>$cart['name'],
				'setsType'=>$cart['setsType'],
				'runtime'=>$cart['runtime'],
				'imageText'=>$cart['imageText'],
				'movieText'=>$cart['movieText'],
				'production'=>$cart['production'],
				'originalMusic'=>$cart['originalMusic'],
				'recommendMusic'=>$cart['recommendMusic'],
				'price'=>$cart['price'],
				'eventPrice'=>$cart['eventPrice'],
				'savedMoney'=>0,
				'resolution'=>'null| 1280 HD (16:9)',
				'grade'=>$cart['grade'],
				'genres'=>$cart['genres'],
				'keywords'=>$cart['keywords'],
				'shootingPlaces'=>null,
				'imagePath'=>$cart['imagePath'],
				'imageLFile'=>$cart['imageLFile'],
				'imageMFile'=>$cart['imageMFile'],
				'imageSFile'=>$cart['imageSFile'],
				'imageNFile'=>$cart['imageNFile'],
				'createDatetime'=>date("Y-m-d H:i:s"),
				'preset1'=>$cart['preset1'],
				'movieVimeoId'=>$cart['movieVimeoId'],
				'preset2'=>$cart['preset2'],
				'preset3'=>$cart['preset3'],
				'preset4'=>$cart['preset4'],
				'preset5'=>$cart['preset5'],
				'preset6'=>$cart['preset6'],
			);
			$order_item[$key] = $in_data_item;
		}




		//echo "point=>".$order_data['point'];
		//echo "total=>".$total;
		$sum = 0;
		if($order_data['point'] && $total > 0 ){
			$sum = $total - $order_data['point'];
		}


		$this -> db -> select_sum('money');
		$this -> db -> from('tb_member_saved_money');
		$this -> db -> where('tb_member_saved_money.memberId', $memberId);
		$this -> db -> limit(1);
		$row_point = $this -> db -> get() -> row_array();

		$sum2 = $row_point['money'] - $order_data['point'];

		if($sum2 < 0) alert('보유 포인트가 부족합니다.','/order/form/');
		if($sum > 0) alert('지불 포인트가 부족합니다.','/order/form/');
		if($sum < 0){
			 //초과 포인트는 상품 가격만 제외
			$useSavedMoney = $total;
		}


		$order = array(
				'id'=>null,
				 'price'=>$total,
				 'savedMoney'=>0,
				 'useSavedMoney'=>-$order_data['point'],
				 'usePartnerPoint'=>0,
				 'couponId'=>$order_data['couponId'],
				 'couponPrice'=>$couponPrice,
				 'device'=>$order_data['device'],
				 'memberId'=>$memberId,
				 'memberUserId'=>$memberUserId,
				 'memberPassword'=>$order_data['memberPassword'],
				 'memberName'=>$order_data['username'],
				 'memberTel'=>'',
				 'memberMobile'=>'',
				 'memberEmail'=>$order_data['email'],
				 'ip'=>$order_data['ip'],
				 'modifyDatetime'=>$order_data['modifyDatetime'],
				 'inflow'=>null,
				 'createDatetime'=>$order_data['createDatetime'],
				 'status'=>$order_data['status'],
				 'beforeStatus'=>$order_data['beforeStatus'],
				 'enable'=>1
 			);
			//echo $cart['id'];


		$order_payment = array(
							'id'=>null,
							'oid'=>$order_data['oid'],
							'orderId'=>0,
							'payId'=>$order_data['payId'],
							'payMethod'=>$order_data['payMethod'],
							'price'=>$total,
							'resultCode'=>'00',
							'resultMessage'=>'point',
							'cardNo'=>'',
							'cardCode'=>'',
							'cardBankCode'=>'',
							'cardInstallMent'=>'',
							'bankCode'=>$order_data['pay_bank_code'],
							'bankNo'=>$order_data['bankNo'],
							'bankMemberName'=>$order_data['bankMemberName'],
							'bankDepositName'=>$order_data['username'],
							'bankDepositPrice'=>null,
							'bankDepositBank'=>null,
							'bankExpireDate'=>date("Ymd",strtotime("+7 day")),
							'bankDepositCheckType'=>null,
							'bankDepositDate'=>null,
							'bankDepositTime'=>null,
							'adminId'=>null,
							'memberName'=>null,
							'memberMobile'=>null,
							'memberEmail'=>null,
							'confirmDatetime'=>date("YmdHis"),
							'applyId'=>null,
							'applyDate'=>date("Ymd"),
							'applyTime'=>date("His"),
							'cashReceiptIssueCode'=>null,
							'cashReceiptIssueResultCode'=>null,
							'mobile'=>null,
							'isSuccess'=>1,
							'createDatetime'=>date("Y-m-d H:i:s")
						);


		//echo"order item =><br>";
		//echo "<pre>";
		//print_r($order_item);
		//echo "</pre>";
		//트랜잭션 시작

		$this->db->insert('tb_order', $order); //order
		$first_insert_id = $this->db->insert_id();

		//$first_insert_id = "000";

		foreach($order_item as $key => $item){
			$order_item[$key]['orderId'] = $first_insert_id;
		}

		/*
		echo"order item =><br>";
		echo "<pre>";
		print_r($order_item);
		echo "</pre>";
		 */

		$order_payment['orderId'] = $first_insert_id;

		/*
		echo"<br>";
		echo "<pre>";
		print_r($order_payment);
		echo "</pre>";
		 * */

		$this->db->insert_batch('tb_order_item', $order_item); //order_item
		$this->db->insert('tb_order_payment', $order_payment); //order_payment

		//무비메이커 생성
		$this->db->select("*");
		$this->db->from("tb_order_item");
		$this->db->where("orderId",$first_insert_id);
		$order_item_row_data = $this -> db -> get() -> result_array();

		$movie_maker = array();
		foreach($order_item_row_data as $key => $item){
			$movie_maker[$key]['id'] = "B".$first_insert_id.$key;
			$movie_maker[$key]['orderId'] = $first_insert_id;
			$movie_maker[$key]['orderItemId'] = $item['id'];
			$movie_maker[$key]['memberId'] = $memberId;
			$movie_maker[$key]['isComplete'] = 0;
			$movie_maker[$key]['createDatetime'] = date("Y-m-d H:i:s");
		}

		//print_r($movie_maker);
		$this->db->insert_batch('tb_movie_maker', $movie_maker); //order_payment

		$date = date('Y-m-d H:i:s');
		//포인트 사용시 포인트 처리 - 포인트 구매는 무조건 처리
		if($useSavedMoney){
			$point_data = array(
				'memberId'=>$memberId,
				'orderId'=>$first_insert_id,
				'name'=>'상품구매',
				'money'=> -$order_data['point'],
				'endDatetime'=>null,
				'createDatetime'=>$date
			);
			$this->db->insert('tb_member_saved_money',$point_data);
		}

		//트랜잭션 엔드


		$result['status'] = true;
		$result['oid'] = $order_payment['orderId'];
		return $result;
	}


	//페이팔 구매 
	//사용 안함 TR 방식 --
	function paypal_insert($cart_data, $order_data){
		$total = 0;
		$couponPrice = 0; //쿠폰 사용금액
		$useSavedMoney = 0; //사용 포인트
		
		$i=0;
		foreach ($cart_data['product'] as $key => $cart) {			
			$total = $total + $cart_data['total_price'];
			
			//쿠폰 아이디가 있으면
			if($order_data['couponId']){
				//$total = $total - $couponPrice; //쿠폰 가격만큼 제함
			}
			//포인트를 입력 했으면
			//쿠폰 제한 가격이 0원 이상 일때만
			if($order_data['point'] && $total > 0 ){
				//$total = $total - $order_data['point'];
								
				//총 가격 2000 포인트. 사용 10000만 일경우... 즉 포인트가 초과시
				if($total <0){
					//사용한 포인트에서 
					//남은 전채 금액을 제하면  사용 하고 남은 포인트
					//$useSavedMoney = $order_data['point'] - $total;
				}else{
					//그렇지 않으면 전액 사용됨
					//$useSavedMoney = $order_data['point']; 
				}
			}
			
			
			
			$in_data_item = array(
				'id' =>null,
				'orderId'=>null,
				'productId'=>$cart['id'],
				'categoryId'=>$cart['categoryId'],
				'categoryName'=>$this->_catename($cart['categoryId']),
				'name'=>$cart['name'], 
				'setsType'=>$cart['setsType'], 
				'runtime'=>$cart['runtime'], 
				'imageText'=>$cart['imageText'], 
				'movieText'=>$cart['movieText'], 
				'production'=>$cart['production'], 
				'originalMusic'=>$cart['originalMusic'], 
				'recommendMusic'=>$cart['recommendMusic'], 
				'price'=>$cart['price'], 
				'eventPrice'=>$cart['eventPrice'], 
				'savedMoney'=>0, 
				'resolution'=>'null| 1280 HD (16:9)', 
				'grade'=>$cart['grade'], 
				'genres'=>$cart['genres'], 
				'keywords'=>$cart['keywords'], 
				'shootingPlaces'=>null, 
				'imagePath'=>$cart['imagePath'], 
				'imageLFile'=>$cart['imageLFile'], 
				'imageMFile'=>$cart['imageMFile'], 
				'imageSFile'=>$cart['imageSFile'], 
				'imageNFile'=>$cart['imageNFile'], 
				'createDatetime'=>date("Y-m-d H:i:s"), 
				'preset1'=>$cart['preset1'], 
				'movieVimeoId'=>$cart['movieVimeoId'], 
				'preset2'=>$cart['preset2'], 
				'preset3'=>$cart['preset3'], 
				'preset4'=>$cart['preset4'], 
				'preset5'=>$cart['preset5'], 
				'preset6'=>$cart['preset6'],
			);
			$order_item[$key] = $in_data_item;
		}
		
		$memberId = $this->session->userdata['mid'];
		
				
		$order = array(
				'id'=>null,
				 'price'=>$total,
				 'savedMoney'=>0,
				 'useSavedMoney'=>$useSavedMoney,
				 'usePartnerPoint'=>0,
				 'couponId'=>$order_data['couponId'],
				 'couponPrice'=>$couponPrice,
				 'device'=>$order_data['device'],
				 'memberId'=>$memberId,
				 'memberUserId'=>'',
				 'memberPassword'=>$order_data['memberPassword'],
				 'memberName'=>$order_data['username'],
				 'memberTel'=>'',
				 'memberMobile'=>'',
				 'memberEmail'=>$order_data['email'],
				 'ip'=>$order_data['ip'],
				 'modifyDatetime'=>$order_data['modifyDatetime'],
				 'inflow'=>null,
				 'createDatetime'=>$order_data['createDatetime'],
				 'status'=>$order_data['status'],
				 'beforeStatus'=>$order_data['beforeStatus'],
				 'enable'=>1
 			);
			//echo $cart['id'];
		
		
		$order_payment = array(
							'id'=>null, 
							'oid'=>$order_data['oid'], 
							'orderId'=>0, 
							'payId'=>$order_data['payId'], 
							'payMethod'=>$order_data['payMethod'], 
							'price'=>$total, 
							'resultCode'=>'00', 
							'resultMessage'=>'point', 
							'cardNo'=>'', 
							'cardCode'=>'', 
							'cardBankCode'=>'', 
							'cardInstallMent'=>'', 
							'bankCode'=>$order_data['pay_bank_code'], 
							'bankNo'=>$order_data['bankNo'], 
							'bankMemberName'=>$order_data['bankMemberName'], 
							'bankDepositName'=>$order_data['username'], 
							'bankDepositPrice'=>null, 
							'bankDepositBank'=>null, 
							'bankExpireDate'=>date("Ymd",strtotime("+7 day")), 
							'bankDepositCheckType'=>null, 
							'bankDepositDate'=>null, 
							'bankDepositTime'=>null, 
							'adminId'=>null,
							'memberName'=>null, 
							'memberMobile'=>null, 
							'memberEmail'=>null, 
							'confirmDatetime'=>date("YmdHis"), 
							'applyId'=>null, 
							'applyDate'=>date("Ymd"), 
							'applyTime'=>date("His"), 
							'cashReceiptIssueCode'=>null,
							'cashReceiptIssueResultCode'=>null, 
							'mobile'=>null, 
							'isSuccess'=>1, 
							'createDatetime'=>date("Y-m-d H:i:s")
						);


		//echo"order item =><br>";
		//echo "<pre>";
		//print_r($order);
		//echo "</pre>";
		//트랜잭션 시작
		
		$this->db->insert('tb_order', $order); //order
		$first_insert_id = $this->db->insert_id();
		
		//$first_insert_id = "000";
		
		foreach($order_item as $key => $item){
			$order_item[$key]['orderId'] = $first_insert_id;			
		}
		
		/*
		echo"order item =><br>";
		echo "<pre>";
		print_r($order_item);
		echo "</pre>";
		 */
		
		$order_payment['orderId'] = $first_insert_id;
		
		/*
		echo"<br>";
		echo "<pre>";
		print_r($order_payment);
		echo "</pre>";
		 * */
		
		$this->db->insert_batch('tb_order_item', $order_item); //order_item
		$this->db->insert('tb_order_payment', $order_payment); //order_payment
		
		//무비메이커 ㅅㅇ성
		$this->db->select("*");
		$this->db->from("tb_order_item");
		$this->db->where("orderId",$first_insert_id);
		$order_item_row_data = $this -> db -> get() -> result_array();
		
		$movie_maker = array();
		foreach($order_item_row_data as $key => $item){
			$movie_maker[$key]['id'] = "B".$first_insert_id.$key;
			$movie_maker[$key]['orderId'] = $first_insert_id;
			$movie_maker[$key]['orderItemId'] = $item['id'];
			$movie_maker[$key]['memberId'] = $memberId;
			$movie_maker[$key]['isComplete'] = 0;
			$movie_maker[$key]['createDatetime'] = date("Y-m-d H:i:s"); 
		}
		
		//print_r($movie_maker);
		$this->db->insert_batch('tb_movie_maker', $movie_maker); //order_payment
		
		$date = date('Y-m-d H:i:s');
		//포인트 사용시 포인트 처리
		if($useSavedMoney){
			$point_data = array(
				'memberId'=>$memberId,
				'orderId'=>null,
				'name'=>'상품구매',
				'money'=> -$useSavedMoney,
				'endDatetime'=>null,
				'createDatetime'=>$date
			);
			$this->db->insert('tb_member_saved_money',$point_data);
		}
				
		//트랜잭션 엔드
		
		$result['status'] = true;
		$result['oid'] = $order_payment['orderId'];		
		return $result;
	}

	//테섭용 --
	function paypal_noti_t($invoice){
		
		log_message("debug","model paypal noti t");
		$TEST = $this->load->database('test', TRUE);//test 고정
		
		$TEST->from("zd_pay_order");
		$TEST->where("p_oid",$invoice);
		$db_order  = $TEST->get()->row_array();
		
		//$first_insert_id = $db_order["id"];
		
		$TEST->from("zd_pay_order_item");
		$TEST->where("orderId",$db_order["id"]);
		$db_item  = $TEST->get()->result_array();
		
		//호출 하고 나서 해당 invoice 값 삭제
		//log_message("debug","model paypal noti oid = ".$first_insert_id);
		//$TEST->delete();
		
		
		$order = array(
				'id'=>null,
				 'price'=>$db_order['price'],
				 'savedMoney'=>$db_order['savedMoney'],
				 'useSavedMoney'=>$db_order['useSavedMoney'],
				 'usePartnerPoint'=>0,
				 'couponId'=>$db_order['couponId'],
				 'couponPrice'=>$db_order['couponPrice'],
				 'device'=>$db_order['device'],
				 'memberId'=>$db_order['memberId'],
				 'memberUserId'=>$db_order['memberUserId'],
				 'memberPassword'=>$db_order['memberPassword'],
				 'memberName'=>$db_order['memberName'],
				 'memberTel'=>$db_order['memberTel'],
				 'memberMobile'=>$db_order['memberMobile'],
				 'memberEmail'=>$db_order['memberEmail'],
				 'ip'=>$db_order['ip'],
				 'modifyDatetime'=>$db_order['modifyDatetime'],
				 'inflow'=>null,
				 'createDatetime'=>$db_order['createDatetime'],
				 'status'=>$db_order['status'],
				 'beforeStatus'=>$db_order['beforeStatus'],
				 'enable'=>1
 			);
			
			$TEST->insert('tb_order', $order); //order
			$first_insert_id = $TEST->insert_id();
			
			//id ,price, eventPrice, imagePath, imageSFile
			//$cart_data['product'] = $db_item;
			//$cart_data['product']['id'] =$db_item[0]['productId'];
			 
			foreach($db_item as $key => $cart){
				$cart_data['product'][$key]['id'] = $first_insert_id;
				$cart_data['product'][$key]['price'] = $cart['price'];
				$cart_data['product'][$key]['eventPrice'] = $cart['eventPrice'];
				$cart_data['product'][$key]['imagePath'] = $cart['imagePath'];
				$cart_data['product'][$key]['imageSFile'] = $cart['imageSFile'];
				$cart_data['product'][$key]['name'] = $cart['name'];
				
							
				$in_data_item = array(
						
						'orderId'=>$first_insert_id,
						'productId'=>$cart['productId'],
						'categoryId'=>$cart['categoryId'],
						'categoryName'=>$this->_catename($cart['categoryId']),
						'name'=>$cart['name'], 
						'setsType'=>$cart['setsType'], 
						'runtime'=>$cart['runtime'], 
						'imageText'=>$cart['imageText'], 
						'movieText'=>$cart['movieText'], 
						'production'=>$cart['production'], 
						'originalMusic'=>$cart['originalMusic'], 
						'recommendMusic'=>$cart['recommendMusic'], 
						'price'=>$cart['price'], 
						'eventPrice'=>$cart['eventPrice'], 
						'savedMoney'=>0, 
						'resolution'=>'null| 1280 HD (16:9)', 
						'grade'=>$cart['grade'], 
						'genres'=>$cart['genres'], 
						'keywords'=>$cart['keywords'], 
						'shootingPlaces'=>null, 
						'imagePath'=>$cart['imagePath'], 
						'imageLFile'=>$cart['imageLFile'], 
						'imageMFile'=>$cart['imageMFile'], 
						'imageSFile'=>$cart['imageSFile'], 
						'imageNFile'=>$cart['imageNFile'], 
						'createDatetime'=>date("Y-m-d H:i:s"), 
						'preset1'=>$cart['preset1'], 
						'movieVimeoId'=>$cart['movieVimeoId'], 
						'preset2'=>$cart['preset2'], 
						'preset3'=>$cart['preset3'], 
						'preset4'=>$cart['preset4'], 
						'preset5'=>$cart['preset5'], 
						'preset6'=>$cart['preset6'],
					);
					$order_item[$key] = $in_data_item;
					
					    
			}

		$order_payment = array(
							'id'=>null, 
							'oid'=>$invoice, 
							'orderId'=>$first_insert_id, 
							'payId'=>$invoice, 
							'payMethod'=>'paypal', 
							'price'=>$db_order['price'], 
							'resultCode'=>'00', 
							'resultMessage'=>'paypal', 
							'cardNo'=>'', 
							'cardCode'=>'', 
							'cardBankCode'=>'', 
							'cardInstallMent'=>'', 
							'bankCode'=>'', 
							'bankNo'=>'', 
							'bankMemberName'=>'', 
							'bankDepositName'=>'', 
							'bankDepositPrice'=>null, 
							'bankDepositBank'=>null, 
							'bankExpireDate'=>date("Ymd",strtotime("+7 day")), 
							'bankDepositCheckType'=>null, 
							'bankDepositDate'=>null, 
							'bankDepositTime'=>null, 
							'adminId'=>null,
							'memberName'=>null, 
							'memberMobile'=>null, 
							'memberEmail'=>null, 
							'confirmDatetime'=>date("YmdHis"), 
							'applyId'=>null, 
							'applyDate'=>date("Ymd"), 
							'applyTime'=>date("His"), 
							'cashReceiptIssueCode'=>null,
							'cashReceiptIssueResultCode'=>null, 
							'mobile'=>null, 
							'isSuccess'=>1, 
							'createDatetime'=>date("Y-m-d H:i:s")
						);
			
		
		$TEST->insert_batch('tb_order_item', $order_item); //order_item
		$TEST->insert('tb_order_payment', $order_payment); //order_payment
		
		
		
		//저장한것을 불러
		$TEST->from("tb_order_item");
		$TEST->where("orderId",$first_insert_id);
		$return_order_item  = $TEST->get()->result_array();
		
		$movie_maker = array();
		foreach($return_order_item as $key => $item){
			$movie_maker[$key]['id'] = "B".$first_insert_id.$key;
			$movie_maker[$key]['orderId'] = $first_insert_id;
			$movie_maker[$key]['orderItemId'] = $item['id'];
			$movie_maker[$key]['memberId'] = $db_order['memberId'];
			$movie_maker[$key]['isComplete'] = 0;
			$movie_maker[$key]['createDatetime'] = date("Y-m-d H:i:s"); 
		}

		
		//print_r($movie_maker);
		$TEST->insert_batch('tb_movie_maker', $movie_maker); //order_payment
		
		
			$send_email = $db_order['memberEmail']; //받을 이메일
			$oid = $first_insert_id; //주문번호
			//$point = 0; //사용포인트
			$pay_type = 'paypal'; //결제 방법
			$payment = $db_order['price']; //최종 결제액
			$point = 0;
			

			$fin_is_member = '비회원';
			if($db_order['memberId']) $fin_is_member = '회원';
			
			
			
			//메일 발송		
			$this->temp_email->order_fin_mail_send($send_email, $oid, $point, $pay_type, $payment, $fin_is_member, $cart_data);
			
				
	}
	
	
	//모바일 사이트 용
	//pin 방식 결재
	function paypal_noti_m($invoice){
		
		log_message("debug","model paypal noti m");
		
		//$TEST = $this->load->database(WEB_DB, TRUE);//real 고정
		$this->db->from("zd_pay_order");
		$this->db->where("p_oid",$invoice);
		$db_order  = $this->db->get()->row_array();
		
		//$first_insert_id = $db_order["id"];
		
		$this->db->from("zd_pay_order_item");
		$this->db->where("orderId",$db_order["id"]);
		$db_item  = $this->db->get()->result_array();
		
		//호출 하고 나서 해당 invoice 값 삭제
		//log_message("debug","model paypal noti oid = ".$first_insert_id);
		//$TEST->delete();
		
		
		$order = array(
				'id'=>null,
				 'price'=>$db_order['price'],
				 'savedMoney'=>$db_order['savedMoney'],
				 'useSavedMoney'=>$db_order['useSavedMoney'],
				 'usePartnerPoint'=>0,
				 'couponId'=>$db_order['couponId'],
				 'couponPrice'=>$db_order['couponPrice'],
				 'device'=>$db_order['device'],
				 'memberId'=>$db_order['memberId'],
				 'memberUserId'=>$db_order['memberUserId'],
				 'memberPassword'=>$db_order['memberPassword'],
				 'memberName'=>$db_order['memberName'],
				 'memberTel'=>$db_order['memberTel'],
				 'memberMobile'=>$db_order['memberMobile'],
				 'memberEmail'=>$db_order['memberEmail'],
				 'ip'=>$db_order['ip'],
				 'modifyDatetime'=>$db_order['modifyDatetime'],
				 'inflow'=>null,
				 'createDatetime'=>$db_order['createDatetime'],
				 'status'=>$db_order['status'],
				 'beforeStatus'=>$db_order['beforeStatus'],
				 'enable'=>1,
				 'p_oid' => $invoice
 			);
			
			$this->db->insert('tb_order', $order); //order
			$first_insert_id = $this->db->insert_id();
			
			//id ,price, eventPrice, imagePath, imageSFile
			//$cart_data['product'] = $db_item;
			//$cart_data['product']['id'] =$db_item[0]['productId'];
			 
			foreach($db_item as $key => $cart){
				$cart_data['product'][$key]['id'] = $first_insert_id;
				$cart_data['product'][$key]['price'] = $cart['price'];
				$cart_data['product'][$key]['eventPrice'] = $cart['eventPrice'];
				$cart_data['product'][$key]['imagePath'] = $cart['imagePath'];
				$cart_data['product'][$key]['imageSFile'] = $cart['imageSFile'];
				$cart_data['product'][$key]['name'] = $cart['name'];
				
							
				$in_data_item = array(
						
						'orderId'=>$first_insert_id,
						'productId'=>$cart['productId'],
						'categoryId'=>$cart['categoryId'],
						'categoryName'=>$this->_catename($cart['categoryId']),
						'name'=>$cart['name'], 
						'setsType'=>$cart['setsType'], 
						'runtime'=>$cart['runtime'], 
						'imageText'=>$cart['imageText'], 
						'movieText'=>$cart['movieText'], 
						'production'=>$cart['production'], 
						'originalMusic'=>$cart['originalMusic'], 
						'recommendMusic'=>$cart['recommendMusic'], 
						'price'=>$cart['price'], 
						'eventPrice'=>$cart['eventPrice'], 
						'savedMoney'=>0, 
						'resolution'=>'null| 1280 HD (16:9)', 
						'grade'=>$cart['grade'], 
						'genres'=>$cart['genres'], 
						'keywords'=>$cart['keywords'], 
						'shootingPlaces'=>null, 
						'imagePath'=>$cart['imagePath'], 
						'imageLFile'=>$cart['imageLFile'], 
						'imageMFile'=>$cart['imageMFile'], 
						'imageSFile'=>$cart['imageSFile'], 
						'imageNFile'=>$cart['imageNFile'], 
						'createDatetime'=>date("Y-m-d H:i:s"), 
						'preset1'=>$cart['preset1'], 
						'movieVimeoId'=>$cart['movieVimeoId'], 
						'preset2'=>$cart['preset2'], 
						'preset3'=>$cart['preset3'], 
						'preset4'=>$cart['preset4'], 
						'preset5'=>$cart['preset5'], 
						'preset6'=>$cart['preset6'],
					);
					$order_item[$key] = $in_data_item;
					
					    
			}

		$order_payment = array(
							'id'=>null, 
							'oid'=>$invoice, 
							'orderId'=>$first_insert_id, 
							'payId'=>$invoice, 
							'payMethod'=>'paypal', 
							'price'=>$db_order['price'], 
							'resultCode'=>'00', 
							'resultMessage'=>'paypal', 
							'cardNo'=>'', 
							'cardCode'=>'', 
							'cardBankCode'=>'', 
							'cardInstallMent'=>'', 
							'bankCode'=>'', 
							'bankNo'=>'', 
							'bankMemberName'=>'', 
							'bankDepositName'=>'', 
							'bankDepositPrice'=>null, 
							'bankDepositBank'=>null, 
							'bankExpireDate'=>date("Ymd",strtotime("+7 day")), 
							'bankDepositCheckType'=>null, 
							'bankDepositDate'=>null, 
							'bankDepositTime'=>null, 
							'adminId'=>null,
							'memberName'=>null, 
							'memberMobile'=>null, 
							'memberEmail'=>null, 
							'confirmDatetime'=>date("YmdHis"), 
							'applyId'=>null, 
							'applyDate'=>date("Ymd"), 
							'applyTime'=>date("His"), 
							'cashReceiptIssueCode'=>null,
							'cashReceiptIssueResultCode'=>null, 
							'mobile'=>null, 
							'isSuccess'=>1, 
							'createDatetime'=>date("Y-m-d H:i:s")
						);
			
		
		$this->db->insert_batch('tb_order_item', $order_item); //order_item
		$this->db->insert('tb_order_payment', $order_payment); //order_payment
		
		
		
		//저장한것을 불러
		$this->db->from("tb_order_item");
		$this->db->where("orderId",$first_insert_id);
		$return_order_item  = $this->db->get()->result_array();
		
		$movie_maker = array();
		foreach($return_order_item as $key => $item){
			$movie_maker[$key]['id'] = "B".$first_insert_id.$key;
			$movie_maker[$key]['orderId'] = $first_insert_id;
			$movie_maker[$key]['orderItemId'] = $item['id'];
			$movie_maker[$key]['memberId'] = $db_order['memberId'];
			$movie_maker[$key]['isComplete'] = 0;
			$movie_maker[$key]['createDatetime'] = date("Y-m-d H:i:s"); 
		}

		
		//print_r($movie_maker);
		$this->db->insert_batch('tb_movie_maker', $movie_maker); //order_payment
		
		
			$send_email = $db_order['memberEmail']; //받을 이메일
			$oid = $first_insert_id; //주문번호
			//$point = 0; //사용포인트
			$pay_type = 'paypal'; //결제 방법
			$payment = $db_order['price']; //최종 결제액
			$point = 0;
			

			$fin_is_member = '비회원';
			if($db_order['memberId']) $fin_is_member = '회원';
			
			
			
			//메일 발송		
			$this->temp_email->order_fin_mail_send($send_email, $oid, $point, $pay_type, $payment, $fin_is_member, $cart_data);
			
				
	}
	
	
	//실섭용
	function paypal_noti_p($invoice){
		
		log_message("debug","model paypal noti p");
		$TEST = $this->load->database('real', TRUE);//real 고정
		
		$TEST->from("zd_pay_order");
		$TEST->where("p_oid",$invoice);
		$db_order  = $TEST->get()->row_array();
		
		//$first_insert_id = $db_order["id"];
		
		$TEST->from("zd_pay_order_item");
		$TEST->where("orderId",$db_order["id"]);
		$db_item  = $TEST->get()->result_array();
		
		//호출 하고 나서 해당 invoice 값 삭제
		//log_message("debug","model paypal noti oid = ".$first_insert_id);
		//$TEST->delete();
		
		
		$order = array(
				'id'=>null,
				 'price'=>$db_order['price'],
				 'savedMoney'=>$db_order['savedMoney'],
				 'useSavedMoney'=>$db_order['useSavedMoney'],
				 'usePartnerPoint'=>0,
				 'couponId'=>$db_order['couponId'],
				 'couponPrice'=>$db_order['couponPrice'],
				 'device'=>$db_order['device'],
				 'memberId'=>$db_order['memberId'],
				 'memberUserId'=>$db_order['memberUserId'],
				 'memberPassword'=>$db_order['memberPassword'],
				 'memberName'=>$db_order['memberName'],
				 'memberTel'=>$db_order['memberTel'],
				 'memberMobile'=>$db_order['memberMobile'],
				 'memberEmail'=>$db_order['memberEmail'],
				 'ip'=>$db_order['ip'],
				 'modifyDatetime'=>$db_order['modifyDatetime'],
				 'inflow'=>null,
				 'createDatetime'=>$db_order['createDatetime'],
				 'status'=>$db_order['status'],
				 'beforeStatus'=>$db_order['beforeStatus'],
				 'enable'=>1
 			);
			
			$TEST->insert('tb_order', $order); //order
			$first_insert_id = $TEST->insert_id();
			
			//id ,price, eventPrice, imagePath, imageSFile
			//$cart_data['product'] = $db_item;
			//$cart_data['product']['id'] =$db_item[0]['productId'];
			 
			foreach($db_item as $key => $cart){
				$cart_data['product'][$key]['id'] = $first_insert_id;
				$cart_data['product'][$key]['price'] = $cart['price'];
				$cart_data['product'][$key]['eventPrice'] = $cart['eventPrice'];
				$cart_data['product'][$key]['imagePath'] = $cart['imagePath'];
				$cart_data['product'][$key]['imageSFile'] = $cart['imageSFile'];
				$cart_data['product'][$key]['name'] = $cart['name'];
				
							
				$in_data_item = array(
						
						'orderId'=>$first_insert_id,
						'productId'=>$cart['productId'],
						'categoryId'=>$cart['categoryId'],
						'categoryName'=>$this->_catename($cart['categoryId']),
						'name'=>$cart['name'], 
						'setsType'=>$cart['setsType'], 
						'runtime'=>$cart['runtime'], 
						'imageText'=>$cart['imageText'], 
						'movieText'=>$cart['movieText'], 
						'production'=>$cart['production'], 
						'originalMusic'=>$cart['originalMusic'], 
						'recommendMusic'=>$cart['recommendMusic'], 
						'price'=>$cart['price'], 
						'eventPrice'=>$cart['eventPrice'], 
						'savedMoney'=>0, 
						'resolution'=>'null| 1280 HD (16:9)', 
						'grade'=>$cart['grade'], 
						'genres'=>$cart['genres'], 
						'keywords'=>$cart['keywords'], 
						'shootingPlaces'=>null, 
						'imagePath'=>$cart['imagePath'], 
						'imageLFile'=>$cart['imageLFile'], 
						'imageMFile'=>$cart['imageMFile'], 
						'imageSFile'=>$cart['imageSFile'], 
						'imageNFile'=>$cart['imageNFile'], 
						'createDatetime'=>date("Y-m-d H:i:s"), 
						'preset1'=>$cart['preset1'], 
						'movieVimeoId'=>$cart['movieVimeoId'], 
						'preset2'=>$cart['preset2'], 
						'preset3'=>$cart['preset3'], 
						'preset4'=>$cart['preset4'], 
						'preset5'=>$cart['preset5'], 
						'preset6'=>$cart['preset6'],
					);
					$order_item[$key] = $in_data_item;
					
					    
			}

		$order_payment = array(
							'id'=>null, 
							'oid'=>$invoice, 
							'orderId'=>$first_insert_id, 
							'payId'=>$invoice, 
							'payMethod'=>'paypal', 
							'price'=>$db_order['price'], 
							'resultCode'=>'00', 
							'resultMessage'=>'paypal', 
							'cardNo'=>'', 
							'cardCode'=>'', 
							'cardBankCode'=>'', 
							'cardInstallMent'=>'', 
							'bankCode'=>'', 
							'bankNo'=>'', 
							'bankMemberName'=>'', 
							'bankDepositName'=>'', 
							'bankDepositPrice'=>null, 
							'bankDepositBank'=>null, 
							'bankExpireDate'=>date("Ymd",strtotime("+7 day")), 
							'bankDepositCheckType'=>null, 
							'bankDepositDate'=>null, 
							'bankDepositTime'=>null, 
							'adminId'=>null,
							'memberName'=>null, 
							'memberMobile'=>null, 
							'memberEmail'=>null, 
							'confirmDatetime'=>date("YmdHis"), 
							'applyId'=>null, 
							'applyDate'=>date("Ymd"), 
							'applyTime'=>date("His"), 
							'cashReceiptIssueCode'=>null,
							'cashReceiptIssueResultCode'=>null, 
							'mobile'=>null, 
							'isSuccess'=>1, 
							'createDatetime'=>date("Y-m-d H:i:s")
						);
			
		
		$TEST->insert_batch('tb_order_item', $order_item); //order_item
		$TEST->insert('tb_order_payment', $order_payment); //order_payment
		
		
		
		//저장한것을 불러
		$TEST->from("tb_order_item");
		$TEST->where("orderId",$first_insert_id);
		$return_order_item  = $TEST->get()->result_array();
		
		$movie_maker = array();
		foreach($return_order_item as $key => $item){
			$movie_maker[$key]['id'] = "B".$first_insert_id.$key;
			$movie_maker[$key]['orderId'] = $first_insert_id;
			$movie_maker[$key]['orderItemId'] = $item['id'];
			$movie_maker[$key]['memberId'] = $db_order['memberId'];
			$movie_maker[$key]['isComplete'] = 0;
			$movie_maker[$key]['createDatetime'] = date("Y-m-d H:i:s"); 
		}

		
		//print_r($movie_maker);
		$TEST->insert_batch('tb_movie_maker', $movie_maker); //order_payment
		
		
			$send_email = $db_order['memberEmail']; //받을 이메일
			$oid = $first_insert_id; //주문번호
			//$point = 0; //사용포인트
			$pay_type = 'paypal'; //결제 방법
			$payment = $db_order['price']; //최종 결제액
			$point = 0;
			

			$fin_is_member = '비회원';
			if($db_order['memberId']) $fin_is_member = '회원';
			
			
			
			//메일 발송		
			$this->temp_email->order_fin_mail_send($send_email, $oid, $point, $pay_type, $payment, $fin_is_member, $cart_data);
			
				
	}
	
	//
	 
	function ajax_mpaypal_init_save($cart_data, $order_data){
		
		//$this->db = $this->load->database(WEB_DB, TRUE);//real 고정
		
		
		$total = 0;
		$couponPrice = 0; //쿠폰 사용금액
		$useSavedMoney = 0; //사용 포인트		
		$total = $order_data['total_price'];
		$invoice = $order_data['invoice']; 
		
		$memberId = null;
		if($this->session->userdata['mid']) $memberId = $this->session->userdata['mid'];
		$memberUserId = $this->session->userdata('member_user_id');
		
		$result['return_point'] = "T"; //포인트정상
		
		if($order_data['point'] > 0 ){
			$sum = $total - $order_data['point'];
			
			$this->db -> select_sum('money');
			$this->db -> from('tb_member_saved_money');
			$this->db -> where('tb_member_saved_money.memberId', $memberId);
			$this->db -> limit(1);
			$row_point = $this->db -> get() -> row_array();
			
			$sum2 = $row_point['money'] - $order_data['point'];
			
			//if($sum2 < 0) alert('보유 포인트가 부족합니다.','/order/form/');
			
			if($sum2 < 0) $result['return_point'] = "F"; //포인트 부족 
			
			if($sum < 0){
				 //초과 포인트는 상품 가격만 제외
				$useSavedMoney = $total;  
			} 
		
		}
		
		foreach ($cart_data['product'] as $key => $cart) {
			//이니시스는 쿠폰과 포인트를 사전 결제 끝내고 나서 계산된 토탈 금액으로 한다
			
						
			$in_data_item = array(
				'id' =>null,
				'orderId'=>null,
				'productId'=>$cart['id'],
				'categoryId'=>$cart['categoryId'],
				'categoryName'=>$this->_catename($cart['categoryId']),
				'name'=>$cart['name'], 
				'setsType'=>$cart['setsType'], 
				'runtime'=>$cart['runtime'], 
				'imageText'=>$cart['imageText'], 
				'movieText'=>$cart['movieText'], 
				'production'=>$cart['production'], 
				'originalMusic'=>$cart['originalMusic'], 
				'recommendMusic'=>$cart['recommendMusic'], 
				'price'=>$cart['price'], 
				'eventPrice'=>$cart['eventPrice'], 
				'savedMoney'=>0, 
				'resolution'=>'null| 1280 HD (16:9)', 
				'grade'=>$cart['grade'], 
				'genres'=>$cart['genres'], 
				'keywords'=>$cart['keywords'], 
				'shootingPlaces'=>null, 
				'imagePath'=>$cart['imagePath'], 
				'imageLFile'=>$cart['imageLFile'], 
				'imageMFile'=>$cart['imageMFile'], 
				'imageSFile'=>$cart['imageSFile'], 
				'imageNFile'=>$cart['imageNFile'], 
				'createDatetime'=>date("Y-m-d H:i:s"), 
				'preset1'=>$cart['preset1'], 
				'movieVimeoId'=>$cart['movieVimeoId'], 
				'preset2'=>$cart['preset2'], 
				'preset3'=>$cart['preset3'], 
				'preset4'=>$cart['preset4'], 
				'preset5'=>$cart['preset5'], 
				'preset6'=>$cart['preset6'],
			);
			$order_item[$key] = $in_data_item;
		}
		
		$uniqid = uniqid(time());		
		
		$order = array(
				'id'=>							null,
				 'price'=>						$total,
				 'savedMoney'=>					0,
				 'useSavedMoney'=>				-$order_data['point'],
				 'usePartnerPoint'=>			0,
				 'couponId'=>					$order_data['couponId'],
				 'couponPrice'=>				$couponPrice,
				 'device'=>						$order_data['device'],
				 'memberId'=>					$memberId,
				 'memberUserId'=>				$memberUserId,
				 'memberPassword'=>				$order_data['memberPassword'],
				 'memberName'=>					$order_data['username'],
				 'memberTel'=>					'',
				 'memberMobile'=>				'',
				 'memberEmail'=>				$order_data['email'],
				 'ip'=>							$order_data['ip'],
				 'modifyDatetime'=>				$order_data['modifyDatetime'],
				 'inflow'=>						null,
				 'createDatetime'=>				$order_data['createDatetime'],
				 'status'=>						$order_data['status'],
				 'beforeStatus'=>				$order_data['beforeStatus'],
				 'enable'=>						1,
				 'p_oid' =>						$invoice,
				 'type' => 'paypal'
 			);
			//echo $cart['id'];
		
		
			$isSuccess = 0;
			$cardNo = "";
			$cardCode = "";
			$cardBankCode = "";
			$cardInstallMent = "";
			
			
			$bankCode = "";
			$bankNo = "";
			$bankMemberName = "주식회사 위드비디오";		//
			$bankDepositName = "";
			
			$bankDepositBank = "";		//이체 은행명
			$bankDepositCheckType = 2; //수동수신 
		
		
			
		//트랜잭션 시작
		//주문 정보랑 아이템만 생성
		$this->db->insert('zd_pay_order', $order); //order
		$first_insert_id = $this->db->insert_id();
		foreach($order_item as $key => $item){
			$order_item[$key]['orderId'] = $first_insert_id;			
		}
		
		$this->db->insert_batch('zd_pay_order_item', $order_item); //order_item
		//트랜잭션 엔드
		
		$result['status'] = true;
		$result['oid'] = $uniqid;
		return $result;
		
	}
	
	//paypal chk
	function palpay_invoice_chk($invoice){
		$this->db = $this->load->database(WEB_DB, TRUE);//real 고정
		$this->db->from("tb_order");
		$this->db->where("p_oid",$invoice);
		return $this->db->get();
	} 
}
