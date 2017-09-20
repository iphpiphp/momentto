<!-- #container -->
	<div id="container" class="clearfix">

<!-- 페이지 시작-->

<div class="row side_page w1140">
	<!-- side -->
	<?=aside_left_mypage()?>
	
	<!-- content -->
	<div id="ct" class="col-md-10">
		<h1 class="sub_hd">
			개인정보 조회/변경 
			<small>개인정보 보호를 위해 주기적으로 비밀번호를 변경해주시고,  타인에게 비밀번호가 노출되지 않도록 주의해주세요.</small>
		</h1>
		<div class="login_bx">
			<form action="/mypage/myinfo" method="POST" >
				<img class="img-responsive" src="<?=IMG_PATH?>img/mypage/personal.png" alt="" />
				<p class="mb10">개인정보를 안전하게 보호하기 위해 비밀번호를 다시 한 번 입력해 주세요.</p>
				<div class="mb10">
					<input type="text" name="email" class="form-control" placeholder="이메일">
				</div>
				<div class="mb10">
					<input type="password" name="password" class="form-control" placeholder="비밀번호">
				</div>
				<div class="mb10">
					<button type="submit" class="btn btn-lg btn-block bg_red">확인</button>
				</div>
			</form>
		</div>
	</div>
</div>

<!-- //페이지 끝-->