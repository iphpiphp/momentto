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
			$("#go_test").click(function(){
				var params = $("#formname1").serialize();
				var url = $("#url").val();
				
				  $.ajax({
					type: "POST",
					data: params,			       
					url: url,
					dataType: "json",
					success: function(data){
						//alert(data);
						//$("#ajax").html(data);
						var data2 = JSON.stringify(data);
						$("#ajax").text(data2);
					}
			     });    
			});			
		});
	</script>
</head>


<body>
<!-- #container -->
<div id="container" class="clearfix">

	<!-- 페이지 시작-->

	<div id="bg_company" class="bg_cover" style="min-height: 800px; ">
		<div class="w1140">
			<form id="formname1" />			
				API URL 	<input type="text" name="url" 		id="url" 			value="/api/member/mypage" />Ex: /api/member/checkemail or http:// URL..<br />
				authkey 	<input type="text" name="AuthKey" 	id="AuthKey" 		value="<?=md5('theaysmoviemaker0029')?>" />인증키테스트<br />
				uuid 		<input type="text" name="UUID"  	id="UUID" 			value="" /><br />
				email 		<input type="text" name="email" 	id="email" 			value="kudomiyu@hanmail.net" /><br />				
				pass 			<input type="text" name="pass" 		id="pass" 			value="" /><br />
				productId 		<input type="text" name="product_id" 	id="product_id" 			value="" /><br />
				page 			<input type="text" name="page" 	id="page" 			value="" /><br />
				
				
				movie_title 	<input type="text" name="movie_title" 	id="movie_title" 			value="" /><br />
				isBgmChange 	<input type="text" name="isBgmChange" 	id="isBgmChange" 			value="" /><br />
				make_id 		<input type="text" name="make_id" 	id="make_id" 			value="" /><br />
				isComplete 		<input type="text" name="isComplete" 	id="isComplete" 			value="" /><br />
				order_id 		<input type="text" name="order_id" 	id="order_id" 			value="" /><br />
				user_resource_path 		<input type="text" name="user_resource_path" 	id="user_resource_path" 			value="" /><br />
				
			</form>
				<a href="#" id="go_test" />전송</a>
			
			
			<div id="ajax"></div>
			
			
		</div>
	</div>
	
	<!-- //페이지 끝-->

</div>
<!-- //container -->
</body>
</html>