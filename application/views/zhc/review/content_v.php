	

<!DOCTYPE html>
<!--[if lt IE 9]><html class="old-ie" lang="ko"><![endif]-->
<!--[if gte IE 9 | !IE]><!-->
<html lang="ko">
<!--<![endif]-->
<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>:: The Days ::</title>
    
    <link rel="shortcut icon" href="http://thedays.co.kr:80/resources/images/fivicon.ico" />
    
	<link rel="stylesheet" type="text/css" href="http://thedays.co.kr:80/resources/css/global.css" />
	<script type="text/javascript" src="http://thedays.co.kr:80/resources/scripts/libs/modernizr.custom.js"></script>
	<!--[if lt IE 9]><script type="text/javascript" src="http://thedays.co.kr:80/resources/scripts/libs/IE9.js"></script><![endif]-->
	<link href="/assets/css/bootstrap.css" rel="stylesheet" />
	
	<link rel="stylesheet" href="/assets/css/common.css">
	    <script src="http://code.jquery.com/jquery-1.9.0.js"></script>
	<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
	
	<script src="/assets/js/html5.js"></script>
	<script src="/assets/js/respond.min.js"></script>
	
	
	
	
	
	
	
	<script type="text/javascript" src="/resources/scripts/common.js?_=201408131036"></script>
	<script type="text/javascript" src="/resources/scripts/LayerMask.js"></script>
	<script type="text/javascript" src="/resources/scripts/common_func.js"></script>
	<script type="text/javascript" src="/resources/scripts/thedays.js"></script>
	<script type="text/javascript" src="/resources/scripts/thedays_ui.js"></script>
	
	
	
	<script type="text/javascript">
		var baseUrl = "http://thedays.co.kr:80";
		var requestUri = "http://thedays.co.kr/main";
		var backUrl = "http://thedays.co.kr/main";
	</script>
	
	<script>
	  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
	  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
	  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
	  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
	
	  /* ga('create', 'UA-47543725-1', 'thedays.co.kr');
	  ga('send', 'pageview'); */
	  
	  ga('create', 'UA-53568586-1', 'auto');
	  ga('send', 'pageview');
	</script>
	
	<style>
		.hide { display: none; }
		form { display:inline; }
	</style>


	<script src="//wcs.naver.net/wcslog.js"></script>
<link rel="stylesheet" type="text/css" href="/resources/css/products.css" />
	<script type="text/javascript">
		$(document).ready(function(){
			var categoryId = "";
			if( categoryId != "" ){
				categoryId = Number(categoryId);
				$("#priMenu li").eq( categoryId-1 ).addClass("on");
			}
			
			var pageType = "birthday";
			if( pageType == "love" )
				$("#page").addClass("propose");
			else
				$("#page").addClass("birthday");
			
			
			$(".page-size ul li").click(function(){
				var limit = ($(this).index()+1) * 12;
				//location.href = "/product/products/4?limit=" + limit;
				$("#limit").val(limit);
				$("#searchForm").submit();
			});
			
			$("#orderOption a").click(function(){
				$("#orderByType").val($(this).data().type);
				$("#searchForm").submit();
			});
			
			$(".viewBtn").click(function(){
				$("#searchForm").attr("action", "/product/" + $(this).data().id );
				$("#searchForm").submit();
			});
			
			$(".orderBtn").click(function(){
				addOrderItem( $(this).data().id );
			});
			
			$(".cartBtn").click(function(){
				var data = $(this).data();
				var params = {
					"productId": data.pid, "categoryId": data.cid
				};
				addCart(params);
			});			
			
		});
	</script>

	<script>
		if(!wcs_add) var wcs_add = {};
		wcs_add["wa"] = "s_67eaac32558";
		if (!_nasa) var _nasa={};
		wcs.inflow();
	</script>
</head>

