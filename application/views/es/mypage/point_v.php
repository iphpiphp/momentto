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
			나의 적립금
		</h1>
		<section id="point-summery" class="rounding">
					<!-- <a href="#" class="btn-review global-btn gbtn-b"><span class="in">평점/리뷰 작성하기</span></a> -->
					<dl class="valid-point">
						<dt>받은 적립금</dt>
						<dd class="rounding-s"><b>￦&nbsp;<?=number_format($point_list['0']['sumplus']) ?></b></dd>
					</dl>
					
					<dl class="invalid-point">
						<dt>사용 적립금</dt>
						<dd class="rounding-s"><b>￦&nbsp;<?=number_format($point_list['0']['summus']) ?></b></dd>
					</dl>
				</section>
		
		<!-- 테이블 -->
		<div class="table-responsive">
			<table class="mp-list styled-table" style="" summary="나의 적립금 내역으로 날짜,내역,받은적립금,사용적립금,상태 정보제공">
						<colgroup>
							<col style="width: 96px;">
							<col style="width: 361px;">
							<col style="width: 150px;">
							<col style="width: 150px;">
						</colgroup>
						<thead>
							<tr>
								<th>날짜</th>
								<th>내역</th>
								
								<th class="recieve">받은 적립금</th>
								<th class="use">사용 적립금</th>
								</tr>
						</thead>
						<tbody>
							<?php foreach($point_list as $key => $val): ?>
							<tr>
								<td class="date"><?=date('Y.m.d', strtotime($val['createDatetime']))?></td>
								<td class="event"><?=$val['name'] ?></td>								
								<td class="recieve"><?=($val['money'] >= 1) ? "￦" . number_format($val['money']) : ""; ?></td>
								<td class="use"><?=($val['money'] <= -1) ? "￦" . number_format($val['money']) : ""; ?></td>
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
			<a class="btn bg_grey" href="/customer/emailaq_view/">고객센터 1:1 이메일 문의하기</a>
		</div>
	</div>
</div>

<!-- //페이지 끝-->

	</div>
	<!-- //container -->