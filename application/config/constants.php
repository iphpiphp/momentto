<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
define('FILE_READ_MODE', 0644);
define('FILE_WRITE_MODE', 0666);
define('DIR_READ_MODE', 0755);
define('DIR_WRITE_MODE', 0755);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/

define('FOPEN_READ', 'rb');
define('FOPEN_READ_WRITE', 'r+b');
define('FOPEN_WRITE_CREATE_DESTRUCTIVE', 'wb'); // truncates existing file data, use with care
define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE', 'w+b'); // truncates existing file data, use with care
define('FOPEN_WRITE_CREATE', 'ab');
define('FOPEN_READ_WRITE_CREATE', 'a+b');
define('FOPEN_WRITE_CREATE_STRICT', 'xb');
define('FOPEN_READ_WRITE_CREATE_STRICT', 'x+b');

/*
|--------------------------------------------------------------------------
| Display Debug backtrace
|--------------------------------------------------------------------------
|
| If set to TRUE, a backtrace will be displayed along with php errors. If
| error_reporting is disabled, the backtrace will not display, regardless
| of this setting
|
*/
define('SHOW_DEBUG_BACKTRACE', TRUE);

/*
|--------------------------------------------------------------------------
| Exit Status Codes
|--------------------------------------------------------------------------
|
| Used to indicate the conditions under which the script is exit()ing.
| While there is no universal standard for error codes, there are some
| broad conventions.  Three such conventions are mentioned below, for
| those who wish to make use of them.  The CodeIgniter defaults were
| chosen for the least overlap with these conventions, while still
| leaving room for others to be defined in future versions and user
| applications.
|
| The three main conventions used for determining exit status codes
| are as follows:
|
|    Standard C/C++ Library (stdlibc):
|       http://www.gnu.org/software/libc/manual/html_node/Exit-Status.html
|       (This link also contains other GNU-specific conventions)
|    BSD sysexits.h:
|       http://www.gsp.com/cgi-bin/man.cgi?section=3&topic=sysexits
|    Bash scripting:
|       http://tldp.org/LDP/abs/html/exitcodes.html
|Notice: Undefined index: HTTPS in /var/www/html/application/config/constants.php on line 88
 * 
*/
define('EXIT_SUCCESS', 0); // no errors
define('EXIT_ERROR', 1); // generic error
define('EXIT_CONFIG', 3); // configuration error
define('EXIT_UNKNOWN_FILE', 4); // file not found
define('EXIT_UNKNOWN_CLASS', 5); // unknown class
define('EXIT_UNKNOWN_METHOD', 6); // unknown class member
define('EXIT_USER_INPUT', 7); // invalid user input
define('EXIT_DATABASE', 8); // database error
define('EXIT__AUTO_MIN', 9); // lowest automatically-assigned error code
define('EXIT__AUTO_MAX', 125); // highest automatically-assigned error code

$base_url = (isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] == "on") ? "https://" : "http://";
$base_url .= $_SERVER["HTTP_HOST"];
define('BASE_URL',$base_url);


// by ykshin 2015.10.07 for SNS
define('TWITTER_CODE', "TW");
define('FACEBOOK_CODE', "FB");
define('KAKAO_CODE', "KO");
define('GOOGLE_CODE', "GP");
define('NAVER_CODE', "NV");
define('DAUM_CODE', "DM");
define('TW_CLIENT_ID', "p5ekbfVJ3SDEUWxqe3uR4jGxm");
define('TW_CLIENT_SECRET', "h96SkQV8WMlzFG1zjgvsBwpQAinsli3sKROpIYdnB1h3WJWVEG");
define('FB_CLIENT_ID', "777581829031957");
define('FB_CLIENT_SECRET', "e45295bdc6147e7cfbe81261df5f76cd"); //e45295bdc6147e7cfbe81261df5f76cd

define('KO_CLIENT_ID', "5c8e0653c61e1a749920ee71e86b0ad1");
define('NV_CLIENT_ID', "FDkAgCNuBKQ2qxlYJHzv");
define('NV_CLIENT_SECRET', "Y7vdVrWkfO");
define('GP_CLIENT_ID', "776192909259-voefphoaio9hrh2nltltcrv4ntifrtna.apps.googleusercontent.com");
define('GP_CLIENT_SECRET', "ksnBD3Jd3irVOyupmLfkQcIz");
define('DM_CLIENT_ID', "3621228956584600623");
define('DM_CLIENT_SECRET', "6353f19e3036c3aa248765fcf043d06f");

define('FACEBOOK_REDIRECT_URI', BASE_URL."/auth/callback?type=".FACEBOOK_CODE);
define('NAVER_REDIRECT_URI', BASE_URL."/auth/callback?type=".NAVER_CODE);
define('GOOGLE_REDIRECT_URI', BASE_URL."/auth/callback?type=".GOOGLE_CODE);
define('KAKAO_REDIRECT_URI', BASE_URL."/auth/callback?type=".KAKAO_CODE);
define('DAUM_REDIRECT_URI', BASE_URL."/auth/callback?type=".DAUM_CODE);



