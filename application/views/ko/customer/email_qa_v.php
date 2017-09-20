<!-- #container -->
<div id="container" class="clearfix">

	<!-- 페이지 시작-->

	<!-- lnb -->
	<? customer_top_menu();?>

	<form class="form-horizontal" action="/customer/email_post/" method="post" id="form_post" enctype="multipart/form-data">
		<fieldset class="bg_f0">
			<p class="mb25 fs13 color_grey">
				문의하신 사항에 대한 답변은 입력해 주신 이메일과
				<br> 마이페이지에서 확인하실 수 있으며,기재하신 정보는
				<br> 회원님의 문의처리를 위한 용도로만 이용됩니다.
			</p>
			<div class="form-group">
				<label class="col-sm-2 control-label color_blue2">이름 *</label>
				<div class="col-sm-10">
					<input type="text" class="form-control" name="username" id="username" value="<?=$this -> session -> userdata['username'] ?>">
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label color_blue2">이메일 *</label>
				<div class="col-sm-10">
					<p class="mb10 fs12 color_grey">* 답변 받으실 수 있는 수신 가능한 이메일 주소를 입력해 주세요.</p>
					<input type="email" class="form-control" id="email-id" name="email">
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label color_blue2">제목</label>
				<div class="col-sm-10">
					<input type="text" class="form-control" id="input-tit" name="title">
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label color_blue2">내용</label>
				<div class="col-sm-10">
					<textarea class="form-control" rows="5" name="content"></textarea>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label color_blue2">사진등록</label>
				<div class="col-sm-10">
					<button type="button" class="btn bg_blue2 btn_radius w110 pull-right btn_upload">파일 선택</button>
					<p class="fs12 color_grey">*5Mbyte 미만의 파일만 허용</p>
					<div class="mt5 fs13 color_blue2 file_text">선택된 파일 없음</div>
					<input type="file" class="form-control upload" id="photo" name="userfile">
				</div>
			</div>
			<div class="row pt20">
				<div class="col-xs-6 pr6">
					<a item="email" id="saveBtn" class="btn btn-block bg_red">문의</a>
				</div>
				<div class="col-xs-6 pl6">
					<a id="cancelBtn" class="btn btn-block">취소</a>
				</div>
			</div>
		</fieldset>
	</form>

	<!-- //페이지 끝-->

</div>
<!-- //container -->
