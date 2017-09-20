<?
class Api_model extends CI_Model {
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
	
	//무비메이커 첫 호출... 무비메이커 시작 전에 ajax로 날림
	function movie_first_data($input)
	{
		$this->db->from('tb_order');
		$this->db->where('id',$input['orderId']);
		$this->db->where('status', "02"); //02인경우만
		$sql = $this->db->get();
		if($sql->num_rows() >= 1){

			$this->db->trans_start(); //트랜잭션 스타트
			$this->db->where("id",$input['orderId']); //해당 아이디 업데이트
			$this->db->update('tb_order',array("status"=>"03"));

			//한개더
			$this->db->where("orderId",$input['orderId']); //해당 아이디 업데이트
			$this->db->update('tb_movie_maker',array("modifyDatetime"=>date("Y-m-d H:i:s")));
			$this->db->trans_complete(); //트랜잭션 엔드
			$result['status'] = $this->db->trans_status(); //true , false

		}else{
			$result['status'] = false;
		}
		return $result;
	}

	function movie_reset_data($input)
	{
		$this->db->from('tb_movie_maker');
		$this->db->where('orderId',$input['orderId']);
		$sql = $this->db->get();
		if($sql->num_rows() >= 1){
			$this->db->trans_start(); //트랜잭션 스타트

			$this->db->where("orderId",$input['orderId']); //해당 아이디 업데이트
			$this->db->update('tb_movie_maker',array("reset_cnt"=>1, "reset_avail"=>0,"isComplete"=>null,"renderStartDate"=>null,"renderServerName"=>null,"completeDatetime"=>null ));

			$this->db->where("id",$input['orderId']); //해당 아이디 업데이트
			$this->db->update('tb_order',array("status"=>"03"));

			$this->db->where('movieMakerId', $sql->row()->id);
			$this->db->delete('tb_movie_store');

			$this->db->trans_complete(); //트랜잭션 엔드
			$result['status'] = $this->db->trans_status(); //true , false
		}else{
			$result['status'] = false;
		}
		return $result;
	}


	function catelist(){
		$this->db->from('tb_category');
		$result['catelist'] = $this->db->get()->result_array();
		
		$json_data = json_encode($result);
		print_r($json_data);
	}
	
	function productlists($cate_id){
		$this->db->from('tb_product');
		$this->db->where('categoryId',$cate_id);
		$this->db->where('isDisplay',1);
		
		$result['productlist'] = $this->db->get()->result_array();
		$json_data = json_encode($result);
		print_r($json_data);
	}
	function findproduct($product_id){
		$this->db->from('tb_product');
		$this->db->where('id',$product_id);
		$this->db->where('isDisplay',1);
		
		$result = $this->db->get()->row_array();
		$json_data = json_encode($result);
		print_r($json_data);
	}
	
	
	//*******************************   app관련 모듈        *********************************// 
	
	function app_product($page , $pagelist=5 , $categoryId, $type, $keyword){
		if(is_numeric($page) == false) $page = 1;
		if($page < 0) $page = 1; 
		$limit_ofset = ($page-1) * $pagelist;
		
		$TEST = $this->load->database(APP_DB, TRUE);//test 고정
		
		$TEST->select('SQL_CALC_FOUND_ROWS *',false);
		$TEST->from('tb_product');
		$TEST->where('isDisplay','1');
		
		if($categoryId) $TEST->where('catetoryId',$categoryId);
		if($keyword) $TEST->like('keyword',$keyword);			
		//if($type) $TEST->where('catetoryId',$categoryId);
		
		$TEST->order_by('id','desc');
		$TEST->order_by('id','RANDOM');
		$TEST->limit($pagelist,$limit_ofset);

		$result['data']= $TEST->get()->result_array();
		$result['total_cnt'] = $TEST->query("SELECT FOUND_ROWS() AS total_cnt;")->row()->total_cnt;
		
		
		//$result = $TEST->get()->result_array();
		$json_data = json_encode($result);
		print_r($json_data);
	}
	
	//app uuid 추가
	function app_device_add($uuid){
		$TEST = $this->load->database(APP_DB, TRUE);//test 고정
		//인증 검사 uuid  있는지 조회
		$sql_uuid = $this->app_select_uuid($uuid);
		if( $sql_uuid->num_rows() >= 1){
			$result['result'] =false;
			$result['data'] = array();
			$result['message'] ="이미 추가된 uuid가 있습니다.";
			$json_data = json_encode($result);
			print_r($json_data);
		}else{
			$data = array("uuid"=>$uuid,"create_date"=>date("Y-m-d H:i:s"));
						
			$result['result'] =  $TEST->insert("app_uuid",$data);		
        	$result['data']['insert_id'] = $TEST->insert_id();				
			$result['message'] ="성공적으로 추가 되었습니다.";
			$json_data = json_encode($result);
			print_r($json_data);
		}		
	}
	
