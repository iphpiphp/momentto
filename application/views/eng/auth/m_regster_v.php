<!-- #container -->
<div id="container" class="clearfix">

	<!-- 페이지 시작-->

			<!--div class="row side_page w1140">				
				<h1 class="sub_hd">SNS 회원 가입</h1>
				<div class="login_bx">
					<div class="form-group">
				
						<a href="/auth/sns_login?type=FB"><img src="/assets/img/MergedLayers3.png" /></a>
						<a href="/auth/sns_login?type=NV"><img src="/assets/img/MergedLayers1.png" /></a>
						<a href="/auth/sns_login?type=GP"><img src="/assets/img/MergedLayers2.png" /></a>						
					</div>
				</div>	
			</div -->
	
			<!-- div class="row side_page w1140" style="  ">
			<h1 class="sub_hd">회원 가입</h1>
			<div class=" login_bx">
				<form class="form-horizontal" role="form" id="register_form" method="post" action="/auth/register_chk">
					<div class="form-group">
						<div class="form-group">
						
						<div class="col-sm-8">
							<input type="password" name="register_password" id="register_name" class="form-control" id="inputPassword3" placeholder="이름">
						</div>
					</div>
						<div class="col-sm-8">
							<input type="email" name="register_email" id="register_email" class="form-control" id="inputEmail3" placeholder="이메일">
						</div>
					</div>
					
					
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
				
				
					<div class="form-group">
						
						<div class="col-sm-8">
							<input type="password" name="register_password" id="register_password" class="form-control" id="inputPassword3" placeholder="비밀번호">
						</div>
					</div>
					<div class="form-group">
						
						<div class="col-sm-8">
							<input type="password" name="register_password_rw" id="register_password_rw" class="form-control" id="inputPassword3" placeholder="비밀번호확인">
						</div>
					</div>

					<div class="form-group">
						<div class="col-sm-offset-1 col-sm-8">
							
							
							<div id="login_agree">
								<input type="checkbox" id="register_agree">
								<label for="chk" class="">정책에 동의</label>
							</div>
						</div>
					</div>

					<div class="form-group">
						<div class="col-sm-offset-1 col-sm-8">
							<button id="register_btn" class=" btn-regster">
								<a>확인</a>
							</button>
						</div>
					</div>
				</form>
			</div>
			
			
			
			
		</div -->
		<div id="order" class="row side_page w1140">
			<h1 class="sub_hd">회원 가입</h1>
			<form class="form-horizontal" role="form" id="register_form" method="post" action="/auth/register_chk">
			<input type="hidden" name="mobile" id="mobile" />
			<input type="hidden" name="register_email" id="register_email" />
		<div class="rounding-outline ">
			<p>이름</p>
			<div class="form-group">
				<div class="form-group">
						<input name="username" id="username" class="styled-input form-control" type="text" value=""  placeholder="이름">
				</div>
			</div>
			
			<p>국적</p>
			<div class="">
				<div class="">
						<div style=" float:left;"><input type="checkbox" id="crt" style="width:40px; height:40px;"></div><div style="padding-left:25px; float:left;"><label for="crt">해외거주<br>(SMS 서비스 불가능)</label></div>
				</div>
			</div>
			
						
				<div class="form-group" id="hpp">
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
			
				
			<p>이메일</p>
			<div class="form-group">
					<div class="select_email">						
						<input type="text" id="email1" class="form-control" value=""> <span>@</span> 									
						<input type="text" id="email2" class="form-control" value="">
					</div>
			</div>
			
			
			<p>패스워드</p>
			<div class="form-group">
					
						<input type="password" id="register_password" name="register_password" class="form-control"  value="" maxlength="8" required="required">
					
			</div>
			
			
			
			<p>패스워드 확인</p>
			<div class="form-group">
					
						<input type="password" id="register_password_rw" class="form-control" value="" maxlength="8" required="required">
					
			</div>
			
			
			<div class="form-group">
						<div class="col-sm-offset-1 col-sm-8">
							<div>
								<textarea style="width:100%;" rows="5">이용약관
									제1장 총칙

