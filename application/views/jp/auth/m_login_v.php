<?
	$active1 = "active";
	$active2 = "";
?>
	<!-- #container -->
	<div id="container" class="clearfix">

		<!-- 페이지 시작-->

		<div id="login">
			<ul class="nav2">
				<li class="<?=$active1?>"><a href="/auth/login">회원 로그인</a></li>
				<li class="<?=$active2?>"><a href="/auth/guest">비회원 로그인</a></li>
			</ul>
			<!-- login -->
			<div class="main_login_bx text-center">
				<form class="mb15" action="/auth/login_chk" method="post" id="login-form" role="form">
					<div>
						<input type="text" name="email" id="email" class="form-control" placeholder="이메일을 입력하세요">
						<input type="password" name="password" id="password" class="form-control mt10" placeholder="비밀번호를 입력하세요">
					</div>
					<div class="mt15">
						<button type="submit" class="btn btn-block bg_red btn-regster">로그인</button>
						<p class="mt25 mb10 fs13 color_blue2">SNS 로그인</p>
						<a class="btn btn-block bg_fb" href="/auth/sns_login?type=FB"><i class="fa fa-facebook mr10"></i> 페이스북 계속하기</a>
					</div>
				</form>
			</div>
		</div>

		<!-- //페이지 끝-->

	</div>
	<!-- //container -->
