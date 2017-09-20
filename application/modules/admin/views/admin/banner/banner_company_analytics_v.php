<style type="text/css">
</style>
<link href='http://fonts.googleapis.com/css?family=Roboto:400,300,300italic,400italic,700' rel='stylesheet' type='text/css'>
<script src="http://code.jquery.com/jquery-2.1.1.min.js"></script>
<script>
	$(document).ready(function (){
		$(".pagination a").click(function (event){
		  	event.stopPropagation ();
			//alert($(this).data("num"));
			$("#page").val($(this).data("num"));
			$("#page_form").submit();

		});

		$("#form_post").click(function (event){
			$("#page_form").submit();
		});
		$("#reset").click(function (event){
			$("#page").val("1");
			$("#sfl").val("");
			$("#stx").val("");
			$("#sdate").val("");
			$("#edate").val("");
			$("#page_form").submit();
		});

		$("#form_excel").click(function (event){
			var params = $("#page_form" ).serialize();
			var url = "/admin/page/banner_company_analytics/excel/?excel=true";

			$("#page_form").attr("target","_blink");
			$("#page_form").attr("action",url);
			$("#page_form").submit();
			$("#page_form").attr("target","");
			$("#page_form").attr("action","");
		});

		


		$.datepicker.regional['ko'] = {
                         closeText: '닫기',
                         prevText: '이전달',
                         nextText: '다음달',
                         currentText: '오늘',
                         monthNames: ['1월','2월','3월','4월','5월','6월',
                         '7월','8월','9월','10월','11월','12월'],
                         monthNamesShort: ['1월','2월','3월','4월','5월','6월',
                         '7월','8월','9월','10월','11월','12월'],
                         dayNames: ['일','월','화','수','목','금','토'],
                         dayNamesShort: ['일','월','화','수','목','금','토'],
                         dayNamesMin: ['일','월','화','수','목','금','토'],
               //          weekHeader: 'Wk',
                         dateFormat: 'yy-mm-dd',
                         firstDay: 0,
                         isRTL: false,
                         duration:200,
                         showMonthAfterYear: true,
                         autoSize: false, //오토리사이즈(body등 상위태그의 설정에 따른다)
                         changeMonth: true, //월변경가능
                         changeYear: true, //년변경가능
                         yearRange: '1990:2020',
                         yearSuffix: '년'
                    };
                    $.datepicker.setDefaults($.datepicker.regional['ko']);
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
			<form action="" id="page_form" method="get" >
				<input type="hidden" name="page"	id="page"	value="<?=(isset($input['page']) && $input['page']>=1)? $input['page'] : 1 ?>" />
				<select name="sfl" id="sfl">
					<option value="pname" <? if(isset($input['sfl']) && $input['sfl']=="pname") echo "selected";?>>상품명</option>
					<option value="mname" <? if(isset($input['sfl']) && $input['sfl']=="mname") echo "selected";?> >고객명</option>
				</select>
				<!-- input type="hidden" name="sfl" 	id="sfl" 	value="<?=(isset($input['sfl']) )? $input['sfl'] : "" ?>" / -->
				<input type="text" name="stx" 	id="stx" 	value="<?=(isset($input['stx']) )? $input['stx'] : "" ?>" placeholder="상품명, 고객명" />
				<input type="text" name="sdate" 	id="sdate" 	value="<?=(isset($input['sdate']) )? $input['sdate'] : "" ?>" placeholder="시작일" />
				<input type="text" name="edate" 	id="edate" 	value="<?=(isset($input['edate']) )? $input['edate'] : "" ?>" placeholder="종료일" />

				<input type="hidden" name="type" 	id="type" 	value="<?=(isset($input['type']) )? $input['type'] : "" ?>" />
				<input type="hidden" name="cid" 	id="type" 	value="<?=(isset($input['cid']) )? $input['cid'] : "" ?>" />

				<a href="javascript:;" id="reset" class="btn">리셋</a>
				<a href="javascript:;" id="form_post" class="btn">검색</a>
				<a href="javascript:;" id="form_excel" class="btn">엑셀</a>

				
			</form>
			<div class="panel panel-primary plain toggle panelMove panelClose panelRefresh" id="jst_9">
                                <!-- Start .panel -->
                                <div class="panel-heading">
									<h4 class="panel-title">배너 클릭 총 <?=$acnt?> 클릭</h4>
                                <div class="panel-controls"><a href="#" class="panel-refresh"><i class="im-spinner12"></i></a><a href="#" class="toggle panel-minimize"><i class="im-minus"></i></a><a href="#" class="panel-close"><i class="im-close"></i></a></div></div>
                                <div class="panel-body">
									<? foreach($alists as $key => $val) : $tct = ($val['cnt'] / $acnt) *100;  $tct = floor($tct); ?>
                                    <div class="pie-charts">
										<div><?=$val['cnt']?></div>
                                        <div class="easy-pie-chart-teal easyPieChart" data-percent="<?=$tct?>" style="width: 100px; height: 100px; line-height: 100px;"><?=$tct?>%<canvas width="100" height="100"></canvas></div>
                                        <div class="label"><?=$val['pname']?></div>
                                    </div>
									<? endforeach; ?>
                                </div>
                            </div>


			<div class="table-responsive" style="overflow: hidden; width: 100%; height: auto;">
				<table class="table">
				<thead>
					<th>id</th>
					<th>배너명</th>
					<th>상품명</th>
					<!--th>회원번호</th -->

					<th>ip</th>
					<th>브라우저</th>
					<th>최종방문시간</th>
					<!--th>총 횟수</th -->

				</thead>
				<tbody>
						<?php
						//pop set
						$atts = array(
								'width'       => 938,
								'height'      => 600,
								'scrollbars'  => 'no',
								'status'      => 'no',
								'resizable'   => 'no',
								'screenx'     => 0,
								'screeny'     => 0,
								'window_name' => '_blank'
						);

						//page set
						$page = $input["page"];
						$pagelist = $input["pagelist"];
						if(is_numeric($page) == false) $page = 1;
						if($page < 0) $page = 1;

						$total_count = $total_count - (($page -1) * $pagelist);



						foreach ($lists as $key => $val):
						?>
							<tr>
								<td><? echo $total_count--;?></td>
								<td><?=$val['alt']?></td>
								<td><?=$val['pname']?></td>
								<!-- td><? echo ($val['memberId'])? $val['memberId'] : "비회원";?></td -->

								<td><?=$val['ip']?></td>
								<td><?=$val['bro']?></td>
								<td><?=$val['createDatetime']?></td>
								<!--td><?=$val['cnt']?></td -->
								
							</tr>
							<? endforeach;  ?>
					</tbody>
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
