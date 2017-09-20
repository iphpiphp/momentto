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

<div class="row side_page w1140">
	<!-- side -->
	<?=aside_left_mypage()?>
	
	
	<!-- content -->
	<div id="ct" class="col-md-10">
		<h1 class="sub_hd">
			취소/환불
			<small>취소 요청 내역조회</small>
		</h1>
		<ul class="nav2">
			<li class="<?=$active1?>"><a href="/mypage/refund">취소/환불 신청</a></li>
			<li class="<?=$active2?>"><a href="/mypage/refund_app">취소/환불 내역조회</a></li>
		</ul>
		
		<nav>
			<ul class="pagination">
				<?=$page_nation?>
			</ul>
		</nav>
		<!-- list2 -->
		<div class="lst v2">
			<ul class="row">
				<!-- 대기 -->
				<? 
				
					/** 상태값 정리
					 * status == 00 빈값 생성
					 * status == 01  입금 대기
					 * status == 02  준비대기  무비메이커 클릭 전
					 * 	[무비메이커 시작하기]
					 * status == 03  진행중    무비메이커 클릭 -
					 * 	[무비메이커 진행하기] 
					 * status == 08  취소요청
					 * 	
					 * status == 10 제작요청
					 * 
					 * status == 11 제작완료
					 *  - 기간남음
					 *  [무비다운로드][링크][소스]
					 * 
					 */
					 
					 
					 
					$ribbon = "ribbon_blue"; //휘장 대기
					$ribbon_text = '대기'; 
					$summary = '아래의 [무비메이커 시작하기] 버튼을 클릭하면 무비 제작이 시작됩니다. 무비 제작이 가능한 일수는 <strong class="color_red">15일</strong>이며, 시작과 동시에 무비의 취소/환불은 불가능합니다.';

						foreach($lists as $key => $val):
						
						$save_date = date('Y-m-d',strtotime($val['startDatetime']."+15 day"));
						
						$leftDate = intval((strtotime($save_date)-strtotime(date('Y-m-d'))) / 86400); // 나머지 날짜값이 나옵니다.
						
						$status_div = "wait"; //wait ready-item 	progress-item	complete-item
						
						if($val['status'] >= 2 && !$val['startDatetime']) $status_div = "ready";
						if($val['status'] == '03' && $val['startDatetime']) $status_div = "progress";						
						if($val['status'] == '08') $status_div = "del";
						if($val['status'] == '10') $status_div = "progress";
						
						//if($val['status'] >= 10 && $val['isDelete'] == 1) $status_div = "end"; //삭제됨
												
						if($val['status'] == '11' && $val['isDelete'] == 0) $status_div = "complete";
						if($val['status'] == '11' && $val['isDelete'] == 1) $status_div = "del";
						
						if($status_div == 'wait'){
							$ribbon = "ribbon_blue"; //휘장 대기
							$ribbon_text = '입금대기';
						}
						
						if($status_div == 'ready'){
							$ribbon = "ribbon_blue"; //휘장 대기
							$ribbon_text = '대기';
						}
						
						if($status_div == 'progress'){
							$ribbon = "ribbon_red"; //휘장 대기
							$ribbon_text = '진행중';
						}
						
						if($status_div == 'progress_10'){
							$ribbon = "ribbon_red"; //휘장 대기
							$ribbon_text = '제작요청';
						}
						
						if($status_div == 'complete'){
							$ribbon = "ribbon_grey"; //휘장 대기
							$ribbon_text = '완료';
						}
						
						if($status_div == 'del'){
							$ribbon = "ribbon_grey"; //휘장 대기
							$ribbon_text = '취소요청';
						}
						
						
				?>
				<li class="col-sm-6 col-xs-12 itm v2" >
					<div style="min-height:603px">
						<a href="#">
							<img class="img-responsive" src="<?=IMG_O_PATH?>/resources/uploads/product/image/<?=$val['imagefile']?>" alt="">
						</a>
						<i class="<?=$ribbon?>"><?=$ribbon_text?></i>
						<div class="cnt_wrp">
							<h4><a href=""><?=$val['name']?></a> <!-- <?=$val['status']?>  <?=$leftDate?> --></h4>
							<dl class="order_info">
								<dt>주문일자</dt>
								<dd><?=date_format(date_create($val['createDatetime']),'Y.m.d')?></dd>
								<dt>주문번호</dt>
								<dd><?=$val['orderId']?> <a class="color_blue ml5" href=""></a></dd>
							</dl>
							<div class="meta clearfix">
								<div class="pull-left pt5">결제금액(수량)</div>
								<div class="pull-right">
									<strong class="price color_red">￦<?=number_format($val['price'])?></strong> (1개)
								</div>
							</div>
							<div class="summary">
								취소 환불 신청 중 입니다.						
							</div>
							<div class="btnarea">
																
							</div>
						</div>
					</div>
				</li>
				<? endforeach; ?>
			</ul>
		</div>
	</div>
</div>

<!-- //페이지 끝-->

	</div>
	<!-- //container -->