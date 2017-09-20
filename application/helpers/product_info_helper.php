<? if (!defined('BASEPATH')) exit('No direct script access allowed');


function product_info($product_id){
	$CI = get_instance();
	$CI->load->model('common_model');
	$product = $CI->common_model->product_info($product_id);
	return $product;
}
