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


	<form name="mobileweb_form" id="inicis_pay" method="post" accept-charset="euc-kr" class="form-horizontal bg_f0">


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
		<input type="hidden" name="P_GOODS" value="M_<?=$product['0']['name'] ?>">
		<!--상품명 -->
		<input type="hidden" name="P_AMT" id="price" value="<?=$total_price ?>">
		<!--가격 -->

		<input type="hidden" name="P_EMAIL" id="p_email" value="">
		<input type="hidden" name="P_MOBILE" id="p_mobile" value="<?=$this->session->userdata('mobile')?>">

		<!-- P_OID 상점주문번호상점 주문번호는 최대 40 BYTE 길이입니다.-->
		<input type="hidden" name="P_OID" id="p_oid" value="">
		<!--P_HPP_METHOD : 컨텐츠 구분		휴대폰 결제시 필수	계약된 정보에 따라 입력 필요 1:컨텐츠, 2:실물  -->
		<input type="hidden" name="P_HPP_METHOD" value="1">

		<!-- 기타주문필드 -->
		<input type="hidden" name="P_NOTI" value="모바일 페이지에서 결제">
		<!-- 리턴 파라메터 -->
		<input type="hidden" name="P_RESERVED" value="twotrs_isp=Y&block_isp=Y&twotrs_isp_noti=N">




		<section>
			<h3 class="h-frm color_blue2">결제수단</h3>
			<div class="pa16 bg_wh">
				<div class="row radio">
					<label class="col-xs-6 pb5">
						<input type="radio" id="methodtype1" value="CARD" name="P_GOPAYMETHOD" item="ifream_form_inisis" data-id="Card"> 신용카드
					</label>
					<label class="col-xs-6 pb5">
						<input type="radio" id="payType4" item="ifream_form_paypal" name="P_GOPAYMETHOD" value="PAYPAL"> PayPal
					</label>
					<!-- label class="col-xs-6 pb5">
						<input type="radio" id="methodtype2" value="BANK" name="P_GOPAYMETHOD" item="ifream_form_inisis" data-id="DirectBank"> 실시간 계좌이체
					</label -->
					<label class="col-xs-6 pb5">
						<input type="radio" id="payType2" style="z-index:999" item="ifream_form_cacao" name="P_GOPAYMETHOD" value="CACAO"> 카카오페이
					</label>
					<label class="col-xs-6 pb5">
						<input type="radio" id="methodtype4" value="HPP" name="P_GOPAYMETHOD" item="ifream_form_inisis" data-id="Hpp"> 휴대폰
					</label>
					<? if($this->session->userdata['auth_lv']>=4)	{ ?>
						<label class="col-xs-6 pb5">
							<input type="radio" id="payType6" item="ifream_form_point" name="P_GOPAYMETHOD" value="POINT"> 적립금구매
						</label>
						<?}?>
				</div>
			</div>
		</section>

		<section>
			<h3 class="h-frm color_blue2">주문자 정보</h3>
			<div class="pa16 bg_wh">
				<div class="form-group">
					<label class="col-sm-2 control-label color_blue2">주문자이름</label>
					<div class="col-sm-10">
						<input name="P_UNAME" id="buyername" class="form-control" type="text" value="<?=$this->session->userdata['username']?>" placeholder="이름">
					</div>
				</div>


				<div style="<?=$display?>">
					<div class="form-group">
						<label class="col-sm-2 control-label color_blue2">휴대폰번호</label>
						<div class="col-sm-10">
							<div class="frm_tel row">
								<div class="col-xs-4">
									<select class="styled-select phone-hd" id="mobile1" style="z-index: 10; opacity: 1;">
										<option>선택</option>
										<option>010</option>
										<option>011</option>
										<option>016</option>
										<option>018</option>
										<option>017</option>
										<option>019</option>
									</select>
								</div>
								<div class="col-xs-4">
									<input type="text" id="mobile2" class="form-control" maxlength="4">
								</div>
								<div class="col-xs-4">
									<input type="text" id="mobile3" class="form-control" maxlength="4">
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label color_blue2">이메일 *</label>
					<div class="col-sm-10">
						<input type="text" id="email1" class="form-control" value="<?=$mail_id ?>" <?=$readonly?>> <span>@</span>
						<input type="text" id="email2" class="form-control" value="<?=$mail_domain ?>" <?=$readonly?>>
					</div>
				</div>

				<div style="<?=$display?>">
					<div class="form-group">
						<label class="col-sm-2 control-label color_blue2">패스워드</label>
						<div class="col-sm-10">
							<input id="password" class="form-control" type="password" value="" maxlength="8" required="required">
						</div>
					</div>
				</div>
				<div style="<?=$display?>">
					<div class="form-group">
						<label class="col-sm-2 control-label color_blue2">패스워드 확인</label>
						<div class="col-sm-10">
							<input type="password" id="password_re" class="form-control" value="" maxlength="8" required="required">
						</div>
					</div>
				</div>

				<div class="form-group">
					<div class="pull-right fs13 color_grey">
						보유 적립금 :<span class="guide color_red" id="use_point"><?=number_format($use_point)?></span>
					</div>
					<label class="col-sm-2 control-label color_blue2">적립금</label>
					<div class="col-sm-10">
						<input name="point" id="point" class="form-control" type="text" value="">
					</div>
				</div>
			</div>
		</section>
	</form>



	<script>
		$(document).ready(function() {
			on_load();
			onChangePayType();
			$("#point").keyup(function() {

				var point = $("#point").val();
				var use_point = <?=$use_point?>;
				var total_price = <?=$total_price?>;
				var tempPrice = 0;
				var tempPoint = 0;

				if (point) {
					if (is_numeric(point) == false) {
						alert("숫자만 입력 하실 수 있습니다.");
						$("#point").val(0);
						$("#point").focus();
						return false;
					}
				} else {
					$("#point").val(0);
					return false;
				}

				point = parseInt(point);
				use_point = parseInt(use_point);

				tempPoint = use_point - point;
				if (tempPoint <= 0) {
					alert("보유하신 적립금이 더 적습니다.");
					$("#point").val(0);
					$("#point").focus();
				} else {
					tempPrice = total_price - point;

					if (tempPrice < 0) {
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




			//**

			$('input:radio[name=P_GOPAYMETHOD]').change(function() {
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
					if ($(this).val() == "CARD" || $(this).val() == "BANK" || $(this).val() == "HPP") {
						$("#is").load("/order/" + $(this).attr("item"));
					}
				}
				$("#gopaymethod").val($(this).val());
			});
			$('input:radio[name=P_GOPAYMETHOD]:input[value=' + $(".payType").val() + '] ').attr("checked", true);

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


		function onChangePayType() {
			var oldPayType = $(".payType").val();
			if (oldPayType == "Card") $(".payType").val("CARD");
			if (oldPayType == "DirectBank") $(".payType").val("BANK");
			if (oldPayType == "Hpp") $(".payType").val("HPP");
		}

	</script>
