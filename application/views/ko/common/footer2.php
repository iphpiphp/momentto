<!-- Footer -->
<footer id="ft">
	<div class="ft_top">
		<img src="<?=PATH2?>img/kakao.png" alt="" />
		<p class="color_red pt15 pb5">문의사항은 실시간 카카오톡으로 보내주세요</p>
		<span class="fs16">ID : 더데이즈</span>
		<img class="mt30 mb15" src="<?=PATH2?>img/icon_time2.png" alt="" />
		<dl>
			<dt>근무시간</dt>
			<dd class="fs16 pt5">09:30~18:00</dd>
		</dl>
	</div>
	<ul class="fnb pt50 pb20">
		<li><a href="/customer/company">회사소개</a></li>
		<li><a href="/customer/policy">이용약관</a></li>
		<li><a href="/customer/privacy">개인정보보호방침</a></li>
		<li><a href="http://www.ftc.go.kr/info/bizinfo/communicationList.jsp" target="_blank">사업자정보확인</a></li>
		<li><a href="/customer/partner">협력/제휴</a></li>
	</ul>
	<dl class="ft_btm clearfix">
		<dt>상호</dt>
		<dd>주식회사 위드비디오</dd>
		<dt>사업자등록번호 </dt>
		<dd>771-87-00082</dd>
		<dt>대표</dt>
		<dd>최옥현</dd>
		<dt>통신판매업신고</dt>
		<dd>제2015-서울강서-0574</dd>
		<dt>전화</dt>
		<dd>1800.5662</dd>
		<dt>이메일</dt>
		<dd>cs@thedays.co.kr</dd>
		<dt>개인정보보호담당</dt>
		<dd>옥지현</dd>
		<dt>주소</dt>
		<dd>서울특별시 강서구 양천로 551-24, 506호 (가양동, 한화비즈메트로 2차)</dd>
		<dt>계좌번호</dt>
		<dd>국민은행 535901-01-303137<br>주식회사 위드비디오</dd>
	</dl>
	<div class="sns_link pt20">
		<!-- a href="https://www.facebook.com/%EB%8D%94%EB%8D%B0%EC%9D%B4%EC%A6%88-1445304675718246/" target="_blank">페이스북</a -->
		<!--a href="https://twitter.com/for_theDays" target="_blank">트위터</a -->
		<a href="https://thedays.co.kr/main?mobile=true" target="_blank"  >PC</a>
	</div>
</footer>
<!-- //Footer -->
</div>
<!-- //wrap -->


<? $v = mt_rand(1,1000); ?>
	<!--[if lt IE 9]>
	<script type="text/javascript" src="assets/js/libs/excanvas.min.js"></script>
	<script type="text/javascript" src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<script type="text/javascript" src="assets/js/libs/respond.min.js"></script>
	
	<script src="js/jquery.placeholder.js"></script>
	<script src="js/ie9.js"></script>
<![endif]-->

	<script type='text/javascript' language='javascript'>
		jQuery.browser = {};
		jQuery.browser.mozilla = /mozilla/.test(navigator.userAgent.toLowerCase()) && !/webkit/.test(navigator.userAgent.toLowerCase());
		jQuery.browser.webkit = /webkit/.test(navigator.userAgent.toLowerCase());
		jQuery.browser.opera = /opera/.test(navigator.userAgent.toLowerCase());
		jQuery.browser.msie = /msie/.test(navigator.userAgent.toLowerCase());
		jQuery.browser.chrome = /chrome/.test(navigator.userAgent.toLowerCase());

		if ($.browser.msie) { /*IE fix for on change handling */
			$("input:radio, input:checkbox").click(function() {
				this.blur();
				this.focus();
			});
		}
	</script>
	<script src="<?=PATH3?>js/jquery-ui.js?_v=1"></script>
	
	<!-- ajax file upload plu -->
	<script src="<?=PATH3?>js/jquery.form.js?_<?=$v?>"></script>
	<!-- lib -->
	<script src="<?=PATH3?>js/jquery.bxslider.min.js?_<?=$v?>"></script>



	<!-- Bootstrap plugins -->

	<script src="<?=PATH3?>js/bootstrap.min.js"></script>
	<script src="<?=PATH_ADMIN3?>plugins/core/slimscroll/jquery.slimscroll.min.js"></script>
	<script src="<?=PATH_ADMIN3?>plugins/core/slimscroll/jquery.slimscroll.horizontal.min.js"></script>
	
	<!-- user custom -->
	<script src="<?=PATH3?>js/phpjs.js"></script>
	<!-- script src="/resources/scripts/AjaxUploader.js"></script -->
	<!-- script src="/assets/plugins/ui/video/video.js"></script -->
	<!-- script>videojs(document.getElementById('example_video_1'), {}, function() {});</script -->


	<!-- common -->
	<script src="<?=PATH3?>js/common.js?_<?=$v?>"></script>



	</body>

	</html>
