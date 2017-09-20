<div id="main">
		
		<div id="bc-wrap">
			<p id="breadcrumb"><a href="/index.html">메인</a> &gt; <a href="index.html">마이페이지</a> &gt; 나의 리뷰</p>
		</div>
		
		<div id="content">
			
			<div id="side">
	<nav id="local-nav">
		<?=mypage_left_menu($this->uri->segment(2))?>
	</nav>	
</div><!-- #side -->
<script>
	var myPageActiveIdx = Number("6");
	$("#side #local-nav .menu li").eq( myPageActiveIdx ).addClass("current-page");
</script><div id="content-main">

				<h3 class="page-hd">나의 리뷰</h3>

				<section id="review-main" class="tab-frame">
					<ul class="nav styled-tab stab-2">
						<li class="on"><a href="#">평점/리뷰 작성하기</a></li>
						<li><a href="reviewHistory.html">내가 작성한 평점/리뷰 보기</a></li>
					</ul>
					
					<div id="review-items" class="content-box board-frame">
						
						<table class="prd-table styled-table stable-solid" summary="평점/리뷰 작성하기 리스트로 주문번호,상품명,수량,상품가격,결제금액,평점/리뷰 정보제공">
							<colgroup>
								<col style="width: 143px;" />
								<col style="width: 242px;" />
								<col style="width: 42px;" />
								<col style="width: 115px;" />
								<col style="width: 115px;" />
								<col style="width: 95px;" />
							</colgroup>
							<thead>
								<tr>
									<th>주문번호</th>
									<th>상품명</th>
									<th>수량</th>
									<th>상품가격</th>
									<th>결제금액</th>
									<th>평점/리뷰</th>
								</tr>
							</thead>
							<tbody>
							<tr>
										<td class="order-num">100000000003621</td>
										<td>
											<div class="prd-item-s">
												<p class="thumb-s">
													<a href="/product/24">
														<img src="/resources/uploads/product/image/1437549165438HZQGS.jpg" alt="item thumbnail image" />
														<span class="frame-s"> </span>
													</a>
												</p>
												<p class="tit"><a href="#">Love Travel</a></p>
											</div><!-- .prd-item-s -->
										</td>
										<td>1개</td>
										<td class="currency">￦1,000</td>
										<td class="currency">￦0</td>
										<td>
											<a href="#" data-id="24" class="btn-write global-btn gbtn-h writeBtn" title="새창으로 이동"><span class="in">작성하기</span></a>
										</td>
									</tr>
								<tr>
										<td class="order-num">100000000003610</td>
										<td>
											<div class="prd-item-s">
												<p class="thumb-s">
													<a href="/product/15">
														<img src="/resources/uploads/product/image/1414719209857UGXWI.jpg" alt="item thumbnail image" />
														<span class="frame-s"> </span>
													</a>
												</p>
												<p class="tit"><a href="#">Film Memories</a></p>
											</div><!-- .prd-item-s -->
										</td>
										<td>1개</td>
										<td class="currency">￦2,000</td>
										<td class="currency">￦0</td>
										<td>
											<a href="#" data-id="15" class="btn-write global-btn gbtn-h writeBtn" title="새창으로 이동"><span class="in">작성하기</span></a>
										</td>
									</tr>
								<tr>
										<td class="order-num">100000000003606</td>
										<td>
											<div class="prd-item-s">
												<p class="thumb-s">
													<a href="/product/27">
														<img src="/resources/uploads/product/image/1438568629935CZDGX.jpg" alt="item thumbnail image" />
														<span class="frame-s"> </span>
													</a>
												</p>
												<p class="tit"><a href="#">Exciting Wedding</a></p>
											</div><!-- .prd-item-s -->
										</td>
										<td>1개</td>
										<td class="currency">￦1,000</td>
										<td class="currency">￦0</td>
										<td>
											<a href="#" data-id="27" class="btn-write global-btn gbtn-h writeBtn" title="새창으로 이동"><span class="in">작성하기</span></a>
										</td>
									</tr>
								<tr>
										<td class="order-num">100000000003564</td>
										<td>
											<div class="prd-item-s">
												<p class="thumb-s">
													<a href="/product/10">
														<img src="/resources/uploads/product/image/1393303881072YXKMH.jpg" alt="item thumbnail image" />
														<span class="frame-s"> </span>
													</a>
												</p>
												<p class="tit"><a href="#">Our Travel Diary</a></p>
											</div><!-- .prd-item-s -->
										</td>
										<td>1개</td>
										<td class="currency">￦10,000</td>
										<td class="currency">￦0</td>
										<td>
											<a href="#" data-id="10" class="btn-write global-btn gbtn-h writeBtn" title="새창으로 이동"><span class="in">작성하기</span></a>
										</td>
									</tr>
								<tr>
										<td class="order-num">100000000003557</td>
										<td>
											<div class="prd-item-s">
												<p class="thumb-s">
													<a href="/product/20">
														<img src="/resources/uploads/product/image/1433298527783JLAOW.jpg" alt="item thumbnail image" />
														<span class="frame-s"> </span>
													</a>
												</p>
												<p class="tit"><a href="#">My Little Friend</a></p>
											</div><!-- .prd-item-s -->
										</td>
										<td>1개</td>
										<td class="currency">￦20,000</td>
										<td class="currency">￦1,000</td>
										<td>
											<a href="#" data-id="20" class="btn-write global-btn gbtn-h writeBtn" title="새창으로 이동"><span class="in">작성하기</span></a>
										</td>
									</tr>
								<tr>
										<td class="order-num">100000000003253</td>
										<td>
											<div class="prd-item-s">
												<p class="thumb-s">
													<a href="/product/21">
														<img src="/resources/uploads/product/image/1433299502878BZLAZ.jpg" alt="item thumbnail image" />
														<span class="frame-s"> </span>
													</a>
												</p>
												<p class="tit"><a href="#">The Cat</a></p>
											</div><!-- .prd-item-s -->
										</td>
										<td>1개</td>
										<td class="currency">￦20,000</td>
										<td class="currency">￦0</td>
										<td>
											<a href="#" data-id="21" class="btn-write global-btn gbtn-h writeBtn" title="새창으로 이동"><span class="in">작성하기</span></a>
										</td>
									</tr>
								</tbody>
						</table>
