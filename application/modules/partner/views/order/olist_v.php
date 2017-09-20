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
						<th>번호</th>						
						<th>주문일시</th>
						<th>환경</th>
						<th>주문번호</th>						
						<th>주문상품</th>
						<th>수량</th>
						<th>주문자</th>
						<th>결재수단</th>
						<th>최종결제금약</th>
						<th>결재일시</th>
					</thead>
					<tbody>
						<?php 
						$page = $this->input->get('page',true);
						if(is_numeric($page) == false) $page = 1;
						if($page < 0) $page = 1; 
						
						$total_count = $total_count - (($page -1) * $pagelist); 
						foreach ($order as $key => $val):?>
							<tr>
								<td><? echo $total_count--;?></td>								
								<td><?=$val['createDatetime']?></td>
								<td><?=$val['device']?></td>								
								<td><?=$val['id']?></td>
								<td><?=$val['iname']?></td>
								<td><?=$val['order_cnt']?></td>
								<td><?=$val['memberName']?></td>
								<td><?=$val['payMethod']?></td>
								<td><?=$val['price']?></td>
								<td><?=$val['confirmDatetime']?></td>
							</tr>
							<? endforeach; ?>
					</tbody>
				</table>
			</div>
			
			<div class="page-nation">
				<ul class="pagination">
					<?=$page_nation?>
				</ul>
			</div>

		</div>
		<!-- End .content-inner -->
	</div>
	<!-- End .content-wrapper -->
	<div class="clearfix"></div>
</div>
<!-- End #content -->