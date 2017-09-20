<?  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require realpath(FCPATH) . '/vendor/kaleido/src/Kaleido/autoload.php';

class Order extends CI_Controller {
	function __construct()	{
		parent::__construct();
		
		$this->load->database('default');		
		$this->load->model('common_model');
		$this->load->model('order_model');
		
		
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->helper('alert');
		$this->load->helper('bankcode');
		$this->load->helper('common');
		$this -> load -> helper('pg');
		
		$this->load->library('cart');
		$this->load->library('user_agent');
		$this->load->library('pagination_custom');
		$this->load->library('temp_email');
	}
	public function _remap($method){

		$this->segs = $this->uri->segment_array();
		$location = $this->session->userdata('location');
		if(!$location) $location = "ko";
		$data = array();
		$data['location'] = $location;

		if($this->input->is_ajax_request()){
			if( method_exists($this, $method) ) {
				$this->{"{$method}"}($location);
			}else{
				//없는 메소드 호출				
			}
		}else{ //ajax가 아니면
			if( substr($method,0,6) == "ifream" ){ //ifream 형식이면
				$this->load->view($location."/common/header_nts");
				$this->{"{$method}"}($location);
				$this->load->view($location."/common/footer_nts");
			}elseif ($method == "m_inicis_noti"){ //이니시스 리턴 페이지 제외
				$this->{"{$method}"}($location);				
			}elseif ($method == "paypal_noti"){ //페이팔 리턴 페이지 제외 paypal_noti_p
				$this->{"{$method}"}($location);
			}elseif ($method == "paypal_noti_p"){ //페이팔 리턴 페이지 제외
				$this->{"{$method}"}($location);
			}elseif ($method == "paypal_noti_m"){ //페이팔 리턴 페이지 제외
				$this->{"{$method}"}($location);
			}else{
				$this->load->view($location."/common/header2",$data);
				if( method_exists($this, $method) ){
					$this->{"{$method}"}($location);
					
				}
				$this->load->view($location."/common/footer2");
				//$this->output->enable_profiler(true);
			}
		}
	}
	function index($location){
		
 	}
	
	
	
	function _cart_ids(){
		$product_id = array();
		$i = 0;
		$total_price=0;
		$total_price_usd=0;

		if(!$this->cart->contents()) alert('세션만료','/main/');

		foreach($this->cart->contents() as $items){
			
			$product[$i] = $items['id'];		
			$product_id = $product;
			$i++;
		
			/*
			//해당 하는 1개의 아이템만 나타냄
			if($itemcount>=1){
				$itemcount = $itemcount-1;
				$product_id[0] =  $product[$itemcount];
			}else{
			 	$product_id = $product;
			}
			 * 
			 */
			 }
			$db_data = $this->order_model->product($product_id);
			foreach($db_data as $key => $val){
				$data['product'][$key] = $db_data[$key]['product'];				
				if($db_data[$key]['product']['eventPrice'] > 0){				
					$total_price+=$db_data[$key]['product']['eventPrice'];
				}else{
					$total_price+=$db_data[$key]['product']['price'];
				}
				$total_price_usd += $db_data[$key]['product']['usd'];
			}
			$data['total_price']=$total_price;
			$data['total_price_usd']=$total_price_usd;

		return $data;
	}

	//결재 폼
	function form($location){		
		$data = $this->_cart_ids();
		// -- 
		$this->load->library('INIStdPayUtil');
		$SignatureUtil = new INIStdPayUtil();
		
		$signKey = SINGNKEY;
		
		
		$timestamp=$SignatureUtil->getTimestamp();
		$data['mid']= INICIS_MID;
		$data['oid']=$data['mid']."_".$timestamp;
		$data['timestamp']=$timestamp;
		$data['mkey']=$SignatureUtil->makeHash($signKey, "sha256");
		$params = array(
				"oid" => $data['oid'],
				"price" => $data['total_price'],
				"timestamp" => $timestamp
		);
		$data['signature'] = $SignatureUtil->makeSignature($params, "sha256");
		// end change div
		$data['sdf'] = date("YmdHis");
		$data['p_oid']=$data['mid']."_".$data['sdf'];
		//$plainText = (string)$data['sdf'].(string)$data['mid']."authreq".(string)$data['p_oid']."WON".(string)$data['total_price'].$signKey; 
		//$data['hashdata']=hash("sha512", $plainText);
		
		 
		$data['inicis_returnUrl']	=	BASE_URL."/order/inicis_return";
		$data['inicis_popupUrl']	=	BASE_URL."/order/inicis_popup";
		$data['inicis_closeUrl']	=	BASE_URL."/order/inicis_close";
		
		// --
		$this->load->view($location."/order/form_v",$data);
	}
	
	//무통장 입금 입금 처리
	function ifream_nbank_insert($location){
		
		//$product_id = $this->input->post("product_id",true); 	//상품번호 - 카트로 처리
		
		$username = $this->input->post("username",true); 	//이름
		$email = $this->input->post("email",true);			//이메일
		$password = $this->input->post("password",true);			//패스워드
		
		//$price = $this->input->post("price",true);			////실제 가격 -- 카트로 처리
		
		$point = $this->input->post("point",true); 			//포인트 
		$couponid = $this->input->post("couponid",true);	//쿠폰 번호
		
		$pay_bank_code = $this->input->post("pay_bank_code",true);			//결재할 은행 코드
		
		
		if($this->agent->is_mobile()){
			$device = "M";
		}else{
			$device = "PC";	
		}
		
		$memberId = "";
		
		//패스워드 로그인이 안된 사람이면 입력 받은 값을 md5로 암호
		if(!$this->session->userdata['password']){
			$memberPassword = md5($password);
		}else{
			$memberPassword = $this->session->userdata['password']; 
		}
		
		
		$ip = $this->input->ip_address();
		//$modifyDatetime = date("Y-m-d H:i:s");
		//$createDatetime = date("Y-m-d H:i:s");
		$status = '01'; //1은 무통장 입금 대기 상태
		$beforeStatus = '00'; //무비메이커 비 노출 상태
		$enable = "r";
		
		//order-item
		//주문번호만 있으면 됨
		
		//order-payment
		$bankNo = BANK_NUM; //입금주 입금은행
		$bankMemberName = "주식회사  위드비디"; //		
		$payMethod = "nbank";
		$payId = "무통장입금";
		$oid  = "nbank";
		
		
		$cart_data = $this->_cart_ids();
		
		
		$data = array(			
			'username'=>$username,		
			'email'=>$email,			
			'point'=>$point,		
			'couponId'=>$couponid,		
			'pay_bank_code' => $pay_bank_code,
			'device' => $device,
			'memberId' => $memberId,		
			'memberPassword' => $memberPassword,
			'ip' => $this->input->ip_address(),
			'modifyDatetime' => date("Y-m-d H:i:s"),
			'createDatetime' => date("Y-m-d H:i:s"),
			'status' => '01',
			'beforeStatus' => '00',		
			'enable' => 'r',		
			'bankNo' => $bankNo,
			'bankMemberName' => '주식회사  위드비디',
			'payMethod' => 'nbank',					
			'payId' => $payId,
			'oid'   => $oid			
		);
		
		$status = $this->order_model->nbank_insert($cart_data, $data);
		if($status){
			
			//기본정보
			$send_email = $email; //받을 이메일
			$oid = $status['oid']; //주문번호
			//$point = 0; //사용포인트
			$pay_type = '무통장입금';
			$payment = 0; //최종 결제액
			
			$fin_is_member = '비회원';
			if($this->session->userdata("mid")) $fin_is_member = '회원';

			//메일 발송		
			$this->temp_email->order_fin_mail_send($send_email, $oid, $point, $pay_type, $payment, $fin_is_member, $cart_data);
			
			
			//세션 생성
			
			$new_data = array(
				'fin_oid'=>$oid,
				'fin_use_point'=>$point,				
				'fin_total_pay'=>$payment,
				'fin_is_member'=>$fin_is_member,
				'fin_name'=>$username,
				'fin_email'=>$email
			);
			$this->session->set_userdata($new_data);
			
			
			//완료 페이지로 넘기기
			 redirect("/order/finish");
		}else{
			alert("결재에 실패 하였습니다.");
		}
		
	}

	//무통장 입금 승인 완료 처리
	function nbank_cnf($location){
		//관리자만 승인 가능 하다.
	}
	
	//주문 처리 완료 
	//성공 과 실패가 동일 한 페이지에서  처리 되게...	
	function finish($location){
		$data = $this->_cart_ids();		
		$this->load->view($location."/order/finish_v",$data);
	}
	
	//주문 완료 후 무비 메이커 등록
	function order_movemaker($location){
		
	}
	
	//무통장 입금
	function ifream_form_dbank($location){		
		$data = $this->_cart_ids();
		$this->load->view($location."/order/ifream_form_dbank_v",$data);
	}
	
	//카카오페이
	function ifream_form_cacao($location){
		$data = kakaopay_init(); //config init
		$pg = new Kaleido\Pg();
		$lgcns = $pg->getLgcnsHeandler([$data]);

		//가맹점서명키 (꼭 해당 가맹점키로 바꿔주세요)
		//$merchantKey = "33F49GnCMS1mFYlGXisbUDzVf2ATWCl9k3R++d5hDd3Frmuos/XLx8XhXpe+LDYAbpGKZYSwtlyyLOtS/8aD7A==";

		$data['ediDate'] = date("YmdHis");  // 전문생성일시

		//상품가격 - hash 생성 시 필요하므로 화면로딩시 가지고 있어야 하는 값
		//$data['Amt'] = 1000; //ps 이 가격은 추가로 입력 폼에서 변동이 되어도 상관 없다 그러니 고정으로 놔두면 됨
		//그렇지 않다. 가격 변동에 따라서 새로 hash_String 를 따와야한다.....

		$cart = $this->_cart_ids();
		$data['Amt'] =  $cart['total_price'];

		////////위변조 처리/////////
		//결제요청용 키값
		$data['cnspay_lib'] = $lgcns->CnsPayWebConnector();
		$data['md_src'] = $data['ediDate'].$data['MID'].$data['Amt'];
		$data['salt'] = hash("sha256",$data['merchantKey'].$data['md_src'],false);

		$data['hash_input'] = $lgcns->makeHashInputString($data['salt']);
		$data['hash_calc'] = hash("sha256", $data['hash_input'], false);
		$data['hash_String'] = base64_encode($data['hash_calc']);

		//기본값 -- 딱히 변경 금지
		$data['AuthFlg'] = "10";
		$data['currency'] = "KRW";
		$data['remoteaddr'] = $_SERVER['REMOTE_ADDR'];
		$data['serveraddr'] = $_SERVER['SERVER_ADDR'];
		$data['merchantTxnNum'] = date("YmdHis",time());


		$data['cart'] = $this->_cart_ids();

		$this->load->view($location."/order/ifream_form_cacao_v",$data);		
	}
	
	//페이코
	function ifream_form_payco($location){
		$data = $this->_cart_ids();
		$this->load->view($location."/order/ifream_form_payco_v",$data);		
	}
	
	//적립금
	function ifream_form_point($location){
		$data = $this->_cart_ids();
		$this->load->view($location."/order/m_ifream_form_point_v",$data);
	}
	
	function _KMPayRequest($key) {
		return (isset($_REQUEST[$key])?$_REQUEST[$key]:"");
	}

