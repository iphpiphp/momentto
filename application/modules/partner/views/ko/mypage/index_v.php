<!-- #container -->
	<div id="container" class="clearfix">

<!-- 페이지 시작-->

<div class="row side_page w1140">
	<!-- side -->
	<?=aside_left_mypage()?>
	
	
	<!-- content -->
	<div id="ct" class="col-md-10">
		<h1 class="sub_hd">
			마이 무비 리스트
			<small>My Movie</small>
		</h1>
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
							$ribbon_text = '만료';
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
								<dd><?=$val['orderId']?> <a class="color_blue ml5" href=""><u>상세보기 <i class="fa fa-angle-right"></i></u></a></dd>
							</dl>
							<div class="meta clearfix">
								<div class="pull-left pt5">결제금액(수량)</div>
								<div class="pull-right">
									<strong class="price color_red">￦<?=number_format($val['price'])?></strong> (1개)
								</div>
							</div>
							<div class="summary">
								<? if($status_div == 'wait'){ ?>
									해당 무비를 무통장 결제방법으로 주문하셨습니다. 입금하시면 구매하신 무비를 제작하실 수 있습니다.
								<? } ?>
								
								<?if($status_div == 'progress'){?>
									<h5 class="text-center">제작잔여일수 : <strong class="color_red"><?=$leftDate?>일</strong></h5>
								<? } ?>
								
								<?if($status_div == 'progress_10'){?>
									<h5 class="text-center">무비의 <strong class="color_red">제작 요청이 완료</strong> 되었습니다.</h5>
									<p>
										무비가 완성되면 고객님의 이메일과 문자메시지로 안내해 드리며,<br>
										완성된 무비는 감상 / 다운로드 하실 수 있습니다.
									</p>
								<? } ?>
								
								<? if($status_div == 'ready'){ ?>
									아래의 [무비메이커 시작하기] 버튼을 클릭하면 무비 제작이 시작됩니다. 무비 제작이 가능한 일수는 <strong class="color_red"><?=$leftDate?>일</strong>이며, 시작과 동시에 무비의 취소/환불은 불가능합니다.
								<? } ?>
									
								<? if($status_div == 'complete'){ ?>									
										<div class="row pt10">
										<div class="col-xs-12 pb4">
											<a class="btn btn-lg btn-block" href="<?=$val['filePath']?>/<?=$val['storeFile']?>">무비 다운로드</a>
										</div>
										<div class="col-xs-6 pr2">
											<a class="btn btn-lg btn_blk btn-block" href="javascript:link_make('<?=$val['filePath']?>/<?=$val['storeFile']?>', 'link');" >링크</a>
										</div>
										<div class="col-xs-6 pl2">
											<a class="btn btn-lg btn_blk btn-block" href="javascript:link_make('<?=$val['filePath']?>/<?=$val['storeFile']?>', 'ife');">소스</a>
										</div>
									</div>
								<? } ?>
								
								<? if($status_div == 'del'){ ?>
									보관 기간이 만료 되었습니다.
								<? } ?>
								
							</div>
							<div class="btnarea">
								<? if($status_div == 'wait'){ ?>
								<? } ?>
								<? if($status_div == 'ready'){ ?>
									<?if($this->agent->is_mobile()){ ?>
										<div>모바일 환경에서는 제작이 불가능 합니다. PC로 접속 해 주십시오. <a href="<?=URL_PATH?>">PC페이지</a></div>
										<p class="pt10 text-center"><a class="color_grey pull-left" href="/customer/emailaq_view/"><u>무비 Q&amp;A 질문하기</u></a></p>	
									<? }else{ ?>
									<div><a class="btn btn-lg btn-block move_start" href="#" data-itemid="<?=$val['item_id']?>" data-orderid="<?=$val['orderId']?>">무비메이커 시작하기</a></div>
									<p class="pt10 text-center"><a class="color_grey pull-left" href="/customer/emailaq_view/"><u>무비 Q&amp;A 질문하기</u></a></p>
									<? } ?>
									
								<? } ?>
								
								<!-- 진행 중 -->
								<?if($status_div == 'progress'){?>
									<?if($this->agent->is_mobile()){ ?>
										<div>모바일 환경에서는 제작이 불가능 합니다. PC로 접속 해 주십시오. <a href="<?=URL_PATH?>">PC페이지</a></div>
										<p class="pt10 text-center"><a class="color_grey pull-left" href="/customer/emailaq_view/"><u>무비 Q&amp;A 질문하기</u></a></p>	
									<? }else{ ?>									
									<div><a class="btn btn-lg btn-block move_start" href="javascript:;" data-itemid="<?=$val['item_id']?>" data-orderid="<?=$val['orderId']?>">무비메이커 진행하기</a></div>
									<p class="pt10 text-center"><a class="color_grey pull-left" href="/customer/emailaq_view/"><u>무비 Q&amp;A 질문하기</u></a></p>
									<? } ?>
								<? } ?>
									
								<?if($status_div == 'progress_10'){?>
									<p class="pt10 text-center"><a class="color_grey pull-left" href="/customer/emailaq_view/"><u>무비 Q&amp;A 질문하기</u></a></p>
								<? } ?>
								
								<? if($status_div == 'complete'){ ?>
								<div></div>
								<p class="pt10 clearfix">
									<a class="color_grey pull-left" href="/customer/emailaq_view/"><u>무비 Q&amp;A 질문하기</u></a>
									<a class="color_blue pull-right" href="/product/detail/<?=$val['pid']?>"><u>평점/리뷰 작성하기</u></a>
								</p>
								<? } ?>
								
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