<style type="text/css">


</style>
<!-- Start #right-sidebar -->
<!-- Start #content -->
<div id="content">
	<!-- Start .content-wrapper -->
	<div class="content-wrapper">


		<!-- Start .content-inner -->
		<div class="content-inner">
			<div class="table-responsive" style="overflow: hidden; width: 100%; height: auto;">
				<table class="table">
					<thead>

						<th>오늘회원가입/전체</th>
						<th>누적적립금</th>
						<th>판매중인상품</th>
						<!-- th>총누적주문</th -->
					</thead>
					<tbody>
						<tr>
							<td>
								<em><?=number_format($todayNewMember)?></em>명 / <em><?=number_format($allMember)?></em>명
							</td>
							<td>
								<em><?=number_format($allPoint)?></em>원
							</td>
							<td>
								<!-- <em><?=number_format($todayPrice) ?></em>원 / 총 --><?=number_format($todayCnt)?> <!-- (쿠폰 <?=$todayCoupon?> 건) -->
							</td>
							<!-- td>
								<em><?=number_format($allPrice)?></em>원
							</td -->
						</tr>
					</tbody>
				</table>
			</div>
			<!-- Start .row -->
			<div class="row">
				<!--
				<div class="col-lg-5 col-md-5 sortable-layout">
					<div class="panel panel-primary plain toggle panelClose panelRefresh panelMove">
						<div class="panel-heading">
							<h4 class="panel-title"><i class="ec-list"></i>무비제작</h4>
						</div>
						<div class="panel-body">
							<div class="table-responsive" style="overflow: hidden; width: 100%; height: auto;">
								<table class="table table-striped">
									<tr>
										<td class="per40">무비 대기중</td>
										<td style="">xxx건</td>
									</tr>
									<tr>
										<td>무비 진행중</td>
										<td>xxx건</td>
									</tr>
								</table>
							</div>
						</div>
					</div>
				</div>

				<!-- col-lg-6 end here -->
				<!--
				<div class="col-lg-5 col-md-5 sortable-layout">
					<div class="panel panel-primary plain toggle panelClose panelRefresh panelMove ">
						<div class="panel-heading">
							<h4 class="panel-title"><i class="ec-list"></i>SMS자동발송내역</h4>
						</div>
						<div class="panel-body">
							<p style="text-align:right;"><a href="#">더보기</a></p>
							<div class="table-responsive" style="overflow: hidden; width: 100%; height: auto;">
								<table class="table table-striped">
									<tr>
										<td><a href="#">[상품제휴]본메일이 안될경우...</a></td>
										<td>2015-07-29</td>
									</tr>
								</table>
							</div>
						</div>
					</div>
				</div>
				<!-- col-lg-6 end here -->
			</div>
			<!-- End .row -->
		</div>
		<!-- End .content-inner -->
	</div>
	<!-- End .content-wrapper -->
	<div class="clearfix"></div>
</div>
<!-- End #content -->
