<!-- #container -->
<div id="container" class="clearfix">
	<!-- 페이지 시작-->
	<!-- lnb -->
	<nav class="lnb text-center">
		<a>주문이 완료되었습니다.</a>
	</nav>

	<form class="form-horizontal bg_f0">
		<section>
			<h3 class="h-frm color_blue2">
			주문하신 무비
			<div class="pull-right fw300 fs13 color_grey">주문번호 <?=$this->session->userdata['fin_oid']?></div>
		</h3>
			<ul class="lst_cart v2">
				<? $total = 0; foreach($product as $key => $val): ?>
				<li class="row">
					<div class="col-xs-6 thmb">
						<img src="<?=IMG_O_PATH . $val['imagePath'] . "/" . $val['imageSFile'] ?>" alt="item thumbnail image">
					</div>
					<div class="col-xs-6">
						<h4><?=$val['name'] ?></h4>
						<dl class="dl">
							<dt>수량</dt>
							<dd>1개</dd>
							<dt>상품가격</dt>
							<dd>&#8361;<?=$val['eventPrice'] ? number_format($val['eventPrice']) : number_format($val['price']); ?></dd>
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
		<section>
			<h3 class="h-frm color_blue2">주문자 정보</h3>
			<ul class="lst_complete">
				<li class="clearfix">
					<div class="pull-left color_red">
						주문자 이름
						<p class="mt3 color_grey">(고객님께서는 <strong><?=$this->session->userdata['fin_is_member']?></strong>으로 주문해 주셨습니다) </p>
					</div>
					<div class="pull-right">
						<?=$this->session->userdata['fin_name']?>
					</div>
				</li>
				<li class="clearfix">
					<div class="pull-left color_red">
						이메일
					</div>
					<div class="pull-right">
						<?=$this->session->userdata['fin_email']?>
					</div>
				</li>
			</ul>
		</section>
		<section>
			<h3 class="h-frm color_blue2">할인 정보</h3>
			<ul class="lst_complete">
				<li class="clearfix">
					<div class="pull-left color_red">
						총주문 금액
					</div>
					<div class="pull-right">
						&#8361; <?=number_format($total_price) ?>
					</div>
				</li>
				<li class="clearfix">
					<div class="pull-left color_red">
						적립금 사용
					</div>
					<div class="pull-right">
						<?=number_format($this->session->userdata['fin_use_point'])?>
					</div>
				</li>
				<li class="clearfix">
					<div class="pull-left color_red">
						최종 결제금액
					</div>
					<div class="pull-right">
						&#8361; <?=$this->session->userdata['fin_total_pay']?>
					</div>
				</li>
			</ul>
			<div class="mt15 pa16 bg_wh">
				<div class="row">
					<div class="col-xs-6 pr6">
						<a type="submit" class="btn btn-block bg_red" href="/mypage/">무비 제작하기</a>
					</div>
					<div class="col-xs-6 pl6">
						<a type="button" class="btn btn-block" href="/product/">쇼핑 계속하기</a>
					</div>
				</div>
			</div>
		</section>
	</form>
	<!-- //페이지 끝-->
</div>
<!-- //container -->
