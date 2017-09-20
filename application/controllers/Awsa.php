<?  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//require FCPATH.'vendor/autoload.php';

require realpath(FCPATH) . '/vendor/autoload.php';

use Aws\Ec2\Ec2Client;


use Aws\Sqs\SqsClient;
use Aws\Exception\AwsException;

use Aws\S3\S3Client;
use Aws\S3\Exception\S3Exception;
use Aws\Credentials\CredentialProvider;

class Awsa extends CI_Controller {
	function __construct()	{
		parent::__construct();
		$this->load->database('default');
		$this->load->model('aws_model');
		$this->load->model('common_model');
		
		$this->load->library('encrypt');
		$this->load->library('encryption');

		$this->load->helper('product_info');

		$this -> load -> library('pagination_custom_v3'); //ci 3 version
		//$this->output->enable_profiler(true);
	}

	function s3(){

		$bucket = 'thedays-movie-seoul';
		$key = 'AKIAIUZRQN2M4XEEEDQA';
		$skye = "90YQcY8t4VfZYzghoos+0mVnXIqs7P5H5SJABhRF";
		$region = "ap-northeast-2";
		$fileName = "B1000000000083341_kudomiyu_HD_The-Cat.mp4";
		$filepath = '*** Your File Path ***';

		$type = $this->uri->segment(3);
		$server = $this->uri->segment(4);
		$item = $this->input->get("item",true);


		if($server == "test") $bucket = 'test-thedays-movie-seoul';

		log_message("debug","server==>".$server);
		log_message("debug","bucket==>".$bucket);


		$result['status'] = "";
		$result['msg'] = "";
		$result['downloadUrl'] = "";

		if(!$type){
		$result['status'] = "false";
		$result['msg'] = "요청 타입이 맞지 않습니다.";
		$result['downloadUrl'] = "";

		$json_data = json_encode($result);
			print_r($json_data);
			exit;
		}
		if(!$item){
			$result['status'] = "false";
			$result['msg'] = "item 요청 타입이 맞지 않습니다.";
			$result['downloadUrl'] = "";

			$json_data = json_encode($result);
			print_r($json_data);
			exit;
		}

		if($type == "download_url"){

			$db_data = $this->aws_model->s3_file_download($server,$item);

			//걸리는게 있으면
			if( $db_data->num_rows() >= 1){
				$row = $db_data->row_array();
			}else{
				$result['status'] = "false";
				$result['msg'] = "해당 아이템이 없습니다.";
				$result['downloadUrl'] = "";
				$json_data = json_encode($result);
				print_r($json_data);
				exit;
			}

			//print_r($row);
			$fileName = $row['fileName'];
			//echo $fileName;
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

			// Create an SDK class used to share configuration across clients.
			$sdk = new Aws\Sdk($sharedConfig);

			// Create an Amazon S3 client using the shared configuration data.
			$client = $sdk->createS3();

			try {
				ini_set('memory_limit','-1');

				// Get the object
				$command = $client->getCommand('GetObject', array(
					'Bucket' => $bucket,
					'Key' => $fileName,
					'ResponseContentDisposition' => 'attachment; filename='.$fileName
				));

				// Create a signed URL from the command object that will last for
				// 10 minutes from the current time
				$request  = $client->createPresignedRequest($command,'+10 minutes');

				$presignedUrl = (string) $request->getUri();

				$result['status'] = "true";
				$result['msg'] = "조회에 성공 하였습니다.";
				$result['downloadUrl'] = $presignedUrl;
				$json_data = json_encode($result);
				print_r($json_data);

			} catch (S3Exception $e) {
				//echo $e->getMessage() . "\n";
				$result['status'] = "flase";
				$result['msg'] =$e->getMessage(). "\n";
				$result['data'] = array();
				$json_data = json_encode($result);
				exit;
			}
		}//end file down


	}
	function directs3(){

		$bucket = 'thedays-movie-seoul';
		$key = 'AKIAIUZRQN2M4XEEEDQA';
		$skye = "90YQcY8t4VfZYzghoos+0mVnXIqs7P5H5SJABhRF";
		$region = "ap-northeast-2";
		$fileName = "B1000000000083341_kudomiyu_HD_The-Cat.mp4";
		$filepath = '*** Your File Path ***';

		$type = $this->uri->segment(3);
		$server = $this->uri->segment(4);
		$item = $this->input->get("item",true);


		if($server == "test") $bucket = 'test-thedays-movie-seoul';

		log_message("debug","server==>".$server);
		log_message("debug","bucket==>".$bucket);


		$result['status'] = "";
		$result['msg'] = "";
		$result['downloadUrl'] = "";

		if(!$type){
		$result['status'] = "false";
		$result['msg'] = "요청 타입이 맞지 않습니다.";
		$result['downloadUrl'] = "";

		$json_data = json_encode($result);
			print_r($json_data);
			exit;
		}
		if(!$item){
			$result['status'] = "false";
			$result['msg'] = "item 요청 타입이 맞지 않습니다.";
			$result['downloadUrl'] = "";

			$json_data = json_encode($result);
			print_r($json_data);
			exit;
		}

		if($type == "download_url"){

			$db_data = $this->aws_model->s3_file_download($server,$item);

			//걸리는게 있으면
			if( $db_data->num_rows() >= 1){
				$row = $db_data->row_array();
			}else{
				$result['status'] = "false";
				$result['msg'] = "해당 아이템이 없습니다.";
				$result['downloadUrl'] = "";
				$json_data = json_encode($result);
				print_r($json_data);
				exit;
			}

			//print_r($row);
			$fileName = $row['fileName'];
			//echo $fileName;
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

			// Create an SDK class used to share configuration across clients.
			$sdk = new Aws\Sdk($sharedConfig);

			// Create an Amazon S3 client using the shared configuration data.
			$client = $sdk->createS3();

			try {
				ini_set('memory_limit','-1');

				// Get the object
				$command = $client->getCommand('GetObject', array(
					'Bucket' => $bucket,
					'Key' => $fileName,
					'ResponseContentType' => 'application/octet-stream',
					'ResponseContentDisposition' => 'attachment; filename='.$fileName
				));

				// Create a signed URL from the command object that will last for
				// 10 minutes from the current time
				$request  = $client->createPresignedRequest($command,'+10 minutes');

				$presignedUrl = (string) $request->getUri();

				redirect($presignedUrl);

				//header("Content-Type: {$result['ContentType']}");
    			//echo $result['Body'];

			} catch (S3Exception $e) {
				//echo $e->getMessage() . "\n";
				$result['status'] = "flase";
				$result['msg'] =$e->getMessage(). "\n";
				$result['data'] = array();
				$json_data = json_encode($result);
				exit;
			}
		}//end file down


	}
	function index(){}//end index

