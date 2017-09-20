 <?
$active1 = "";
$active2 = "active";
?>
 <!-- #container -->
<div id="container" class="clearfix">

	<!-- 페이지 시작-->
	<div class="row side_page w1140">
	<!-- side -->

		<!-- content -->
		<div id="ct" class="col-md-10">
			<ul class="nav2">
				<li class="<?=$active1?>"><b><a href="/auth/login">회원 로그인</a></b></li>
				<li class="<?=$active2?>"><b><a href="/auth/guest">비회원 로그인</a></b></li>
			</ul>
		
			<div class=" login_bx ">
				<form class="form-horizontal mt0" action="/auth/guest_login" id="register-form" role="form" method="post">
					<div class="form-group">
						<div class="form-group">
							<div class="col-sm-8">
								<input type="text" name="oid" id="oid" class="form-control"  placeholder="주문번호">
							</div>
						</div>
						<div class="form-group">
							<div class="col-sm-8">
								<input type="text" name="email" id="email" class="form-control" placeholder="이메일">
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
</div>
			
    
    