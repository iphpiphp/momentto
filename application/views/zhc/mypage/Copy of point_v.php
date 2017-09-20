<div class="container">
	<div class="row">
		<div class="col-lg-12">
			<div class="col-lg-2">
				<?=aside_left_mypage()?>
			</div>

			<div class="col-lg-9">
						
		<div id="content-main">

				<h3 class="page-hd">나의 적립금</h3>
				
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
				
				<section class="mypoint-board board-frame">					
					<header class="date-filtering">
												
						<!-- div class="by-date">							
							<div class="date-picker">
								<div class="input-field">
									<label for="input-start-date" class="screen-reader-text">조회시작일</label>
									<input id="selectStartDate" class="date-input styled-input" readonly="readonly">
									<img src="/resources/images/global/btn-calendar.gif" alt="달력보기" class="btn-calendar"> 
								</div>
							<span>&nbsp;-&nbsp;</span>
							
							<div class="date-picker">
								<div class="input-field">
									<label for="input-end-date" class="screen-reader-text">조회종료일</label>
									<input id="selectEndDate" class="date-input styled-input" readonly="readonly">
									<img src="/resources/images/global/btn-calendar.gif" alt="달력보기" class="btn-calendar"> 
								</div><!-- .input-field -->
							
						</div><!-- .by-date -->	
						<!-- a href="#" id="searchBtn" class="btn-find global-btn gbtn-a"><span class="in">조회</span></a -->
					</header><!-- .mp-board-header -->
					
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
								<td class="date"><?=$val['createDatetime'] ?></td>
								<td class="event"><?=$val['name'] ?></td>								
								<td class="recieve"><?=($val['money'] >= 1) ? "￦" . $val['money'] : ""; ?></td>
								<td class="use"><?=($val['money'] <= -1) ? "￦" . $val['money'] : ""; ?></td>
							</tr>
							<? endforeach; ?>
						</tbody>
					</table>					
					<footer>
						<div class="page-nation">
							<ul class="pagination">
								<?=$page_nation ?>
							</ul>
						</div>
					</footer>
		
				</section><!-- .mypoint-board -->
		
				<ul class="page-bottom-notice">
					<li>- 적립금은 구매 후 자동 지급이 되며, 다른 상품을 구매 시 현금처럼 사용 가능합니다.</li>
					<li>- 상품정보에 표기된 적립금액과 실제 받으신 적립금은 결제금액에 기준하여 비율이 적용되기 때문에 다를 수 있습니다.</li>
					<li>- 적립금은 주문 이외에 이벤트 등으로도 부여될 수 있습니다.</li>
				</ul>
						
			</div>
			

</div>
</div>
</div>
</div>