define('API_FACEBOOK_REDIRECT_URI', BASE_URL."/api/callback?type=".FACEBOOK_CODE);
define('API_NAVER_REDIRECT_URI', BASE_URL."/api/callback?type=".NAVER_CODE);
define('API_GOOGLE_REDIRECT_URI', BASE_URL."/api/callback?type=".GOOGLE_CODE);
define('API_KAKAO_REDIRECT_URI', BASE_URL."/api/callback?type=".KAKAO_CODE);
define('API_DAUM_REDIRECT_URI', BASE_URL."/api/callback?type=".DAUM_CODE);

define('TEST_API_FACEBOOK_REDIRECT_URI', BASE_URL."/api/test_callback?type=".FACEBOOK_CODE);
define('TEST_API_NAVER_REDIRECT_URI', BASE_URL."/api/test_callback?type=".NAVER_CODE);
define('TEST_API_GOOGLE_REDIRECT_URI', BASE_URL."/api/test_callback?type=".GOOGLE_CODE);
define('TEST_API_KAKAO_REDIRECT_URI', BASE_URL."/api/test_callback?type=".KAKAO_CODE);
define('TEST_API_DAUM_REDIRECT_URI', BASE_URL."/api/test_callback?type=".DAUM_CODE);


define('SINGNKEY', 'T1JsU2IrUXdlc2xwdThjVGtORWhxQT09');//이니시스 싱글키
define('CONNECT_TIMEOUT', 5);
define('READ_TIMEOUT', 15);
define('INICIS_MID','thedays000');

define('BANK_NUM','535901-01-303137');

//define('MAIL_TO','cswithvideo@gmail.com');
define('MAIL_TO','cs@thedays.co.kr');
//define('MAIL_TO','kudomiyu@hanmail.net');
 
//페이팔 리턴
//define('PP_HOSTNAME','www.sandbox.paypal.com'); //test
//define('PP_AUTH_TOKEN','1DKax8uOsMqwO-q2A7nIiSkgSRgHtWeJHVBvirVW_ucS012auSRIK5Tf-ym'); //test
 
//define('PP_HOSTNAME','www.paypal.com');
//define('PP_AUTH_TOKEN','tthbdHIA4NXa3ci4803nAaw4PzSR4BHNi15UluA8U7VgtXu-yhKaJm5nsrG');

 
//페이팔 결재 요청
//define('PP_URL','https://www.sandbox.paypal.com/kr/cgi-bin/webscr'); 	//test
//define('PP_RECV_MAIL','cswithvideo-facilitator-1@gmail.com');			//test
 
//define('PP_URL','https://www.paypal.com/cgi-bin/webscr');
//define('PP_RECV_MAIL','cswithvideo@gmail.com');


define('REAL_URL', 'http://thedays.co.kr/');
define('IMG_PATH','/assets/');
define('PATH2', "/assets2/"); //뉴 패스
define('PATH_ADMIN', "/assets2/admin/"); //뉴 패스


define('ASSET_PATH','/assets/');

define('PATH3', "/assets3/"); //새버전
define('PATH_ADMIN3', "/assets3/admin/"); //뉴 패스


//define('IMG_O_PATH','http://thedays.co.kr/');
define('IMG_O_PATH','https://d359hdvta3sq5o.cloudfront.net');
define('URL_PATH','http://thedays.co.kr/');
define('URL_LOGIN', 'http://thedays.co.kr/member/login.html');
//define('IMG_O_PATH','http://test.thedays.co.kr/');
//define('URL_PATH','http://test.thedays.co.kr/');
//define('URL_LOGIN', 'http://test.thedays.co.kr/member/login.html');

define('TEST_URL_LOGIN', 'http://test.thedays.co.kr/member/login.html');


//APP 관련
define("APP_IMG_PATH", URL_PATH."/resources/uploads/product/image/");

define("APP_KEY", md5("theaysmoviemaker0029"));
define("APP_DB",  'test'); //DB 셀렉트
//define("APP_DB",  'real');


//DB 컨트롤
//define("WEB_DB",  'test'); //DB 셀렉트
define("WEB_DB",  'real'); //DB 셀렉트

//define("SNS_DB",  'test'); //DB 셀렉트 sns 페이스북용
define("SNS_DB",  'real'); //DB 셀렉트



define("AWS_DB_T",  'test');
define("AWS_DB_R",  'real');

 
define("S3_IMG_PATH", 'https://d359hdvta3sq5o.cloudfront.net');



define('KAKAO_URL',$base_url."/order/");
define('INICIS_URL',$base_url."/order/");



/*
---google api
*/

define('APPLICATION_NAME', 'thedays');
define('CREDENTIALS_PATH', FCPATH.'/credentials/people.googleapis.com-php-quickstart.json');
define('CLIENT_SECRET_PATH', FCPATH. '/credentials/client_secret_966266008065-i8lk0ufp96bm2igtj6jkqe2572t70tqk.apps.googleusercontent.com.json');
