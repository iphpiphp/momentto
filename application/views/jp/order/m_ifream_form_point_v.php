<?
$use_point = use_point(); //사용자의 포인트 가져옴
?>
	<?=order_section_pay_type()?>

		<form class="pay_post" action="/order/ifream_point_insert" method="post">
			<section>
				<h3 class="h-frm color_blue2">주문정보</h3>

				<div class="form-group">
					<label class="col-sm-2 control-label color_blue2">적립금</label>
					<div class="col-sm-10">
						<input name="point" id="point" class="form-control" type="text" value="">
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label color_blue2">보유적립금</label>
					<div class="col-sm-10">
						<span class="guide" id="use_point"><?=number_format($use_point)?></span>
					</div>
				</div>

			</section>
		</form>
		<script>
			$(document).ready(function() {

				$("#point").keyup(function() {

					var point = $("#point").val();
					var use_point = <?=$use_point?>;
					var total_price = <?=$total_price?>;
					var tempPrice = 0;
					var tempPoint = 0;

					if (point) {
						if (is_numeric(point) == false) {
							alert("숫자만 입력 하실 수 있습니다.");
							$("#point").val();
							$("#point").focus();
							return false;
						}
					} else {
						$("#point").val();
						return false;
					}

					point = parseInt(point);
					use_point = parseInt(use_point);

					tempPoint = use_point - point;
					if (tempPoint <= 0) {
						alert("보유하신 적립금이 더 적습니다.");
						$("#point").val();
						$("#point").focus();
					} else {
						tempPrice = total_price - point;

						if (tempPrice < 0) {
							//원복
							alert("주문 가격은 0원 미만이 될 수 없습니다.");
							$("#point").val();
							$("#point").focus();
							tempPrice = total_price;
							tempPoint = use_point;
						}

						$("#use_point").text(number_format(tempPoint));
						$("#showLastPrice").text(number_format(tempPrice));
					}
				});



			});

		</script>
		<?=order_section_pay_scritp() ?>
