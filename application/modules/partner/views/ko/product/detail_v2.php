<?
$is_oner = false;
if($review_oner >=1) $is_oner = true; 

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
	
	
	//
	
</script>
	
	<!-- #container -->
	<div id="container" class="clearfix">

<!-- 페이지 시작-->

<!-- view  -->
<div class="view">
	<!-- 카테고리탭 -->
	<div class="detail_category">
		<ul class="category_tab clearfix">
			<li><a class="keyword_tg collapsed" href="#keyword"  data-toggle="collapse">키워드 <i class="glyphicon glyphicon-menu-up"></i></a></li>
			<!-- li><a class="on" href="">ALL</a></li -->
			<!-- li><a href="/product/orderby/all" <?=$all?>>ALL</a></li -->
			<li><a href="/product/lists/?page=1&cate_id=1" <?=($product['categoryId'] == 1 AND $this->uri->segment(4) !== 'all')? 'class="on"':'' ?>>BABY&amp;KIDS</a></li>
			<li><a href="/product/lists/?page=1&cate_id=2" <?=($product['categoryId'] == 2 AND $this->uri->segment(4) !== 'all')? 'class="on"':'' ?>>LOVE</a></li>
			<li><a href="/product/lists/?page=1&cate_id=3" <?=($product['categoryId'] == 3 AND $this->uri->segment(4) !== 'all')? 'class="on"':'' ?>>WEDDING</a></li>			
			<li><a href="/product/lists/?page=1&cate_id=4" <?=($product['categoryId'] == 4 AND $this->uri->segment(4) !== 'all')? 'class="on"':'' ?>>BIRTHDAY</a></li>
			<li><a href="/product/lists/?page=1&cate_id=5" <?=($product['categoryId'] == 5 AND $this->uri->segment(4) !== 'all')? 'class="on"':'' ?>>TRAVEL</a></li>
			<li><a href="/product/lists/?page=1&cate_id=6" <?=($product['categoryId'] == 6 AND $this->uri->segment(4) !== 'all')? 'class="on"':'' ?>>D-Card</a></li>			
		</ul>
		<!-- 키워드 -->
		<div class="collapse" id="keyword">
			<i></i>
			<ul class="row">
				<? foreach($keyword_list as $key => $val): ?>
					<li class="col-sm-3 col-xs-6"><a href="#" class="" item="<?=$val['tag_name']?>"><?=$val['tag_name']?></a></li>							
				<? endforeach; ?>
				
				<!--li class="col-sm-3 col-xs-6"><a href="">고급스러운</a></li>
				<li class="col-sm-3 col-xs-6"><a href="">이벤트 &amp; 클럽</a></li>
				<li class="col-sm-3 col-xs-6"><a href="">사랑</a></li>
				<li class="col-sm-3 col-xs-6"><a href="">재미난</a></li>
				<li class="col-sm-3 col-xs-6"><a href="">부드러운</a></li>
				<li class="col-sm-3 col-xs-6"><a href="">자동차 &amp; 스포츠</a></li>
				<li class="col-sm-3 col-xs-6"><a href="">숙박 &amp; 부동산</a></li>
				<li class="col-sm-3 col-xs-6"><a href="">카페 &amp; 레스토랑</a></li>
				<li class="col-sm-3 col-xs-6"><a href="">성장동영상 &amp; 가족동영상</a></li>
				<li class="col-sm-3 col-xs-6"><a href="">전문적인</a></li>
				<li class="col-sm-3 col-xs-6"><a href="">앱 &amp; 게임</a></li>
				<li class="col-sm-3 col-xs-6"><a href="">태권도</a></li>
				<li class="col-sm-3 col-xs-6"><a href="">신규 템플릿</a></li>
				<li class="col-sm-3 col-xs-6"><a href="">크리스마스 템플릿</a></li>
				<li class="col-sm-3 col-xs-6"><a href="">여행 &amp; 여가</a></li>
				<li class="col-sm-3 col-xs-6"><a href="">학교 &amp; 학원</a></li>
				<li class="col-sm-3 col-xs-6"><a href="">엣지있는</a></li>
				<li class="col-sm-3 col-xs-6"><a href="">패션 &amp; 뷰티</a></li>
				<li class="col-sm-3 col-xs-6"><a href="">웨딩</a></li>
				<li class="col-sm-3 col-xs-6"><a href="">임신9개월</a></li>
				<li class="col-sm-3 col-xs-6"><a href="">열정적인</a></li>
				<li class="col-sm-3 col-xs-6"><a href="">광고영상</a></li>
				<li class="col-sm-3 col-xs-6"><a href=""></a></li-->
			</ul>
		</div>
	</div>
	<!-- 내용 -->
	<section class="view_cnt">
		<h2 class="sr-only">웨딩 영상 샘플</h2>
		<!-- 비디오 삽입부분 -->
		<div class="video_wrap">
			<!-- img class="img-responsive" src="_temp/tmb2.jpg" alt="" / -->
			<iframe class="_vimeoPlayer aligncenter" style="width:100%; " id="vimeoPlayer" src="http://player.vimeo.com/video/<?=$product['movieVimeoId']?>?api=1&player_id=<?=$product['movieVimeoId']?>&color=e54b63&autoplay=1&badge=0 " width="<?=$width?>" height="<?=$height?>" frameborder="0" mozallowfullscreen allowfullscreen >
				</iframe>
		</div>
		<div class="sns_link text-right pa15">
			<a href="javascript:facebookshare()">페이스북</a>
			<a href="javascript:twittershare()">트위터</a>
		</div>
		<!-- 정보 -->
		<section class="view_body bg_wh">
			<h2 class="text-center"><?=$product['name']?></h2>
			<hr class="hr">
			<div class="video_info row">
				<dl class="col-sm-3 col-xs-6 photo">
					<dt>PHOTO</dt>
					<dd><?=$product['imageText']?>장</dd>
				</dl>
				<dl class="col-sm-3 col-xs-6 text">
					<dt>TEXT</dt>
					<dd><?=$product['txt_chg']?></dd>
				</dl>
				<dl class="col-sm-3 col-xs-6 time">
					<dt>TIME</dt>
					<dd><?=$product['runtime']?>초</dd>
				</dl>
				<dl class="col-sm-3 col-xs-6 music">
					<dt>BGM</dt>
					<dd class="color_red"><?=$product['bgm_chg']?></dd>
				</dl>
			</div>
			<div class="price text-center">
				판매가 <strong class="color_red">￦<?=number_format($price)?></strong>
				<span class="price_ex color_red">($<?=$product['usd']?>)</span>
			</div>
			<div class="btn_area row pa15">
				<!-- span class="col-xs-6 pr5"><button type="button" id="btn_sale" class="btn btn-lg btn-block bg_red mb10">바로구매</button></span>
				<span class="col-xs-6 pl5"><button type="button" id="btn_cart" class="btn btn-lg btn-block mb10">장바구니</button></span -->
				
				
				<span class="col-xs-6 pr5"><a class="btn btn-lg btn-block bg_red mb10" href="<?=Base_url()?>cart_lib/link_one_add?product_id=<?=$product['id']?>">바로구매</a></span>
				<span class="col-xs-6 pl5"><a href="/cart_lib/cart_one_add?product_id=<?=$product['id']?>" class="btn btn-lg btn-block mb10">장바구니</a></span>
				
				
						
						
			</div>
			<hr class="hr">
			<div class="helper pa15 pr">
				<dl class="row">
					<dt>헬퍼서비스</dt>
					<dd class="pt5 fs12 color_grey">9,900원이 추가되는 동영상 제작대행 서비스 입니다.</dd>
				</dl>
				<a href="/main/helper/<?=$product['id']?>">바로가기 &gt;</a>
			</div>
		</section>
		<hr class="hr mt5">
		<!-- 댓글 -->
		<div class="cmt_box">
			<p class="color_grey pb15">
				고객님이 작성해주신 상품평이 총 <strong class="color_red">0</strong>개 있습니다.
			</p>
			<!-- 댓글목록 -->
			<div class="cmt_lst">
				<table class="table v2">
					<thead>
						<tr>
							<th class="grade" scope="col">평점</th>
							<th scope="col">제목</th>
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
								<div>
									<a href="/review/detail/<?=$val['id']?>"><?=$val['title']?></a>
								</div>
								<div class="meta">
									<?=$val['memberName']?> / <?=date('Y.m.d',strtotime($val['createDatetime']))?>
								</div>
							</td>
						</tr>
						<!-- 테이블형 내용 출렧 -->
						<tr class="table_cnt">
							<td></td>
							<td class="td_cnt">
								<div class="content">
									<?=$val['content']?>
								</div>
							</td>
						</tr>
						<? endforeach; ?>						
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
			
			
			
			<!-- 댓글작성 -->
			
			<div class="cmt_wrt_wrp bg_f1">
				<? if($is_oner){ ?>
				<form class="bx2" action="/product/review/insert" method="post" enctype="multipart/form-data" id="form_post_review">
					<input type="hidden" name="productId" value="<?=$product['id']?>" />
					<input type="hidden" name="uri_1" value="<?=$this->uri->segment(1)?>" />
					<input type="hidden" name="uri_2" value="<?=$this->uri->segment(2)?>" />
					<input type="hidden" name="uri_3" value="<?=$this->uri->segment(3)?>" />
					
					<div class="form-group star_regist">
						<label class="radio-inline">
							<input type="radio" name="score" value="5">
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
						<label for="picFile" class="col-sm-2 control-label pt10 fs16">사진등록</label>
						<div class="col-sm-10">
							<input type="file" name="userfile" id="picFile" class="form-control input-lg">
						</div>
					</div>
					<div class="row">
						<div class="col-sm-9 col-xs-12 pb20 fs16 fs13-xs">
							<p>무비에 대한 문의사항은 <a href="mailto:cs@thedays.co.kr" class="color_blue">cs@thedays.co.kr</a>로 문의하시면 빠른 시간내에 답변 드리겠습니다.</p>
						</div>
						<div class="col-sm-3 col-xs-12">
							<!-- button type="submit" class="btn btn-lg btn-block bg_red">리뷰 등록</button -->
							<a class="btn btn-lg btn-block bg_red" href="javascript:insert('review');">리뷰등록</a>
						</div>
					</div>
				</form>
				<?  }?>
			</div>
			
			
		
		
		</div>
	</section>
	
	<!-- 하단슬라이드 -->
	<div class="view_slider">
		<ul>
			<? $j=1; foreach($product_chain_list as $key => $val): ?>
				
				<li><a data-slide-index="<?=$j++?>" href="/product/detail/<?=$val['id']?>">
						<img src="<?=IMG_O_PATH?>/resources/uploads/product/image/<?=$val['imageSFile']?>" alt="">
						<span class="ellipsis"><?=$val['name']?></span>
					</a>
				</li>
			<? endforeach; ?>	
		</ul>
	</div>
<script>
jQuery(function($){
	$('.view_slider ul').bxSlider({
		pager:false,
		minSlides:3,
		maxSlides:3,
		slideWidth:230,
		slideMargin:6,
		infiniteLoop:false
	});
});

//common
function insert(para) {
	//alert(para);
	//form_post_review	
		$('#form_post_' + para).ajaxForm({
			dataType: "json",
			beforeSubmit: function (data, form, option) {
				//validation체크 
				//막기위해서는 return false를 잡아주면됨
				return true;
			},
			success: function (response, status) {
				
				if(response.status == "T") {
					alert(response.message);
					document.location.reload();
				}else{
					alert(response.message);
				}
			},
			error: function (response, status) {
				
				alert('error  {'+status+'}\r\n'+response);
				document.location.reload();
			}
		});
		$('#form_post_' + para).submit();
}
</script>
</div>

<!-- //페이지 끝-->

	</div>
	<!-- //container -->
