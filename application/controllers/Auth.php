<?
if (!defined('BASEPATH'))
	exit('No direct script access allowed');
class Auth extends CI_Controller {
	function __construct() {
		parent::__construct();

		$this -> load -> database('default');
		$this -> load -> model('common_model');

		$this -> load -> helper('form');
		$this -> load -> helper('url');

		$this -> load -> helper('alert');

		$this -> load -> library('pagination_custom');
		$this->load->library('email');
		$this->load->library('encryption');
		

		$this -> segs = $this -> uri -> segment_array();
		//print_r($this->segs);

	}

	public function _remap($method) {
		$this -> segs = $this -> uri -> segment_array();
		$location = $this -> session -> userdata('location');
		if (!$location)
			$location = "ko";
		$data = array();
		$data['location'] = $location;

		if ($this -> input -> is_ajax_request()) {
			if (method_exists($this, $method)) {
				$this -> {"{$method}"}($location);
			}
		} else {//ajax가 아니면
			$this -> load -> view($location . "/common/header2", $data);
			if (method_exists($this, $method)) {
				$this -> {"{$method}"}($location);
			}
			$this -> load -> view($location . "/common/footer2");
			//$this->output->enable_profiler(true);
		}
	}

	function index($location) {

	}//end index
	
	function login($location) {
		// ykshin : 2015.10.08
		// save redirect url to session
		$this->load->library('user_agent');
		
		$redirect=array('redirect' => $this->agent->referrer());
		$this->session->set_userdata($redirect);
		$this -> load -> view($location . "/auth/m_login_v");
	}
	
	function reg_step1($location)
	{
		$this -> load -> view($location . "/auth/reg_step1_v");
	}

	function guest($location) {
		// ykshin : 2015.10.08
		// save redirect url to session
		$this->load->library('user_agent');
		
		$redirect=array('redirect' => $this->agent->referrer());
		$this->session->set_userdata($redirect);
		$this -> load -> view($location . "/auth/m_guest_v");
	}



	function logout($location) {
		$this->load->library('user_agent');
		$this->session->sess_destroy();
		$referrer=$this->agent->referrer();
		//alert('로그아웃하였습니다.');
		redirect(BASE_URL);
		/*
			if($referrer!='' && strpos($referrer, '/order/form')===false) {
				redirect($this->agent->referrer());
			} else {
				redirect('/');
			}		 
		*/
	}

	function login_chk($location) {
		$email = $this->input->post("email", TRUE);
		$pass = $this->input->post("password", TRUE);

		if (!$email)
			alert('이메일을 입력해 주세요');
		if (!$pass)
			alert('패스워드를 입력해 주세요');

		// 5회 에러가 발생했던 아이디인지 확인
		if($this->common_model->check_denied($email)) {
			//alert('로그인 5회 에러때문에 로그인이 막혔습니다.');
		}
		//echo $pass;
		if($this->common_model->new_user_chk($email)) {
			//$pass = hash("sha512", $pass);
			$pass = md5($pass);
		} else {
			$pass = md5($pass);
		}
		
		$db_data = $this->common_model->login_chk($email, $pass);
		
		if ($db_data) {
			//if(strpos($db_data->role, "ROLE_ADMIN")) $db_data->auth_lv = 7;

			$newdata = array(
				'email' => $db_data->email, 'auth_lv' => $db_data->auth_lv, 
				'mid'=>$db_data->id, 'profile_img'=>$db_data->profile_img, 'username'=>$db_data->name, 
				'mobile'=>$db_data->mobile,
				'member_user_id'=>$db_data->userId
				);			
			$this->session->set_userdata($newdata);
			$error_data = array('login_error' => 0);			
			$referrer=$this->session->userdata['redirect'];
			if($referrer!='' && strpos($referrer, '/order/form')===false) {
				redirect($this->session->userdata['redirect']);
			} else {
				redirect(BASE_URL);
			}
		} else {
			// 세션에 에러 확인
			if($this->session->userdata('login_error')!==FALSE) {
				$error_count=intval($this->session->userdata('login_error'))+1;
			} else {
				$error_count=1;
			}
			if($error_count>=5) {
				// 5번째 에러라면 db에 저장
				$data=array(
						'userId' => $email
				);
				$result=$this->common_model->insert('tb_member_stmp', $data);
				alert('회원 정보가 없습니다. 다시 확인해 주십시오. 5번째 로그인 오류입니다. 해당 계정으로 로그인하실 수 없습니다.');
			} else {
				// 5회 미만의 에러라면
				$error_data = array('login_error' => $error_count);			
				$this->session->set_userdata($error_data);
				alert('회원 정보가 없습니다. 다시 확인해 주십시오. 5회 에러시 로그인이 막힙니다. 현재 '.$error_count.'번째 로그인 에러.');
			}
		}

	}
			
