<?
$time = time();
$offerPeriod = "";
$offerPeriod = date("Ymd") . "-" . date("Ymd", strtotime("+30 Day", $time));
//판매 후 30일 제품 보장
$vbank_date = date("Ymd", strtotime("+1 Week", $time));
//무통장 입금 결제일은 오늘 부터 1주일

$payViewType = "popup";
//overlay popup  : 모바일은 new
if ($this -> agent -> is_mobile())	$payViewType = "new";

$mail_id = "";
$mail_domain = "";
$readonly = "";
$disabled = "";
$display = "";
$is_login = "F";
if ($this -> session -> userdata['email'] != '') {
	$mail = explode('@', $this -> session -> userdata['email']);
	$mail_id = $mail[0];
	$mail_domain = $mail[1];
	$readonly = "readonly";
	$disabled = "disabled";
	$display = "display: none";
	$is_login = "T";
}

$use_point = use_point(); //사용자의 포인트 가져옴
?>
<?php
# 테스트 URL
$pp_url = PP_URL;
$recv_mail = PP_RECV_MAIL;
# 상용 URL
// $pp_url = "https://www.paypal.com/cgi-bin/webscr";
// $recv_mail = "info@xxxxxx.com";
$exchange = exchange("USD");
?>			
<form action="<?=$pp_url?>" method="post" id="paypal_pay">
	
	
	<table class="form-table guest-info" summary="주문자 이름, 연락처(휴대폰), 이메일, 비밀번호 입력필드 제공" style="width:100%">
		<colgroup>
			<col style="width: 110px;">
			<col style="width: 338px;">
			<col style="width: 110px;">
			<col style="width: 339px;">
		</colgroup>
		<tbody>
			<tr class="">
				<th scope="row">이름[영문]</th>
				<td colspan="3"><input type="text" name="buyername" id="p_buyername" /></td>
			</tr>
			<tr>
					<th scope="row">이메일</th>
					<td colspan="3" class="email"><!--
					<label for="email1" class="screen-reader-text">이메일 아이디</label>
					-->
					<input type="text" id="email1" class="email-id styled-input" value="<?=$mail_id ?>" <?=$readonly?>>
					<span>@</span><!--
					<label for="email2" class="screen-reader-text">이메일 도메인</label>
					-->
					<input type="text" id="email2" class="email-domain styled-input" value="<?=$mail_domain ?>" <?=$readonly?>>
					<span class="styled-select-box">
						<select class="select-email styled-select" id="emails" onchange="email_select()" style="z-index: 10; opacity: 1;" <?=$disabled?>>
							<option>선택하세요</option>
							<option>chol.com</option>
							<option>dreamwiz.com</option>
							<option>empal.com</option>
							<option>freechal.com</option>
							<option>gmail.com</option>
							<option>hanafos.com</option>
							<option>hanmail.net</option>
							<option>hanmir.com</option>
							<option>hotmail.com</option>
							<option>korea.com</option>
							<option>nate.com</option>
							<option>naver.com</option>
							<option>netian.com</option>
							<option>paran.com</option>
							<option>sayclub.com</option>
							<option>yahoo.co.kr</option>
							<option>yahoo.com</option>
							<option>직접입력</option>
						</select> </span><!-- .styled-select-box --></td>
				</tr>
			<tr class="">
				<th scope="row">상품명</th>
				<td colspan="3"><?=$product['0']['name'] ?></td>
			</tr>
			<tr class="">
				<th scope="row">결재가격</th>
				<td colspan="3">$ <?=round(($total_price/$exchange),2);?></td>
			</tr>			
		</tbody>
	</table>

	
	
	<input type="hidden" name="cmd" value="_xclick">
	<input type="hidden" name="business" value="<?=$recv_mail?>">
	<input type="hidden" name="item_number" value="<?=$product['0']['id'] ?>"><br />
	<input type="hidden" name="item_name" value="<?=$product['0']['name'] ?>">
	<input type="hidden" name="amount" value="<?=round(($total_price/$exchange),2);?>"><br />
	<input type="hidden" name="charset" value="UTF-8">
	<input type="hidden" name="currency_code" value="USD">
	
	<input type="hidden" name="email" id="buyeremail" />
	<!-- input type="image" name="submit" border="0" src="https://www.paypalobjects.com/en_US/i/btn/btn_buynow_LG.gif" alt="PayPal - The safer, easier way to pay online" -->
</form>