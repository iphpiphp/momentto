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

<input type="hidden" id="is_login" value="<?=$is_login?>" />

<div class="ord-ordpaper-section">
	
	
	<form name="mobileweb_form" id="inicis_pay" method="post" accept-charset="euc-kr">		
		<!--************************************************************************************ 
		안심클릭, 가상계좌(채번), 휴대폰, 문화상품권, 해피머니 사용시 필수 항목 - 인증결과를 해당 url로 post함, 즉 이 URL이 화면상에 보여지게 됨
		************************************************************************************-->
		<input type="hidden" name="P_NEXT_URL" value="<?=BASE_URL?>/order/m_inicis_next">
		 
	
		<!--************************************************************************************ 
		ISP, 가상계좌(입금), 계좌이체, kpay, 삼성월렛 필수항목 - 이 URL로 결제결과 정보가 리턴됨 -- 통신 값 리턴 받음
		************************************************************************************-->
		<input type="hidden" name="P_NOTI_URL" value="<?=BASE_URL?>/order/m_inicis_noti"> 
		
		<!--************************************************************************************ 
		ISP 필수항목 - ISP, 계좌이체, 삼성월렛, kpay 동작이 완료된 후 이 URL이 화면상에 보여짐 -- 처리 이후 자동으로 호출 되는 곳
		************************************************************************************-->
		<input type="hidden" name="P_RETURN_URL" value="<?=BASE_URL?>/order/m_inicis_return"> 
		
		<input type="hidden" name="P_MID" value="thedays000">
		<input type="hidden" name="P_GOODS" value="M_<?=$product['0']['name'] ?>"> <!--상품명 -->
		<input type="hidden" name="P_AMT" id="price" value="<?=$total_price ?>"> <!--가격 -->
		
		<input type="hidden" name="P_EMAIL" id="p_email" 	value="">
		<input type="hidden" name="P_MOBILE" id="p_mobile" 	value="<?=$this->session->userdata('mobile')?>">
		
		<!-- P_OID 상점주문번호상점 주문번호는 최대 40 BYTE 길이입니다.-->
		<input type="hidden" name="P_OID" id="p_oid" value="">
		<!--P_HPP_METHOD : 컨텐츠 구분		휴대폰 결제시 필수	계약된 정보에 따라 입력 필요 1:컨텐츠, 2:실물  -->
		<input type="hidden" name="P_HPP_METHOD" value="1"> 
		
		<!-- 기타주문필드 -->
		<input type="hidden" name="P_NOTI" value="모바일 페이지에서 결제">
		<!-- 리턴 파라메터 -->
		<input type="hidden" name="P_RESERVED" value="twotrs_isp=Y&block_isp=Y&twotrs_isp_noti=N">
		
		<div class="rounding-outline ">
			<p>결제방식</p>
			
			<div class="pay_left_info_block">
				<div class="pay_radio">
					<input type="radio" id="methodtype2" value="BANK" name="P_GOPAYMETHOD">
						<label for="methodtype2">실시간계좌이체</label>
				</div>
				
				<div class="pay_radio">
					<input type="radio" id="methodtype3" value="VBANK" name="P_GOPAYMETHOD">
						<label for="methodtype3">무통장입금</label>
				</div>				
				
			</div>
			<div class="pay_right_info_block">
				<div class="pay_radio">
					<input type="radio" id="methodtype1" value="CARD" name="P_GOPAYMETHOD" checked="checked">
						<label for="methodtype1">신용카드</label>
				</div>
				<div class="pay_radio">
					<input type="radio" id="methodtype4" value="HPP" name="P_GOPAYMETHOD" checked="checked">
						<label for="methodtype4">휴대폰</label>
				</div>
			</div>
			
			<p>주문자이름 <span>(성과이름을 붙여주세요)</span></p>
			<div class="form-group">
				<div class="form-group">
						<input name="P_UNAME" id="buyername" class="styled-input form-control" type="text" value="<?=$this->session->userdata['username']?>"  placeholder="이름">
				</div>
			</div>
			
			
			<div style="<?=$display?>">
				<div class="form-group">
					<p>휴대폰 번호</p>
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
			<p>보유 적립금 </p>
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
	on_load();
	

		
		
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
	
	function on_load() { 
		//alert();
		myform = document.mobileweb_form;
		//alert(myform); 
		/**************************************************************************** 
		OID(상점주문번호)를 랜덤하게 생성시키는 루틴
		상점에서 각 거래건마다 부여하는 고유의 주문번호가 있다면 이 루틴은 필요없고, 
		해당 값을 P_OID에 세팅해서 사용하면 된다.
		****************************************************************************/ 
		
		curr_date = new Date(); 
		year = curr_date.getYear(); 
		month = curr_date.getMonth(); 
		day = curr_date.getDay(); 
		hours = curr_date.getHours(); 
		mins = curr_date.getMinutes(); 
		secs = curr_date.getSeconds(); 
		myform.P_OID.value = year.toString() + month.toString() + day.toString() + hours.toString() + mins.toString() + secs.toString();
		//alert(myform.P_OID.value);
	} 


	//**
	
});
	 
</script>