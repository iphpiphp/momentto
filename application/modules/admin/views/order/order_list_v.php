<style type="text/css"></style>
<script>
	$(document).ready(function() {
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
			$("#page_form > div > input:checkbox").prop("checked",false);
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
	});

</script>
<!-- Start #right-sidebar -->
<!-- Start #content -->
<div id="content">


	<!-- Start .content-wrapper -->
	<div class="content-wrapper">


		<!-- Start .content-inner -->
		<div class="content-inner">
			<form action="" id="page_form" method="get">
				<input type="hidden" name="page" id="page" value="<?=(isset($input['page']) && $input['page']>=1)? $input['page'] : 1 ?>" />
				<select name="sfl" id="sfl">
					<option value="name" <? if(isset($input[ 'sfl']) && $input[ 'sfl']=="name" ) echo "selected";?>>ProductName</option>
				</select>
				<!-- input type="hidden" name="sfl" 	id="sfl" 	value="<?=(isset($input['sfl']) )? $input['sfl'] : "" ?>" / -->
				<input type="text" name="stx" id="stx" value="<?=(isset($input['stx']) )? $input['stx'] : " " ?>" placeholder="productName, memberName" />
				<input type="text" name="sdate" id="sdate" value="<?=(isset($input['sdate']) )? $input['sdate'] : " " ?>" placeholder="startDate" />
				<input type="text" name="edate" id="edate" value="<?=(isset($input['edate']) )? $input['edate'] : " " ?>" placeholder="endDate" />

				<input type="hidden" name="type" id="type" value="<?=(isset($input['type']) )? $input['type'] : " " ?>" />

				<div class="">

					<label for="guest">비회원 주문</label><input type="checkbox" id="guest" name="guest" <? if(isset($input[ 'guest'])) echo "checked"; ?> />
					<label for="open_market">오픈마켓</label> <input type="checkbox" id="open_market" name="open_market" <? if(isset($input[ 'open_market'])) echo "checked"; ?> />
				</div>
				<div>
					<a href="javascript:;" id="reset" class="btn btn-success">reForm</a>
					<a href="javascript:;" id="form_post" class="btn btn-info">serach</a>
				</div>
			</form>
			<div class="table-responsive" style="overflow: hidden; width: 100%; height: auto;">
				<table class="table">
					<thead>
						<th>num</th>
						<th>order Number</th>
						<th>price</th>
						<th>device</th>
						<th>productName</th>
						<th>memberName</th>
						<th>memberEmail</th>
						<th>orderDate</th>
					</thead>
					<?
						$page = $input["page"];
						$pagelist = $input["pagelist"];
						if(is_numeric($page) == false) $page = 1;
						if($page < 0) $page = 1;

						$total_count = $total_count - (($page -1) * $pagelist);
					
						foreach ($lists as $key => $val): 
					?>
						<tr>
							<td>
								<? echo $total_count--;?>
							</td>
							<td>
								<?=$val['id']?>
							</td>

							<td>
								<?=number_format($val['price'])?>
							</td>

							<td>
								<?=$val['device']?>
							</td>
							<td>
								<?=$val['productName']?>
							</td>
							<td>
								<?=$val['memberName']?>
							</td>
							<td>
								<?=$val['memberEmail']?>
							</td>
							<td>
								<?=$val['createDatetime']?>
							</td>

						</tr>
						<? endforeach;  ?>
				</table>
			</div>
			<!-- Start .row -->
			<div class="page-nation">
				<ul class="pagination">
					<?=$page_nation?>
				</ul>
			</div>

		</div>
	</div>
	<!-- End .content-wrapper -->
	<div class="clearfix"></div>
</div>
<!-- End #content -->
