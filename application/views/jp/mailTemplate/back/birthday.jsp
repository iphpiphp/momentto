<jsp:directive.page contentType="text/html;charset=UTF-8" />
<jsp:directive.include file="/WEB-INF/views/common/lib/taglib.jsp"/>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>고객님의 생일을 축하합니다! | theDays</title>
</head>
<body style="margin:0; padding:0;">
	
	
<!-- start email -->
<table border="0" cellpadding="0" cellspacing="0" width="100%" bgcolor="#ffffff" style="border-collapse:collapse;">
	<tbody>
		<tr>
			<td height="69"></td>
		</tr>
		<tr>
			<td align="center">
				<!-- start rounding box -->
				<table border="0" cellpadding="0" cellspacing="0" width="724" style="border-collapse:collapse">
					<tr>
						<td>
							<!-- start round top -->
							<table border="0" cellpadding="0" cellspacing="0" width="100%" style="border-collapse:collapse">
								<tr>
									<td>
										<table border="0" cellpadding="0" cellspacing="0" width="100%" style="border-collapse:collapse">
											<tr>
												<td height="6"></td>
											</tr>
											<tr>
												<td>
													<table border="0" cellpadding="0" cellspacing="0" width="100%" style="border-collapse:collapse">
														<tr>
															<td width="20">
																<img src="${baseUrl}/resources/images/email/bir_border_round_tl.gif" alt=" " width="26" height="83" border="0" style="display: block;" />
															</td>
															<td>
																<table border="0" cellpadding="0" cellspacing="0" width="100%" style="border-collapse:collapse">
																	<tr>
																		<td height="2" bgcolor="#b0b0b0"></td>
																	</tr>
																	<tr>
																		<td align="left" height="50">
																			<table border="0" cellpadding="0" cellspacing="0" width="100%" style="border-collapse:collapse">
																				<tr>
																					<td height="13"></td>
																					<td>
																						<jsp:include page="_menu.jsp"/>	
																					</td>
																				</tr>
																			</table>
																		</td>
																	</tr>
																	<tr>
																		<td height="1" bgcolor="#77cdd9"></td>
																	</tr>
																	<tr>
																		<td height="30" bgcolor="#77cdd9"></td>
																	</tr>
																</table>
															</td>
														</tr>
													</table>
												</td>
											</tr>
										</table>
									</td>
									<td width="103">
										<a href="${baseUrl}" target="_blank" title="The Days">
											<img src="${baseUrl}/resources/images/email/bir_theDays_logo.gif" alt="The Days" width="103" height="89" border="0" style="display: block;" />
										</a>
									</td>
								</tr>
							</table><!-- end round top -->
						</td>
					</tr>
					<tr>
						<td>
							<!-- start box body -->
							<table border="0" cellpadding="0" cellspacing="0" width="100%" style="border-collapse:collapse">
								<tr>
									<td align="center">
										<!-- start content core -->
										<table border="0" cellpadding="0" cellspacing="0" width="100%" style="border-collapse:collapse">
											<tr>
												<td align="center" bgcolor="#77cdd9">
													<img src="${baseUrl}/resources/images/email/birthday_tit.gif" alt="오늘은 즐겁고 행복한 일만 가득하길 바랍니다. 축하합니다!" border="0" style="display:block;" />
												</td>
											</tr>
											<tr>
												<td align="center" bgcolor="#77cdd9" style="color:#ffffff; line-height: 22px; font-family: dotum; font-size:12px;">
													<b>${member.name } 고객님</b>의 생일을 진심으로 축하드리며,<br /> 
													회원님을 위해 더데이즈가 작지만 소중한 선물을 준비했습니다.<br />
													<span style="color:#fef964; line-height: 22px; font-family: dotum; font-size:12px;">(마이페이지에서 쿠폰을 확인해보세요)</span>
												</td>
											</tr>
											<tr>
												<td>
													<img src="${baseUrl}/resources/images/email/bir_coupon.gif" alt="thedays 10% 할인쿠폰" border="0" style="display:block;" />
												</td>
											</tr>
											<tr>
												<td align="center" bgcolor="#5c524b" style="padding-bottom:43px;">
													<a href="${baseUrl}" target="_blank">
														<img src="${baseUrl}/resources/images/email/bir_btn_go_thedays.gif" alt="더데이즈 바로가기" border="0" style="display:block;" />
													</a>
												</td>
											</tr>
										</table>
										<!-- end content core -->
									</td>
								</tr>
							</table><!-- end box body -->
						</td>
					</tr>
					<jsp:include page="_footer.jsp"/>		
				</table><!-- end rounding box -->
			</td>
		</tr>
		<tr>
			<td height="130"></td>
		</tr>	
	</tbody>
</table>
<!-- end email -->


</body>
</html>