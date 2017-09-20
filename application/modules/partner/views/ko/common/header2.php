<!DOCTYPE html>
<html lang="ko">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no">
<title>the Days</title>

<!-- css -->
<link rel="stylesheet" href="<?=PATH2?>css/normalize.css">
<link rel="stylesheet" href="<?=PATH2?>css/bootstrap.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
<link rel="stylesheet" href="<?=PATH2?>css/jquery.bxslider.css">
<link rel="stylesheet" href="<?=PATH2?>css/common.css">
<link rel="stylesheet" href="<?=PATH2?>css/m.css">

<!-- js -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
<script src="<?=PATH2?>js/bootstrap.min.js"></script>
</head>

<body>
<a class="skip" href="#container">Skip to main content</a>

<!-- wrap.screenID -->
<div id="wrap" class="main">

	<!-- header -->
	<header id="hd">
		<div>
			<h1><a href="/"><img src="<?=PATH2?>img/logo.png" alt="logo">theDays</a></h1>
			<a class="icon_mn" href="#gnb" onClick="$(this).toggleClass('on');$('#gnb').toggle();return false;">메뉴</a>
			<!-- GNB -->
			<nav id="gnb">
				<ul>
					<li class="dropdown">
						<span>Language</span>
						<button type="button" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">한국어<span class="caret"></span></button>
						 <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenu1">
						 	<li><a href="#">한국어</a></li>
						 	<li><a href="#">English</a></li>
						</ul>
					</li>
					<? if($this->session->userdata['email']){?>
                        	<li class=""><a href="<?=Base_url()?>auth/logout">로그아웃</a></li>
	                    <? }else{ ?>
	                        <li class=""><a href="<?=Base_url()?>auth/login" >로그인</a></li>
	                    <? } ?>	                    					
	                    <li class=""><a href="<?=Base_url()?>review/lists" >리뷰</a></li>
	                    <li class=""><a href="<?=Base_url()?>cart_lib/lists" >장바구니</a></li>
	                    <li class=""><a href="<?=Base_url()?>mypage" >마이페이지</a></li>
	                    <li class=""><a href="<?=Base_url()?>customer/" >FAQ</a></li>
	                    <? if($this->session->userdata['email'] && $this->session->userdata['auth_lv']>=7){?> 
	                        <li class=""><a href="<?=Base_url()?>admin">관리자</a></li>
	                    <? }?>
				</ul>
			</nav>
		</div>
	</header>
	<!-- //header -->