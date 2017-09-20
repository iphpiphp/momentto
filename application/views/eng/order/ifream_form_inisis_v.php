<?
$time = time();
$offerPeriod = "";
$offerPeriod = date("Ymd") . "-" . date("Ymd", strtotime("+30 Day", $time));
//판매 후 30일 제품 보장
$vbank_date = date("Ymd", strtotime("+1 Week", $time));
//무통장 입금 결제일은 오늘 부터 1주일

$payViewType = "overlay";
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

<script language="javascript" type="text/javascript" src="https://stdpay.inicis.com/stdjs/INIStdPay.js" charset="UTF-8"></script>
<div class="ord-ordpaper-section">
	
	
	<input type="hidden" id="hide_password" value="" />
	<input type="hidden" id="hide_passwordre" value="" />	
	<input type="hidden" id="is_login" value="<?=$is_login?>" />
	 
	<form name="inicis_pay" id="inicis_pay" method="post">
		<input type="hidden" name="version" value="1.0">
		<input type="hidden" name="mid" id="mid" value="<?=$mid ?>">
		<input type="hidden" name="oid" id="oid" value="<?=$oid ?>">
		<input type="hidden" name="timestamp" id="timestamp" value="<?=$timestamp ?>">
		<input type="hidden" name="currency" value="WON">
		<input type="hidden" name="returnUrl" value="<?=$inicis_returnUrl ?>">
		<input type="hidden" name="buyeremail" id="buyeremail" value="">
		<input type="hidden" name="buyertel" id="buyertel" value="01000001111">
		<input type="hidden" name="price" id="price" value="<?=$total_price ?>">
		<input type="hidden" name="goodsname" id="goodsname" value="<?=$product['0']['name'] ?>">
		<input type="hidden" name="popupUrl" id="popupUrl" value="<?=$inicis_popupUrl ?>">
		<input type="hidden" name="closeUrl" id="closeUrl" value="<?=$inicis_closeUrl ?>">

		<input type="hidden" name="payViewType" id="payViewType" value="<?=$payViewType ?>">
		<!-- TODO : overlay 형식으로 동작안함. 아마도 jquery충돌문제일듯. -->
		<input type="hidden" name="mKey" id="mKey" value="<?=$mkey ?>">
		<input type="hidden" name="signature" id="signature" value="<?=$signature ?>">
		<input type="hidden" name="languageView" id="languageView" value="ko">
		<!-- 필수값 -->
		<input type="hidden" name="charset" id="charset">
		<input type="hidden" name="gopaymethod" id="gopaymethod" value="Card">
		<!-- 결재 선택 -->
		<input type="hidden" name="acceptmethod" id="acceptmethod" value="HPP(1):vbank(<?=$vbank_date ?>):below1000">
		<!-- 추가 옵션 선택 -->
		<!-- 필수값으로 수정되었음. 콘텐트(1), 실물(2) -->
		<input type="hidden" name="nointerest" id="nointerest">
		<input type="hidden" name="quotabase" id="quotabase">
		<input type="hidden" name="vbankRegNo" id="vbankRegNo">
		<input type="hidden" name="offerPeriod" id="offerPeriod" value="<?=$offerPeriod ?>">
		<input type="hidden" name="merchantData" id="merchantData">

		<table class=" form-table guest-info" summary="주문자 이름, 연락처(휴대폰), 이메일, 비밀번호 입력필드 제공" style="width:100%">
			<colgroup>
				<col style="width: 110px;">
				<col style="width: 338px;">
				<col style="width: 110px;">
				<col style="width: 339px;">
			</colgroup>
			<tbody>
				<tr class="">
					<th scope="row">결재방식</th>
					<td colspan="3">
					<div class="rounding-outline ord-ordpaper-section">
			
						<input type="radio" id="methodtype1" value="Card" name="methodtype" checked="checked">
						<label for="methodtype1">신용카드</label>
			
						<input type="radio" id="methodtype2" value="DirectBank" name="methodtype">
						<label for="methodtype2">실시간계좌이체</label>
			
						<input type="radio" id="methodtype3" value="Vbank" name="methodtype">
						<label for="methodtype3">무통장입금(가상계좌)</label>
						
						<input type="radio" id="methodtype4" value="Hpp" name="methodtype">
						<label for="methodtype4">휴대폰</label>
			
					</div>					
				</tr>
				
				<tr class="">
					<th scope="row">주문자 이름</th>
					<td colspan="3">
					<input name="buyername" id="buyername" class="styled-input" type="text" value="">
					<span class="guide">(성과 이름을 붙여 주세요)</span></td>
				</tr>
				<tr>
					<th scope="row">휴대폰번호</th>
					<td class="phone"><span class="styled-select-box">
						<select class="styled-select phone-hd" id="mobile1" style="z-index: 10; opacity: 1;">
							<option>선택</option>
							<option>010</option>
							<option>011</option>
							<option>016</option>
							<option>018</option>
							<option>019</option>
						</select> </span><span>-</span><!--
					<label for="mobile2" class="screen-reader-text">휴대폰번호 앞자리</label>
					-->
					<input type="text" id="mobile2" class="styled-input" maxlength="4">
					<span>-</span><!--
					<label for="mobile3" class="screen-reader-text">휴대폰번호 뒷자리</label>
					-->
					<input type="text" id="mobile3" class="styled-input" maxlength="4">
					</td>
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
				<tr class="first" style="<?=$display?>">
					<th scope="row">비밀번호</th>
					<td colspan="3">
					<input id="password" class="styled-input" type="password"  value="" maxlength="8" required="required">
					<span class="guide">(4~8자로 입력해주세요)</span><em>* 주문 및 무비관리를 위해 필요하므로 반드시 기억해주세요</em></td>
				</tr>
				<tr class="first" style="<?=$display?>">
					<th scope="row">비밀번호 확인</th>
					<td colspan="3">
					<input type="password" id="password_re" class="styled-input" value="" maxlength="8" required="required">
					<span class="guide">(한번 더 입력해주세요)</span></td>
				</tr>
				<tr class="first" >
					<th scope="row">적립금</th>
					<td><input name="point" id="point" class="styled-input" type="text" value="" ></td>
					<th>적립금</th>
					<td>					
						<span class="guide" id="use_point"><?=number_format($use_point)?></span>
					</td>
				</tr>
			</tbody>
		</table>
	</form>