	function return_login($location) {
		$this -> load -> view($location . "/auth/return_login_v");
	}
		
	/*
	function return_login_chk($location) {
		$email = $this->input->post("email", TRUE);
		$pass = $this->input->post("password", TRUE);
		
		$uri = $this->input->get("uri",true);
		$getstring = $this->input->get("getstring",true);
		

		if (!$email)
			alert('이메일을 입력해 주세요');
		if (!$pass)
			alert('패스워드를 입력해 주세요');

		if($this->common_model->new_user_chk($email)) {
			//$pass = hash("sha512", $pass);
			$pass = md5($pass);
		} else {
			$pass = md5($pass);
		}
		$db_data = $this->common_model->login_chk($email, $pass);
		
		if ($db_data) {
			$newdata = array('email' => $db_data->email, 'auth_lv' => $db_data->auth_lv);			
			$this->session->set_userdata($newdata);
			redirect(BASE_URL.$uri."?".$getstring);
		} else {
			alert('회원 정보가 없습니다. 다시 확인해 주십시오.');
		}

	}
	*/
	
	// by ykshin : 2015.09.17
	// 회원가입 페이지
	function regster($location){
		
		//if($this->agent->is_mobile()){
			$this -> load -> view($location . "/auth/m_regster_v");
		/*if(true){
			$this -> load -> view($location . "/auth/m_regster_v");
		}else{
			$this -> load -> view($location . "/auth/regster_v");
		}*/
	}
	
	// by ykshin : 2015.09.18
	// 인증메일로 보낸 인증키 확인용
	function check_auth($location) {
		
		
		$key=$this->input->get("key", TRUE);
		$result=$this->common_model->auth_chk($this->encryption->decrypt($key), $key);
		if($result) {
			$data['message']="인증하였습니다. 로그인 후 사이트를 이용해주세요.";
			
			alert('인증하였습니다. 로그인 후 사이트를 이용해주세요.','/auth/login');
		} else {
			$data['message']="인증하지 못 하였습니다. 회원가입을 다시 해주시거나 인증키를 확인하신 후 다시 인증을 시도해주세요.";
			alert('인증하였습니다. 로그인 후 사이트를 이용해주세요.','/auth/login');
		}
		//$this -> load -> view($location . "/auth/auth_chk_v", $data);
	}
	
