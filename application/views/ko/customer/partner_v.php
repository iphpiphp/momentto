<!-- #container -->
<div id="container" class="clearfix">

	<!-- 페이지 시작-->
	<script>
		$(document).ready(function() {
			$("#submit").click(function() {


				if (!$("#name").val()) {
					alert("이름이 비어 있습니다.");
					return false;
				}
				if (!$("#company").val()) {
					alert("회사이름이 비어 있습니다.");
					return false;
				}
				if (!$("#email").val()) {
					alert("이메일이 비어 있습니다.");
					return false;
				}

				if (!$("#advice").val()) {
					alert("상담 내용이 비어 있습니다.");
					return false;
				}

				if ($('#chk').prop('checked') == false) {
					alert('정책에 동의해 주셔야 합니다.');
					return false;
				}

				$("#form_post").submit();
			});
			
			$(".btn_upload").click(function(){
				$(".upload").click();
			});
			$(".upload").change(function(){				
				$(".file_text").text($(this).val());
			});
		});

	</script>


	<!-- 페이지 시작-->
	<style>
	
	</style>
	<!-- lnb -->
	<nav class="lnb">
		<a href="#">협력/제휴</a>
	</nav>

	<div id="partner">
		<section>
			<h2 class="color_red">1. 상품 입점</h2>
			<p>현재 더데이즈 플랫폼에 귀사의 새롭고 참신한 상품을 입점 제안하실 수 있습니다.</p>
		</section>
		<section>
			<h2 class="color_red">2. 상품 제휴</h2>
			<p>경쟁력을 갖춘 더데이즈의 모든 상품을 제휴의 형태로 제공하여 양사가 윈-윈 할수 있습니다.</p>
		</section>
		<section>
			<h2 class="color_red">3. 마케팅 제휴</h2>
			<p>온라인 프로모션/이벤트/협찬 및 다양한 마케팅 제휴를 더데이즈와 함께 진행할 수 있습니다.</p>
		</section>
		<section>
			<h2 class="color_red">4. 대량구매</h2>
			<p>기업/단체/학교/스튜디오 등 더데이즈의 상품을 대량으로 구매 해야 할 경우 요청사항을 남겨 주시면 별도로 연락을 드립니다.</p>
		</section>
		<form class="form-horizontal" action="/customer/partner_post/" method="post" id="form_post" enctype="multipart/form-data">
			<fieldset class="bg_f0">
				<div class="form-group">
					<label class="col-sm-2 control-label color_blue2">구분</label>
					<div class="col-sm-10">
						<select class="form-control" id="select" name="type">
							<option value="1">상품 입점</option>
							<option value="2">상품 제휴</option>
							<option value="3">마케팅 제휴</option>
							<option value="4">대량구매 제안</option>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label color_blue2">이름 *</label>
					<div class="col-sm-10">
						<input type="text" class="form-control"  id="name" name="name">
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label color_blue2">직급</label>
					<div class="col-sm-10">
						<input type="text" class="form-control" id="rank" name="position">
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label color_blue2">회사 *</label>
					<div class="col-sm-10">
						<input type="text" class="form-control" id="company" name="company">
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label color_blue2">부서명</label>
					<div class="col-sm-10">
						<input type="text" class="form-control" id="department" name="department">
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label color_blue2">회사전화</label>
					<div class="col-sm-10">
						<div class="frm_tel row">
							<div class="col-xs-4">
								<input type="text" class="form-control" maxlength="4" name="tel_1">
							</div>
							<div class="col-xs-4">
								<input type="text" class="form-control" maxlength="4" name="tel_2">
							</div>
							<div class="col-xs-4">
								<input type="text" class="form-control" maxlength="4" name="tel_3">
							</div>
						</div>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label color_blue2">휴대폰번호</label>
					<div class="col-sm-10">
						<div class="frm_tel row">
							<div class="col-xs-4">
								<input type="text" class="form-control" maxlength="4" name="mobile_1">
							</div>
							<div class="col-xs-4">
								<input type="text" class="form-control" maxlength="4" name="mobile_2">
							</div>
							<div class="col-xs-4">
								<input type="text" class="form-control" maxlength="4" name="mobile_3">
							</div>
						</div>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label color_blue2">이메일 *</label>
					<div class="col-sm-10">
						<input type="email" class="form-control" 	name="email" id="email" >
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label color_blue2">상담내용</label>
					<div class="col-sm-10">
						<textarea class="form-control" rows="5" name="content" id="advice"></textarea>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label color_blue2">사진등록</label>
					<div class="col-sm-10">
						<button type="button" class="btn bg_blue2 btn_radius w110 pull-right btn_upload">파일 선택</button>
						<p class="fs12 color_grey">*100Mbyte 미만의 파일만 허용</p>
						<div class="mt5 fs13 color_blue2 file_text">선택된 파일 없음</div>
						<input type="file" class="form-control upload" id="photo" name="userfile">
						
					</div>
				</div>
				<p class="pt30 fs13 color_565656">* 제안의 내용이 더데이즈의 비전과 맞지 않거나 협력/제휴의 방식으로 불가능한 경우 별도의 연락 없이 회신이 없을 수 있습니다.</p>
			</fieldset>
			<div class="pa16 pt30 pb50">
				<ol class="color_grey">
					<li>수집 주체 : (주)위드비디오</li>
					<li>수집 목적 : 제안(문의) 내용의 확인 및 처리</li>
					<li>수집 항목 : 이름, 회사(단체명), 직급, 부서명, 대표전화, 휴대폰번호, 이메일</li>
					<li>보유 기간 : 제안(문의) 채택 시 서비스 반영 시 까지, 제안(문의) 불 채택 시 즉시 파기됨</li>
				</ol>
				<div class="mt20 mb25 fs15 checkbox">
					<label>
						<input type="checkbox" checked="checked" id="chk"> 위의 개인정보 제공에 동의합니다.
					</label>
				</div>
				<a  id="submit" class="btn btn-block bg_red">문의/제안 신청</a>
			</div>
		</form>
	</div>

	<!-- //페이지 끝-->

</div>