	//cli 실행
	function sqs_email_start(){
		//system("php index.php awsa sqs_email");
		$command = "php index.php awsa sqs_email";
		exec("nohup $command");
	}

	//mail server 오픈
	function mail_server_start(){

		$action = $this->uri->segment(3);
		echo "action = ".$action;

		$key = 'AKIAI7I6Z7UDDWLYSL6Q';
		$skye = "AdfdC2kO5VNme25MjXaYSA5cjw5Bo5JCM9v5Qc2O";
		$region = "ap-northeast-2";
		$server_id = "i-5d811efa";

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

		//$sdk = new Aws\Sdk($sharedConfig);
		//$client = $sdk->Ec2Client();
		try{
			$client = new Aws\Ec2\Ec2Client($sharedConfig);


			if($action =="start"){
				echo "action start!";
				$result = $client->startInstances(array(
					// InstanceIds is required stop
					'InstanceIds' => array($server_id)
				));
				print_r($result);
			}

			if($action =="stop"){
				echo "action! stop!";
				$result = $client->stopInstances(array(
					// InstanceIds is required stop
					'InstanceIds' => array($server_id)
				));
				print_r($result);
			}

			exit;
		} catch (Exception $e) {
			die('Error creating new queue ' . $e->getMessage());
		}
	}


