<jsp:directive.page contentType="text/html;charset=UTF-8" />
<jsp:directive.include file="/WEB-INF/views/common/lib/taglib.jsp"/>

<c:set var="baseUrl" value="http://thedays.co.kr" />
<c:set var="product" value="${movieMaker.orderItem }" />

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>무비제작이 완료되었습니다 | theDays</title>
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
																<img src="${baseUrl}/resources/images/email/fin_border_round_tl.gif" alt=" " width="26" height="83" border="0" style="display: block;" />
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
																		<td height="1" bgcolor="#4d4947"></td>
																	</tr>
																	<tr>
																		<td height="30" bgcolor="#4d4947"></td>
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
											<img src="${baseUrl}/resources/images/email/fin_theDays_logo.gif" alt="The Days" width="103" height="89" border="0" style="display: block;" />
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
												<td align="center" bgcolor="#4d4947">
													<img src="${baseUrl}/resources/images/email/finishMovie_tit.gif" alt="행복한 추억이 담긴 무비를 소중한 사람들과 함께 하세요! 무비제작이 완료되었습니다." border="0" style="display:block;" />
												</td>
											</tr>
											<tr>
												<td align="center" bgcolor="#4d4947">
													<img src="${baseUrl}${product.imagePath}/${product.imageMFile}" border="0" style="display:block;" />
												</td>
											</tr>
											<tr>
												<td align="center" bgcolor="#4d4947" style="line-height:46px;">
													<a href="#" style="color:#fef964; font-family: dotum; font-size:14px; text-decoration:underline;"><b>${product.name }</b></a>
												</td>
											</tr>
											<tr>
												<td align="center" bgcolor="#4d4947" style="color:#ffffff; line-height: 20px; font-family: dotum; font-size:12px;">
													<b>${member.name } 고객님</b>! 고객님의 더데이즈 무비가 완료되었습니다.<br />
													<c:if test="${not empty movieMaker.order.memberId }">
														마이페이지 내 [My Movie]에서 고객님의 무비를 감상/다운로드 하실 수 있습니다.
													</c:if>
													<c:if test="${empty movieMaker.order.memberId }">
														고객센터 내 [비회원 주문/조회]에서 고객님의 무비를 감상/다운로드 하실 수 있습니다.
													</c:if>
												</td>
											</tr>
											<tr>
												<td align="center" bgcolor="#4d4947" style="padding-top:21px; padding-bottom:46px;">
													<a href="${baseUrl }/myPage" target="_blank">
														<c:if test="${not empty movieMaker.order.memberId }">
															<img src="${baseUrl}/resources/images/email/fin_btn_mypage.gif" alt="더데이즈 바로가기" border="0" style="display:block;" />
														</c:if>
														<c:if test="${empty movieMaker.order.memberId }">
															<img src="${baseUrl}/resources/images/email/fin_btn_go_thedays.gif" alt="더데이즈 바로가기" border="0" style="display:block;" />
														</c:if>
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
					
					<tr>
						<td>
							<!-- start round bottom -->
							<table border="0" cellpadding="0" cellspacing="0" width="100%" style="border-collapse:collapse">
								<tbody><tr>
									<td width="20" height="20">
										<img src="${baseUrl}/resources/images/email/fin_border_round_bl.gif" alt=" " width="20" height="20" border="0" style="display: block;">
									</td>
									<td>
										<table border="0" cellpadding="0" cellspacing="0" width="100%" style="border-collapse:collapse">
											<tbody><tr>
												<td height="18" bgcolor="#4d4947"></td>
											</tr>
											<tr>
												<td height="2" bgcolor="#4d4947">
													<img src="${baseUrl}/resources/images/email/blank.gif" alt=" " width="1" height="2" border="0" style="display: block;">
												</td>
											</tr>
										</tbody></table>
									</td>
									<td width="20" height="20">
										<img src="${baseUrl}/resources/images/email/fin_border_round_br.gif" alt=" " width="20" height="20" border="0" style="display: block;">
									</td>
								</tr>
							</tbody></table><!-- end round bottom -->
						</td>
					</tr>
					
					<tr>
						<td height="18"></td>
					</tr>
					
					<tr>
						<td align="left" style="padding-left:24px; color:#959595; font:11px dotum; line-height:17px;">
							본 메일은 발신 전용 메일로서 고객님은 현재 더데이즈 메일 수신 동의를 하신 상태입니다.<br>
							더 이상 메일 수신을 원치 않으시면 <a href="${baseUrl}/myPage/myInfo.html" target="_blank" style="color:#959595; font:11px dotum;"><u>여기</u></a>를 눌러 메일 서비스를 변경하시기 바랍니다.<br>
							(If you dont want this type of information or e-mail, please <a href="${baseUrl}/myPage/myInfo.html" target="_blank" style="color:#959595; font:11px dotum;"><u>click here</u></a>)<br>
							135-080  서울 강남구 역삼동 683-39 202호 (주)더데이즈 | 더데이즈 고객센터 02.562.3618 | <a href="mailto:help@thedays.co.kr" target="_blank" style="color:#959595; font:11px dotum;"><u>help@thedays.co.kr</u></a><br>
							copyright (c) 2013-2014 theDays. All Rights Reserved. Contact webmaster for more information.
						</td>
					</tr>
							
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