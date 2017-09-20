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
		
				<div id="content-main">
					<section id="notice-board" class="board-frame">
						<div id="notice-view" class="board-view-frame">
							<table id="notice-view-table" class="board-view-table styled-table stable-solid" summary="공지사항 내용보기로 구분,제목,등록일,내용 정보제공">
								<tbody>
									<tr>
										<th scope="row">구분</th>
										<td><?=$notice['type'] ?></td>
									</tr>
									<tr>
										<th scope="row">제목</th>
										<td><?=$notice['title'] ?></td>
									</tr>
									<tr>
										<th scope="row">등록일</th>
										<td><?=$notice['createDatetime'] ?></td>
									</tr>
									<tr>
										<th scope="row">내용</th>
										<td class="content multiline">
											<?=$notice['content'] ?>
										</td>
									</tr>
								</tbody>
							</table><!-- .board-view-table -->

							<footer>
								<a href="/customer/notice" id="listBtn" class="btn-list global-btn gbtn-a"><span class="in">목록</span></a>
							</footer>
						</div><!-- .board-view-frame -->

					</section><!-- #notice-board -->

				</div>
			</div>
		</div>
	</div>

