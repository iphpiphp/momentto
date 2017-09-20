<!-- #container -->
	<div id="container" class="clearfix">

<!-- 페이지 시작-->

<div class="row side_page w1140">
	<!-- side -->
	<?=aside_left_customer() ?>
	<!-- content -->
	<div id="ct" class="col-sm-10 col-xs-12 pl50 pl0-xs">
		<h1 class="sub_hd">
			공지사항
		</h1>		
				<section id="notice-board" class="board-frame">
		
					<table id="notice-board-table" class="styled-table" summary="공지사항으로 번호,구분,제목,등록일 정보제공">
						<colgroup>							
							<col style="width: 95px;">
							<col style="width: 380px;">
							<col style="width: 164px;">
						</colgroup>
						<thead>
							<tr>								
								<th class="cat">구분</th>
								<th>제목</th>
								<th>등록일</th>
							</tr>
						</thead>
						<tbody>
							<? foreach($lists as $key => $val): ?>
							<tr>
								<td class="cat"><?=$val['type']?></td>
								<td class="tit"><a href="/customer/notice_view/<?=$val['id']?>" class="viewBtn" ><?=$val['title']?></a></td>
								<td><?=$val['createDatetime']?></td>
							</tr>
							<? endforeach; ?>
						</tbody>
					</table>

					<footer>
						<div class="page-nation">
							<ul class="pagination">
								<?=$page_nation?>
							</ul>
						</div>
						
						<fieldset class="search-field" style="margin-top:20px;">
							<form action="" action="get" id="form_post">							
							<select class="select" id="searchType" style="z-index: 10; padding: 5px 5px 8px 5px;">
								<option value="" selected>전체</option>
								<option value="1">발표</option>
								<option value="2">공지</option>
								<option value="3">모집</option>
								<option value="4">필독</option>
								<option value="5">이벤트</option>
							</select>
							<input type="text" id="input-search-board" name="stx" class="styled-input">
							<a id="searchBtn" href="#" class="btn-search global-btn gbtn-g"><span class="in">검색</span></a>
							</p><!-- .styled-select-box -->
							</form>
						</fieldset>
					</footer>
				</section>

			</div>
		</div>
	</div>

