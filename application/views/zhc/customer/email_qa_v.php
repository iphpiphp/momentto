<!-- #container -->
<div id="container" class="clearfix">

	<!-- 페이지 시작-->

	<div class="row side_page w1140">
		<!-- side -->
		<?=aside_left_customer() ?>
		<!-- content -->
		<div id="ct" class="col-sm-10 col-xs-12 pl50 pl0-xs">
			<h1 class="sub_hd"> 1:1 이메일 문의 하기 </h1>
			
			
			
			<div id="content-main" class="eqa-content">
				<p class="hd-txt">
					문의하신 사항에 대한 답변은 입력해 주신 이메일과 마이페이지에서 확인하실 수 있으며,기재하신 정보는 회원님의 문의처리를 위한 용도로만 이용됩니다.
				</p>

				<section id="eqa-form" class="form-frame">
					<form action="/customer/email_post/" method="post" id="form_post" enctype="multipart/form-data">
						<table id="eqa-form-table" class="member-info-form form-table">

							<th>이름</th>
							<td>
							<input type="text" name="username" id="username"  value="<?=$this -> session -> userdata['username'] ?>" />
							</td>
							</tr>
							<tr>
								<th>이메일 주소</th>
								<td>
								<input type="text" id="email-id" name="email" class="email-domain styled-input" value="" />
								<!-- span>@</span>
								<input type="text" id="email2" class="email-domain styled-input" value="" / --><!-- select class="select-email styled-select" id="emails">
								<option>선택</option>
								<option>chol.com</option>
								<option>dreamwiz.com</option>
								<option>empal.com</option>
								<option>freechal.com</option>
								<option>gmail.com</option>
								<option>hanafos.com</option>
								<option>hanmail.net</option>
								<option>hanmir.com</option>
								<option>hotmail.com</option>
								<option>korea.com</option>
								<option>nate.com</option>
								<option>naver.com</option>
								<option>netian.com</option>
								<option>paran.com</option>
								<option>sayclub.com</option>
								<option>yahoo.co.kr</option>
								<option>yahoo.com</option>
								<option>직접입력</option>
								</select -->
								<p class="guide">
									* 답변 받으실 수 있는 수신 가능한 이메일 주소를 입력해 주세요.
								</p></td>
							</tr>

							<th><label for="input-tit">제목</label></th>
							<td>
							<input id="input-tit" name="title" class="input-tit styled-input" type="text" value=""/>
							</td>
							</tr>
							<tr>
								<th><label for="txtarea-content">내용</label></th>
								<td>								<textarea id="txtarea-content" rows=8 name="content" class="txtarea-content styled-input"></textarea></td>
							</tr>
							<tr>
								<th><label for="input-attach">첨부파일</label></th>
								<td>
								<input type="file" name="userfile" id="input-attach" class="input-file styled-input" />
								<span class="guide">* 5Mbyte 미만의 파일만 허용</span></td>
							</tr>
						</table><!-- #eqa-form-table -->
					</form>

					<div id="btn_footer">
						<a href="#" class="btn btn-danger mr5 mb10" item="email" id="saveBtn"><span class="in">문의</span></a>
						<a href="#" class="btn btn-white mr5 mb10" id="cancelBtn"><span class="in">취소</span></a>
					</div>

				</section><!-- .form-frame -->

			</div><!-- #content-main -->



</div>
</div>
</div>
