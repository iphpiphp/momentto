<? 
$active1 = "";
$active2 = "";
if($this->uri->segment(2) == 'coupon') {
	$active1 = "active";
}else{
	$active2 = "active";	
}
?>
<!-- #container -->
	<div id="container" class="clearfix">

<!-- 페이지 시작-->

<div class="row side_page w1140">
	<!-- side -->
	<?=aside_left_mypage()?>	
	
	<!-- content -->
	<div id="ct" class="col-md-10">
		<h1 class="sub_hd">
			쿠폰조회/등록
		</h1>
		<div class="bx2">
			<div class="form-inline coupon_bx">
				<h5 class="mb20 mb10-xs fs13-xs">소지하고 계신 쿠폰의 인증번호 또는 Pin번호를 입력하세요.</h5>
				<label class="color_grey mr10">쿠폰번호 입력</label>
				<div>
					<input type="text" class="form-control w60 mr10" maxlength="4" id="pin_num1">
					<input type="text" class="form-control w60 mr10" maxlength="4" id="pin_num2">
					<input type="text" class="form-control w60 mr10" maxlength="4" id="pin_num3">
					<input type="text" class="form-control w60 mr10" maxlength="4" id="pin_num4">
				</div>
				<button type="button" class="btn bg_red w80" id="btnRecharge">등록</button>
			</div>
		</div>
		<ul class="nav2">
			<li class="<?=$active1?>"><a href="/mypage/coupon" style="font-size: 14px;">사용가능 쿠폰 내역</a></li>
			<li class="<?=$active2?>"><a href="/mypage/coupon_fin" style="font-size: 14px;">사용 완료/만기 쿠폰 내역</a></li>
		</ul>
		<!-- 테이블 -->
		<div class="table-responsive">
			<table class="table">
				<thead>
					<tr>
						<th>쿠폰명/상세정보</th>
						<th>사용기간</th>
						<!-- th>적용상품</th -->						
						<th>할인가격</th>
					</tr>
				</thead>
				<tbody>
					<? foreach ($lists as $key => $val) : ?>
					<tr>
						<td><?=$val['name']?></td>
						<td><?
							if($val['startDatetime'] && $val['endDatetime']) {
								echo date('Y.m.d', strtotime($val['startDatetime']))."-".date('Y.m.d', strtotime($val['endDatetime']));
							}else{
								echo "무제한";
							}
							?>
						</td>
						<!-- td class="title">
							<a href="#">My Wedding</a>
						</td -->
						<td>\ <?=number_format($val['price'])?></td>
					</tr>
					<? endforeach; ?>
				</tbody>
			</table>
		</div>
		<nav class="text-center">
			<ul class="pagination">
				<?=$page_nation?>
			</ul>
		</nav>
		<div class="mypage_help mt20">
			<p class="mb20 color_grey fs13">
				*신용카드 영수증은 주문한 시점부터 1년 이내 발행 가능합니다.<br>
				*주문완료 (카드결제완료) 직후부터 발행 가능합니다.
			</p>
			<a class="btn bg_grey" href="/customer/emailaq_view/">고객센터 1:1 이메일 문의하기</a>
		</div>
	</div>
</div>

<!-- //페이지 끝-->

	</div>
	<!-- //container -->