<? 
$active1 = "";
$active2 = "";
if($this->uri->segment(2) == 'refund') {
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

		<ul class="nav3">
			<li class="<?=$active1?>"><a href="/mypage/refund">취소/환불 신청</a></li>
			<li class="<?=$active2?>"><a href="/mypage/refund_app">취소/환불 내역조회</a></li>
		</ul>

		<!-- list2 -->
		<div class="lst v2">
			<ul class="row">
				
				<!-- 대기 -->
				<? foreach($lists as $key => $val): ?>
				<li class="col-sm-6 col-xs-12 itm v2">
					<div>
						<a href="javascript:;">
							<img class="img-responsive" src="<?=IMG_O_PATH?>/resources/uploads/product/image/<?=$val['imagefile']?>" alt="">
						</a>
						<i class="ribbon_blue">대기</i>
						<div class="cnt_wrp">
							<h4><a href="javascript:;"><?=$val['name']?></a></h4>
							<dl class="order_info">
								<dt>주문일자</dt>
								<dd><?=date_format(date_create($val['createDatetime']),'Y.m.d')?></dd>
								<dt>주문번호</dt>
								<dd><?=$val['orderId']?></dd>
							</dl>
							<div class="meta clearfix">
								<div class="pull-left">결제금액(수량)</div>
								<div class="pull-right color_grey">
									<strong class="price color_red">￦<?=number_format($val['price'])?></strong> (1개)
								</div>
							</div>
							<div class="btnarea">
								<div><a class="btn btn-block" href="">취소/환불 하기</a></div>
							</div>
						</div>
					</div>
				</li>
				<? endforeach; ?>
			</ul>
		</div>

		<!-- //페이지 끝-->