	//카카오페이
	function kakao_txnId($location){
		$data = kakaopay_init(); //config init
		$pg = new Kaleido\Pg();
		$lgcns = $pg->getLgcnsHeandler([$data]);
		$kmFunc = $lgcns->getKmpayFunc($data);



		// 로그 저장 위치 지정
		//$kmFunc = new kmpayFunc($LogDir);

		$kmFunc->setPhpVersion($data['phpVersion']);

		// TXN_ID를 요청하기 위한 PARAMETERR
		$REQUESTDEALAPPROVEURL = $this->_KMPayRequest("requestDealApproveUrl");	//인증 요청 경로
		$PR_TYPE = $this->_KMPayRequest("prType");												//결제 요청 타입
		$MERCHANT_ID = $this->_KMPayRequest("MID");											//가맹점 ID
		$MERCHANT_TXN_NUM = $this->_KMPayRequest("merchantTxnNum");				//가맹점 거래번호
		$CHANNEL_TYPE = $this->_KMPayRequest("channelType");
		$PRODUCT_NAME = $this->_KMPayRequest("GoodsName");								//상품명
		$AMOUNT = $this->_KMPayRequest("Amt");												//상품금액(총거래금액) (총거래금액 = 공급가액 + 부가세 + 봉사료)


		$CURRENCY = $this->_KMPayRequest("currency");											//거래통화(KRW/USD/JPY 등)
		$RETURN_URL = $this->_KMPayRequest("returnUrl");										//결제승인결과전송URL
		$CERTIFIED_FLAG = $this->_KMPayRequest("CERTIFIED_FLAG");							//가맹점 인증 구분값 ("N","NC")

		$OFFER_PERIOD_FLAG = $this->_KMPayRequest("OFFER_PERIOD_FLAG");							//상품제공기간 플래그
		$OFFER_PERIOD = $this->_KMPayRequest("OFFER_PERIOD");							//상품제공기간

		//무이자옵션
		$NOINTYN = $this->_KMPayRequest("noIntYN");											//무이자 설정
		$NOINTOPT = $this->_KMPayRequest("noIntOpt");										//무이자 옵션
		$MAX_INT =$this->_KMPayRequest("maxInt");												//최대할부개월
		$FIXEDINT = $this->_KMPayRequest("fixedInt");												//고정할부개월
		$POINT_USE_YN = $this->_KMPayRequest("pointUseYn");								//카드사포인트사용여부
		$POSSICARD = $this->_KMPayRequest("possiCard");										//결제가능카드설정
		$BLOCK_CARD = $this->_KMPayRequest("blockCard");									//금지카드설정

		// ENC KEY와 HASH KEY는 가맹점에서 생성한 KEY 로 SETTING 한다.
		$merchantEncKey = $this->_KMPayRequest("merchantEncKey");
		$merchantHashKey = $this->_KMPayRequest("merchantHashKey");
		$hashTarget = $MERCHANT_ID.$MERCHANT_TXN_NUM.str_pad($AMOUNT,7,"0",STR_PAD_LEFT);

		// payHash 생성
		$payHash = strtoupper(hash("sha256", $hashTarget.$merchantHashKey, false));

		//json string 생성
		//$strJsonString = new JsonString($LogDir);
		$strJsonString = $lgcns->JsonString($data);


		$strJsonString->setValue("PR_TYPE", $PR_TYPE);
		$strJsonString->setValue("CHANNEL_TYPE", $CHANNEL_TYPE);
		$strJsonString->setValue("MERCHANT_ID", $MERCHANT_ID);
		$strJsonString->setValue("MERCHANT_TXN_NUM", $MERCHANT_TXN_NUM);
		$strJsonString->setValue("PRODUCT_NAME", $PRODUCT_NAME);

		$strJsonString->setValue("AMOUNT", $AMOUNT);

		$strJsonString->setValue("CURRENCY", $CURRENCY);
		$strJsonString->setValue("CERTIFIED_FLAG", $CERTIFIED_FLAG);

		$strJsonString->setValue("OFFER_PERIOD_FLAG", $OFFER_PERIOD_FLAG);
		$strJsonString->setValue("OFFER_PERIOD", $OFFER_PERIOD);

		$strJsonString->setValue("NO_INT_YN", $NOINTYN);
		$strJsonString->setValue("NO_INT_OPT", $NOINTOPT);
		$strJsonString->setValue("MAX_INT", $MAX_INT);
		$strJsonString->setValue("FIXED_INT", $FIXEDINT);

		$strJsonString->setValue("POINT_USE_YN", $POINT_USE_YN);
		$strJsonString->setValue("POSSI_CARD", $POSSICARD);
		$strJsonString->setValue("BLOCK_CARD", $BLOCK_CARD);

		$strJsonString->setValue("PAYMENT_HASH", $payHash);

		// 결과값을 담는 부분
		$resultCode = "500";
		$resultMsg = "기타오류";
		$txnId = "";
		$prDt = "";
		$strValid = "";
		$rawResult = "";

		// Data 검증
		//$dataValidator = new KMPayDataValidator($strJsonString->getArrayValue());
		$dataValidator = $lgcns->KMPayDataValidator($strJsonString->getArrayValue());
		$strValid = $dataValidator->resultValid;
			//alert($strValid,"");
		if (strlen($strValid) > 0) {
			$arrVal = explode(",", $strValid);
			if (count($arrVal) == 3) {
				$resultCode = $arrVal[1];
				$resultMsg = $arrVal[2];
			} else {
				$resultCode = $strValid;
				$resultMsg = $strValid;
			}
		}

		// Data에 이상 없는 경우
		if (strlen($strValid) == 0) {
			// CBC 암호화
			$paramStr = $strJsonString->getJsonString();
			$kmFunc->writeLog("Request");
			$kmFunc->writeLog($paramStr);
			$kmFunc->writeLog($strJsonString->getArrayValue());
			$encryptStr = $kmFunc->parameterEncrypt($merchantEncKey, $paramStr);
			$payReqResult = $kmFunc->connMPayDLP($REQUESTDEALAPPROVEURL, $MERCHANT_ID, $encryptStr);
			$rawResult = $payReqResult;
			$resultString = $kmFunc->parameterDecrypt($merchantEncKey, $payReqResult);

			//$resultJSONObject = new JsonString($LogDir);
			$resultJSONObject = $lgcns->JsonString($data);

			if (substr($resultString, 0, 1) == "{") {
			  $resultJSONObject->setJsonString($resultString);
			  $resultCode = $resultJSONObject->getValue("RESULT_CODE");
					$resultMsg = $resultJSONObject->getValue("RESULT_MSG");
					if ($resultCode == "00") {
				$txnId = $resultJSONObject->getValue("TXN_ID");
					$prDt = $resultJSONObject->getValue("PR_DT");
				}
			}
			else {
				$tmpArrVal = explode(",", $rawResult);
				if (count($tmpArrVal) == 3 && $tmpArrVal[0] == "_FAIL_") {
					$resultCode = $tmpArrVal[1];
					$resultMsg = $tmpArrVal[2];
				} else {
					$resultCode = $strValid;
					$resultMsg = $strValid;
				}
			}


			$kmFunc->writeLog("Result");
			$kmFunc->writeLog($resultString);
			$kmFunc->writeLog($resultJSONObject->getArrayValue());

		}
		$data['resultCode'] = $resultCode;
		$data['resultMsg'] = $resultMsg;
		$data['txnId'] = $txnId;
		$data['prDt'] = $prDt;

		echo "lo=".$location;
		$this->load->view($location."/order/kakao_txnid_v",$data);
	}

	//result page
	function kakaopayLiteResult(){
		$data = kakaopay_init(); //config init
		$pg = new Kaleido\Pg([$data]);
		//$lgcns = $pg->getLgcnsHeandler();

		// 로그 저장 위치 지정
		//$connector = new CnsPayWebConnector($LogDir);


		$connector = $pg->getLgcnsHeandler();
		$connector->CnsActionUrl($data['CnsPayDealRequestUrl']);//$CnsPayDealRequestUrl
		$connector->CnsPayVersion($data['phpVersion']);//$phpVersion

		// 요청 페이지 파라메터 셋팅
		//$connector->setRequestData($_REQUEST);
		$connector->setRequestData($this->input->get_post(NULL, true)); //ci style

		// 추가 파라메터 셋팅
		$connector->addRequestData("actionType", "PY0");  						// actionType : CL0 취소, PY0 승인, CI0 조회
		$connector->addRequestData("MallIP", $_SERVER['REMOTE_ADDR']);	// 가맹점 고유 ip
		$connector->addRequestData("CancelPwd", $data['cancelPwd']);

		//가맹점키 셋팅 (MID 별로 틀림)
		$connector->addRequestData("EncodeKey", $data['MID']);

		// 4. CNSPAY Lite 서버 접속하여 처리
		$connector->requestAction();

		// 5. 결과 처리
		$insert_data['resultCode'] 	= $resultCode = $connector->getResultData("ResultCode"); 			// 결과코드 (정상 :3001 , 그 외 에러)
		$insert_data['resultMsg'] 	= $resultMsg = $connector->getResultData("ResultMsg");   			// 결과메시지
		$insert_data['authDate'] 	= $authDate = $connector->getResultData("AuthDate");   				// 승인일시 YYMMDDHH24mmss
		$insert_data['authCode'] 	= $authCode = $connector->getResultData("AuthCode");   				// 승인번호
		$insert_data['buyerName'] 	= $buyerName = $connector->getResultData("BuyerName");   			// 구매자명
		$insert_data['goodsName'] 	= $goodsName = $connector->getResultData("GoodsName"); 				// 상품명
		$insert_data['payMethod'] 	= $payMethod = $connector->getResultData("PayMethod");  			// 결제수단
		$insert_data['mid'] 		= $mid = $connector->getResultData("MID");  									// 가맹점ID
		$insert_data['tid'] 		= $tid = $connector->getResultData("TID");  									// 거래ID
		$insert_data['moid'] 		= $moid = $connector->getResultData("Moid");  								// 주문번호
		$insert_data['amt'] 		= $amt = $connector->getResultData("Amt");  									// 금액
		$insert_data['cardCode'] 	= $cardCode = $connector->getResultData("CardCode");					// 카드사 코드
		$insert_data['cardName'] 	= $cardName = $connector->getResultData("CardName");  	 			// 결제카드사명
		$insert_data['cardQuota'] 	= $cardQuota = $connector->getResultData("CardQuota"); 				// 할부개월수 ex) 00:일시불,02:2개월
		$insert_data['cardInterest']= $cardInterest = $connector->getResultData("CardInterest");	// 무이자 여부 (0:일반, 1:무이자)
		$insert_data['cardCl'] 		= $cardCl = $connector->getResultData("CardCl");             	// 체크카드여부 (0:일반, 1:체크카드)
		$insert_data['cardBin'] 	= $cardBin = $connector->getResultData("CardBin");           	// 카드BIN번호
		$insert_data['cardPoint'] 	= $cardPoint = $connector->getResultData("CardPoint");       	// 카드사포인트사용여부 (0:미사용, 1:포인트사용, 2:세이브포인트사용)

		//부인방지토큰값
		$insert_data['NON_REP_TOKEN'] = $nonRepToken =$_REQUEST["NON_REP_TOKEN"];

		$paySuccess = false;												// 결제 성공 여부

		$insert_data['resultMsg'] 	= $resultMsg = iconv("euc-kr", "utf-8", $resultMsg);
		$insert_data['cardCode'] 	= $cardName = iconv("euc-kr", "utf-8", $cardName);
		$insert_data['goodsName'] 	= $goodsName = iconv("euc-kr", "utf-8", $goodsName);
		$insert_data['buyerName'] 	= $buyerName = iconv("euc-kr", "utf-8", $buyerName);
		$insert_data['cardCode'] 	= $cardCode = iconv("euc-kr", "utf-8", $cardCode);
		$insert_data['cardName'] 	= $cardName = iconv("euc-kr", "UTF-8//IGNORE", $cardName);////iconv("EUC-KR","UTF-8//IGNORE",$str);


		/** 위의 응답 데이터 외에도 전문 Header와 개별부 데이터 Get 가능 */
		if($payMethod == "CARD"){	//신용카드
			if($resultCode == "3001") $paySuccess = true;				// 결과코드 (정상 :3001 , 그 외 에러)
		}
		if($paySuccess) {
		   // 결제 성공시 DB처리 하세요.
			$insert_data['paySuccess'] = $paySuccess;
			$insert_data['createDatetime'] = date("Y-m-d H:i:s"); //입력시간

			$email = $this->session->userdata['email'];
			$password = $this->input->post("password",true);			//패스워드


			$exp = explode("@", $email);
			$username =$buyerName;

			//$price = $this->input->post("price",true);			////실제 가격 -- 카트로 처리

			$point = $this->input->post("point",true); 			//포인트

			$couponid = $this->input->post("couponid",true);	//쿠폰 번호

			$pay_bank_code = $this->input->post("pay_bank_code",true);			//결재할 은행 코드


			if($this->agent->is_mobile()){
				$device = "M";
			}else{
				$device = "PC";
			}

			$memberId = "";
			if(!$password){
				//$memberPassword = hash("sha512", $password);
				$memberPassword = md5($password);
			}else{
				$memberPassword = $this->session->userdata['password'];
				if(!$memberPassword) $memberPassword = md5('1234');
			}
			$ip = $this->input->ip_address();


			//$modifyDatetime = date("Y-m-d H:i:s");
			//$createDatetime = date("Y-m-d H:i:s");
			$status = '02'; //1은 무통장 입금 대기 상태
			$beforeStatus = '02'; //무비메이커 비 노출 상태
			$enable = "r";

			//order-item
			//주문번호만 있으면 됨

			//order-payment
			$bankNo = BANK_NUM; //입금주 입금은행
			$bankMemberName = "주식회사  위드비디"; //
			$payMethod = "Kakao";
			$payId = $tid; //tid
			$oid  = $moid;


			$cart_data = $this->_cart_ids();

			$data = array(
				'username'=>$username,
				'email'=>$email,
				'point'=>$point,
				'couponId'=>$couponid,
				'pay_bank_code' => $pay_bank_code,
				'device' => $device,
				'memberId' => $memberId,
				'memberPassword' => $memberPassword,
				'ip' => $this->input->ip_address(),
				'modifyDatetime' => date("Y-m-d H:i:s"),
				'createDatetime' => date("Y-m-d H:i:s"),
				'status' => $status,
				'beforeStatus' => $beforeStatus,
				'enable' => 'r',
				'bankNo' => $bankNo,
				'bankMemberName' => '주식회사  위드비디',
				'payMethod' => 'Kakao',
				'payId' => $payId,
				'oid'   => $oid
			);

			$status = $this->order_model->kakao_insert($cart_data, $data);
			if($status){

				//print_r($status);

				//기본정보
				$send_email = $email; //받을 이메일
				$oid = $status['oid']; //주문번호
				//$point = 0; //사용포인트
				$pay_type = '카카오페이';
				$payment = 0; //최종 결제액

				$fin_is_member = '비회원';
				if($this->session->userdata("mid")) $fin_is_member = '회원';

				//메일 발송
				$this->temp_email->order_fin_mail_send($send_email, $oid, $point, $pay_type, $payment, $fin_is_member, $cart_data);


				//세션 생성

				$new_data = array(
					'fin_oid'=>$oid,
					'fin_use_point'=>$point,
					'fin_total_pay'=>$payment,
					'fin_is_member'=>$fin_is_member,
					'fin_name'=>$username,
					'fin_email'=>$email
				);
				$this->session->set_userdata($new_data);


				//완료 페이지로 넘기기
				// redirect("/order/finish");
				alert('주문이 성공적으로 저장 되었습니다.',"/order/finish");

			}else{
				alert("주문 저장에 실패 하였습니다.");
			}



			//$insert_id = $this->common_model->insert("kakao_pay_result",$insert_data); //table, data[]
			//if($insert_id) alert('결제 성공!!',KAKAO_URL."/kakao_order_list");
		}else{
		   // 결제 실패시 DB처리 하세요.
			$insert_data['paySuccess'] = $paySuccess;
			$insert_data['createDatetime'] = date("Y-m-d H:i:s"); //입력시간
			//$insert_id = $this->common_model->insert("kakao_pay_result",$insert_data); //table, data[]
			alert('결제 실패!!',KAKAO_URL."/kakao_form");
		}


	}


