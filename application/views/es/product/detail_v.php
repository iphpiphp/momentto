<?
$all = "";
if($this->uri->segment(4) == 'all') $all = 'class="on"';
$imageText = explode('/', $product['imageText']);
$exchange = exchange("USD"); 
$price = $product['price'];
if($product['eventPrice'] > 0 )$price = $product['eventPrice'];

$width = "960px";
$height = "650px";

 if ($this->agent->is_mobile()){
	$width = "370px";
	$height = "215px"; 	
 }


if($product['imageText']){
	$imageText = explode("/",$product['imageText']);
	$product['imageText'] =$imageText[0] + $imageText[1]; 
}else{
	$product['imageText'] = 0;
}

$product['runtime'] = str_replace(":", "분 ", $product['runtime']);

?>
<!-- #container -->
	<div id="container" class="clearfix">

<!-- 페이지 시작-->

<!-- view  -->
<div class="view">
	<!-- 카테고리탭 -->
	<div class="detail_fixed-top-fix " style="width:100%">
	<div class="detail_category clearfix">
		<ul class=" category_tab w1140 clearfix ">
			<li class="hidden-xs"><a></a></li>
			<li><a href="/product/orderby/all" <?=$all?>>ALL</a></li>
			<li><a href="/product/orderby/1" <?=($product['categoryId'] == 1 AND $this->uri->segment(4) !== 'all')? 'class="on"':'' ?>>BABY&amp;KIDS</a></li>
			<li><a href="/product/orderby/2" <?=($product['categoryId'] == 2 AND $this->uri->segment(4) !== 'all')? 'class="on"':'' ?>>LOVE</a></li>
			<li><a href="/product/orderby/3" <?=($product['categoryId'] == 3 AND $this->uri->segment(4) !== 'all')? 'class="on"':'' ?>>WEDDING</a></li>			
			<li><a href="/product/orderby/4" <?=($product['categoryId'] == 4 AND $this->uri->segment(4) !== 'all')? 'class="on"':'' ?>>BIRTHDAY</a></li>
			<li><a href="/product/orderby/5" <?=($product['categoryId'] == 5 AND $this->uri->segment(4) !== 'all')? 'class="on"':'' ?>>TRAVEL</a></li>
			<li><a href="/product/orderby/6" <?=($product['categoryId'] == 6 AND $this->uri->segment(4) !== 'all')? 'class="on"':'' ?>>SALE</a></li>			
			<!-- li><a href="#">BUSINESS</a></li>
			<li><a href="#">FREE</a></li -->
		</ul>
	</div>
	</div>
	<script>
  window.fbAsyncInit = function() {
    FB.init({
      appId      : '777581829031957',
      xfbml      : true,
      version    : 'v2.4'
    });
  };

  (function(d, s, id){
     var js, fjs = d.getElementsByTagName(s)[0];
     if (d.getElementById(id)) {return;}
     js = d.createElement(s); js.id = id;
     js.src = "//connect.facebook.net/en_US/sdk.js";
     fjs.parentNode.insertBefore(js, fjs);
   }(document, 'script', 'facebook-jssdk'));
  window.twttr = (function(d, s, id) {
	  var js, fjs = d.getElementsByTagName(s)[0],
	    t = window.twttr || {};
	  if (d.getElementById(id)) return t;
	  js = d.createElement(s);
	  js.id = id;
	  js.src = "https://platform.twitter.com/widgets.js";
	  fjs.parentNode.insertBefore(js, fjs);
	 
	  t._e = [];
	  t.ready = function(f) {
	    t._e.push(f);
	  };
	 
	  return t;
	}(document, "script", "twitter-wjs"));

