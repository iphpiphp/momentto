<body class="login-page">
	<div id="login" class="animated bounceIn">
		<!-- Start .login-wrapper -->
		<div class="login-wrapper">
			<ul id="myTab" class="nav nav-tabs nav-justified bn">
				<li class="active">
					<a href="#log-in">로그인</a>
				</li>
				<li class="">
					<a href="/auth/regster">회원가입</a>
				</li>
			</ul>
			<div id="myTabContent" class="tab-content bn">
				<div class="tab-pane fade active in" id="log-in">					
					
					<form class="form-horizontal mt0" action="/auth/return_login_chk" method="post" id="login-form" role="form">						
						<div class="form-group">
							<div class="col-lg-12">
								<input type="text" name="email" id="email" class="form-control left-icon" value="" placeholder="이메일을 입력해 주세요.">
								
							</div>
						</div>
						<div class="form-group">
							<div class="col-lg-12">
								<input type="password" name="password" id="password" class="form-control left-icon" value="somepass" placeholder="패스워드를 입력해 주세요.">
								
							</div>
						</div>
						<div class="form-group">
							
							<!-- col-lg-12 end here -->
							<div class="col-lg-12 mb25">
								<!-- col-lg-12 start here -->
								<button class="btn btn-default pull-right" type="submit">Login</button>
							</div>
							<!-- col-lg-12 end here -->
						</div>
					</form>
				</div>
			</div>
		</div>
		<!-- End #.login-wrapper -->
	</div>