<body>
	<a id="top"></a>
	<div id="page">
		<form id="gSearchForm" method="get" action="/search">
		<input type="hidden" name="searchText" />
	</form>

	<div id="headerWrap">
		<header id="branding">
			<h1 class="ci"><a href="<?=REAL_URL?>/index.html"><img src="<?=REAL_URL?>/resources/images/global/header_logo.gif" alt="the days" /></a></h1>
			
			<div id="globalUtil">
				<ul id="globalMenu">
					<!-- li class="first"><a href="/member/login.html">로그인</a></li -->
						
						<li><a href="<?=REAL_URL?>/member/regist/step1.html">회원가입</a></li>
						<li><a href="<?=REAL_URL?>/myPage/index.html">마이페이지</a></li>
					<li><a href="<?=REAL_URL?>/customer/index.html">고객센터</a></li>
					</ul>
				<section id="globalSearch">
					<label for="gSearch" class="screen-reader-text">search</label>
					<input type="text" id="gSearch" />
					<input type="image" src="<?=REAL_URL?>/resources/images/global/header_btn_search.gif" alt="검색" id="gSearchBtn" />
				</section>
			</div><!-- #globalUtil -->
			
			<nav id="priMenu">
				<ul>
					<li><a href="<?=REAL_URL?>/product/products/1" class="ir n0">Baby &amp; Kids</a></li>
					<li><a href="<?=REAL_URL?>/product/products/2" class="ir n1">Propose</a></li>
					<li><a href="<?=REAL_URL?>/product/products/3" class="ir n2">Wedding</a></li>
					<li><a href="<?=REAL_URL?>/product/products/4" class="ir n3">My Pet</a></li>
					<li><a href="<?=REAL_URL?>/product/products/5" class="ir n4">Travel</a></li>
					<li><a href="<?=REAL_URL?>/product/products/6" class="ir n5">The Moment</a></li>
				</ul>
			</nav><!-- #priMenu -->
			
			<div id="qMenu">
				<ul>
					<li class="active"><a href="<?=REAL_URL?>/customer/userManual.html">사용메뉴얼</a></li>
					<li><a href="<?=REAL_URL?>/event/index.html">이벤트</a></li>
					<li><a href="https://www.google.com/intl/ko/chrome/browser/features.html" target="_blank">크롬 설치</a></li>
				</ul>

				<div class="qimg">
					<span class="arrow"></span>
					<img src="<?=REAL_URL?>/resources/images/global/menuIcon_0.gif" alt="" />
				</div>
			</div>	
			
			<!-- <ul id="etcMenu">
				<li>
					<a href="/event/index.html"><img src="/resources/images/global/header_btn_event.gif" alt="이벤트" /></a>
				</li>
				<li>
					<a href="/customer/userManual.html"><img src="/resources/images/global/header_btn_manual.gif" alt="사용메뉴얼" /></a>
				</li>
			</ul> -->
		</header><!-- #branding -->
	</div>
	<!-- #container -->
	

<!-- 페이지 시작-->

<div id="review" class="row side_page w1140">
	<h1 class="sub_hd">
		<?=$review_info['title'] ?>
	</h1>
		
	<div class="input_review">						
		<!-- 리뷰 보기 에서만 나타남 -->
		<table class="table">
			<tbody><tr>
				<th scope="row">평점</th>
				<td><span class="rating rating-<?=$review_info['score'] ?>"></span></td>
				<th scope="row">작성자</th>
				<td><?=$review_info['memberName'] ?></td>
			</tr>
			<tr>
				<th scope="row">조회수</th>
				<td><?=$review_info['viewCount'] ?></td>
				<th scope="row">작성일</th>
				<td><?=date('Y-m-d', strtotime($review_info['createDatetime'])) ?></td>
			</tr>
		</tbody></table>
	</div>

	<!-- 카테고리 선택 -->
	<!-- 리뷰 리스트에서 글 쓰기로 들어 왔을 경우 -->	
	

	<!-- 1. 수정 하기 2. 글쓰기 에서는 textarea 3. 보기에는 div -->
	<div class="row">
		<div class="col-xs-12 mt15">
			<!-- textarea rows="8" cols="100" class="form-control icon-textarea" style="width:100%"></textarea -->
			<div class="" style="min-height:300px; display: inline-block;">
				<?=nl2br($review_info['content'])?>
				<?
						if ($review_info['fileName'])
							echo '<br /><img  style="max-width: 400px" src="' . REAL_URL . 'resources/uploads/review/' . $review_info["fileName"] . '">';
 				?>
				
			</div>
		</div>		
		<!--
			* 해당 권한이 있을 경우 버튼이 노출 됨. 아니면 노출 안됨
		 * case 1 수정 
		 * 수정 일때는 수정 버튼 , 삭제 버튼
		 * case 2 뷰
		 * 수정 버튼, 삭제 버튼 
		 * case 3 글쓰기
		 * 쓰기 버튼	
		-->
		<!-- div class="col-xs-12 btn_group pt10 pb10 text-right">
			
			<a href="/review/modify/<?=$review_info['id']?>" class="btn btn_blk  w80 mb5">수정</a>
			<a href="javascript:review_del(<?=$review_info['id']?>);"  class="btn btn_blk  w80 mb5">삭제</a>
			<a href="/review/write/<?=$review_info['id']?>" class="btn btn_blk  w80 mb5" style="color: ##DA4A61;">글쓰기</a>
		</div -->
	</div>
	
