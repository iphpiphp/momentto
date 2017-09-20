<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Secretlib {

	protected static $key_size = 128;
	// The default key size in bits
	protected static $valid_key_sizes = array(128, 192, 256);
	// Sizes in bits
	protected static $key = "thedayssecretkey";
	protected static $iv = "1234567890123456";

	public static function pkcs5Pad2($data, $blocksize) {

		$pad = $blocksize - (strlen($data) % $blocksize);
		$returnValue = $data . str_repeat(chr($pad), $pad);

		return $returnValue;
	}

	public static function enc_aes128_ecb($data, $key = null, $iv = null, $dataAs = 0) {

		if (!$key)	$key = Secretlib::$key;
		if (!$iv)	$iv = Secretlib::$iv;

		$size = mcrypt_get_block_size(MCRYPT_RIJNDAEL_128, 'ecb');
		$cipher = mcrypt_module_open(MCRYPT_RIJNDAEL_128, '', 'ecb', '');

		// Add padding to String
		$data = self::pkcs5Pad2($data, $size);
		$length = strlen($data);

		mcrypt_generic_init($cipher, $key, $iv);

		$data = mcrypt_generic($cipher, $data);

		$data = bin2hex($data);
		mcrypt_generic_deinit($cipher);
		return $data;
	}

	public static function dec_aes128_ecb($data, $key = null, $iv = null, $dataAs = 0) {
		if (!$key)	$key = Secretlib::$key;
		if (!$iv)	$iv = Secretlib::$iv;

		$size = mcrypt_get_block_size(MCRYPT_RIJNDAEL_128, 'ecb');
		$cipher = mcrypt_module_open(MCRYPT_RIJNDAEL_128, '', 'ecb', '');

		mcrypt_generic_init($cipher, $key, $iv);

		$data = pack('H*', $data);
		
		$data = mdecrypt_generic($cipher, $data);
		mcrypt_generic_deinit($cipher);

		return Secretlib::pkcs5Unpad($data);
	}

	private static function pkcs5Unpad($data) {

		$pad = ord($data{strlen($data) - 1});
		if ($pad > strlen($data))
			return false;
		if (strspn($data, chr($pad), strlen($data) - $pad) != $pad)
			return false;

		return substr($data, 0, -1 * $pad);
	}

}
