<!-- #container -->
<div id="container" class="clearfix">

	<!-- 페이지 시작-->

	<!-- lnb -->
	<?=aside_top_mypage()?>

	<div id="login">
		<!-- login -->
		<div class="main_login_bx v2 text-center">
			<p class="ma20 color_grey">패스워드를 입력 하시면 패스워드가 변경 됩니다.
				<br> 이메일은 변경 하실 수 없습니다.</p>
			<form class="mb15" action="/mypage/myinfo_save" method="POST">
				<div>
					<input type="text" name="email" class="form-control" placeholder="이메일을 입력하세요" value="<?=$this->session->userdata['email']?>" readonly>
					<input type="text" name="mobile" class="form-control" placeholder="연락처를 입력해 주십시오" value="<?=$mobile?>" >
					<input type="password" name="password" class="form-control mt10" placeholder="비밀번호 변경을 원하시면 입력해 주십시오.">
				</div>
				<div class="mt15">
					<button type="submit" class="btn btn-block bg_blue2">수정</button>
				</div>
			</form>
		</div>
	</div>

	<!-- //페이지 끝-->

</div>
<!-- //container -->
