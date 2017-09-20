<style type="text/css"></style>
<script>
	$(document).ready(function() {
		
		
		onCate();
		$(".pagination a").click(function(event) {
			event.stopPropagation();
			//alert($(this).data("num"));
			$("#page").val($(this).data("num"));
			$("#page_form").submit();

		});

		$("#form_post").click(function(event) {
			$("#page_form").submit();
		});
		$("#reset").click(function(event) {
			$("#page").val("1");
			$("#sfl").val("");
			$("#stx").val("");
			$("#sdate").val("");
			$("#edate").val("");
			$("#page_form").submit();
		});
		$.datepicker.regional['en'] = {
			//         closeText: '닫기',
			//        prevText: '이전달',
			//         nextText: '다음달',
			//         currentText: '오늘',
			//         monthNames: ['1월','2월','3월','4월','5월','6월','7월','8월','9월','10월','11월','12월'],
			//         monthNamesShort: ['1월','2월','3월','4월','5월','6월', '7월','8월','9월','10월','11월','12월'],
			//         dayNames: ['일','월','화','수','목','금','토'],
			//         dayNamesShort: ['일','월','화','수','목','금','토'],
			//         dayNamesMin: ['일','월','화','수','목','금','토'],
			//         weekHeader: 'Wk',
			dateFormat: 'yy-mm-dd',
			firstDay: 0,
			isRTL: false,
			duration: 200,
			showMonthAfterYear: true,
			autoSize: true, //오토리사이즈(body등 상위태그의 설정에 따른다)
			changeMonth: true, //월변경가능
			changeYear: true, //년변경가능
			yearRange: '1990:2020',
			yearSuffix: 'Year'
		};
		$.datepicker.setDefaults($.datepicker.regional['en']);
		$("#sdate").datepicker();
		$("#edate").datepicker();
		
		$(".saveBtn").click(function(){
			if(form_auto_complet()) $(".form_post").submit();
		});
	});
	
	function form_auto_complet(){
		$("#imageText").val($("#imageText1").val()+"/"+$("#imageText2").val()); //img
		$("#movieText").val($("#movieText1").val()+"/"+$("#movieText2").val()); //movie
		$("#runtime").val($("#runtime1").val()+":"+$("#runtime2").val()); //runtime
		return true;
	}

	function onCate(){
		$.ajax({
		type: "POST",
		data: {},
		cache: false,
		async: false,
		url: "/api/catelist",
		dataType: "json",
		success: function(data){
			var html = "";
			$.each( data.catelist, function( key, value ) {
			  	//alert( key + ": " + value );
				$("#categoryId").append("<option value="+value['id']+">"+value['name']+"</option>");	
			});
		}
		});    
	}

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
					<h1 class="member-id text-center">Product Add</h1>
					<p class="pull-left"><a class="btn btn-inverse" href="/admin/product/product_list"><i class="icon-list-alt icon-white"></i> product list</a></p>
					<div>
						<p class="pull-right"><a class="btn btn-primary saveBtn" href="#"><i class="icon-ok icon-white"></i>save</a></p>
					</div>
				</header>
			</div>
			<!-- .header-wrap -->
			
			<form method="post" accept-charset="utf-8" enctype="multipart/form-data" action="/admin/product/product_crud/add" class="form_post">
				<input type="hidden" name="resolutionId" value="1" />
			<div class="register-item">
				<section class="ri-cat">					
					<table class="table table-bordered table-condensed">
						<tbody>
							<tr>
								<th>categori</th>
								<td class="form-inline">
									
									<select id="categoryId" name="categoryId" class="input-large">										
									</select>								
								</td>								
							</tr>
						</tbody>
					</table>
				</section>
				<!-- .ri-cat -->

				<section class="ri-basic-info">
					<h3>product info</h3>
					<table class="table table-bordered table-condensed">
						<tbody>
							<tr>
								<th>product name</th>
								<td class="form-inline">
									<input id="productName" name="productName" class="span5" type="text" value="" />
								</td>
								<th>product add date</th>
								<td class="form-inline"><span class="span2 uneditable-input" id="createDatetime"></span></td>
							</tr>
							<tr>
								<th>run time</th>
								<td class="form-inline">
									<input type="text" class="span1 text-right" id="runtime1" maxlength="2"><span> min&nbsp;&nbsp;</span>
									<input type="text" class="span1 text-right" id="runtime2" maxlength="2"><span> sec</span>
									<input id="runtime" name="runtime" type="hidden" value="" />
								</td>
							</tr>
							<tr>
								<th>image text</th>
								<td>
									<div class="form-inline vertical-control">
										<label for="">picture</label>
										<span>
										:&nbsp;&nbsp;width <input type="text" class="span1 text-right" id="imageText1"> 장&nbsp;&nbsp;/&nbsp;&nbsp;height
										<input type="text" class="span1 text-right" id="imageText2" maxlength="4"> 장
										<input id="imageText" name="imageText" type="hidden" value=""/></span>
									</div>
									<div class="form-inline vertical-control">
										<label for="">movie</label>
										<span>
										:&nbsp;&nbsp;width <input type="text" class="span1 text-right" id="movieText1"> 개&nbsp;&nbsp;/&nbsp;&nbsp;height
										<input type="text" class="span1 text-right" id="movieText2" maxlength="4"> 개
										<input id="movieText" name="movieText" type="hidden" value=""/></span>
									</div>
								</td>
								<th>음악</th>
								<td>
									<div class="form-inline vertical-control">
										<label for="">원본음악 </label>
										<span> : </span>
										<input id="originalMusic" name="originalMusic" class="span4" type="text" value="" />
									</div>
									<div class="form-inline vertical-control">
										<label for="">추천음악 </label>
										<span> : </span>
										<input id="recommendMusic" name="recommendMusic" class="span4" type="text" value="" />
									</div>
								</td>
							</tr>
							<tr>
								<th>영상 설명</th>
								<td colspan="3" class="tag-td">
									<div class="editor">
										<textarea name="exText" id="exText" style="width: 100%; height: 400px;"></textarea>
										<script>CKEDITOR.replace( 'exText' );</script>
									</div>
								</td>
							</tr>

						</tbody>
					</table>
				</section>
				<!-- .ri-basic-info -->

				<section class="ri-price-info">
					<h3>price info</h3>
					<table class="ri-pi-table table table-bordered table-condensed">
						<thead>
							<tr>
								<th>price</th>								
								<th>event price</th>								
							</tr>
						</thead>
						<tbody>
							<tr>
								<td class="form-inline">
									<input id="price" name="price" class="span3 text-right" type="text" value="" />
								</td>								
								<td class="evt-price-td form-inline">
									<input id="eventPrice" name="eventPrice" class="span3 text-right" type="text" value="0" />
								</td>								
							</tr>
						</tbody>
					</table>
				</section>
				<!-- .ri-price-info -->
				
				<section class="ri-set-info">
					<h3>config</h3>
					<table class="ri-pi-table table table-bordered table-condensed">
						<thead>
							<tr>
								<th>public/private</th>								
								<th>Seq</th>								
							</tr>
						</thead>
						<tbody>
							<tr>
								<td class="form-inline">									
									<select name="isDisplay">
										<option value="true" >public</option>
										<option value="flase" selected>private</option>
									</select>
								</td>								
								<td class="evt-price-td form-inline">
									<input id="sort" name="sort" class="span3 text-right" type="text" value="0" />
								</td>								
							</tr>
						</tbody>
					</table>
				</section>
				<!-- .ri-price-info -->

				<section class="ri-reg-visual">
					<h3>영상/이미지 등록</h3>
					<table class="table table-bordered table-condensed">
						<tbody>
							<tr>
								<th>영상 등록(VimeoId)</th>
								<td class="form-inline">
									<input id="movieVimeoId" name="movieVimeoId" type="text" value="" />
								</td>
								
							</tr>
							<tr>
								<th>프리셋</th>
								<td colspan="3">
									<input id="preset1" name="preset1" class="span12" type="text" value="" />
								</td>
							</tr>
							<tr>
								<th>이미지 등록</th>
								<td colspan="3" class="reg-img-td">
									<table class="reg-img-table table">
										<thead>
											<tr>
												<th>사이즈</th>
												<th>상품 대표 (L)</th>												
												<th>상품 슬라이드 썸네일 (N) multi select</th>
												
											</tr>
										</thead>
										<tbody id="contents">
											<tr>
												<th>대표이미지</th>
												<td>
													<input type="file" name="uploadMainImage1[]" >
												</td>												
												<td>
													<input type="file" name="uploadMainImage3[]" multiple>
												</td>
												
											</tr>
										</tbody>		
									</table>
									<!-- .reg-img-table -->
								</td>
							</tr>
						</tbody>
					</table>
				</section>
				<!-- .ri-reg-visual -->

				<footer class="ri-footer text-center">
					<button type="button" class="btn btn-primary btn-large input-large saveBtn"><i class="icon-ok icon-white"></i> 등록하기</button>
				</footer>

			</div>
			<!-- .register-item -->
			</form>

		</div>
		<!-- /container -->

	</div>
	<!-- End .content-wrapper -->
	<div class="clearfix"></div>
</div>
<!-- End #content -->
