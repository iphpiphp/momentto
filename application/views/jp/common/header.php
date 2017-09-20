<!DOCTYPE html>
<html lang="ko">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="format-detection" content="telephone=no">
<meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no">
<title>momentto</title>

<? $v = mt_rand(1,1000); ?>

<!-- css -->
<link rel="stylesheet" type="text/css" href="<?=ASSET_PATH?>jp/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="<?=ASSET_PATH?>jp/css/common.css">

<!-- js -->
<script src="<?=ASSET_PATH?>jp/js/jquery-3.1.1.min.js?_<?=$v?>"></script>
<script src="<?=ASSET_PATH?>jp/js/jquery-migrate-1.4.1.min.js?_<?=$v?>"></script>

<!-- js -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
<script src="<?=ASSET_PATH?>jp/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bxslider/4.2.12/jquery.bxslider.min.js"></script>

</head>


<body class="index"><a href="#ct" class="skip sr-only sr-only-focusable" onclick="jQuery('#ct a:first').focus();return false;">Skip to Content</a>

<!-- mobile menu -->
<div id="snb" class="side-nav">
	<section>
		<nav id="mGnb">
			<h3>ACCOUNT</h3>
			<ul>
				<li><a class="gnb-1" href="index.html">HOME</a></li>
				<li><a class="gnb-2" href="05_my_2.html">MY PAGE</a></li>
				<li><a class="gnb-3" href="04_cart_2.html">CART <b class="label">3</b></a></li>
			</ul>
			<h3>CATEGORY</h3>
			<ul>
				<li><a class="gnb-4" href="/product/lists/?cate_id=1">OPENING</a></li>
				<li><a class="gnb-5" href="/product/lists/?cate_id=2">PROFILE</a></li>
				<li><a class="gnb-6" href="/product/lists/?cate_id=3">END ROLL</a></li>
				<li><a class="gnb-7" href="/product/lists/?cate_id=4">LETTER</a></li>
				<li><a class="gnb-8" href="/product/lists/?cate_id=5">PROPOSE</a></li>
			</ul>
			<h3 class="mb0" ></h3>
			<ul>
				<li><a class="gnb-9" href="12_agreement_2.html">FAQ</a></li>
				<li><a class="gnb-10" href="09_oneone_2.html">1:1</a></li>
				<li><a class="gnb-11" href="14_event.html">EVENT</a></li>
			</ul>
		</nav>
		<div class="snb-acc">
			<div class="col-xs-6">
				<a href="06_login.html">LOGIN</a>
			</div>
			<div class="col-xs-6">
				<a href="07_join.html">SIGN UP</a>
			</div>
			<div class="col-xs-12">
				<a class="bg-primary" href="15_making.html"><i class="icon-movie"></i> 作る方法を学ぶ</a>
			</div>
		</div>
	</section>
</div>
<!-- mobile menu -->

<div id="wrap">
	<!-- Header -->
	<header id="hd" class="visible-md-block visible-lg-block">
		<div class="hd-top">
			<div class="container">
				<a href="14_event.html">EVENT</a> <i class="split"></i>
				<a href="15_making.html">作る方法を学ぶ</a> <i class="split"></i>
				<div class="dropdown">
					<a href="javascript:;" data-toggle="dropdown">MY PAGE</a> <i class="split"></i>
					<div class="dropdown-menu my-drop">
						<div class="user-info">
							<div class="name">Hyoung Ju Kim</div>
							<span>쿠폰 3장</span><i class="split"></i><span>적립금 9700円</span>
						</div>
						<ul class="row my-link">
							<li class="col-xs-6"><a href="04_cart_2.html">장바구니</a></li>
							<li class="col-xs-6"><a href="05_my_4.html">쿠폰등록</a></li>
							<li class="col-xs-6"><a href="05_my_6.html">취소 및 환불</a></li>
							<li class="col-xs-6"><a href="05_my_2.html">회원정보 수정</a></li>
							<li class="col-xs-6"><a href="">상품후기</a></li>
							<li class="col-xs-6"><a href="">상품문의</a></li>
							<li class="col-xs-6"><a href="09_oneone.html">일대일문의</a></li>
							<li class="col-xs-6"><a href="">로그아웃</a></li>
						</ul>
					</div>
				</div>
				<a href="06_login.html">LOGIN</a> <i class="split"></i>
				<a href="07_join.html">SIGN UP</a>
				<div class="dropdown link-cart-wrp">
					<a class="link-cart" href="javascript:;" data-toggle="dropdown"><span class="sr-only">Cart</span><b class="label">3</b></a>
					<div class="dropdown-menu my-drop cart-drop">
						<ul>
							<li>
								<a class="clse" href="#">&times;<span class="sr-only">close</span></a>
								<a class="media" href="">
									<div class="media-left">
										<img src="<?=ASSET_PATH?>jp/img/_temp/tmb.png" alt="">
									</div>
									<div class="media-body">
										<h4>LOVE LOVE LOVE</h4>
										<span class="color-primary">profile</span>
									</div>
								</a>
							</li>
							<li>
								<a class="clse" href="#">&times;<span class="sr-only">close</span></a>
								<a class="media" href="">
									<div class="media-left">
										<img src="<?=ASSET_PATH?>jp/img/_temp/tmb.png" alt="">
									</div>
									<div class="media-body">
										<h4>LOVE LOVE LOVE</h4>
										<span class="color-primary">profile</span>
									</div>
								</a>
							</li>
							<li>
								<a class="clse" href="#">&times;<span class="sr-only">close</span></a>
								<a class="media" href="">
									<div class="media-left">
										<img src="<?=ASSET_PATH?>jp/img/_temp/tmb.png" alt="">
									</div>
									<div class="media-body">
										<h4>LOVE LOVE LOVE</h4>
										<span class="color-primary">profile</span>
									</div>
								</a>
							</li>
						</ul>
						<p>* 최근 담은 순으로 5개까지 보여집니다.</p>
					</div>
				</div>
			</div>
		</div>
		<div class="header container">
			<h1 class="logo"><a href="index.html"><span class="sr-only">momentto</span><img src="<?=ASSET_PATH?>jp/img/logo.png" alt=""> 驚くほど簡<span class="color-primary">単かつ迅速オ</span>ンラインムービーメーカー</a></h1>
			<nav id="gnb">
				<ul>
					<li><a class="icon-gnb1" href="/product/lists/?cate_id=1">OPENING</a></li>
					<li><a class="icon-gnb2" href="/product/lists/?cate_id=2">PROFILE</a></li>
					<li><a class="icon-gnb3" href="/product/lists/?cate_id=3">END ROLL</a></li>
					<li><a class="icon-gnb4" href="/product/lists/?cate_id=4">LETTER</a></li>
					<li><a class="icon-gnb5" href="/product/lists/?cate_id=5">PROPOSE</a></li>
				</ul>
			</nav>
		</div>
	</header>
	<!-- 모바일 -->
	<header id="mHd" class="visible-sm-block visible-xs-block">
		<h1><a href="index.html"><span class="sr-only">momentto</span><img class="img-responsive" src="<?=ASSET_PATH?>jp/img/logo_m.png" alt=""></a></h1>
		<a href="#snb" class="icon-mn" onclick="menuOpen('snb');return false;">메뉴열기/닫기</a>
	</header>
	<!-- //Header -->

	<!-- Container -->
	<div id="container">