	//app uuid 삭제
	function app_device_del($uuid){
		$TEST = $this->load->database(APP_DB, TRUE);//test 고정
		//인증 검사 uuid  있는지 조회
		$sql_uuid = $this->app_select_uuid($uuid);
		if( $sql_uuid->num_rows() >= 1){
			$data = array("uuid"=>$uuid);
			$result['result'] = $TEST->delete("app_uuid", $data);
			$result['message'] ="삭제되었습니다.";
			$json_data = json_encode($result);
			print_r($json_data);
		}else{
			$result['result'] =  false;
        	$result['data'] = array();				
			$result['message'] ="삭제할 아이디가 없습니다.";
			$json_data = json_encode($result);
			print_r($json_data);
		}		
	}
	
	//uuid 조회
	function app_select_uuid($uuid){
		$TEST = $this->load->database(APP_DB, TRUE);//test 고정
		$TEST->from('app_uuid');
		$TEST->where('uuid',$uuid);
		return $TEST->get();
	}
	
	
	
	//주문 생성
	function app_movieMaker_order($uuid, $product_id, $email){
		$TEST = $this->load->database(APP_DB, TRUE);//test 고정
		$total = 0;
		$couponPrice = 0; //쿠폰 사용금액
		$useSavedMoney = 0; //사용 포인트
		
		//echo $product_id;
		$cart = $this->_app_make_cart($product_id);
		
		
		$order_item = array(
			'id' =>null,
			'orderId'=>null,
			'productId'=>$product_id,
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
			'genres'=>$cart['keyword'], 
			'keywords'=>$cart['keyword'], 
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
			
				
		$members = $this->_email_to_member($email);
		$memberId =$members['id'];
		
		$date = date("Y-m-d H:i:s");
		
		$order = array(
				'id'=>null,
				 'price'=>$total,
				 'savedMoney'=>0,
				 'useSavedMoney'=>$useSavedMoney,
				 'usePartnerPoint'=>0,
				 'couponId'=>null,
				 'couponPrice'=>$couponPrice,
				 'device'=>'mobile',
				 'memberId'=>$memberId,
				 'memberUserId'=>'',
				 'memberPassword'=>'',
				 'memberName'=>'',
				 'memberTel'=>'',
				 'memberMobile'=>'',
				 'memberEmail'=>$email,
				 'ip'=>$this->input->ip_address(),
				 'modifyDatetime'=>$date,
				 'inflow'=>null,
				 'createDatetime'=>$date,
				 'status'=>'02',
				 'beforeStatus'=>'00',
				 'enable'=>1
 		);
		
		
		
		$order_payment = array(
							'id'=>null, 
							'oid'=>'app_'.$date, 
							'orderId'=>0, 
							'payId'=>'app_'.$date, 
							'payMethod'=>'app_test', 
							'price'=>$total, 
							'resultCode'=>'00', 
							'resultMessage'=>'앱 테스트 주문 저장', 
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
							'bankExpireDate'=>'', 
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
		
		
		$TEST->insert('tb_order', $order); //order		
		$first_insert_id = $TEST->insert_id();
		foreach($order_item as $key => $item){
			//$order_item[$key]['orderId'] = $first_insert_id;
			//echo "key::".$key; 			
		}
		
		$order_item['orderId'] = $first_insert_id;
		
	
		
		$order_payment['orderId'] = $first_insert_id;
		$TEST->insert('tb_order_item', $order_item); //order_item
		$TEST->insert('tb_order_payment', $order_payment); //order_payment
		
		
		
		$TEST->from("tb_order_item");
		$TEST->where("orderId",$first_insert_id);
		$return_order_item  = $TEST->get()->result_array();
		
		
		$db_order = $this->_tb_order($first_insert_id); 
		
		$movie_maker = array();
		foreach($return_order_item as $key => $item){
			$movie_maker[$key]['id'] = "A".$first_insert_id.$key;
			$movie_maker[$key]['orderId'] = $first_insert_id;
			$movie_maker[$key]['orderItemId'] = $item['id'];
			$movie_maker[$key]['memberId'] = $db_order['memberId'];
			$movie_maker[$key]['isComplete'] = 0;
			$movie_maker[$key]['createDatetime'] = date("Y-m-d H:i:s");
			$movie_id = "A".$first_insert_id.$key; 
		}
		
		//print_r($movie_maker);
		$TEST->insert_batch('tb_movie_maker', $movie_maker); //order_payment
		
		$result['result'] =  true;
		$result['message'] ="주문 생성에 성공 하셨습니다.";
		$result['data']['make_id'] = $movie_id;
		$result['data']['order_id'] = $first_insert_id;
		$json_data = json_encode($result);
		print_r($json_data);
	}
	
	function app_movieMaker_save($isBgmChange, $movie_title, $size, $make_id, $isComplete, $order_id, $user_resource_path){
		$TEST = $this->load->database(APP_DB, TRUE);//test 고정
	
		$TEST->where('id', $make_id);
		$TEST->set('isBgmChange',(int)$isBgmChange);
		$TEST->set('movie_title',$movie_title);
		$TEST->set('size',$size);
		$TEST->set('user_resource_path',$user_resource_path);
		
		$TEST->set('isComplete',1);
		$TEST->set('storeDatetime', date("Y-m-d H:i:s"));
		$TEST->set('completeDatetime', date("Y-m-d H:i:s"));
		
		$status = $TEST->update('tb_movie_maker');
		
		//조건을 요약하면 주문정보가 있고 주문아이디가 있고
		//isComplete = 1 컴플릿이 진행되었으며, storeDatetime >= now() 스토어저장기간이 오늘이상이여야 하고, renderStartDate = null 랜더 시작이 아직 안된것.
		
		
		if($status){
		
			$result['result'] = true;			
			$result['message'] ="랜더링 요청에 성공 하였습니다.";
			$result['data'] = $this->_movie_maker_select($make_id);
			$json_data = json_encode($result);
			print_r($json_data);
			exit;
		}else{
			$result['result'] = false;			
			$result['message'] ="업데이트 실패하였습니다.";
			$result['data'] = array();
			$json_data = json_encode($result);
			print_r($json_data);
			exit;
		}		
	}
	
	//회원추가
	function app_member_add($uuid, $email, $pass){
		$TEST = $this->load->database(APP_DB, TRUE);//test 고정
		$sql_uuid = $this->app_select_uuid($uuid);
		//if( $sql_uuid->num_rows() >= 1){
			
			$key=urlencode($this->encryption->encrypt($email));
			$email_exp = explode("@", $email);
			$userId = $email_exp[0]; 
			$userId = $userId ."_".mt_rand(0,9999);
			
			//회원가입
			$data=array(
					'email' => $email,
					'userId' => $userId,
					'password' => $pass,
					'auth_key' => urldecode($key),
					'authKey' => '',
					'authType' => '1',
					'name' => ' ',
					'sex' => 'F',
					'role' => 'ROLE_USER',
					'mobile' => '01000001111',
					'modifyDatetime' => date('Y-m-d H:i:s'),
					'createDatetime' => date('Y-m-d H:i:s'),
					'isNew' => '1',
					'auth_lv' =>4
					
			);
			//'uuid' => $uuid //uuid 제거
			
			$insert_status = $TEST->insert('tb_member', $data);
			$insert_id = $TEST->insert_id();
			if($insert_id){
				$point_data = array(
						'memberId'=>$insert_id,
						'orderId'=>null,
						'name'=>'회원가입 축하',
						'money'=> 1000,
						'endDatetime'=>null,
						'createDatetime'=>date("Y-m-d H:i:s")
				);
				$this->db->insert('tb_member_saved_money',$point_data);
				$result['result'] = true;			
				$result['message'] ="회원가입에 성공하였습니다.";
				$result['data'] = array();
				$json_data = json_encode($result);
				print_r($json_data);
				exit;
			}else{
				$result['result'] = false;			
				$result['message'] ="회원가입 실패...";
				$result['data'] = array();
				$json_data = json_encode($result);
				print_r($json_data);
				exit;
			}
			
		/*	
		}else{
			$result['result'] = false;			
			$result['message'] ="uuid 조회 실패. 데이터가 없습니다.";
			$result['data'] = array();
			$json_data = json_encode($result);
			print_r($json_data);
			exit;
		}
		*/
	}
	
	//이메일 중복 체크
	function app_member_email($email){
		$TEST = $this->load->database(APP_DB, TRUE);//test 고정
		$TEST->from('tb_member');
		$TEST->where('email', $email);
		$sql = $TEST->get();
		if( $sql->num_rows() >= 1){
			
				$result['result'] = false;
				$result['message'] ="이메일 중목이 있습니다.";
				$result['data'] = array();
				$json_data = json_encode($result);
				print_r($json_data);
				exit;
		}else{
				$result['result'] = true;			
				$result['message'] ="사용 가능한 이메일 입니다.";
				$result['data'] = array();
				$json_data = json_encode($result);
				print_r($json_data);
				exit;
		}		
	}
	
	//로그인 
	function app_member_login($uuid, $email, $pass){
		$TEST = $this->load->database(APP_DB, TRUE);//test 고정
		$TEST->select('id, name, userId, email, isExit, uuid');
		$TEST->from('tb_member');
		$TEST->where('email', $email);
		$TEST->where('password', $pass);
		//$TEST->where('uuid', $uuid); //$uuid 제거
		$sql = $TEST->get();
		if( $sql->num_rows() >= 1){
			$result['result'] = true;
				$result['message'] ="로그인 되셨습니다.";
				$result['data'] = $sql->row_array();
				$json_data = json_encode($result);
				print_r($json_data);
				exit;
		}else{
			$result['result'] = false;
				$result['message'] ="가입정보를 다시 확인해 주십시오.";
				$result['data'] = array();
				$json_data = json_encode($result);
				print_r($json_data);
				exit;
		}
		
	}
	
	//패스워드 변경
	function app_member_password_chg($uuid, $email, $pass, $new_pass){
		$TEST = $this->load->database(APP_DB, TRUE);//test 고정
		//정보체크
		$TEST->from('tb_member');
		$TEST->where('email', $email);
		$TEST->where('password', $pass);
		//$TEST->where('uuid', $uuid); //$uuid 제거		
		$sql = $TEST->get();
		if( $sql->num_rows() == 1){
			$TEST->set('password',$new_pass);
			
			
			$result['result'] = $TEST->update('tb_member');
			$result['message'] ="업데이트를 했습니다.";
			$result['data'] = array();
			$json_data = json_encode($result);
			print_r($json_data);
			exit;
			
		}else{
			$result['result'] = false;
			$result['message'] ="일치하는 정보가 없습니다.";
			$result['data'] = array();
			$json_data = json_encode($result);
			print_r($json_data);
			exit;
		}
		
	}
	
	function app_mypage_list($page, $uuid, $email){
		$pagelist = 5;
		if(is_numeric($page) == false) $page = 1;
		if($page < 0) $page = 1; 
		$limit_ofset = ($page-1) * $pagelist;
		
		$TEST = $this->load->database(APP_DB, TRUE);//test 고정
		
		/*
		 * 	data[]		
		 * 	,p_type 
			,tb_movie_maker.movie_title As i_title
			,tb_order.status  AS isComplete
			,day
			,date
		 * 
		 * 		item[]
		 * 				
		 * 
		*/
		$query = "SELECT  SQL_CALC_FOUND_ROWS	* 				
			FROM (
				SELECT 
					tb_movie_maker.* , tb_order.price,  tb_order.beforeStatus, tb_order.status, 
					tb_order_item.imageMfile AS imagefile, tb_order_item.name, tb_order_item.id AS item_id, tb_movie_store.isDelete, 
					tb_movie_store.fileName AS storeFile, tb_product.id as pid,
					tb_movie_store.filePath, tb_order.id AS OID,
					tb_product.device_type as p_type,
					tb_movie_maker.movie_title as i_title					
					
				
				FROM `tb_movie_maker`
				INNER JOIN tb_order ON tb_order.id = tb_movie_maker.orderId
				INNER JOIN tb_order_item ON tb_order_item.id = tb_movie_maker.orderItemId
				LEFT JOIN tb_movie_store ON tb_movie_store.movieMakerId = tb_movie_maker.id				
				INNER JOIN tb_product ON tb_order_item.productId = tb_product.id
				
				WHERE `tb_order`.`memberEmail` = '".$this->db->escape_str($email)."' AND tb_order.status != '08'
							
				
			) AS A
			 
			 ORDER BY A.createDatetime DESC
			 limit $limit_ofset, $pagelist
			 ";
			 //INNER JOIN tb_order_item ON tb_order_item.id = tb_movie_maker.orderItemId
			
		
		$result['page'] = $page;
		$mypage = $TEST->query($query,false)->result_array(); //일단 받아오고
		$total_cnt = $TEST->query("SELECT FOUND_ROWS() AS total_cnt;")->row()->total_cnt;		
		$result['total_cnt'] = ceil($total_cnt / 5);
		
		//루프 돌면서 정재
		foreach($mypage as $keys => $val){
			$data_mypage[$keys]['p_type'] = $val['p_type'];
			$data_mypage[$keys]['i_title'] = $val['i_title'];
			$data_mypage[$keys]['isComplete'] = $val['status'];
			
			//제작잔여일수
			if($val['storeDatetime']) {
				$data_mypage[$keys]['day'] = date("Y-m-d", strtotime($val['storeDatetime']));
			}else{
				$data_mypage[$keys]['day'] = null;
			}
						
			//보관잔여일수
			if($val['completeDatetime']) {
				$data_mypage[$keys]['date'] =  date("Y-m-d", strtotime($val['completeDatetime']."+30 day") );
				
				
			}else{
				$data_mypage[$keys]['date'] = null;
			}
			
			
			
			$query = "
				select
					tb_order_item.productId AS id 
					,tb_order_item.imageLFile, tb_order_item.imageMFile, tb_order_item.imageSFile, tb_order_item.imageNFile					
					,tb_order_item.name
					,tb_order_item.imageText
					,tb_order_item.categoryName AS category
					,tb_movie_store.fileName
					,tb_movie_store.filePath
					, concat('".APP_IMG_PATH."') AS imgPath
					
					
				
				from tb_order_item 				
				INNER JOIN tb_movie_maker ON tb_order_item.id = tb_movie_maker.orderItemId
				LEFT JOIN tb_movie_store ON tb_movie_store.movieMakerId = tb_movie_maker.id	
				
				where tb_order_item.orderId = ".$val['OID'];
				
			//,CONCAT('http://player.vimeo.com/video/',movieVimeoId) as mp4_url
			$data_mypage[$keys]['item'] =  $TEST->query($query)->row_array();		
			
			
			
		}
		
		$result['data']=  $data_mypage;
		
		/*
		foreach ($mypage as $key => $value) {				
			$query = "select * from tb_order_item where orderId = ".$value['OID'];
			$result['data']['item'][$key] =  $TEST->query($query)->row_array();							
		}
		*/
		//print_r($result);
				
		$result['result'] = true;
		$result['message'] ="정상 호출 되었습니다.";
		
		/*
		echo "<pre>";
		print_r($result);
		echo "</pre>";
		exit;
		*/
		
		//$result = $TEST->get()->result_array();
		$json_data = json_encode($result);
		print_r($json_data);
		
	}
	
	
	
	/******** _내부함수 실행자 들 ****************/

	
		
	//상품명으로 카트 정보 생성
	function _app_make_cart($product_id){
		$TEST = $this->load->database(APP_DB, TRUE);//test 고정
		$TEST->from('tb_product');
		//$TEST->where('device_type', 'mobile');
		$TEST->where('id', $product_id);
		return $TEST->get()->row_array();
	}
	
	//카테고리 네임변환
	function _catename($caterogyId){
		$TEST = $this->load->database(APP_DB, TRUE);//test 고정
		$TEST -> select('name');
		$TEST -> from('tb_category');
		$TEST -> where('id', $caterogyId);			
		$TEST -> limit(1);
		return $TEST -> get()->row()->name;
	}
	
	//주문 정보 조회
	function _tb_order($id){
		$TEST = $this->load->database(APP_DB, TRUE);//test 고정		
		$TEST -> from('tb_order');
		$TEST -> where('id', $id);			
		$TEST -> limit(1);
		return $TEST->get()->row_array();	
	}
	
	//_email_to_member
	function _email_to_member($email){
		$TEST = $this->load->database(APP_DB, TRUE);//test 고정		
		$TEST -> from('tb_member');
		$TEST -> where('email', $email);			
		$TEST -> limit(1);
		return $TEST->get()->row_array();
	}
	
	//무비메이커 조회
	function _movie_maker_select($movie_maker_id){
		$TEST = $this->load->database(APP_DB, TRUE);//test 고정
		$TEST->from('tb_movie_maker');	
		$TEST->where('id', $movie_maker_id);
		$TEST -> limit(1);
		return $TEST->get()->row_array();
	}
	
}//end
