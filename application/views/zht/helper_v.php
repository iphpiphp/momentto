<? $product_id = $this->input->get('product'); ?>
<!-- #container -->
<div id="container" class="clearfix">
	
	<!-- 페이지 시작-->

	<div id="helper">
		<section id="sect1" class="text-center">
			<div class="w1140">
				<h2 class="sr-only">promotion</h2>
				<img class="img-responsive center-block mb60 mb30-xs" src="<?=IMG_PATH ?>img/helper/1_1.png" alt="더데이즈 헬퍼는 동영상 제작대행 서비스 입니다.">
				<div>
					<h3 class="fw400 fs18 fs14-xs mb20" style="opacity:.8">D-day는 다가오는데 시간이 턱없이 부족하세요? 더데이즈의 시스템 조작에 어려움을 겪고 계신가요?</h3>
					<h4 class="fs18-xs">단돈 <strong class="color_sky">9,900</strong>원만 추가하면 대기중인 더데이즈 헬퍼가 <strong class="color_sky">30분</strong>만에
					<br class="hidden-xs">
					근사한 동영상 한편을 뚝~딱! 만들어 드립니다.</h4>
				</div>
			</div>
		</section>
		<section id="sect2">
			<input type="hidden" id="item" value="80047573" />
			<input type="hidden" id="product_id" value="<?=$product_id?>" />
			<h2 class="sr-only">promotion</h2>
			<form class="row w1140" action="/main/helper_send" method="POST" id="help_post">
				<input type="hidden" name="subject" id="subject" />
				<textarea name="message" style="display:none" id="message"></textarea>
				<div class="col-sm-8 col-sm-offset-2">
					<section class="step1">
						<div class="step_hd">
							<h3 class="color_red">제품(템플릿)선택</h3>
							<p class="mb40 mb20-xs fs16 fs14-xs">
								먼저 마음에 드는 템플릿을 선택하세요!
								<br>
								템플릿을 선택하시면 우측으로 (사진 정리폴더 다운) 버튼이 생성되며,
								<br>
								클릭하여 다운받은 후 zip파일을 열고 필독사항에 따라 사진과 문구를 넣어 주세요.
							</p>
							<div class="form-inline mb40">
								<? ajax_cate(); ?>
								
								<?  if (!$this->agent->is_mobile()){ ?>
								<a id="img_down" class="btn bg_red">사진 정리폴더 다운</a>
								<? } ?>
							</div>
						</div>
						<!-- 16:9 aspect ratio -->
						<div class="embed-responsive embed-responsive-16by9">
							<!-- iframe class="embed-responsive-item" src="https://www.youtube.com/embed/614oSsDS734?rel=0&amp;showinfo=0"></iframe -->
							<iframe	class="_vimeoPlayer" id="if_id"	width="720"height="400" frameborder="0"	webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>
						</div>
					</section>
					<hr class="hr">
					<section class="step2">
						<div class="step_hd">
							<h3 class="color_red">주문/입금하기</h3>
							<p class="mb40 mb20-xs fs16 fs14-xs">
								선택하신 템플릿 비용 + 헬퍼서비스 비용 (9,900원)을 합산하여 무통장 계좌로 입금해 주세요.
								<br>
								<span class="color_grey">(계좌번호 : 국민은행 535901-01-303137 주식회사 위드비디오)</span>
							</p>
							<div class="row mb40 mb20-xs">
								<div class="col-sm-3">
									<label for="" class="color_blue2">제품가격</label>
									<input type="text" class="form-control text-right" id="acg_1" value="9,900">
								</div>
								<div class="col-sm-1 text-center">
									<label class="hidden-xs">&nbsp;</label>
									<p class="form-control-static">
										+
									</p>
								</div>
								<div class="col-sm-3">
									<label for="" class="color_blue2">헬퍼</label>
									<input type="text" class="form-control text-right" id="acg_2" value="9,900">
								</div>
								<div class="col-sm-1 text-center">
									<label class="hidden-xs">&nbsp;</label>
									<p class="form-control-static">
										=
									</p>
								</div>
								<div class="col-sm-3">
									<label for="" class="color_blue2">최종주문금액</label>
									<input type="text" class="form-control text-right bg_blue2" id="acg_3" value="19,800">
								</div>
							</div>
						</div>
					</section>
					<hr class="hr">
					<section class="step3">
						<div class="step_hd">
							<h3 class="color_red">헬퍼 신청서 작성</h3>
							<p class="mb40 mb20-xs fs16 fs14-xs">
								아래 헬퍼신청서의 정보들을 기입해 주세요!
							</p>
							<div class="form-horizontal mb40 mb20-xs">
								<div class="form-group">
									<label class="col-xs-2 control-label color_blue2">이름</label>
									<div class="col-xs-10">
										<input type="text" class="form-control" style="max-width:269px" name="pname">
									</div>
								</div>
								<div class="form-group">
									<label class="col-xs-2 control-label color_blue2">연락처</label>
									<div class="col-xs-10 form-inline">
										<input type="text" class="form-control w80" maxlength="4" name="tel_1">
										-
										<input type="text" class="form-control w80" maxlength="4" name="tel_2">
										-
										<input type="text" class="form-control w80" maxlength="4" name="tel_3">
									</div>
								</div>
								<div class="form-group">
									<label class="col-xs-2 control-label color_blue2">이메일</label>
									<div class="col-xs-10">
										<input type="text" class="form-control" style="max-width:269px" name="mail_from">
									</div>
								</div>
							</div>
							<p class="mb40 mb20-xs fs16 fs14-xs">
								*다운받으신 <span class="color_red">[사진 정리폴더]</span>에 고객님의 사진, 문구, 음악을 넣어서 알집(zip)으로 압축해서 <span class="color_red">cs@thedays.co.kr</span> 이메일에 첨부하여 보내주세요.
							</p>
						</div>
						<div>
							<a class="btn btn-xxl bg_red btn-block" href="#" id="help_submit">
								헬퍼 서비스 신청하기
							</a>
						</div>
						<p class="mt40 fs16 fs14-xs">
							헬프데스크 (02-562-3618)로 전화를 주시거나 카톡 (ID:더데이즈) 친구 추가 후, <span class="color_red">신청서 확인 메시지</span>를 보내주세요.
							<br>
							<span class="color_grey">예) 홍길동, 웨딩 You and I 헬퍼 신청서 보냈습니다. 확인 바랍니다.</span>
						</p>
					</section>
				</div>
			</form>
		</section>
		<section id="sect3">
			<h2 class="sr-only">promotion</h2>
			<div class="row w1140">
				<div class="col-sm-4">
					<h3 class="h3 fs20-xs"><i class="glyphicon glyphicon-ok color_red"></i>
					<br class="hidden-xs">
					영상제작 및 완성</h3>
				</div>
				<div class="col-sm-8">
					<ul class="fs20 fs14-xs mb40">
						<li>
							1. 영상제작이 시작되면 고객님에게 <span class="color_red">카톡 또는 문자메시지</span>를 보내 드립니다.
						</li>
						<li>
							2. 30분~1시간 이내로 완성된 영상을 이메일로 받아보실 수 있습니다.
						</li>
						<li>
							3. <span class="color_red">1회에 한해 수정가능</span>하며, 수정본 역시 30분 이내에 완료하여 보내드립니다.
						</li>
					</ul>
					<p class="fs18 fs13-xs color_grey">
						* 헬퍼 서비스 운영시간 : 평일 09:00 ~ 18:00 (주말, 공휴일 휴무)
						<br>
						* 운영 시간 내에 접수된 제작의뢰 건은 즉시 제작해 드리며, 평일 18:00 이후의 제작의뢰 건은 익일 오전에,  주말에 접수 된 제작의뢰 건은 월요일 오전에 제작 완료하여 보내드립니다.
					</p>
				</div>
			</div>
		</section>
	</div>

	<!-- //페이지 끝-->

</div>
<!-- //container -->
<script>
	$(document).ready(function() {
		ajax_find_category();//카테고리 init
		vimeo_init();
		agent_chk();
				
		//카테고리 선택시
		$("select[name ='cate']" ).change(function (){
			var cate_num = $("#cate option:selected").val();
			if(cate_num > 0 ){
				
				ajax_find_product_list(cate_num);
			}
		});
		//상품 선택시
		$("select[name ='product']" ).change(function (){
			var product_id = $("#product option:selected").val();
			if(product_id > 0 ){
				ajax_find_product(product_id);
			}
		});
		
	});
</script>
<iframe target="hide" id="if" src="" style="display:none"></iframe>
	
