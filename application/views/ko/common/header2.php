<!DOCTYPE html>
<html lang="ko">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no">
<meta name="naver-site-verification" content="20d5797f1bf185967400aa384e59de8184f359df">
<meta name="description" content="사진으로 누구나 손쉽게 만들 수 있는 셀프 영상제작 솔루션">
<meta name="keywords" content="더데이즈영상">
<meta property="og:type" content="website">
<meta property="og:title" content="더데이즈영상">
<meta property="og:description" content="사진으로 누구나 손쉽게 만들 수 있는 셀프 영상제작 솔루션">
<meta property="og:image" content="https://www.thedays.co.kr/resources/images/global/header_logo.gif">
<meta property="og:url" content="https://www.thedays.co.kr">
<title>더데이즈영상</title>
<link rel="shortcut icon" href="https://d359hdvta3sq5o.cloudfront.net/resources/images/fivicon.ico" />

<? $v = mt_rand(1,1000); ?>

	
<!-- css -->
<link rel="stylesheet" href="<?=PATH3?>css/bootstrap.min.css?_<?=$v?>">
<!-- link rel="stylesheet" href="<?=PATH3?>css/font-awesome.min.css?_<?=$v?>" -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
<link rel="stylesheet" href="<?=PATH3?>css/jquery.bxslider.css?_<?=$v?>">
<link rel="stylesheet" href="<?=PATH3?>css/common.css?_<?=$v?>">
<link rel="stylesheet" href="<?=PATH3?>css/m.css?_<?=$v?>">
	
<link rel="stylesheet" href="<?=PATH3?>css/my_custom.css?_<?=$v?>">

<!-- js -->
<script src="<?=PATH3?>js/jquery-3.1.1.min.js?_<?=$v?>"></script>
<script src="<?=PATH3?>js/jquery-migrate-1.4.1.min.js?_<?=$v?>"></script>


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
<script language='javascript'>
	var _AceGID=(function(){var Inf=['dgc16.acecounter.com','8080','BP3N40229214675','CW','0','NaPm,Ncisy','ALL','0']; var _CI=(!_AceGID)?[]:_AceGID.val;var _N=0;var _T=new Image(0,0);if(_CI.join('.').indexOf(Inf[3])<0){ _T.src =( location.protocol=="https:"?"https://"+Inf[0]:"http://"+Inf[0]+":"+Inf[1]) +'/?cookie'; _CI.push(Inf);  _N=_CI.length; } return {o: _N,val:_CI}; })();
	var _AceCounter=(function(){var G=_AceGID;if(G.o!=0){var _A=G.val[G.o-1];var _G=( _A[0]).substr(0,_A[0].indexOf('.'));var _C=(_A[7]!='0')?(_A[2]):_A[3];	var _U=( _A[5]).replace(/\,/g,'_');var _S=((['<scr','ipt','type="text/javascr','ipt"></scr','ipt>']).join('')).replace('tt','t src="'+location.protocol+ '//cr.acecounter.com/Web/AceCounter_'+_C+'.js?gc='+_A[2]+'&py='+_A[4]+'&gd='+_G+'&gp='+_A[1]+'&up='+_U+'&rd='+(new Date().getTime())+'" t');document.writeln(_S); return _S;} })();
</script>
<noscript><img src='https://dgc16.acecounter.com:8080/?uid=BP3N40229214675&je=n&' border='0' width='0' height='0' alt=''></noscript>

</head>

<body>
<a class="skip" href="#container">Skip to main content</a>

<!-- wrap.screenID -->
<div id="wrap" class="main">

	<!-- header -->
	<header id="hd">
		<div>
			<h1><a href="/"><img src="<?=PATH2?>img/logo.png" alt="logo">theDays</a>
			<? if(!$this->agent->is_mobile()){ ?>
			<div class="pull-right pc_menu">
				<? if($this->session->userdata['email']){?>
					<a href="<?=BASE_URL?>/auth/logout">로그아웃</a>
				<? }else{ ?>
					<a href="<?=BASE_URL?>/auth/login" >로그인</a>
				<? } ?>
				<a href="<?=BASE_URL?>/product/lists" >상품</a>
				<a href="<?=BASE_URL?>/review/lists" >리뷰</a>
				<a href="<?=BASE_URL?>/cart_lib/lists" >장바구니</a>
				<a href="<?=BASE_URL?>/mypage" >마이페이지</a>
				<a href="<?=BASE_URL?>/customer/" >FAQ</a>
				<? if($this->session->userdata['email'] && $this->session->userdata['auth_lv']>=7){?>
					<a href="<?=BASE_URL?>/admin">관리자</a>
				<? }?>
			</div>
			<? } ?>
			</h1>

			<? if($this->agent->is_mobile()){ ?>
			<a class="icon_mn" href="#gnb" onClick="$(this).toggleClass('on');$('#gnb').toggle();return false;">메뉴</a>
			<? } ?>
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
                        	<li class=""><a href="<?=BASE_URL?>/auth/logout">로그아웃</a></li>
	                    <? }else{ ?>
	                        <li class=""><a href="<?=BASE_URL?>/auth/login" >로그인</a></li>
	                    <? } ?>
						<li class=""><a href="<?=BASE_URL?>/product/lists" >상품</a></li>
	                    <li class=""><a href="<?=BASE_URL?>/review/lists" >리뷰</a></li>
	                    <li class=""><a href="<?=BASE_URL?>/cart_lib/lists" >장바구니</a></li>
	                    <li class=""><a href="<?=BASE_URL?>/mypage" >마이페이지</a></li>
	                    <li class=""><a href="<?=BASE_URL?>/customer/" >FAQ</a></li>
	                    <? if($this->session->userdata['email'] && $this->session->userdata['auth_lv']>=7){?> 
	                        <li class=""><a href="<?=BASE_URL?>/admin">관리자</a></li>
	                    <? }?>
				</ul>
			</nav>
		</div>
	</header>
	<!-- //header -->
