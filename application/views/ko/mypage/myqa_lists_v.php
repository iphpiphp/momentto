<!-- #container -->
<div id="container" class="clearfix">

	<!-- 페이지 시작-->

	<!-- lnb -->
	<? aside_top_mypage();?>

		<!-- search -->


		<!-- list -->
		<ul class="lst_notice">
			<? foreach($lists as $key => $val): ?>
				<li>
					<a href="/mypage/myqa/views/<?=$val['id']?>">
						<h3><?=$val['title']?></h3>
						<div class="meta">
							<?=$val['createDatetime']?>
						</div>
					</a>
				</li>
				<? endforeach; ?>
		</ul>

		<!-- //페이지 끝-->

</div>
<!-- //container -->
