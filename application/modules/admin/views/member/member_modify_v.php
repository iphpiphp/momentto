<script>
	$(document).ready(function() {
		$(".saveBtn").click(function() {
			$(".form_post").submit();
		});
		$("#point_save").click(function() {
			if (!$("#money").val()) {
				alert("값을 꼭 넣어주셔야 합니다.");
				$("#money").focus();
				return false;
			}
			var params = $("#point_form").serialize();
			$.ajax({
				type: "POST",
				data: params,
				url: "/admin/member/ajax_point_update",
				dataType: "html",
				success: function(data) {
					document.write(data);
				}
			});
		});
	});

</script>

<!-- Start #right-sidebar -->
<!-- Start #content -->
<div id="content">
	<!-- Start .content-wrapper -->
	<div class="content-wrapper">
		<!-- Start .content-inner -->
		<div class="content-inner">
			<!-- main content -->

			<div class="header-wrap well">
				<header class="list-page-header">
					<h1 class="member-id text-center">Member Modify</h1>
					<p class="pull-left"><a class="btn btn-info" href="/admin/member/member_list"><i class="icon-list-alt icon-white"></i>Member list</a></p>
					<div>
						<p class="pull-right"><a class="btn btn-primary saveBtn" href="#"><i class="icon-ok icon-white"></i>save</a></p>
					</div>
				</header>
			</div>
			<!-- .header-wrap -->


			<form method="post" accept-charset="utf-8" enctype="multipart/form-data" action="/admin/member/member_crud/modify" class="form_post">
				<input type="hidden" name="memberId" value="<?=$member['id']?>" />
				<div>
					<table class="table">
						<tbody>
							<tr>
								<th>이름</th>
								<td>
									<input type="text" name="name" id="" class="form-control" value="<?=$member['name']?>" />
								</td>
							</tr>
							<tr>
								<th>아이디</th>
								<td>
									<input type="text" name="name" id="" class="form-control" value="<?=$member['userId']?>" disabled /><span>*아이디는 변경 불가능 합니다.</span></td>
							</tr>
							<tr>
								<th>이메일</th>
								<td>
									<input type="text" name="" id="" class="form-control" value="<?=$member['email']?>" disabled /><span>*이메일은 변경 불가능 합니다.</span></td>
							</tr>
							<tr>
								<th>패스워드</th>
								<td>
									<input type="password" name="password" class="form-control" id="" value="" /> <span>*패스워드 변경시에만 넣어주세요.</span></td>
							</tr>
							<tr>
								<th>권한수정</th>
								<td>
									<select name="auth_lv" class="form-control">
										<option value="9" <?=($member[ 'auth_lv']==9)? "selected": ""?>>슈퍼관리자</option>
										<option value="8" <?=($member[ 'auth_lv']==8)? "selected": ""?>>운영관리자</option>
										<option value="7" <?=($member[ 'auth_lv']==7)? "selected": ""?>>운영자</option>
										<option value="6" <?=($member[ 'auth_lv']==6)? "selected": ""?>>리셀러</option>
										<option value="5" <?=($member[ 'auth_lv']==5)? "selected": ""?>>매니저</option>
										<option value="4" <?=($member[ 'auth_lv']==4)? "selected": ""?>>일반회원</option>
										<option value="0" <?=($member[ 'auth_lv']==0)? "selected": ""?>>탈퇴회원</option>
									</select>
									<br />
									<span>* 관리자 페이지는 최소 운영자 이상 부터 접근 가능 합니다.</span>
								</td>
							</tr>
							<tr>
								<th>보유적립금</th>
								<td>
									<?=number_format($money)?>
								</td>
							</tr>
							<tr>
								<th>휴대번호</th>
								<td>
									<input type="text" name="mobile" id="" class="form-control" value="<?=$member['mobile']?>" />
								</td>
							</tr>
							<tr>
								<th>가입일</th>
								<td>
									<?=$member['createDatetime']?>
								</td>
							</tr>
						</tbody>
					</table>
					<div class="form-group">
						<button type="submit" class="btn btn-default form-control">save</button>
					</div>
				</div>

				<!-- .register-item -->
			</form>
			<div>
				적립금 지급하기 <span>* -금액을 넣으면 차감이 됩니다. 예:  -1000  (1000원 차감)</span>
				<form id="point_form">
					<div class="form-group">
						<input type="hidden" name="memberId" id="point_id" value="<?=$member['id']?>">
						<label class="control-label col-sm-2" for="money">적립금</label>
						<div class="col-sm-2">
							<input type="text" name="money" id="money" value="" required />
						</div>
						<label class="control-label col-sm-2" for="point_name">지급/차감 사유</label>
						<div class="col-sm-2">
							<input type="text" name="name" id="point_name" value="적립금지급" required />
						</div>

					</div>

				</form>
				<div class="form-group">
					<a id="point_save" class="btn btn-default form-control">포인트 지급</a>
				</div>
			</div>

			<section class="hr">
				<table class="table">
					<thead>
						<th>쿠폰이름</th><th>쿠폰시작일</th><th>쿠폰종료일</th><th>쿠폰사용일</th><th>쿠폰등록일</th><th><a href="" >더보기</a></th>
					</thead>
					<tbody>
						<? foreach($mycoupon['lists'] as $key => $val) : ?>
							<tr>
								<td>
									<?=$val['name']?>(<?=$val['description']?>)
								</td>
								
								<td>
									<?=($val['startDatetime'])? $val['startDatetime'] : "무제한"; ?>
								</td>
								<td>
									<?=($val['endDatetime'])? $val['endDatetime'] : "무제한"; ?>
								</td>
								<td>
									<?=($val['useDatetime'])? $val['endDatetime'] : "미사용"; ?>
								</td>
								<td>
									<?=$val['createDatetime']?>
								</td>
								<td><a class="btn">주문 상세 내역</a></td>

							</tr>
						<? endforeach; ?>
						<? if($mycoupon['total_count'] == 0) echo "<tr><td>보유 쿠폰이 없습니다.</td></tr>"; ?>
						
					</tbody>
				</table>
				<div class="page-nation">
					<ul class="pagination">
						<?=$mycoupon['page_nation']?>
					</ul>
				</div>
			</section>



		</div>
		<!-- /container -->

	</div>
	<!-- End .content-wrapper -->
	<div class="clearfix"></div>
</div>
<!-- End #content -->
