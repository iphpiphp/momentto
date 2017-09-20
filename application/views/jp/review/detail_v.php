<!-- #container -->
<div id="container" class="clearfix">

	<!-- 페이지 시작-->

	<!-- lnb -->
	<nav class="lnb">
		<div><a href="/review/lists">리뷰</a></div>
	</nav>

	<!-- article -->
	<article class="view">
		<ul class="lst_notice">
			<li>
				<a href="javascript:;">
					<div class="meta2">
						<span class="label bg_red"><?=$review_info['cate_name']?></span>
						<span class="star_wrp sm ml5">
							<? $i=0; $j = $review_info['score']; for($i=0; 4>=$i; $i++){
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
						<span class="color_blue2">상품명 <b class="fw500"><?=$review_info['product_name'] ?></b></span>
						<i class="split"></i>
						<?=$review_info['memberName'] ?>
							<i class="split"></i> 조회수
							<?=$review_info['viewCount'] ?>
					</div>
					<h3><?=$review_info['title'] ?></h3>
				</a>
			</li>
		</ul>
		<div class="view_notice">
			<?=nl2br($review_info['content'])?>
				<?
						if ($review_info['fileName'])
							echo '<br /><img  style="max-width: 400px" src="' . IMG_O_PATH . '/resources/uploads/review/' . $review_info["fileName"] . '">';
 				?>
		</div>
		<!-- 댓글 -->
		<div class="cmt_wrp">
			<div class="cmt_count">
				댓글이 총 <strong class="color_red"><?=$reply_cnt?>개</strong> 있습니다.
			</div>
			<ul class="lst_cmt">
				<? foreach($reply as $key => $val):?>
				<li class="media">
					<div class="media-left">
						<img class="img-circle" src="<?=PATH3?>img/logo.png" alt="">
					</div>
					<div class="media-body">
						<h4 class="tit"><?=nl2br($val['content']) ?></h4>
						<div class="meta">
							<?=$val['memberName'] ?> <i class="split"></i> <?=$val['createDatetime'] ?>
						</div>
					</div>
				</li>
				<? endforeach; ?>
			</ul>
			<form class="cmt_wrt" id="form_post_reply" action="/review/review_reply/insert" method="POST">
				<input type="hidden" name="reviewId" value="<?=$review_info['id']?>" />
				<input type="hidden" name="productId" value="<?=$review_info['productId']?>" />

				<textarea name="content" class="form-control" rows="4" placeholder="댓글 내용을 입력하세요."></textarea>
				<a  onclick="insert_reply('reply')" class="btn btn-block mt10 mb15 bg_blue2">댓글 등록</a>
				<p class="fs13 text-center color_grey">로그인 하셔야 댓글을 등록 하실 수 있습니다.</p>
			</form>
		</div>
	</article>

	<!-- //페이지 끝-->

</div>
<!-- //container -->
