<!-- #container -->
	<div id="container" class="clearfix">

<!-- 페이지 시작-->

<div class="row side_page w1140">
	
	
	<!-- content -->
	<div id="ct" class="col-sm-10 col-xs-12 pl50 pl0-xs">
		<h1 class="sub_hd">
			리뷰
		</h1>
	<table id="notice-board-table" class="styled-table">
		<colgroup>							
			<col style="width: 100px;">
			<col style="width: 100px;">
			<col style="width: 100px;">
			<col style="">
		</colgroup>
		<thead>
			<!-- th class="pre5">평점</th -->
			<th>상품명</th>
			<th>제목</th>
			<th>조회수</th>
		</thead>
		<tbody><!--class open_review -->
			<? foreach($lists as $key => $val): ?>
				<tr>
					<!-- td><label for="rating<?=$val['score'] ?>"><span class="rating rating-<?=$val['score'] ?>"></span></label></td -->
					<td><a href="<?=Base_url() . "product/detail/" . $val['productId'] ?>"><?=$val['name'] ?></a></td>
					<td><a href="/review/detail/<?=$val['id'] ?>" class="" item="<?=$val['id'] ?>" itemid="<?=$val['productId'] ?>" ><?=$val['title'] ?></a></td>					
					<td><?=$val['viewCount'] ?></td>
				</tr>
				<tr style="display:none" id="tr_<?=$val['id'] ?>" class="tr">
					<td></td>
					<td class="" style="width:200px;" colspan="3"><?=nl2br($val['content']) ?><?
						if ($val['fileName'])
							echo '<br /><img  style="max-width: 400px" src="' . Base_url() . 'resources/uploads/review/' . $val["fileName"] . '">';
 ?>
					</td>					
					<td></td>
				</tr>
				<tr style="display:none" id="trr_<?=$val['id'] ?>" class="trr"><td id="trd_<?=$val['id'] ?>" colspan="5" width="100%"></td></tr>
				<tr  style="display:none" class="ajax_retrun ajax_retrun_<?=$val['id'] ?>"><td></td><td colspan=4 class="ajax_retrun_td_<?=$val['id'] ?>"></td></tr>
				<? foreach($reply as $key => $val2): ?>
					<? if($val2['reviewId'] == $val['id']){ ?>
						<tr class="trrd trrd_<?=$val['id'] ?>" style="display:none">
							<td> <?=$val2['memberName'] ?> </td>
							<td colspan="4">
								<?=nl2br($val2['content']) ?><?
								if ($val2['fileName'])
									echo '<br /><img  style="max-width: 400px" src="' . Base_url() . 'resources/uploads/review/' . $val2["fileName"] . '">';
 ?>
							</td>
						</tr>
					<? } ?>				
				<? endforeach; ?>
			<? endforeach; ?>
		</tbody>
	</table>
	<div class="page-nation">
		<ul class="pagination">
			<?=$page_nation ?>
		</ul>
	</div>
</div>
</div>
</div>


<form action="" method="get" id="form_page">
	<input type="hidden" name="cate_id" id="cate_id" value="0" />
</form>
