<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no">
    <title> :: The days :: </title>
    <!--[if IE]><meta http-equiv="x-ua-compatible" content="IE=9" /><![endif]-->

    <!-- Css files -->
    <!-- Icons -->
    <link href="/assets/css/icons.css" rel="stylesheet" />
    <!-- Bootstrap stylesheets (included template modifications) -->
    <link href="/assets/css/bootstrap.css" rel="stylesheet" />
    <!-- link href="/assets/css/bootstrap.min.css" rel="stylesheet" -->
    <link href="/assets/css/docs.css" rel="stylesheet">
    <!-- jQueryUI -->
    <link href="/assets/css/appstart-theme/jquery.ui.all.css" rel="stylesheet" />
    <!-- Plugins stylesheets (all plugin custom css) -->
    <link href="/assets/css/plugins.css" rel="stylesheet" />
    <!-- Main stylesheets (template main css file) -->
    <link href="/assets/css/main.css" rel="stylesheet" />
    <!-- Custom stylesheets ( Put your own changes here ) -->
    <link href="/assets/css/custom.css" rel="stylesheet" />
    
    <!-- public -->
    <link rel="stylesheet" href="/assets/css/normalize.css">	
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="/assets/css/jquery.bxslider.css">
	<link rel="stylesheet" href="/assets/css/common.css">
	
    <!-- Fav and touch icons -->
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="/assets/img/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="/assets/img/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="/assets/img/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="/assets/img/ico/apple-touch-icon-57-precomposed.png">
    <link rel="icon" href="/assets/images/favicon.ico" type="image/png">
    
    <!-- Windows8 touch icon ( http://www.buildmypinnedsite.com/ )-->
    <meta name="msapplication-TileColor" content="#3399cc" />
    
    <script src="http://code.jquery.com/jquery-1.9.0.js"></script>
	<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
	
	<script src="/assets/js/html5.js"></script>
	<script src="/assets/js/respond.min.js"></script>
</head>

<body>
	<a class="skip" href="#container">Skip to main content</a>

	<!-- wrap.screenID -->
	<div id="wrap" class="main">

		<!-- header -->
		<header id="hd" >
			<div class=" w1140" >
				<a id="mMn" class="visible-xs-block" href="#gnb" onClick="$('#gnb').toggle();return false;">
					<i class="glyphicon glyphicon-menu-hamburger" style="z-index:2000" ></i>
					<span class="sr-only">메뉴</span>
				</a>
				<h1><a href="/"><img src="/assets/img/logo.png" alt="logo"></a></h1>
				<!-- GNB -->
				<nav id="gnb">
					<ul>
						<li class="dropdown">
							<span>Language</span>
							 <select name="location">
                        		<option value="ko" <?=($this->session->userdata['location'] =="ko")? 'selected' : ""; ?> itemset="<?=uri_string()?>" item="<?=$_SERVER['QUERY_STRING']?>">한국</option>
                        		<option value="eng" <?=($this->session->userdata['location'] =="eng")? 'selected' : ""; ?>  itemset="<?=uri_string()?>" item="<?=$_SERVER['QUERY_STRING']?>">Eng</option>
                        		
                        		<option value="zhc" <?=($this->session->userdata['location'] =="zhc")? 'selected' : ""; ?> itemset="<?=uri_string()?>" item="<?=$_SERVER['QUERY_STRING']?>">中文 (简体)</option>
                        		<option value="zht" <?=($this->session->userdata['location'] =="zht")? 'selected' : ""; ?>  itemset="<?=uri_string()?>" item="<?=$_SERVER['QUERY_STRING']?>">中文 (繁體)</option>
                        		
                        		<option value="jp" <?=($this->session->userdata['location'] =="jp")? 'selected' : ""; ?> itemset="<?=uri_string()?>" item="<?=$_SERVER['QUERY_STRING']?>">日本</option>
                        		<option value="es" <?=($this->session->userdata['location'] =="es")? 'selected' : ""; ?>  itemset="<?=uri_string()?>" item="<?=$_SERVER['QUERY_STRING']?>">Español</option>
                        		
                    		</select>
							<!-- a class="dropdown-toggle" href="#" data-toggle="dropdown">한국어 <span class="caret"></span></a -->
							<!-- ul class="dropdown-menu dropdown-menu-right">
								<li><a href="#">Engilsh</a></li>
								<li><a href="#">Engilsh</a></li>
							</ul -->
						</li>
						<? if($this->session->userdata['email']){?>
                        	<li class=""><a href="<?=Base_url()?>auth/logout">로그아웃</a></li>
	                    <? }else{ ?>
	                        <li class=""><a href="<?=Base_url()?>auth/login" style="text-align: center;">로그인</a></li>
	                    <? } ?>	                    					
	                    <li class=""><a href="<?=Base_url()?>review/lists" style="text-align: center;">리뷰</a></li>
	                    <li class=""><a href="<?=Base_url()?>cart_lib/lists" style="text-align: center;">장바구니</a></li>
	                    <li class=""><a href="<?=Base_url()?>mypage" style="text-align: center;">마이페이지</a></li>
	                    <li class=""><a href="<?=Base_url()?>customer/" style="text-align: center;">FAQ</a></li>
	                    <? if($this->session->userdata['email'] && $this->session->userdata['auth_lv']>=7){?> 
	                        <li class=""><a href="<?=Base_url()?>admin" style="text-align: center;">관리자</a></li>
	                    <? }?>
					</ul>
				</nav>
			</div>
		</header>
		<!-- //header -->
		
		
<!-- body>
    <header class="navbar navbar-static-top navbar-fixed-top bs-docs-nav" id="top" role="banner">
        <div class="container">
            <div class="navbar-header">
                <button class="navbar-toggle" type="button" data-toggle="collapse" data-target=".bs-navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <div id="" style="display:inline-block; float: left;">
                    <a href="#" class="navbar-brand" style=""><input type="image" src="/resources/images/global/header_btn_search.gif" alt="검색" id="gSearchBtn"></a>
                </div>
                <div id="" style="display:inline-block; float: left; width:100px">
                    <a href="<?=Base_url()?>" class="navbar-brand title_head " style="margin-left:5%; ">The days</a>
                </div>
            </div>
            <nav class="navbar-left navbar-brand" role="">                
            </nav>

            <nav class="collapse navbar-collapse bs-navbar-collapse navbar-right" role="navigation">
                <ul class="nav navbar-nav">
                    
                  
                    <li class="">
                        <a href="#" style="text-align: center;">
                        <select name="location" style="padding:2px 2px;">
                        <option value="ko" <?=($this->session->userdata['location'] =="ko")? 'selected' : ""; ?> itemset="<?=uri_string()?>" item="<?=$_SERVER['QUERY_STRING']?>">한국어</option>
                        <option value="eng" <?=($this->session->userdata['location'] =="eng")? 'selected' : ""; ?>  itemset="<?=uri_string()?>" item="<?=$_SERVER['QUERY_STRING']?>">Eng</option>
                    </select>
                    </a>
                    </li>
                    <? if($this->session->userdata['email']){?>
                        <li class=""><a href="<?=Base_url()?>auth/logout">로그아웃</a></li>
                    <? }else{ ?>
                        <li class=""><a href="<?=Base_url()?>auth/login" style="text-align: center;">로그인</a></li>
                    <? } ?>					
                    <li class=""><a href="<?=Base_url()?>review/lists" style="text-align: center;">리뷰</a></li>
                    <li class=""><a href="<?=Base_url()?>mypage" style="text-align: center;">마이페이지</a></li>
                    <li class=""><a href="<?=Base_url()?>customer/" style="text-align: center;">고객센터</a></li>
                    <? if($this->session->userdata['email'] && $this->session->userdata['auth_lv']>=7){?> 
                        <li class=""><a href="<?=Base_url()?>admin" style="text-align: center;">관리자</a></li>
                    <? }?>
                    
                </ul>
            </nav>
        </div>
    </header>
    <div class="clearfix" style="padding-top:80px;"></div -->	