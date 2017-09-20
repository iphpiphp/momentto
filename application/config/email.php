<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| Email
| -------------------------------------------------------------------------
| This file lets you define parameters for sending emails.
| Please see the user guide for info:
|
|	http://codeigniter.com/user_guide/libraries/email.html
|
*/

/*
$config = array();
$config['useragent']           = "CodeIgniter";
$config['mailpath']            = "/usr/bin/sendmail"; // or "/usr/sbin/sendmail"
$config['protocol']            = "smtp";
$config['smtp_host']           = "localhost";
$config['smtp_port']           = "25";
*/

/*
$config = array();
$config['mailtype'] 			= 'html';
$config['useragent']           	= "CodeIgniter";
$config['mailpath']            	= "/usr/bin/sendmail"; // or "/usr/sbin/sendmail"
$config['protocol']     		= 'smtp';
$config['smtp_host']           	= "smtp.daum.net";
$config['smtp_port']           	= "465";
$config['smtp_user']    		= 'kudomiyu';
$config['smtp_pass']    		= 'mrv!&$!1';
$config['crlf'] 				= '\r\n';      //should be "\r\n"
$config['newline'] 				= '\r\n';   //should be "\r\n"
$config['wordwrap'] 			= TRUE; 
*/

/*
//
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



/*
//naver
$config['useragent'] = 'thedays';
$config['protocol'] = 'smtp';
$config['smtp_host'] = 'ssl://smtp.naver.com';
$config['smtp_user'] = 'cswithvideo@naver.com';
$config['smtp_pass'] = 'thedays0629';
$config['smtp_port'] = 465; 
$config['smtp_timeout'] = 50;
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






/*
$config['mailtype'] = 'html';
$config['useragent']    = 'ses-smtp-user.20150914-110514';
$config['protocol']     = 'smtp';
//$config['smtp_crypto']  = 'tls';
$config['smtp_host']    = 'tls://email-smtp.us-east-1.amazonaws.com';
$config['smtp_user']    = 'AKIAJHO5WPB5VIYERCIA';
$config['smtp_pass']    = 'AjaaQXP+3drgsV6aC007pB1/br3e6yY9BKjzyK44Juq/';
$config['smtp_port']    = '465';
$config['charset']  = 'utf-8';
$config['crlf'] = '\r\n';      //should be "\r\n"
$config['newline'] = '\r\n';   //should be "\r\n"
$config['wordwrap'] = TRUE; 
$config['smtp_crypto'] = 'tls'; // TLS protocol
$config['email_newline'] = "\r\n"; // SES hangs with just \n
*/

/*
$config['useragent'] = 'thedays';
		$config['protocol'] = 'smtp';
		$config['smtp_host'] = 'ssl://smtp.naver.com';
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
*/

//smtp.mailgun.org
$config['useragent'] = 'withvideo';
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

/* End of file email.php */
/* Location: ./application/config/email.php */