	// by ykshin : 2015.09.18
	// 회원가입 시, 인증메일 전송
	function register_chk($location) {
		$email = $this->input->post("register_email", TRUE);
		$pass = $this->input->post("register_password", TRUE);		
		$name = $this->input->post("username", TRUE);
		$mobile = $this->input->post("mobile", TRUE);
		
		
        
		
		 // 기존 아이디가 있는지 확인
        if($this->common_model->user_exist($email)) {
            alert('사용중인 이메일 주소입니다. 다른 이메일을 입력해주세요.');

			//print_r($_POST);
			//echo "기존아이디...";

			exit;
        }
		
		//이메일 인증 제거
		//$this->email->set_newline("\r\n");
		//$this->email->from(MAIL_TO, 'thedays');
        //$this->email->to($email); 
		
		// save email, password and key to DB
		$key=urlencode($this->encryption->encrypt($email));
		//$this->email->subject('thedays.co.kr 회원가입이 되셨습니다. 인증 확인 메일입니다.');
		//$this->email->message('<div>회원가입이 정상적으로 이루어졌습니다. 아래 링크를 통해서 인증을 하셔야 로그인이 가능합니다.</div><div><a href="'.Base_url('/auth/check_auth?key='.$key).'">'.Base_url('/auth/check_auth?key='.$key).'</a></div>');
		
		$email_exp = explode("@", $email);
		$userId = $email_exp[0]; 
		
		$userId = $userId ."_".mt_rand(0,9999);
		
		//회원가입
		$data=array(
				'email' => $email,
				'userId' => $userId,
				'password' => md5($pass),
				'auth_key' => urldecode($key),
				'authKey' => '',
				'authType' => '1',
				'name' => $name,
				'sex' => 'F',
				'role' => 'ROLE_USER',
				'mobile' => $mobile,
				'modifyDatetime' => date('Y-m-d H:i:s'),
				'createDatetime' => date('Y-m-d H:i:s'),
				'isNew' => '1',
				'auth_lv' =>4
		);
		$result=$this->common_model->insert('tb_member', $data);

		
		if($result['insert_id']){
			//포인트 지급
			$point_data = array(
					'memberId'=>$result['insert_id'],
					'orderId'=>null,
					'name'=>'회원가입 축하',
					'money'=> 1000,
					'endDatetime'=>null,
					'createDatetime'=>date("Y-m-d H:i:s")
			);
			$this->db->insert('tb_member_saved_money',$point_data);
		
			
				$db_data = $this->common_model->sns_login_chk($email);				
				$newdata = array('email' => $db_data->email, 'auth_lv' => $db_data->auth_lv, 'mid'=>$db_data->id, 'profile_img'=>$db_data->profile_img, 'username'=>$db_data->name, 'mobile'=>$db_data->mobile);			
				$this->session->set_userdata($newdata);
				alert("회원가입에 성공 하였습니다.",BASE_URL);
				//redirect(BASE_URL);
		}else{
			alert("회원가입에 실패 하였습니다. 다시 진행해 주십시오.");
		}
		
		//$this->email->send();
		//alert('인증용 이메일을 발송 하였습니다. '.$email.' 해당 이메일에서 인증 절차를 거쳐 주십시오.','/');
						
		//echo $this->email->print_debugger();
	}
	
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
				
