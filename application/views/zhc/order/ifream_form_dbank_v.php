<?
$email = "";
$mail_id = "";
$mail_domain = "";
$readonly = "";
$disabled = "";
if ($this -> session -> userdata['email']) {
	$mail_exp = explode('@', $this -> session -> userdata['email']);
	$mail_id = $mail_exp[0];
	$mail_domain = $mail_exp[1];
	$email = $this -> session -> userdata['email'];
	$readonly = "readonly";
	$disabled = "disabled";
}


?>
<form class="pay_post" action="/order/ifream_nbank_insert" method="post">
	<input type="hidden" name="email" id="email" value="<?=$email ?>" />
	
	<table class="form-table guest-info" summary="주문자 이름, 연락처(휴대폰), 이메일, 비밀번호 입력필드 제공" style="width:100%">		
			<colgroup>
				<col style="width: 110px;">
				<col style="width: 338px;">
				<col style="width: 110px;">
				<col style="width: 339px;">
			</colgroup>
			<tbody>
				<tr class="">
					<th scope="row">입금은행</th>
					<td colspan="3">국민은행</td>
				</tr>
				<tr class="">
					<th scope="row">통장 번호</th>
					<td colspan="3"><?=BANK_NUM ?></td>					
				</tr>
				<tr class="">
					<th scope="row">입금주</th>
					<td colspan="3">주식회사 위드비디오</td>										
				</tr>
				
				<tr class="">
					<th scope="row">주문자 이름</th>
					<td colspan="3">
					<input name="username" id="username" class="styled-input" type="text" value="">
					<span class="guide">(성과 이름을 붙여 주세요)</span></td>
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
						</select> </span><!-- .styled-select-box --> <span class="guide">(회원은 변경 하실 수 없습니다.)</span></td>
				</tr>
				<? if($this->session->userdata['auth_lv'] < 4){ ?>
				<tr class="first">
					<th scope="row">비밀번호</th>
					<td colspan="3">
					<input id="merchantData1" class="styled-input" type="password" value="" maxlength="8">
					<span class="guide">(4~8자로 입력해주세요)</span><em>* 주문 및 무비관리를 위해 필요하므로 반드시 기억해주세요</em></td>
				</tr>
				<tr class="first">
					<th scope="row">비밀번호 확인</th>
					<td colspan="3">
					<input type="password" id="merchantData2" class="styled-input" value="" maxlength="8">
					<span class="guide">(한번 더 입력해주세요)</span></td>
				</tr>
				<? } ?>
				<tr class="first">
					<th scope="row">결재하실 은행</th>
					<td colspan="3"><?=bank_select('pay_bank_code') ?>		
					<span class="guide"></span></td>
				</tr>
			</tbody>
		</table>	
</form>