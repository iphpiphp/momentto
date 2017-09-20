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
	
	<link rel="stylesheet" href="/assets2/css/normalize.css">
<link rel="stylesheet" href="/assets2/css/bootstrap.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
<link rel="stylesheet" href="/assets2/css/jquery.bxslider.css">
<link rel="stylesheet" href="/assets2/css/common.css">
<link rel="stylesheet" href="/assets2/css/m.css">

    <script src="http://code.jquery.com/jquery-1.9.0.js"></script>
	<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
	<script src="/assets2/js/bootstrap.min.js"></script>
	<script>
		$(document).ready(function () {
			init_cate();
			init_coupon();			
			$("#find_member").click(function (){
				var url = "/awsa/find_member";
			  	var popUrl = "/awsa/find_member";
                var popTitle = 'html_view';
                var popOption = "width=790, height=2000, resizable=yes, scrollbars=yes, status=no;";    //팝업창 옵션(optoin)
                window.open(popUrl,popTitle,popOption);


			});

			$("#html_view").click(function(){

				var params = $("#formname1").serialize();
				var url = "/awsa/email_html_view";
				
			  	var popUrl = '';
                var popTitle = 'html_view';
                var popOption = "width=790, height=2000, resizable=yes, scrollbars=yes, status=no;";    //팝업창 옵션(optoin)
                window.open(popUrl,popTitle,popOption);
				
				$("#formname1").attr("target","html_view");
				$("#formname1").attr("action",url);
				$("#formname1").attr("method","post");
				$("#formname1").submit();

				
			});

			$(".cate").change(function(){
				var type = $(this).data("type");				

				if(type ==1 || type == 3){
					var cate_id = $(this).children('option:selected').val();
					if(type == 1) product_list(cate_id,2);
					if(type == 3) product_list(cate_id,4);
				}
				if(type ==2 || type == 4){
					var product_id = $(this).children('option:selected').val();
					findproduct(product_id,type);
				}
			});
			
			//선택 삭제
			//$(".remove_sec").click(function(){
			$('.cont_s1, .cont_s2').on('click', '.remove_sec', function() {
				//alert();
				//alert($(this).parent().attr("class"));
				$(this).parent().remove();
				
			});
			
			$("#go_send").click(function(){
				var params = $("#formname1").serialize();
				var url = "/awsa/email_send";
				$.ajax({
					type: "POST",
					data: params,
					url: url,
					dataType: "html",
					success: function(data){
						alert(data);
					} ,beforeSend:function(){

						$('.wrap-loading').removeClass('display-none');
					}
					,complete:function(){

						$('.wrap-loading').addClass('display-none');

					}
				});
				
				//$("#formname1").attr("action",url);
				//$("#formname1").attr("method","post");
				//$("#formname1").submit();
			});

		});
		function init_cate(){
			//1차
			cate_list();

			//2차
			product_list(1,2); //cate_id , class num
			product_list(1,4);


		}
		function cate_list(){
			var params = $("#formname1").serialize();
			var url = "/api/catelist";
			$.ajax({
			type: "POST",
			data: params,
			url: url,
			dataType: "json",
			success: function(data){				
				//var data2 = JSON.stringify(data);
				//$("#ajax").text(data2);
				$.each(data.catelist, function(key, value){
					$("#cate1").append("<option value='"+value.id+"'>"+value.name+"</option>");
					$("#cate3").append("<option value='"+value.id+"'>"+value.name+"</option>");
				});

			}
			});
		}
		function product_list(cate_id, num){
			var url = "/api/productlists";
			$.ajax({
				type: "POST",
				data: {cate_id:cate_id},
				url: url,
				dataType: "json",
				success: function(data){
					$("#cate"+num+" > option").remove();
					$("#cate"+num).append("<option value='' selected>상품을 선택해 주십시오.</option>");
					$.each(data.productlist, function(key, value){						
						$("#cate"+num).append("<option value='"+value.id+"'>"+value.name+"</option>");
					});					
				}
			});
		}
		function findproduct(product_id,type){
			var url = "/api/findproduct";
			$.ajax({
				type: "POST",
				data: {product_id:product_id},
				url: url,
				dataType: "json",
				success: function(data){
					//var data2 = JSON.stringify(data);
					//$("#ajax").text(data2);
					var html = "";
					if(type==2){
						html = 	'<div class="s1" ><input type="hidden" name="serialize_s1[]" id="serialize_s1" value="'+data.id+'" />'+								
							   	'섹션제목 : <input type="text" name="s1_title[]" id="s1_title" /> <a href="javascript:;" class="remove_sec btn">제거</a> <div class="s1_view" id="view_s1_">'+
								'<img style="padding:10px 10px; width:25%" src="<?=S3_IMG_PATH?>'+data.imagePath +"/"+ data.imageLFile+'" /></div>'+							   
						       	'안내문구 : <textarea name="s1_text[]" id="s1_text" cols="50" rows="3"></textarea></div>';						
						$(".cont_s1").append(html);
					}
					if(type==4){
						html = '<div class="s2"><input type="hidden" name="serialize_s2[]" id="serialize_s2" value="'+data.id+'" />'+							   
							   '<a href="javascript:;" class="remove_sec btn">제거</a> <div class="s2_view" id="view_s2_">'+							   
						  	   '<img style="padding:10px 10px; width:25%" src="<?=S3_IMG_PATH?>'+data.imagePath +"/"+ data.imageLFile+'" /></div>'+
						       '안내문구 : <textarea name="s2_text[]" id="s2_text" cols="50" rows="3"></textarea></div>';						
						$(".cont_s2").append(html);
					}
				}
			});
		}
		
		function init_coupon(){
			var url = "/api/coupon_list";
			//alert('init coupon');
			
			$.ajax({
				type: "POST",				
				url: url,
				dataType: "json",
				success: function(data){
					var data2 = JSON.stringify(data);
					//alert(data2);
					//$("#ajax").text(data2);
					var html = "";
					$("#coupon").append("<option value=''>쿠폰을 선택해 주십시오.</option>");
					$.each(data.coupon_list, function(key, value){
						$("#coupon").append("<option value='"+value.id+"'>"+value.name+"_"+value.price+"%</option>");
					});
					
				}
			});
		}
	</script>