jQuery(function($){
	$('#viewSlidePager').bxSlider({
		pager:false,
		minSlides:2,
		maxSlides:4,
		slideWidth:230,
		slideMargin:15,
		infiniteLoop:false
	});
	$('#viewSlidePager > li > a').click(function(){
		var id=  $(this).attr("data-id");
		document.location.href = "/product/detail/"+id;
		/*
		var index=  $(this).attr("data-slide-index");
		var movieId = $(this).attr("item");
		var html = '<iframe class="_vimeoPlayer aligncenter" style="width:100%; " id="vimeoPlayer" src="http://player.vimeo.com/video/'+movieId+'?api=1&player_id='+movieId+'&color=e54b63" width="738px" height="416" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>'; 
		$("#vimeo_"+index).html(html);
		*/
	});
	
	$('#viewSlide').bxSlider({
		mode:'fade',
		controls:false,
		pagerCustom:'#viewSlidePager',
		infiniteLoop:false
	});
});
</script>
	<!-- slide : http://bxslider.com/examples/thumbnail-pager-1 -->
	<section class="view_slide " >
		<div style="width:100%; background: #484142">
			<div class="w1140" style="padding:0 0px;">
			<h2 class="sr-only">promotion</h2>
				<div class="" style="margin-top:100px;">
				<ul id="viewSlide" style="">
					
					<li><a class="banner" href="#"><iframe class="_vimeoPlayer aligncenter" style="width:100%; " id="vimeoPlayer" src="http://player.vimeo.com/video/<?=$product['movieVimeoId']?>?api=1&player_id=<?=$product['movieVimeoId']?>&color=e54b63&autoplay=1&badge=0 " width="<?=$width?>" height="<?=$height?>" frameborder="0" mozallowfullscreen allowfullscreen >
				</iframe></a></li>
					<? $i=1; foreach($product_chain_list as $key => $val): ?>
						<li><a class="banner" href="#"><div id="vimeo_<?=$i++?>"></div></a></li>
					<? endforeach; ?>
				
				</ul>
			</div>
			
			</div>
		</div>
		
		
			<div class="view_slide_pager">
				<ul id="viewSlidePager">
					<li ><img src="<?=IMG_O_PATH?>/resources/uploads/product/image/<?=$product['imageSFile']?>" alt=""><h5 class="ellipsis"><?=$product['name']?></h5></li>
					<? $j=1; foreach($product_chain_list as $key => $val): ?>
						<li><a data-id="<?=$val['id']?>" item="<?=$val['movieVimeoId']?>" data-slide-index="<?=$j++?>" href=""><img src="<?=IMG_O_PATH?>/resources/uploads/product/image/<?=$val['imageSFile']?>" alt=""><h5 class="ellipsis"><?=$val['name']?></h5></a></li>
					<? endforeach; ?>
				</ul>
			</div>
		</div>
		

	</section>
	<section class="view_body bg_wh">		
		<div class="w1140 pt20">		
			<div class="text-right" style="position: relative; margin-right: -10px">
				<div class="text-left" style="position: absolute; top:10px; font-size: 19px; left:-8px;"><?=$product['name']?></div>
				<a href="javascript:facebookshare()" class="btn btn-primary btn-alt btn-round btn-lg " style="border:1px solid #2D31D8;"><i class="fa fa-facebook" style="color: #2D31D8; width:15px;"></i></a>
				<a href="javascript:twittershare()" class="btn btn-primary btn-alt btn-round btn-lg " style="border:1px solid #E4D612;"><i class="fa fa-twitter " style="color: #E4D612; width:15px;"></i></a>		
			</div>
			
			
			<hr class="hr">
			<article class="row">
				<div class="col-sm-6 col-xs-12 pr40 pr0-xs">
					<!-- 정보 -->
					<dl class="dl-horizontal mb30 mb15-xs fs16 fs13-xs">
						<dt><i class="icon_photo"></i> PHOTO</dt>
						<dd><?=$product['imageText']?> 장</dd>
						<dt><i class="icon_time"></i> TIME</dt>
						<dd><?=$product['runtime']?>초</dd>
						<dt><i class="icon_text"></i> TEXT</dt>
						<dd><!-- <?=$product['movieText']?> -->  <span class="color_red"><?=$product['txt_chg']?></span></dd>
						<dt><i class="icon_music"></i> BGM</dt>
						<dd><!--<?=$product['originalMusic']?>--> <span class="color_red"><?=$product['bgm_chg']?></span></dd>
					</dl>
					<!-- 요약 -->
					<div class="fs16 fs14-xs color_grey"><?=$product['info_text']?>
						<?// print_r($product); ?>
					</div>
				</div>
				<div class="col-sm-6 col-xs-12 pl40 pl0-xs text-right">
					<div class="price">
						판매가 <strong class="color_red"> ￦  <?=number_format($price)?><!-- &nbsp;&nbsp;/&nbsp;$ <?=$product['usd']?> --></strong>
						<!--- p class="price_ex color_red">$ <?=round($price/$exchange,2)?></p -->
					</div>
					<div class="col-sm-offset-4">						
						<a class="btn btn-lg btn-block bg_red mb10" href="<?=Base_url()?>cart_lib/link_one_add?product_id=<?=$product['id']?>">바로구매</a>
						<a href="/cart_lib/cart_one_add?product_id=<?=$product['id']?>" class="btn btn-lg btn-block mb10">장바구니</a>						
					</div>
				</div>
			</article>
			<hr class="hr">
			<?  if (!$this->agent->is_mobile()){ ?>
			<div class="row">
				<div class="col-sm-6 col-xs-12 pr10 pr0-xs">
					<div class="media bx pa30 pa15-xs mb10 fs16 fs14-xs">
						<div class="media-body media-middle">
							무비메이커가 어려우시거나 시간이 없으시다면
						</div>
						<div class="media-right media-middle pt10 pb10 text-nowrap">
							<a class="fs20 fs16-xs color_red" href="/main/helper/<?=$product['id']?>"><u>헬퍼서비스</u></a>
						</div>
					</div>
				</div>
				<div class="col-sm-6 col-xs-12 pl10 mb10 pl0-xs">
					<div class="media bx pa30 pa15-xs fs16 fs14-xs">
						<div class="media-body media-middle">
							헬퍼서비스 제작의뢰시 정리폴더를 다운받으시고 <br class="hidden-xs">폴더내용으로 정리하시면 영상 제작이 수월해집니다
						</div>
						<div class="media-right media-middle pt10 pb10 text-nowrap">
							<a class="fs20 fs16-xs color_blue" href="/product/filedown/setcode_<?=$this->uri->segment(3)?>.zip/set.zip"><u>사진정리폴더 다운</u></a>
						</div>
					</div>
				</div>
			</div>
			<? } ?>
			
			
			<!-- 댓글 -->
			<div class="row pt40 pb40">
				<div class="col-sm-6 col-xs-12 cmt_star pb10">					
					<!-- 별점 -->
					<!--span class="star_wrp">
						<i class="fa fa-star on"></i>
						<i class="fa fa-star on"></i>
						<i class="fa fa-star on"></i>
						<i class="fa fa-star on"></i>
						<i class="fa fa-star"></i>
					</span>
					<strong>5</strong -->
				</div>
				<div class="col-sm-6 col-xs-12 pt20 pt0-xs mb15-xs text-right text-left-xs color_grey fs20 fs14-xs">
					고객님이 작성해주신 상품평이 총 <strong class="color_red"><?=$product_review_list_total?></strong>개 있습니다.
				</div>
				<div class="col-xs-12">
					<!-- 댓글 -->
					<table class="table v2">
						<thead>
							<tr>
								<th>평점</th>
								<th>제목</th>
								<th class="hidden-xs">작성자</th>
								<th class="hidden-xs">등록일</th>
								<th class="hidden-xs">조회수</th>
							</tr>
						</thead>
						<tbody>
							<? foreach($product_review_list as $key => $val): ?>
							<tr>
								<td>
									<!-- 별점 -->
									<span class="star_wrp sm">
										<? for($i=1; 5>=$i; $i++){
											if($val['score'] >= $i){
												 echo '<i class="fa fa-star on"></i>';
											}else{
												 echo '<i class="fa fa-star"></i>';
											}	
										} ?>
									</span>
								</td>
								<td class="title">
									<a href="/review/detail/<?=$val['id']?>"><?=$val['title']?></a>
									<div class="meta visible-xs-block">
										 / 
									</div>
								</td>
								<td class="hidden-xs"><?=$val['memberName']?></td>
								<td class="hidden-xs"><?=date('Y.m.d',strtotime($val['createDatetime']))?></td>
								<td class="hidden-xs"><?=$val['viewCount']?></td>
							</tr>
							<? endforeach; ?>
							<!-- 테이블형 내용 출렧 -->
							<!--tr class="table_cnt">
								<td></td>
								<td class="td_cnt">
									<div class="content">
