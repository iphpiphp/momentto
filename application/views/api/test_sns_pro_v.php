<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no">
    <title> :: The days :: </title>
    <!--[if IE]><meta http-equiv="x-ua-compatible" content="IE=9" /><![endif]-->

    <link rel="icon" href="/assets/images/favicon.ico" type="image/png">
    
    <!-- Windows8 touch icon ( http://www.buildmypinnedsite.com/ )-->
    <meta name="msapplication-TileColor" content="#3399cc" />
    
    <script src="http://code.jquery.com/jquery-1.9.0.js"></script>
	<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
	<script>
		$(document).ready(function () {
			$("#form_post").submit();
		});
	</script>
</head>
<body>
<!-- #container -->
<div id="container" class="clearfix">

	<!-- 페이지 시작-->

	<div id="bg_company" class="bg_cover" style="min-height: 800px; ">
		<div class="w1140">
			<form action="http://test.thedays.co.kr/member/doLogin" method="POST" id="form_post">
				<input type="hidden" name="j_username" value="<?=$email?>"/>
				<input type="hidden" name="j_password" value="<?=$password?>" />				
			</form>
			
		</div>
	</div>
	
	<!-- //페이지 끝-->

</div>
<!-- //container -->
</body>
</html>