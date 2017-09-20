<!-- #container -->
	<div id="container" class="clearfix">

<!-- 페이지 시작-->

<div id="order" class="row side_page w1140">
	<!-- content -->
	<h1 class="sub_hd">
		주문완료
	</h1>
	<p class="txt">주문이 정상적으로 완료되었습니다.</p>
	<section>
		<h2 class="h2 color_red mtit">주문하신 무비</span><span>주문번호 : <?=$this->session->userdata['fin_oid']?></h2>
		<div class="table-responsive">
			<table class="table">
				<caption class="sr-only">주문목록</caption>
				<thead>
					<tr>
						<th class="scope">상품명</th>
						<th class="scope">수량</th>
						<th class="scope">상품가격</th>
						<th class="scope">주문내역확인</th>
					</tr>
				</thead>
				<tbody>
					<? $total = 0; foreach($product as $key => $val): ?>
					<tr>
						<td class="thumb"><img src="<?=IMG_O_PATH . $val['imagePath'] . "/" . $val['imageSFile'] ?>" alt="item thumbnail image"><span class="tit"><?=$val['name'] ?></span></a></td>
						<td>1개</td>
						<td>\ <?=$val['eventPrice'] ? number_format($val['eventPrice']) : number_format($val['price']); ?></td>						
					</tr>
					<? endforeach; ?>
				</tbody>
			</table>
		</div>
		<div class="table_total">
			<strong>총 주문금액 :</strong>
			<span class="price color_red">￦ <?=number_format($total_price) ?></span>
		</div>
	</section>
	<section>
		<h2 class="h2 color_red">주문자정보</h2>
		<dl class="row">
			<dt class="col-sm-3 col-xs-4">주문자이름</dt>
			<dd class="col-sm-9 col-xs-8 name"><?=$this->session->userdata['fin_name']?><span>(고객님께서는 <em><?=$this->session->userdata['fin_is_member']?></em>으로 주문해 주셨습니다) </span></dd>
			<dt class="col-sm-3 col-xs-4">이메일</dt>
			<dd class="col-sm-9 col-xs-8"><?=$this->session->userdata['fin_email']?></dd>
		</dl>
	</section>
	<section>
		<h2 class="h2 color_red">할인정보</h2>
		<dl class="row">
			<dt class="col-sm-3 col-xs-4">총주문금액</dt>
			<dd class="col-sm-9 col-xs-8">\ <?=number_format($total_price) ?></dd>
			<dt class="col-sm-3 col-xs-4">적립금사용</dt>
			<dd class="col-sm-9 col-xs-8"><?=$this->session->userdata['fin_use_point']?></dd>
			<dt class="col-sm-3 col-xs-4">최종결제금액</dt>
			<dd class="col-sm-9 col-xs-8"><?=$this->session->userdata['fin_total_pay']?></dd>
		</dl>
	</section>
	<!-- section>
		<h2 class="h2 color_red">결제정보</h2>
		<dl class="row">
			<dt class="col-sm-3 col-xs-4">적립금구매</dt>
			<dd class="col-sm-9 col-xs-8"></dd>
		</dl>
	</section -->
	
	<div class="row mb40 text-center">
		<a class="btn btn-lg bg_red2 w280 mb10" href="/mypage/">무비제작하기</a>
		<a class="btn btn-lg  w280 mb10 ml5 ml0-xs" href="/">쇼핑계속하기</a>
	</div>
</div>

<!-- //페이지 끝-->

	</div>
	<!-- //container -->