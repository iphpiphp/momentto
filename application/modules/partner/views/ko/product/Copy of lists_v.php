<form action="" method="get" id="form_page">
<input type="hidden" name="cate_id" id="cate_id" value="0" />
</form>

<div class="container">
	<div class="container">
		<div class="content-wrapper">
			<div class="content-inner">
				<!-- Start .row -->
				<div class="row">
					<div class="gallery">
						<ul>
							<li><a href="javascript:cate_page(0);" item="0">전체</a></li>
							<li><a href="javascript:cate_page(1);" item="1">베이비</a></li>
							<li><a href="javascript:cate_page(2);" item="2">러브</a></li>
							<li><a href="javascript:cate_page(3);" item="3">웨딩</a></li>
							<li><a href="javascript:cate_page(4);" item="4">생일</a></li>
							<li><a href="javascript:cate_page(5);" item="5">여행</a></li>
							<li><a href="javascript:cate_page(6);" item="6">기타</a></li>
						</ul>
						<div class="page-nation">
							<ul class="pagination">
								<?=$page_nation?>
							</ul>
						</div>

						<ul class="item-list">
							<? foreach($lists as $key => $val): ?>
								<div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
									<li>
										<div class="prd-item">
											<div class="item-info">
												<div class="top">
													<p class="thumb">
														<a href="<?=Base_url()?>product/detail/<?=$val['id']?>">
									<img src="http://test.thedays.co.kr/<?=$val['imagePath']?>/<?=$val['imageMFile']?>" alt="item thumbnail image" />
									<span class="frame"></span>
								</a>
													</p>
												</div>
												<div class="bottom">
													<h4 class="tit"><a href="<?=Base_url()?>product/detail/<?=$val['id']?>"><?=$val['name']?></a></h4>
													<ul class="desc">
														<li class="first">
															<?=$val['genre']?>
														</li>
														<li>
															<?=str_replace(":","분 ",$val['runtime'])?> 초</li>
														<li>1280 HD (16:9)</li>
													</ul>
													<p class="price">
														<span class="sell-price"><?=number_format($val['price'])?></span>
														<span class="offer-price dc">￦<?=($val['eventPrice'] >0)? number_format($val['eventPrice']):number_format($val['price']);?></span>
													</p>
												</div>

												<span class="set-icon flag-icon ficon-fun">FUN</span>
												<span class="flag-icon ficon-best">Best seller!</span>
											</div>
											<!-- .prd-info -->
											<div class="prd-buy-btns">
												<a href="#" class="prdBtn prdBtn-buy orderBtn" data-id="17">바로구매</a>
												<a href="#" class="prdBtn prdBtn-cart cartBtn" data-pid="17" data-cid="1">장바구니</a>
											</div>
											<!-- .prd-buy-btns -->
										</div>
										<!-- .prd-item -->
									</li>
								</div>
								<? endforeach; ?>
						</ul>
						<!-- .item-list -->

					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="page-nation">
		<ul class="pagination">
			<?=$page_nation?>
		</ul>
	</div>
</div>