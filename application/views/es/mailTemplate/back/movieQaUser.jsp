<jsp:directive.page contentType="text/html;charset=UTF-8" />
<jsp:directive.include file="/WEB-INF/views/common/lib/taglib.jsp"/>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>문의하신 내용과 답변입니다. | theDays</title>
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
																<img src="${baseUrl}/resources/images/email/border_round_tl.gif" alt=" " width="26" height="83" border="0" style="display: block;" />
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
																		<td height="1" bgcolor="#d8d8d8"></td>
																	</tr>
																	<tr>
																		<td height="30"></td>
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
											<img src="${baseUrl}/resources/images/email/theDays_logo.gif" alt="The Days" width="103" height="89" border="0" style="display: block;" />
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
									<td align="center" style="padding: 0 35px; border-left: 2px solid #b0b0b0; border-right: 2px solid #b0b0b0;">
										<!-- start content core -->
										<table border="0" cellpadding="0" cellspacing="0" width="622" style="border-collapse:collapse">
											<tr>
												<td align="center" style="padding-bottom: 29px;">
													<img src="${baseUrl}/resources/images/email/qaAnswer_tit.gif" alt="문의하신 내용과 답변입니다. Q&amp;A" border="0" style="display:block;" />
												</td>
											</tr>
											<tr>
												<td>
													<!-- start qa content table -->
													<table border="0" cellpadding="0" cellspacing="0" width="100%" style="border-collapse:collapse; color:#818181; font-family: dotum; font-size: 12px;">
														<tr>
															<td align="left" width="79" height="38" style="padding-left: 23px; border: 1px solid #e6e6e6; font-family: dotum;">
																이름
															</td>
															<td align="left" height="38" style="padding:0 17px; border: 1px solid #e6e6e6; font-family: dotum;">
																${movieQa.member.name}
															</td>
														</tr>
														<tr>
															<td align="left" width="79" height="38" style="padding-left: 23px; border: 1px solid #e6e6e6; font-family: dotum;">
																문의상품
															</td>
															<td align="left" height="38" style="padding:0 17px; border: 1px solid #e6e6e6; font-family: dotum;">
																<a href="${baseUrl}/product/${movieQa.productId}" target="_blank" style="color:#818181; font-family: dotum; font-size:12px;"><b>${movieQa.product.name}</b></a>
															</td>
														</tr>
														<tr>
															<td align="left" width="79" height="38" style="padding-left: 23px; border: 1px solid #e6e6e6; font-family: dotum;">
																등록일
															</td>
															<td align="left" height="38" style="padding:0 17px; border: 1px solid #e6e6e6; font-family: dotum;">
																${movieQa.createDatetime}
															</td>
														</tr>
														<tr>
															<td align="left" width="79" height="38" style="padding-left: 23px; border: 1px solid #e6e6e6; font-family: dotum;">
																제목
															</td>
															<td align="left" height="38" style="padding:0 17px; border: 1px solid #e6e6e6; font-family: dotum;">
																${movieQa.title}
															</td>
														</tr>
														<tr>
															<td align="left" width="79" style="padding-top: 11px; padding-bottom: 11px; padding-left: 23px; border: 1px solid #e6e6e6; font-family: dotum;">
																내용
															</td>
															<td align="left" style="padding:11px 17px; border: 1px solid #e6e6e6; line-height: 22px; font-family: dotum;">
																${movieQa.content}
															</td>
														</tr>
														<tr>
															<td align="left" bgcolor="#f1f1f1" width="79" style="padding-top: 11px; padding-bottom: 11px; padding-left: 23px; border: 1px solid #e6e6e6; font-family: dotum;">
																답변
															</td>
															<td align="left" bgcolor="#f1f1f1" style="padding:11px 17px 20px 17px; border: 1px solid #e6e6e6; line-height: 22px; font-family: dotum;">
																${movieQa.reply.content}
															</td>
														</tr>
													</table>
													<!-- end qa content table -->
												</td>
											</tr>
											<tr>
												<td align="center" style="padding-top:32px; padding-bottom: 37px;">
													<a href="${baseUrl}/product/${movieQa.productId}" target="_blank">
														<img src="${baseUrl}/resources/images/email/btn_confirm.gif" alt="더데이즈 웹사이트에서 확인하기" border="0" />
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