	//이니시스
	function ifream_form_inisis($location){
		$data = $this->_cart_ids();
		
		//print_r($data);
		//exit;
		//log_message('info','ifream_form_inisis');
		
		$this->load->library('INIStdPayUtil');
		$SignatureUtil = new INIStdPayUtil();
		
		$signKey = SINGNKEY;
		
		
		$timestamp=$SignatureUtil->getTimestamp();
		$data['mid']= INICIS_MID;
		$data['oid']=$data['mid']."_".$timestamp;
		$data['timestamp']=$timestamp;
		$data['mkey']=$SignatureUtil->makeHash($signKey, "sha256");
		$params = array(
				"oid" => $data['oid'],
				"price" => $data['total_price'],
				"timestamp" => $timestamp
		);
		$data['signature'] = $SignatureUtil->makeSignature($params, "sha256");
		// end change div
		$data['sdf'] = date("YmdHis");
		$data['p_oid']=$data['mid']."_".$data['sdf'];
		 
		$data['inicis_returnUrl']	=	BASE_URL."/order/inicis_return";
		$data['inicis_popupUrl']	=	BASE_URL."/order/inicis_popup";
		$data['inicis_closeUrl']	=	BASE_URL."/order/inicis_close";
			
		
		if ($this -> agent -> is_mobile()){
			$this->load->view($location."/order/m_ifream_form_inisis_v",$data);
		}else{
			$this->load->view($location."/order/ifream_form_inisis_v",$data);
		}		
	}
	
	function inicis_popup($location) {
        $this->load->view($location."/order/inicis_popup_v");
    }
    function inicis_close($location) {
        $this->load->view($location."/order/inicis_close_v");
    }
	
	//이니시스 kpay 결제 처리 -- TX 리턴 페이지 --
	function m_inicis_noti($location){
		$PGIP = $_SERVER['REMOTE_ADDR'];
		//PG에서 보냈는지 IP로 체크
		//log_message("debug","m_noti ok");
		 if($PGIP == "211.219.96.165" || $PGIP == "118.129.210.25"){
		 	//log_message("debug","m_noti IP pass");

			// 이니시스 NOTI 서버에서 받은 Value
			$P_STATUS;		      	// 거래상태 (00:성공, 01:실패)
			$P_TID;				        // 거래번호
			$P_TYPE;			        // 지불수단
			$P_AUTH_DT;		      	// 승인일자
			$P_MID;				        // 상점아이디
			$P_OID;				        // 상점주문번호
			$P_FN_CD1;		      	// 금융사코드1
			$P_FN_CD2;		      	// 금융사코드2
			$P_FN_NM;			        // 금융사명 (은행명, 카드사명, 이통사명)
			$P_AMT;				        // 거래금액
			$P_UNAME;			        // 결제고객성명
			$P_RMESG1;		      	// 결과메시지1
			$P_RMESG2;		      	// 결과메시지2
			$P_RMESG3;            // 결과메시지3
			$P_NOTI;			        // 기타주문정보(상점에서 올린 P_NOTI의 값 그대로 반환)
			$P_AUTH_NO;			      // 신용카드 승인번호
			$P_CARD_ISSER_CODE;   // 발급사 코드
			$P_CARD_NUM;          // 카드번호
			$P_PRTC_CODE;         // 부분취소 가능여부 - 가능 : 1, 불가능 : 0
			$P_SRC_CODE;          // 앱 연동 결제 구분 - A:Kpay, S:삼성월렛, P:페이핀, K:국민앱카드
			 
		
	
			$resultMap['P_TID'] = $_REQUEST["P_TID"];
			$resultMap['P_MID'] = $_REQUEST["P_MID"];
			$resultMap['P_AUTH_DT'] = $_REQUEST["P_AUTH_DT"];
			$resultMap['P_STATUS'] = $_REQUEST["P_STATUS"];
			$resultMap['P_TYPE'] = $_REQUEST["P_TYPE"];
			$resultMap['P_OID'] = $_REQUEST["P_OID"];
			$resultMap['P_FN_CD1'] = $_REQUEST["P_FN_CD1"];
			$resultMap['P_FN_CD2'] = $_REQUEST["P_FN_CD2"];						
			$resultMap['P_FN_NM'] = $_REQUEST["P_FN_NM"];
			$resultMap['P_AMT'] = $_REQUEST["P_AMT"];
			$resultMap['P_UNAME'] = $_REQUEST["P_UNAME"];
			$resultMap['P_RMESG1'] = $_REQUEST["P_RMESG1"];
			$resultMap['P_RMESG2'] = $_REQUEST["P_RMESG2"];
			$resultMap['P_NOTI'] = $_REQUEST["P_NOTI"];
			$resultMap['P_AUTH_NO'] = $_REQUEST["P_AUTH_NO"];
			//$resultMap['P_CARD_ISSER_CODE'] = $_REQUEST["P_CARD_ISSER_CODE"];
			$resultMap['P_CARD_NUM'] = $_REQUEST["P_CARD_NUM"];
			$resultMap['P_PRTC_CODE'] = $_REQUEST["P_PRTC_CODE"];
			$resultMap['P_SRC_CODE'] = $_REQUEST["P_SRC_CODE"];
			
			
			
			
			
			//$resultMap[] = iconv("EUC-KR", "UTF-8", $value);
			$resultMap['P_TID'] = iconv("EUC-KR", "UTF-8",$_REQUEST["P_TID"]);
			$resultMap['P_MID'] = iconv("EUC-KR", "UTF-8",$_REQUEST["P_MID"]);
			$resultMap['P_AUTH_DT'] = iconv("EUC-KR", "UTF-8",$_REQUEST["P_AUTH_DT"]);
			$resultMap['P_STATUS'] = iconv("EUC-KR", "UTF-8",$_REQUEST["P_STATUS"]);
			$resultMap['P_TYPE'] = iconv("EUC-KR", "UTF-8",$_REQUEST["P_TYPE"]);
			$resultMap['P_OID'] = iconv("EUC-KR", "UTF-8",$_REQUEST["P_OID"]);
			$resultMap['P_FN_CD1'] = iconv("EUC-KR", "UTF-8",$_REQUEST["P_FN_CD1"]);
			$resultMap['P_FN_CD2'] = iconv("EUC-KR", "UTF-8",$_REQUEST["P_FN_CD2"]);						
			$resultMap['P_FN_NM'] = iconv("EUC-KR", "UTF-8",$_REQUEST["P_FN_NM"]);
			$resultMap['P_AMT'] = iconv("EUC-KR", "UTF-8",$_REQUEST["P_AMT"]);
			$resultMap['P_UNAME'] = iconv("EUC-KR", "UTF-8",$_REQUEST["P_UNAME"]);
			$resultMap['P_RMESG1'] = iconv("EUC-KR", "UTF-8",$_REQUEST["P_RMESG1"]);
			$resultMap['P_RMESG2'] = iconv("EUC-KR", "UTF-8",$_REQUEST["P_RMESG2"]);
			$resultMap['P_NOTI'] = iconv("EUC-KR", "UTF-8",$_REQUEST["P_NOTI"]);
			$resultMap['P_AUTH_NO'] = iconv("EUC-KR", "UTF-8",$_REQUEST["P_AUTH_NO"]);
			//$resultMap['P_CARD_ISSER_CODE'] = iconv("EUC-KR", "UTF-8",$_REQUEST["P_CARD_ISSER_CODE"]);
			$resultMap['P_CARD_NUM'] = iconv("EUC-KR", "UTF-8",$_REQUEST["P_CARD_NUM"]);
			$resultMap['P_PRTC_CODE'] = iconv("EUC-KR", "UTF-8",$_REQUEST["P_PRTC_CODE"]);
			$resultMap['P_SRC_CODE'] = iconv("EUC-KR", "UTF-8",$_REQUEST["P_SRC_CODE"]);
			
			foreach ($resultMap as $key => $value) {
				//$resultMap[$key] = iconv("EUC-KR", "UTF-8", $value);
				
			}
			//log_message("debug","map=>".$resultMap);
			
			//WEB 방식의 경우 가상계좌 채번 결과 무시 처리
			//(APP 방식의 경우 해당 내용을 삭제 또는 주석 처리 하시기 바랍니다.)
			if($resultMap['P_TYPE'] == "VBANK")	//결제수단이 가상계좌이며
	        	{
	           	   if($P_STATUS != "02") //입금통보 "02" 가 아니면(가상계좌 채번 : 00 또는 01 경우)
	           	   {
		              echo "OK";
	        	      return;
	           	   }
	        	}
			
		
					
			// if(데이터베이스 등록 성공 유무 조건변수 = true)
			//$status = $this->_m_inicis_noti_save($resultMap); //컨트롤 호출
			
			log_message("info","P_STATUS = ".$resultMap['P_STATUS']);
			
			if($resultMap['P_STATUS'] == "01"){
				echo "FAIL";
				exit;
				//결제 실패 저장 안함.
			}
			//저장과 데이터 확인
			$status =  $this->order_model->m_inicis_noti_save($resultMap);
			
			log_message("info","status".$status['status']);
			
			$PageCall_time = date("H:i:s");
			$value = array(
				"PageCall time" => $PageCall_time,
				"P_TID"			=> $resultMap['P_TID'],  
				"P_MID"     => $resultMap['P_MID'],  
				"P_AUTH_DT" => $resultMap['P_AUTH_DT'],      
				"P_STATUS"  => $resultMap['P_STATUS'],
				"P_TYPE"    => $resultMap['P_TYPE'],     
				"P_OID"     => $resultMap['P_OID'],  
				"P_FN_CD1"  => $resultMap['P_FN_CD1'],
				"P_FN_CD2"  => $resultMap['P_FN_CD2'],
				"P_FN_NM"   => $resultMap['P_FN_NM'],  
				"P_AMT"     => $resultMap['P_AMT'],  
				"P_UNAME"   => $resultMap['P_UNAME'],  
				"P_RMESG1"  => $resultMap['P_RMESG1'],  
				"P_RMESG2"  => $resultMap['P_RMESG2'],
				"P_NOTI"    => $resultMap['P_NOTI'],  
				"P_AUTH_NO" => $resultMap['P_AUTH_NO']
				);
			$this->_writeLog($value);
			
			if($status['status'] == true){
			    echo "OK"; //절대로 지우지 마세요
			}else{
				echo "FAIL";
			}
		}else{
			//ip가 안맞음
			echo "FAIL"; //잘못 들어옴
			
		}		
	}

	function _writeLog($msg){
		/*
	    $file = FCPATH. "\application\logs\noti_input_".date("Ymd").".log";
	
	    if(!($fp = fopen($file, "a+"))) return 0;
	                
	    ob_start();
	    print_r($msg);
	    $ob_msg = ob_get_contents();
	    ob_clean();
			
	    if(fwrite($fp, " ".$ob_msg."\n") === FALSE)
	    {
	        fclose($fp);
	        return 0;
	    }
	    fclose($fp);
		 * 
		 */
	    return 1;
	}

	
	//이니시스 kpay -- 결제 처리 저장 끝내고 값 비교 하는 곳
	function m_inicis_return($location){
		$data = $this->_cart_ids();	
		$p_oid= $this->input->get('P_OID',true);
		//$save_oid = $this->session->userdata("save_oid");
		$db_data = $this->order_model->m_inicis_return($p_oid); //저장 되었는지 확인 및 데이터 가져오기
		
		$data['order'] =$db_data['order'];
		
		if($db_data['order']['id']){
			$this->load->view($location."/order/m_inicis_return_v",$data);
		}else{
			alert_parent("결제 처리에 오류가 발생 하였습니다. 결제 대금이 입금이 되셨을 경우, 문의해 주십시오.","/order/form");
		}
	}
	