</head>


<body>
	<style type="text/css" >
.wrap-loading{ /*화면 전체를 어둡게 합니다.*/
    position: fixed;
    left:0;
    right:0;
    top:0;
    bottom:0;
    background: rgba(0,0,0,0.2); /*not in ie */
    filter: progid:DXImageTransform.Microsoft.Gradient(startColorstr='#20000000', endColorstr='#20000000');    /* ie */

}
    .wrap-loading div{ /*로딩 이미지*/
        position: fixed;
        top:50%;
        left:50%;
        margin-left: -21px;
        margin-top: -21px;
    }
    .display-none{ /*감추기*/
        display:none;
    }

</style>

<div class="wrap-loading display-none">
    <div><img src="./images/loading1.gif" /></div>
</div>

<!-- #container -->
<div id="container" class="clearfix">

	<!-- 페이지 시작-->

	<div id="bg_company" class="bg_cover" style="min-height: 800px; ">
		<h1>대용량 이메일 설정</h1>
		<div class="w1140">
			
			<form id="formname1" method="post" >
				
				<table class="table">
					<tbody>
						<tr><th>이메일 제목</th> <td><input type="text" name="email_title" id="email_title" /></td></tr>
						<tr class="table-success"><th colspan="2"> 섹션1 - 신규상품 </th></tr>
						<tr>
							<th> 영상 추가 </th>
							<td><select name="cate1" id="cate1" class="cate" data-type="1"></select><select name="cate2" id="cate2" class="cate" data-type="2"></select></td>
						</tr>
						<tr><th> 신규상품 </th><td><div class="cont_s1" style="text-align:left;"></div></td></tr>
						
						<tr class="table-warning"><th colspan="2"> 섹션2 - MD 추천 </th></tr>
						<tr><th> 섹션2 전체 제목 </th><td><input type="text" name="s2_title" id="s2_title" /></td></tr>
						<tr>
							<th> 영상 추가</th>
							<td>
								<select name="cate3" id="cate3" class="cate" data-type="3"></select>
								<select name="cate4" id="cate4" class="cate" data-type="4"></select>
							</td>
						</tr>
						<tr><th> 추천 제품 </th><td><div class="cont_s2" style="text-align:left;"></div></td></tr>
						
						<tr class="table-info"><th colspan="2"> 섹션3 - 쿠폰설정 </th></tr>
						<tr><th> 할인 쿠폰 설정 </th><td><select name="cid" id="coupon"></select></td></tr>


						<tr class="table-info"><th colspan="2"> 메일 설정 </th></tr>
						<tr>
							<th> 메일 타입 </th>
							<td>
								<select name="action" id="action">
									<option value="all" selected>전체메일</option>
									<option value="test">테스트메일</option>
								</select>
							</td>
						</tr>
						<tr>
							<th> 메일 서버  </th>
							<td>
								<select name="QueueName" id="action">
									<option value="emailQueue1" selected>1번 메일서버</option>
									<option value="emailQueue2">2번 메일 서버</option>
								</select>
							</td>
						</tr>
						
						<tr><th>회원 번호</th><td><input type="text" name="up" id="up" value="1" /> ~ <input type="text" name="down" id="down" value="" />번까지</td></tr>

						<tr>
							<th>반복횟수 <br>테스트메일일 경우만 사용</th>
							<td><input type="text" name="limit" id="limit" value="" /></td>
						</tr>
						<tr>
							<th>회원 선택(테스트 메일)</th>
							<td>
								<input type="text" name="m_id" id="m_id" value=""  /><input type="text" name="m_email" id="m_email" value=""  />
							</td>
						</tr>

					</tbody>
				</table>
			</form>

			<a href="#" class="btn btn-warning" id="find_member" >회원찾기</a>
			<a href="#" class="btn btn-primary " id="html_view" >미리보기</a>
			<a href="#" class="btn btn-warning" id="go_send" >대량 이메일 보내기</a>
			

			<div id="ajax"></div>
		</div>
	</div>

	<!-- //페이지 끝-->

</div>
<!-- //container -->
</body>
</html>
