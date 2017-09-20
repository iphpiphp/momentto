<?  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Api extends CI_Controller {
	function __construct()	{
		parent::__construct();
		
		$this->load->database('default');
		$this -> load -> model('common_model');
		$this->load->model('api_model');
		
		
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->helper('alert');
		
		$this->load->library('email');
		$this->load->library('encryption');
		
	}
	
	public function _remap($method){
		$this->segs = $this->uri->segment_array();
		$location = $this->session->userdata('location');
		if(!$location) $location = "ko";
		$data = array();
		$data['location'] = $location;

		if($this->input->is_ajax_request()){
			if( method_exists($this, $method) ){
				$this->{"{$method}"}($location); 
			}
		}else{ //ajax가 아니면
				$this->{"{$method}"}($location); //일단 표시
		}
	}
	
	
	function index($location){		
		//$this->load->view($location."/customer/index_v");
 	}//end index
 	
	function _tempJson($status, $msg, $data){
		$json = array();
		$json['result'] = $status;
		$json['message'] =$msg;
		$json['data'] = $data;
		print_r(json_encode($json));
	}

 	
	function movie()
	{
		$input = array();
		$data = array();
		if(!isset($this->segs[3])){
			//액션이 없음
			$this->_tempJson(false,'Not Action!',$input);
			exit;
		}else{
			$action = $this->segs[3];
		}

		foreach($this->input->get(NULL, TRUE) as $key => $val) $input["{$key}"]  = $val;
		foreach($this->input->post(NULL, TRUE) as $key => $val) $input["{$key}"]  = $val;

		//fileName > saveData
		if(!isset($input['saveData'])) $input['saveData'] = null;
		if(!isset($input['isComplete'])) $input['isComplete'] = false; // true
		if(!isset($input['isBgmChange'])) $input['isBgmChange'] = false; // 1, 2
		if(!isset($input['renderServerName'])) $input['renderServerName'] = null;

		//if(!isset($input['movieMakerId'])) $input['movieMakerId'] = null;

		if(!isset($input['makeid'])) $input['makeid'] = null;
		$input['movieMakerId'] = $input['makeid']; //변환  //실제로는 movieMakerId를 사용한다

		if($input['isComplete'] === 1) $input['isComplete'] = true;
		if($input['isBgmChange'] === 2) $input['isBgmChange'] = true;

		//print_r($input);

		$message = "";
		$status = false;

		//액션이 퍼스트  first 무비메이커 실행 하면 업데이트 하는 액션
		if($action == "first"){
			if($input['orderId']){
				$db = $this->api_model->movie_first_data($input);
				if($db['status']){
					//있으면 업데이트
					$this->_tempJson(true,'Update Complete.',$data);
				}else{
					//없으면 없는것
					$this->_tempJson(false,'No Serach Data.',array());
				}
			}else{
				$this->_tempJson(false,'Not movieMakerId! ERR!',array());
			}
		}//end First

		if($action == "reset"){
			if($input['orderId']){
				$db = $this->api_model->movie_reset_data($input);
				if($db['status']){
					//있으면 업데이트
					$this->_tempJson(true,'Update Complete.',$data);
				}else{
					//없으면 없는것
					$this->_tempJson(false,'No Serach Data.',array());
				}
			}else{
				$this->_tempJson(false,'Not orderId! ERR!',array());
			}
		}//end reset


	}

	
	//상품리스트
	function productlists(){
	
		$cate = $this->input->post('cate_id',true);
		$this->api_model->productlists($cate); //안에서 print_r
	}
	//카테리스트
	function catelist(){		
		$this->api_model->catelist(); //안에서 print_r
	}
	//해당 상품 검색
	function findproduct(){
		$product_id = $this->input->post('product_id',true);
		$this->api_model->findproduct($product_id); //안에서 print_r
	}
	
	//쿠폰리스트
	function coupon_list(){
		//...
		$orderby = array("id"=>"desc");
		//$orderby = false;
		$sql = $this->common_model->select_get("tb_coupon",false,$orderby);
		
		$result['coupon_list'] = $sql->result_array();
		$json_data = json_encode($result);
		print_r($json_data);
	}
	
	//***
	
	// by ykshin : 2015.09.23
	// for twitter auth.
	function buildBaseString($baseURI, $params){
	
		$r = array();
		ksort($params);
		foreach($params as $key=>$value){
			$r[] = "$key=" . rawurlencode($value);
		}//end foreach
	
		return "POST&" . rawurlencode($baseURI) . '&' . rawurlencode(implode('&', $r));
	}
	
	// by ykshin : 2015.09.23
	// for twitter auth.
	function getCompositeKey($consumerSecret, $requestToken){
		return rawurlencode($consumerSecret) . '&' . rawurlencode($requestToken);
	}
	
	// by ykshin : 2015.09.23
	// for twitter auth.
	function buildAuthorizationHeader($oauth){
		$r = 'Authorization: OAuth ';
	
		$values = array();
		foreach($oauth as $key=>$value)
			$values[] = "$key=\"" . rawurlencode($value) . "\"";
	
		$r .= implode(', ', $values);
		return $r;
	}
	
	// by ykshin : 2015.09.18
	// SNS를 이용한 로그인
	function sns_login($location) {
		$type=$this->input->get("type", TRUE);
		
	    $mt = microtime();
    	$rand = mt_rand();
    	$state=md5($mt . $rand);
    	
    	$this->session->set_userdata('state', $state);
		
		if($type==TWITTER_CODE) {
			$url="https://twitter.com/oauth/request_token";
			$timestamp=time();
			$oauth_nonce=$timestamp;
				
			$oauth = array('oauth_callback' => Base_url('/api/callback?type='.TWITTER_CODE),
					'oauth_consumer_key' => TW_CLIENT_ID,
					'oauth_nonce' => $timestamp,
					'oauth_signature_method' => 'HMAC-SHA1',
					'oauth_timestamp' => $timestamp,
					'oauth_version' => '1.0');
			$baseString = $this->buildBaseString($url, $oauth);
			
			$compositeKey = $this->getCompositeKey(TW_CLIENT_SECRET, null);
			$oauth_signature = base64_encode(hash_hmac('sha1', $baseString, $compositeKey, true));
			
			$oauth['oauth_signature'] = $oauth_signature;
			
			$ch=curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
			curl_setopt($ch, CURLOPT_POST, 1);
			
			$header=$this->buildAuthorizationHeader($oauth);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array($header));
			$result=curl_exec($ch);
			
			$url="https://api.twitter.com/oauth/authorize?".$result;
			curl_close($ch);
			redirect($url);
		} else if($type==FACEBOOK_CODE) {
			$url="https://www.facebook.com/dialog/oauth?client_id=".FB_CLIENT_ID."&redirect_uri=".urlencode(API_FACEBOOK_REDIRECT_URI)."&scope=email,publish_actions";
			redirect($url);
		} else if($type==KAKAO_CODE) {
			$url="https://kauth.kakao.com/oauth/authorize?client_id=".KO_CLIENT_ID."&redirect_uri=".urlencode(API_KAKAO_REDIRECT_URI)."&response_type=code";
			redirect($url);
		} else if($type==NAVER_CODE) {
			$url="https://nid.naver.com/oauth2.0/authorize?client_id=".NV_CLIENT_ID."&redirect_uri=".urlencode(API_NAVER_REDIRECT_URI)."&response_type=code&state=".$state;
			redirect($url);
		} else if($type==GOOGLE_CODE) {
			$url="https://accounts.google.com/o/oauth2/auth?scope=email%20profile&redirect_uri=".urlencode(API_GOOGLE_REDIRECT_URI)."&response_type=code&client_id=".GP_CLIENT_ID;
			redirect($url);
		} else if($type==DAUM_CODE) {
			$url="https://apis.daum.net/oauth2/authorize?client_id=".DM_CLIENT_ID."&redirect_uri=".urlencode(API_DAUM_REDIRECT_URI)."&response_type=code";
			redirect($url);
		}
	}
	
	
	// SNS callback
	function callback($location) {
		$type=$this->input->get("type", TRUE);
		$access_token=$this->input->get("access_token", TRUE);
		$code=$this->input->get("code", TRUE);
		$state=$this->input->get("state", TRUE);
		$orig_state=$this->session->userdata("state");
		$oauth_token=$this->input->get("oauth_token", TRUE);
		$oauth_verifier=$this->input->get("oauth_verifier", TRUE);
		
		$data = array();
		
		if($type==TWITTER_CODE) {
			// email 없음
		} else if($type==FACEBOOK_CODE) {
			
			$url="https://graph.facebook.com/v2.3/oauth/access_token?client_id=".FB_CLIENT_ID."&redirect_uri=".urlencode(API_FACEBOOK_REDIRECT_URI)."&client_secret=".FB_CLIENT_SECRET."&code=".$code;
			$ch=curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
			curl_setopt($ch, CURLOPT_POST, 0);
			$result=curl_exec($ch);
			$json=json_decode($result);
			//echo $json->{'error'}->{'code'};
			
			//print_r($result);//bearer 
			//print_r($json);//bearer
			
			if(!empty($json->{'error'}->{'code'})) alert('페이스북 통신 에러. 다시 시도해 주십시오.');
			//if($json->{'error'}->{'code'} == '100') alert('에러');
			//print_r($result);//bearer 

			$url="https://graph.facebook.com/me?fields=email,name&access_token=".$json->{'access_token'};
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
			curl_setopt($ch, CURLOPT_POST, 0);
			$result=curl_exec($ch);
			$json=json_decode($result);
			curl_close($ch);
			
			if(empty($json->{'email'})) alert("페이스북으로 회원 가입은 이메일 정보 제공에 동의해 주셔야 가능합니다. 페이스북 로그인 - 앱 설정에서 thedays 앱을 삭제 하시고 다시 진행해 주십시오.", URL_LOGIN);
			
			$email=$json->{'email'};
			$name=$json->{'name'};
			$snstype = "FB";
			
			$this->_sns_pro($snstype, $email, $name);
						
			
		} else if($type==NAVER_CODE) {
			if($state!=$orig_state) {
				// TODO : redirect error
			}
			$url="https://nid.naver.com/oauth2.0/token?client_id=".NV_CLIENT_ID."&client_secret=".NV_CLIENT_SECRET."&grant_type=authorization_code&state=".$state."&code=".$code;
			$ch=curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
			$result=curl_exec($ch);
			if($errno = curl_errno($ch)) {
    			$error_message = curl_strerror($errno);
			} else {
				$json=json_decode($result);
				$url="https://openapi.naver.com/v1/nid/getUserProfile.xml";
				$header=array("Authorization: ".$json->{'token_type'}." ".$json->{'access_token'});
				curl_setopt($ch, CURLOPT_URL, $url);
				curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
				curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
				$result=curl_exec($ch);
				$xml = simplexml_load_string($result);
				
				
				if($xml!==FALSE) {
					$userInfo = array(
						'email' => (string)$xml -> response -> email,
						'nickname' => (string)$xml -> response -> nickname,
						'age' => (string)$xml -> response -> age,
						'birth' => (string)$xml -> response -> birthday,
						'gender' => (string)$xml -> response -> gender,
						'name' => (string)$xml -> response -> name,
						'profImg' => (string)$xml -> response -> profile_image
					);
					$email = $userInfo['email'];
					$name = $userInfo['name'];					
					$snstype= "NV";
					
					$this->_sns_pro($snstype, $email, $name);
					 
				}
			}
			curl_close($ch);
		} else if($type==GOOGLE_CODE) {
			$url="https://www.googleapis.com/oauth2/v3/token";
			$ch=curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
			curl_setopt($ch, CURLOPT_POST, 1);
			$postdata="code=".$code."&client_secret=".GP_CLIENT_SECRET."&client_id=".GP_CLIENT_ID."&redirect_uri=".urlencode(API_GOOGLE_REDIRECT_URI)."&grant_type=authorization_code";
			curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
			$result=curl_exec($ch);
			$json=json_decode($result);
			
			
			if(!empty($json->{'error'})) alert("인증 절차가 잘못 되었습니다.  다시 시도해 주십시오.");
			
			$url="https://www.googleapis.com/oauth2/v2/userinfo";
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
			curl_setopt($ch, CURLOPT_POST, 0);
			$header=array("Authorization: ".$json->{'token_type'}." ".$json->{'access_token'});
			curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
			$result=curl_exec($ch);
			$json=json_decode($result);
			$email=$json->{'email'};
			$name = $json->{'name'};
			$snstype = "GP";
			curl_close($ch);
			
			$this->_sns_pro($snstype, $email, $name);
			
			/*
			 * [id] => 106690101210208496755 
			 * [email] => ceo@thedays.co.kr 
			 * [verified_email] => 1 
			 * [name] => Lee Sangkyo 
			 * [given_name] => Lee 
			 * [family_name] => Sangkyo 
			 * [link] => https://plus.google.com/106690101210208496755 
			 * [picture] => https://lh3.googleusercontent.com/-XdUIqdMkCWA/AAAAAAAAAAI/AAAAAAAAAAA/4252rscbv5M/photo.jpg 
			 * [gender] => male 
			 * [locale] => ko
			 * */
				
					
		}else if($type==KAKAO_CODE) {
			$url="https://kauth.kakao.com/oauth/token";
			$ch=curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
			curl_setopt($ch, CURLOPT_POST, 1);
			$postdata="code=".$code."&client_id=".KO_CLIENT_ID."&redirect_uri=".urlencode(KAKAO_REDIRECT_URI)."&grant_type=authorization_code";
			curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
			$result=curl_exec($ch);
			$json=json_decode($result);
			
			$url="https://kapi.kakao.com/v1/user/me";
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
			curl_setopt($ch, CURLOPT_POST, 0);
			$header=array("Authorization: ".$json->{'token_type'}." ".$json->{'access_token'});
			curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
			$result=curl_exec($ch);
			// echo $result;
			// email 없음
			curl_close($ch);
		}else if($type==DAUM_CODE) {
			$url="https://apis.daum.net/oauth2/token";
			
			$ch=curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
			curl_setopt($ch, CURLOPT_POST, 1);
			$postdata="code=".$code."&client_id=".DM_CLIENT_ID."&client_secret=".DM_CLIENT_SECRET."&redirect_uri=".urlencode(DAUM_REDIRECT_URI)."&grant_type=authorization_code";
			curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
			$result=curl_exec($ch);
			$json=json_decode($result);
			
			$url="https://apis.daum.net/user/v1/show.json?access_token=".$json->{'access_token'};
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_POST, 0);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
			$result=curl_exec($ch);
			$json=json_decode($result);
			// email 없음
				
			curl_close($ch);
		}
	}

	
	//**
	
	function _sns_pro($sns_type, $email, $name){
					
		//$this = $this->load->database('real', TRUE);//리얼 DB 로드 고정		
		
		//회원인지 아닌지 구분 --
		$user_row = $this->common_model->sns_user_chk($email);			
		$sns_auth = "R"; //기본
		
		if($user_row['num_rows'] > 1){
			alert("계정 오류. 운영자에게 문의해 주십시오.", URL_LOGIN);
		}
		
		if($user_row['status']){				
			$sns_type = $user_row['data']->sns_type;
			$sns_auth = $user_row['data']->sns_auth;
		}
		
		
		if($sns_auth == "F" || $sns_auth == "T"){
			//토큰 발행
			$this->common_model->sns_token($email);
			
			//로그인 대상이면 로그인
			$db_data = $this->common_model->sns_login_chk($email);
			if(!$db_data)alert("탈퇴한 회원이거나, 없는 계정입니다.",TEST_URL_LOGIN);
			
			$data['email'] = $db_data->email;
			$data['password'] = $db_data->password; 
			$this->load->view("api/sns_pro_v",$data);
			
			//redirect("/");				
		}
		
		//회원 가입 대상이면
		if($sns_auth == "R"){					
		
			//가입로직
			$key=urlencode($this->encryption->encrypt($email));
			$email_exp = explode("@", $email);
			$userId = $email_exp[0]; 
			$pass = uniqid();
	
			$data = array(
					'email' => $email,
					'userId' => $userId,
					'password' => md5($pass),
					'auth_key' => urldecode($key),
					'authKey' => '',
					'authType' => '0',
					'name' => $name,
					'sex' => 'F',
					'role' => 'ROLE_USER',
					'mobile' => '01011119991',
					'modifyDatetime' => date('Y-m-d H:i:s'),
					'createDatetime' => date('Y-m-d H:i:s'),
					'isNew' => '1',
					'is_auth' => 1,
					'auth_lv' =>4,
					'sns_type' =>$sns_type,
					'sns_auth' =>"F",
					'link_token'=>"1"
			);
			$result=$this->common_model->insert('tb_member', $data);
			
			$point_data = array(
						'memberId'=>$result['insert_id'],
						'orderId'=>null,
						'name'=>'회원가입 축하',
						'money'=> 1000,
						'endDatetime'=>null,
						'createDatetime'=>date("Y-m-d H:i:s")
			);
			$this->common_model->insert('tb_member_saved_money',$point_data);
			
			if($result){
				//세션 만들어줌
				$db_data = $this->common_model->sns_login_chk($email);
				
				$data['email'] = $db_data->email;
				$data['password'] = $db_data->password; 
				$this->load->view("api/sns_pro_v",$data);				
				
			}else{
				alert('회원 가입에 실패 하였습니다. 처음부터 다시 시도해 주십시오.',URL_LOGIN);
			}
		}
	}

	
	/// test server only
	function test_sns_login($location) {
		$type=$this->input->get("type", TRUE);
		
	    $mt = microtime();
    	$rand = mt_rand();
    	$state=md5($mt . $rand);
    	
    	$this->session->set_userdata('state', $state);
		
		if($type==TWITTER_CODE) {
			$url="https://twitter.com/oauth/request_token";
			$timestamp=time();
			$oauth_nonce=$timestamp;
				
			$oauth = array('oauth_callback' => Base_url('/api/test_callback?type='.TWITTER_CODE),
					'oauth_consumer_key' => TW_CLIENT_ID,
					'oauth_nonce' => $timestamp,
					'oauth_signature_method' => 'HMAC-SHA1',
					'oauth_timestamp' => $timestamp,
					'oauth_version' => '1.0');
			$baseString = $this->buildBaseString($url, $oauth);
			
			$compositeKey = $this->getCompositeKey(TW_CLIENT_SECRET, null);
			$oauth_signature = base64_encode(hash_hmac('sha1', $baseString, $compositeKey, true));
			
			$oauth['oauth_signature'] = $oauth_signature;
			
			$ch=curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
			curl_setopt($ch, CURLOPT_POST, 1);
			
			$header=$this->buildAuthorizationHeader($oauth);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array($header));
			$result=curl_exec($ch);
			
			$url="https://api.twitter.com/oauth/authorize?".$result;
			curl_close($ch);
			redirect($url);
		} else if($type==FACEBOOK_CODE) {
			$url="https://www.facebook.com/dialog/oauth?client_id=".FB_CLIENT_ID."&redirect_uri=".urlencode(TEST_API_FACEBOOK_REDIRECT_URI)."&scope=email,publish_actions";
			redirect($url);
		} else if($type==KAKAO_CODE) {
			$url="https://kauth.kakao.com/oauth/authorize?client_id=".KO_CLIENT_ID."&redirect_uri=".urlencode(TEST_API_KAKAO_REDIRECT_URI)."&response_type=code";
			redirect($url);
		} else if($type==NAVER_CODE) {
			$url="https://nid.naver.com/oauth2.0/authorize?client_id=".NV_CLIENT_ID."&redirect_uri=".urlencode(TEST_API_NAVER_REDIRECT_URI)."&response_type=code&state=".$state;
			redirect($url);
		} else if($type==GOOGLE_CODE) {
			$url="https://accounts.google.com/o/oauth2/auth?scope=email%20profile&redirect_uri=".urlencode(TEST_API_GOOGLE_REDIRECT_URI)."&response_type=code&client_id=".GP_CLIENT_ID;
			redirect($url);
		} else if($type==DAUM_CODE) {
			$url="https://apis.daum.net/oauth2/authorize?client_id=".DM_CLIENT_ID."&redirect_uri=".urlencode(TEST_API_DAUM_REDIRECT_URI)."&response_type=code";
			redirect($url);
		}
	}
	
	// by ykshin : 2015.09.18
	// SNS callback
	function test_callback($location) {
		$type=$this->input->get("type", TRUE);
		$access_token=$this->input->get("access_token", TRUE);
		$code=$this->input->get("code", TRUE);
		$state=$this->input->get("state", TRUE);
		$orig_state=$this->session->userdata("state");
		$oauth_token=$this->input->get("oauth_token", TRUE);
		$oauth_verifier=$this->input->get("oauth_verifier", TRUE);
		
		$data = array();
		
		if($type==TWITTER_CODE) {
			// email 없음
		} else if($type==FACEBOOK_CODE) {
			
			$url="https://graph.facebook.com/v2.3/oauth/access_token?client_id=".FB_CLIENT_ID."&redirect_uri=".urlencode(TEST_API_FACEBOOK_REDIRECT_URI)."&client_secret=".FB_CLIENT_SECRET."&code=".$code;
			$ch=curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
			curl_setopt($ch, CURLOPT_POST, 0);
			$result=curl_exec($ch);
			$json=json_decode($result);
			//echo $json->{'error'}->{'code'};
			
			//print_r($result);//bearer 
			//print_r($json);//bearer
			
			if(!empty($json->{'error'}->{'code'})) alert('페이스북 통신 에러. 다시 시도해 주십시오.');
			//if($json->{'error'}->{'code'} == '100') alert('에러');
			//print_r($result);//bearer 

			$url="https://graph.facebook.com/me?fields=email,name&access_token=".$json->{'access_token'};
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
			curl_setopt($ch, CURLOPT_POST, 0);
			$result=curl_exec($ch);
			$json=json_decode($result);
			curl_close($ch);
			
			//print_r($json);			
			if(empty($json->{'email'})) alert("페이스북으로 회원 가입은 이메일 정보 제공에 동의해 주셔야 가능합니다. 페이스북 로그인 - 앱 설정에서 thedays 앱을 삭제 하시고 다시 진행해 주십시오.", TEST_URL_LOGIN);
			
			$email=$json->{'email'};
			$name=$json->{'name'};
			$snstype = "FB";
			$this->_test_sns_pro($snstype, $email, $name);
						
			
		} else if($type==NAVER_CODE) {
			if($state!=$orig_state) {
				// TODO : redirect error
			}
			$url="https://nid.naver.com/oauth2.0/token?client_id=".NV_CLIENT_ID."&client_secret=".NV_CLIENT_SECRET."&grant_type=authorization_code&state=".$state."&code=".$code;
			$ch=curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
			$result=curl_exec($ch);
			if($errno = curl_errno($ch)) {
    			$error_message = curl_strerror($errno);
			} else {
				$json=json_decode($result);
				$url="https://openapi.naver.com/v1/nid/getUserProfile.xml";
				$header=array("Authorization: ".$json->{'token_type'}." ".$json->{'access_token'});
				curl_setopt($ch, CURLOPT_URL, $url);
				curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
				curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
				$result=curl_exec($ch);
				$xml = simplexml_load_string($result);
				
				
				if($xml!==FALSE) {
					$userInfo = array(
						'email' => (string)$xml -> response -> email,
						'nickname' => (string)$xml -> response -> nickname,
						'age' => (string)$xml -> response -> age,
						'birth' => (string)$xml -> response -> birthday,
						'gender' => (string)$xml -> response -> gender,
						'name' => (string)$xml -> response -> name,
						'profImg' => (string)$xml -> response -> profile_image
					);
					$email = $userInfo['email'];
					$name = $userInfo['name'];					
					$snstype= "NV";
					
					$this->_test_sns_pro($snstype, $email, $name);
					 
				}
			}
			curl_close($ch);
		} else if($type==GOOGLE_CODE) {
			$url="https://www.googleapis.com/oauth2/v3/token";
			$ch=curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
			curl_setopt($ch, CURLOPT_POST, 1);
			$postdata="code=".$code."&client_secret=".GP_CLIENT_SECRET."&client_id=".GP_CLIENT_ID."&redirect_uri=".urlencode(TEST_API_GOOGLE_REDIRECT_URI)."&grant_type=authorization_code";
			curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
			$result=curl_exec($ch);
			$json=json_decode($result);
			
			
			if(!empty($json->{'error'})) alert("인증 절차가 잘못 되었습니다.  다시 시도해 주십시오.");
			
			$url="https://www.googleapis.com/oauth2/v2/userinfo";
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
			curl_setopt($ch, CURLOPT_POST, 0);
			$header=array("Authorization: ".$json->{'token_type'}." ".$json->{'access_token'});
			curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
			$result=curl_exec($ch);
			$json=json_decode($result);
			$email=$json->{'email'};
			$name = $json->{'name'};
			$snstype = "GP";
			curl_close($ch);
			
			$this->_test_sns_pro($snstype, $email, $name);
			
			//print_r($json);
			
			/*
			 * [id] => 106690101210208496755 
			 * [email] => ceo@thedays.co.kr 
			 * [verified_email] => 1 
			 * [name] => Lee Sangkyo 
			 * [given_name] => Lee 
			 * [family_name] => Sangkyo 
			 * [link] => https://plus.google.com/106690101210208496755 
			 * [picture] => https://lh3.googleusercontent.com/-XdUIqdMkCWA/AAAAAAAAAAI/AAAAAAAAAAA/4252rscbv5M/photo.jpg 
			 * [gender] => male 
			 * [locale] => ko
			 * */
				
					
		}else if($type==KAKAO_CODE) {
			$url="https://kauth.kakao.com/oauth/token";
			$ch=curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
			curl_setopt($ch, CURLOPT_POST, 1);
			$postdata="code=".$code."&client_id=".KO_CLIENT_ID."&redirect_uri=".urlencode(TEST_KAKAO_REDIRECT_URI)."&grant_type=authorization_code";
			curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
			$result=curl_exec($ch);
			$json=json_decode($result);
			
			$url="https://kapi.kakao.com/v1/user/me";
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
			curl_setopt($ch, CURLOPT_POST, 0);
			$header=array("Authorization: ".$json->{'token_type'}." ".$json->{'access_token'});
			curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
			$result=curl_exec($ch);
			// echo $result;
			// email 없음
			curl_close($ch);
		}else if($type==DAUM_CODE) {
			$url="https://apis.daum.net/oauth2/token";
			
			$ch=curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
			curl_setopt($ch, CURLOPT_POST, 1);
			$postdata="code=".$code."&client_id=".DM_CLIENT_ID."&client_secret=".DM_CLIENT_SECRET."&redirect_uri=".urlencode(TEST_DAUM_REDIRECT_URI)."&grant_type=authorization_code";
			curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
			$result=curl_exec($ch);
			$json=json_decode($result);
			
			$url="https://apis.daum.net/user/v1/show.json?access_token=".$json->{'access_token'};
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_POST, 0);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
			$result=curl_exec($ch);
			$json=json_decode($result);
			// email 없음
				
			curl_close($ch);
		}
	}

	
	//**
	
	function _test_sns_pro($sns_type, $email, $name){
					
		//$this = $this->load->database('real', TRUE);//리얼 DB 로드 고정		
		
		//회원인지 아닌지 구분 --
		$user_row = $this->common_model->test_sns_user_chk($email);			
		$sns_auth = "R"; //기본
		
		if($user_row['num_rows'] > 1){
			alert("계정 오류. 운영자에게 문의해 주십시오.", TEST_URL_LOGIN);
		}
		
		if($user_row['status']){
			$sns_type = $user_row['data']->sns_type;
			$sns_auth = $user_row['data']->sns_auth;
		}
		
		
		if($sns_auth == "F" || $sns_auth == "T"){
			//토큰 발행
			$this->common_model->test_sns_token($email);
			
			//로그인 대상이면 로그인
			$db_data = $this->common_model->test_sns_login_chk($email);
			if(!$db_data)alert("탈퇴한 회원이거나, 없는 계정입니다.",TEST_URL_LOGIN);		
			$data['email'] = $db_data->email;
			$data['password'] = $db_data->password; 
			$this->load->view("api/test_sns_pro_v",$data);
							
		}
				
		//회원 가입 대상이면
		if($sns_auth == "R"){					
		
			//가입로직
			$key=urlencode($this->encryption->encrypt($email));
			$email_exp = explode("@", $email);
			$userId = $email_exp[0]; 
			$pass = uniqid();
	
			$data = array(
					'email' => $email,
					'userId' => $userId,
					'password' => md5($pass),
					'auth_key' => urldecode($key),
					'authKey' => '',
					'authType' => '0',
					'name' => $name,
					'sex' => 'F',
					'role' => 'ROLE_USER',
					'mobile' => '01011119991',
					'modifyDatetime' => date('Y-m-d H:i:s'),
					'createDatetime' => date('Y-m-d H:i:s'),
					'isNew' => '1',
					'is_auth' => 1,
					'auth_lv' =>4,
					'sns_type' =>$sns_type,
					'sns_auth' =>"F",
					'link_token'=>"1"
			);
			
			$result=$this->common_model->test_insert('tb_member', $data);
			
			$point_data = array(
						'memberId'=>$result['insert_id'],
						'orderId'=>null,
						'name'=>'회원가입 축하',
						'money'=> 1000,
						'endDatetime'=>null,
						'createDatetime'=>date("Y-m-d H:i:s")
			);
			$this->common_model->test_insert('tb_member_saved_money',$point_data);
			
			if($result){
				//세션 만들어줌
				$db_data = $this->common_model->test_sns_login_chk($email);
				
				$data['email'] = $db_data->email;
				$data['password'] = $db_data->password; 
				$this->load->view("api/test_sns_pro_v",$data);
			}else{
				alert('회원 가입에 실패 하였습니다. 처음부터 다시 시도해 주십시오.',URL_LOGIN);
			}
		}
	}

	
	
	// test server only
	
	
	//** app api 처리 
	function app_test(){
		$this->load->view("api/api_test_v");
	}
	
	//· API URL: /api/device/add	
	function device(){
		$uri3 = $this->uri->segment(3);
		$uuid = $this->input->post("UUID",true);
		$authkey = $this->input->post("AuthKey",true);
		
		
		if( $uri3== "add"){
			if(!$uuid){
				$result['result'] =false;
				$result['message'] ="uuid 값이 없습니다.";
				$json_data = json_encode($result);
				print_r($json_data);
				exit;
			}
			
			if($authkey == APP_KEY){
				$this->api_model->app_device_add($uuid);//uuid 하나 가져감
			}else{				
				$result['result'] =false;
				$result['message'] ="인증키 값이 같지 않습니다.";
				$json_data = json_encode($result);
				print_r($json_data);
			}				
		}
		if( $uri3== "del"){
			if(!$uuid){
				$result['result'] =false;
				$result['message'] ="uuid 값이 없습니다.";
				$json_data = json_encode($result);
				print_r($json_data);
				exit;
			}
			
			if($authkey == APP_KEY){
				$this->api_model->app_device_del($uuid);//uuid 하나 가져감
			}else{				
				$result['result'] =false;
				$result['message'] ="인증키 값이 같지 않습니다.";
				$json_data = json_encode($result);
				print_r($json_data);
			}
		}
	}
	
	//상품리스트
	function product(){
		$uri3 = $this->uri->segment(3);
		if($uri3 == "info"){
			$page = $this->input->post("page",true);
			$categoryId = $this->input->post("categoryId",true);
			$type = $this->input->post("type",true);
			$keyword = $this->input->post("keyword",true);
			$pagelist=5;			
			$this->api_model->app_product($page , $pagelist , $categoryId, $type, $keyword);
			
		}
	}
	
	//· API URL: /api/movieMaker/makemoviestart
	function movieMaker(){
		$uri3 = $this->uri->segment(3);		
		//무비 시작 -- 주문 정보 생성
		if( $uri3 == "makemoviestart"){
			$uuid = $this->input->post("UUID",true);
			$product_id = $this->input->post("product_id",true);
			$email = $this->input->post("email",true);
			
			
			$this->api_model->app_movieMaker_order($uuid, $product_id, $email);
		}
		
		//업데이트 - 무비메이커 끝나고 랜더요청
		if( $uri3 == "save"){			
			$isBgmChange = $this->input->post("isBgmChange",true);
			$movie_title = $this->input->post("movie_title",true);
			$size = $this->input->post("size",true);
			$make_id = $this->input->post("make_id",true); //무비 메이크 아이디
			$isComplete = $this->input->post("isComplete",true);
			$order_id = $this->input->post("order_id",true);
			$user_resource_path = $this->input->post("user_resource_path",true);
			
			if(!$make_id){
				$result['result'] = false;			
				$result['message'] ="make_id 가 없습니다. 필수 값입니다.";
				$result['data'] = array();
				$json_data = json_encode($result);
				print_r($json_data);
				exit;
			}
			
			$this->api_model->app_movieMaker_save($isBgmChange, $movie_title, $size, $make_id, $isComplete, $order_id, $user_resource_path);	
		}
		
	}
	
	//· API URL: /api/member/join
	function member(){
		$uri3 = $this->uri->segment(3);
		$uuid = $this->input->post("UUID",true);
		$pass = $this->input->post("pass",true); //md5로 넘어옴
		$email = $this->input->post("email",true);
		$authkey = $this->input->post("AuthKey",true);
		$new_pass =$this->input->post("new_pass",true); //md5로 넘어옴
		
		if($uri3 == 'join'){
			$this->_chk_info($uuid, $authkey); //체크 실패시 exit 로 나간다
			$this->api_model->app_member_add($uuid, $email, $pass);//회원추가
		}		
		
		if($uri3 == 'checkemail'){
			$this->_chk_info($uuid, $authkey); //체크 실패시 exit 로 나간다
			$this->api_model->app_member_email($email);//이메일 체크
		}
		
		if($uri3 == 'login'){
			$this->_chk_info($uuid, $authkey); //체크 실패시 exit 로 나간다
			$this->api_model->app_member_login($uuid, $email, $pass);//로그인 체크
		}
		
		if($uri3 == 'password_chg'){
			$this->_chk_info($uuid, $authkey); //체크 실패시 exit 로 나간다
			$this->api_model->app_member_password_chg($uuid, $email, $pass, $new_pass);//패스워드 변경
		}
		
		//마이페이지 · API URL: /api/member/mypage
		if($uri3 == 'mypage'){
			$uuid = $this->input->post("UUID",true);		
			$email = $this->input->post("email",true);
			$authkey = $this->input->post("AuthKey",true);
			$page = $this->input->post("page",true);
			
			$this->_chk_info($uuid, $authkey);
			
			$this->api_model->app_mypage_list($page, $uuid, $email); //mypage 리스트
		}
	} 
	
	
	//빈값 체크, 인증키 값 체크
	function _chk_info($uuid, $authkey){
		/*
		//uuid 빈값 확인
		if(!$uuid){
			$result['result'] =false;
			$result['message'] ="uuid 값이 없습니다.";
			$json_data = json_encode($result);
			print_r($json_data);
			exit;
		}
		 * 
		 */
		 
		//인증키 값 확인
		if($authkey != APP_KEY){
			$result['result'] =false;
			$result['message'] ="인증키 값이 같지 않습니다.";
			$json_data = json_encode($result);
			print_r($json_data);
			exit;
		}
	}

	function inicis_cancle()
	{
		//과거 로직 방식이라... 과거 로직 그대로 사용함..
		$input = array();
		foreach($this->input->post(NULL, TRUE) as $key => $val) $input["{$key}"]  = $val;
		
		if(!isset($input["type"])) $input["type"] = 1;
		
		//print_r($input);exit;
		//print_r($input);
		//echo FCPATH."inicis/libs/INILib.php";
		
		/* * ************************
		 * 1. 라이브러리 인클루드 *
		 * ************************ */
		require(FCPATH."inicis/libs/INILib.php");
		/* * *************************************
		 * 2. INIpay41 클래스의 인스턴스 생성 *
		 * ************************************* */
	//exit;
		$inipay = new INIpay50;
		$inipay->SetField("inipayhome", FCPATH."inicis/"); // 이니페이 홈디렉터리(상점수정 필요)
		$inipay->SetField("type", "cancel");                            // 고정 (절대 수정 불가)
		$inipay->SetField("debug", "true");                             // 로그모드("true"로 설정하면 상세로그가 생성됨.)
		$inipay->SetField("mid", INICIS_MID);                                 // 상점아이디
		
		//print_r($page_data); exit;
		
		/* * ************************************************************************************************
		 * admin 은 키패스워드 변수명입니다. 수정하시면 안됩니다. 1111의 부분만 수정해서 사용하시기 바랍니다.
		 * 키패스워드는 상점관리자 페이지(https://iniweb.inicis.com)의 비밀번호가 아닙니다. 주의해 주시기 바랍니다.
		 * 키패스워드는 숫자 4자리로만 구성됩니다. 이 값은 키파일 발급시 결정됩니다.
		 * 키패스워드 값을 확인하시려면 상점측에 발급된 키파일 안의 readme.txt 파일을 참조해 주십시오.
		 * ************************************************************************************************ */
		$inipay->SetField("admin", "1111");
		$inipay->SetField("tid", $input["tid"]);                                 // 취소할 거래의 거래아이디
		$inipay->SetField("cancelmsg", $input["msg"]);
		
		
		
		
		
		/* * **************
		 * 4. 취소 요청 *
		 * ************** */
		$inipay->startAction();
		
		/* * **************************************************************
		 * 5. 취소 결과                                           	*
		 *                                                        	*
		 * 결과코드 : $inipay->getResult('ResultCode') ("00"이면 취소 성공)  	*
		 * 결과내용 : $inipay->getResult('ResultMsg') (취소결과에 대한 설명) 	*
		 * 취소날짜 : $inipay->getResult('CancelDate') (YYYYMMDD)          	*
		 * 취소시각 : $inipay->getResult('CancelTime') (HHMMSS)            	*
		 * 현금영수증 취소 승인번호 : $inipay->getResult('CSHR_CancelNum')    *
		 * (현금영수증 발급 취소시에만 리턴됨)                          * 
		 * ************************************************************** */
		$page_data['ResultCode'] = $inipay->getResult('ResultCode');
		$page_data['ResultMsg'] = $inipay->getResult('ResultMsg');
		$page_data['CancelDate'] = $inipay->getResult('CancelDate');		
		$page_data['CancelTime'] = $inipay->getResult('CancelTime');
		$page_data['CSHR_CancelNum'] = $inipay->getResult('CSHR_CancelNum');
		
		$page_data['ResultMsg'] = iconv("EUC-KR", "UTF-8", $page_data['ResultMsg']);
		//echo "<br>euckr:".iconv("UTF-8", "EUC-KR", $page_data['ResultMsg'])."<br>";
		//echo "<br>utf8:".iconv("EUC-KR", "UTF-8", $page_data['ResultMsg']);
		
		if($inipay->getResult('ResultCode') == "00"){
			//취소 프로세스...
			
			//$input["orderId"];
			$table = "tb_order_payment";
			$data = array("orderId"=>$input["orderId"]);
			$db = $this->common_model->select_get($table,$data);
			$order_payment=$db->row_array();
			//print_r($order_payment);


			$table = "tb_order";
			$data = array("id"=>$input["orderId"]);
			$db = $this->common_model->select_get($table,$data);
			$order=$db->row_array();


			$table = "tb_order";
			$data = array("status"=>"09");
			$field = "id";
			$id = $input["orderId"];
			$this->common_model->update($table, $field, $data, $id);

			$table = "tb_order_refund";
			$data = array("type"=>$input["type"],"orderId"=>$input["orderId"], "price"=>$order["price"],"payMethod"=>$order_payment["payMethod"], "payId"=>$order_payment["payId"],"paymentId"=>$order_payment["id"],"message"=>$input["msg"],"refundDate"=>$page_data['CancelDate'] , "refundTime"=>$page_data['CancelTime'], "createDatetime"=>date("Y-m-d H:i:s") );
			$this->common_model->insert($table,$data);

			$table = "tb_order_refund_apply";
			$data = array("orderId"=>$input["orderId"], "memberId"=>$order["memberId"], "payMethod"=>$order_payment["payMethod"], "orderDatetime"=>date("Y-m-d H:i:s"),"confirmDatetime"=>date("Y-m-d H:i:s"),"createDatetime"=>date("Y-m-d H:i:s") );
			$this->common_model->insert($table,$data);

			//쿠폰 취소
			if($order["couponTargetId"]>=1){				
				$table = "tb_member_coupon";
				$data = array("useDatetime"=>null);
				$field = "id";
				$id = $order["couponTargetId"];
				$this->common_model->update($table, $field, $data, $id);
			}
			
			//포인트 반환
			if($order["useSaveMoney"] && $order["useSaveMoney"]>=1){
				$table = "tb_member_saved_money";
				$data = array("memberId"=>$order["memberId"],"name"=>"환불취소","money"=>$order["useSaveMoney"], "createDatetime"=>date("Y-m-d H:i:s"));
				$this->common_model->insert($table,$data);
			}

			$url = str_replace(":89","",BASE_URL);
			alert("환불처리 되었습니다.", $url."/admin/order/refundList.html");
			
			
		}else{
			alert("취소 실패...code:".$page_data['ResultCode']."-"."text:".$page_data['ResultMsg']);
		}

		
	}
	
}//

	