	function test_aws(){}
	function test_gmail(){
		echo "test gmail mail";

		

		$this->load->library('email');
		
		$config['useragent'] = 'thedays';
		$config['protocol'] = 'smtp';
		$config['smtp_host'] = 'ssl://smtp.googlemail.com';
		$config['smtp_user'] = 'cswithvideo@gmail.com';
		$config['smtp_pass'] = 'thedays0629';
		$config['smtp_port'] = 465;
		$config['smtp_timeout'] = 5;
		$config['wordwrap'] = TRUE;
		$config['wrapchars'] = 76;
		$config['mailtype'] = 'html';
		$config['charset'] = 'utf-8';
		$config['validate'] = FALSE;
		$config['priority'] = 3;
		$config['crlf'] = "\r\n";
		$config['newline'] = "\r\n";
		$config['bcc_batch_mode'] = FALSE;
		$config['bcc_batch_size'] = 200;
		$this->email->initialize($config);
		
		$this->email->from("cswithvideo@gmail.com",'thedays'); //보내는쪽
		$this->email->to("cswithvideo@naver.com"); //받는쪽




		$this->email->subject("test mail");
		$this->email->message("test!"); //메세지
		$status = $this->email->send();
		if($status) echo "<br />이메일이 정상적으로 전송 되었습니다!";
		$this->email->print_debugger();

		echo "<hr> test end!";
	}

	function test_nate(){
		echo "test nate mail";
		$this->load->library('email');
		$config['useragent'] = 'thedays';
		$config['protocol'] = 'smtp';
		$config['smtp_host'] = 'ssl://smtp.mail.nate.com';
		$config['smtp_user'] = 'cswithvideo';
		$config['smtp_pass'] = 'thedays0629';
		$config['smtp_port'] = 465;
		$config['smtp_timeout'] = 5;
		$config['wordwrap'] = TRUE;
		$config['wrapchars'] = 76;
		$config['mailtype'] = 'html';
		$config['charset'] = 'utf-8';
		$config['validate'] = FALSE;
		$config['priority'] = 3;
		$config['crlf'] = "\r\n";
		$config['newline'] = "\r\n";
		$config['bcc_batch_mode'] = FALSE;
		$config['bcc_batch_size'] = 200;
		$this->email->initialize($config);
		
		$this->email->from("cswithvideo@nate.com",'thedays'); //보내는쪽
		$this->email->to("cswithvideo@naver.com"); //받는쪽

		


		$this->email->subject("test mail");
		$this->email->message("test!"); //메세지
		$status = $this->email->send();
		if($status) echo "<br />이메일이 정상적으로 전송 되었습니다!";
		$this->email->print_debugger();

		echo "<hr> test end!";

	}
	//
	function test_naver(){
		echo "test naver mail";
		$this->load->library('email');
		
		//$this->email->initialize($config);
		
		$this->email->from("cswithvideo@naver.com",'thedays'); //보내는쪽
		$this->email->to("cswithvideo@naver.com"); //받는쪽

		


		$this->email->subject("test mail");
		$this->email->message("test!"); //메세지
		$status = $this->email->send();
		if($status) echo "<br />이메일이 정상적으로 전송 되었습니다!";
		$this->email->print_debugger();

		echo "<hr> test end!";
	}

	//실제 메일 전송
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

			//기본 프로필 생성
			$sqs_client = new Aws\Sqs\SqsClient($sharedConfig);

			//생성
			//$queue_options = array('QueueName' => 'emailQueue2');
			//$sqs_client->createQueue($queue_options);

			//get queryUrl ... 사용할 정보
    		$result = $sqs_client->getQueueUrl(array('QueueName' => "emailQueue1"));
    		$queue_url = $result->get('QueueUrl');

