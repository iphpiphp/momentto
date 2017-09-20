	<!-- Footer -->
	<footer id="ft">
		<div class="row w1140">
			<div class="col-xs-2 hidden-xs">
				<img class="img-responsive" src="/assets/img/logo_ft.png" alt="logo">
			</div>
			<!-- ul class="col-sm-2 col-xs-12">
				<li><a href="#">withVIDEO</a></li>
				<li><a href="javascript:alert('준비중입니다.');">withVIDEO소개</a></li>
				<li><a href="https://www.facebook.com/%EB%8D%94%EB%8D%B0%EC%9D%B4%EC%A6%88-1445304675718246/">withVIDEO 페이스북</a></li>
				<li><a href="javascript:alert('준비중입니다.');">withVIDEO 블로그</a></li>
				<li><a href="/customer/policy">withVIDEO 정책</a></li>
				<li><a href="/customer/privacy">개인정보방침</a></li>
				<li><a href="javascript:alert('준비중입니다.');">채용정보</a></li>
			</ul>
			<ul class="col-sm-2 col-xs-12">
				<li><a href="#">도움말</a></li>
				<li><a href="/customer/notice">공지사항</a></li>
				<li><a href="/customer/emailQa">1:1문의</a></li>
				<li><a href="/customer/faq/">자주하는 질문</a></li>
				<li><a href="javascript:alert('준비중입니다.');">withVIDEO 소식지</a></li>
			</ul>
			<ul class="col-sm-2 col-xs-12">
				<li><a href="/customer/partner">협력 / 제휴</a></li>
				<li><a href="javascript:alert('준비중입니다.');">제품 입점</a></li>
				<li><a href="javascript:alert('준비중입니다.');">상품 제휴</a></li>
				<li><a href="javascript:alert('준비중입니다.');">마케팅 제휴</a></li>
				<li><a href="javascript:alert('준비중입니다.');">PPL. 광고 문의</a></li>
				<li><a href="javascript:alert('준비중입니다.');">대량구매</a></li>
			</ul -->
			<div class="col-sm-6  col-xs-10 ">
				<a href="/customer/company">회사소개</a> | 
				<a href="/customer/policy">이용약관</a> |
				<a href="/customer/privacy">개인정보보호방침</a> |
				<a href="http://www.ftc.go.kr/info/bizinfo/communicationList.jsp" target="_blank">사업자정보확인</a> |
				<a href="/customer/partner">협력 / 제휴</a><br><br>
				<address class="">
				(우 157-804 ) 서울특별시 강서구 양천로 551-24, 506호<br> (가양동, 한화비즈메트로 2차)<br>
				상호명: 주식회사 위드비디오 | 대표이사 최옥현, 이상교<br>
				통신판매업신고 제2015-서울강서-0574 <br>사업자등록번호 771-87-00082<br>
				고객센터 : 02.562.3618 | fax : 02.3775.4100 <br>
				<a href="mailto:cs@thedays.co.kr">cs@thedays.co.kr</a> | 개인정보관리책임자 옥지현팀장<br>
				Copyright&copy; 2013 - 2015 thedays All Rights Reserved.<br> Contact webmaster for more information<br>
				</address>
			</div>
			<div class="col-sm-4 col-xs-2 ft_sns text-right">
				<a href="https://www.facebook.com/%EB%8D%94%EB%8D%B0%EC%9D%B4%EC%A6%88-1445304675718246/" target="_blank"><i class="fa fa-facebook"></i><span class="sr-only">facebook</span></a>
				<a href="https://twitter.com/for_theDays" target="_blank"><i class="fa fa-twitter"></i><span class="sr-only">twitter</span></a>
				<!-- a href="" target="_blank"><i class="fa fa-google"></i><span class="sr-only">google</span></a -->
			</div>
			
		</div>
	</footer>


	<!-- Javascripts -->
	
	
	
	<script type='text/javascript' language='javascript'>
		
		var agent = navigator.userAgent.toLowerCase();
		if ((navigator.appName == 'Netscape' && navigator.userAgent.search('Trident') != -1) || (agent.indexOf("msie") != -1)) {
			if(detectIE() == "25" || detectIE() == "7")
			{
				if(detectIE() == "7") {
					document.location.href = "http://www.thedays.co.kr";
				}else{
					//alert("호환모드");
				}
			}
		} else {
			//alert("인터넷 익스플로러 브라우저가 아닙니다.");
		}

		function detectIE() {

			var agent = navigator.userAgent.toLowerCase();

			if (agent.indexOf('msie') == -1 && agent.indexOf('trident') == -1) return;

			if (agent.indexOf('msie 7') > -1 && agent.indexOf('trident') > -1) {
				return "7";
			} else {

				if (agent.indexOf('msie') == -1) return 11;
				return agent.indexOf('msie');

			}
		}
	</script>
	
<!-- Important javascript libs(put in all pages) -->
<!-- script src="http://code.jquery.com/jquery-2.1.1.min.js"></script>
<script type='text/javascript' language='javascript'>
	window.jQuery || document.write('<script src="/assets/js/libs/jquery-2.1.1.min.js">\x3C/script>')
</script>
<script src="http://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
<script type='text/javascript' language='javascript'>
	window.jQuery || document.write('<script src="/assets/js/libs/jquery-ui-1.10.4.min.js">\x3C/script>')
</script -->

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
		$("input:radio, input:checkbox").click(function () {
			this.blur();
			this.focus();
		});
	}	
</script>

<!-- ajax file upload plu -->
<script src="/assets/js/jquery.form.js"></script>
<!-- Bootstrap plugins -->
<script src="/assets/js/bootstrap/bootstrap.js"></script>
<!-- Core plugins ( not remove ) -->
<script src="/assets/js/libs/modernizr.custom.js"></script>
<!-- Handle responsive view functions -->
<script src="/assets/js/jRespond.min.js"></script>
<!-- Custom scroll for sidebars,tables and etc. -->
<script src="/assets/plugins/core/slimscroll/jquery.slimscroll.min.js"></script>
<script src="/assets/plugins/core/slimscroll/jquery.slimscroll.horizontal.min.js"></script>
<!-- Highlight code blocks -->


<!-- Handle template sounds -->
<!-- script src="/assets/plugins/misc/ion-sound/ion.sound.js"></script -->

<!-- Proivde quick search for many widgets -->
<script src="/assets/plugins/core/quicksearch/jquery.quicksearch.js"></script>

<!-- Prompt modal -->
<script src="/assets/plugins/ui/bootbox/bootbox.js"></script>
<!-- Other plugins ( load only nessesary plugins for every page) -->



<script src="/assets/plugins/forms/icheck/jquery.icheck.js"></script>
<script src="/assets/plugins/misc/gallery/jquery.magnific-popup.min.js"></script>
<!-- popup icon -->
<script src="/assets/plugins/misc/mixitup/jquery.mixitup.min.js"></script>
<script src="/assets/js/jquery.appStart.js"></script>
<script src="/assets/js/app.js"></script>
<!-- script src="/assets/js/pages/blank.js"></script -->
<script src="/assets/js/pages/gallery.js"></script>

<!-- user custom -->
<script src="/assets/js/phpjs.js"></script>
<!-- script src="/resources/scripts/AjaxUploader.js"></script -->

<?=lang('ko')?>
<script src="/assets/js/common.php"></script>

<!-- script src="/assets/plugins/ui/video/video.js"></script -->
<!-- script>videojs(document.getElementById('example_video_1'), {}, function() {});</script -->

	

	<!-- lib -->
	<script src="/assets/js/jquery.bxslider.min.js"></script>
	

</div>

</body>

</html>