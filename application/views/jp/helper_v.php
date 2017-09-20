<? $product_id = $this->uri->segment(3); ?>
	<!-- #container -->
	<div id="container" class="clearfix">

		<!-- 페이지 시작-->


		<div id="helper">
			<section id="sect1" class="text-center">
				<div class="w1140">
					<h2 class="sr-only">promotion</h2>
					<img class="img-responsive center-block" id="helper_title" src="<?=PATH3?>img/helper/pc.jpg" alt="더데이즈 헬퍼는 동영상 제작대행 서비스 입니다." />
					<div class="sr-only">
						<h3 class="fw400 fs18 fs14-xs mb20" style="opacity:.8">D-day는 다가오는데 시간이 턱없이 부족하세요? 더데이즈의 시스템 조작에 어려움을 겪고 계신가요?</h3>
						<h4 class="fs18-xs">단돈 <strong class="color_sky">9,900</strong>원(일부상품제외) 추가하면 대기중인 더데이즈 헬퍼가 <strong class="color_sky">1시간</strong>만에 <br class="hidden-xs">근사한 동영상 한편을 뚝~딱! 만들어 드립니다.</h4>
					</div>
				</div>
			</section>
			<section id="sect2">
				
				<h2 class="sr-only">promotion</h2>
				<input type="hidden" id="item" value="80047573" />
				<input type="hidden" id="product_id" value="<?=$product_id?>" />
				<form class="row w1140" action="/main/helper_send" method="POST" id="help_post">					
					<input type="hidden" name="subject" id="subject" />
					<input type="hidden" name="message" id="message" />

					<div class="col-sm-8 col-sm-offset-2">
						<section class="step1">
							<div class="step_hd">
								<h3 class="color_red">1. 제품(템플릿)선택</h3>
								<p class="mb40">
									먼저 마음에 드는 템플릿을 선택하세요!
									<br> 템플릿을 선택하시면 하단에 <strong class="color_red">사진 정리폴더 다운</strong> 버튼이
									<br> 생성되며, 클릭하여 다운받은 후 zip파일을 열고 필독사항에
									<br> 따라 사진과 문구를 넣어 주세요.
									<br>(핸드폰에서는 다운로드가 되지 않습니다. PC를 이용해 주세요.)
								</p>
								<div class="form-inline mb50">
									<? ajax_cate(); ?>
								
								<?  if (!$this->agent->is_mobile()){ ?>
									<a id="img_down" class="btn btn-block btn_radius bg_red">사진 정리폴더 다운</a>
									<? } ?>
								</div>
							</div>
							<!-- 16:9 aspect ratio -->
							<div class="embed-responsive embed-responsive-16by9">
								
								<iframe	class="_vimeoPlayer" id="if_id"	width="720"height="400" frameborder="0"	webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>
							</div>
						</section>
						<section class="step2">
							<div class="step_hd">
								<h3 class="color_red">2. 주문/입금하기</h3>
								<p class="mb40">
									선택하신 템플릿 비용 + 헬퍼서비스 비용을
									<br>합산하여 무통장 계좌로 입금해 주세요.
									<br>
									<span class="color_grey">(계좌번호 : 국민은행 535901-01-303137 주식회사 위드비디오)</span>
								</p>
								<div class="row">
									<div class="col-sm-3">
										<label for="" class="color_blue2">제품가격</label>
										<input type="text" class="form-control text-right" id="acg_1" value="9,900" readonly />
									</div>
									<div class="col-sm-1 text-center">
										<label class="hidden-xs">&nbsp;</label>
										<p class="form-control-static">+</p>
									</div>
									<div class="col-sm-3">
										<label for="" class="color_blue2">헬퍼</label>
										<input type="text" class="form-control text-right" id="acg_2" value="9,900" readonly />
									</div>
									<div class="col-sm-1 text-center">
										<label class="hidden-xs">&nbsp;</label>
										<p class="form-control-static">=</p>
									</div>
									<div class="col-sm-3">
										<label for="" class="color_blue2">최종주문금액</label>
										<input type="text" class="form-control text-right bg_blue2" id="acg_3" value="19,800" readonly />
									</div>
								</div>
							</div>
						</section>
						<section class="step3">
							<div class="step_hd">
								<h3 class="color_red">3. 헬퍼 신청서 작성</h3>
								<p class="mb40">
									아래 헬퍼신청서의 정보들을 기입해 주세요!
								</p>
								<div class="form-horizontal mb40 mb20-xs">
									<div class="form-group">
										<label class="col-sm-2 control-label color_blue2">이름</label>
										<div class="col-sm-10">
											<input type="text" class="form-control" name="pname">
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-2 control-label color_blue2">연락처</label>
										<div class="col-sm-10">
											<div class="frm_tel row">
												<div class="col-xs-4">
													<input type="text" class="form-control" maxlength="4" name="tel_1">
												</div>
												<div class="col-xs-4">
													<input type="text" class="form-control" maxlength="4" name="tel_2">
												</div>
												<div class="col-xs-4">
													<input type="text" class="form-control" maxlength="4" name="tel_3">
												</div>
											</div>
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-2 control-label color_blue2">이메일</label>
										<div class="col-sm-10">
											<input type="text" class="form-control" name="mail_from">
										</div>
									</div>
								</div>
								<p class="text-left">
									*다운받으신 <span class="color_red">[사진 정리폴더]</span>에 고객님의 사진, 문구, 음악을 넣어서 알집(zip)으로 압축해서 <span class="color_red">cs@thedays.co.kr</span> 이메일에 첨부하여 보내주세요.
								</p>
							</div>
						</section>
						<section class="step3 fs13">
							<a class="btn bg_red btn-block" id="help_submit">헬퍼 서비스 신청하기</a>
							<p class="mt20 text-left">
								헬프데스크 (1800-5662)로 전화를 주시거나 카톡 (ID:@더데이즈) 친구 추가 후, <span class="color_red">신청서 확인 메시지</span>를 보내주세요.
							</p>
							<p class="mt10 text-left color_grey">예) 홍길동, 웨딩 You and I 헬퍼 신청서 보냈습니다. 확인 바랍니다.</p>
						</section>
					</div>
				</form>
			</section>
			<section id="sect3">
				<div class="row w1140">
					<div class="col-sm-4">
						<h2 class="h3"><i class="icon_chk"></i> 영상제작 및 완성</h2>
					</div>
					<div class="col-sm-8 fs13">
						<ol class="ml15 mb15">
							<li>영상제작이 시작되면 고객님에게
								<br><span class="color_red">카톡 또는 문자메시지</span>를 보내 드립니다.</li>
							<li id="info_text_helper1">30분~1시간 이내로 완성된 영상을
								<br>이메일로 받아보실 수 있습니다.</li>
							<li id="info_text_helper2"><span class="color_red">1회에 한해 수정가능</span>하며, 수정본 역시 1시간 이내에
								<br>완료하여 보내드립니다.</li>
						</ol>
						<p class="color_grey">
							* 헬퍼 서비스 운영시간 : 평일 09:30 ~ 17:00 (주말, 공휴일 휴무)
							<br> * 운영 시간 내에 접수된 제작의뢰 건은 즉시 제작해 드리며, 평일 17:00 이후의 제작의뢰 건은 익일 오전에, 주말에 접수 된 제작의뢰 건은 월요일 오전에 제작 완료하여 보내드립니다.
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
		//ajax_find_product();//카테고리 init
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
				chang_helper_title_img(product_id);//헬퍼 이미지 동영상 버전과 일반 버전 이미지 변경
			}
		});
		
	});
</script>
<iframe target="hide" id="if" src="" style="display:none"></iframe>
