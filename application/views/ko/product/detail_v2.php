<?
	$is_oner = false;
	if($review_oner >=1) $is_oner = true;

	$all = "";
	if($this->uri->segment(4) == 'all') $all = 'class="on"';
	$imageText = explode('/', $product['imageText']);
	$exchange = exchange("USD");
	$price = $product['price'];
	if($product['eventPrice'] > 0 )$price = $product['eventPrice'];

	$width = "720px";
	$height = "404px";

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
		//페이스북
		window.fbAsyncInit = function() {
			FB.init({
				appId: '777581829031957',
				xfbml: true,
				version: 'v2.4'
			});
		};

		(function(d, s, id) {
			var js, fjs = d.getElementsByTagName(s)[0];
			if (d.getElementById(id)) {
				return;
			}
			js = d.createElement(s);
			js.id = id;
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

		//하단 슬라이드
		jQuery(function($) {
			$('.view_slider ul').bxSlider({
				pager: false,
				minSlides: 3,
				maxSlides: 3,
				slideWidth: 230,
				slideMargin: 6,
				infiniteLoop: false
			});
		});

	</script>

	<!-- #container -->
	<div id="container" class="clearfix">

		<!-- 페이지 시작-->
		<!-- view  -->
		<div id="index">
			<section id="sect2" class="row pb20">

				<ul class="category_tab clearfix">
					<li><a class="keyword_tg collapsed" href="#keyword" data-toggle="collapse">키워드 <i class="glyphicon glyphicon-menu-up"></i></a></li>
					<li><a href="/product/lists/?page=1&cate_id=all">ALL</a></li>
					<li><a href="/product/lists/?page=1&cate_id=1" <?=($product[ 'categoryId']==1 )? 'class="on"': '' ?>>BABY&amp;KIDS</a></li>
					<li><a href="/product/lists/?page=1&cate_id=2" <?=($product[ 'categoryId']==2 )? 'class="on"': '' ?>>LOVE</a></li>
					<li><a href="/product/lists/?page=1&cate_id=3" <?=($product[ 'categoryId']==3 )? 'class="on"': '' ?>>WEDDING</a></li>
					<li><a href="/product/lists/?page=1&cate_id=4" <?=($product[ 'categoryId']==4 )? 'class="on"': '' ?>>ANNIVERSARY</a></li>
					<li><a href="/product/lists/?page=1&cate_id=5" <?=($product[ 'categoryId']==5 )? 'class="on"': '' ?>>TRAVEL</a></li>
					<li><a href="/product/lists/?page=1&cate_id=6" <?=($product[ 'categoryId']==6 )? 'class="on"': '' ?>>D-Card</a></li>
					<li><a href="/product/lists/?page=1&cate_id=7" <?=($product[ 'categoryId']==7 )? 'class="on"': '' ?>>BUSINESS</a></li>
				</ul>
				<!-- 키워드 -->
				<div class="collapse" id="keyword">
					<i></i>
					<ul class="row">
						<? foreach($keyword_list as $key => $val): ?>
							<li class="col-sm-3 col-xs-6">
								<a href="#" class="" item="<?=$val['tag_name']?>">
									<?=$val['tag_name']?>
								</a>
							</li>
							<? endforeach; ?>
					</ul>
				</div>

			</section>
		</div>
		<div class="view">
			<!-- 카테고리탭 -->

			<!-- 내용 -->
			<section class="view_cnt">
				<h2 class="sr-only">웨딩 영상 샘플</h2>
				<!-- 비디오 삽입부분 -->
				<div class="video_wrap">
					<!-- img class="img-responsive" src="_temp/tmb2.jpg" alt="" / -->
					<iframe class="_vimeoPlayer aligncenter" style="width:100%; " id="vimeoPlayer" src="https://player.vimeo.com/video/<?=$product['movieVimeoId']?>?api=1&player_id=<?=$product['movieVimeoId']?>&color=e54b63&autoplay=1&badge=0 " width="<?=$width?>" height="<?=$height?>" frameborder="0" mozallowfullscreen allowfullscreen>
					</iframe>
				</div>
				<div class="sns_link text-right pa15">
					<!--a href="javascript:facebookshare()">페이스북</a>
					<a href="javascript:twittershare()">트위터</a -->
				</div>
				<!-- 정보 -->
				<section class="view_body bg_wh">
					<h2 class="text-center"><?=$product['name']?></h2>
					<div class="video_info row">
						<dl class="col-sm-3 col-xs-6 photo">
							<dt>PHOTO</dt>
							<dd>
								<?=$product['imageText']?>장</dd>
						</dl>
						<dl class="col-sm-3 col-xs-6 text">
							<dt>TEXT</dt>
							<dd>
								<?=$product['txt_chg']?>
							</dd>
						</dl>
						<dl class="col-sm-3 col-xs-6 time">
							<dt>TIME</dt>
							<dd>
								<?=$product['runtime']?>초</dd>
						</dl>
						<dl class="col-sm-3 col-xs-6 music">
							<dt>BGM</dt>
							<dd class="">
								<?=$product['bgm_chg']?>
							</dd>
						</dl>
					</div>
					<div class="price text-center">
						판매가 <strong class="color_red">￦<?=number_format($price)?></strong>
						<span class="price_ex color_red">($<?=$product['usd']?>)</span>
					</div>
					<div class="btn_area row">
						<? if($product['id'] == 180 || $product['id']== 17){ ?>
							<span class="col-xs-12 pl3"><a class="btn btn-lg btn-block bg_red mb10" href="/main/helper/<?=$product['id']?>">헬퍼 서비스 신청</a></span>
						<? } else { ?>
							<span class="col-xs-6 pr3"><a class="btn btn-lg btn-block bg_red mb10" href="<?=BASE_URL?>/cart_lib/link_one_add?product_id=<?=$product['id']?>">바로구매</a></span>
							<span class="col-xs-6 pl3"><a class="btn btn-lg btn-block mb10" href="/cart_lib/cart_one_add?product_id=<?=$product['id']?>">장바구니</a></span>
							<? if (!$this->agent->is_mobile()){  //pc 에서만 나타남 ?>
								<span class="col-xs-6 pl3"><a href="javascript:;" class="btn btn-lg btn-block bg_blue mb10 move_exp_start" href="/cart_lib/cart_one_add?product_id=<?=$product['id']?>" data-id="<?=$product['id']?>">무료로 체험하기</a></span>
							<? } ?>
						<? } ?>
					</div>
					<hr class="hr">
					<? if($product['id'] == 180 || $product['id']== 17){ ?>

						<? } else { ?>
					<div class="helper">

						<dl>
							<dt>헬퍼서비스</dt>
							<dd class="pt5 fs12 ">9,900원이 추가되는 동영상 제작대행 서비스 입니다.(일부상품제외)</dd>
						</dl>
						<a href="/main/helper/<?=$product['id']?>">바로가기 &gt;</a>
					</div>
					<? } ?>
				</section>
				<!-- 상품평 -->
				<div class="cmt_box">
					<div class="cmt_count bg_f0">
						고객님이 작성해주신 상품평이 총 <strong class="color_red"><?=$product_review_list_total?>개</strong> 있습니다.
					</div>
					<ul class="lst_notice">
						<? foreach($product_review_list as $key => $val): ?>
							<li>
								<a href="/review/detail/<?=$val['id']?>">
									<div class="meta2">
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
									</div>
									<div class="meta">
										<span class="color_blue2">상품명 <b class="fw500"><?=$val['product_name']?></b></span>
										<i class="split"></i>
										<?=mb_substr($val['memberName'],0,1)."*".mb_substr($val['memberName'],2,1)?>
											<i class="split"></i> 조회수
											<?=number_format($val['viewCount'])?>
									</div>
									<h3><?=$val['title']?></h3>
								</a>
							</li>
							<? endforeach; ?>
					</ul>
					<!-- 댓글작성 -->
					<form class="bx2 form-horizontal" action="/review/ajax_insert_review/insert" method="post" enctype="multipart/form-data" id="form_post_review" accept="file_extension|image/*|media_type">
						<input type="hidden" name="productId" value="<?=$product['id']?>" />
						<input type="hidden" name="uri_1" value="<?=$this->uri->segment(1)?>" />
						<input type="hidden" name="uri_2" value="<?=$this->uri->segment(2)?>" />
						<input type="hidden" name="uri_3" value="<?=$this->uri->segment(3)?>" />

						<input type="hidden" name="score" id="score" value="1">

						<fieldset class="pt30 bg_f0">
							<h3 class="mb15 text-center"><u class="fs14 color_red">리뷰작성</u></h3>
							<div class="review_wrt">
								<span class="star_wrp form-control">
									<i class="fa fa-star on" role="button"></i>
									<i class="fa fa-star" role="button"></i>
									<i class="fa fa-star" role="button"></i>
									<i class="fa fa-star" role="button"></i>
									<i class="fa fa-star" role="button"></i>
								</span>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label color_blue2">제목</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" name="title">
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label color_blue2">내용</label>
								<div class="col-sm-10">
									<textarea class="form-control" rows="5" name="content" id="content"></textarea>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label color_blue2">첨부파일</label>
								<div class="col-sm-10">
									<button type="button" class="btn bg_blue2 btn_radius w110 pull-right btn_upload">파일 선택</button>
									<p class="fs12 color_grey">*5Mbyte 미만의 파일만 허용</p>
									<div class="mt5 fs13 color_blue2 file_text">선택된 파일 없음</div>
									<input type="file" class="form-control upload" id="photo" name="userfile">
								</div>
							</div>
							<div class="row pt20">
								<a class="btn btn-block bg_red" href="javascript:insert('review');">리뷰등록</a>
							</div>
						</fieldset>
					</form>
				</div>
			</section>
			<!-- 다른 비디오 더보기 -->
			<section class="reladted_itm">
				<h3 class="color_red">다른 비디오 더보기</h3>
				<ul>
					<? $j=1; foreach($product_chain_list as $key => $val): ?>
						<li>
							<a data-slide-index='<?=$j++?>' href="/product/detail/<?=$val['id']?>">
							<img src='<?=IMG_O_PATH?>/resources/uploads/product/image/<?=$val["imageSFile"]?>'/>
							<h4 class="ellipsis"><?=$val['name']?></h4></a>
						</li>
						<? endforeach; ?>
				</ul>
			</section>
		</div>

		<script>
			jQuery(function($) {
				// 별점
				$('.review_wrt .fa-star').click(function() {
					$(this).addClass('on').prevAll().addClass('on').end().nextAll().removeClass('on');
					$("#score").val($('.review_wrt span > .on').length);
				});

				// 다른 비디오
				$('.reladted_itm>ul').bxSlider({
					pager: false,
					slideWidth: 140,
					minSlides: 3,
					maxSlides: 3,
					slideMargin: 10
				});

				$(".btn_upload").click(function() {
					$(".upload").click();
				});
				$(".upload").change(function() {
					$(".file_text").text($(this).val());
				});

			});

		</script>

		<!-- //페이지 끝-->

	</div>
	<!-- //container -->
