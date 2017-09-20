<!-- #container -->
<div id="container" class="clearfix">

	<!-- 페이지 시작-->

	<div id="bg_company" class="bg_cover" style="min-height: 800px; ">
		<div class="w1140">
			<!-- h1><img class="img-responsive mb60" src="<?=IMG_PATH?>img/manual/h1.png" alt=""></h1 -->
			<!-- 동영상 -->
			<!-- 16:9 aspect ratio -->
			
		</div>
	</div>
	<script>
		// resize
		function pxHeight() {
			$('#bg_company').css('min-height', $(window).height() - $('#hd').height());
		}

		pxHeight();
		$(window).resize(pxHeight);
	</script>

	<!-- //페이지 끝-->

</div>
<!-- //container -->