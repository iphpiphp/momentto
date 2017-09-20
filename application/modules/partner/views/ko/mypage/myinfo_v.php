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
			<form action="/mypage/myinfo_save" method="POST" >
				
				패스워드를 입력 하시면 패스워드가 변경 됩니다.<br>
				이메일은 변경 하실 수 없습니다.
				<div class="mb10">
					<input type="text" name="email" class="form-control" placeholder="이메일" value="<?=$this->session->userdata['email']?>" readonly>
				</div>
				
				<div class="mb10">
					<input type="text" name="password" class="form-control" placeholder="패스워드" value="">
				</div>
				
				<div class="mb10">
					<button type="submit" class="btn btn-lg btn-block bg_red">수정</button>
				</div>
			</form>
		</div>
	</div>
</div>

<!-- //페이지 끝-->