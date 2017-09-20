<?
$mail_id = "";
$mail_domain = "";
if ($this -> session -> userdata['email'] != '') {
	$mail = explode('@', $this -> session -> userdata['email']);
	$mail_id = $mail[0];
	$mail_domain = $mail[1];
}

$exchange = exchange("USD");
$inicis = "이니시스";
$is_mobile = "";
if ($this -> agent -> is_mobile())$is_mobile = "M";
if ($this -> agent -> is_mobile())$inicis = "이니시스";	

?>


<!-- #container -->
<div id="container" class="clearfix">

	<!-- 페이지 시작-->
	<div id="order" class="row side_page w1140">
		<!-- content -->
		<h1 class="sub_hd">주문 하신 무비</h1>	
		<section>		
			<div class="table-responsive">
				<table class="table">
					<caption class="sr-only">주문목록</caption>
					<thead>
						<tr>
							<th class="scope">상품명</th>
							<th class="scope">수량</th>
							<th class="scope">상품가격</th>						
						</tr>
					</thead>
					<tbody>
						<? $total = 0; foreach($product as $key => $val): ?>
						<tr>
							<td class="thumb"><img src="<?=IMG_O_PATH . $val['imagePath'] . "/" . $val['imageSFile'] ?>" alt="item thumbnail image"><span class="tit"><?=$val['name'] ?></span></a></td>
							<td>1개</td>
							<td> ￦ <?=$val['eventPrice'] ? number_format($val['eventPrice']) : number_format($val['price']); ?></td>						
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
		<h1 class="sub_hd">	이용약관 </h1>
		<div class="rounding-outline privacy box_info">
			<!-- p class="info">
				<strong>개인정보 수집, 이용 및 제공 등에 관한 고지사항</strong>
				<br> 주문을 위해 고객님께서 입력하신 정보의 관리는 당사의 개인정보취급방침을 준용합니다.
				<a target="_blank" href="/customer/privacy" class="global-btn gbtn-g"><span class="in">개인정보보호방침 바로 가기</span></a>
			</p -->
			<p class="check-agree">
				<span id="privacy">개인정보 수집, 이용 및 제공 등에 관한 고지사항을 읽고 위 내용에 동의하십니까?</span>
				<div class="p10">
					<input type="radio" name="privacy-agree" id="privacy-agree" >
					<label for="privacy-agree">정책에 동의</label>
					<!-- input type="radio" name="privacy-agree" id="privacy-degree">
					<label for="privacy-degree">동의안함</label -->
				</div>
			</p>
		</div>
		</section>
	
		<section>
		<h1 class="sub_hd">결제 수단</h1>
		<div class="rounding-outline ord-ordpaper-section" style="padding: 20 20 20 20;">
			<!-- input type="radio" id="payType1" item="ifream_form_dbank" class="payType" name="payType" value="DBank" checked="checked">
			<label for="payType1">무통장입금</label -->
			
			<div class="pay_left_info_block">
				<div class="pay_radio">
					<input type="radio" id="payType5" item="ifream_form_inisis" class="payType" name="payType" value="<?=$is_mobile?>INICIS" checked="checked">
					<label for="payType5"><?=$inicis?></label>
				</div>
				
				<div class="pay_radio">
					<input type="radio" id="payType4" item="ifream_form_paypal" class="payType" name="payType" value="PAYPAL">
					<label for="payType4">PayPal</label>
				</div>
				
				<? if($this->session->userdata['auth_lv'] >= 4) { ?>
					<div class="pay_radio">
						<input type="radio" id="payType6" item="ifream_form_point" class="payType" name="payType" value="POINT">
						<label for="payType6">적립금 구매</label>
					</div>
				<? } ?>
			</div>
			
			<div class="pay_right_info_block">
				<!-- div class="pay_radio">
					<input type="radio" id="payType2" style="z-index:999" item="ifream_form_cacao" class="payType" name="payType" value="CACAO">
					<label for="payType2">카카오페이</label>
				</div>
				<div class="pay_radio">
					<input type="radio" id="payType3" item="ifream_form_payco" class="payType" name="payType" value="PAYCO">
					<label for="payType3">페이코</label>
				</div -->
			</div>
		</div>
		<!-- 결재폼 -->
			
		
		<!-- iframe id="ifram_form" src="/order/ifream_form_dbank" style="border: none;" width=100% height=500px></iframe -->
		</section>
		
		
		<div id="is"></div>
		
		
		<section>
			<div class="pay_info">
				<h1 class="sub_hd"><span>결제 정보</span></h1>
				
				<div class="price_info">
					<span id="price_info_title">최종 결제금액</span>
					<div id="all_price" style="display:block;">
						<span>￦</span> <span id="showLastPrice"><?=number_format($total_price) ?></span>
					</div>
					<div id="paypal_price" style="display:none;">$ 
						<span id="showLastPrice" style="color: rgb(226, 61, 86);"><?=$total_price_usd?></span>
					</div>
				</div>
			</div>
		</section>
		
		
		<!-- section>
		<h1 class="sub_hd">결재 정보</h1>	
			<dl class="row">
				<dt class="col-sm-3 col-xs-4">최종 결제금액  </dt>
				<dd class="col-sm-9 col-xs-8">
					<div id="all_price" style="display:block;"><em>￦<span id="showLastPrice" style="color: rgb(226, 61, 86);"><?=number_format($total_price) ?></span></em></div>
					<div id="paypal_price" style="display:none;"><em>$ <span id="showLastPrice" style="color: rgb(226, 61, 86);"><?=round(($total_price/$exchange),2);?></span></em></div>					
				</dd>
			</dl>
		</section -->
		
		<div class="row mb40 text-center">
			<button type="button" class="btn btn-lg bg_red2 w280 mb10"id="pay_go">결제</button>
			<button type="button" class="btn btn-lg  w280 mb10 ml5 ml0-xs" id="pay_cansle">이전/취소</button>
		</div>			
	</div>

</div>



<script>

	$("#is").load("/order/"+$('input:radio[name=payType]').attr("item")); //무통장 입금 로드
</script>