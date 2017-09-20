<?  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	
	//require FCPATH.'vendor/autoload.php';
	
	//require realpath(FCPATH) . '/vendor/autoload.php';
	require realpath(FCPATH) . '/vendor/facebook-php-sdk-v4/src/Facebook/autoload.php';
	//require_once __DIR__ . '/facebook-sdk-v5/autoload.php';
	
	use Facebook\FacebookSession;
	use Facebook\FacebookRequest;
	use Facebook\GraphUser;
	use Facebook\FacebookRequestException;
	
	//aws
	require realpath(FCPATH) . '/vendor/autoload.php';
	
	use Aws\Sqs\SqsClient;		
	use Aws\Exception\AwsException;
	
	use Aws\S3\S3Client;
	use Aws\S3\Exception\S3Exception;	
	use Aws\Credentials\CredentialProvider;
	

	
			
class Facebook extends CI_Controller  {
	function __construct()	{
		parent::__construct();
		$this -> load -> helper('alert');
		
		$this->load->database('default');		
		$this->load->model('common_model');
		$this->load->model('mypage_model');
		
		$this->output->enable_profiler(true);
	}
	
	public function _remap($method) {
		$this -> segs = $this -> uri -> segment_array();
		
		$fb = new Facebook\Facebook([
		  'app_id' => '777581829031957',
		  'app_secret' => 'e45295bdc6147e7cfbe81261df5f76cd',
		  'default_graph_version' => 'v2.4',
		]);
		

		if ($this -> input -> is_ajax_request()) {
			if (method_exists($this, $method)) {
				$this -> {"{$method}"}($fb);
			}
		} else {//ajax가 아니면			
			if (method_exists($this, $method)) {
				$this -> {"{$method}"}($fb);
			}			
		}
	}
	
	function fileupload($fb){
		$helper = $fb->getRedirectLoginHelper();
		$permissions = ['email', 'public_profile','user_friends','user_videos', 'user_posts'];
		$loginUrl = $helper->getLoginUrl('http://new.thedays.co.kr/facebook/fb_token', $permissions);
		
		/*
		$loginUrl   = $fb->getLoginUrl(
            array(
                'scope'         => 'email,offline_access,publish_stream,user_birthday,user_location,user_work_history,user_about_me,user_hometown',
                'redirect_uri'  => 'http://new.thedays.co.kr/facebook/fb_token'
            )
    	);
		 * 
		 */
	
		
		$item = array('item_id' => $this->uri->segment(3));
		$this->session->set_userdata($item);
		
		redirect(''.$loginUrl);
	}
	
	function fb_token($fb){
				
		$helper = $fb->getRedirectLoginHelper();
		
		try {
		  $accessToken = $helper->getAccessToken();
		} catch(Facebook\Exceptions\FacebookResponseException $e) {
		  // When Graph returns an error
		  echo 'Graph returned an error: ' . $e->getMessage();
		  exit;
		} catch(Facebook\Exceptions\FacebookSDKException $e) {
		  // When validation fails or other local issues
		  echo 'Facebook SDK returned an error: ' . $e->getMessage();
		  exit;
		}
		
		if (isset($accessToken)) {
			  // Logged in!
			  //$_SESSION['facebook_access_token'] = (string) $accessToken;
		  	//echo 'accessToken ==>' .$accessToken;
			$this->_video($fb, $accessToken);
			
		}
		
	}

	
	function _video($fb,$accessToken){
		ini_set('memory_limit','-1');		
		
		//https://test-thedays-movie-seoul.s3.ap-northeast-2.amazonaws.com/B1000000000122481_kudomiyu_HD_We-Will-Marry.mp4
		$item_id = $this->session->userdata("item_id");
		$db_data = $this->mypage_model->select_movie($item_id);
		$file = "";
		if($db_data ) {
			$file = $db_data->row()->filePath."/".$db_data->row()->fileName;
		}else{
			$file = "";
			alert("select file Err!","/mypageSample");
			exit;
		}
		
		$data = [
		  'title' => 'The days Video',
		  'description' => '',
		  'source' => $fb->videoToUpload($file)
		];
		//'source' => $fb->videoToUpload(FCPATH.'/sample.mp4'),
		
		try {
		  $response = $fb->post('/me/videos', $data, $accessToken);
		} catch(Facebook\Exceptions\FacebookResponseException $e) {
		  // When Graph returns an error
		  echo 'Graph returned an error: ' . $e->getMessage();
		  exit;
		} catch(Facebook\Exceptions\FacebookSDKException $e) {
		  // When validation fails or other local issues
		  echo 'Facebook SDK returned an error: ' . $e->getMessage();
		  exit;
		}
		
		$graphNode = $response->getGraphNode();
		
		//var_dump($graphNode);		
		//echo 'Video ID: ' . $graphNode['id'];
		alert("Upload request completed! Please Facebook connect after 1-5 minutes!","/mypageSample");
	}
	
}