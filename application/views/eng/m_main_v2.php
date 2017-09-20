<?
	
	$display = "display: none";
	$exchange = exchange("USD"); 
?>
	<div id="container" class="clearfix">

<!-- 페이지 시작-->

<div id="index">
	<section id="sect1" class="row mb15 pa0">
		<h2 class="sr-only">promotion</h2>
		<!-- 메인 슬라이드 -->
		<div id="slider">
			<ul>
				<? foreach ($bnr_list as $key => $val) : ?>						
				<li>
					<a href="<?=$val['link']?>">
						<!-- div class="cap" style="position: absolute; top:<?=$val['top']?>; left: <?=$val['left']?>; font-size: <?=$val['font_size']?>; color: <?=$val['font_color']?>; "><?=$val['content']?></div -->								
						<img class="img-responsive center-block" src="/uploads/main_bnr/<?=$val['zmb_filename']?>" alt="<?=$val['zmb_alt']?>" >
					</a>
				</li>
				<? endforeach; ?>
				<!--li><img class="img-responsive center-block" src="/assets/img/index/slide2.jpg" alt=""></li -->
				
			</ul>
		</div>
		<!-- login -->
		<div class="main_login_bx text-center" style="<?=$this->session->userdata['email']? $display : '' ?>">			
			<form class="mb15"  action="/auth/login_chk" method="post">
				<div>
					<input type="text" name="email" class="form-control input-lg" placeholder="이메일을 입력하세요">
				</div>
				<div class="mb15">
					<input type="password" name="password" class="form-control input-lg" placeholder="비밀번호를 입력하세요">
				</div>
				<div>
					<button type="submit" class="btn btn-lg btn-block bg_red">로그인</button>
				</div>
				<div class="mt15">
					<a class="" href="/auth/regster"><u>회원가입</u></a>
					<p class="mt10 color_blue">회원 가입하시면 무료 체험하실 수 있습니다.</p>
				</div>
			</form>
			<!-- a class="btn btn-lg btn-block bg_blue" href="/auth/sns_login?type=FB"><i class="fa fa-facebook mr5"></i> 페이스북으로 회원가입</a>
			<p class="mt10 color_grey">theDays에 가입함으로써 theDay의 서비스 약관 및 개인 정보보호정책에 동의하게 됩니다.</p -->
		</div>
		<div class="col-xs-12">
			<ul id="indexTab" class="nav nav-pills nav-justified">
				<li><a href="/main/menual"><i class="icon_indextab_1"></i>사용 메뉴얼</a></li>
				<li><a href="/main/experience"><i class="icon_indextab_2"></i> 체험하기</a></li>
				<li><a href="/review/lists/"><i class="icon_indextab_3"></i>리뷰</a></li>
				<li><a href="/main/helper"><i class="icon_indextab_4"></i>헬퍼 서비스</a></li>
			</ul>
		</div>
		<script>
		jQuery(function($){
			$('#slider>ul').bxSlider({
				speed:1000,
				controls:false
			});
		});
		
		$(document).ready(function () {

//카테고리 클릭
	$(".category_tab > li > a").click(function(){		
		var cate = $(this).attr("item");
		var keyword = "";
		var i = $("#i").val();
		
		if(cate != 'keyword'){
			$(".category_tab > li > a").attr("class","");
			$(this).attr("class","on");
			$("#key_head").attr("class","keyword_tg collapsed");
			$(".main_card > li").remove();
			
			
			$('body, html').animate({ scrollTop: $("#indexTab").offset().top }, 1000); 
			$(".main_card ").load("/main/main_list_html/"+cate+"/"+i+"/"+keyword);
			
			
		}		
	});
	//키워드 클릭
	$(".keyword_tag").click(function(){	
		
		var cate = 'all';
		var keyword = $(this).attr("item");
		var i = 1;
		
		$(".category_tab > li > a").attr("class","");
		$("#cate_head").attr("class","on");
		$("#key_head").attr("class","keyword_tg collapsed");
			
		$(".main_card > li").remove();
		$('body, html').animate({ scrollTop: $("#indexTab").offset().top }, 1000);
		$(".main_card ").load("/main/main_list_html/"+cate+"/"+i+"/"+keyword);
		
	});
});
		</script>
	</section>
	<section id="sect2" class="row pb20">
		<h2 class="sr-only">item</h2>
		<!-- 카테고리탭 -->
		<ul class="category_tab clearfix">
			<li><a class="keyword_tg collapsed" href="#keyword"  data-toggle="collapse" item="keyword" id="key_head">키워드 <i class="glyphicon glyphicon-menu-up"></i></a></li>
			<li><a class="on" href="#" item="all" id="cate_head">ALL</a></li>
			<li><a href="#" item="1">BABY&amp;KIDS</a></li>
			<li><a href="#" item="2">LOVE</a></li>
			<li><a href="#" item="3">WEDDING</a></li>
			<li><a href="#" item="4">BIRTHDAY</a></li>
			<li><a href="#" item="5">TRAVEL</a></li>						
			<li><a href="#" item="6">D-CARD</a></li>		
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
		<!-- 아이템 목록 -->
		<div class="lst">
			<ul class="row main_card">
				<? $i=1; foreach($product_list as $key => $val): ?>
				<li class="col-sm-6 col-xs-12 itm">					
					<div>
						<a href="/product/detail/<?=$val['id']?>">
							<!-- img class="img-responsive" src="<?=PATH2?>_temp/tmb.jpg" alt="" -->
							<img class="img-responsive" src="<?=IMG_O_PATH.$val['imagePath']."/".$val['imageLFile']?>" alt="" item="<?=$val['movieVimeoId']?>">
						</a>
						<div class="cnt_wrp">
							<h4><a href="<?=Base_url()?>product/detail/<?=$val['id']?>"><?=$val['name']?></a></h4>
							<div class="summary">
								<?=$val['keyword']?>
							</div>
							<div class="meta clearfix">
								<div class="pull-left"><span class="label bg_red"><?=$val['tag']?></span></div>
								<div class="pull-right">
									<? 
													$price = $val['price'];
													if($val['eventPrice']>0)$price =$val['eventPrice']; 
													$USD = $val['usd'];
									?>
									<strong class="color_red">￦<?=number_format($price)?>  /  ($<?=$USD?>)</strong>
								</div>
							</div>
						</div>
					</div>
				</li>
				<? endforeach; ?>
				
			</ul>
		</div>
	</section>
	<section id="sect3" class="row pa60 pa20-xs bg_wh text-center">
		<img class="img-responsive center-block mt60 mb60 mt30-xs mb30-xs" src="<?=PATH2?>img/index/section3.png" alt="">
		<h1 class="h1 fs16">더데이즈 무비메이커 사용방법 동영상보기</h1>
		<h2 class="h2 fs11 color_grey">쉽고 간편한 무비메이커 4분 완전 정복!!! 정말 쉬워요!!! 1번만 보면 세상을 바꿀 수 있습니다.</h2>
		<div class="pa30 pt15">
			<a class="btn btn-md btn-block" href="/main/menual">동영상 보기</a>
		</div>
	</section>
	<section id="sect4" class="row pa60 pa20-xs text-center">
		<img class="img-responsive center-block mt30 mb30" src="<?=PATH2?>img/index/section4.png" alt="">
		<h1 class="h1 fs16">더데이즈 무비메이커 체험하기</h1>
		<h2 class="h2 fs11 color_grey">사진만 준비되면 5분~10분이내 나만의 영상 완성, 제2의 기록물이 될 것입니다.</h2>
		<div class="pa30 pt15">
			<a class="btn btn-md btn-block" href="javascript:;" onclick="experienceMovieMaker('https://s3-ap-northeast-1.amazonaws.com/thedays-preset/exp/index.html')">체험하기</a>
			
		</div>
	</section>
	<section id="sect5" class="row pa60 pa20-xs text-center color_wh">
		<img class="img-responsive center-block mt60 mb60 mt30-xs mb30-xs" src="<?=PATH2?>img/index/section5.png" alt="">
		<h1 class="h1">헬퍼서비스</h1>
		<h2 class="h2" style="opacity:.6">직접 제작하기 번거롭다고요, 급하게 1시간이내에 제작해서 이벤트하고 싶다면?</h2>
		<div class="pa30 pt15">
			<a class="btn btn-md btn-block" href="/main/helper/">신청하기</a>
		</div>
	</section>
	<section id="sect6" class="row pa60 pa20-xs bg_wh text-center">
		<h1 class="h1 fs16"><strong>모든기기에서 동영상 시청이 가능하며 공유도 가능합니다.</strong></h1>
		<h2 class="h2 fs11">컴퓨터, 스마트폰, 태블릿, TV, 극장상영을 통해 연인, 가족, 친구들과 함께 동영상을 공유하세요</h2>
		<img class="img-responsive center-block" src="<?=PATH2?>img/index/section6.png" alt="">
	</section>
	<section id="sect7" class="row pa60 pa20-xs text-center color_wh" style="<?=$this->session->userdata['email']?  $display : "display:block" ?>">
		<h1 class="h1 fs16"><strong>고품질 동영상의 중심지로 당신을 초대합니다.</strong></h1>
		<div class="row pa40 pa20-xs">
			<div class="col-xs-6 pr2">
				<a class="btn btn-sm btn-block btn_wh" href="/auth/regster">회원가입</a>
			</div>
			<div class="col-xs-6 pl2">
				<a class="btn btn-sm btn-block bg_red" href="/auth/login">로그인</a>
			</div>
		</div>
	</section>
</div>

<!-- //페이지 끝-->

	</div>
	<!-- //container -->

	