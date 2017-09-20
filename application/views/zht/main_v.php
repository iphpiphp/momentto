<?
	
	$display = "display: none";
	$exchange = exchange("USD"); 
?>
<script language="JavaScript">
function scrollMove(t,h){
	"use strict";
	if(h===undefined){
		h=0;
	}
	var o = $('body');
	if(navigator.userAgent.toLowerCase().match(/trident/i)){
		o = $('html');
	}
	o.animate({
		scrollTop:$(t).offset().top-h
	},500);
}

// Menu Open
function menuOpen(o){
	"use strict";
	$('#wrap').after('<button type="button" id="sidebar_tg" onclick="menuClose();"><b class="sr-only">Close</b></button>');
	var a = -$(window).scrollTop();
	$('#'+o).show(0,function(){
		$('#sidebar_tg').addClass('in');
		$('body').addClass('nav_open '+o+'_open');
		$('#wrap').addClass('if_m').css('top',a);
	});
}

// Menu Close
function menuClose(o){
	"use strict";
	$('#sidebar_tg').removeClass('in');
	$('body').removeClass('snb_open');
	var originScroll = -$('#wrap').position().top;
	setTimeout(function(){
		$('div.side_nav').hide();
		$('body').removeClass('nav_open');
		$(window).scrollTop(originScroll);
		$('#wrap').removeClass('if_m').removeAttr('style');
		$('#sidebar_tg').remove();
	},500);
}
//

jQuery(function ($) {
	$('#slider>ul').bxSlider({
		speed: 1000,
		controls: false
	});
});

jQuery(function($){
	"use strict";
	var w = $(window);
	var $body = $('body');

// scroll
	w.scroll(function(){
		if(w.scrollTop()>85){
			$body.addClass('if_scroll');
		} else {
			$body.removeClass('if_scroll');
		}
	});



// input
	$body
	.on('click','label.radio_label>input',function(){
		var t = $(this);
		$('input[type=radio][name='+t.attr('name')+']').parent('label').removeClass('on');
		t.parent('label').addClass('on');
	})
	.on('click','label.agree_label>input',function(){
		var t = $(this);
		t.parent('label').toggleClass('on');
	});
});
</script>
<style>
.cap{font-family:'Nanum Barun Gothic','나눔바른고딕',nbg,NanumGothic,'나눔고딕',sans-serif}	
</style>

		<!-- #container -->
		<div id="container" class="clearfix">

			<!-- 페이지 시작-->

			<div id="index">
				<section id="sect1" class="row w1140 mb30 mb15-xs pa0-xs">
					<h2 class="sr-only">promotion</h2>
					<!-- 메인 슬라이드 -->
					<div id="slider" class="col-sm-8 col-xs-12">
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
					<div class="col-sm-4 col-xs-12 pa30 text-center" style="<?=$this->session->userdata['email']? $display : '' ?>">
						<form class="mb50 mb20-xs"  action="/auth/login_chk" method="post">
							<div class="mb10">
								<input type="text" name="email" class="form-control input-lg" placeholder="이메일을 입력하세요">
							</div>
							<div class="mb10">
								<input type="password" name="password" class="form-control input-lg" placeholder="비밀번호를 입력하세요">
							</div>
							<div class="mb10">
								<button type="submit" class="btn btn-lg btn-block bg_red">로그인</button>
							</div>
							<div class="mt15">
								<a href="/auth/regster"><u>회원가입</u></a>
								<p class="mt10">회원 가입하시면 무료 체험하실 수 있습니다.</p>
							</div>
						</form>
						<a class="btn btn-lg btn-block bg_blue" href="/auth/sns_login?type=FB"><i class="fa fa-facebook mr20"></i>페이스북 계속하기</a>
						<p class="mt10">thedays에 가입함으로써 thedays의 서비스 약관 및 개인 정보보호정책에 동의하게 됩니다.</p>
					</div>
					<!-- login true -->
					<div class="col-sm-4 col-xs-12 text-center account" style="<?=$this->session->userdata['email']?  "display:block" : $display ?>">
						<div class="row">
							<div class="col-sm-6 col-xs-4">
								<a href="/cart_lib/lists">
									<img src="/assets/img/ico/cart.png"  />
									<div style="margin-top:15px;">
										<b class="label bg_red"><?=$data1?></b>
										<h5>장바구니</h5>
									</div>
								</a>
							</div>
							<div class="col-sm-6 col-xs-4">
								<a href="/mypage/">
									<img src="/assets/img/ico/file.png" />
									<div style="margin-top:15px;">
										<b class="label bg_red"><?=$data2?></b>
										<h5>주문접수</h5>
									</div>
								</a>
							</div>
							<div class="col-sm-6 col-xs-4">
								<a href="/mypage/">
									<img src="/assets/img/ico/cash.png" />
									<div style="margin-top:15px;">
										<b class="label bg_red"><?=$data3?></b>
										<h5>결제완료</h5>
									</div>
								</a>
							</div>
							<div class="col-sm-6 col-xs-4">
								<a href="/mypage/">
									<img src="/assets/img/ico/tools.png" />
									<div style="margin-top:15px;">
										<b class="label bg_red"><?=$data4?></b>
										<h5>무비 진행중</h5>
									</div>
								</a>
							</div>
							<div class="col-sm-6 col-xs-4">
								<a href="/mypage/">
									<img src="/assets/img/ico/check.png" />
									<div style="margin-top:15px;">
										<b class="label bg_red"><?=$data5?></b>
										<h5>무비완료</h5>
									</div>
								</a>
							</div>
							<div class="col-sm-6 col-xs-4">
								<a href="/mypage/refund_app">
									<img src="/assets/img/ico/refresh.png" />
									<div style="margin-top:15px;">
										<b class="label bg_red"><?=$data6?></b>
										<h5>취소환불</h5>
									</div>
								</a>
							</div>
						</div>
					</div>
				
			<script>
	$(document).ready(function () {
    $(document).on("scroll", onScroll);
 });
