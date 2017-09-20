<!-- #container -->
<div id="container" class="clearfix">

	<!-- 페이지 시작-->

	<!-- lnb -->
	<? customer_top_menu();?>

	<!-- article -->
	<article class="view">
		<ul class="lst_notice">
			<li>
				<a>
					<h3><?=$notice['title']?></h3>
					<div class="meta"><?=$notice['createDatetime']?></div>
				</a>
			</li>
		</ul>
		<div class="view_notice">
			<?=$notice['content']?>
		</div>
		<div class="view_nav text-center">
			<a class="btn w160" href="/customer/notice">목록</a>
		</div>
	</article>

	<!-- //페이지 끝-->

</div>
<!-- //container -->
