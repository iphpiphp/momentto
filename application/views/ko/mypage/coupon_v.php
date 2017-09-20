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
		<!-- lnb -->
		<?=aside_top_mypage()?>
			<div class="bx2">
				<div class="form-inline coupon_bx">
					<h5 class="mb15 fs13 text-center color_blue2">소지하고 계신 쿠폰의 인증번호 또는 Pin번호를 입력하세요.</h5>
					<div>
						<form action="/mypage/ajax_coupon_chk" id="form_post" method="post">
							<input type="text" class="form-control w60 mr10" maxlength="4" name="pin_num1" id="pin_num1">
							<input type="text" class="form-control w60 mr10" maxlength="4" name="pin_num2" id="pin_num2">
							<input type="text" class="form-control w60 mr10" maxlength="4" name="pin_num3" id="pin_num3">
							<input type="text" class="form-control w60 mr10" maxlength="4" name="pin_num4" id="pin_num4">
						</form>
					</div>
					<button type="button" class="btn bg_blue2" id="btnRecharge">등록</button>
				</div>
			</div>
			<ul class="nav3">
				<li class="<?=$active1?>"><a href="/mypage/coupon">사용가능 쿠폰 내역</a></li>
				<li class="<?=$active2?>"><a href="/mypage/coupon_fin">사용 완료/만기 쿠폰 내역</a></li>
			</ul>

			<ul class="lst_notice lst_event">
				<? foreach ($lists as $key => $val) : ?>
					<li>
						<h3><?=$val['name']?></h3>
						<dl class="dl">
							<dt>사용기간 : </dt>
							<dd>
								<?=($val['startDatetime'] && $val['endDatetime'])? date('Y.m.d', strtotime($val['startDatetime']))."-".date('Y.m.d', strtotime($val['endDatetime'])):"무제한";?>
							</dd>
							<!--dt>적용상품 : </dt>
						<dd>프로포즈</dd -->
							<dt>할인가격 :</dt>
							<dd><span class="color_red"><?=number_format($val['price'])?>%</span></dd>
						</dl>
					</li>
					<? endforeach; ?>
			</ul>
			<div>
				<ul class="pagination">
					<?=$page_nation?>
				</ul>
			</div>

			<!-- //페이지 끝-->
	</div>
	<!-- //container -->
