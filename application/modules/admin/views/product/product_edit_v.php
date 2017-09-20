<style type="text/css"></style>
<?php

if($product['runtime'])   $runtime = explode(":",$product['runtime']);
if($product['imageText']) $imageText = explode("/",$product['imageText']);
if($product['movieText']) $movieText = explode("/",$product['movieText']);

if(!isset($runtime[0]))$runtime[0] = 0;	
if(!isset($runtime[1]))$runtime[1] = 0;

if(!isset($imageText[0]))$imageText[0] = 0;	
if(!isset($imageText[1]))$imageText[1] = 0;
if(!isset($movieText[0]))$movieText[0] = 0;
if(!isset($movieText[1]))$movieText[1] = 0;

?>
<script>
	$(document).ready(function() {
		onCate();
		$(".pagination a").click(function(event) {
			event.stopPropagation();			
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
		
		$(".saveBtn").click(function(){			
			form_auto_complet();			
			$(".form_post").submit();
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
	});
	
	function form_auto_complet(){
		$("#runtime").val($("#runtime1").val()+":"+$("#runtime2").val()); //runtime
		$("#imageText").val($("#imageText1").val()+"/"+$("#imageText2").val()); //img
		$("#movieText").val($("#movieText1").val()+"/"+$("#movieText2").val()); //movie
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
			var sel = "<?=$product['categoryId']?>";			
			$.each( data.catelist, function( key, value ) {
				if(value['id'] == sel) {
					$("#categoryId").append("<option value="+value['id']+" selected>"+value['name']+"</option>");
				} else {
			   		$("#categoryId").append("<option value="+value['id']+">"+value['name']+"</option>");
			   	}
				
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
					<h1 class="member-id text-center">Product Modify</h1>
					<p class="pull-left"><a class="btn btn-info" href="/admin/product/product_list"><i class="icon-list-alt icon-white"></i> product list</a></p>
					<div>
						<p class="pull-right"><a class="btn btn-primary saveBtn" href="#"><i class="icon-ok icon-white"></i>save</a></p>
					</div>
				</header>
			</div>
			<!-- .header-wrap -->
			
			
			<form method="post" accept-charset="utf-8" enctype="multipart/form-data" action="/admin/product/product_crud/modify" class="form_post">
			<input id="productId" name="productId" class="span5" type="hidden" value="<?=$product['id']?>" />
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
									<input id="productName" name="name" class="span5" type="text" value="<?=$product['name']?>" />
								</td>
								<th>product add date</th>
								<td class="form-inline"><span class="span2 uneditable-input" id="createDatetime"><?=$product['createDatetime']?></span></td>
							</tr>
							<tr>
								<th>run time</th>
								<td class="form-inline">
									<input type="text" class="span1 text-right" id="runtime1" maxlength="2" value="<?=$runtime[0]?>" ><span> min&nbsp;&nbsp;</span>
									<input type="text" class="span1 text-right" id="runtime2" maxlength="2" value="<?=$runtime[1]?>" ><span> sec</span>
									<input id="runtime" name="runtime" type="hidden" value="<?=$product['runtime']?>" />
								</td>
							</tr>
							<tr>
								<th>image text</th>
								<td>
									<div class="form-inline vertical-control">
										<label for="">picture</label>
										<span>
										:&nbsp;&nbsp;width <input type="text" class="span1 text-right" id="imageText1" value="<?=$imageText[0]?>"> 장&nbsp;&nbsp;/&nbsp;&nbsp;height
										<input type="text" class="span1 text-right" id="imageText2" maxlength="4" value="<?=$imageText[1]?>"> 장
										<input id="imageText" name="imageText" type="hidden" value="<?=$product['imageText']?>"/></span>
									</div>
									<div class="form-inline vertical-control">
										<label for="">movie</label>
										<span>
										:&nbsp;&nbsp;width <input type="text" class="span1 text-right" id="movieText1" value="<?=$movieText[1]?>"> 개&nbsp;&nbsp;/&nbsp;&nbsp;height
										<input type="text" class="span1 text-right" id="movieText2" maxlength="4" value="<?=$movieText[1]?>"> 개
										<input id="movieText" name="movieText" type="hidden" value="<?=$product['movieText']?>"/></span>
									</div>
								</td>
								<th>음악</th>
								<td>
									<div class="form-inline vertical-control">
										<label for="">원본음악 </label>
										<span> : </span>
										<input id="originalMusic" name="originalMusic" class="span4" type="text" value="<?=$product['originalMusic']?>" />
									</div>
									<div class="form-inline vertical-control">
										<label for="">추천음악 </label>
										<span> : </span>
										<input id="recommendMusic" name="recommendMusic" class="span4" type="text" value="<?=$product['recommendMusic']?>" />
									</div>
								</td>
							</tr>
							<tr>
								<th>영상 설명</th>
								<td colspan="3" class="tag-td">
									<div class="editor">
										<textarea name="exText" id="exText" style="width: 100%; height: 400px;"><?=$product['exText']?></textarea>
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
								<th>usd</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td class="form-inline">
									<input id="price" name="price" class="span3 text-right" type="text" value="<?=$product['price']?>" />
								</td>								
								<td class="evt-price-td form-inline">
									<input id="eventPrice" name="eventPrice" class="span3 text-right" type="text" value="<?=$product['eventPrice']?>" />
								</td>
								<td class="evt-price-td form-inline">
									<input id="usd" name="usd" class="span3 text-right" type="text" value="<?=$product['usd']?>" />
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
								<th>sort</th>

							</tr>
						</thead>
						<tbody>
							<tr>
								<td class="form-inline">									
									<select name="isDisplay">
										<option value="true"  <?if($product['isDisplay']) echo 'selected'; ?> >public</option>
										<option value="flase" <?if(!$product['isDisplay']) echo 'selected'; ?>>private</option>
									</select>
								</td>								
								<td class="evt-price-td form-inline">
									<input id="sort" name="sort" class="span3 text-right" type="text" value="<?=$product['sort']?>" />
								</td>								

							</tr>
						</tbody>
					</table>
				</section>
				<!-- .ri-price-info -->

				<section class="ri-set-info">
					<h3>Keyword Info</h3>
					<table class="ri-pi-table table table-bordered table-condensed">
						<thead>
							<tr>
								<th>Mobile Keyword</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td class="evt-price-td form-inline">
									<input id="keyword" name="keyword" class="span3 text-right" type="text" value="<?=$product['keyword']?>" />
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
									<input id="movieVimeoId" name="movieVimeoId" type="text" value="<?=$product['movieVimeoId']?>" />
								</td>
								
							</tr>
							<tr>
								<th>프리셋</th>
								<td colspan="3">
									<input id="preset" name="preset1" class="span12" type="text" value="<?=$product['preset1']?>" />
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
													<input type="file" name="uploadMainImage1[]" ><br />
													<a href="<?=S3_IMG_PATH?>/resources/uploads/product/image/<?=$product['imageLFile']?>" target="_self"><?=$product['imageLFile']?></a>
												</td>												
												<td>													
													<input type="file" name="uploadMainImage3[]" multiple><br>
													<? foreach($product_content as $key => $val) : ?>
													<a href="<?=S3_IMG_PATH?>/resources/uploads/product/image/<?=$val['imageLFile']?>" target="_self"><?=$val['imageLFile']?></a><br />
													<? endforeach;?>
																										
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
					<button type="button" class="btn btn-primary btn-large input-large saveBtn"><i class="icon-ok icon-white"></i> 수정하기</button>
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
