<?
$active1 = "";
$active2 = "active";
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
				<form class="mb15" action="/auth/guest_login" id="register-form" role="form" method="post">
					<div>
						<input type="text" name="oid" id="oid" class="form-control" placeholder="주문번호를 입력하세요">
						<input type="password" name="password" id="password" class="form-control mt10" placeholder="패스워드를 입력해 주세요">
					</div>
					<div class="mt15">
						<button type="submit" class="btn btn-block bg_red">로그인</button>
					</div>
				</form>
			</div>
		</div>
		<!-- //페이지 끝-->
	</div>
	<!-- //container -->
