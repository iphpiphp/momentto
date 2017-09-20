<?	
	$display = "display: none";
	$exchange = exchange("USD"); 
?>
<style>

</style>
	<!-- #container -->
	<div id="container" class="clearfix">
		<!-- 페이지 시작-->
		<div id="index">
			<section id="sect1" class="row">
				<h2 class="sr-only">promotion</h2>
				<!-- 메인 슬라이드 -->
				<div id="slider">
					<ul>
						<? foreach ($bnr_list as $key => $val) : ?>
							<li>
								<a href="<?=$val['link']?>">
									<img class="img-responsive center-block" src="/uploads/main_bnr/<?=$val['zmb_filename']?>?v_3" alt="<?=$val['zmb_alt']?>" >
									<?=($val['isTxt'] == "T")? $val['content'] : ""?>
								</a>
							</li>
						<? endforeach; ?>
					</ul>
				</div>
				<!-- login -->
				<div class="main_login_bx text-center" style="<?=$this->session->userdata['email']? $display : '' ?>">
					<form class="mb15" action="/auth/login_chk" method="post">
						<div>
							<input type="text" name="email" class="form-control" placeholder="이메일을 입력하세요">
							<input type="password" name="password" class="form-control mt10" placeholder="비밀번호를 입력하세요">
						</div>
						<div class="mt15">
							<button type="submit" class="btn btn-block bg_red">로그인</button>
							<a class="btn btn-block bg_fb" href="/auth/sns_login?type=FB"><i class="fa fa-facebook mr10"></i> 페이스북 계속하기</a>
						</div>
						<div class="mt30">
							<a class="color_navy" href="/auth/reg_step1"><u>회원가입</u></a>
							<p class="mt16 fw300 ">무료제작체험, 영상 만들기는
								<br><b>PC버전에서</b> 가능합니다.</p>
						</div>
					</form>
				</div>
				<div class="col-xs-12">
					<ul id="indexTab" class="nav nav-pills nav-justified">
						<li><a href="/main/menual"><i class="icon_indextab_1"></i>사용 메뉴얼</a></li>						
						<li><a href="/review/lists/"><i class="icon_indextab_3"></i>리뷰</a></li>
						<li><a href="/main/helper"><i class="icon_indextab_4"></i>헬퍼 서비스</a></li>
					</ul>
				</div>
				<script>
					jQuery(function($) {
						$('#slider>ul').bxSlider({
							speed: 1000
						});
					});
					$(document).ready(function() {

						//카테고리 클릭
						$(".category_tab > li > a").click(function() {
							var cate = $(this).attr("item");
							var keyword = "";
							var i = $("#i").val();

							if (cate != 'keyword') {
								$(".category_tab > li > a").attr("class", "");
								$(this).attr("class", "on");
								$("#key_head").attr("class", "keyword_tg collapsed");
								$(".main_card > li").remove();


								$('body, html').animate({
									scrollTop: $("#indexTab").offset().top
								}, 1000);
								$(".main_card ").load("/main/main_list_html/" + cate + "/" + i + "/" + keyword);


							}
						});
						//키워드 클릭
						$(".keyword_tag").click(function() {

							var cate = 'all';
							var keyword = $(this).attr("item");
							var i = 1;

							$(".category_tab > li > a").attr("class", "");
							$("#cate_head").attr("class", "on");
							$("#key_head").attr("class", "keyword_tg collapsed");

							$(".main_card > li").remove();
							$('body, html').animate({
								scrollTop: $("#indexTab").offset().top
							}, 1000);
							$(".main_card ").load("/main/main_list_html/" + cate + "/" + i + "/" + keyword);

						});
					});

				</script>
			</section>
			<section id="sect2" class="row">
				<h2 class="sr-only">item</h2>
		<!-- 카테고리탭 -->
		<ul class="category_tab clearfix">
			<li><a class="keyword_tg collapsed" href="#keyword"  data-toggle="collapse" item="keyword" id="key_head">키워드 <i class="glyphicon glyphicon-menu-up"></i></a></li>
			<li><a class="on" href="#" item="all" id="cate_head">ALL</a></li>
			<li><a href="javascript:;" item="1">BABY&amp;KIDS</a></li>
			<li><a href="javascript:;" item="2">LOVE</a></li>
			<li><a href="javascript:;" item="3">WEDDING</a></li>
			<li><a href="javascript:;" item="4">ANNIVERSARY</a></li>
			<li><a href="javascript:;" item="5">TRAVEL</a></li>
			<li><a href="javascript:;" item="6">D-CARD</a></li>
			<li><a href="javascript:;" item="7">BUSINESS</a></li>
		</ul>
		<!-- 키워드 -->
		<div id="keyword" class="collapse">
			<i></i>
			<ul class="row">
				<? foreach($keyword_list as $key => $val): ?>
					<li class="col-sm-3 col-xs-6"><a href="#" class="keyword_tag" item="<?=$val['tag_name']?>"><?=$val['tag_name']?></a></li>							
				<? endforeach; ?>
				<!-- li class="col-sm-3 col-xs-6"><a href="">고급스러운</a></li -->				
			</ul>
		</div>
		<!-- ITEM -->
		<div class="lst">
			<ul class="row main_list">

				<li class="col-sm-6 col-xs-12 itm">
					<div>
						<a href="/product/lists/?cate_id=3">
							<img class="img-responsive" src="https://d359hdvta3sq5o.cloudfront.net/resources/mobile/main/c3.gif?_=v" alt="WEDDING">
						</a>
						<div class="cnt_wrp">
							<h4><a href="<?=Base_url()?>product/detail/">WEDDING</a></h4>
							<div class="summary">
								#식전영상 #청첩영상 #부모님감사영상 #프로포즈
							</div>
							<div class="meta clearfix">
								<div class="pull-left"><span class="label bg_red">웨딩</span></div>
								<div class="pull-right">
									<strong class="color_red"></strong>
								</div>
							</div>
						</div>
					</div>
				</li>

				<li class="col-sm-6 col-xs-12 itm">
					<div>
						<a href="/product/lists/?cate_id=1">
							<img class="img-responsive" src="https://d359hdvta3sq5o.cloudfront.net/resources/mobile/main/c1.gif?_=v" alt="BABY&KIDS">
						</a>
						<div class="cnt_wrp">
							<h4><a href="<?=Base_url()?>product/detail/">BABY&KIDS</a></h4>
							<div class="summary">
								#성장동영상 #유치원
							</div>
							<div class="meta clearfix">
								<div class="pull-left"><span class="label bg_red">성장동영상</span></div>
								<div class="pull-right">
									<strong class="color_red"></strong>
								</div>
							</div>
						</div>
					</div>
				</li>
				<li class="col-sm-6 col-xs-12 itm">
					<div>
						<a href="/product/lists/?cate_id=2">
							<img class="img-responsive" src="https://d359hdvta3sq5o.cloudfront.net/resources/mobile/main/c2.gif?_=v" alt="LOVE">
						</a>
						<div class="cnt_wrp">
							<h4><a href="<?=Base_url()?>product/detail/">LOVE</a></h4>
							<div class="summary">
								#고백 #곰신.군대 #영상편지 #연인기념일
							</div>
							<div class="meta clearfix">
								<div class="pull-left"><span class="label bg_red">러브레터</span></div>
								<div class="pull-right">
									<strong class="color_red"></strong>
								</div>
							</div>
						</div>
					</div>
				</li>

				<li class="col-sm-6 col-xs-12 itm">
					<div>
						<a href="/product/lists/?cate_id=4">
							<img class="img-responsive" src="https://d359hdvta3sq5o.cloudfront.net/resources/mobile/main/c4.gif?_=v" alt="BIRTHDAY">
						</a>
						<div class="cnt_wrp">
							<h4><a href="<?=Base_url()?>product/detail/">BIRTHDAY</a></h4>
							<div class="summary">
								#생신 결혼기념일# #생일 #추모 #졸업 #가족
							</div>
							<div class="meta clearfix">
								<div class="pull-left"><span class="label bg_red">기념일</span></div>
								<div class="pull-right">
									<strong class="color_red"></strong>
								</div>
							</div>
						</div>
					</div>
				</li>
				<li class="col-sm-6 col-xs-12 itm">
					<div>
						<a href="/product/lists/?cate_id=5">
							<img class="img-responsive" src="https://d359hdvta3sq5o.cloudfront.net/resources/mobile/main/c5.gif?_=v" alt="TAVEL">
						</a>
						<div class="cnt_wrp">
							<h4><a href="<?=Base_url()?>product/detail/">TRAVEL</a></h4>
							<div class="summary">
								#여행 #허니문
							</div>
							<div class="meta clearfix">
								<div class="pull-left"><span class="label bg_red">여행</span></div>
								<div class="pull-right">
									<strong class="color_red"></strong>
								</div>
							</div>
						</div>
					</div>
				</li>
				<li class="col-sm-6 col-xs-12 itm">
					<div>
						<a href="/product/lists/?cate_id=6">
							<img class="img-responsive" src="https://d359hdvta3sq5o.cloudfront.net/resources/mobile/main/c6.gif?_=v" alt="D-CARD">
						</a>
						<div class="cnt_wrp">
							<h4><a href="<?=Base_url()?>product/detail/">D-CARD</a></h4>
							<div class="summary">
								#크리스마스 #신년카드 #송년회
							</div>
							<div class="meta clearfix">
								<div class="pull-left"><span class="label bg_red">카드</span></div>
								<div class="pull-right">
									<strong class="color_red"></strong>
								</div>
							</div>
						</div>
					</div>
				</li>
				<li class="col-sm-6 col-xs-12 itm">
					<div>
						<a href="/product/lists/?cate_id=7">
							<img class="img-responsive" src="https://d359hdvta3sq5o.cloudfront.net/resources/mobile/main/c7.gif?_=v" alt="BUSINESS">
						</a>
						<div class="cnt_wrp">
							<h4><a href="<?=Base_url()?>product/detail/">BUSINESS</a></h4>
							<div class="summary">
								#홍보 #SNS
							</div>
							<div class="meta clearfix">
								<div class="pull-left"><span class="label bg_red">홍보</span></div>
								<div class="pull-right">
									<strong class="color_red"></strong>
								</div>
							</div>
						</div>
					</div>
				</li>
			</ul>
		</div>
			</section>
			<section id="sect3" class="row pa60 pa25-xs bg_wh text-center">
				<img class="img-responsive center-block mt60 mb60 mt30-xs mb30-xs" src="<?=PATH3?>img/index/section3.png" alt="">
				<h1 class="h1">더데이즈 무비메이커 사용방법 동영상보기</h1>
				<h2 class="h2 ">쉽고 간편한 무비메이커 4분 완전정복! <br>1번만 보면 세상을 바꿀 수 있습니다.</h2>
				<div class="pl50 pr60 pt15 pb25">
					<a class="btn btn-sm btn-block" href="/main/menual">동영상 보기</a>
				</div>
			</section>
			<section id="sect5" class="row pa60 pa25-xs text-center color_wh">
				<img class="img-responsive center-block mt60 mb60 mt30-xs mb30-xs" src="<?=PATH3?>img/index/section5.png" alt="" style="height:80px">
				<h1 class="h1">헬퍼서비스</h1>
				<h2 class="h2" style="">직접 제작하기 번거롭다고요, <br>급하게 1시간이내에 제작해서 이벤트하고 싶다면?</h2>
				<div class="pl50 pr60 pt15 pb25">
					<a class="btn btn-sm btn-block" href="/main/helper">신청하기</a>
				</div>
			</section>
			<!-- section id="sect6" class="row pa60 pa25-xs bg_wh text-center">
				<h1 class="h1">모든기기에서 동영상 시청이 가능하며 <br>공유도 가능합니다.</h1>
				<h2 class="h2 color_grey">컴퓨터, 스마트폰, 태블릿, TV, 극장상영을 통해 <br>연인, 가족, 친구들과 함께 동영상을 공유하세요</h2>
				<img class="img-responsive center-block" src="<?=PATH3?>img/index/section6.png" alt="">
				<div class="pl50 pr60 pt15 pb25">
					<a class="btn btn-sm btn-block" href="">APP 다운로드</a>
				</div>
			</section -->
			<section id="sect7" class="row pa50 pa25-xs text-center color_wh">
				<h1 class="h1 fw500">고품질 동영상의 중심지로 <br>당신을 초대합니다.</h1>
				<div class="pl50 pr60 pt15 pb25">
					<a class="btn btn-sm btn-block btn_wh" href="/auth/regster">회원가입</a>
					<a class="btn btn-sm btn-block bg_red" href="/auth/login">로그인</a>
				</div>
			</section>
		</div>
		<!-- //페이지 끝-->
	</div>
	<!-- //container -->
