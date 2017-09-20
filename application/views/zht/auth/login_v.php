 <!-- #container -->
<div id="container" class="clearfix">

	<!-- 페이지 시작-->

	<div class="row side_page w1140">
		<!-- side -->

		<!-- content -->
		<div id="ct" class="col-md-10">
			
    
    <body class="login-page">
        <!-- Start #login -->
        <div id="login" class="animated bounceIn">
            
            <!-- Start .login-wrapper -->
            <div class="login-wrapper">
                <ul id="myTab" class="nav nav-tabs nav-justified bn">
                    <li>
                        <a href="#log-in" data-toggle="tab">회원로그인</a>
                    </li>
                    <li class="">
                        <a href="#register" data-toggle="tab">비회원로그인</a>
                    </li>
                    <li class="">
                    	<a href="/auth/regster">회원가입</a>
                    </li>
                </ul>
                <div id="myTabContent" class="tab-content bn">
                    	<div class="tab-pane fade active in" id="log-in">
					<!--div class="social-buttons text-center mt25">
						<a href="#" class="btn btn-primary btn-alt btn-round btn-lg mr10"><i class="fa fa-facebook s24"></i></a>
						<a href="#" class="btn btn-primary btn-alt btn-round btn-lg mr10"><i class="fa fa-twitter s24"></i></a>
						<a href="#" class="btn btn-danger btn-alt btn-round btn-lg mr10"><i class="fa fa-google-plus s24"></i></a>
						<a href="#" class="btn btn-info btn-alt btn-round btn-lg"><i class="fa fa-linkedin s24"></i></a>
					</div>
					<div class="seperator">
						<strong>or</strong>
						<hr>
					</div -->
					<div class="seperator">
						
					</div>
					<form class="form-horizontal mt0" action="/auth/login_chk" method="post" id="login-form" role="form">
						<div class="form-group">
							<div class="col-lg-12">
								<!-- i class="im-user s16 left-input-icon"></i -->								
								<input type="text" name="email" id="email" class="form-control left-icon" value="" placeholder="이메일을 입력해 주세요.">
								
							</div>
						</div>
						<div class="form-group">
							<div class="col-lg-12">
								<input type="password" name="password" id="password" class="form-control left-icon" value="somepass" placeholder="패스워드를 입력해 주세요.">
								<!-- i class="im-lock s16 left-input-icon"></i -->
								<!-- span class="help-block"><a href="#"><small>Email/Password 찾기</small></a></span -->
							</div>
						</div>
						<div class="form-group">
							
							<!-- col-lg-12 end here -->
							<div class="col-lg-12">
								<!-- col-lg-12 start here -->
								<button class="btn btn-default btn-block" type="submit">Login</button>
							</div>
							<!-- col-lg-12 end here -->
						</div>
					</form>
				</div>
			
                    <div class="tab-pane fade" id="register">
                        <form class="form-horizontal mt20" action="/auth/guest_login" id="register-form" role="form" method="post">
                            <div class="form-group">
                                <div class="col-lg-12">
                                    <!-- col-lg-12 start here -->
                                    <input id="oid" name="oid" type="text" class="form-control left-icon" placeholder="주문번호를 입력해 주십시오.">
                                    
                                </div>
                                <!-- col-lg-12 end here -->
                            </div>
                            <div class="form-group">
                                <div class="col-lg-12">
                                    <!-- col-lg-12 start here -->
                                    <input id="email" name="email" type="email" class="form-control left-icon" placeholder="주문에 사용 하신 이메일을 입력해 주십시오.">
                                    <!-- i class="fa fa-envelope s16 left-input-icon"></i -->
                                </div>
                                <!-- col-lg-12 end here -->
                                <div class="col-lg-12 mt15">
                                    <!-- col-lg-12 start here -->
                                    <!--i class="im-lock s16 left-input-icon"></i -->
                                    <input type="password" class="form-control left-icon" id="password" name="passowrd" placeholder="패스워드를 입력해 주십시오">
                                     
                                </div>
                                <!-- col-lg-12 end here -->
                            </div>
                            <div class="form-group mb25">
                                <div class="col-lg-12">
                                    <!-- col-lg-12 start here -->
                                    <button class="btn btn-default btn-block">login</button>
                                </div>
                                <!-- col-lg-12 end here -->
                            </div>
                        </form>
                    
                    </div>
                </div>
            </div>
            <!-- End #.login-wrapper -->
        </div>
        
        
        
        </div>
        </div>
        </div>

