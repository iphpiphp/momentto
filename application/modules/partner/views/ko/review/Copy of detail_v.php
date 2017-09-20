<!-- #container -->
	<div id="container" class="clearfix">

<!-- 페이지 시작-->

<div class="row side_page w1140">
	
	
	<!-- content -->
	<div id="ct" class="col-sm-10 col-xs-12 pl50 pl0-xs">
		<h1 class="sub_hd">
			<?=$review_info['title']?>[글 보기 일때 나타남]
		</h1>
		
	<div class="input-review">
		<!-- 1.수정하기 2.리뷰 리스트에서 글쓰기 -->
		<table class="table">
			<tr>
				<th>제목</th>
				<td>
					<input type="text" name="title" /> [신규 글쓰기, 수정 하기일때 나타남]
				</td>
			</tr>
		</table>
		
		

		<!-- 리뷰 보기 에서만 나타남 -->
		[글보기 일때만 나타남]
		<table class="table">
			<tr>
				<th>평점</th>
				<td><span class="rating rating-<?=$review_info['score']?>"></span></td>
				<th>작성자</th>
				<td><?=$review_info['memberName']?></td>
			</tr>
			<tr>
				<th>조회수</th>
				<td><?=$review_info['viewCount']?></td>
				<th>작성일</th>
				<td><?=date('Y-m-d',strtotime($review_info['createDatetime']))?></td>
			</tr>
		</table>
	</div>

	<!-- 카테고리 선택 -->
	<!-- 리뷰 리스트에서 글 쓰기로 들어 왔을 경우 -->
	<style>
		.select_group {
			width: 100%;
			display: inline-block;
		}
		.select_group #group1 {
			width: 200px;
			float: left;
		}
		.select_group #group2 {
			width: 200px;
			float: left;
		}		
	</style>
	[글쓰기 일때 나타남. 수정일때도 나타나지만 선택 금지]
	<div class="select_group">
		<div id="group1">
			<select name="cate" id="cate">
				<option class="cate_options" value="0">대분류를 선택하세요</option>
				<option class="cate_options" value="1" selected="selected">BABY&amp;KIDS</option><option class="cate_options" value="2">LOVE</option><option class="cate_options" value="3">WEDDING</option><option class="cate_options" value="4">BIRTHDAY</option><option class="cate_options" value="5">TRAVEL</option><option class="cate_options" value="6">SALE</option>
			</select>
		</div>
		<div id="group2">
			<select name="product" id="product">
				<option calss="cate_options" value="">제품을 선택하세요</option><option class="cate_options" value="2">You are our dream</option><option class="cate_options" value="12">가족의 탄생</option><option class="cate_options" value="17" selected="selected">Amazing Birthday Party</option><option class="cate_options" value="41">아빠만 보세요</option><option class="cate_options" value="47">오늘 유치원 가?</option>
			</select>
		</div>

	</div>

	<!-- 1. 수정 하기 2. 글쓰기 에서는 textarea 3. 보기에는 div -->
	<div class="row">
		<div class="col-lg-12"style="display: block">
			<textarea rows="8" cols="100" class="form-control icon-textarea" style="width:100%" ></textarea>
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
		
		<div class="col-lg-12"  >
			
			<div class="btn_group" style="padding-top:10px; padding-bottom:10px; display:inline-block">
				[버튼 색상 별로 차등 ]
				<a href="#" class="btn btn_blk  w80 mb5">수정</a>
				<a href="#" class="btn btn_blk  w80 mb5">삭제</a>
				<a href="#" class="btn btn_blk  w80 mb5" style="color: ##DA4A61;">글쓰기</a>
			</div>
		</div>
	</div>

	<!-- 댓글 등록 폼 -->
	<div class="row">
		<div class="col-lg-12" >
			<h3>댓글 등록</h3>
			<textarea name="content" class="form-control icon-textarea" rows="3" placeholder="*무비에 대한 문의사항은 고객센터를 이용해주세요."></textarea>
		</div>
		<div class="col-lg-12" >
			<div class="col-lg-12 btn_group" style="padding-top:10px; padding-bottom:10px; display:inline-block; text-align: right">
				<a href="#" class="btn btn_blk  w80 mb5" style="">댓글등록</a>
			</div>
		</div>
	</div>
	
	<!-- 댓글 리스트 -->
	<style>
		.reply_block_left{float:left;}
		.reply_block_right{float:left;}
	</style>
	<div class="row">
		<h3>댓글 리스트 [마진값 적당히 조절- 글과 글 사이 솔리드 라인 추가 ]</h3>
		<div>
			<? foreach($reply as $key => $val):?>
				<div class="reply_block clearfix">
					<div class="reply_block_left"><img width=50 height=50 src="<?=IMG_PATH?>img/profile/profile.png" class="img-circle img-thumbnail" /></div>
					<div class="reply_block_right">
						<div class="reply_info"><?=$val['memberName']?></div>
						<div class="reply_content"><?=$val['content']?></div>
					</div>
					<!-- div class="reply_img"><? if($val['fileName']){echo '<br /><img  style="max-width: 400px" src="' . Base_url() . 'resources/uploads/review/' . $val["fileName"] . '">';} ?></div -->
				</div>
			<? endforeach; ?>
		</div>
	</div>

</div>
</div>
</div>

