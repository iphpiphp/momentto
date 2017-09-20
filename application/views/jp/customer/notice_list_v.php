<!-- #container -->
<div id="container" class="clearfix">

	<!-- 페이지 시작-->

	<!-- lnb -->
	<? customer_top_menu();?>

		<!-- search -->
		<form class="srch row" id="form_post">
			<div class="col-xs-3">
				<select class="form-control input-sm">
					<option value="" selected>전체</option>
					<option value="1">발표</option>
					<option value="2">공지</option>
					<option value="3">모집</option>
					<option value="4">필독</option>
					<option value="5">이벤트</option>
				</select>
			</div>
			<div class="col-xs-9">
				<input type="text" class="form-control input-sm" name="stx">
				<button type="submit" class="no_style"><i class="fa fa-search"></i><span class="sr-only">검색</span></button>
			</div>
		</form>

		<!-- list -->
		<ul class="lst_notice">
			<? foreach($lists as $key => $val): ?>
				<li>
					<a href="/customer/notice_view/<?=$val['id']?>">
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