function onScroll(event){
	var scrollPos = $(document).scrollTop();
    
    var sum = $('.lst').position().top;
    //$("#text").text(scrollPos+'__'+sum);
    //alert(scrollPos+'__'+sum);
    if(scrollPos >= sum){
    	
    	$(".keyword_coll").addClass("keyword-fixed-top-fix");
    	$(".category_tab").addClass("cate-fixed-top-fix");
    	
    	//$(".keyword_coll").css("margin-top","400px;");
    	
    }else{
    	    	
    	$(".keyword_coll").removeClass("keyword-fixed-top-fix");
    	$(".category_tab").removeClass("cate-fixed-top-fix");
    	
    	//$(".keyword_coll").css("margin-top","0px;");
    	
    }
    //alert($('#navbar_cate a').position().top);  

}
</script>		
					<div class="col-xs-12">
						<ul id="indexTab" class="nav nav-pills nav-justified">
							<li><a href="/main/menual"><i class="icon_indextab_1"></i>사용 메뉴얼</a></li>
							<li><a href="/main/experience"><i class="icon_indextab_2"></i> 체험하기</a></li>
							<li><a href="/review/lists/"><i class="icon_indextab_3"></i>리뷰</a></li>
							<li><a href="/main/helper"><i class="icon_indextab_4"></i>헬퍼 서비스</a></li>
						</ul>
					</div>					
				</section>
				<section id="sect2" class="row w1140 pb60">
					<h2 class="sr-only">item</h2>
					<!-- 카테고리탭 -->
					<ul class="category_tab clearfix " style="z-index: 90">
						<li><a class="keyword_tg collapsed" href="#keyword" data-toggle="collapse" item="keyword">키워드 <i class="glyphicon glyphicon-menu-up"></i></a></li>
						<li><a class="on" href="#" item="all">ALL</a></li>
						<li><a href="#" item="1">BABY&amp;KIDS</a></li>
						<li><a href="#" item="2">LOVE</a></li>
						<li><a href="#" item="3">WEDDING</a></li>
						<li><a href="#" item="4">BIRTHDAY</a></li>
						<li><a href="#" item="5">TRAVEL</a></li>						
						<li><a href="#" item="6">SALE</a></li>
						<li><a href="#" item="7">&nbsp;</a></li>
						<li><a href="#" item="8">&nbsp;</a></li>
					</ul>
					<!-- 키워드 -->
					<div class="collapse keyword_coll clearfix" id="keyword">
						<ul class="row ">
							<? foreach($keyword_list as $key => $val): ?>
								<li class="col-sm-3 col-xs-6"><a href="#" class="keyword_tag" item="<?=$val['tag_name']?>"><?=$val['tag_name']?></a></li>							
							<? endforeach; ?>
						</ul>
					</div>
					
					<!-- 아이템 목록 -->					
					<div class="lst">
						<ul class="row main_list">
							<? $i=1; foreach($product_list as $key => $val): ?>
							<li class="col-sm-4 col-xs-12 itm">
								<div>
									<a href="#">
										<div id="img_<? echo $i++; ?>" class="vimeo_play" style="min-height: 196px">
											<img class="img-responsive" src="<?=IMG_O_PATH.$val['imagePath']."/".$val['imageLFile']?>" alt="" item="<?=$val['movieVimeoId']?>">
											<div class="vimeo_play_movie"></div>
										</div>
									</a>
									<div class="cnt_wrp">
										<h4 style='width-min:220px; overflow:hidden;white-space:nowrap; text-overflow:ellipsis;'><a href="<?=Base_url()?>product/detail/<?=$val['id']?>"><b><?=$val['name']?></b></a></h4>
										<div class="summary">
											<?=$val['keyword']?>
										</div>
										<div class="meta clearfix">
											<div class="pull-left"><span class="label bg_red"><?=$val['tag']?></span></div>
											<div class="pull-right">
												<? 
													$price = $val['price'];
													if($val['eventPrice']>0)$price =$val['eventPrice']; 
													//$USD = round(($price/$exchange),2);
												?>
												최종가 <strong class="color_red">￦<?=number_format($price)?></strong>
											</div>
										</div>
									</div>
								</div>
							</li>
							<? endforeach; ?>
						</ul>					
					</div>
					
					<input type="hidden" id="page" 			value="1"	/>
					<input type="hidden" id="stay_cate" 	value=""	/>
					<input type="hidden" id="keyword" 		value=""	/>
					<input type="hidden" id="i" 			value="<?=$i?>"	/>
					
					<hr class="hr">
					<h2 class="h2 mt40 text-center">
						<img class="img-responsive center-block mb20" src="/assets/img/index/section2.png" alt="">뜨겁다 뜨거워~~  신규 제작물
					</h2>
					<!-- 아이템 목록 -->
					<div class="lst">
						<ul class="row">
							<? $i=1; foreach($product_list2 as $key => $val): ?>
							<li class="col-sm-4 col-xs-12 itm">
								<div>
									<a href="#">
										<div id="img_<? echo $i++; ?>" class="vimeo_play" >
											<img class="img-responsive" src="<?=IMG_O_PATH.$val['imagePath']."/".$val['imageLFile']?>" alt="" item="<?=$val['movieVimeoId']?>">
											<div class="vimeo_play_movie"></div>
										</div>
									</a>
									<div class="cnt_wrp">
										<h4><a href="<?=Base_url()?>product/detail/<?=$val['id']?>"><b><?=$val['name']?></b></a></h4>
										<div class="summary">
											<?=$val['keyword']?>
										</div>
										<div class="meta clearfix">
											<div class="pull-left"><span class="label bg_red"><?=$val['tag']?></span></div>
											<div class="pull-right">
												<? 
													$price = $val['price'];
													if($val['eventPrice']>0)$price =$val['eventPrice']; 
													$USD = round(($price/$exchange),2);
												?>
												
												
												최종가 <strong class="color_red">￦<?=number_format($price)?></strong>
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
					<img class="img-responsive center-block mt60 mb60 mt30-xs mb30-xs" src="/assets/img/index/section3.png" alt="">
					<h1 class="h1">더데이즈 무비메이커 사용방법 동영상보기</h1>
					<h2 class="h2 color_grey">쉽고 간편한 무비메이커 4분 완전 정복!!! 정말 쉬워요!!! 1번만 보면 세상을 바꿀 수 있습니다.</h2>
					<div class="pa40 pa20-xs">
						<a class="btn btn-lg w280" href="/main/menual">동영상 보기</a>
					</div>
				</section>
				<section id="sect4" class="row pa60 pa20-xs text-center">
					<img class="img-responsive center-block mt30 mb30 mt30-xs mb30-xs" src="/assets/img/index/section4.png" alt="">
					<h1 class="h1">더데이즈 무비메이커 체험하기</h1>
					<h2 class="h2 color_grey">사진만 준비되면 5분~10분이내 나만의 영상 완성, 제2의 기록물이 될 것입니다.</h2>
					<div class="pa40 pa20-xs">
						<a class="btn btn-lg w280" href="#" onclick="experienceMovieMaker('https://s3-ap-northeast-1.amazonaws.com/thedays-preset/exp/index.html')">체험하기</a>
					</div>
				</section>
				<section id="sect5" class="row pa60 pa20-xs text-center color_wh">
					<img class="img-responsive center-block mt60 mb60 mt30-xs mb30-xs" src="/assets/img/index/section5.png" alt="">
					<h1 class="h1">헬퍼서비스</h1>
					<h2 class="h2" style="opacity:.6">직접 제작하기 번거롭다고요, 급하게 1시간이내에 제작해서 이벤트하고 싶다면?</h2>
					<div class="pa40 pa20-xs">
						<a class="btn btn-lg btn_wh w280" href="/main/helper/">신청하기</a>
					</div>
				</section>
				<section id="sect6" class="row pa60 pa20-xs bg_wh text-center">
					<h1 class="h1"><strong>모든기기에서 동영상 시청이 가능하며 공유도 가능합니다.</strong></h1>
					<h2 class="h2">컴퓨터, 스마트폰, 태블릿, TV, 극장상영을 통해 연인, 가족, 친구들과 함께 동영상을 공유하세요</h2>
					<div class="pa40 pa20-xs">
						<!-- a class="btn btn-lg w280" href="javascript:alert('준비중입니다.');">APP 다운로드</a -->
					</div>
					<img class="img-responsive center-block" src="/assets/img/index/section6.png" alt="">
				</section>
				<section id="sect7" class="row pa60 pa20-xs text-center color_wh" style="<?=$this->session->userdata['email']?  $display : "display:block" ?>">
					<h1 class="h1"><strong>고품질 동영상의 중심지로 당신을 초대합니다.</strong></h1>
					<div class="pa40 pa20-xs">
						<a class="btn btn-lg btn_wh w280 mb10" href="/auth/regster">회원가입</a>
						<a class="btn btn-lg bg_red w280 mb10 ml5 ml0-xs" href="/auth/login">로그인</a>
					</div>
				</section>
			</div>

			<!-- //페이지 끝-->

		</div>
		<!-- //container -->