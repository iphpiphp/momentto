<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Temp_email {
	
	//이메일 전송
	function order_fin_mail_send($send_email, $oid, $point, $pay_type, $payment, $fin_is_member, $cart_data){
		$CI = get_instance();
		
		$CI->load->library('email');
		$CI->load->library('session');	
		
		$location = $CI -> session -> userdata('location');
		if (!$location)	$location = "ko";
		
		$email_exp = explode("@", $send_email);
		$name = $email_exp[0];
		//$this->email->initialize($config);
		
		$CI->email->from('cswithvideo@naver.com', 'thedays');
		$CI->email->to($send_email);
		
		$data = array();
		$data['oid'] = $oid;
		$data['point'] = $point;
		$data['pay_type'] = $pay_type;
		$data['payment'] = $payment;
		$data['fin_is_member'] = $fin_is_member;
		$data['cart_data'] = $cart_data;
		$data['name'] = $name;
		
		
		//		$this->email->cc('another@another-example.com'); 
		//		$this->email->bcc('them@their-example.com'); 
		
		$title = "[주문완료] 요청하신 주문이 완료 되었습니다.";
		$CI->email->subject($title);
		$CI->email->message($CI->load->view($location .'/mailTemplate/order', $data, TRUE)); //메세지		
		
		//$this->email->set_alt_message($this->load->view('email/'.$type.'-txt', $data, TRUE)); //html 메일을 못받는 경우 txt 파일로 대체
		
		
		
		$status = $CI->email->send();
		
		
	}
	
	function sqs_email(){

		//echo "sqs_email <hr />";
		$this->load->library('email');

		$key = 'AKIAI7I6Z7UDDWLYSL6Q';
		$skye = "AdfdC2kO5VNme25MjXaYSA5cjw5Bo5JCM9v5Qc2O";
		$region = "ap-northeast-2";

		$provider = CredentialProvider::ini();
		$provider = CredentialProvider::memoize($provider);

		$profile = 'default';
		$path = FCPATH.'/.aws/credentials';

		$provider = CredentialProvider::ini($profile, $path);
		$provider = CredentialProvider::memoize($provider);


		// Use the s3 buket config
		$sharedConfig['region'] = $region;
		$sharedConfig['version'] = 'latest';
		$sharedConfig['signature_version'] = 'v4';
		$sharedConfig['credentials'] = $provider;

		try{
			//send email
			$this->email->from("cswithvideo@naver.com",'thedays'); //보내는쪽
			$this->email->to($body->email); //받는쪽

			//		$this->email->cc('another@another-example.com');
			//		$this->email->bcc('them@their-example.com');

			$data = array();
			$data['member'] = array("email"=>$body->email);

			$type = "new_product"; //파일명
			$this->email->subject($body->subject);
			$this->email->message($body->message); //메세지
			$status = $this->email->send();

			if($status) echo "<br />".$body->email."님의 이메일이 정상적으로 전송 되었습니다!";
			$this->email->print_debugger(array('headers'));
		} catch (Exception $e) {
			die('Error creating new queue ' . $e->getMessage());
		}
	}//end function

}