</div>

<div style="padding-bottom: 100px;"></div>

<form action="" method="get" id="form_page">
	<input type="hidden" name="cate_id" id="cate_id" value="0" />
</form>




<div id="footerWrap">
		<footer id="colophon">
			<a href="#top" class="topBtn"><img src="<?=REAL_URL?>/resources/images/global/footer_btn_top.gif" alt="top"></a>
			<div class="top">
				<p class="txt"><img src="<?=REAL_URL?>/resources/images/global/footer_txt.gif" alt="for the new yesterday!"></p>
				<ul class="footerPri">
					<li><a href="<?=REAL_URL?>/product/products/1" class="ir n0">Baby &amp; Kids</a></li>
					<li><a href="<?=REAL_URL?>/product/products/2" class="ir n1">Propose</a></li>
					<li><a href="<?=REAL_URL?>/product/products/3" class="ir n2">Wedding</a></li>
					<li><a href="<?=REAL_URL?>/product/products/4" class="ir n3">My Pet</a></li>
					<li><a href="<?=REAL_URL?>/product/products/5" class="ir n4">Travel</a></li>
					<li><a href="<?=REAL_URL?>/product/products/6" class="ir n5">The Moment</a></li>
				</ul>
			</div><!-- .top -->
			
			<div class="side">
				<section class="newsletter">
					<h3>
						<img src="<?=REAL_URL?>/resources/images/global/footer_hd_newsletter.gif" alt="newsletter!">
						더데이즈 뉴스레터를 신청하세요!
					</h3>
					<div class="inputBox">
						<label for="emailInput" class="screen-reader-text">email 입력</label>
						<input type="text" id="emailInput">
						<input id="newsLetterBtn" type="image" src="<?=REAL_URL?>/resources/images/global/footer_btn_newsletter.gif" alt="신청" onclick="return false;">
					</div>
				</section>
				<section class="call">
					<img src="<?=REAL_URL?>/resources/images/global/footer_cs.gif" alt="고객센터 대표전화: 02-562-3618, 평일 9:00~18:00, 토요일 9:00~13:00, 일/공휴일 휴무">
				</section>
			</div><!-- .side -->
			
			<div class="bottom">
				<a href="http://thedays.co.kr:80" class="ci"><img src="<?=REAL_URL?>/resources/images/global/footer_logo.gif" alt="thedays"></a>
				<ul class="links">
					<li><b><a href="<?=REAL_URL?>/company/introduce.html">회사소개</a>&nbsp;&nbsp;|&nbsp;</b></li>
					<li><b><a href="<?=REAL_URL?>/company/policy.html">이용약관</a>&nbsp;&nbsp;|&nbsp;</b></li>
					<li><b><a href="<?=REAL_URL?>/company/privacy.html">개인정보보호방침</a>&nbsp;&nbsp;|&nbsp;</b></li>
					<li><b><a href="<?=REAL_URL?>/company/partner.html">협력/제휴</a></b></li>
				</ul>
				<div class="siteInfo">
					(우 157-804 ) 서울특별시 강서구 양천로 551-24, 506호 (가양동, 한화비즈메트로 2차)<br>
					상호명: 주식회사 위드비디오&nbsp;&nbsp;|&nbsp;&nbsp;대표이사  최옥현, 이상교<br>
					통신판매업신고  제2015-서울강서-0574  &nbsp;&nbsp;|&nbsp;&nbsp;사업자등록번호 771-87-00082<br>								
					고객센터 : 02.562.3618&nbsp;&nbsp;|&nbsp;fax : 02.3775.4100&nbsp;&nbsp;|&nbsp;
					<a href="mailto:cs@thedays.co.kr">cs@thedays.co.kr</a>&nbsp;&nbsp;|&nbsp;개인정보관리책임자 옥지현팀장<br>
					Copyright© 2013 - 2015 thedays All Rights Reserved. Contact webmaster for more information.
				</div>
			</div>
			
		</footer>
	</div>
	


	