<!-- #container -->
<div id="container" class="clearfix">

	<!-- 페이지 시작-->

	<!-- lnb -->
	<? aside_top_mypage();?>

	<!-- article -->
	<article class="view">
		<ul class="lst_notice">
			<li>
				<a>
					<h3><?=$myqa['title']?></h3>
					<div class="meta"><?=$myqa['createDatetime']?></div>
				</a>
			</li>
		</ul>
		<div class="view_notice">
			<?=$myqa['content']?>
		</div>
		<div class="view view_notice">
			<pre><?=$myqa['reply']?></pre>
		</div>
		<div class="view_nav text-center">
			<a class="btn w160" href="/mypage/myqa/lists">목록</a>
		</div>
	</article>

	<!-- //페이지 끝-->

</div>
<!-- //container -->
