<div class="container">
	<div class="row">
		<div class="col-lg-12">
			<div class="col-lg-2">
				<?=aside_left_mypage() ?>
			</div>

			<div class="col-lg-9">
				<h3 style="    border-bottom: 4px solid #6e6c6a; ">쿠폰조회/등록</h3>
				<div id="content-main">					

					<section id="register-coupon" class="rounding">
						<p class="txt-guide">
							소지하고 계신 쿠폰의 인증번호 또는 Pin번호를 입력하세요.
						</p>
						<fieldset class="input-field">
							<label for="input-coupon-num">쿠폰번호 입력</label>
							<input type="text" class="styled-input input-coupon-num" id="pin_num1" maxlength="4">
							-
							<input type="text" class="styled-input input-coupon-num" id="pin_num2" maxlength="4">
							-
							<input type="text" class="styled-input input-coupon-num" id="pin_num3" maxlength="4">
							-
							<input type="text" class="styled-input input-coupon-num" id="pin_num4" maxlength="4">
							<a href="#" class="btn btn-dark mr5 mb10" id="btnRecharge"><span class="in">등록</span></a>
						</fieldset>
					</section><!-- #register-coupon -->

					<section id="my-coupon-list" class="tab-frame">

						<div id="expired-coupon" class="content-box board-frame">
							<table class="styled-table" summary="사용가능 쿠폰 내역으로 쿠폰, 쿠폰명/상세정보, 사용기간, 적용상품, 사용가능액 정보제공">
								<colgroup>
									<col style="width:201px;">
									<col style="width:228px;">
									<col style="width:91px;">
									<col style="width:129px;">
								</colgroup>
								<thead>
									<tr>
										<th>쿠폰명/상세정보</th>
										<th>사용기간</th>
										<th>적용상품</th>
										<th>할인가격</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td class="tit">dasdasd</td>
										<td class="expiry"> 2015-09-03 11:34:52
										~ 2015-12-12 11:34:52</td>
										<td class="target"><a href="javascript:popup('popup/coupon/applyList?cid=42', 'couponPrdPop', 638, 625);" class="underline" title="새창으로 이동">적용상품보기</a></td>
										<td class="condition"> 30% 할인</td>
									</tr>
								</tbody>
							</table>
							<footer>
								<div class="pagenation">
									<a href="#" data-pno="0" data-gno="0" id="pagingPrevBtn"><img src="/resources/images/global/pagenation_prev.png" alt="prev"></a>
									<span class="page-nums" id="pagingNoList"> <a href="#">1</a> </span>
									<a href="#" data-pno="0" data-gno="0" id="pagingNextBtn"><img src="/resources/images/global/pagenation_next.png" alt="next"></a>
								</div><!-- .pagenation -->
							</footer>
						</div>
					</section><!-- #my-coupon-list -->

					<ul class="page-bottom-notice">
						<li>
							- 쿠폰은 중복사용 할 수 없으며, 한번 주문에 1장만 사용 가능합니다.
						</li>
						<li>
							- 일부 특별 세일, 이벤트 상품에는 이용 할 수 없습니다.
						</li>
						<li>
							- 각 쿠폰은 유효기간이 있으며, 기간 이후에는 소멸되오니 유의 하시기 바랍니다.
						</li>
						<li>
							- 할인쿠폰을 사용하여 주문하신 후 취소/환불하신 경우 해당 쿠폰은 재사용하실 수 없습니다
						</li>
					</ul>
				</div>
			</div>
		</div>
	</div>
</div>
</div>