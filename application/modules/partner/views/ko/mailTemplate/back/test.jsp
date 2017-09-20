<jsp:directive.page contentType="text/html;charset=UTF-8" />
<jsp:directive.include file="/WEB-INF/views/common/lib/taglib.jsp"/>
<!DOCTYPE html>
<html lang="ko">
<head>
	<title>메일 테스트 | theDays</title>
	<link rel="stylesheet" type="text/css" href="/resources/css/member.css" />
	<script type="text/javascript">
		$(document).ready(function(){
			
		});
	</script>
	<style>
		hr { margin-top: 30px; margin-bottom: 30px; }
	</style>
</head>

<body>
	
	회원가입( ${baseUrl }/mailTemplate/joinEmail )
	<form method="post" action="joinEmail" target="_blank">
		<table>
			<tr>
				<td><input type="text" name="name" placeholder="이름" /></td>
			</tr>
			<tr>
				<td><input type="submit" /></td>
			</tr>
		</table>
	</form>
	
	<hr/>회원탈퇴( ${baseUrl }/mailTemplate/leaveMember )
	<form method="post" action="leaveMember" target="_blank">
		<table>
			<tr>
				<td><input type="text" name="name" placeholder="이름" /></td>
			</tr>
			<tr>
				<td><input type="submit" /></td>
			</tr>
		</table>
	</form>
	
	<hr/>비밀번호 안내 ( ${baseUrl }/mailTemplate/passwordInfo )
	<form method="post" action="passwordInfo" target="_blank">
		<table>
			<tr>
				<td><input type="text" name="name" placeholder="이름" /></td>
			</tr>
			<tr>
				<td><input type="text" name="password" placeholder="비밀번호" /></td>
			</tr>
			<tr>
				<td><input type="submit" /></td>
			</tr>
		</table>
	</form>
	
	<hr/>생일축하( ${baseUrl }/mailTemplate/birthday )
	<form method="post" action="birthday" target="_blank">
		<table>
			<tr>
				<td><input type="text" name="name" placeholder="이름" /></td>
			</tr>
			<tr>
				<td><input type="submit" /></td>
			</tr>
		</table>
	</form>
	
	<hr/>이메일 문의 등록(관리자) ( ${baseUrl }/mailTemplate/emailQaAdmin )
	<form method="post" action="emailQaAdmin" target="_blank">
		<table>
			<tr>
				<td><input type="text" name="id" placeholder="고유번호" /></td>
			</tr>
			<tr>
				<td><input type="submit" /></td>
			</tr>
		</table>
	</form>
	
	<hr/>이메일 문의 답변 알림(사용자) ( ${baseUrl }/mailTemplate/emailQaUser )
	<form method="post" action="emailQaUser" target="_blank">
		<table>
			<tr>
				<td><input type="text" name="id" placeholder="고유번호" /></td>
			</tr>
			<tr>
				<td><input type="submit" /></td>
			</tr>
		</table>
	</form>
	
	<hr/>무비 완료 ( ${baseUrl }/mailTemplate/finishMovie )
	<form method="post" action="finishMovie" target="_blank">
		<table>
			<tr>
				<td><input type="text" name="movieMakerId" placeholder="무비메이커 id" /></td>
			</tr>
			<tr>
				<td><input type="text" name="name" placeholder="이름" /></td>
			</tr>
			<tr>
				<td><input type="text" name="productName" placeholder="상품명" /></td>
			</tr>
			<tr>
				<td><input type="submit" /></td>
			</tr>
		</table>
	</form>
	
	<hr/>주문접수 ( ${baseUrl }/mailTemplate/order )
	<form method="post" action="order" target="_blank">
		<input type="text" name="id" placeholder="주문번호" value="1231231231" /></td>
		<input type="submit" />
	</form>
	
	<hr/>무통장 주문 ( ${baseUrl }/mailTemplate/bankDepositInfo )
	<form method="post" action="bankDepositInfo" target="_blank">
		<input type="text" name="id" placeholder="주문번호" value="1231231231" /></td>
		<input type="submit" />
	</form>
	
	<hr/>무통장 주문 입금 확인 ( ${baseUrl }/mailTemplate/bankDepositOk )
	<form method="post" action="bankDepositOk" target="_blank">
		<input type="text" name="id" placeholder="주문번호" value="1231231231" /></td>
		<input type="submit" />
	</form>
	
	<hr/>취소/환불 ( ${baseUrl }/mailTemplate/refund )
	<form method="post" action="refund" target="_blank">
		<input type="text" name=id placeholder="주문번호" value="1231231231" /></td>
		<input type="submit" />
	</form>
	
	<hr/>상품문의 알림 ( ${baseUrl }/mailTemplate/movieQaAdmin )
	<form method="post" action="movieQaAdmin" target="_blank">
		<input type="text" name=id placeholder="고유번호" value="" /></td>
		<input type="submit" />
	</form>
	
	<hr/>상품문의 답변 ( ${baseUrl }/mailTemplate/movieQaUser )
	<form method="post" action="movieQaUser" target="_blank">
		<input type="text" name=id placeholder="주문번호" value="1231231231" /></td>
		<input type="submit" />
	</form>
	
	<hr/>기념일 ( ${baseUrl }/mailTemplate/specialDay )
	<form method="post" action="specialDay" target="_blank">
		<input type="text" name="name" placeholder="name" value="조태수" /></td>
		<input type="submit" />
	</form>
	
</body>

</html>
