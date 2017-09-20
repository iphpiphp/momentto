<?
$use_point = use_point(); //사용자의 포인트 가져옴
?>
<form class="pay_post" action="/order/ifream_point_insert" method="post">
	<table class="form-table guest-info" summary="주문자 이름, 연락처(휴대폰), 이메일, 비밀번호 입력필드 제공" style="width:100%">
			<colgroup>
				<col style="width: 110px;">
				<col style="width: 338px;">
				<col style="width: 110px;">
				<col style="width: 339px;">
			</colgroup>
			<tbody>
				<tr class="first" >
					<th scope="row">적립금</th>
					<td><input name="point" id="point" class="styled-input" type="text" value="" ></td>
					<th>point</th>
					<td>					
						<span class="guide" id="use_point"><?=number_format($use_point)?></span>
					</td>
				</tr>			
				
			</tbody>
		</table>	
</form>
<script>
$(document).ready(function () {
	
	$( "#point" ).keyup(function() {
		
		var point = $( "#point" ).val();
		var use_point = <?=$use_point?>;
		var total_price = <?=$total_price?>;
		var tempPrice = 0;
		var tempPoint = 0;
		
		if(point){
			if(is_numeric(point) == false) {
				alert("숫자만 입력 하실 수 있습니다.");
				$("#point").val(0);
				$("#point").focus();
				return false;
			}
		}else{
			$("#point").val(0);
			return false;
		}
		
		point = parseInt(point);
		use_point = parseInt(use_point);		
		
		tempPoint = use_point - point;
		if(tempPoint <= 0) {
			alert("보유하신 적립금이 더 적습니다.");
			$("#point").val(0);
			$("#point").focus();
		}else{
			tempPrice = total_price - point;
			
			if(tempPrice < 0){
				//원복
				alert("주문 가격은 0원 미만이 될 수 없습니다.");
				$("#point").val(0);
				$("#point").focus();
				tempPrice = total_price;
				tempPoint = use_point;
			}
			
			$("#use_point").text(number_format(tempPoint));
			$("#showLastPrice").text(number_format(tempPrice));
		}		
	});
	
	$('input:radio[name=methodtype]').change(function() {
		$("#gopaymethod").val($(this).val());
	});
});
	 
</script>