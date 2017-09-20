	

	<!-- #container -->
	<div id="container" class="clearfix">

<!-- 페이지 시작-->

<div id="review" class="row side_page w1140">
	<h1 class="sub_hd">
		<?=$review_info['title'] ?>
	</h1>
		
	<div class="input_review">						
		<!-- 리뷰 보기 에서만 나타남 -->
		<table class="table">
			<tbody><tr>
				<th scope="row">평점</th>
				<td><span class="rating rating-<?=$review_info['score'] ?>"></span></td>
				<th scope="row">작성자</th>
				<td><?=$review_info['memberName'] ?></td>
			</tr>
			<tr>
				<th scope="row">조회수</th>
				<td><?=$review_info['viewCount'] ?></td>
				<th scope="row">작성일</th>
				<td><?=date('Y-m-d', strtotime($review_info['createDatetime'])) ?></td>
			</tr>
		</tbody></table>
	</div>

	<!-- 카테고리 선택 -->
	<!-- 리뷰 리스트에서 글 쓰기로 들어 왔을 경우 -->	
	

	<!-- 1. 수정 하기 2. 글쓰기 에서는 textarea 3. 보기에는 div -->
	<div class="row">
		<div class="col-xs-12 mt15">
			<!-- textarea rows="8" cols="100" class="form-control icon-textarea" style="width:100%"></textarea -->
			<div class="" style="min-height:300px; display: inline-block;">
				<?=nl2br($review_info['content'])?>
				<?
						if ($review_info['fileName'])
							echo '<br /><img  style="max-width: 400px" src="' . IMG_O_PATH . 'resources/uploads/review/' . $review_info["fileName"] . '">';
 				?>
				
			</div>
		</div>		
		<!--
			* 해당 권한이 있을 경우 버튼이 노출 됨. 아니면 노출 안됨
		 * case 1 수정 
		 * 수정 일때는 수정 버튼 , 삭제 버튼
		 * case 2 뷰
		 * 수정 버튼, 삭제 버튼 
		 * case 3 글쓰기
		 * 쓰기 버튼	
		-->
		<!-- div class="col-xs-12 btn_group pt10 pb10 text-right">
			
			<a href="/review/modify/<?=$review_info['id']?>" class="btn btn_blk  w80 mb5">수정</a>
			<a href="javascript:review_del(<?=$review_info['id']?>);"  class="btn btn_blk  w80 mb5">삭제</a>
			<a href="/review/write/<?=$review_info['id']?>" class="btn btn_blk  w80 mb5" style="color: ##DA4A61;">글쓰기</a>
		</div -->
	</div>

	<!-- 댓글 등록 폼 -->
	<div class="cmt_wrt_wrp pt15-xs pb15-xs">
		<div>
			<form class="bx2" id="form_post_reply" action="/review/review_reply/insert" method="POST">
				<input type="hidden" name="reviewId" value="<?=$review_info['id']?>" />
				<input type="hidden" name="productId" value="<?=$review_info['productId']?>" />
				<div class="form-group">
					<textarea rows="5" name="content" class="form-control input-lg" placeholder="내용 (무비에 대한 문의사항은 고객센터를 이용해 주세요.)"></textarea>
				</div>				
				<div class="row">
					
					<div class="col-sm-3 col-xs-12">
						
						<a  onclick="insert_reply('reply')" class="btn btn-lg btn-block bg_red">댓글 등록</a><span>로그인 하셔야 댓글을 등록 하실 수 있습니다.</span>
					</div>
				</div>
			</form>
		</div>
	</div>
	
	
	
	<!-- 댓글 리스트 -->
	<div class="pb40">
		<div class="pt20 pt0-xs mb15-xs color_grey fs20 fs14-xs">
			댓글이 총 <strong class="color_red"><?=$reply_cnt?></strong>개 있습니다.
		</div>
		<ul class="cmt_lst2">
			<? foreach($reply as $key => $val):?>
			<li class="media">
				<div class="media-left">
					<img width=80 height=80 src="<?=IMG_PATH ?>img/profile/profile.png" class="img-circle img-thumbnail" />
				</div>
				<div class="media-body">
					<h4 class="media-heading"><?=$val['memberName'] ?></h4>
					<div class="fs11 color_grey"><?=$val['createDatetime'] ?></div>
					<div class="cmt_content"><?=nl2br($val['content']) ?></div>
				</div>
			</li>
			<? endforeach; ?>
			<? if(count($reply)<= 0) {?>
			
			<? }?>
			
		</ul>
		<!-- nav class="text-center">
			<ul class="pagination">
				<li><a href="#" aria-label="Previous"><span aria-hidden="true">«</span></a></li>
				<li class="active"><a href="#">1</a></li>
				<li><a href="#">2</a></li>
				<li><a href="#">3</a></li>
				<li><a href="#">4</a></li>
				<li><a href="#">5</a></li>
				<li><a href="#" aria-label="Next"><span aria-hidden="true">»</span></a></li>
			</ul>
		</nav -->
	</div>
		
</div>

<!-- //페이지 끝-->

	</div>
	<!-- //container -->
	