<div id="layerpopup">
		<div class="mask"></div>
		<div class="window">			
			<input type="text" id="replay_input" /><br>
			<span class="close">닫기</span> <span class="replay_ok">확인</span>
		</div>
	</div>
							
						<footer>
							<div class="pagenation">
	<a href="#" data-pno="" data-gno="" id="pagingPrevBtn"><img src="/resources/images/global/pagenation_prev.png" alt="prev" /></a>
	
	<span class="page-nums" id="pagingNoList">
	
		<a href="#">1</a>
		</span>
	
	<a href="#" data-pno="" data-gno="" id="pagingNextBtn"><img src="/resources/images/global/pagenation_next.png" alt="next" /></a>
	
	
</div><!-- .pagenation -->



</footer>
					</div><!-- #review-items -->
					
				</section><!-- #review-main -->
	
				<ul class="page-bottom-notice">
					<li>-  무비의 평점/리뷰를 작성해 주시면 현금처럼 사용 가능 한 적립금을 드립니다.</li>
					<li>-  무비의 평점/리뷰를 남겨주시는 고객님께 다음 번 구매 시 사용 가능한 쿠폰을 발급해드립니다.</li>
					<li>-  베스트 리뷰로 선정되시면, 별도의 유효기간 없이 언제든 사용 가능한 쿠폰을 발급해드립니다.</li>
				</ul>
				
				<p class="page-bottom-notice-btns">
					<a target="_blank" href="/event/4" class="global-btn gbtn-e"><span class="in">혜택 자세히 보기</span></a>
				</p>
						
			</div><!-- #content-main -->
			
		</div><!-- #content -->
	</div><!-- #main -->
	
	<script>function wrapMask() {
		// 화면에 너비와 너비를 구함
		var width = $(document).width();
		var height = $(document).height();


		// 마스크를 화면의 높이와 너비로 만들어 전체화면에 덮기 및 애니매이션 효과
		$("#layerpopup .mask").css({'width':width,'height':height});
		$("#layerpopup .mask").fadeTo("fast", 0.2);
		document.onkeydown = function(e) { 
			var eventKey = (e) ? e.which : window.event.keyCode; 
			if(eventKey == 27) {
				$("#layerpopup .mask").show("slow");
				$("#layerpopup .window").show("slow");
				
			}
			if(eventKey == 13){
				$("#layerpopup .replay_ok").click();
			}
		}
	}</script>
	