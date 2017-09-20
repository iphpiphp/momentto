<? $exchange = exchange("USD");  ?>
	<!-- #container -->
	<div id="container" class="clearfix">

		<!-- 페이지 시작-->

		<!-- lnb -->
		<nav class="lnb">
			<a>장바구니</a>
		</nav>


		<form id="cart" class="form-horizontal" action="/cart_lib/mut_add" method="post">
			<ul class="lst_cart">
				<?
				$total_price = 0;
				$total_price_uds = 0;
				foreach($cart_list as $key=> $val):
				$price = $val['price'];
				if($val['eventPrice']>0)$price =$val['eventPrice'];
				$total_price =$total_price + $price;
				$total_price_uds =$total_price_uds + $val['usd'];
				?>
					<li class="row">
						<input type="checkbox" class="chk_id" title="Check" name="chk_id[]" value="<?=$val['id']?>">
						<div class="col-xs-6 thmb">
							<a href="/product/detail/<?=$val['id']?>"><img src="<?=IMG_O_PATH?>/resources/uploads/product/image/<?=$val['imageSFile']?>" alt="item thumbnail image"></a>
						</div>
						<div class="col-xs-6">
							<h4><?=$val['name']?></h4>
							<dl class="dl">
								<dt>수량</dt>
								<dd>1개</dd>
								<dt>상품가격</dt>
								<dd>&#8361;<?=number_format($price);?></dd>
							</dl>
						</div>
						<div class="col-xs-12">
							<a href="/cart_lib/link_one_add?product_id=<?=$val['product_id']?>" class="btn btn-xs">바로주문</a>
							<a href="/cart_lib/one_del/<?=$val['idx']?>" class="btn btn-xs btn_grey">삭제</a>
						</div>
					</li>
				<? endforeach; ?>
				<? if(count($cart_list)<=0) { ?>
				<li class="row">카트에 담긴 상품이 없습니다.</li>
				<? } ?>
			</ul>
			<div class="cart_total row">
				<div class="col-xs-6 pt5">
					총 주문금액
				</div>
				<div class="col-xs-6 total-price color_red">
					&#8361;<?=number_format($total_price)?>&nbsp;/&nbsp;&nbsp;$<?=$total_price_uds?>
				</div>
				<div class="col-xs-12 fs13 color_grey">
					*할인쿠폰을 다운받았을 경우, 할인된 금액은
					<br> 주문서에서 확인하실 수 있습니다.
				</div>
			</div>
			<div class="row pa16">
				<div class="col-xs-6 pr6">
					<a id="allOrderBtn" href="javascript:cart_mut_add('all');" class="btn btn-block bg_red">전체상품 주문</a>
				</div>
				<div class="col-xs-6 pl6">
					<a id="selectOrderBtn" href="javascript:cart_mut_add();" class="btn btn-block">선택상품 주문</a>
				</div>
			</div>
			<div class="pb20 text-center">
				<a class="color_blue2" href="/product/orderby/all"><u>쇼핑 계속하기</u></a>
			</div>
		</form>

		<!-- //페이지 끝-->

	</div>
	<!-- //container -->
