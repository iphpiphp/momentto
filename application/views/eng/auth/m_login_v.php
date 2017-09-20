 <?
$active1 = "active";
$active2 = "";
?>
 <!-- #container -->
<div id="container" class="clearfix">

	<!-- 페이지 시작-->
	
	<!-- side -->

		<!-- content -->
		
			
			<!-- div class="row  w1140">
			<!-- h1 class="sub_hd">SNS 로그인</h1>
				<div class="login_bx">
					<div class="form-group">
						<div class="login_img">
							<a href="/auth/sns_login?type=FB"><img src="/assets/img/ico/facebook.png" width=85></a>
							<a href="/auth/sns_login?type=GP"><img src="/assets/img/ico/google.png" width=85></a>
							<a href="/auth/sns_login?type=NV"><img src="/assets/img/ico/naver.png" width=85></a>
						</div>
					</div>
				</div>
			</div -->
			
			<div class="row side_page w1140">
				<div id="ct" class="col-md-10">
				<ul class="nav2">
					<li class="<?=$active1?>"><b><a href="/auth/login">회원 로그인</a></b></li>
					<li class="<?=$active2?>"><b><a href="/auth/guest">비회원 로그인</a></b></li>
				</ul>
			

		
			<div class=" login_bx ">
				<form class="form-horizontal mt0" action="/auth/login_chk" method="post" id="login-form" role="form">
					<div class="form-group">
						<div class="form-group">
							<div class="col-sm-8">
								<input type="text" name="email" id="email" class="form-control" placeholder="이메일">
							</div>
						</div>
						<div class="form-group">
							<div class="col-sm-8">
								<input type="password" name="password" id="password" class="form-control"  placeholder="패스워드">
							</div>
						</div>
					</div>
					
					<div class="form-group">
						<div class="col-sm-offset-1 col-sm-8">
							<button id="" class=" btn-regster">
								<a>로그인</a>
							</button>
						</div>
					</div>
					
				</form>
				<div class="form-group">
						<div class="col-sm-offset-1 col-sm-8">
							<button id="regist_go" class=" btn-regster2">
								<a href="/auth/regster/">회원가입</a>
							</button>
						</div>
					</div>
			</div>
				
			
			
			
			</div>
		</div>
	

	<!-- div class="row side_page w1140">
	<h1 class="sub_hd">SNS 로그인</h1>
		<div class="login_bx">
			<div class="form-group">
				<div class="login_img">
					<a href="/auth/sns_login?type=FB"><img src="/assets/img/ico/facebook.png" width=85></a>
					<a href="/auth/sns_login?type=GP"><img src="/assets/img/ico/google.png" width=85></a>
					<a href="/auth/sns_login?type=NV"><img src="/assets/img/ico/naver.png" width=85></a>
				</div>
			</div>
		</div>
	</div -->
			
</div>    
    