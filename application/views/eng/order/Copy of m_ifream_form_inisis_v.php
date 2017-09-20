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
		<input type="hidden" name="buyertel" id="buyertel" value="">
		<input type="hidden" name="price" id="price" value="<?=$total_price ?>">
		<input type="hidden" name="goodsname" id="goodsname" value="<?=$product['0']['name'] ?>">
		<input type="hidden" name="popupUrl" id="popupUrl" value="<?=$inicis_popupUrl ?>">
		<input type="hidden" name="closeUrl" id="closeUrl" value="<?=$inicis_closeUrl ?>">

		<input type="hidden" name="payViewType" id="payViewType" value="new">
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
		
		<!-- div class="rounding-outline m_inicis" style="padding: 20 20 20 20;">
			<p>결제방식</p>
			
			<div class="pay_left_info_block">
				<div class="pay_radio">
					<input type="radio" id="methodtype2" value="DirectBank" name="methodtype">
						<label for="methodtype2">실시간계좌이체</label>
				</div>
				
				<div class="pay_radio">
					<input type="radio" id="methodtype3" value="Vbank" name="methodtype">
						<label for="methodtype3">무통장입금(가상계좌)</label>
				</div>				
				
			</div>
			<div class="pay_right_info_block">
				<div class="pay_radio">
					<input type="radio" id="methodtype1" value="Card" name="methodtype" checked="checked">
						<label for="methodtype1">신용카드</label>
				</div>
			</div>
		</div -->
		<div class="rounding-outline ">
			<p>결제방식</p>
			
			<div class="pay_left_info_block">
				<div class="pay_radio">
					<input type="radio" id="methodtype2" value="DirectBank" name="methodtype">
						<label for="methodtype2">실시간계좌이체</label>
				</div>
				
				<div class="pay_radio">
					<input type="radio" id="methodtype3" value="Vbank" name="methodtype">
						<label for="methodtype3">무통장입금(가상계좌)</label>
				</div>				
				
			</div>
			<div class="pay_right_info_block">
				<div class="pay_radio">
					<input type="radio" id="methodtype1" value="Card" name="methodtype" checked="checked">
						<label for="methodtype1">신용카드</label>
				</div>
			</div>
			
			<p>주문자이름 <span>(성과이름을 붙여주세요)</span></p>
			<div class="form-group">
				<div class="form-group">
						<input name="buyername" id="buyername" class="styled-input form-control" type="text" value=""  placeholder="이름">
				</div>
			</div>
			
			<p>휴대폰 번호</p>
			
				<div class="form-group">
						<div class="selectbox">
							<select class="styled-select phone-hd" id="mobile1" style="z-index: 10; opacity: 1;">
								<option>선택</option>
								<option>010</option>
								<option>011</option>
								<option>016</option>
								<option>018</option>
								<option>019</option>
							</select>
							<span>-</span>
							<input type="text" id="mobile2" class="form-control" maxlength="4">	
							<span>-</span>					
							<input type="text" id="mobile3" class="form-control" maxlength="4">
						</div>
				</div>
			
				
			<p>이메일</p>
			<div class="form-group">
					<div class="select_email">						
						<input type="text" id="email1" class="form-control" value="<?=$mail_id ?>" <?=$readonly?>> <span>@</span> 									
						<input type="text" id="email2" class="form-control" value="<?=$mail_domain ?>" <?=$readonly?>>
					</div>
			</div>
			
			<div style="<?=$display?>">
			<p>패스워드</p>
			<div class="form-group">
					
						<input id="password" class="form-control" type="password"  value="" maxlength="8" required="required">
					
			</div>
			</div>
			
			<div style="<?=$display?>">
			<p>패스워드 확인</p>
			<div class="form-group">
					
						<input type="password" id="password_re" class="form-control" value="" maxlength="8" required="required">
					
			</div>
			</div>
			
			
			
			<p>적립금 </p>
			<div class="form-group">
				<div class="form-group">
						<input name="point" id="point" class="form-control" type="text" value="" >
				</div>
			</div>
			<p>포인트 </p>
			<div class="form-group">
				<div class="form-group">
						<div class="select_point">
							<span class="guide" id="use_point"><?=number_format($use_point)?></span>
						</div>
				</div>
			</div>
		</div>
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