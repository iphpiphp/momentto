<? if (!defined('BASEPATH')) exit('No direct script access allowed');

// 경고메세지를 경고창으로
function lang($location) {
	$CI =& get_instance();	
	
	$CI->lang->load('common', $location);
	//var_dump($CI->lang);
	
	//print_r($CI->lang->language);
	
	/*
	echo "<script> ";
	echo "\n";
	foreach ($CI->lang->language  as $key => $value) {
		//echo $key ."-". $value;
		
		echo 'var '.strtoupper($key).' = "'.$value.'";';
		echo "\n";
		
		
		
	}
	echo "</script>";
	*/
	
	foreach ($CI->lang->language  as $key => $value) {
		define(strtoupper($key), $value);
		
	}
	
	
	//echo '<script src="/common_lang.php"></script>';
	
}
