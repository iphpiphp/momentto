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


$inicis = "이니시스";
$is_mobile = "";
if ($this -> agent -> is_mobile())$is_mobile = "M";
if ($this -> agent -> is_mobile())$inicis = "이니시스";	

?>

	<script language="javascript" type="text/javascript" src="https://stdpay.inicis.com/stdjs/INIStdPay.js" charset="UTF-8"></script>

	<div class="ord-ordpaper-section">


		<input type="hidden" id="hide_password" value="" />
		<input type="hidden" id="hide_passwordre" value="" />
		<input type="hidden" id="is_login" value="<?=$is_login?>" />

		<form name="inicis_pay" id="inicis_pay" method="post" action="/order/ajax_minicis_init">
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


			<?=order_section_pay_type()?>

				<section>
					<h3 class="h-frm color_blue2">주문자 정보</h3>
					<div class="pa16 bg_wh">
						<div class="form-group">
							<label class="col-sm-2 control-label color_blue2">이름</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" name="buyername" id="buyername" placeholder="이름">
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label color_blue2">휴대폰번호</label>
							<div class="col-sm-10">
								<div class="frm_tel row">
									<div class="col-xs-4">
										<select class="form-control" id="mobile1" style="z-index: 10; opacity: 1;">
											<option>선택</option>
											<option>010</option>
											<option>011</option>
											<option>016</option>
											<option>018</option>
											<option>019</option>
										</select>
									</div>
									<div class="col-xs-4">
										<input type="text" class="form-control" maxlength="4" id="mobile2">
									</div>
									<div class="col-xs-4">
										<input type="text" class="form-control" maxlength="4" id="mobile3">
									</div>
								</div>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label color_blue2">이메일 *</label>
							<div class="col-sm-10">
								<input type="text" id="email1" class="form-control" value="<?=$mail_id?>"> <span>@</span>
								<input type="text" id="email2" class="form-control" value="<?=$mail_domain?>">
								<span class="styled-select-box">
									<select class="form-control select-email styled-select" id="emails" onchange="email_select()" style="z-index: 10; opacity: 1;" <?=$disabled?>>
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
									</select>
								</span>
							</div>
						</div>
						<? if($is_login == "F"){ ?>
						<div class="form-group">
							<label class="col-sm-2 control-label color_blue2">패스워드</label>
							<div class="col-sm-10">
								<input type="password"  id="password" name="password" class="form-control">
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label color_blue2">패스워드 확인</label>
							<div class="col-sm-10">
								<input type="password"  id="password_re" name="password_re" class="form-control">
							</div>
						</div>
						<? } ?>

						<div class="form-group">
							<div class="pull-right fs13 color_grey">
								보유 적립금 : <span class="color_red"><span class="guide" id="use_point"><?=number_format($use_point)?></span></span>
							</div>
							<label class="col-sm-2 control-label color_blue2">적립금</label>
							<div class="col-sm-10">
								<input type="text"  id="point" name="point" class="form-control">
							</div>
						</div>
					</div>
				</section>
		</form>
	</div>

	<script>
		$(document).ready(function() {

			$("#point").keyup(function() {

				var point = $("#point").val();
				var use_point = <?=$use_point?>;
				var total_price = <?=$total_price?>;
				var tempPrice = 0;
				var tempPoint = 0;

				//alert(total_price);

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

				//alert('?');

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
		});

	</script>
	<?=order_section_pay_scritp() ?>
