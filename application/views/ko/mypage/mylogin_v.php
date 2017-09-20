<!-- #container -->
<div id="container" class="clearfix">

	<!-- 페이지 시작-->

	<!-- lnb -->
	<?=aside_top_mypage()?>

	<div id="login">
		<!-- login -->
		<div class="main_login_bx v2 text-center">
			<img class="mt20 mb40" src="<?=PATH3?>img/mypage/personal.png" alt="logo" style="width:108px">
			<form class="mb15" action="/mypage/myinfo" method="POST" >
				<div>
					<input type="text" name="email" class="form-control" placeholder="이메일을 입력하세요">
					<input type="password" name="password" class="form-control mt10" placeholder="비밀번호를 입력하세요">
				</div>
				<div class="mt15">
					<button type="submit" class="btn btn-block bg_blue2">확인</button>
				</div>
			</form>
		</div>
	</div>

	<!-- //페이지 끝-->

</div>
<!-- //container -->