	//이니시스 모바일 결제 처리
	function m_inicis_next($location){
		//$this->output->set_header("");
		$this->load->helper('html');
		echo meta('Content-type', 'text/html; charset=euc-kr', 'equiv');
		echo meta(array('name' => 'robots', 'content' => 'no-cache'));
		
		include_once(APPPATH. "/libraries/INImx.php");
		
		//$this->load->library('HttpClient');
		//$this->load->library('INImx');
		
		$inimx = new INImx;
		
		

		/////////////////////////////////////////////////////////////////////////////
		///// 1. 변수 초기화 및 POST 인증값 받음                                 ////
		/////////////////////////////////////////////////////////////////////////////
		
		$inimx->reqtype 		= "PAY";  //결제요청방식
		$inimx->inipayhome 	= FCPATH."inicis"; //로그기록 경로 (이 위치의 하위폴더에 log폴더 생성 후 log폴더에 대해 777 권한 설정)
		$inimx->status			= $P_STATUS;
		$inimx->rmesg1			= $P_RMESG1;
		$inimx->tid		= $P_TID;
		$inimx->req_url		= $P_REQ_URL;
		$inimx->noti		= $P_NOTI;
		
		
		/////////////////////////////////////////////////////////////////////////////
		///// 2. 상점 아이디 설정 :                                              ////
		/////    결제요청 페이지에서 사용한 MID값과 동일하게 세팅해야 함...      ////
		/////    인증TID를 잘라서 사용가능 : substr($P_TID,'10','10');           ////
		/////////////////////////////////////////////////////////////////////////////
		$inimx->id_merchant = substr($P_TID,'10','10');  //
		if($inimx->status =="00") {// 모바일 인증이 성공시			
			/////    인증성공시  P_REQ_URL로 승인요청을 함...                        ////
			$inimx->startAction();  // 승인요청
			$inimx->getResult();  //승인결과 파싱, P_REQ_URL에서 내려준 결과값 파싱 
			
			//var_dump($inimx);
			
			//받아온 캐릭터 값 전부 변환
			foreach ($inimx as $key => $value) {
				$inimx->$key = iconv("EUC-KR", "UTF-8", $value);
			}
			//var_dump($inimx);
			//echo $str = iconv("EUC-KR", "UTF-8", $inimx->m_resultMsg);
			
			$this->_m_inicis_save($inimx);
			
			/*
			switch($inimx->m_payMethod){
				   
      			
				case("CARD"):  //신용카드 안심클릭
  					echo("승인결과코드:".$inimx->m_resultCode."<br>");
					echo("결과메시지:".$inimx->m_resultMsg."<br>");
					echo("지불수단:".$inimx->m_payMethod."<br>");
					echo("주문번호:".$inimx->m_moid."<br>");
					echo("TID:".$inimx->m_tid."<br>");
					echo("승인금액:".$inimx->m_resultprice."<br>");
					echo("승인일:".$inimx->m_pgAuthDate."<br>");
					echo("승인시각:".$inimx->m_pgAuthTime."<br>");
					echo("상점ID:".$inimx->m_mid."<br>");
					echo("구매자명:".$inimx->m_buyerName."<br>");
					echo("P_NOTI:".$inimx->m_noti."<br>");
					echo("NEXT_URL:".$inimx->m_nextUrl."<br>");
					echo("NOTI_URL:".$inimx->m_notiUrl."<br>");
					echo("승인번호:".$inimx->m_authCode."<br>");
					echo("할부개월:".$inimx->m_cardQuota."<br>");
					echo("카드코드:".$inimx->m_cardCode."<br>");
					echo("발급사코드:".$inimx->m_cardIssuerCode."<br>");
					echo("카드번호:".$inimx->m_cardNumber."<br>");
					echo("가맹점번호:".$inimx->m_cardMember."<br>");
					echo("매입사코드:".$inimx->m_cardpurchase."<br>");
					echo("부분취소가능여부(0:불가, 1:가능):".$inimx->m_prtc."<br>");
  					break;
  	  			case("MOBILE"):  //휴대폰결제
					echo("승인결과코드:".$inimx->m_resultCode."<br>");
					echo("결과메시지:".$inimx->m_resultMsg."<br>");
					echo("지불수단:".$inimx->m_payMethod."<br>");
					echo("주문번호:".$inimx->m_moid."<br>");
					echo("TID:".$inimx->m_tid."<br>");
					echo("승인금액:".$inimx->m_resultprice."<br>");
					echo("승인일:".$inimx->m_pgAuthDate."<br>");
					echo("승인시각:".$inimx->m_pgAuthTime."<br>");
					echo("상점ID:".$inimx->m_mid."<br>");
					echo("구매자명:".$inimx->m_buyerName."<br>");
					echo("P_NOTI:".$inimx->m_noti."<br>");
					echo("NEXT_URL:".$inimx->m_nextUrl."<br>");
					echo("NOTI_URL:".$inimx->m_notiUrl."<br>");
					echo("통신사:".$inimx->m_codegw."<br>");
					break;
				case("VBANK"):  //가상계좌 
					echo("승인결과코드:".$inimx->m_resultCode."<br>");
					echo("결과메시지:".$inimx->m_resultMsg."<br>");
					echo("지불수단:".$inimx->m_payMethod."<br>");
					echo("주문번호:".$inimx->m_moid."<br>");
					echo("TID:".$inimx->m_tid."<br>");
					echo("승인금액:".$inimx->m_resultprice."<br>");
					echo("요청일:".$inimx->m_pgAuthDate."<br>");
					echo("요청시각:".$inimx->m_pgAuthTime."<br>");
					echo("상점ID:".$inimx->m_mid."<br>");
					echo("구매자명:".$inimx->m_buyerName."<br>");
					echo("P_NOTI:".$inimx->m_noti."<br>");
					echo("NEXT_URL:".$inimx->m_nextUrl."<br>");
					echo("NOTI_URL:".$inimx->m_notiUrl."<br>");
					echo("가상계좌번호:".$inimx->m_vacct."<br>");
					echo("입금예정일:".$inimx->m_dtinput."<br>");
					echo("입금예정시각:".$inimx->m_tminput."<br>");
					echo("예금주:".$inimx->m_nmvacct."<br>");
					echo("은행코드:".$inimx->m_vcdbank."<br>");  
					break;
  				default: //문화상품권,해피머니
					echo("승인결과코드:".$inimx->m_resultCode."<br>");
					echo("결과메시지:".$inimx->m_resultMsg."<br>");
					echo("지불수단:".$inimx->m_payMethod."<br>");
					echo("주문번호:".$inimx->m_moid."<br>");
					echo("TID:".$inimx->m_tid."<br>");
					echo("승인금액:".$inimx->m_resultprice."<br>");
					echo("승인일:".$inimx->m_pgAuthDate."<br>");
					echo("승인시각:".$inimx->m_pgAuthTime."<br>");
					echo("상점ID:".$inimx->m_mid."<br>");
					echo("구매자명:".$inimx->m_buyerName."<br>");
					echo("P_NOTI:".$inimx->m_noti."<br>");
					echo("NEXT_URL:".$inimx->m_nextUrl."<br>");
					echo("NOTI_URL:".$inimx->m_notiUrl."<br>");
  			
			}
			*/
		} else {// 모바일 인증 실패
			alert_parent("모바일 인증 실패!");
		 // echo("인증결과코드:".$inimx->status);
		  //echo("<br>");
		  //echo("인증결과메시지:".$inimx->rmesg1);
		}
	  
	}
	