			$oauth = array('oauth_callback' => Base_url('/auth/callback?type='.TWITTER_CODE),
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
			$url="https://www.facebook.com/dialog/oauth?client_id=".FB_CLIENT_ID."&redirect_uri=".urlencode(FACEBOOK_REDIRECT_URI)."&scope=email,publish_actions";
			redirect($url);
		} else if($type==KAKAO_CODE) {
			$url="https://kauth.kakao.com/oauth/authorize?client_id=".KO_CLIENT_ID."&redirect_uri=".urlencode(KAKAO_REDIRECT_URI)."&response_type=code";
			redirect($url);
		} else if($type==NAVER_CODE) {
			$url="https://nid.naver.com/oauth2.0/authorize?client_id=".NV_CLIENT_ID."&redirect_uri=".urlencode(NAVER_REDIRECT_URI)."&response_type=code&state=".$state;
			redirect($url);
		} else if($type==GOOGLE_CODE) {
			$url="https://accounts.google.com/o/oauth2/auth?scope=email%20profile&redirect_uri=".urlencode(GOOGLE_REDIRECT_URI)."&response_type=code&client_id=".GP_CLIENT_ID;
			redirect($url);
		} else if($type==DAUM_CODE) {
			$url="https://apis.daum.net/oauth2/authorize?client_id=".DM_CLIENT_ID."&redirect_uri=".urlencode(DAUM_REDIRECT_URI)."&response_type=code";
			redirect($url);
		}
	}
	
	// by ykshin : 2015.09.18
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
			$url="https://graph.facebook.com/v2.3/oauth/access_token?client_id=".FB_CLIENT_ID."&redirect_uri=".urlencode(FACEBOOK_REDIRECT_URI)."&client_secret=".FB_CLIENT_SECRET."&code=".$code;
			$ch=curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
			curl_setopt($ch, CURLOPT_POST, 0);
			$result=curl_exec($ch);
			$json=json_decode($result);
			//echo $json->{'error'}->{'code'};
			
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
			$postdata="code=".$code."&client_secret=".GP_CLIENT_SECRET."&client_id=".GP_CLIENT_ID."&redirect_uri=".urlencode(GOOGLE_REDIRECT_URI)."&grant_type=authorization_code";
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
	
	
	//게스트로그인
	function guest_login($location){
		$oid = $this->input->post('oid',TRUE);
		//$email = $this->input->post('email',true);
		$pass = $this->input->post('password',true);


		$db_data = $this->common_model->guest_login_chk(md5($pass), $oid);
		if($db_data){
			$newdata = array('guest_oid' => $oid, 'guest_password' => $pass);
			$this->session->set_userdata($newdata);			
			redirect(BASE_URL."/customer/guest_movie/");
		}else{
			alert('해당 정보가 없습니다.');
		}
		//print_r($db_data);
		//exit;
		
		
	}
	
	function _sns_pro($sns_type, $email, $name){
		//회원인지 아닌지 구분 --
		$user_row = $this->common_model->sns_user_chk($email);			
		$sns_auth = "R"; //기본
		if($user_row['status']){				
			$sns_type = $user_row['data']->sns_type;
			$sns_auth = $user_row['data']->sns_auth;
		}
		
		
		if($sns_auth == "F" || $sns_auth == "T"){
			//로그인 대상이면 로그인
			$db_data = $this->common_model->sns_login_chk($email);
			//var_dump($db_data);				
			//$newdata = array('email' => $db_data->email, 'auth_lv' => $db_data->auth_lv, 'mid'=>$db_data->id, 'profile_img'=>$db_data->profile_img, 'username' => $db_data->name,'member_user_id'=>$db_data->userId);
			$newdata = array(
				'email' => $db_data->email, 'auth_lv' => $db_data->auth_lv, 
				'mid'=>$db_data->id, 'profile_img'=>$db_data->profile_img, 'username'=>$db_data->name, 
				'mobile'=>$db_data->mobile,
				'member_user_id'=>$db_data->userId
				);			
			$this->session->set_userdata($newdata);
			redirect(BASE_URL);				
		}
		
		//print_r($user_row);		
		
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
					'mobile' => '01011112222',
					'modifyDatetime' => date('Y-m-d H:i:s'),
					'createDatetime' => date('Y-m-d H:i:s'),
					'isNew' => '1',
					'is_auth' => 1,
					'auth_lv' =>4,
					'sns_type' =>$sns_type,
					'sns_auth' =>"F"
			);
			$result=$this->common_model->insert('tb_member', $data);
			
			$point_data = array(
						'memberId'=>$result['insert_id'],
						'orderId'=>null,
						'name'=>'회원 가입',
						'money'=> 1000,
						'endDatetime'=>null,
						'createDatetime'=>date("Y-m-d H:i:s")
			);
			$this->db->insert('tb_member_saved_money',$point_data);
			
			if($result){
				//세션 만들어줌
				$db_data = $this->common_model->sns_login_chk($email);				
				
				$newdata = array(
				'email' => $db_data->email, 'auth_lv' => $db_data->auth_lv, 
				'mid'=>$db_data->id, 'profile_img'=>$db_data->profile_img, 'username'=>$db_data->name, 
				'mobile'=>$db_data->mobile,
				'member_user_id'=>$db_data->userId
				);			
				$this->session->set_userdata($newdata);
				redirect(BASE_URL);
				
			}else{
				alert('회원 가입에 실패 하였습니다. 처음부터 다시 시도해 주십시오.','/auth/login');
			}
		}
	}


}
