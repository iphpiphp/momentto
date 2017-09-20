<!-- #container -->
<div id="container" class="clearfix">

	<!-- 페이지 시작-->

	<!-- lnb -->
	<nav class="lnb">
		<a>리뷰</a>
	</nav>

	<!-- list -->
	<ul class="lst_notice">
		<? foreach($lists as $key => $val): ?>
		<li>
			<a href="/review/detail/<?=$val['id'] ?>" class="" item="<?=$val['id'] ?>" itemid="<?=$val['productId'] ?>" >
				<div class="meta2">
					<span class="label bg_red"><?=$val['cate_name']?></span>
					<span class="star_wrp sm ml5">
						<? $i=0; $j = $val['score']; for($i=0; 4>=$i; $i++){
							if($j>0){
								$star = "on";
							 }else{
								$star = "";
							}
							echo '<i class="fa fa-star '.$star.'"></i>';
							$j--;
	
						} ?>

				</span>
				</div>
				<div class="meta">
					<span class="color_blue2">상품명 <b class="fw500"><?=$val['name'] ?></b></span>
					<i class="split"></i> <?=$val['memberName'] ?>
					<i class="split"></i> 조회수 <?=$val['viewCount'] ?>
				</div>
				<h3><?=$val['title'] ?></h3>
			</a>
		</li>
		<? endforeach; ?>
	</ul>
	<div class="page-nation text-center">
					<ul class="pagination">
						<?=$page_nation?>
					</ul>
				</div>

	<!-- //페이지 끝-->

</div>
<!-- //container -->
