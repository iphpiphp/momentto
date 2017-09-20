<?
$mail_id = "";
$mail_domain = "";
if ($this -> session -> userdata['email'] != '') {
	$mail = explode('@', $this -> session -> userdata['email']);
	$mail_id = $mail[0];
	$mail_domain = $mail[1];
}

$exchange = exchange("USD");
$inicis = "이니시스";
$is_mobile = "";
if ($this -> agent -> is_mobile())$is_mobile = "M";
if ($this -> agent -> is_mobile())$inicis = "이니시스";	

?>


	<!-- #container -->
	<div id="container" class="clearfix">

		<!-- 페이지 시작-->

		<!-- lnb -->
		<nav class="lnb">
			<a>결제하기</a>
		</nav>

		<div class="form-horizontal bg_f0">
			<section>
				<h3 class="h-frm color_blue2">주문하신 무비</h3>
				<ul class="lst_cart v2">
					<? $total = 0; foreach($product as $key => $val): ?>
						<li class="row">
							<div class="col-xs-6 thmb">
								<img src="<?=IMG_O_PATH . $val['imagePath'] . "/" . $val['imageLFile'] ?>" alt="item thumbnail image" width="70%" />
							</div>
							<div class="col-xs-6">
								<h4><?=$val['name']?></h4>
								<dl class="dl">
									<dt>수량</dt>
									<dd>1개</dd>
									<dt>상품가격</dt>
									<dd>&#8361;
										<?=$val['eventPrice'] ? number_format($val['eventPrice']) : number_format($val['price']); ?>
									</dd>
								</dl>
							</div>
						</li>
						<? endforeach; ?>
							<li class="row">
								<div class="col-xs-12">
									<div class="">
										<div class="col-xs-6">
											총 주문금액
										</div>
										<div class="col-xs-6 text-right">
											<span class="color_red">&#8361;<?=number_format($total_price) ?></span>
										</div>
									</div>
								</div>
							</li>

				</ul>
			</section>
			<?php  if (!$this -> session -> userdata('email')) { ?>
				<section>
					<h3 class="h-frm color_blue2">이용약관</h3>
					<div class="pa16 bg_wh">
						<p class="fs13 color_grey">
							개인정보 수집, 이용 및 제공 등에 관한 고지사항을 읽고 위 내용에 동의하십니까?
						</p>
						<div class="checkbox fs15 mt10">
							<label>
								<input type="checkbox"> 동의합니다.
							</label>
						</div>
					</div>
				</section>
				<? }?>

					<input type="hidden" class="payType" value="Card" item="<?=$is_mobile?>" />
					<input type="radio" name="privacy-agree" checked style="display:none" />

					<div id="is"></div>


					<section>
						<h3 class="h-frm color_blue2">결제 정보</h3>
						<div class="cart_total row">
							<div class="col-xs-6 pt5">
								총 주문금액
							</div>
							<div class="col-xs-6 total-price color_red">
								&#8361;<span id="showLastPrice"><?=number_format($total_price) ?></span>
							</div>
							<div class="col-xs-12 pt20">
								<div class="col-xs-6 pr6">
									<button class="btn btn-block bg_red" id="pay_go">결제</button>
								</div>
								<div class="col-xs-6 pl6">
									<button class="btn btn-block" id="pay_cansle">이전/취소</button>
								</div>
							</div>
						</div>
					</section>
		</div>

		<!-- //페이지 끝-->

	</div>
	<!-- //container -->
	<script>
		//$("#is").load("/order/"+$('input:radio[name=payType]').attr("item")); //무통장 입금 로드
		$("#is").load("/order/ifream_form_inisis");
	</script>
