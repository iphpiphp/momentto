<style>
	.pick-style {
		width: 200px;
		height: 200px;
		background-image: url('/assets/location/ko/image/img_how_to_1.png');
	}
	
	.customize-style {
		width: 200px;
		height: 200px;
		background-image: url('/assets/location/ko/image/img_how_to_2.png');
	}
	
	.share-style {
		width: 250px;
		height: 200px;
		background-image: url('/assets/location/ko/image/img_how_to_3.png');
	}
	
	#video_skin {
		position: relative;
		width: 100%;
		height: 100%;
	}
	
	#tpo1 {
		position: absolute;
		top: 30%;
		z-index: 999;
		color: white;
		text-align: center;
		width: 100%;
		font-size: 25px;
	}
	
	#tpo2 {
		position: absolute;
		top: 38%;
		z-index: 999;
		color: white;
		text-align: center;
		width: 100%;
		font-size: 20px;
	}
	
	#tpo3 {
		position: absolute;
		top: 45%;
		z-index: 999;
		color: white;
		text-align: center;
		width: 100%;
	}
	
	#tpo4 {
		position: absolute;
		top: 48%;
		z-index: 999;
		color: white;
		text-align: center;
		width: 100%;
		font-size: 34px;
	}
	#menu_table tr{
		    
		    border-bottom:1px solid #b1bdbd;
	}
	
	.carousel-inner .item{
		float:center;
	}
	.carousel-inner .item img{
		display: block;
		margin-left:auto;
		margin-right:auto;
	}
	.fc-list li{
		
		text-align:center;
	}
</style>
<script>
	function cl() {
		position = $("#how_tit ").offset();
		$('html,body').animate({
			scrollTop: position.top
		}, 1500);
	}
</script>

<div class="container">
<div class="col-lg-12">
	<div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
        <!-- Indicators -->
        <ol class="carousel-indicators dotstyle center">
        	<? $z=0; foreach($bnr_list as $key => $val){  ?>
            <li data-target="#carousel-example-generic" data-slide-to="<?=$z?>" class="<? if($z==0)echo "active";?>"><a href="#">slide</a></li>            
            <? $z++;} ?>
        </ol>
        <!-- Wrapper for slides -->
        <div class="carousel-inner">
        	<? $z=0; foreach($bnr_list as $key => $val){ $z++; ?>
            <div class="item <? if($z==1)echo "active";?>" >
            	
            	<div style="display:block; position: relative;">
                	<a href="#"><img src="/uploads/main_bnr/<?=$val['zmb_filename']?>" alt="<?=$val['zmb_alt']?>" width="100%" height="<?=$val['zmb_height']?>"></a>
                	
               </div>
                <!-- div class="carousel-caption">
                    <h4><?=$val['zmb_h1_text']?></h4>
                    <p><?=$val['zmb_span_text']?></p>
                </div -->
            </div>
            <? } ?>            
        </div>
        <!-- Controls -->
        <a class="left carousel-control" href="#carousel-example-generic" data-slide="prev">
            <i class="fa fa-angle-left"></i>
        </a>
        <a class="right carousel-control" href="#carousel-example-generic" data-slide="next">
            <i class="fa fa-angle-right"></i>
        </a>
    </div>
	<!-- div id="video_skin" style="">
		<div id="tpo1">당신만을 위한 프리미엄 무비</div>
		<div id="tpo2">3,000명이 같이 했습니다!</div>
		<div id="tpo3">지금 시작 하세요!</div>
		<div id="tpo4"><a href="javascript:cl();">▽</a></div>


		<video id="example_video_1" class="video-js vjs-default-skin" autoplay muted loop width="100%" height="100%" poster="" data-setup='{"example_option":true}'>
			<source src="http://thedays.co.kr/resources/mp4/A_Thousand_years-HD.mp4" type="video/mp4">
			<div class="fallback">
				<div class="alert alert-danger fade in" style="text-align:center">
					<i class="im-cancel alert-icon s24"></i><span>해당 사이트는 IE9 이상 및 크롬, 파이어폭스에 최적화 되어 있습니다.</span>
					<p>정상 동작을 위해서 최신 브라우저를 설치 하셔야 합니다. <a href="">크롬</a> <a href="">IE</a> <a href="">파이어폭스</a> <a href="">사파리</a></p>
				</div>
			</div>
		</video>
	</div -->
</div>
</div>

