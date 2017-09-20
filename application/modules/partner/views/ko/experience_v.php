<!-- #container -->
<div id="container" class="clearfix">

	<!-- 페이지 시작-->

	<div id="experience" class="bg_cover">
		<div class="w1140 text-center">
			<h1><img class="img-responsive center-block mb30" src="<?=IMG_PATH ?>img/experience/h1.png" alt=""><span class="label pa10 pl20 pr20 bg_violet fw400 fs15 fs12-xs" style="white-space:normal; line-height:1.4">체험용 샘플 무비이므로 제작시 미리보기까지만 제공해 드리며, 최종 완성될 무비 형태로 제공하지는 않습니다.</span></h1>
			<div class="event_movie_wrp">
				<div class="event_movie">
					<div class="flag"><img src="<?=IMG_PATH ?>img/logo.png" alt="logo">
					</div>
					<div class="ppm-player-frame">
						<div id="vimeoPlayerArea" style="min-height: 386px;">
							<iframe width="684" height="386" class="_vimeoPlayer" id="vimeoPlayer" src="http://player.vimeo.com/video/135642810?api=1&amp;player_id=135642810&amp;color=e54b63" frameborder="0" allowfullscreen="" webkitallowfullscreen="" mozallowfullscreen=""></iframe>
						</div>
					</div>
				</div>

				
			</div>
			<div class="clearfix">
				<? if($this->agent->is_mobile()){ ?>
					<a class="btn btn-lg bg_red ma0-xs" href="#" >PC 에서만 체험 하기가 가능 합니다.</a>
				<? }else{ ?>
					<a class="btn btn-lg bg_red ma0-xs" href="#" onclick="experienceMovieMaker('https://s3-ap-northeast-1.amazonaws.com/thedays-preset/exp/index.html')">무비메이커 체험 시작하기</a>
				<? } ?>
			</div>
		</div>
	</div>
	<script>
		// resize
		function pxHeight() {
			$('#experience').css('min-height', $(window).height() - $('#hd').height());
		}

		pxHeight();
		$(window).resize(pxHeight);
	</script>

	<!-- //페이지 끝-->

</div>
<!-- //container -->