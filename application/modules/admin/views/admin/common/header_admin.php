
<!html>
<head>
	<meta charset="utf-8">
	<title>Thedays Admin</title>
	<!-- Mobile specific metas -->
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<!-- Force IE9 to render in normal mode -->
	<!--[if IE]><meta http-equiv="x-ua-compatible" content="IE=9" /><![endif]-->
	

	<? $v = mt_rand(1,1000); ?>
	<!-- css -->
	<link href="<?=PATH_ADMIN?>css/icons.css" rel="stylesheet" />
	<!-- Bootstrap stylesheets (included template modifications) -->
	<link href="<?=PATH_ADMIN?>css/bootstrap.css" rel="stylesheet" />
	<!-- jQueryUI -->
	<link href="<?=PATH_ADMIN?>css/appstart-theme/jquery.ui.all.css" rel="stylesheet" />
	<!-- Plugins stylesheets (all plugin custom css) -->
	<link href="<?=PATH_ADMIN?>css/plugins.css" rel="stylesheet" />
	<!-- Main stylesheets (template main css file) -->
	<link href="<?=PATH_ADMIN?>css/main.css" rel="stylesheet" />
	<!-- Custom stylesheets ( Put your own changes here ) -->
	<link href="<?=PATH_ADMIN?>css/custom.css" rel="stylesheet" />
	<!-- Fav and touch icons -->
	<link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?=PATH_ADMIN?>img/ico/apple-touch-icon-144-precomposed.png">
	<link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?=PATH_ADMIN?>img/ico/apple-touch-icon-114-precomposed.png">
	<link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?=PATH_ADMIN?>img/ico/apple-touch-icon-72-precomposed.png">
	<link rel="apple-touch-icon-precomposed" href="<?=PATH_ADMIN?>img/ico/apple-touch-icon-57-precomposed.png">
	<link rel="icon" href="<?=PATH_ADMIN?>img/ico/favicon.ico" type="image/png">
	<!-- Windows8 touch icon ( http://www.buildmypinnedsite.com/ )-->
	<meta name="msapplication-TileColor" content="#3399cc" />
	<script src="<?=PATH_ADMIN?>js/jquery-2.2.4.js"></script>
	<script src="<?=PATH_ADMIN?>js/jquery-migrate-1.4.1.min.js"></script>
	<script src="<?=PATH_ADMIN?>ckeditor/ckeditor.js"></script>
	
	
</head>

<body class="ovh">
	<div id="preloader">
		<div id="preloader-logo">

		</div>
		<div id="preloader-icon">
			<i class="im-spinner icon-spin"></i>
		</div>
	</div>
	<!-- Start #header -->
	<div id="header">
		<div class="container-fluid">
			<div class="navbar">
				<div class="navbar-header">
					<!-- Show navigation toggle on phones -->
					<button id="showNav" class="navbar-toggle" type="button">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<!-- Show logo for large screens and laptops -->
					<a class="navbar-brand visible-lg visible-md" href="/" target="_blink"><img src="/assets3/img/logo.png" alt="logo" width="20%"></a>
					<!-- Show logo for small screens -->
					<a class="navbar-brand hidden-lg hidden-md hidden-xs" href="index.html">
						<img src="<?=PATH_ADMIN?>img/logo-sm.png" alt="Jump start">
					</a>
				</div>
				<nav id="top-nav" class="navbar-no-collapse" role="navigation">
					<!-- Navbar nav -->
					<ul class="nav navbar-nav pull-right">
						<!-- li class="dropdown">
                                <a href="#" data-toggle="dropdown">
                                    <i class="im-earth"></i>
                                    <i class="nav-notification im-circle2"></i>
                                    <span class="sr-only">Notifications</span>
                                </a>
                            </li -->
						<li class="dropdown">
							<a href="#" data-toggle="dropdown">
								<i class="im-earth"></i>
								<span class="sr-only">config</span>
							</a>
							<ul class="dropdown-menu dropdown-email right" role="menu">
								<li><a href="#" class="dropdown-menu-header">config</a></li>
								<li class="divider"></li>
								<li class="clearfix">
									<a href="/" target="_blank">
										메인화면으로<span class="time-ago"></span>
									</a>
								</li>
								<li class="divider"></li>
								<li class="clearfix">
									<a href="/admin/conf/faq_conf_list" target="_blank">
										자주하는질문<span class="time-ago"></span>
									</a>
								</li>
								<li class="divider"></li>
								<li class="clearfix">
									<a href="/auth/logout">
										LogOut<span class="time-ago"></span>
									</a>
								</li>
							</ul>
						</li>
					</ul>
				</nav>
			</div>
		</div>
	</div>
	<style>
		#header{background: #2C3E50;}
		#header .navbar{background: #2C3E50;}
		#sidebar .sidebar-inner .option-buttons #search-nav .form-group input {background-color: #FFFFFF}
	</style>
