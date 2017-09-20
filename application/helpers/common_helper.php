<? if (!defined('BASEPATH')) exit('No direct script access allowed');


function use_point(){
	$CI = get_instance();
	$point = 0;
	$email = $CI->session->userdata['email']; 
	if($email && $CI->session->userdata['auth_lv']>=4){	
	    $CI->load->model('common_model');		
		$point = $CI->common_model->use_point($email);
	}
	return $point;
}

function auth_lv($type){
	$type = strtolower($type);
	$data = "";
	if($type == "4"){
		$data = "nomal";
	}else if($type == "5"){
		$data = "oprater";
	}else if($type == "6"){
		$data = "resaler";
	}else if($type == "7"){
		$data = "admin";
	}else if($type == "9"){
		$data = "super admin";
	}
	echo $data;
}
function sns_type($type){
	$type = strtolower($type);
	$data = "";
	if($type == "td"){
		$data = "site";
	}else if($type == "fb"){
		$data = "faceBook";
	}
	echo $data;


}

function payment_type($type){
	$type = strtolower($type);
	$data = "";
	if($type == "card"){
		$data = "카드";
	}else if($type == "point"){
		$data = "적립금";
	}else if($type == "apoint"){
		$data = "관리자 대리구매";
	}else if($type == "bank"){
		$data = "다이렉트뱅크";
	}else if($type == "vbank"){
		$data = "가상계좌";
	}else if($type == "directbank"){
		$data = "다이렉트뱅크";
	}else if($type == "kakao"){
		$data = "카카오페이";
	}else if($type == "paypal"){
		$data = "페이팔";
	}else if($type == "hpp"){
		$data = "휴대폰";
	}
	echo $data;


}
function movie_ststus_type($type){
	$type = strtolower($type);
	$data = "";
	if($type == "01"){
		$data = "입금대기";
	}else if($type == "02"){
		$data = "대기중";
	}else if($type == "03"){
		$data = "진행중";
	}else if($type == "07"){
		$data = "환불신청";
	}else if($type == "09"){
		$data = "환불완료";
	}else if($type == "10"){
		$data = "무비진행중";
	}else if($type == "11"){
		$data = "진행완료(보관)";
	}else if($type == "00"){
		$data = "미결제";
	}
	echo $data;


}

function exchange($type){
	$CI = get_instance();
	$CI->load->model('common_model');
	$money = $CI->common_model->exchange($type);
	return $money; 
}


function filedown($filename, $newfilename = 'set_code.zip'){
	$CI = get_instance();
	$CI->load->helper('download');
	
	$data = file_get_contents("/resources/set_zip/".$filename); // Read the file's contents
	force_download($newfilename, $data);
}

function first_helper(){
	$CI = get_instance();
	if($CI->uri->segment(3)){
		echo '<script> window.onload = function() { ajax_find_product("'.$CI->uri->segment(3).'");}</script>';
	}
}
function ajax_cate(){
	$CI = get_instance();
	$CI->load->model('common_model');
	$db = $CI->common_model->cate_list();
	$opt = "";
	$i=0;
	//echo "<pre>";print_r($db); echo "</pre>";
	$html = '
		<select name="cate" id="cate" class="form-control">
			<option calss="cate_options" value="" select>카테고리를 선택하세요</option>
			';
	
	foreach($db as $key => $val){	
		$id = $val['id'];
		$name = $val['name'];
		$opt .= '<option calss="cate_options" value="'.$id.'" >'.$name.'</option>';
	}
	$html .= $opt;
			
		
	$html .= '</select>		
		<select name="product" id="product" class="form-control">
			<option calss="product_options" value="" disabled>제품을 선택하세요</option>			
		</select>
	';
	echo $html;
}
function order_section_pay_scritp(){

	?>
	<script>
		$(document).ready(function() {
			$('input:radio[name=methodtype]').change(function() {
				var oldPayType = $(".payType").val();
				$(".payType").val($(this).val());
				if ($(this).val() == "PAYPAL") {

					$("#is").load("/order/" + $(this).attr("item"));
				}
				if ($(this).val() == "CACAO") {

					$("#is").load("/order/" + $(this).attr("item"));
				}
				if ($(this).val() == "POINT") {
					$("#is").load("/order/" + $(this).attr("item"));
				}

				//이니시스 아닌 상품 상태에서
				if (oldPayType == "PAYPAL" || oldPayType == "CACAO" || oldPayType == "POINT") {
					//이니시스 상품을 고르면 체인지
					if ($(this).val() == "Card" || $(this).val() == "DirectBank" || $(this).val() == "Hpp") {
						$("#is").load("/order/" + $(this).attr("item"));
					}
				}
				$("#gopaymethod").val($(this).val());
			});
			$('input:radio[name=methodtype]:input[value=' + $(".payType").val() + '] ').attr("checked", true);
		});

	</script>
	<?

}