</div>

<script>
$(document).ready(function () {
	
	$( "#point" ).keyup(function() {
		
		var point = $( "#point" ).val();
		var use_point = <?=$use_point?>;
		var total_price = <?=$total_price?>;
		var tempPrice = 0;
		var tempPoint = 0;
		
		if(point){
			if(is_numeric(point) == false) {
				alert("숫자만 입력 하실 수 있습니다.");
				$("#point").val(0);
				$("#point").focus();
				return false;
			}
		}else{
			$("#point").val(0);
			return false;
		}
		
		point = parseInt(point);
		use_point = parseInt(use_point);		
		
		tempPoint = use_point - point;
		if(tempPoint <= 0) {
			alert("보유하신 적립금이 더 적습니다.");
			$("#point").val(0);
			$("#point").focus();
		}else{
			tempPrice = total_price - point;
			
			if(tempPrice < 0){
				//원복
				alert("주문 가격은 0원 미만이 될 수 없습니다.");
				$("#point").val(0);
				$("#point").focus();
				tempPrice = total_price;
				tempPoint = use_point;
			}
			
			$("#use_point").text(number_format(tempPoint));
			$("#showLastPrice").text(number_format(tempPrice));
		}		
	});
	
	$('input:radio[name=methodtype]').change(function() {
		$("#gopaymethod").val($(this).val());
	});
});
	 
</script>