	/**
	 * 모바일 이니시스 저장 전용 - 가상계좌 저장 전용
	 *
	 */  
	function _m_inicis_save($resultMap){
		
		//echo $resultMap->status;
		//echo "<pre>"; 
		//print_r($resultMap);
		//echo "</pre>";
		
		$username = 	$this->session->userdata('ss_username');				//세션처리 //주문자
		$email =		$this->session->userdata('ss_email');				//세션처리 //이메일
		$point = 		$this->session->userdata('ss_point');				//세션처리 //포인트
		$couponid = 	$this->session->userdata('ss_couponid');				//세션처리 //쿠폰아이디
		$password = 	$this->session->userdata('ss_password');				//세션처리 //패스워드
		
		//해당 세션들 지움
		$this->session->unset_userdata('ss_username');
		$this->session->unset_userdata('ss_email');
		$this->session->unset_userdata('ss_point');
		$this->session->unset_userdata('ss_couponid');
		$this->session->unset_userdata('ss_password');
		
		$pay_bank_code = "";
		
		if($this->agent->is_mobile()){
			$device = "M";
		}else{
			$device = "PC";	
		}
		
		$memberId = "";		
		//패스워드 로그인이 안된 사람이면 입력 받은 값을 md5로 암호
		if(!$this->session->userdata['password']){
			//$memberPassword = hash("sha512", $password);
			$memberPassword = md5($password);
		}else{
			$memberPassword = $this->session->userdata['password']; 
		}
		
		 
		$ip = $this->input->ip_address();		
		$status = '02'; //02 준비
		$beforeStatus = '02'; //무비메이커  노출 상태
		$enable = "r";
		
		if($resultMap->m_payMethod == "VBANK"){ //-- 수정 2015 11 23
			$status = '01'; //1은 무통장 입금 대기 상태
			$beforeStatus = '01'; //무비메이커 비 노출 상태	
		}
		
		//order-item
		//주문번호만 있으면 됨
		
		//order-payment
		$bankNo = BANK_NUM; //입금주 입금은행
		$bankMemberName = "주식회사  위드비디"; //		
		$payMethod = $resultMap->m_payMethod;
		
		
		//중요...
		//echo("주문번호:".$inimx->m_moid."<br>");
		//echo("TID:".$inimx->m_tid."<br>");
		
		$payId = $resultMap->m_tid; //이게 있어야 환불이 가능함		
		$oid  = $resultMap->m_moid;
		
		
		$cart_data = $this->_cart_ids();
		if(!$point) $point = 0;
		
		$data = array(			
			'username'=>$username,		
			'email'=>$email,			
			'point'=>$point,		
			'couponId'=>$couponid,		
			'pay_bank_code' => $pay_bank_code,
			'device' => $device,
			'memberId' => $memberId,
			'memberPassword' => $memberPassword,		
			'ip' => $this->input->ip_address(),
			'modifyDatetime' => date("Y-m-d H:i:s"),
			'createDatetime' => date("Y-m-d H:i:s"),
			'status' => $status,
			'beforeStatus' => $beforeStatus,		
			'enable' => 'r',		
			'bankNo' => $bankNo,
			'bankMemberName' => $bankMemberName,
			'payMethod' => $payMethod,					
			'payId' => $payId,
			'oid'   => $oid			
		);
		
		$status = $this->order_model->m_inicis_save($cart_data, $data, $resultMap);
		//정상 처리 되었다면
		if($status['status'] == true){
			
			//기본정보
			$send_email = $email; //받을 이메일
			$oid = $status['oid']; //주문번호
			//$point = 0; //사용포인트
			$pay_type = '이니시스_'.$payMethod; //결제 방법
			$payment = $resultMap->m_resultprice; //최종 결제액
			

			$fin_is_member = '비회원';
			if($this->session->userdata("mid")) $fin_is_member = '회원';
			
			//메일 발송		
			$this->temp_email->order_fin_mail_send($send_email, $oid, $point, $pay_type, $payment, $fin_is_member, $cart_data);
						
			//세션 생성			
			$new_data = array(
				'fin_oid'=>$oid,
				'fin_use_point'=>$point,				
				'fin_total_pay'=>$payment,
				'fin_is_member'=>$fin_is_member,
				'fin_name'=>$username,
				'fin_email'=>$email
			);
			$this->session->set_userdata($new_data);
			
			//완료 페이지로 넘기기
			alert('주문이 성공적으로 저장 되었습니다.',"/order/finish");
		}else{
			alert("상품 저장에 실패 하였습니다.\r\n운영자에게 문의해 주십시오.","/");
		}
		
		
	}
	
	
	/**
	 * 웹표준 이니시스 리턴
	 */
    function inicis_return($location) {
		//require_once('../libs/INIStdPayUtil.php');
		//require_once('../libs/HttpClient.php');
		
		//$P_REQ_URL = $this->input->get_post('P_REQ_URL', TRUE);
		//print_r($P_REQ_URL);		
		//echo "<br><br><br><br><br><br><br>===>".$P_REQ_URL; //왜 있는건지? 문의는 한번 넣을 필요.. 	
		
		$this->load->library('INIStdPayUtil');
		$this->load->library('HttpClient');
		
		$util = new INIStdPayUtil();
				
		$data['resultCode']=$this->input->post('resultCode', TRUE);
		$data['resultMsg']=$this->input->post('resultMsg', TRUE);
		$data['returnUrl']=$this->input->post('returnUrl', TRUE);
		$data['merchantData']=$this->input->post('merchantData', TRUE);
		$data['netCancelUrl']=$this->input->post('netCancelUrl', TRUE);
		$data['orderNumber']=$this->input->post('orderNumber', TRUE);
		$data['authUrl']=$this->input->post('authUrl', TRUE);
		$data['authToken']=$this->input->post('authToken', TRUE);
		$data['charset']=$this->input->post('charset', TRUE);
		$data['mid']=$this->input->post('mid', TRUE);
		$data['checkAckUrl']=$this->input->post('checkAckUrl', TRUE);
		
		
		$mid = $data['mid'];     // 가맹점 ID 수신 받은 데이터로 설정
		
		$signKey = SINGNKEY; // 가맹점에 제공된 키(이니라이트키) (가맹점 수정후 고정) !!!절대!! 전문 데이터로 설정금지
		
		$timestamp = $util->getTimestamp();   // util에 의해서 자동생성
		
		$charset = "UTF-8";        // 리턴형식[UTF-8,EUC-KR](가맹점 수정후 고정)
		
		$format = "JSON";        // 리턴형식[XML,JSON,NVP](가맹점 수정후 고정)
		// 추가적 noti가 필요한 경우(필수아님, 공백일 경우 미발송, 승인은 성공시, 실패시 모두 Noti발송됨) 미사용 
		//String notiUrl	= "";
		
		$authToken = $data['authToken'];   // 취소 요청 tid에 따라서 유동적(가맹점 수정후 고정)
		
		$authUrl = $data['authUrl'];    // 승인요청 API url(수신 받은 값으로 설정, 임의 세팅 금지)
		
		$netCancel = $data['netCancelUrl'];   // 망취소 API url(수신 받은f값으로 설정, 임의 세팅 금지)
		
		$ackUrl = $data['checkAckUrl'];   // 가맹점 내부 로직 처리후 최종 확인 API URL(수신 받은 값으로 설정, 임의 세팅 금지)
		
		$quota = 0;

		if (strcmp("0000", $_REQUEST["resultCode"]) == 0) {
			//#####################
			// 2.signature 생성
			//#####################
			$signParam["authToken"] = $authToken;  // 필수
			$signParam["timestamp"] = $timestamp;  // 필수
			// signature 데이터 생성 (모듈에서 자동으로 signParam을 알파벳 순으로 정렬후 NVP 방식으로 나열해 hash)
			$signature = $util->makeSignature($signParam);
			
			
			//#####################
			// 3.API 요청 전문 생성
			//#####################
			$authMap["mid"] = $mid;   // 필수
			$authMap["authToken"] = $authToken; // 필수
			$authMap["signature"] = $signature; // 필수
			$authMap["timestamp"] = $timestamp; // 필수
			$authMap["charset"] = $charset;  // default=UTF-8
			$authMap["format"] = $format;  // default=XML
			//if(null != notiUrl && notiUrl.length() > 0){
			//	authMap.put("notiUrl"		,notiUrl);
			//}
			
			try {
				// 수신결과를 파싱후 resultCode가 "0000"이면 승인성공 이외 실패
				// 가맹점에서 스스로 파싱후 내부 DB 처리 후 화면에 결과 표시
				// payViewType을 popup으로 해서 결제를 하셨을 경우
				// 내부처리후 스크립트를 이용해 opener의 화면 전환처리를 하세요
				//throw new Exception("강제 Exception");
			
			    $httpUtil = new HttpClient();
			
				//#####################
				// 4.API 통신 시작
				//#####################
			
				$authResultString = "";
				if ($httpUtil->processHTTP($authUrl, $authMap)) {
				    $authResultString = $httpUtil->body;
				} else {
				    echo "Http Connect Error\n";
					echo $httpUtil->errormsg;		
					throw new Exception("Http Connect Error");
				}
				$resultMap = json_decode($authResultString, true);
				 
				 //print_r($resultMap);
				if (strcmp("0000", $resultMap["resultCode"]) == 0) {
					/** ***************************************************************************
				 		* 여기에 가맹점 내부 DB에 결제 결과를 반영하는 관련 프로그램 코드를 구현한다.
				 		 [중요!] 승인내용에 이상이 없음을 확인한 뒤 가맹점 DB에 해당건이 정상처리 되었음을 반영함 처리중 에러 발생시 망취소를 한다.
				
				
				  		* 내부로직 처리가 정상적으로 완료 되면 ackUrl로 결과 통신한다.
				  		만약 ACK통신중 에러 발생시(exeption) 망취소를 한다.
				 	* **************************************************************************** */
					$checkMap["mid"] = $mid;        // 필수					
					$checkMap["tid"] = $resultMap["tid"];    // 필수					
					$checkMap["applDate"] = $resultMap["applDate"];  // 필수					
					$checkMap["applTime"] = $resultMap["applTime"];  // 필수					
					$checkMap["price"] = $resultMap["TotPrice"];   // 필수					
					$checkMap["goodsName"] = $resultMap["goodsName"];  // 필수				
					$checkMap["charset"] = $charset;  // default=UTF-8					
					$checkMap["format"] = $format;  // default=XML		
					
					$ackResultString = "";
					if ($httpUtil->processHTTP($ackUrl, $checkMap)) {
					    $ackResultString = $httpUtil->body;
					} else {
						echo "Http Connect Error\n";
						echo $httpUtil->errormsg;
						alert($httpUtil->errormsg);
						throw new Exception("Http Connect Error");
					}
					
					$ackMap = json_decode($ackResultString);
					
					//echo "<tr><th class='td01'><p>거래 성공 여부</p></th>";
					//echo "<td class='td02'><p>성공</p></td></tr>";
				} else {
					//실패
					alert('ACK 거래실패!');
				}
				
				//공통
				//$resultMap["tid"] 			거래번호
				//$resultMap["payMethod"] 		결제방법 지불수단
				//$resultMap["resultCode"] 		결과코드 
				//$resultMap["resultMsg"] 		결과내용
				//$resultMap["TotPrice"]		결제완료금액
				//$resultMap["orderNumber"]		주문번호
				//$resultMap["applDate"]		승인날짜
				//$resultMap["applTime"]		승인시간
								
				
				if (strcmp("VBank", $resultMap["payMethod"]) == 0) { //가상계좌
					//$resultMap["VACT_Num"] 				입금계좌번호
					//$resultMap["VACT_BankCode"] 			입금은행코드
					//$resultMap["vactBankName"]			입금은행명
					//$resultMap["VACT_Name"]				예금주 명
					//$resultMap["VACT_InputName"]			송금자 명
					//$resultMap["VACT_Date"]				송금일자
					//$resultMap["VACT_Time"]				송금시간
					
				} else if (strcmp("DirectBank", $resultMap["payMethod"]) == 0) { //실시간계좌이체
					//$resultMap["ACCT_BankCode"]			은행코드
					//$resultMap["CSHRResultCode"]			현금영수증 발급결과 코드 [(0 - 소득공제용, 1 - 지출증빙용)]
					
				} else if (strcmp("HPP", $resultMap["payMethod"]) == 0) { //휴대폰
				} else if (strcmp("KWPY", $resultMap["payMethod"]) == 0) { //뱅크월렛 카카오
				} else if (strcmp("DGCL", $resultMap["payMethod"]) == 0) { //게임문화상품권
				} else if (strcmp("OCBPoint", $resultMap["payMethod"]) == 0) { //오케이 캐쉬백
				} else if (strcmp("GSPT", $resultMap["payMethod"]) == 0) { //GSPoint
				} else if (strcmp("UPNT", $resultMap["payMethod"]) == 0) {  //U-포인트
				} else if (strcmp("KWPY", $resultMap["payMethod"]) == 0) {  //뱅크월렛 카카오
				} else if (strcmp("YPAY", $resultMap["payMethod"]) == 0) { //엘로우 페이
				} else if (strcmp("TEEN", $resultMap["payMethod"]) == 0) { //틴캐시
				} else if (strcmp("Bookcash", $resultMap["payMethod"]) == 0) { //도서문화상품권
				} else { //카드
					//$resultMap["CARD_Num"]				카드번호
					//$resultMap["CARD_Quota"]				할부기간
					
						if (strcmp("1", $resultMap["CARD_Interest"]) == 0 || strcmp("1", $resultMap["EventCode"]) == 0) {
                            //할부 유형 - 무이자							
                        } else if ($quota > 0 && !strcmp("1", $resultMap["CARD_Interest"]) == 0) {
                        	//할부 유명 유이자					
                        }
                        
                        if (strcmp("1", $resultMap["point"]) == 0) {
                        	//포인트 사용
                        } else {
                        	//포인트 미사용
						}
					//$resultMap["cardCode"]				카드종류
					//$resultMap["cardCode"]				카드발급사
					
					
				}
				//이니시스 결과 저장
				$this->_save_inicis($resultMap);
				
				
			}catch (Exception $e) {
					//    $s = $e->getMessage() . ' (오류코드:' . $e->getCode() . ')';
	                //####################################
	                // 실패시 처리(***가맹점 개발수정***)
	                //####################################
	                //---- db 저장 실패시 등 예외처리----//
	                $s = $e->getMessage() . ' (오류코드:' . $e->getCode() . ')';
	                echo $s;
	
	                //#####################
	                // 망취소 API
	                //#####################
	
	                $netcancelResultString = ""; // 망취소 요청 API url(고정, 임의 세팅 금지)
	                if ($httpUtil->processHTTP($netCancel, $authMap)) {
	                    $netcancelResultString = $httpUtil->body;
	                } else {
	                    echo "Http Connect Error\n";
	                    echo $httpUtil->errormsg;
	
	                    throw new Exception("Http Connect Error");
	                }
	
	                echo "## 망취소 API 결과 ##";
	
	                $netcancelResultString = str_replace("<", "&lt;", $$netcancelResultString);
	                $netcancelResultString = str_replace(">", "&gt;", $$netcancelResultString);
	
	                echo "<pre>", $netcancelResultString . "</pre>";
	                // 취소 결과 확인	
			}
		
		} else {
			//#############
			// 인증 실패시
			//#############
			alert('이니시스 인증 실패!','/order/form/');			
			//echo "<pre>" . var_dump($_REQUEST) . "</pre>";
		}
		//$this->load->view($location."/order/inicis_return_v", $data);
	}
	
	/**
	 * 웹표준 이니시스 저장
	 */
	function _save_inicis($resultMap){
		$username = 	$this->session->userdata('ss_username');				//세션처리 //주문자
		$email =		$this->session->userdata('ss_email');				//세션처리 //이메일
		$point = 		$this->session->userdata('ss_point');				//세션처리 //포인트
		$couponid = 	$this->session->userdata('ss_couponid');				//세션처리 //쿠폰아이디
		$password = 	$this->session->userdata('ss_password');				//세션처리 //패스워드
		
		//해당 세션들 지움
		$this->session->unset_userdata('ss_username');
		$this->session->unset_userdata('ss_email');
		$this->session->unset_userdata('ss_point');
		$this->session->unset_userdata('ss_couponid');
		$this->session->unset_userdata('ss_password');
		
		$pay_bank_code = "";
		
		if($this->agent->is_mobile()){
			$device = "M";
		}else{
			$device = "PC";	
		}
		
		$memberId = "";		
		//패스워드 로그인이 안된 사람이면 입력 받은 값을 md5로 암호
		if(!$this->session->userdata['password']){
			//$memberPassword = hash("sha512", $password);
			$memberPassword = md5($password);
		}else{
			$memberPassword = $this->session->userdata['password']; 
		}
		
		
		$ip = $this->input->ip_address();		
		$status = '02'; //02 준비
		$beforeStatus = '02'; //무비메이커  노출 상태
		$enable = "r";
		
		if($resultMap['payMethod'] == "VBank"){
			$status = '01'; //1은 무통장 입금 대기 상태
			$beforeStatus = '01'; //무비메이커 비 노출 상태	
		}
		
		//order-item
		//주문번호만 있으면 됨
		
		//order-payment
		$bankNo = BANK_NUM; //입금주 입금은행
		$bankMemberName = "주식회사  위드비디"; //		
		$payMethod = $resultMap['payMethod'];
		
		
		//중요...
		$payId = $resultMap['tid'];		
		$oid  = $resultMap['payMethod'];
		
		
		$cart_data = $this->_cart_ids();
		if(!$point) $point = 0;
		
		//코드 치환. 00 성공 01 실패
		if($resultMap['resultCode'] == "0000") $resultMap['resultCode'] = "00";
		
		$data = array(
			'username'=>$username,		
			'email'=>$email,			
			'point'=>$point,		
			'couponId'=>$couponid,		
			'pay_bank_code' => $pay_bank_code,
			'device' => $device,
			'memberId' => $memberId,
			'memberPassword' => $memberPassword,		
			'ip' => $this->input->ip_address(),
			'modifyDatetime' => date("Y-m-d H:i:s"),
			'createDatetime' => date("Y-m-d H:i:s"),
			'status' => $status,
			'beforeStatus' => $beforeStatus,		
			'enable' => 'r',		
			'bankNo' => $bankNo,
			'bankMemberName' => $bankMemberName,
			'payMethod' => $payMethod,					
			'payId' => $payId,
			'oid'   => $oid			
		);
		
		$status = $this->order_model->inicis_save($cart_data, $data, $resultMap);
		
		//정상 처리 되었다면
		if($status['status'] == true){
			
			//기본정보
			$send_email = $email; //받을 이메일
			$oid = $status['oid']; //주문번호
			//$point = 0; //사용포인트
			$pay_type = '이니시스_'.$payMethod; //결제 방법
			$payment = $resultMap['TotPrice']; //최종 결제액
			

			$fin_is_member = '비회원';
			if($this->session->userdata("mid")) $fin_is_member = '회원';
			
			//메일 발송		
			$this->temp_email->order_fin_mail_send($send_email, $oid, $point, $pay_type, $payment, $fin_is_member, $cart_data);
			
			
			//세션 생성
			
			$new_data = array(
				'fin_oid'=>$oid,
				'fin_use_point'=>$point,				
				'fin_total_pay'=>$payment,
				'fin_is_member'=>$fin_is_member,
				'fin_name'=>$username,
				'fin_email'=>$email
			);
			$this->session->set_userdata($new_data);
			
			
			//완료 페이지로 넘기기
			 alert('주문이 성공적으로 저장 되었습니다.',"/order/finish");
		}else{
			alert("상품 저장에 실패 하였습니다.\r\n운영자에게 문의해 주십시오.","/");
		}
	}
			
