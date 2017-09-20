<jsp:directive.page contentType="text/html;charset=UTF-8" />
<jsp:directive.include file="/WEB-INF/views/common/lib/taglib.jsp"/>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>더데이즈 회원이 되신것을 환영합니다. | theDays</title>
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
																						<!-- start category nav -->
																						<table border="0" cellpadding="0" cellspacing="0" style="border-collapse:collapse">
																							<tr>
																								<td width="38">
																									<a href="${baseUrl}/product/products/1" target="_blank">
																										<img src="${baseUrl}/resources/images/email/cat_icon_01.gif" alt="Baby&Kids" title="Baby&Kids" border="0" style="display: block;" />
																									</a>
																								</td>
																								<td width="38">
																									<a href="${baseUrl}/product/products/2" target="_blank">
																										<img src="${baseUrl}/resources/images/email/cat_icon_02.gif" alt="Propose" title="Propose" border="0" style="display: block;" />
																									</a>																								
																								</td>
																								<td width="38">
																									<a href="${baseUrl}/product/products/3" target="_blank">
																										<img src="${baseUrl}/resources/images/email/cat_icon_03.gif" alt="Wedding" title="Wedding" border="0" style="display: block;" />
																									</a>
																								</td>
																								<td width="38">
																									<a href="${baseUrl}/product/products/4" target="_blank">
																										<img src="${baseUrl}/resources/images/email/cat_icon_04.gif" alt="My Pet" title="My Pet" border="0" style="display: block;" />
																									</a>
																								</td>
																								<td width="38">
																									<a href="${baseUrl}/product/products/5" target="_blank">
																										<img src="${baseUrl}/resources/images/email/cat_icon_05.gif" alt="Travel" title="Travel" border="0" style="display: block;" />
																									</a>
																								</td>
																								<td width="38">
																									<a href="${baseUrl}/product/products/6" target="_blank">
																										<img src="${baseUrl}/resources/images/email/cat_icon_06.gif" alt="The Moment" title="The Moment" border="0" style="display: block;" />
																									</a>
																								</td>
																							</tr>
																						</table>
																						<!-- end category nav -->
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
												<td align="center" style="padding-top:23px; padding-bottom: 33px;">
													<img src="${baseUrl}/resources/images/email/joinEmail_tit.gif" alt="더데이즈 회원이 되신 것을 환영합니다." border="0" style="display:block;" />
												</td>
											</tr>
											<tr>
												<td>
													<!-- start qa content table -->
													<table border="0" cellpadding="0" cellspacing="0" width="100%" style="border-collapse:collapse; color:#818181; font-family: dotum; font-size: 12px;">
														<tr>
															<td align="center" bgcolor="#f1f1f1" style="padding:35px 0; border: 1px solid #e6e6e6; line-height: 22px; font-family: dotum;">
																<b>${member.name} 고객님</b> 환영합니다! 입력하신 아이디 <b>${member.userId}</b>으로 회원가입이 되었습니다.<br />
																이제 더데이즈에서 행복하고 즐거운 추억을 만들어 보세요!<br />
																가입 시 등록한 정보의 변경을 원하시면,<br />
																마이페이지 내 개인정보조회/변경 에서 언제든 수정하실 수 있습니다.
															</td>
														</tr>
													</table>
													<!-- end qa content table -->
												</td>
											</tr>
											<tr>
												<td align="center" style="padding-top:26px; padding-bottom:31px;">
													<a href="${baseUrl}" target="_blank">
														<img src="${baseUrl}/resources/images/email/btn_go_thedays.gif" alt="더데이즈 바로가기" border="0" />
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
								<tr>
									<td width="20" height="20">
										<img src="${baseUrl}/resources/images/email/border_round_bl.gif" alt=" " width="20" height="20" border="0" style="display: block;" />
									</td>
									<td>
										<table border="0" cellpadding="0" cellspacing="0" width="100%" style="border-collapse:collapse">
											<tr>
												<td height="18"></td>
											</tr>
											<tr>
												<td height="2" bgcolor="#b0b0b0">
													<img src="${baseUrl}/resources/images/email/blank.gif" alt=" " width="1" height="2" border="0" style="display: block;" />
												</td>
											</tr>
										</table>
									</td>
									<td width="20" height="20">
										<img src="${baseUrl}/resources/images/email/border_round_br.gif" alt=" " width="20" height="20" border="0" style="display: block;" />
									</td>
								</tr>
							</table><!-- end round bottom -->
						</td>
					</tr>
					<tr>
						<td height="18"></td>
					</tr>
					<tr>
						<td align="left" style="padding-left:24px; color:#959595; font:11px dotum; line-height:17px;">
							본 메일은 발신 전용 메일로서 고객님은 현재 더데이즈 메일 수신 동의를 하신 상태입니다.<br />
							더 이상 메일 수신을 원치 않으시면 <a href="${baseUrl}/myPage/myInfo.html" target="_blank" style="color:#959595; font:11px dotum;"><u>여기</u></a>를 눌러 메일 서비스를 변경하시기 바랍니다.<br />
							(If you dont want this type of information or e-mail, please <a href="${baseUrl}/myPage/myInfo.html" target="_blank" style="color:#959595; font:11px dotum;"><u>click here</u></a>)<br />
							135-080  서울 강남구 역삼동 683-39 202호 (주)더데이즈 | 더데이즈 고객센터 02.562.3618 | <a href="mailto:help@thedays.co.kr" target="_blank" style="color:#959595; font:11px dotum;"><u>help@thedays.co.kr</u></a><br />
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