			$i = 0;
			while(true){
				sleep(1);

				$result = $sqs_client->receiveMessage(array('QueueUrl' => $queue_url));
				//echo"RM=><pre>"; print_r($result); echo"</pre>";
				$msgs = $result->getPath('Messages');
				//echo"Msgs<pre>"; print_r($msgs); echo"</pre>";

				//echo count($msgs);
				if(count($msgs)===0){
					//echo "<hr />work end! & not work!";
					//break;
					echo ".";
					continue;
				}

				foreach ($msgs as $msg) {
					$body = json_decode($msg['Body']);
					$receiptHandle = $msg['ReceiptHandle'];

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
				}
				
				//메세지 큐 1개 삭제
				$sqs_client->deleteMessage(array(
                    'QueueUrl'  => $queue_url,
                    'ReceiptHandle' =>$receiptHandle
                ));
			}

		} catch (Exception $e) {
			die('Error creating new queue ' . $e->getMessage());
		}
	}//end function

	function email_form(){
		$data = array();
		$this->load->view("aws/email_form",$data);
	}
	function email_html_view(){
		//$this->output->enable_profiler(true);
		$html = ""; //html을 만들어서 보낸다

		$data = array();
		foreach($this->input->post(NULL, TRUE) as $key => $val) {
			$data["{$key}"] = $val;
			$data['post']["{$key}"] = $val;
		}
		
		
		$data['memberId'] = "2971";
		//$data['cid'] = "70"; //post 으로 넘어옴
		
		
		$sql = array("id"=>$data['cid']);
		$coupon_array = $this->common_model->select_get("tb_coupon", $sql);
		$data['coupon_price'] = $coupon_array->row()->price;
		
		$html = $this->load->view("aws/email_html_view.php",$data, true);
		echo $html;		
	}
	
	function find_member(){

		$input = array();
		foreach($this->input->post_get(NULL, TRUE) as $key => $val) $input["{$key}"]  = $val;
		if(!isset($input["page"])) $input["page"] = 1;
		if(!isset($input["pagelist"])) $input["pagelist"] = 30;
		$data['input'] = $input;

		$db_data = $this->common_model->find_member($input);

		//$link_url = "/".$this->segs[1]."/".$this->segs[2]."/".$this->segs[3]."/";
		$link_url = "/".$this->uri->segment(1)."/".$this->uri->segment(2);
		$total_count = $db_data['total_cnt'];
		$data['total_count'] = $total_count;

		$config = $this->pagination_custom_v3->pagenation_bootstrap($input["page"], $total_count, $input["pagelist"], $link_url, $segment=3, $num_link=3);
		$config['base_url'] = BASE_URL.$link_url;
		$config['page_query_string'] = TRUE; //쿼리 스트링
		$config['query_string_segment'] = 'page';
		$config['display_always'] = TRUE;      
		$config['use_fixed_page'] = TRUE;
		$config['fixed_page_num'] = 10;
		$this->pagination_custom_v3->initialize($config);
		
		$data['page_nation'] = $this->pagination_custom_v3->create_links();
		$data['lists'] = $db_data['page_list_m'];
		$this->load->view("aws/find_member_v",$data);

	}
	
	//실제 이메일 데이터 생성-- 
	function email_send(){
		//$this->output->enable_profiler(true);
		//sqs 메세지 셋팅

		$data = array();
		foreach($this->input->post(NULL, TRUE) as $key => $val) {
			$data["{$key}"] = $val;
			$data['post']["{$key}"] = $val;
		}


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
			//기본 프로필 생성
			$sqs_client = new Aws\Sqs\SqsClient($sharedConfig);
			//emailQueue1 or emailQueue2
    		$result = $sqs_client->getQueueUrl(array('QueueName' => $data["QueueName"]));
    		$queue_url = $result->get('QueueUrl');
		} catch (Exception $e) {
			die('Error creating new queue ' . $e->getMessage());
		}
	
		
		//$this->output->enable_profiler(true);
		$html = ""; //html을 만들어서 보낸다

		
				
		$limit = false;
		if(isset($data["limit"])) $limit = $data["limit"]; //반복횟수 추가


		$sql = array("id"=>$data['cid']);//쿠폰아이디 조회
		$coupon_array = $this->common_model->select_get("tb_coupon", $sql);
		$data['coupon_price'] = $coupon_array->row()->price;
		
		
		
		//유저데이터 배분...
		$sql = array("id <"=> $data['down'], "id >="=> $data['up'], "isEmail" => true); //회원 10000개 이하 담당
		
		$member_10000 = $this->common_model->select_get("tb_member", $sql, false, $limit);