	//ajax 이니시스 플래시 데이터 생성
	function ajax_inicis_init($location){
		$username = $this->input->post('username',true);
		$email = $this->input->post('email',true);
		$point = $this->input->post('point',true);
		$couponid = $this->input->post('couponid',true);
		$password = $this->input->post('password',true);
		
		$total_price = $this->input->post('total_price',true); //계산전 상품 값
		
		$newdata = array(
			'ss_username'  => $username,
			'ss_email'     => $email,
			'ss_point' => $point,
			'ss_couponid' => $couponid,
			'ss_password' => $password
		);

		$this->session->set_userdata($newdata);
		
		$total_price = $total_price - $point;
		
		$this->load->library('INIStdPayUtil');
		$SignatureUtil = new INIStdPayUtil();
		
		$signKey = SINGNKEY;
				
		$timestamp=$SignatureUtil->getTimestamp();
		$data['mid']= INICIS_MID;
		$data['oid']=$data['mid']."_".$timestamp;
		$data['timestamp']=$timestamp;
		$data['mkey']=$SignatureUtil->makeHash($signKey, "sha256");
		$params = array(
				"oid" => $data['oid'],
				"price" => $total_price,
				"timestamp" => $timestamp
		);
		$data['signature'] = $SignatureUtil->makeSignature($params, "sha256");
		
		$data['price'] = $total_price;
		
		
		$json_data = json_encode($data);
		print_r($json_data);
		
	}

	//ajax 모바일 이니시스 플래시 데이터 생성
	//-- 채번 저장용 임시 데이터도 같이 생성
	function ajax_minicis_init($location){
		log_message("debug","ajax_minicis_init");
		
		$username = $this->input->post('username',true);
		$email = $this->input->post('email',true);
		$point = $this->input->post('point',true);
		$couponid = $this->input->post('couponid',true);
		$password = $this->input->post('password',true);
		
		
		
				
		log_message("debug","username--" . $username);
		log_message("debug","email--" . $email);
		
		$total_price = $this->input->post('total_price',true); //계산전 상품 값
		$total_price = $total_price - $point; //포인트 계산
		
		$newdata = array(
			'ss_username'  => $username,
			'ss_email'     => $email,
			'ss_point' => $point,
			'ss_couponid' => $couponid,
			'ss_password' => $password
		);

		$this->session->set_userdata($newdata);
		
		
		//-- 저장용 임시 데이터
		// 이름, 이메일, 포인트, 쿠폰, 패스워드 + 
		
		$pay_bank_code = "";
		
		if($this->agent->is_mobile()){
			$device = "M";
		}else{
			$device = "PC";	
		}
		
		$memberId = "";
		//패스워드 로그인이 안된 사람이면 입력 받은 값을 md5로 암호
		if(!$password){
			//$memberPassword = hash("sha512", $password);
			$memberPassword = md5($password);
		}else{
			$memberPassword = $this->session->userdata['password']; 
		}

		$ip = $this->input->ip_address();		
		$status = '02'; //02 준비
		$beforeStatus = '02'; //무비메이커  노출 상태
		$enable = "r";

		//order-payment
		$bankNo = BANK_NUM; //입금주 입금은행
		$bankMemberName = "주식회사  위드비디"; //		
		$payMethod = "KPAY";
		$payId = "KPAY";
		
		$oid  = "";
		
		$cart_data = $this->_cart_ids();
				
		if(!$point) $point = 0;
		
		$data = array(			
			'username'=>$username,		
			'email'=>$email,			
			'point'=>$point,		
			'couponId'=>$couponid,		
			'pay_bank_code' => $pay_bank_code,
			'device' => $device,
			'memberId' => $memberId,
			'memberPassword' => $memberPassword,		
			'ip' => $this->input->ip_address(),
			'modifyDatetime' => date("Y-m-d H:i:s"),
			'createDatetime' => date("Y-m-d H:i:s"),
			'status' => $status,
			'beforeStatus' => $beforeStatus,		
			'enable' => 'r',		
			'bankNo' => $bankNo,
			'bankMemberName' => $bankMemberName,
			'payMethod' => $payMethod,					
			'payId' => $payId,
			'oid'   => $oid,
			'total_price' => $total_price			
		);
		
		

		$status = $this->order_model->ajax_minicis_init_save($cart_data, $data);
		//---------------
		
		$data['p_oid'] = $status['oid'];
		$data['return_point'] = $status['return_point'];
		$data['price'] = $total_price;
		$json_data = json_encode($data);
		print_r($json_data);
	}


	//포인트 구매 저장
	function ifream_point_insert($location){
		
		if(!$this->session->userdata['email']) alert('로그인 하셔야 진행 가능 합니다.');
		
		
		$email = $this->session->userdata['email'];
		$password = $this->input->post("password",true);			//패스워드
		
		
		//$exp = explode("@", $email);
		$username =$this->session->userdata['username'];
		
		//$price = $this->input->post("price",true);			////실제 가격 -- 카트로 처리
		
		$point = $this->input->post("point",true); 			//포인트
		
		if(!$point) alert("포인트를 입력해 주십시오.","/order/form/");
		$couponid = $this->input->post("couponid",true);	//쿠폰 번호
		
		$pay_bank_code = $this->input->post("pay_bank_code",true);			//결재할 은행 코드
		
		
		if($this->agent->is_mobile()){
			$device = "M";
		}else{
			$device = "PC";	
		}
		
		$memberId = "";
		$memberPassword = $this->session->userdata['password'];			
		$ip = $this->input->ip_address();
		
		
		//$modifyDatetime = date("Y-m-d H:i:s");
		//$createDatetime = date("Y-m-d H:i:s");
		$status = '02'; //1은 무통장 입금 대기 상태
		$beforeStatus = '02'; //무비메이커 비 노출 상태
		$enable = "r";
		
		//order-item
		//주문번호만 있으면 됨
		
		//order-payment
		$bankNo = BANK_NUM; //입금주 입금은행
		$bankMemberName = "주식회사  위드비디"; //		
		$payMethod = "point";
		$payId = "point";
		$oid  = "point";
		
		
		$cart_data = $this->_cart_ids();
		
		$data = array(			
			'username'=>$username,		
			'email'=>$email,			
			'point'=>$point,		
			'couponId'=>$couponid,		
			'pay_bank_code' => $pay_bank_code,
			'device' => $device,
			'memberId' => $memberId,		
			'memberPassword' => $memberPassword,		
			'ip' => $this->input->ip_address(),
			'modifyDatetime' => date("Y-m-d H:i:s"),
			'createDatetime' => date("Y-m-d H:i:s"),
			'status' => $status,
			'beforeStatus' => $beforeStatus,		
			'enable' => 'r',		
			'bankNo' => $bankNo,
			'bankMemberName' => '주식회사  위드비디',
			'payMethod' => 'point',					
			'payId' => $payId,
			'oid'   => $oid			
		);
		
		$status = $this->order_model->point_insert($cart_data, $data);
		if($status){
			
			//print_r($status);

			//기본정보
			$send_email = $email; //받을 이메일
			$oid = $status['oid']; //주문번호
			//$point = 0; //사용포인트
			$pay_type = '포인트구매';
			$payment = 0; //최종 결제액
			
			$fin_is_member = '비회원';
			if($this->session->userdata("mid")) $fin_is_member = '회원';

			//메일 발송		
			$this->temp_email->order_fin_mail_send($send_email, $oid, $point, $pay_type, $payment, $fin_is_member, $cart_data);
			
			
			//세션 생성
			
			$new_data = array(
				'fin_oid'=>$oid,
				'fin_use_point'=>$point,				
				'fin_total_pay'=>$payment,
				'fin_is_member'=>$fin_is_member,
				'fin_name'=>$username,
				'fin_email'=>$email
			);
			$this->session->set_userdata($new_data);
			
			//print_r($_POST);
			//print_r($new_data);
			//완료 페이지로 넘기기
			redirect(BASE_URL."/order/finish");
			//alert('주문이 성공적으로 저장 되었습니다.',"/order/finish");
			 
		}else{
			//alert("결재에 실패 하였습니다.");
		}
	}


	//페이팔
	function ifream_form_paypal($location){
		$data = $this->_cart_ids();

		$email_chk = null;
		if(isset($this->session->userdata['email'])){$email_chk = $this->session->userdata['email']; }
		if($email_chk && $email_chk == "kudomiyu@hanmail.net"){
			//페이팔 리턴
			define('PP_HOSTNAME','www.sandbox.paypal.com'); //test
			define('PP_AUTH_TOKEN','1DKax8uOsMqwO-q2A7nIiSkgSRgHtWeJHVBvirVW_ucS012auSRIK5Tf-ym'); //test

			//define('PP_HOSTNAME','www.paypal.com');
			//define('PP_AUTH_TOKEN','tthbdHIA4NXa3ci4803nAaw4PzSR4BHNi15UluA8U7VgtXu-yhKaJm5nsrG');


			//페이팔 결재 요청
			define('PP_URL','https://www.sandbox.paypal.com/kr/cgi-bin/webscr'); 	//test
			define('PP_RECV_MAIL','cswithvideo-facilitator-1@gmail.com');			//test

			//define('PP_URL','https://www.paypal.com/cgi-bin/webscr');
			//define('PP_RECV_MAIL','cswithvideo@gmail.com');
		}else{
			define('PP_HOSTNAME','www.paypal.com');
			define('PP_AUTH_TOKEN','tthbdHIA4NXa3ci4803nAaw4PzSR4BHNi15UluA8U7VgtXu-yhKaJm5nsrG');
			define('PP_URL','https://www.paypal.com/cgi-bin/webscr');
			define('PP_RECV_MAIL','cswithvideo@gmail.com');
		}

		$this->load->view($location."/order/m_ifream_form_paypal_v",$data);		
	}
	
	//ajax -- 페이팔 주문 채번 데이터 생성
	function ajax_paypal_init($location){
		
		$username = $this->input->post('username',true);
		$email = $this->input->post('email',true);
		$point = $this->input->post('point',true);
		$couponid = $this->input->post('couponid',true);
		$password = $this->input->post('password',true);
				
		$invoice= $this->input->post('invoice',true);//구분
		
		//log_message("debug","username--" . $username);
		//log_message("debug","email--" . $email);
		
		$total_price = $this->input->post('total_price',true); //계산전 상품 값
		
		
		if($this->agent->is_mobile()){
			$device = "M";
		}else{
			$device = "PC";	
		}
		
		$memberId = "";
		//패스워드 로그인이 안된 사람이면 입력 받은 값을 md5로 암호
		if(!$password){
			//$memberPassword = hash("sha512", $password);
			$memberPassword = md5($password);
		}else{
			$memberPassword = $this->session->userdata['password']; 
		}

		$ip = $this->input->ip_address();		
		$status = '02'; //02 준비
		$beforeStatus = '02'; //무비메이커  노출 상태
		$enable = "r";

		//order-payment
		$pay_bank_code = "";
		$bankNo = BANK_NUM; //입금주 입금은행
		$bankMemberName = "주식회사  위드비디"; //		
		$payMethod = "Paypal";
		$payId = "Paypal";
		
		$oid  = "";
		
		$cart_data = $this->_cart_ids();
				
		if(!$point) $point = 0;
		
		
		$point = 0;
		$data = array(			
			'username'=>$username,		
			'email'=>$email,			
			'point'=>$point,		
			'couponId'=>$couponid,		
			'pay_bank_code' => $pay_bank_code,
			'device' => $device,
			'memberId' => $memberId,
			'memberPassword' => $memberPassword,		
			'ip' => $this->input->ip_address(),
			'modifyDatetime' => date("Y-m-d H:i:s"),
			'createDatetime' => date("Y-m-d H:i:s"),
			'status' => $status,
			'beforeStatus' => $beforeStatus,		
			'enable' => 'r',		
			'bankNo' => $bankNo,
			'bankMemberName' => $bankMemberName,
			'payMethod' => $payMethod,					
			'payId' => $payId,
			'oid'   => $oid,
			'total_price' => $total_price,
			'invoice' =>$invoice
		);

		$status = $this->order_model->ajax_mpaypal_init_save($cart_data, $data);
		//---------------
		
		$data['p_oid'] = $status['oid'];
		$data['return_point'] = $status['return_point'];
		$data['price'] = $total_price;
		$json_data = json_encode($data);
		print_r($json_data);
	}
	
	
	//테스트 서버용
	function paypal_noti_t($location){				
		log_message("debug","paypal_noti_t");
		$invoice = $this->input->post('invoice', true);
		$status = $this->input->post('payment_status',true);
				
		//정상 이므로 저장
		if($status == "Completed"){
			$this->order_model->paypal_noti_t($invoice);
		}
	}
	