<div class="container">
<div class="col-lg-12">
	
	<h1 class="fc-header" id="how_tit">How it works</h1>
	<ul class="fc-list list-style-none">
		<li class="fc-list-item col-md-4 ">
			<div class="icon-how "><img src="/assets/location/ko/image/img_how_to_1.png" /></div>
			<div class="numbered-step">1</div>
			<div class="fc-copy">감성적인 스토리를 담은
				<br>더데이즈 만의 무비 스타일</div>
		</li>
		<li class="fc-list-item col-md-4 ">
			<div class="icon-how"><img src="/assets/location/ko/image/img_how_to_2.png" /></div>			
			<div class="numbered-step">2</div>
			<div class="fc-copy">누구나 쉽고 간편하게
				<br />사용할 수 있는 무비메이커</div>
		</li>
		<li class="fc-list-item col-md-4 ">
			<div class="icon-how"><img src="/assets/location/ko/image/img_how_to_3.png" /></div>
			<div class="numbered-step">3</div>
			<div class="fc-copy">언제 어디서든 감상하는
				<br />나만의 기록 영상</div>
		</li>
	</ul>
	</div>
</div>





<div class="container">
	<div class="content-wrapper">
		<div class="content-inner" id="movie_title">
			<h1>무비리스트</h1>
			<div id="navbar_cate" class="navbar ">
				<div class="navbar-inner">
					<div class="container">
						<table class="table" id="menu_table">
							<tbody>
							<tr>
								<th><a href="#">전체</a></th>
								<td><a href="#">BABY&KIDS</a></td>
								<td><a href="#">LOVE</a></td>
								<td><a href="#">WEDDING</a></td>
								<td><a href="#">BIRTHDAY</a></td>
								<td><a href="#">TRAVEL</a></td>
								<td><a href="#">SALE</a></td>
							</tr>
							<tr>
								<th><a href="#">사용메뉴얼</a></th>
								<td><a href="#">ACADEME</a></td>
								<td><a href="#">FAMILY</a></td>
								<td><a href="#">MILITARY</a></td>
								<td><a href="#">THEMAPARK</a></td>
								<td><a href="#">ENTERTAINER</a></td>
								<td><a href="#">BUSINESS</a></td>
							</tr>
							</tbody>
						</table>
						<!-- span id="text"></span -->
					</div>
				</div>
			</div>
			
			<!-- Start .row -->
			<div id="cart"></div>
			<div class="row">
				<? $i=1; foreach($product_list as $key => $val): ?>
					<div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 mix cate<?=$val['categoryId']?>" data-my-order="<? echo $i++; ?>">
						<iframe class="_vimeoPlayer" style="width:100%; max-width:738px" id="vimeoPlayer" src="http://player.vimeo.com/video/<?=$val['movieVimeoId']?>?api=1&player_id=<?=$val['movieVimeoId']?>&color=e54b63" width="" height="" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen>
						</iframe>
						<!-- a href="#" class="thumbnail" style="height:212px; "><img src="<?="http://test.thedays.co.kr/".$val['imagePath']."/".$val['imageLFile']?>" alt="image"></a -->
						<div style='font-size:20px;text-align:center;'>
							<a href="<?=Base_url()?>product/detail/<?=$val['id']?>">
								<?=$val['name']?>
							</a>
						</div>
						<div id="span_info">
							<span id="">￦<?=number_format($val['price'])?></span>
							<span id="" style="margin-left:5px;"><a href="#">바로구매</a></span>
							<span id=""><a href="/cart_lib/cart_one_add?product_id=<?=$val['id']?>">장바구니</a></span>
							<span id=""><a href="#">헬퍼</a> </span>
						</div>
						<!-- div class="gallery-image-controls">
<div class="action-btn" style="font-size:30px;"><a href="javasrcipt:;" id="">▶</a></div>
<!-- div class="action-btn">
<a class="gallery-image-open btn btn-teal btn-round tipB" title="Open image" href="assets/img/gallery/1.jpg"><i class="fa fa-search"></i></a>
<a class="gallery-image-download btn btn-teal btn-round tipB" title="Download" href="#"><i class="fa fa-download"></i></a>
<a class="gallery-image-delete btn btn-teal btn-round tipB" href="#" title="Delete"><i class="fa fa-trash-o"></i></a>
</div -->
						<!-- /div -->
					</div>
					<? endforeach; ?>
			</div>
			<!-- End .row -->
		</div>
	</div>
	<div class=""><a href="javascript:;" id="more" class="btn btn-primary btn-block mb10">더보기</a></div>
</div>
<input type="hidden" id="page" value="2" />
<input type="hidden" id="stay_cate_btn" value="" />
<input type="hidden" id="i" value="<?=$i?>" />
<script src="http://code.jquery.com/jquery-1.9.0.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
<script>
	$(document).ready(function () {
    $(document).on("scroll", onScroll);
 });
function onScroll(event){
	var scrollPos = $(document).scrollTop();
    //alert(scrollPos);
    var sum = $('.content-inner h1').position().top+ $('.content-inner h1').height();
    //$("#text").text(scrollPos+'__'+sum);
    if(scrollPos >= sum){
    	
    	$("#navbar_cate").addClass("navbar-fixed-top-fix");
    }else{
    	$("#navbar_cate").removeClass("navbar-fixed-top-fix");
    }
    //alert($('#navbar_cate a').position().top);  

}
</script>