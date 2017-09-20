<div class="col-lg-8">
		<form action="/review/review_reply/insert" method="post" enctype="multipart/form-data" id="form_post_review">
			<input type="hidden" name="productId" value="<?=$this->uri->segment(4)?>" />
			<input type="hidden" name="reviewId" value="<?=$this->uri->segment(3)?>" />			
			<input type="hidden" name="uri_1" value="<?=$this->uri->segment(1)?>" />
			<input type="hidden" name="uri_2" value="<?=$this->uri->segment(2)?>" />
			<input type="hidden" name="email" value="<?=$this->session->userdata['email']?>" />
			<table class="">
				<colgroup width="20%"></colgroup>
				<colgroup width="756px"></colgroup>
				<thead>
				</thead>
				<tbody>					
					<!--tr>
						<th><b>* </b>
							<label for="input-tit">제목</label>
						</th>
						<td>
							<input id="input-tit" name="title" class="form-control" type="text" value="">
						</td>
					</tr -->
					<tr>
						<th><b>* </b>내용</th>
						<td>
							<textarea name="content" class="form-control icon-textarea" rows="3" placeholder="*무비에 대한 문의사항은 고객센터를 이용해주세요."></textarea>
						</td>
					</tr>
					<tr>
						<th>
							<label for="input-attach">사진 등록</label>
						</th>
						<td>
							<input type="file" name="userfile" id="input-attach" class="input-file styled-input">
						</td>
					</tr>
				</tbody>
			</table>
		</form>
		<a class="btn btn-danger mr5 mb10" href="javascript:insert_reply('review');">리뷰등록</a>
	</div>