	//실제서버용
	function paypal_noti_p($location){
		//$this->output->enable_profiler(true);		
		log_message("debug","paypal_noti_p");		
		
		//invoice
		/*
		addr1 = request("address_street")								' 주문자 정보 - 주소
		city = request("address_city")								' 주문자 정보 - 도시
		company = request("payer_business_name")						' 주문자 정보 - 회사
		country = request("address_country")							' 주문자 정보 - 국가
		email = request("payer_email")								' 주문자 정보 -  email
		orderdate = request("payment_date")							' 주문일
		orderid = request("txn_id")									' 상품 주문 id (product order id)
		prodid = request("item_number")								' 상품의 id (product id)
		qty = request("quantity")									' 주문 수량 (order product quantity)
		state = request("address_state")								' 주문자 정보 - state(주)
		tot = request("mc_gross")									' 상품의 총 가격 (product total price)
		trackingid = request("txn_id")								' order trackin id
		ordername = request("last_name") & " " & request("first_name")	        ' 주문자 이름
		zip = request("address_zip")									' 주문자 정보 - 우편번호 (zip)
		payment_status = request("payment_status")						' 주문 상태 (payment status)
		 * 
		*/
		$invoice = $this->input->post('invoice', true);
		$status = $this->input->post('payment_status',true);
				
		log_message("debug","paypal_noti post[invoice] = ".$invoice);		
		log_message("debug","paypal_noti post[payment_status] = ".$status);
		
		//정상 이므로 저장
		//실섭용
		if($status == "Completed"){
			$this->order_model->paypal_noti_p($invoice);
		}
		
		
		
		
	}

	//모바일 사이트- noti 리턴
	function paypal_noti_m($location){
		//$this->output->enable_profiler(true);		
		log_message("debug","paypal_noti_m");		
		
		//invoice
		/*
		addr1 = request("address_street")								' 주문자 정보 - 주소
		city = request("address_city")								' 주문자 정보 - 도시
		company = request("payer_business_name")						' 주문자 정보 - 회사
		country = request("address_country")							' 주문자 정보 - 국가
		email = request("payer_email")								' 주문자 정보 -  email
		orderdate = request("payment_date")							' 주문일
		orderid = request("txn_id")									' 상품 주문 id (product order id)
		prodid = request("item_number")								' 상품의 id (product id)
		qty = request("quantity")									' 주문 수량 (order product quantity)
		state = request("address_state")								' 주문자 정보 - state(주)
		tot = request("mc_gross")									' 상품의 총 가격 (product total price)
		trackingid = request("txn_id")								' order trackin id
		ordername = request("last_name") & " " & request("first_name")	        ' 주문자 이름
		zip = request("address_zip")									' 주문자 정보 - 우편번호 (zip)
		payment_status = request("payment_status")						' 주문 상태 (payment status)
		 * 
		*/
		
		$invoice = $this->input->post('invoice', true);
		$status = $this->input->post('payment_status',true);
		
		log_message("debug","paypal_noti post[invoice] = ".$this->input->post('invoice'));		
		log_message("debug","paypal_noti post[payment_status] = ".$this->input->post('payment_status'));
		
		
		if($status == "Completed"){
			$this->order_model->paypal_noti_m($invoice);
		}
		
	}

	
	//페이팔 
	function paypal_return($location){
		log_message("debug","paypal_return");
		/*
		 * 
		string(1553) "HTTP/1.1 200 OK
		Date: Wed, 25 Nov 2015 03:29:30 GMT
		Server: Apache
		X-Frame-Options: SAMEORIGIN
		Set-Cookie: c9MWDuvPtT9GIMyPc3jwol1VSlO=oMdyuXwkQI4Zs53dGXU4CLb1by2DHTHkbPjEG23gzDS9U5Y76k-No44Qn9XQ02xa75-dfz3OiqKH-etO0TN0IvCwVXoHCfbVoGQxwwsTRPUHge2X7qtnKebh2USrk9E76aXmI5qlCJxnsJvGV_70MbZ-ki7YqZotC5HPadR9h_UGhfOnTVhcTyIfRqM74BtIoXWrdn3iywVIcbTqiZZwmmGxvPRxmEj6HQREPr27S-ecFT0hQhtDdsJJ9PZ8BWoVM_mgaOrtscJZZPYawgAGppVVWaVP-xXXgpXsStXXlMYAO9N5bbzwlXFjsV8tilyBHtv80og9Pt-53EOMIehT5dO26053XORVscUnpSYHATJb0eu0DzoSU9zOddsUKhNWyaPf9fKwB8kn-t2c0TInMPPedNd_7HzfnN9hr3oqyhfUGlCw57wPldyfCZ0; domain=.paypal.com; path=/; Secure; HttpOnly
		Set-Cookie: cookie_check=yes; expires=Sat, 22-Nov-2025 03:29:31 GMT; domain=.paypal.com; path=/; Secure; HttpOnly
		Set-Cookie: navcmd=_notify-validate; domain=.paypal.com; path=/; Secure; HttpOnly
		Set-Cookie: navlns=0.0; expires=Fri, 24-Nov-2017 03:29:31 GMT; domain=.paypal.com; path=/; Secure; HttpOnly
		Set-Cookie: Apache=10.72.108.11.1448422170850178; path=/; expires=Fri, 17-Nov-45 03:29:30 GMT
		Vary: Accept-Encoding,User-Agent
		Connection: close
		Paypal-Debug-Id: 77508800cb74f
		Set-Cookie: X-PP-SILOVER=name%3DSANDBOX3.WEB.1%26silo_version%3D880%26app%3Dappdispatcher%26TIME%3D439047510; domain=.paypal.com; path=/; Secure; HttpOnly
		Set-Cookie: X-PP-SILOVER=; Expires=Thu, 01 Jan 1970 00:00:01 GMT
		Set-Cookie: Apache=10.72.128.11.1448422170833137; path=/; expires=Fri, 17-Nov-45 03:29:30 GMT
		Strict-Transport-Security: max-age=14400
		Transfer-Encoding: chunked
		Content-Type: text/html; charset=UTF-8
		
		INVALID"
		 * 
		 * */
		 
		 /**
		  * <fieldset id="ci_profiler_get" style="border:1px solid #cd6e00;padding:6px 10px 10px 10px;margin:20px 0 20px 0;background-color:#eee;">
<legend style="color:#cd6e00;">&nbsp;&nbsp;GET DATA&nbsp;&nbsp;</legend>


<table style="width:100%;border:none;">
<tbody><tr><td style="width:50%;color:#000;background-color:#ddd;padding:5px;">$_GET['tx']&nbsp;&nbsp; </td><td style="width:50%;padding:5px;color:#cd6e00;font-weight:normal;background-color:#ddd;">4WK602335A5249147</td></tr>
<tr><td style="width:50%;color:#000;background-color:#ddd;padding:5px;">$_GET['st']&nbsp;&nbsp; </td><td style="width:50%;padding:5px;color:#cd6e00;font-weight:normal;background-color:#ddd;">Completed</td></tr>
<tr><td style="width:50%;color:#000;background-color:#ddd;padding:5px;">$_GET['amt']&nbsp;&nbsp; </td><td style="width:50%;padding:5px;color:#cd6e00;font-weight:normal;background-color:#ddd;">1.00</td></tr>
<tr><td style="width:50%;color:#000;background-color:#ddd;padding:5px;">$_GET['cc']&nbsp;&nbsp; </td><td style="width:50%;padding:5px;color:#cd6e00;font-weight:normal;background-color:#ddd;">USD</td></tr>
<tr><td style="width:50%;color:#000;background-color:#ddd;padding:5px;">$_GET['cm']&nbsp;&nbsp; </td><td style="width:50%;padding:5px;color:#cd6e00;font-weight:normal;background-color:#ddd;"></td></tr>
<tr><td style="width:50%;color:#000;background-color:#ddd;padding:5px;">$_GET['item_number']&nbsp;&nbsp; </td><td style="width:50%;padding:5px;color:#cd6e00;font-weight:normal;background-color:#ddd;">50</td></tr>
<tr><td style="width:50%;color:#000;background-color:#ddd;padding:5px;">$_GET['sig']&nbsp;&nbsp; </td><td style="width:50%;padding:5px;color:#cd6e00;font-weight:normal;background-color:#ddd;">tSU//ZK8/DAgIxu5Ec+o4XK86l25EGEbmI4V4LR9T8OJ4DJbneTovPz7ECWxVrjthcR2778/jqU/7XtkLqc7KlY4XeExmtPeDF8+z0LeJlrbkjkKGakrbGv1aHpv7ESaxBeNiPEOgRY2mM0I3OWq8irdmQ9uOMVkslFt8yz23eE=</td></tr>
</tbody></table>
</fieldset>
		  */
		//$this->output->enable_profiler(true);
		
		define("DEBUG", 1);
		
		// Set to 0 once you're ready to go live
		define("USE_SANDBOX", 1);
		
		
		//define("LOG_FILE", "./ipn.log");
		
		
		// Read POST data
		// reading posted data directly from $_POST causes serialization
		// issues with array data in POST. Reading raw POST data from input stream instead.
		$raw_post_data = file_get_contents('php://input');
		$raw_post_array = explode('&', $raw_post_data);
		$myPost = array();
		foreach ($raw_post_array as $keyval) {
			$keyval = explode ('=', $keyval);
			if (count($keyval) == 2)
				$myPost[$keyval[0]] = urldecode($keyval[1]);
		}
		// read the post from PayPal system and add 'cmd'
		$req = 'cmd=_notify-validate';
		if(function_exists('get_magic_quotes_gpc')) {
			$get_magic_quotes_exists = true;
		}
		foreach ($myPost as $key => $value) {
			if($get_magic_quotes_exists == true && get_magic_quotes_gpc() == 1) {
				$value = urlencode(stripslashes($value));
			} else {
				$value = urlencode($value);
			}
			$req .= "&$key=$value";
		}
		
		// Post IPN data back to PayPal to validate the IPN data is genuine
		// Without this step anyone can fake IPN data
		
		
		if(USE_SANDBOX == true) {
			$paypal_url = "https://www.sandbox.paypal.com/cgi-bin/webscr";
		} else {
			$paypal_url = "https://www.paypal.com/cgi-bin/webscr";
		}
		
		$paypal_url = "https://www.sandbox.paypal.com/cgi-bin/webscr";
		
		$ch = curl_init($paypal_url);
		if ($ch == FALSE) {
			return FALSE;
		}
		
		curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $req);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
		curl_setopt($ch, CURLOPT_FORBID_REUSE, 1);
		
		if(DEBUG == true) {
			curl_setopt($ch, CURLOPT_HEADER, 1);
			curl_setopt($ch, CURLINFO_HEADER_OUT, 1);
		}
		
		// CONFIG: Optional proxy configuration
		//curl_setopt($ch, CURLOPT_PROXY, $proxy);
		//curl_setopt($ch, CURLOPT_HTTPPROXYTUNNEL, 1);
		
		// Set TCP timeout to 30 seconds
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Connection: Close'));
		
		// CONFIG: Please download 'cacert.pem' from "http://curl.haxx.se/docs/caextract.html" and set the directory path
		// of the certificate as shown below. Ensure the file is readable by the webserver.
		// This is mandatory for some environments.
		
		//$cert = __DIR__ . "./cacert.pem";
		//curl_setopt($ch, CURLOPT_CAINFO, $cert);
		
		$res = curl_exec($ch);
		
