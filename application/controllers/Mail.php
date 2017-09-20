<?  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require FCPATH.'vendor/autoload.php';
		use Mailgun\Mailgun;

class Mail extends CI_Controller {
	function __construct()	{
		parent::__construct();

	}



	function route()
	{
		echo "ok";
	}

	function test_send()
	{
		$this->load->library('email');
		//$this->email->sendMailgun("admin@withvideo.com", "hello", "world");
		$this->email->sendMailgun("kudomiyu@thedays.co.kr", "hello", "world");

	}

	function send(){


		# Instantiate the client.
		$mgClient = new Mailgun("key-7aed60a2f9106eb9c56dea9f0184e369");
		$domain = "withvideo.com";

		# Make the call to the client.
		$result = $mgClient->sendMessage($domain, array(
			'from'    => 'admin@withvideo.com',
			'to'      => 'Baz <kudomiyu@naver.com>',
			'subject' => 'Hello?',
			'text'    => 'Testing some Mailgun awesomness!!'
		));
	}
}
