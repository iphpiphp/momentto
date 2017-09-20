<div class="container">
	<div class="row">
		<div class="col-lg-12">
			<div class="col-lg-2">
				<?=aside_left_mypage()?>
			</div>

			<div class="col-lg-9">
				<h3 style="    border-bottom: 4px solid #6e6c6a; ">취소/환불</h3>

				<div id="content-main">
					<!-- section class="my-dashboard">
					<p class="greeting">
					<span class="username"><i>김성현</i>님 안녕하세요?</span>&nbsp;&nbsp;
					<a href="/myPage/myInfo.html" class="underline">개인정보 수정/변경</a>
					</p>
					<div class="assets">
					<span class="point">적립금 : <u><a href="/myPage/point.html" class="underline">￦18,100</a></u></span>
					<span class="divider">|</span>
					<span class="point">보유쿠폰 : <u><a href="/myPage/coupon.html" class="underline">3</a></u>개</span>
					<a href="/myPage/coupon.html" class="global-btn gbtn-e"><span class="in">쿠폰등록하기</span></a>
					</div>
					<div class="box">
					<ul class="order-state">
					<li><a href="/myPage/cart.html"><span class="tit">장바구니</span><span class="value">4</span></a></li>
					<li><a href="/myPage/myMovie.html"><span class="tit">주문접수</span><span class="value">0</span></a></li>
					<li><a href="/myPage/myMovie.html"><span class="tit">결제완료</span><span class="value">8</span></a></li>
					<li class="upload"><a href="/myPage/myMovie.html"><span class="tit">무비메이커<br>진행중</span><span class="value">0</span></a></li>
					<li><a href="/myPage/myMovie.html"><span class="tit">무비완료</span><span class="value">4</span></a></li>
					<li><a href="/myPage/return.html"><span class="tit">취소/환불</span><span class="value">0</span></a></li>
					</ul>						
					</div>
					</section -->
					<!-- .my-dashboard -->
					<section class="my-movie">
						
						고객님이 구입 하신 상 품 중 취소/환불이 가능한 상품 내역 입니다.
						<div class="page-nation">
							<ul class="pagination">
								<?=$page_nation?>
							</ul>
						</div>
						<? 

						foreach($lists as $key => $val):
						$status_div = "ready-item"; // ready-item 	progress-item	complete-item
						if($val['status'] == '03' && $val['startDatetime']) $status_div = "progress-item";						
						if($val['status'] == '10') $status_div = "progress-item";
						if($val['status'] >= 10 && $val['isDelete'] == 1) $status_div = "progress-item"; //삭제됨
						if($val['status'] == '11' && $val['isDelete'] == 0) $status_div = "complete-item";
						if($val['status'] >= 3 && !$val['startDatetime']) $status_div = "ready-item";
						
						
						?>
							<div class="mymv-item rounding-outline">
								<div class="side">
									<dl>
										<dt>주문일자 / 주문번호</dt>
										<dd>
											<p class="date"><b><?=date_format(date_create($val['createDatetime']),'Y.m.d')?></b></p>
											<p class="order-num"><i><?=$val['orderId']?></i></p>
										</dd>
									</dl>
									<dl>
										<dt>결제금액 (수량)</dt>
										<dd>
											<span class="price"><b>￦<?=$val['price']?></b></span>
											<span class="qty">(1개)</span>
											<p class="order-detail">
												<a href="javascript:viewOrderDetail('<?=$val["orderId"]?>');" class="underline">주문상세보기</a>
											</p>
										</dd>
									</dl>
								</div>
								<!-- .side -->
								<div class="main">
									<dl>
										<dt>상품정보 / 진행상태</dt>
										<dd>
											<div class="mymv-item-info <?=$status_div?>" style="width:100%">
												<div class="left">
													<p class="thumb-m">
														<img src="/resources/uploads/product/image/<?=$val['imagefile']?>" alt="item thumbnail image">
														<span class="frame"></span>
													</p>
													<a href="#" class="underline goMovieQa" data-id="5">&nbsp;</a>
												</div>
												<? if($val['status'] == '01'){?>
													<div class="right">
														<p class="tit"><b><?=$val['name']?></b></p>

														<!-- 첫번째 대기 아이템만 결제 정보를.. -->
														<p class="payment-guide txt-guide"></p>
														<!-- .payment-guide -->
														<p class="txt-guide">
																
														</p>
													</div>
													<span class="flag-icon ficon-ready">대기</span>
												<? }?>
												
													<div class="right">
														<p class="tit"><b><?=$val['name']?></b></p>

														<p class="payment-guide txt-guide">
															아래의 버튼을 클릭하면 취소 환불 신청이 가능 합니다.															
														</p>
														<!-- .payment-guide -->
														<p class="maker-btn">															
															<button class="btn btn-info mr5 mb10 btn-block" id="move_refund">취소/환불 하기</button>															
														</p>
														<p class="txt-guide">
															<br>
														</p>
													</div>
													<span class="flag-icon ficon-ready">대기</span>											
											</div>
										</dd>
									</dl>
									</div>
									<!-- .main -->
								</div>
								<? endforeach; ?>
							</div>
					</section>
				</div>
			</div>
		</div>
	</div>
</div>