		echo "<pre>";
		print_r($res);
		echo "</pre>";
		if (curl_errno($ch) != 0) // cURL error
			{
			if(DEBUG == true) {	
				//error_log(date('[Y-m-d H:i e] '). "Can't connect to PayPal to validate IPN message: " . curl_error($ch) . PHP_EOL, 3, LOG_FILE);
				log_message("error","paypal_curl_error");
			}
			curl_close($ch);
			exit;
		
		} else {
				// Log the entire HTTP response if debug is switched on.
				if(DEBUG == true) {
					//error_log(date('[Y-m-d H:i e] '). "HTTP request of validation request:". curl_getinfo($ch, CURLINFO_HEADER_OUT) ." for IPN payload: $req" . PHP_EOL, 3, LOG_FILE);
					//error_log(date('[Y-m-d H:i e] '). "HTTP response of validation request: $res" . PHP_EOL, 3, LOG_FILE);
					log_message("error","paypal_curl_http_error");
		
					// Split response headers and payload
					list($headers, $res) = explode("\r\n\r\n", $res, 2);
				}
				curl_close($ch);
		}
		
		// Inspect IPN validation result and act accordingly
		
		if (strcmp ($res, "VERIFIED") == 0) {
			// check whether the payment_status is Completed
			// check that txn_id has not been previously processed
			// check that receiver_email is your PayPal email
			// check that payment_amount/payment_currency are correct
			// process payment and mark item as paid.
		
			// assign posted variables to local variables
			//$item_name = $_POST['item_name'];
			//$item_number = $_POST['item_number'];
			//$payment_status = $_POST['payment_status'];
			//$payment_amount = $_POST['mc_gross'];
			//$payment_currency = $_POST['mc_currency'];
			//$txn_id = $_POST['txn_id'];
			//$receiver_email = $_POST['receiver_email'];
			//$payer_email = $_POST['payer_email'];
			
			if(DEBUG == true) {
				//error_log(date('[Y-m-d H:i e] '). "Verified IPN: $req ". PHP_EOL, 3, LOG_FILE);
				log_message("error","paypal_curl".date('[Y-m-d H:i e] '). "Verified IPN: $req ". PHP_EOL);
			}
		} else if (strcmp ($res, "INVALID") == 0) {
			// log for manual investigation
			// Add business logic here which deals with invalid IPN messages
			if(DEBUG == true) {
				//error_log(date('[Y-m-d H:i e] '). "Invalid IPN: $req" . PHP_EOL, 3, LOG_FILE);
				log_message("error","paypal_curl".date('[Y-m-d H:i e] '). "Verified IPN: $req ". PHP_EOL);
			}
		}
		
	}
	//
	
	//pin방식 리턴
	//모바일 사이트용 paypal
	function paypal_return_m($location){
		
		$invoice = $this->input->get('invoice',true);//해당 값으로 검색
		$cart_data = $this->_cart_ids();
		$email = $this->session->user_data['email'];
		$username = $this->session->user_data['username'];
		
		$paypal_obj  = $this->order_model->palpay_invoice_chk($invoice);
		$paypal_data = $paypal_obj ->row_array();
		
		
		
			
			//기본정보
			$send_email = $email; //받을 이메일
			$oid = $paypal_data['id']; //주문번호
			$point = 0; //사용포인트
			$pay_type = 'paypal';
			$payment = $paypal_data['price']; //최종 결제액
			
			$fin_is_member = '비회원';
			if($this->session->userdata("mid")) $fin_is_member = '회원';
			

			//메일 발송		
			$this->temp_email->order_fin_mail_send($send_email, $oid, $point, $pay_type, $payment, $fin_is_member, $cart_data);
			
			
			//세션 생성
			
			$new_data = array(
				'fin_oid'=>$oid,
				'fin_use_point'=>$point,				
				'fin_total_pay'=>$paypal_data['price'],
				'fin_is_member'=>$fin_is_member,
				'fin_name'=>$username,
				'fin_email'=>$email
			);
			$this->session->set_userdata($new_data);
			
			
			//완료 페이지로 넘기기
			 //redirect("/order/finish");
			 alert('주문이 성공적으로 저장 되었습니다.',"/order/finish");
		
	}
	
	//페이팔 리턴
	//tr 방식 - 사용안함
	function paypal_return_back($location) {
			/* 이니시스 리턴
			$data['resultcode']=$this->input->post('resultcode', TRUE);
			$data['resultmessage']=$this->input->post('resultmessage', TRUE);
			$data['mid']=$this->input->post('mid', TRUE);
			$data['tid']=$this->input->post('tid', TRUE);
			$data['webordernumber']=$this->input->post('webordernumber', TRUE);
			$data['goodname']=$this->input->post('goodname', TRUE);
			$data['price']=$this->input->post('price', TRUE);
			$data['currency']=$this->input->post('currency', TRUE);
			$data['paymethod']=$this->input->post('paymethod', TRUE);
			$data['authdate']=$this->input->post('authdate', TRUE);
			$data['authtime']=$this->input->post('authtime', TRUE);
			$data['notetext']=$this->input->post('notetext', TRUE);
			$data['shiptoname']=$this->input->post('shiptoname', TRUE);
			$data['shiptostreet']=$this->input->post('shiptostreet', TRUE);
			$data['shiptostreet2']=$this->input->post('shiptostreet2', TRUE);
			$data['shiptocity']=$this->input->post('shiptocity', TRUE);
			$data['shiptostate']=$this->input->post('shiptostate', TRUE);
			$data['shiptozip']=$this->input->post('shiptozip', TRUE);
			$data['shiptocountrycode']=$this->input->post('shiptocountrycode', TRUE);
			$data['shiptophonenum']=$this->input->post('shiptophonenum', TRUE);
			$data['shiptocountryname']=$this->input->post('shiptocountryname', TRUE);
			* 
			*/
		 
		# 테스트 서버
		$pp_hostname = PP_HOSTNAME;
		$auth_token = PP_AUTH_TOKEN;
		
		# 상용 서버
		// $pp_hostname = "www.paypal.com";
		// $auth_token = "Yxbn0IuUwYjrXPUZL4M.....................LaUcVpk4cgcSsy3yiC";
		
		$req = 'cmd=_notify-synch';
		$tx_token = $_REQUEST['tx'];
		$req .= "&tx=$tx_token&at=$auth_token";
		
		# 수신한 tx 값과 token 값을 paypal 서버로 전송
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, "https://$pp_hostname/cgi-bin/webscr");
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $req);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array("Host: $pp_hostname"));
		$res = curl_exec($ch);
		curl_close($ch);
		
			//print_r($res);
			##
			/**		  
			  	$_GET['tx']  	6ME91599BN726923G
				$_GET['st']  	Completed
				$_GET['amt']  	0.88
				$_GET['cc']  	USD
				$_GET['cm']  	
				$_GET['item_number']  	37
				
				SUCCESS
				mc_gross=0.88
				protection_eligibility=Eligible
				address_status=unconfirmed
				payer_id=EMFW5BS8BFXMC
				tax=0.00
				address_street=korea
				payment_date=23%3A40%3A42+Oct+29%2C+2015+PDT
				payment_status=Completed
				charset=windows-1252
				address_zip=
				first_name=cim
				mc_fee=0.33
				address_country_code=KR
				address_name=cim+seong-hyun
				custom=
				payer_status=unverified
				business=cswithvideo-facilitator-1%40gmail.com
				address_country=South+Korea
				address_city=seoul
				quantity=1
				payer_email=kudomiyu%40hanmail.net
				txn_id=6ME91599BN726923G
				payment_type=instant
				last_name=seong-hyun
				address_state=
				receiver_email=cswithvideo-facilitator-1%40gmail.com
				payment_fee=0.33
				receiver_id=Y3D2MV75T3D84
				txn_type=web_accept
				item_name=Exciting+Wedding+%5B%1A%1A%1A%5D
				mc_currency=USD
				item_number=37
				residence_country=KR
				receipt_id=1289-0761-3167-5449
				handling_amount=0.00
				transaction_subject=
				payment_gross=0.88
				shipping=0.00
			 * 
			 * 
			*/
		
		# 최종 결과값 분석
		if(!$res){
			//HTTP ERROR
			alert("Paypal 서버 연동 오류가 발생했습니다.",'/order/form');			
			exit;
		}else{
			$lines = explode("\n", $res);
			$keyarray = array();
			if (strcmp ($lines[0], "SUCCESS") == 0) {
				for ($i=1; $i<count($lines);$i++){
					list($key,$val) = explode("=", $lines[$i]);
					$keyarray[urldecode($key)] = urldecode($val);
					//fwrite($fp, urldecode($key).":".urldecode($val)."\n");
				}
				
				$firstname = $keyarray['first_name'];	//이름
				$lastname = $keyarray['last_name'];		//이름
				$itemnumber = $keyarray['item_number'];	//상품ID
				$itemname = $keyarray['item_name'];		//상품명
				$amount = $keyarray['payment_gross']; 	//결재 가격
				
				$payer_email = $keyarray['payer_email']; 	//결재 가격
				
				
				
				$paypal['name'] = $firstname.$lastname;
				$paypal['itemnumber'] =	$itemnumber;
				$paypal['itemname'] =	$itemname;
				$paypal['amount'] =	$amount;
				$paypal['payer_email'] = $payer_email;
				
				
				//주문서 저장
				$this->_paypal_save($paypal);
				
			}else if (strcmp ($lines[0], "FAIL") == 0) {
				alert("Paypal 결제오류가 발생했습니다!\r\n처음부터 다시 시도해 주십시오.",'/order/form');
			} 
		}
	}
	
	//tr 방식 
	//사용안함
	function _paypal_save($paypal){
		
		$email = $paypal['payer_email'];
		
		if($email){
			$exp = explode("@", $email);		
			$username =$exp[0];
		}else{
			
			$username = "unknonwn";
			$email = "unknonwn@thedays.co.kr";
		}
		
		$username = $paypal['name'];
		
				
		$point = $this->input->post("point",true); 			//포인트		
		$couponid = $this->input->post("couponid",true);	//쿠폰 번호		
		$pay_bank_code = $this->input->post("pay_bank_code",true);			//결재할 은행 코드
		
		if(!$point) $point = 0;
		
		
		if($this->agent->is_mobile()){
			$device = "M";
		}else{
			$device = "PC";	
		}
		
		$memberPassword = md5('paypal_thedays');
		if($this->session->userdata('order_password')) $memberPassword = $this->session->userdata['order_password'];
		//if($this->session->userdata('order_password')) $memberPassword = $this->session->userdata['order_password'];
		
		$memberId = "";
		
		$ip = $this->input->ip_address();
		
		
		//$modifyDatetime = date("Y-m-d H:i:s");
		//$createDatetime = date("Y-m-d H:i:s");
		$status = '02'; //1은 무통장 입금 대기 상태
		$beforeStatus = '02'; //무비메이커 비 노출 상태
		$enable = "r";
		
		//order-item
		//주문번호만 있으면 됨
		
		//order-payment
		$bankNo = BANK_NUM; //입금주 입금은행
		$bankMemberName = "주식회사  위드비디"; //		
		$payMethod = "paypal";
		$payId = "paypal";
		$oid  = "paypal";
		
		
		$cart_data = $this->_cart_ids();
		
		$data = array(			
			'username'=>$username,		
			'email'=>$email,			
			'point'=>$point,		
			'couponId'=>$couponid,		
			'pay_bank_code' => $pay_bank_code,
			'device' => $device,
			'memberId' => $memberId,		
			'memberPassword' => $memberPassword,		
			'ip' => $this->input->ip_address(),
			'modifyDatetime' => date("Y-m-d H:i:s"),
			'createDatetime' => date("Y-m-d H:i:s"),
			'status' => $status,
			'beforeStatus' => $beforeStatus,		
			'enable' => 'r',		
			'bankNo' => $bankNo,
			'bankMemberName' => '주식회사  위드비디',
			'payMethod' => 'paypal',					
			'payId' => $payId,
			'oid'   => $oid			
		);
		
		$status = $this->order_model->paypal_insert($cart_data, $data);
		if($status){
			
			//기본정보
			$send_email = $email; //받을 이메일
			$oid = $status['oid']; //주문번호
			//$point = 0; //사용포인트
			$pay_type = 'paypal';
			$payment = 0; //최종 결제액
			
			$fin_is_member = '비회원';
			if($this->session->userdata("mid")) $fin_is_member = '회원';
			

			//메일 발송		
			$this->temp_email->order_fin_mail_send($send_email, $oid, $point, $pay_type, $payment, $fin_is_member, $cart_data);
			
			
			//세션 생성
			
			$new_data = array(
				'fin_oid'=>$oid,
				'fin_use_point'=>$point,				
				'fin_total_pay'=>$payment,
				'fin_is_member'=>$fin_is_member,
				'fin_name'=>$username,
				'fin_email'=>$email
			);
			$this->session->set_userdata($new_data);
			
			
			//완료 페이지로 넘기기
			 //redirect("/order/finish");
			 alert('주문이 성공적으로 저장 되었습니다.',"/order/finish");
		}else{
			alert("결재에 실패 하였습니다.");
		}
		
	}

function test_bank(){
	$this->order_model->test_bank();
}



}//end
