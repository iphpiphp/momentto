	<!-- #container -->
	<div id="container" class="clearfix">

<!-- 페이지 시작-->
<script>
		$(document).ready(function(){
			$("#submit").click(function(){
				
				
				if(!$("#name").val()){
					alert("이름이 비어 있습니다.");
					return false;
				}
				if(!$("#company").val()){
					alert("회사이름이 비어 있습니다.");
					return false;
				}
				if(!$("#email").val()){
					alert("이메일이 비어 있습니다.");
					return false;
				}
				if(!$("#email_domain").val()){
					alert("이메일 도메인이 비어 있습니다.");
					return false;
				}
				if(!$("#advice").val()){
					alert("상담 내용이 비어 있습니다.");
					return false;
				}
				
				if($('#chk').prop('checked') == false){
			          alert('정책에 동의해 주셔야 합니다.');			          
			          return false;
			     }
				
				$("#form_post").submit();		
			});
		});	
</script>
<div id="cooperation" class="row side_page w1140">
	<!-- content -->
	<h1 class="sub_hd">
		협력/제휴
		<small>더데이즈는 늘 새롭고 스마트하게 나아갈 준비된 파트너를 기다립니다.</small>
	</h1>
	<ol class="row">
		<li class="col-sm-3 col-xs-6 num1">
			<strong>상품 입점</strong>
			<p>현재 더데이즈 플랫폼에 귀사의<br />
			새롭고 참신한 상품을 입점<br />
			제안하실 수 있습니다.</p>
		</li>
		<li class="col-sm-3 col-xs-6 num2">
			<strong>상품 제휴</strong>
			<p>경쟁력을 갖춘 더데이즈의<br />
			모든 상품을 제휴의 형태로<br />
			제공하여 양사가 윈-윈 할<br />
			수 있습니다.</p>
		</li>
		<li class="col-sm-3 col-xs-6 num3">
			<strong>마케팅 제휴</strong>
			<p>온라인 프로모션/이벤트/협찬<br />
			및 다양한 마케팅 제휴를<br />
			더데이즈와 함께 진행할 수<br />
			있습니다.</p>
		</li>
		<li class="col-sm-3 col-xs-6 num4">
			<strong>대량구매</strong>
			<p>기업/단체/학교/스튜디오 등<br />
			더데이즈의 상품을 대량으로<br />
			구매해야 할 경우 요청사항을 남겨<br />
			주시면 별도로 연락을 드립니다.</p>
		</li>
	</ol>		
	<div class="form_bx row">
		<p>제안의 내용이 더데이즈의 비전과 맞지 않거나 협력/제휴의 방식으로 불가능한 경우 별도의 연락 없이 회신이 없을 수 있습니다.</p>
		<form class="form-horizontal" action="/customer/partner_post/" method="post" id="form_post" enctype="multipart/form-data">
			<div class="form-group mb10">
				<label for="select" class="col-xs-2 control-label">구분</label>
				<div class="col-xs-10">
					<select class="form-control" id="select" name="type">
						<option value="1">상품 입점</option>
						<option value="2">상품 제휴</option>
						<option value="3">마케팅 제휴</option>
						<option value="4">대량구매 제안</option>
					</select>
				</div>
			</div>
			<div class="form-group mb10">
				<label for="name" class="col-xs-2 control-label">이름 *</label>
				<div class="col-xs-10">
					<input type="text" class="form-control" id="name" name="name">
				</div>
			</div>
			<div class="form-group mb10">
				<label for="rank" class="col-xs-2 control-label">직급</label>
				<div class="col-xs-10">
					<input type="text" class="form-control" id="rank" name="position">
				</div>
			</div>
			<div class="form-group mb10">
				<label for="company" class="col-xs-2 control-label">회사 *</label>
				<div class="col-xs-10">
					<input type="text" class="form-control" id="company" name="company">
				</div>
			</div>
			<div class="form-group mb10">
				<label for="department" class="col-xs-2 control-label">부서명</label>
				<div class="col-xs-10">
					<input type="text" class="form-control" id="department" name="department">
				</div>
			</div>
			<div class="form-inline form-group mb10">
				<label for="tel" class="col-xs-2 control-label">회사전화</label>
				<div class="col-xs-10 input_wid">
					<!-- select class="form-control" id="tel" title="첫번째자리">
						<option>010</option>
					</select -->
						<input type="text" class="form-control" title="두번째자리" 	name="tel_1">
					 - <input type="text" class="form-control" title="두번째자리" 	name="tel_2">
					 - <input type="text" class="form-control" title="세번째자리"	name="tel_3">
				</div>
			</div>
			<div class="form-inline form-group mb10">
				<label for="phone" class="col-xs-2 control-label">휴대폰번호</label>
				<div class="col-xs-10 input_wid">
					<!-- select class="form-control" id="phone" title="첫번째자리">
						<option>010</option>
					</select -->
					<input type="text" class="form-control" title="두번째자리" 		name="mobile_1">
					 - <input type="text" class="form-control" title="두번째자리" 	name="mobile_2">
					 - <input type="text" class="form-control" title="세번째자리"	name="mobile_3">
				</div>
			</div>
			<div class="form-inline form-group mb10">
				<label for="email" class="col-xs-2 control-label">이메일 *</label>
				<div class="col-xs-10 input_wid">
					<input type="text" class="form-control" id="email" 			name="mail_id">
					 @ <input type="text" class="form-control" id="email_domain" title="도메인주소" 	name="mail_domain">
					<!-- select class="form-control" id="phone" title="도메인선택">
						<option>선택하세요</option>
					</select -->
				</div>
			</div>
			<div class="form-inline form-group mb10">
				<label for="advice" class="sr-only">상담내용 *</label>
				<textarea name="content" id="advice" rows="5" placeholder="상담내용" class="col-xs-12" ></textarea>				
			</div>
			<div class="form-group mb20">
				<label for="photo" class="col-xs-2 control-label">사진등록</label>
				<div class="col-xs-10">
					<input type="file" class="form-control" id="photo" name="userfile">
				</div>
				<p>*100Mbyte 미만의 파일만 허용</p>
			</div>
			<div class="form-group mb10">
				<div class="agree_txt">
					<ol>
						<li>1. 수집 주체 : (주)더데이즈</li>
						<li>2. 수집 목적 : 제안(문의) 내용의 확인 및 처리</li>
						<li>3. 수집 항목 : 이름, 회사(단체명), 직급, 부서명, 대표전화, 휴대폰번호, 이메일</li>
						<li>4. 보유 기간 : 제안(문의) 채택 시 서비스 반영 시 까지, 제안(문의) 불 채택 시 즉시 파기됨</li>
					</ol>
					<label class="pt10">
						<input type="checkbox" checked="checked" id="chk"> 위의 개인정보 제공에 동의합니다.
					</label>
				</div>
			</div>
			<div class="mb10">
				<a  id="submit" class="btn btn-lg btn-block bg_red2">문의/제안 신청</a>
			</div>
		</form>
	</div>
</div>

<!-- //페이지 끝-->

	</div>
	<!-- //container -->