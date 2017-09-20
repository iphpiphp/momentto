<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');




//require realpath(FCPATH) . '/vendor/google/auth/autoload.php';

//require_once FCPATH.'/vendor/autoload.php';
require_once FCPATH.'/vendor/google/auth/autoload.php';


class Snsupload extends CI_Controller
{
	public function __construct()
	{
        parent::__construct();
		$this->load->library('session');
        $this->load->helper('url');
	}

	
	function login(){
		  echo "<pre>";
print_r(get_declared_classes());
echo "</pre>";
		$client = new Google_Client();
		//$client = new Google_Client();
		$client->setAuthConfig('client_secrets.json');
		
	}
	function request_youtube_bbb(){
		$access_token=$this->input->get("access_token", TRUE);
		$code=$this->input->get("code", TRUE);
		$state=$this->input->get("state", TRUE);
		$orig_state=$this->session->userdata("state");
		$oauth_token=$this->input->get("oauth_token", TRUE);
		$oauth_verifier=$this->input->get("oauth_verifier", TRUE);

		$params['key'] = '966266008065-i8lk0ufp96bm2igtj6jkqe2572t70tqk.apps.googleusercontent.com';
		$params['secret'] = 'n9qwHyjmj60FzaQpa684M27J';

		$url="https://www.googleapis.com/oauth2/v3/token";
			$ch=curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
			curl_setopt($ch, CURLOPT_POST, 1);
			$postdata="code=".$code."&client_secret=".$params['secret']."&client_id=".$params['key']."&redirect_uri=".urlencode(GOOGLE_REDIRECT_URI)."&grant_type=authorization_code";
			curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
			$result=curl_exec($ch);
			$json=json_decode($result);

		print_r($json);


			//if(!empty($json->{'error'})) alert("인증 절차가 잘못 되었습니다.  다시 시도해 주십시오.");

			$url="https://www.googleapis.com/oauth2/v2/userinfo";
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
			curl_setopt($ch, CURLOPT_POST, 0);
			$header=array("Authorization: ".$json->{'token_type'}." ".$json->{'access_token'});
			curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
			$result=curl_exec($ch);
			$json=json_decode($result);
	}

	//CALL THIS METHOD FIRST BY GOING TO
	//www.your_url.com/index.php/request_youtube
	public function request_youtube()
	{
		$params['key'] = '966266008065-i8lk0ufp96bm2igtj6jkqe2572t70tqk.apps.googleusercontent.com';
		$params['secret'] = 'n9qwHyjmj60FzaQpa684M27J';
		$params['algorithm'] = 'HMAC-SHA1';

		$this->load->library('google_oauth', $params);

		$data = $this->google_oauth->get_request_token('http://m.thedays.co.kr/snsupload/request_youtube');

		//print_r($data);
		exit;

		$this->session->set_userdata('token_secret', $data['token_secret']);
		redirect($data['redirect']);
	}

	//This method will be redirected to automatically
	//once the user approves access of your application
	public function access_youtube()
	{
		$params['key'] = '966266008065-i8lk0ufp96bm2igtj6jkqe2572t70tqk.apps.googleusercontent.com';
		$params['secret'] = 'n9qwHyjmj60FzaQpa684M27J';
		$params['algorithm'] = 'HMAC-SHA1';

		$this->load->library('google_oauth', $params);

		$oauth = $this->google_oauth->get_access_token(false, $this->session->userdata('token_secret'));

		//print_r($oauth);

		$this->session->set_userdata('oauth_token', $oauth['oauth_token']);
		$this->session->set_userdata('oauth_token_secret', $oauth['oauth_token_secret']);
	}

	//This method can be called without having
	//done the oauth steps
	public function youtube_no_auth()
	{
		$params['apikey'] = 'AIzaSyBVjZyh5MTWJ58qg_6BKD3ZllOBjoe3Br8';

		$this->load->library('youtube', $params);
		echo $this->youtube->getKeywordVideoFeed('pac man');

	}

	//This method can be called after you executed
	//the oauth steps
	public function youtube_auth()
	{
		$params['apikey'] = 'AIzaSyBVjZyh5MTWJ58qg_6BKD3ZllOBjoe3Br8';
		$params['key'] = '966266008065-i8lk0ufp96bm2igtj6jkqe2572t70tqk.apps.googleusercontent.com';
		$params['secret'] = 'n9qwHyjmj60FzaQpa684M27J';
		$params['oauth']['algorithm'] = 'HMAC-SHA1';
		$params['oauth']['access_token'] = array('oauth_token'=>urlencode($this->session->userdata('oauth_token')),
												 'oauth_token_secret'=>urlencode($this->session->userdata('oauth_token_secret')));

		$this->load->library('youtube', $params);
		echo $this->youtube->getUserUploads();
	}

	public function direct_upload()
	{
		$videoPath = 'THE RELATIVE PATH ON YOUR SERVER TO THE VIDEO';
		$videoType = 'THE CONTENT TYPE OF THE VIDEO'; //This is the mime type of the video ex: 'video/3gpp'

		$params['apikey'] = 'ENTER YOUR GOOGLE YOUTUBE API KEY';
		$params['oauth']['key'] = 'ENTER YOUR GOOGLE CONSUMER KEY';
		$params['oauth']['secret'] = 'ENTER YOUR GOOGLE CONSUMER SECRET';
		$params['oauth']['algorithm'] = 'HMAC-SHA1';
		$params['oauth']['access_token'] = array('oauth_token'=>urlencode($this->session->userdata('oauth_token')),
												 'oauth_token_secret'=>urlencode($this->session->userdata('oauth_token_secret')));
		$this->load->library('youtube', $params);

		$metadata = '<entry xmlns="http://www.w3.org/2005/Atom" xmlns:media="http://search.yahoo.com/mrss/" xmlns:yt="http://gdata.youtube.com/schemas/2007"><media:group><media:title type="plain">Test Direct Upload</media:title><media:description type="plain">Test Direct Uploading.</media:description><media:category scheme="http://gdata.youtube.com/schemas/2007/categories.cat">People</media:category><media:keywords>test</media:keywords></media:group></entry>';
		echo $this->youtube->directUpload($videoPath, $videoType, $metadata);
	}
}

/* End of file example.php */
/* Location: ./application/controllers/example.php */
