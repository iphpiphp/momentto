<!-- #container -->
<div id="container" class="clearfix">

	<!-- 페이지 시작-->

	<div id="manual" class="bg_cover">
		<div class="w1140">
			<h1><img class="img-responsive mb60" src="<?=PATH3?>img/manual/h1.png" alt=""></h1>
			<!-- 동영상 -->
			<!-- 16:9 aspect ratio -->
			<div class="embed-responsive embed-responsive-16by9">
				<iframe src="//player.vimeo.com/video/139538248" width="911" height="683" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
			</div>
		</div>
	</div>
	<script>
		// resize
		function pxHeight() {
			$('#manual').css('min-height', $(window).height() - $('#hd').height());
		}

		pxHeight();
		$(window).resize(pxHeight);
	</script>

	<!-- //페이지 끝-->

</div>
<!-- //container -->