제1조 (목적)
본 약관은 주식회사 더데이즈 (이하 '회사'라 합니다)가 운영하는 인터넷사이트[http://www.thedays.co.kr(이하 '더데이즈 웹사이트'라 합니다)를 통하여 회사가 제공하는 전자지급결제대행서비스, 선불전자지급수단의 발행 및 관리 서비스(이하 통칭하여 “전자금융거래 서비스’라 합니다)를 이용자가 이용하는 경우, 회사와 이용자 간 전자금융거래의 법률관계를 정함에 그 목적이 있습니다.

제2조 (정의) 
① 이 약관에서 정하는 용어의 정의는 다음 각호와 같습니다. 
1. ‘전자금융거래’라 함은 회사가 전자적 장치를 통하여 전자금융서비스를 제공(이하 ‘전자금융업무’라 합니다)하고, 이용자가 회사의 종사자와 직접 대면하거나 의사소통을 하지 아니하고 자동화된 방식으로 이를 이용하는 거래를 말합니다. 
2. ‘전자지급수단’이라 함은 선불전자지급수단, 신용카드 등 전자금융거래법 제2조 제11호에서 정하는 전자적 방법에 따른 지급수단을 말합니다. 
3. ‘전자지급거래’라 함은 자금을 주는 자(이하 ‘지급인’이라 합니다)가 회사로 하여금 전자지급수단을 이용하여 자금을 받는 자(이하 ‘수취인’이라 합니다)에게 자금을 이동하게 하는 전자금융거래를 말합니다. 
4. ‘전자적 장치’ 라 함은 전자금융거래정보를 전자적 방법으로 전송하거나 처리하는데 이용되는 장치로서 현금자동지급기, 자동입출금기, 지급용단말기, 컴퓨터, 전화기 그 밖에 전자적 방법으로 정보를 전송하거나 처리하는 장치를 말합니다. 
5. ‘접근매체’라 함은 전자금융거래에 있어서 거래지시를 하거나 이용자 및 거래내용의 진실성과 정확성을 확보하기 위하여 사용되는 수단 또는 정보로서 전자식 카드 및 이에 준하는 전자적 정보(신용카드번호를 포함합니다), 전자서명법 상의 전자서명생성정보 및 인증서, 금융기관 또는 전자금융업자에 등록된 이용자번호, 이용자의 생체정보, 이상의 수단이나 정보를 사용하는데 필요한 비밀번호 등 전자금융거래법 제2조 제10호에서 정하고 있는 것을 말합니다. 
6. ‘전자금융거래서비스’또는 ‘서비스’라 함은 회사가 이용자에게 제공하는 제4조 기재의 서비스를 말합니다. 
7. ‘이용자’라 함은 제2장 내지 제4장에서 달리 정한 것을 제외하고는 본 이용약관에 동의하고 회사가 제공하는 전자금융거래서비스를 이용하는 ‘더데이즈 웹사이트’ 회원을 말합니다. 
8. '거래지시'라 함은 이용자가 전자금융거래계약에 따라 금융기관 또는 전자금융업자에게 전자금융거래의 처리를 지시하는 것을 말합니다. 
9. '오류'라 함은 이용자의 고의 또는 과실 없이 전자금융거래가 전자금융거래계약 또는 이용자의 거래지시에 따라 이행되지 아니한 경우를 말합니다. 
10. '이용자번호'란 이용자의 동일성 식별과 서비스 이용을 위하여 이용자가 설정하고 회사가 승인한 숫자와 문자의 조합을 말합니다. 
11. '비밀번호'란 이용자의 동일성 식별과 회원정보의 보호를 위하여 이용자가 설정하고 회사가 승인한 숫자와 문자의 조합을 말합니다. 
12. ‘가맹점’이란 회사와의 계약에 따라 전자지급수단에 의한 거래에 있어서 이용자에게 재화 또는 용역을 제공하는 자로서 전자금융업자가 아닌 자를 말합니다. 
② 본 조 및 본 약관 각 장의 정의조항에서 정한 것을 제외하고는 전자금융거래법 등 관련법령이 정한 바에 의합니다.

제3조 (약관의 적용범위, 명시 및 변경) 
① 본 약관은 이용자가 ‘더데이즈 웹사이트’를 통한 선불식 통신판매를 이용하는 경우에 적용됩니다. 
② 회사는 이용자가 전자금융거래를 하기 전에 본 약관을 ‘더데이즈 웹사이트’에 게시하고 이용자가 본 약관의 중요한 내용을 확인할 수 있도록 합니다. 
③ 회사는 이용자의 요청이 있는 경우 전자문서 전송(전자우편을 이용한 전송을 포함합니다), 모사전송, 우편 약관의 사본을 이용자에게 교부합니다. 
④ 회사가 본 약관을 변경하는 때에는 그 시행일 1개월 전에 변경되는 약관을 금융거래정보 입력화면(주문서), ‘더데이즈 웹사이트’에 게시하고 이용자에게 통지합니다.

제4조 ( 전자금융거래서비스의 구성 및 내용) 
① 전자금융거래서비스는 다음 각호의 서비스로 구성되며 회사는 각 서비스의 자세한 내용을 ‘더데이즈 웹사이트’에 별도 게시합니다. 
1. 전자지급결제대행서비스 
2. 결제대금예치서비스 (매매보호서비스) 
3. 선불전자지급수단발행관리서비스 
② 회사는 필요시 이용자에 사전 고지하고 서비스를 추가하거나 변경할 수 있습니다.

제5조 (거래내용의 확인) 
① 회사는 ‘더데이즈 웹사이트’의 경우 '마이페이지' 화면을 통하여 각 이용자의 거래내용(이용자의 '오류정정 요구사실 및 처리결과에 관한 사항'을 포함합니다)을 확인할 수 있도록 하며, 이용자의 거래내용 서면교부 요청이 있는 경우에는 요청을 받은 날로부터 2주 이내에 모사전송, 우편의 방법으로 거래내용에 관한 서면을 교부합니다. 
② 회사는 제1항에 따른 이용자의 거래내용 서면교부 요청을 받은 경우 전자적 장치의 운영장애, 그 밖의 사유로 거래내용을 제공할 수 없는 때에는 즉시 이용자에게 전자문서 전송(전자우편을 이용한 전송을 포함합니다)의 방법으로 그러한 사유를 알려야 하며, 전자적 장치의 운영장애 등의 사유로 거래내용을 제공할 수 없는 기간은 제1항의 거래내용에 관한 서면의 교부기간에 산입하지 아니합니다. 
③ 제1항의 대상이 되는 거래내용 중 대상기간이 5년인 것은 다음 각호와 같습니다. 
1. 거래계좌의 명칭 또는 번호 
2. 거래의 종류 및 금액 
3. 거래상대방을 나타내는 정보 
4. 거래일시 
5. 회사가 전자금융거래의 대가로 받은 수수료 
6. 이용자의 출금 동의에 관한 사항 
7. 해당 전자금융거래와 관련한 전자적 장치의 접속기록 
8. 전자금융거래의 신청 및 조건의 변경에 관한 사항 
9. 건당 거래금액이 1만원을 초과하는 전자금융거래에 관한 기록 
④ 제1항의 대상이 되는 거래내용 중 대상기간이 1년인 것은 다음 각호와 같습니다. 
1. 건당 거래금액이 1만원 이하인 소액 전자금융거래에 관한 기록 
2. 전자지급수단 이용과 관련된 거래승인에 관한 기록 
3. 이용자의 오류정정 요구사실 및 처리결과에 관한 사항 
⑤ 인터넷사이트의 이용자가 제1항에서 정한 서면교부를 요청하고자 할 경우 다음의 주소 및 전화번호로 요청할 수 있습니다. 
1. ‘더데이즈 웹사이트’ 의 경우 
주소: 서울시 강남구 역삼동 683-39번지 대명빌딩 202호 
이메일 주소: help@thedays.co.kr
전화번호: 02.562.3618

제6조 (오류의 정정 등) 
① 이용자는 전자금융거래서비스를 이용함에 있어 오류가 있음을 안 때에는 회사에 대하여 그 정정을 요구할 수 있습니다. 
② 회사는 전항의 규정에 따른 오류의 정정요구를 받은 때 또는 스스로 전자금융거래에 오류가 있음을 안 때에는 이를 즉시 조사하여 처리한 후 정정요구를 받은 날 또는 오류가 있음을 안 날부터 2주 이내에 그 결과를 문서로 이용자에게 알려 드립니다. 다만, 이용자의 주소가 분명하지 아니하거나 이용자가 요청한 경우에는 전화 또는 전자우편 등의 방법으로 알릴 수 있습니다.

제7조 (전자금융거래 기록의 생성 및 보존) 
① 회사는 이용자가 이용한 전자금융거래의 내용을 추적, 검색하거나 그 내용에 오류가 발생한 경우에 이를 확인하거나 정정할 수 있는 기록을 생성하여 보존합니다. 
② 전항의 규정에 따라 회사가 보존하여야 하는 기록의 종류 및 보존기간은 제5조 제3항, 제4항에서 정한 바에 따릅니다.

제8조 (거래지시의 철회) 
① 이용자가 전자지급거래를 한 경우, 이용자는 지급의 효력이 발생하기 전까지 본 약관 제5조 제5항 기재 담당자에게 전자문서의 전송(전자우편을 이용한 전송을 포함합니다)에 의한 방법으로 거래지시를 철회 할 수 있습니다. 각 서비스별 거래지시 철회의 효력 발생시기는 본 약관 제16조 및 제21조에서 정하는 바와 같습니다. 
② 이용자는 전자지급의 효력이 발생한 경우에 전자상거래등에서의 소비자보호에 관한 법률 등 관련 법령상 청약의 철회의 방법에 따라 결제대금을 반환 받을 수 있습니다.

제9조 (전자금융거래정보의 제공금지) 
회사는 전자금융거래서비스를 제공함에 있어서 취득한 이용자의 인적사항, 이용자의 계좌, 접근매체 및 전자금융거래의 내용과 실적에 관한 정보 또는 자료를 금융실명법 등 법령에 의하거나 이용자의 동의를 얻지 아니하고는 제3자에게 제공, 누설하거나 업무상 목적 외에 사용하지 아니합니다.

제10조 (회사의 책임) 
① 회사는 접근매체의 위조나 변조로 발생한 사고(단, 회사가 접근매체의 발급주체이거나 사용, 관리주체인 경우), 계약체결 또는 거래지시의 전자적 전송이나 처리과정에서 발생한 사고로 인하여 이용자에게 손해가 발생한 경우에는 그 손해를 배상할 책임을 집니다. 
② 회사는 제1항에도 불구하고 다음 각호의 경우에는 이용자에 대하여 손해배상책임을 지지 않습니다. 
1. 회사가 접근매체의 발급주체가 아닌 경우로서 접근매체의 위조나 변조로 발생한 사고로 인하여 이용자에게 손해가 발생한 경우 
2. 이용자가 접근매체를 제3자에게 대여하거나 사용을 위임하거나 양도 또는 담보 목적으로 제공하거나, 제3자가 권한 없이 이용자의 접근매체를 이용하여 전자금융거래를 할 수 있음을 쉽게 알았거나 알 수 있었음에도 불구하고 이용자가 자신의 접근매체를 누설 또는 노출하거나 방치한 경우 
3. 법인('중소기업기본법' 제2조 제2항에 의한 소기업을 제외합니다)인 이용자에게 손해가 발생한 경우로서 회사가 사고를 방지하기 위하여 보안절차를 수립하고 이를 철저히 준수하는 등 합리적으로 요구되는 충분한 주의의무를 다한 경우 
③ 회사는 이용자로부터의 거래지시가 있음에도 불구하고 컴퓨터 등 정보통신설비의 보수점검, 교체 및 고장, 통신의 두절 등의 사유가 발생한 경우에는 전자금융서비스의 제공을 일시적으로 중단할 수 있으며, 이로 인하여 이용자에게 손해가 발생한 경우에는 그 손해를 배상할 책임을 집니다. 
④ 회사는 제3항에도 불구하고 천재지변, 회사의 귀책사유가 없는 정전, 화재, 통신장애 기타의 불가항력적 사유로 처리불가능하거나 지연된 경우로서 이용자에게 처리불가능 또는 지연사유를 통지한 경우(금융기관 또는 결제수단 발행업체나 통신판매업자가 통지한 경우를 포함합니다) 또는 회사가 고의, 과실 없음을 입증한 경우에는 이용자에 대하여 손해배상책임을 지지 않습니다. 
⑤ 회사는 컴퓨터 등 정보통신설비의 보수점검, 교체의 사유 등이 발생한 경우 전자금융거래서비스의 제공을 일시적으로 중단할 수 있으며, 회사는 각 홈페이지를 통하여 이용자에게 전자금융거래서비스 제공의 중단일정 및 중단 사유를 사전에 공지합니다.

제11조 (분쟁처리 및 분쟁조정) 
① 이용자는 ‘더데이즈 웹사이트’ 초기 화면 하단에 게시된 분쟁처리 책임자 및 담당자 연락처를 통하여 전자금융거래와 관련한 의견 및 불만의 제기, 손해배상의 청구 등의 분쟁처리를 요구할 수 있습니다. 
② 이용자는 제1항에 따라 서면(전자문서를 포함합니다) 또는 전자적 장치를 이용하여 회사의 본점이나 영업점에 분쟁처리를 신청할 수 있으며, 회사는 15일 이내에 이에 대한 조사 또는 처리 결과를 이용자에게 안내합니다. 
③ 이용자는 회사의 분쟁처리결과에 대하여 이의가 있을 경우 '금융위원회의 설치 등에 관한 법률'에 따른 금융감독원의 금융분쟁조정위원회나 '소비자기본법' 에 따른 한국소비자원의 소비자분쟁조정위원회에 회사의 전자금융거래서비스의 이용과 관련한 분쟁조정을 신청할 수 있습니다.

제12조 (회사의 안정성 확보 의무) 회사는 전자금융거래가 안전하게 처리될 수 있도록 선량한 관리자로서의 주의를 다하며, 전자금융거래의 안전성과 신뢰성을 확보할 수 있도록 전자금융거래의 종류별로 전자적 전송이나 처리를 위한 인력, 시설, 전자적 장치 등의 정보기술부문 및 전자금융업무에 관하여 금융위원회가 정하는 기준을 준수합니다.

제13조 (약관외 준칙) 본 약관에서 정하지 아니한 사항(용어의 정의 포함)에 대하여는 전자금융거래법, 전자상거래 등에서의 소비자 보호에 관한 법률, 여신전문금융업법 등 소비자보호 관련 법령 및 개별약관에서 정한 바에 따릅니다.

제14조 (관할) 회사와 이용자간에 발생한 분쟁에 관한 관할은 민사소송법에서 정한 바에 따릅니다.

제2장 전자지급결제대행서비스

제15조 (정의) 
본 장에서 정하는 용어의 정의는 다음과 같습니다. 
1. '전자지급결제대행 서비스'라 함은 전자적 방법으로 재화 또는 용역(이하 '재화 등'이라고만 합니다)의 구매에 있어서 지급결제정보를 송신하거나 수신하는 것 또는 그 대가의 정산을 대행하거나 매개하는 서비스를 말합니다. 
2. '이용자'라 함은 본 약관에 동의하고 회사가 제공하는 전자지급결제대행 서비스를 이용하는 자를 말합니다.

제16조 (거래지시의 철회) 
① 이용자가 전자지급결제대행서비스를 이용한 경우, 이용자는 거래지시된 금액의 정보에 대하여 수취인의 계좌가 개설되어 있는 금융기관 또는 회사의 계좌의 원장에 입금기록이 끝나거나 전자적 장치에 입력이 끝나기 전까지 거래지시를 철회할 수 있습니다. 
② 회사는 이용자의 거래지시의 철회에 따라 지급거래가 이루어지지 않은 경우 수령한 자금을 이용자에게 반환하여야 합니다.

제17조 (접근매체의 관리) 
① 회사는 전자지급결제대행서비스 제공 시 접근매체를 선정하여 이용자의 신원, 권한 및 거래지시의 내용 등을 확인 하여야 합니다. 
② 이용자는 접근매체를 사용함에 있어서 다른 법률에 특별한 규정이 없는 한 다음 각 호의 행위를 하여서는 아니됩니다. 
1. 접근매체를 양도하거나 양수하는 행위 
2. 접근매체를 대여하거나 사용을 위임하는 행위 
3. 접근매체를 질권 기타 담보 목적으로 하는 행위 
4. 1호부터 3호까지의 행위를 알선하는 행위 
③ 이용자는 자신의 접근매체를 제3자에게 누설 또는 노출하거나 방치하여서는 안되며, 접근매체의 도용이나 위조 또는 변조를 방지하기 위하여 충분한 주의를 기울여야 합니다. 
④ 회사는 이용자로부터 접근매체의 분실이나 도난 등의 통지를 받은 때에는 그 때부터 제3자가 그 접근매체를 사용함으로 인하여 이용자에게 발생한 손해를 배상할 책임이 있습니다.


제3장 선불전자지급수단

제18조 (정의) 
본 장에서 정하는 용어의 정의는 다음과 같습니다. 
1. ‘ 선불전자지급수단 ’이라 함은 ‘더데이즈 웹사이트’ 에서 사용되는 적립금으로 회사가 발행 당시 미리 이용자에게 공지한 전자금융거래법상 선불전자지급수단을 말합니다. 
2. ‘적립금’이라 함은 회사에서 무상으로 지급하는 선불지급수단을말합니다. 
3. '이용자'라 함은 본 약관에 동의하고 판매자로부터 재화등을 구매하고 선불전자지급수단 을 결제수단으로 하여 그 대가를 지급하는 자를 말합니다. 
4. '판매자'라 함은 이용자에게 재화등을 판매하고 선불전자지급수단을 결제수단으로 하여 그 대가를 지급받는 자를 말합니다. 
5. '접근매체'라 함은 선불전자지급수단을 이용한 전자금융거래에 있어서 지급지시를 하거나 이용자 및 거래내용의 진실성과 정확성을 확보하기 위하여 회사에 등록된 이용자번호 및 비밀번호 기타 회사가 지정한 수단을 말합니다.

제19조 (접근매체의 관리) 
① 회사는 이용자로부터 선불전자지급수단이나 접근매체의 분실 또는 도난 등의 통지를 받기 전에 저장된 금액에 대한 손해에 대하여는 책임지지 않습니다. 
② 제2장 전자지급결제대행서비스 제17조 제1항 내지 제3항은 본장 선불전자지급수단 에 준용합니다.

제20조 (환급) 
이용자는 보유 중인 선불전자지급수단 의 환급을 회사에 요구할 경우 선불전자지급수단 전액을 환급 받으실 수 있습니다. 다만, 환급의 대상이 되는 선불전자지급수단 은 이용자가 회사로부터 구매하여 보유하고 있는 것에 한정되며, 이용자가 이벤트 등을 통하여 회사로부터 무상 제공받은 것은 포함되지 않습니다.

제21조 (유효기간) 
① 회사는 이용자에 대하여 이벤트 등을 통하여 무상으로 제공되는 선불전자지급수단 에 대하여 유효 기간을 설정할 수 있으며, 이용자는 회사가 정한 유효기간 내에서만 동 무상 선불전자지급수단 을 사용할 수 있습니다. 
② 회사는 해당 이벤트 웹 페이지 등을 통하여 유효기간 설정 여부 및 그 기간을 사전 고지합니다.

제22조 (거래지시의 철회) 
① 이용자가 선불전자지급수단 을 이용한 경우, 이용자는 거래지시된 금액의 정보가 수취인이 지정한 전자적 장치에 도달한 때까지 거래지시를 철회할 수 있습니다. 
② 회사는 이용자의 거래지시의 철회에 따라 지급거래가 이루어지지 않은 경우 수령한 자금을 이용자에게 반환하여야 합니다.

제23조 (환수 및 선불전자지급수단의 마이너스 처리) 
① 구매를 통해 적립된 이용자의 선불전자지급수단 은 해당 구매가 취소될 경우 회사에 의해 환수될 수 있습니다. 
② 이용자의 구매 취소 등의 사유 발생으로 회사가 이용자에게 기 부여한 선불전자지급수단 을 환수하고자 하는 경우 환수 시점에 당해 이용자의 선불전자지급수단 잔액이 환수대상액보다 작을 경우에는 회사는 당해 이용자에 대한 선불전자지급수단 을 0보다 작은 마이너스로 처리할 수 있으며, 이용자는 자신의 마이너스 선불전자지급수단 을 추가 구매를 통한 적립, 현금 결제를 통한 충전 등을 통하여 만회할 수 있습니다.

부칙
제1조 (적용일자) 
		이 약관은 2013년 12월 31일부터 시행됩니다.
									</textarea>
									</div>




								<div>
								<textarea style="width:100%" rows="5">개인정보의 보유 및 이용기간

회사는 원칙적으로 개인정보 수집 및 이용목적이 달성된 후에는 해당 개인정보를 지체 없이 파기합니다. 단, 관계법령의 규정에 의하여 보존할 필요가 있는 경우 회사는 아래와 같이 관계법령에서 정한 일정한 기간 동안 이용자 개인정보를 보관합니다.

가. 상법 등 법령에 따라 보존할 필요성이 있는 경우

① 표시 • 광고에 관한 기록  - 보존근거 : 전자상거래 등에서의 소비자보호에 관한 법률 제6조 및 시행령 제6조   - 보존기간 : 6개월
② 계약 또는 청약철회 등에 관한 기록  - 보존근거 : 전자상거래 등에서의 소비자보호에 관한 법률 제6조 및 시행령 제6조   - 보존기간 : 5년
③ 대금결제 및 재화 등의 공급에 관한 기록  - 보존근거 : 전자상거래 등에서의 소비자보호에 관한 법률 제6조 및 시행령 제6조   - 보존기간 : 5년
④ 소비자의 불만 또는 분쟁처리에 관한 기록 - 보존근거 : 전자상거래 등에서의 소비자보호에 관한 법률 제6조 및 시행령 제6조   - 보존기간 : 3년
⑤ 신용정보의 수집, 처리 및 이용 등에 관한 기록   - 보존근거 : 신용정보의 이용 및 보호에 관한 법률   - 보존기간 : 3년
⑥ 접속에 관한 기록보존   - 보존근거 : 통신비밀보호법 제15조의2 및 시행령 제41조  - 보존기간 : 3개월

나. 기타, 이용자의 개별적인 동의가 있는 경우에는 개별 동의에 따른 기간까지 보관합니다
개인정보의 수집 및 이용목적

회사는 수집된 이용자들의 개인정보를 다음의 목적을 위해 이용하고 있습니다.

가. 서비스 제공에 관한 계약 이행 및 서비스 제공에 따른 요금정산
- 컨텐츠 및 회원 맞춤형 서비스 제공, 서비스 구매 및 요금 결제, 금융거래 본인 인증 및 금융 서비스, 상품 주문에 따른 배송 서비스 

나. 회원 관리
- 회원제 서비스 제공, 개인 식별, 불량회원의 부정 이용 방지와 비인가 사용 방지, 가입 의사 확인, 가입 및 가입회수 제한, 분쟁 조정을 위한 기록 보존, 불만처리 등 민원처리, 고지사항 전달

다. 신규서비스 개발 • 마케팅 및 광고에 활용
- 신규 서비스(컨텐츠) 개발 및 특화, 이벤트 등 광고성 정보 전달, 통계학적 특성에 따른 서비스 제공 및 광고 게재, 접속 빈도 파악, 회원의 서비스 이용에 대한 통계</p>

수집하는 개인정보 항목 

회사는 회원가입, 상담, 서비스 신청 및 제공 등을 위해 다음과 같은 개인정보를 수집하고 있습니다. 

가. 개인정보 수집 항목

&lt;필수항목&gt;
- 회원가입 : 성명, 성별, 생년월일, 휴대전화번호, 전자우편주소, 주소
- 상품구매 : 성명, 휴대전화번호, 연락처, 신용카드번호, 계좌번호 , 거래은행명, 아이핀(I-PIN)번호
- 연령제한서비스이용 : 아이핀(I-PIN), 나이스 본인인증
- 환불 : 계좌번호, 거래은행명, 계좌
다만, 서비스 이용과정에서 서비스 이용기록, 접속 로그, 쿠키, 접속 IP 정보, 결제기록 등이 생성되어 수집될 수 있습니다. 

&lt;선택항목&gt;
※ 입점/제휴/문의 : 업체의 명칭, 대표자명, 사업자번호, 주소, 전화번호, 전자우편주소, 담당자의 성명, 직위, 전화번호, 휴대전화번호, 전자우편주소, 팩스번호

나. 개인정보 수집 방법 
- 홈페이지(회원가입, 고객센터게시판, 협력/제휴) 및 고객센터를 통한 전화 및 온라인 상담 - 구독하기 페이지 및 이벤트 페이지를 통한 입력</textarea>

							</div>
							
							<div id="login_agree">
								<input type="checkbox" id="register_agree" style="width:40px; height:40px;">
								<label for="register_agree" class="">정책에 동의</label>
							</div>
						</div>
					</div>
					
					
					<div class="form-group">
						<div class="col-sm-offset-1 col-sm-8">
							<button id="register_btn" class=" btn-regster">
								<a>확인</a>
							</button>
						</div>
					</div>
				
			
			
			
	
	
			
			
	</div>
	</form>		
</div>
	

<!-- //페이지 끝-->