<? $exchange = exchange("USD");  ?>
<!-- #container -->
	<div id="container" class="clearfix">

<!-- 페이지 시작-->

<div class="row side_page w1140">
	<!-- side -->

	
	<!-- content -->
	<div id="ct" class="col-sm-10 col-xs-12 pl50 pl0-xs">
		<h1 class="sub_hd">
			<span style="font-size:32px">장바구니</span>
			<small>				
				장바구니에 담은지 오래된 상품의 경우, 가격이나 혜택에 변동될 수 있음을 양해바랍니다.<br>				
				중복 상품은 주문 하실 때 자동으로 제거 됩니다.
			</small>
		</h1>
		<!-- div class="bx2 clearfix">
			<p class="pull-left fs18 fs14-xs" style="letter-spacing:-1px">
				<span class="label bg_green w60 fs14">FUN</span> <span class="label bg_red w60 fs14">SOFT</span> 를 함께 구매하시면 <strong class="color_red">2개가 \47,000!</strong>  체크박스로 선택하여 세트 할인 가격을 확인해보세요!
			</p>
			<a class="color_blue pull-right mt3" href=""><u>자세히보기</u></a>
		</div -->
		<!-- table -->
		<div class="table-responsive">
			<form id="cart" method="POSt" action="/cart_lib/mut_add" >
			<table class="table v3">
				<thead>
					<tr>
						<th class="check"><input type="checkbox" id="chk_all" title="Check"></th>
						<!-- th>SET구분</th -->
						<th>상품명</th>
						<th>수량</th>
						<th>상품가격</th>
						<th>쿠폰</th>
						<th>주문</th>
					</tr>
				</thead>
				<tbody>
					<? 
						$total_price = 0;
						$total_price_uds = 0;
						foreach($cart_list as $key=> $val):  
						$price = $val['price'];
						if($val['eventPrice']>0)$price =$val['eventPrice']; 
						$total_price =$total_price + $price;
						$total_price_uds =$total_price_uds + $val['usd'];  
					?>
					<tr>
						<td class="check"><input type="checkbox" class="chk_id" title="Check" name="chk_id[]" value="<?=$val['id']?>"></td>
						<!--td><span class="label bg_green w60 fs14">FUN</span></td -->
						<td>
							<a href="/product/detail/<?=$val['id']?>">
								<img src="<?=IMG_O_PATH?>/resources/uploads/product/image/<?=$val['imageSFile']?>" alt="item thumbnail image">
								<h5><?=$val['name']?></h5>
							</a>
						</td>
						<td>1개</td>
						<td>￦ <?=number_format($price);?><!-- br>$ <?=round(($price/$exchange),2);?> --></td>
						<td></td>
						<td>
							<a class="btn btn_blk center-block w80 mb5" href="/cart_lib/link_one_add?product_id=<?=$val['product_id']?>">바로주문</a>
							<a class="btn center-block w80" href="/cart_lib/one_del/<?=$val['idx']?>">삭제</a>
						</td>
					</tr>
					<? endforeach; ?>
					<? if(count($cart_list)<=0) { ?>
					<tr><td colspan="5">카트에 담긴 상품이 없습니다!</td></tr>
					<? } ?>
					
				</tbody>
			</table>
			</form>
		</div>
		<div class="row table_total">
			<div class="col-sm-6 col-xs-12">
				<p class="color_grey">*할인쿠폰을 다운받았을 경우, 할인된 금액은 주문서에서 화인하실 수 있습니다.</p>
			</div>
			<div class="col-sm-6 col-xs-12 fs20 fs16-xs text-right">
				<strong>총 주문금액 :</strong>
				<span class="price color_red">￦ <?=number_format($total_price)?>&nbsp;/&nbsp;&nbsp;$<?=$total_price_uds?></span>
				<!-- div>$ <?=round(($total_price/$exchange),2);?></div -->
			</div>
		</div>
		<div class="row mt40 mb40">
			<div class="col-sm-3 col-xs-12 col-sm-offset-1 pa5">
				<a id="allOrderBtn" href="javascript:cart_mut_add('all');"  class="btn btn-lg bg_red btn-block">전체상품 주문</a>
			</div>
			<div class="col-sm-3 col-xs-12 pa5">
				<a type="button" id="selectOrderBtn" class="btn btn-lg bg_grey btn-block"  href="javascript:cart_mut_add();">선택상품 주문</a>
			</div>
			<div class="col-sm-3 col-xs-12 pa5">
				<a  class="btn btn-lg btn-block" href="/product/orderby/all">쇼핑 계속하기</a>
			</div>
		</div>
	</div>
</div>

<!-- //페이지 끝-->

	</div>
	<!-- //container -->
	
	
	
