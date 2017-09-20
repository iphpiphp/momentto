<?=order_section_pay_type()?>
	<?
	$prType = "WPM";
	$channelType = 4;
	if($this->agent->is_mobile()){
		$prType = "MPM";
		$channelType = 2;
	}
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

		<script src="<?php echo ($CnsPayDealRequestUrl) ?>/dlp/scripts/lib/easyXDM.min.js" type="text/javascript"></script>
		<script src="<?php echo ($CnsPayDealRequestUrl) ?>/dlp/scripts/lib/json3.min.js" type="text/javascript"></script>
		<script type="text/javascript" src="<?php echo ($CNSPAY_WEB_SERVER_URL) ?>/js/dlp/client/kakaopayDlpConf.js" charset="utf-8"></script>
		<script type="text/javascript" src="<?php echo ($CNSPAY_WEB_SERVER_URL) ?>/js/dlp/client/kakaopayDlp.min.js" charset="utf-8"></script>

		<link href="https://pg.cnspay.co.kr:443/dlp/css/kakaopayDlp.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">
			function cnspay() {
				// TO-DO : 가맹점에서 해줘야할 부분(TXN_ID)과 KaKaoPay DLP 호출 API
				// 결과코드가 00(정상처리되었습니다.)
				if(document.payForm.resultCode.value == '00') {
					// TO-DO : 가맹점에서 해줘야할 부분(TXN_ID)과 KaKaoPay DLP 호출 API
					kakaopayDlp.setTxnId(document.payForm.txnId.value);
					<? if($this->agent->is_mobile()){ //모바일 여부?>
						kakaopayDlp.setChannelType('WPM', 'TMS'); // PC결제
					<? } else { ?>
						kakaopayDlp.setChannelType('MPM', 'WEB'); // 모바일 웹(브라우저)결제
						kakaopayDlp.addRequestParams({ MOBILE_NUM : ''}); // 초기값 세팅
					<? } ?>

				kakaopayDlp.callDlp('kakaopay_layer', document.payForm, submitFunc);
				} else {
					alert('[RESULT_CODE] : ' + document.payForm.resultCode.value + '\n[RESULT_MSG] : ' + document.payForm.resultMsg.value);
				}
			}

			function getTxnId() {
				// form에 iframe 주소 세팅
				document.payForm.target = "txnIdGetterFrame";
				document.payForm.action = "<?=KAKAO_URL?>/kakao_txnId";
				//document.payForm.action = "/kakao/getTxnId.php";
				document.payForm.acceptCharset = "utf-8";
			  if (document.payForm.canHaveHTML) { // detect IE
				  document.charset = payForm.acceptCharset;
			  }

				// post로 iframe 페이지 호출
				document.payForm.submit();
				// payForm의 타겟, action을 수정한다

				document.payForm.target = "";
				document.payForm.action = "<?=KAKAO_URL?>/kakaopayLiteResult";
				document.payForm.acceptCharset = "utf-8";
			  if (document.payForm.canHaveHTML) { // detect IE
				  document.charset = payForm.acceptCharset;
			  }
				// getTxnId.jsp의 onload 이벤트를 통해 cnspay() 호출
			}

			var submitFunc = function cnspaySubmit(data){

				if(data.RESULT_CODE === '00') {
					// 부인방지토큰은 기본적으로 name="NON_REP_TOKEN"인 input박스에 들어가게 되며, 아래와 같은 방법으로 꺼내서 쓸 수도 있다.
					// 해당값은 가군인증을 위해 돌려주는 값으로서, 가맹점과 카카오페이 양측에서 저장하고 있어야 한다.
					// var temp = data.NON_REP_TOKEN;
					document.payForm.submit();
				} else if(data.RESLUT_CODE === 'KKP_SER_002') {
					// X버튼 눌렀을때의 이벤트 처리 코드 등록
					alert('[RESULT_CODE] : ' + data.RESULT_CODE + '\n[RESULT_MSG] : ' + data.RESULT_MSG);
				} else {
					alert('[RESULT_CODE] : ' + data.RESULT_CODE + '\n[RESULT_MSG] : ' + data.RESULT_MSG);
				}
			};

		</script>




		<form name="payForm" id="payForm" action="<?=KAKAO_URL?>/kakaopayLiteResult" method="post" accept-charset="">
			<section>
				<h3 class="h-frm color_blue2">Order info</h3>
				<div class="pa16 bg_wh">
					<!-- 결제 파라미터 목록 -->


					<div class="form-group">
						<label class="col-sm-2 control-label color_blue2">Email *</label>
						<div class="col-sm-10">
							<input type="text" id="email1" class="form-control" value="<?=$mail_id ?>" <?=$readonly?>> <span>@</span>
							<input type="text" id="email2" class="form-control" value="<?=$mail_domain ?>" <?=$readonly?>>
							<input name="BuyerEmail" id="email" type="hidden" value="<?=$mail_id."@".$mail_domain ?>" />
						</div>
					</div>

					<div class="form-group">
						<label class="col-sm-2 control-label color_blue2">주문자이름 <span>(성과이름을 붙여주세요)</span></label>
						<div class="col-sm-10">
							<input name="BuyerName" type="text" class="form-control" value="<?=$this->session->userdata['username']?>" placeholder="이름" />
						</div>
					</div>
					<input type="hidden" name="PayMethod" value="KAKAOPAY" />
					<input name="GoodsName" type="hidden" value="<?=$cart['product'][0]['name']?>" />
					<!-- 상품명 -->
					<input name="ServiceAmt" type="hidden" value="0" />
					<!-- 봉사료 -->
					<input name="GoodsVat" type="hidden" value="0" />
					<!-- 부가세 -->
					<input name="EncryptData" type="hidden" value="<?php echo($hash_String); ?>" readonly="readonly" />
					<input name="EdiDate" type="hidden" value="<?php echo($ediDate); ?>" readonly="readonly" />
					<input name="MID" type="hidden" value="<?php echo($MID); ?>" />
					<input name="GoodsCnt" type="hidden" value="1" readonly="readonly" style="background-color: #e2e2e2;" />
					<!-- 고정 -->
					<input name="AuthFlg" type="hidden" value="10" readonly="readonly" style="background-color: #e2e2e2;" />
					<!-- 고정 -->
					<input name="Amt" type="hidden" id="price" value="<?=$cart['total_price']; ?>" />
					<input name="SupplyAmt" type="hidden" value="<?=$cart['total_price']; ?>" />
					<!-- 공급가액 --->

					<!-- 인증 파라미터 목록 -->
					<input name="OFFER_PERIOD_FLAG" type="hidden" value="Y" />
					<input name="OFFER_PERIOD" type="hidden" value="제품표시일까지" />
					<!-- 상품제공기간 -->
					<input type="hidden" name="CERTIFIED_FLAG" value="CN" readonly="readonly" style="background-color: #e2e2e2;" />
					<!-- (*)인증구분 고정 -->
					<input type="hidden" name="currency" value="KRW" readonly="readonly" style="background-color: #e2e2e2;" />
					<!-- (*)거래통화 고정 -->
					<input type="hidden" name="merchantEncKey" value="<?php echo($merchantEncKey); ?>" />
					<!-- (*)가맹점 암호화키 -->
					<input type="hidden" name="merchantHashKey" value="<?php echo($merchantHashKey); ?>" />
					<!-- (*)가맹점 해쉬키 -->
					<input type="hidden" name="requestDealApproveUrl" value="<?php echo($CNSPAY_WEB_SERVER_URL.$msgName); ?>" />
					<input type="hidden" name="prType" value="<?=$prType?>" />
					<!-- MPM WPM -->
					<input type="hidden" name="channelType" vvaluealu="<?=$channelType?>" />
					<!--  2/ 4 -->
					<input type="hidden" name="merchantTxnNum" value="<?php echo($merchantTxnNum)?>" />
					<!-- (*)가맹점 거래번호 -->



					<!-- 인증 파라미터 중 할부결제시 사용하는 파라미터 목록 -->
					<!-- 파라미터 입력형태는 매뉴얼 참조  -->
					<!-- b>할부결제시 선택변수 목록</b><br />
			- 옳은 값들을 넣지 않으면 무이자를 사용하지 않는것으로 한다.<br />

			<b>카드코드(매뉴얼 참조)</b><br />
			- 비씨:01, 국민:02, 외환:03, 삼성:04, 신한:06, 현대:07, 롯데:08, 한미:11, 씨티:11, <br />
			NH채움(농협):12, 수협:13, 신협:13, 우리:15, 하나SK:16, 주택:18, 조흥(강원):19, <br />
			광주:21, 전북:22, 제주:23, 해외비자:25, 해외마스터:26, 해외다이너스:27, <br />
			해외AMX:28, 해외JCB:29, 해외디스커버:30, 은련:34
			<ul>
				<li>카드선택 : <input type="text" name="possiCard" value="" /> ex) 06</li>
				<li>할부개월 : <input type="text" name="fixedInt" value="" /> ex) 03</li>
				<li>최대할부개월 : <input type="text" name="maxInt" value="" /> ex) 24</li>
				<li>
				무이자 사용여부 :
				<select class="require" name="noIntYN" onchange="javascript:noIntYNonChange();">
					<option value="N">사용안함</option>
					<option value="Y">사용</option>
				</select>
				</li -->
					<!-- 결제수단코드 + 카드코드 + - + 무이자 개월 ex) CC01-02:03:05:09 -->
					<!-- li>무이자옵션 : <input type="text" name="noIntOpt" value="" /> ex) CC01-02:03:05</li>
				<li>
				카드사포인트사용여부 :
				<select name ="pointUseYn">
					<option value="N">카드사 포인트 사용안함</option>
					<option value="Y">카드사 포인트 사용</option>
				</select>
				</li>
				<li>금지카드설정 : <input type="text" name="blockCard" value=""/> ex) 01:04:11</li>
				<li>특정제한카드 BIN : <input type="text" name="blockBin" value=""/></li>
			</ul -->
					<!-- getTxnId 응답</b><br /> -->
					<input id="resultCode" type="hidden" value="" />
					<input id="resultMsg" type="hidden" value="" />
					<input id="txnId" type="hidden" value="" />
					<input id="prDt" type="hidden" value="" />

					<!-- DLP호출에 대한 응답 -->
					<input type="hidden" name="SPU" value="" />
					<input type="hidden" name="SPU_SIGN_TOKEN" value="" />
					<input type="hidden" name="MPAY_PUB" value="" />
					<input type="hidden" name="NON_REP_TOKEN" value="" />
				</div>
			</section>

		</form>

		<!-- TODO :  LayerPopup의 Target DIV 생성 -->
		<div id="kakaopay_layer" style="display: none"></div>
		<iframe name="txnIdGetterFrame" id="txnIdGetterFrame" src="" width="0" height="0" style="display: none"></iframe>
		<?=order_section_pay_scritp() ?>