function order_section_pay_type(){
	/*

	<label class="col-xs-6 pb5">
						<input type="radio" id="methodtype2" value="DirectBank" name="methodtype" item="ifream_form_inisis"> 실시간 계좌이체
					</label>

	*/
	$CI = get_instance();
	$data = '<section>
			<h3 class="h-frm color_blue2">결제수단</h3>
			<div class="pa16 bg_wh">
				<div class="row radio">
					<label class="col-xs-6 pb5">
						<input type="radio" id="methodtype1" value="Card" name="methodtype" item="ifream_form_inisis"> 신용카드
					</label>
					<label class="col-xs-6 pb5">
						<input type="radio" id="payType4" item="ifream_form_paypal" name="methodtype" value="PAYPAL"> PayPal
					</label>

					<label class="col-xs-6 pb5">
						<input type="radio" id="payType2" style="z-index:999" item="ifream_form_cacao" name="methodtype" value="CACAO"> 카카오페이
					</label>
					<label class="col-xs-6 pb5">
						<input type="radio" id="methodtype4" value="Hpp" name="methodtype" item="ifream_form_inisis"> 휴대폰
					</label>
					';

	if($CI->session->userdata['auth_lv']>=4) {
					$data .= '<label class="col-xs-6 pb5">
						<input type="radio" id="payType6" item="ifream_form_point" name="methodtype" value="POINT"> 적립금
					</label>';
	}
	$data .= '
				</div>
			</div>
		</section>';
		echo $data;
}
function order_section_pay_type_b(){
	$CI = get_instance();

	//$this->output->append_output("asd");


	$data  = '
	<section>
	<h1 class="sub_hd">결제 수단</h1>
	<div class="rounding-outline ord-ordpaper-section" style="padding: 20 20 20 20;">
		<div class="pay_left_info_block">
			<div class="pay_radio">
				<input type="radio" id="methodtype1" value="Card" name="methodtype" item="ifream_form_inisis">
				<label for="methodtype1">신용카드</label>
			</div>
			<div class="pay_radio">
				<input type="radio" id="methodtype2" value="DirectBank" name="methodtype" item="ifream_form_inisis">
				<label for="methodtype2">실시간계좌이체</label>
			</div>
			<div class="pay_radio">
				<input type="radio" id="methodtype4" value="Hpp" name="methodtype" item="ifream_form_inisis">
				<label for="methodtype4">휴대폰</label>
			</div>
		</div>

		<div class="pay_right_info_block">
			<div class="pay_radio">
				<input type="radio" id="payType4" item="ifream_form_paypal" name="methodtype" value="PAYPAL">
				<label for="payType4">PayPal</label>
			</div>
			<div class="pay_radio">
				<input type="radio" id="payType2" style="z-index:999" item="ifream_form_cacao" name="methodtype" value="CACAO">
				<label for="payType2">카카오페이</label>
			</div>
';
	if($CI->session->userdata['auth_lv']>=4)
	{
		$data = $data.'<div class="pay_radio">
					<input type="radio" id="payType6" item="ifream_form_point" name="methodtype" value="POINT">
					<label for="payType6">적립금 구매</label>
				</div>';
	}
	$data = $data.'
			</div>
		</div>
	</section>
	';
	echo $data;
}

function movie_cnt(){
	$CI = get_instance();
	$query = "SELECT COUNT(*) as cnt FROM tb_movie_maker  WHERE renderStartDate IS NOT NULL LIMIT 1";
	return $CI->db->query($query,false)->row()->cnt;
}