내일 프로포즈 할꺼라서 긴급하게 제작했는데, 너무 완성도가 높네요. <br>
그리고 업로드 하고 빠른 처리해주셔서 감사합니다.<br>
내일 프로포즈 할꺼라서 긴급하게 제작했는데, 너무 완성도가 높네요. <br>
그리고 업로드 하고 빠른 처리해주셔서 감사합니다.<br>
									</div>
								</td>
								<td class="hidden-xs"></td>
								<td class="hidden-xs"></td>
								<td class="hidden-xs"></td>
							</tr -->							
						</tbody>
					</table>
					<!-- nav class="text-center">
						<ul class="pagination">
							<li><a href="#" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a></li>
							<li class="active"><a href="#">1</a></li>
							<li><a href="#">2</a></li>
							<li><a href="#">3</a></li>
							<li><a href="#">4</a></li>
							<li><a href="#">5</a></li>
							<li><a href="#" aria-label="Next"><span aria-hidden="true">&raquo;</span></a></li>
						</ul>
					</nav -->
				</div>
			</div>
		</div>
		<div class="cmt_wrt_wrp bg_f1 pt15-xs pb15-xs">
			<div class="w1140">
				<form class="bx2" action="/product/review/insert" method="post" enctype="multipart/form-data" id="form_post_review">					
					<input type="hidden" name="productId" value="<?=$product['id']?>" />
					<input type="hidden" name="uri_1" value="<?=$this->uri->segment(1)?>" />
					<input type="hidden" name="uri_2" value="<?=$this->uri->segment(2)?>" />
					<input type="hidden" name="uri_3" value="<?=$this->uri->segment(3)?>" />
								
					<div class="form-group star_regist">
						<label class="radio-inline">
							<input type="radio" name="score" value="5" checked="checked">
							<!-- 별점 -->
							<span class="star_wrp sm">
								<i class="fa fa-star on"></i>
								<i class="fa fa-star on"></i>
								<i class="fa fa-star on"></i>
								<i class="fa fa-star on"></i>
								<i class="fa fa-star on"></i>
							</span>
						</label>
						<label class="radio-inline">
							<input type="radio" name="score" value="4">
							<!-- 별점 -->
							<span class="star_wrp sm">
								<i class="fa fa-star on"></i>
								<i class="fa fa-star on"></i>
								<i class="fa fa-star on"></i>
								<i class="fa fa-star on"></i>
								<i class="fa fa-star"></i>
							</span>
						</label>
						<label class="radio-inline">
							<input type="radio" name="score" value="3">
							<!-- 별점 -->
							<span class="star_wrp sm">
								<i class="fa fa-star on"></i>
								<i class="fa fa-star on"></i>
								<i class="fa fa-star on"></i>
								<i class="fa fa-star"></i>
								<i class="fa fa-star"></i>
							</span>
						</label>
						<label class="radio-inline">
							<input type="radio" name="score" value="2">
							<!-- 별점 -->
							<span class="star_wrp sm">
								<i class="fa fa-star on"></i>
								<i class="fa fa-star on"></i>
								<i class="fa fa-star"></i>
								<i class="fa fa-star"></i>
								<i class="fa fa-star"></i>
							</span>
						</label>
						<label class="radio-inline">
							<input type="radio" name="score" value="1">
							<!-- 별점 -->
							<span class="star_wrp sm">
								<i class="fa fa-star on"></i>
								<i class="fa fa-star"></i>
								<i class="fa fa-star"></i>
								<i class="fa fa-star"></i>
								<i class="fa fa-star"></i>
							</span>
						</label>
					</div>
					<div class="form-group">
						<input type="text" name="title" class="form-control input-lg" placeholder="제목">
					</div>
					<div class="form-group">
						<textarea rows="5" name="content" class="form-control input-lg" placeholder="내용 (무비에 대한 문의사항은 고객센터를 이용해 주세요.)"></textarea>
					</div>
					<div class="row form-group">
						<label for="file" class="col-sm-2 control-label pt10 fs16">사진등록</label>
						<div class="col-sm-10">
							<input type="file" name="userfile" class="form-control input-lg">
						</div>
					</div>
					<div class="row">
						<div class="col-sm-9 col-xs-12 pt15 pb20 fs16 fs13-xs">
							<p>무비에 대한 문의사항은 <a href="/customer/emailaq_view"><span class="color_blue">cs@thedays.co.kr</span></a>로 문의하시면 빠른 시간내에 답변 드리겠습니다.</p>
						</div>
						<div class="col-sm-3 col-xs-12">							
							<a class="btn btn-lg btn-block bg_red" href="javascript:insert('review');">리뷰등록</a>
						</div>
					</div>
				</form>
			</div>
		</div>
	</section>
</div>

<!-- //페이지 끝-->

	</div>
	<!-- //container -->