//$table, $data = false, $orderby = false, $limit = false			
		//$member_10000 = $this->common_model->select_get("tb_member", $sql, false, 10);

		

		$i = 0;
		foreach($member_10000->result_array() as $key => $val){			
			if($data["action"] == "all"){
				$data['memberId'] = $val["id"];

			}else{
					//테스트용
				$data['memberId'] = $data["m_id"];
			}

			//$data['memberId'] = 8554; //sklee@thedays.co.kr

			//$data['memberId'] = 2971; //kudomiyu@hanmail.net

			$html = $this->load->view("aws/email_html_view.php",$data, true);

			try{
				if($data["action"] == "all"){
					$msg = array('subject'=>$data['email_title'], 'email'=>$val["email"],'message'=>$html);

				}else{
						//테스트용
					$msg = array('subject'=>$data['email_title'], 'email'=>$data['m_email'],'message'=>$html);
				}
					//$msg = array('subject'=>$data['email_title'], 'email'=>'sklee@thedays.co.kr','message'=>$html);
				
					//$msg = array('subject'=>$data['email_title'], 'email'=>'kudomiyu@hanmail.net','message'=>$html);


				//send 메세지
				$sqs_client->sendMessage(array(
						'QueueUrl'    => $queue_url,
						'MessageBody' => json_encode($msg),
				));
				$i++;

			} catch (Exception $e) {
				die('Error creating new queue ' . $e->getMessage());
			}
		}
		unset($member_10000); //memory free

		
		echo "메일 서버에 [". $data['QueueName']."] 총 $i 개의 메일이 셋팅 되었습니다. <br>";		
		
	}
	
	//이메일 거부
	function email_not(){
		$signature = $this->input->get("signature",true);

		$enkey = "thedays";
		$this->encryption->initialize(
				array(
						'cipher' => 'aes-128',
						'mode' => 'cbc',
						'key' => $enkey
				)
		);

		$get_decode = $this->encryption->decrypt($signature);
		$get = explode("&",$get_decode);

		parse_str($get_decode, $get_data);

		if(isset($get[0]) == FALSE || $get[0] != "v2016"){
			echo $get[0];
			//alert("정상적인 호출이 아닙니다.","http://thedays.co.kr");
			alert("비정상 호출! 잘못된 접근입니다.", REAL_URL);
			echo "비정상 호출";
			exit;
		}

		if(!isset($get[1])){
			//alert("정상적인 호출이 아닙니다.","http://thedays.co.kr");
			alert("파라메터 오류 1. 잘못된 접근입니다.", REAL_URL);
			echo "파라메터 오류 1";
			exit;
		}

		if(!isset($get[2])){
			//alert("정상적인 호출이 아닙니다.","http://thedays.co.kr");
			alert("파라메터 오류2. 잘못된 접근입니다.", REAL_URL);
			echo "파라메터 오류 2";
			exit;
		}

		//해당 아이로 쿠폰 지급
		$memberId = $get_data['id'];		

		$data = array("id"=>$memberId);
		$member_array = $this->common_model->select_get("tb_member",$data);
		$member_array = $member_array->row_array();
		if(!$member_array) alert("해당 회원이 없습니다.",REAL_URL);

		$data = array("isEmail"=>FALSE);
		$this->common_model->update("tb_member", "id", $data, $memberId);
		//update($table, $field, $data, $id)

		alert("상품 안내 이메일 수신 차단 설정 하였습니다.", REAL_URL."member/login");

	}
	
	//자동 쿠폰 발급
	function auto_coupon(){
		$signature = $this->input->get("signature",true);
		
		$enkey = "thedays";
		$this->encryption->initialize(
				array(
						'cipher' => 'aes-128',
						'mode' => 'cbc',
						'key' => $enkey
				)
		);
		
		$get_decode = $this->encryption->decrypt($signature);
		$get = explode("&",$get_decode);
		
		parse_str($get_decode, $get_data);
				
		if(isset($get[0]) == FALSE || $get[0] != "v2016"){
			//alert("정상적인 호출이 아닙니다.","http://thedays.co.kr");
			alert("비정상 호출! 잘못된 접근입니다.", REAL_URL);
			echo "비정상 호출";
			exit;
		}
		
		if(!isset($get[1])){
			//alert("정상적인 호출이 아닙니다.","http://thedays.co.kr");
			alert("파라메터 오류 1. 잘못된 접근입니다.", REAL_URL);
			echo "파라메터 오류 1";
			exit;
		}
		
		if(!isset($get[2])){
			//alert("정상적인 호출이 아닙니다.","http://thedays.co.kr");
			alert("파라메터 오류2. 잘못된 접근입니다.", REAL_URL);
			echo "파라메터 오류 2";
			exit;
		}
		
		//해당 아이로 쿠폰 지급		
		$memberId = $get_data['id'];
		$couponId = $get_data['cid'];
		
		$data = array("id"=>$memberId);
		$member_array = $this->common_model->select_get("tb_member",$data);
		$member_array = $member_array->row_array();		
		
		$data = array("id"=>$couponId);
		$coupon_array = $this->common_model->select_get("tb_coupon",$data);
		$coupon_array = $coupon_array->row_array();
		
		//체크 
		if(!$member_array) alert("해당 회원이 없습니다.",REAL_URL);
		if(!$coupon_array) alert("해당 쿠폰이 없습니다.",REAL_URL);
		
		//쿠폰 발급 받은적이 있는지 체크
		$data = array("memberId"=>$memberId, "couponId"=>$couponId);
		$chk = $this->common_model->select_get("tb_member_coupon_auto_chk", $data);
		if($chk->num_rows() >=1) {
			alert("동일한 쿠폰을 발급 받으신적이 있습니다.", REAL_URL);
			echo "동일 쿠폰 체크";
			exit;
		}
		
		
		$data = array("memberId"=>$memberId, "couponId"=>$couponId, 
					  "type"			=>$coupon_array["type"], 
					  "name"			=>$coupon_array["name"], 
					  "description"		=>$coupon_array["description"], 
					  "price"			=>$coupon_array["price"], 
					  "priceType"		=>$coupon_array["priceType"],
					  "startDatetime"	=>$coupon_array["startDatetime"],
					  "endDatetime"		=>$coupon_array["endDatetime"], 
					  "useProductType"	=>$coupon_array["useProductType"],
					  "productId"		=>$coupon_array["productId"],
					  "useCategoryType"	=>$coupon_array["useCategoryType"],
					  "categoryId"		=>$coupon_array["categoryId"],
					  "useDatetime"		=>NULL,
					  "createDatetime"=> date("Y-m-d H:i:s")
					 );
		$status = $this->common_model->insert("tb_member_coupon",$data);
		
		if($status){			
			//쿠폰 발급 추가		
			$data = array("memberId"=>$memberId, "couponId"=>$couponId);
			$this->common_model->insert("tb_member_coupon_auto_chk", $data);			
			alert("정상적으로 쿠폰을 발급 받으셨습니다.", REAL_URL."member/login");
			//echo "성공";
		}else{			
			alert("쿠폰 발급에 실패 하였습니다. 관리자에게 문의해 주십시오.", REAL_URL);
			//echo "실패";
		}
		echo "혹시 이 문구가 보이면, 스크립트 차단을 해제 해 주십시오.";	
	}
	
	function time(){
		//date_default_timezone_set('Asia/Seoul');
		echo date("Y-m-d H:i:s");
	}


}
