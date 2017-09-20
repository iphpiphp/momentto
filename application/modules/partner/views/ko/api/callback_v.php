<!-- #container -->
	<div id="container" class="clearfix">

<!-- 페이지 시작-->

<div class="row side_page w1140">
	<!-- side -->
	
	
	<!-- content -->
	<div id="ct" class="col-md-10">
		<h1 class="sub_hd">
			 SNS 회원 가입
			<small>패스워드는 7자리 이상, 영문/숫자/특수문자 혼용 으로 넣어주셔야 합니다.</small>
		</h1>
		<div class="login_bx">
			<form action="/api/sns_regster" method="POST" id="form_post">
				<img class="img-responsive" src="<?=IMG_PATH?>img/mypage/personal.png" alt="" />
				<p class="mb10">더데이즈 사이트에 사용 하실 패스워드를 입력해 주십시오.</p>
				<div class="mb10">
					<input type="text" name="email" class="form-control" placeholder="이메일" value="<?=$email?>" readonly>
				</div>
				<div class="mb10">
					<input type="password" id="password" name="password" class="form-control" placeholder="비밀번호" value="">
				</div>
				<div class="mb10">
					<a  class="btn btn-lg btn-block bg_red" id="sns_regster">확인</a>
				</div>
			</form>
		</div>
	</div>
</div>

<!-- //페이지 끝-->