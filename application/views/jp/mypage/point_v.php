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

			<div class="my_point bg_wh row">
				<div class="col-xs-6">
					<h4>받은 적립금</h4>
					<div class="price color_blue2">￦
						<?=number_format($point_list['0']['sumplus']) ?>
					</div>
				</div>
				<div class="col-xs-6">
					<h4>사용 적립금</h4>
					<div class="price color_red">￦
						<?=number_format($point_list['0']['summus']) ?>
					</div>
				</div>
			</div>

			<ul class="lst_notice lst_event">
				<?php foreach($point_list as $key => $val): ?>
					<li>
						<div class="price"><span class="color_red">￦ <?=($val['money'] >= 1) ? number_format($val['money']) : "".number_format($val['money']); ?></span></div>
						<h3><?=$val['name'] ?></h3>
						<div class="meta"><?=date('Y.m.d', strtotime($val['createDatetime']))?></div>
					</li>
					<? endforeach; ?>
			</ul>
			<nav class="text-center">
				<ul class="pagination">
					<?=$page_nation?>
				</ul>
			</nav>
	</div>

	<!-- //페이지 끝-->
