<jsp:directive.page contentType="text/html;charset=UTF-8" />
<jsp:directive.include file="/WEB-INF/views/common/lib/taglib.jsp"/>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>고객님의 결혼기념일을 축하합니다! | theDays</title>
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
																<img src="${baseUrl}/resources/images/email/wed_border_round_tl.gif" alt=" " width="26" height="83" border="0" style="display: block;" />
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
																									<a href="#" target="_blank">
																										<img src="${baseUrl}/resources/images/email/cat_icon_01.gif" alt="Baby&Kids" title="Baby&Kids" border="0" style="display: block;" />
																									</a>
																								</td>
																								<td width="38">
																									<a href="#" target="_blank">
																										<img src="${baseUrl}/resources/images/email/cat_icon_02.gif" alt="Propose" title="Propose" border="0" style="display: block;" />
																									</a>																								
																								</td>
																								<td width="38">
																									<a href="#" target="_blank">
																										<img src="${baseUrl}/resources/images/email/cat_icon_03.gif" alt="Wedding" title="Wedding" border="0" style="display: block;" />
																									</a>
																								</td>
																								<td width="38">
																									<a href="#" target="_blank">
																										<img src="${baseUrl}/resources/images/email/cat_icon_04.gif" alt="My Pet" title="My Pet" border="0" style="display: block;" />
																									</a>
																								</td>
																								<td width="38">
																									<a href="#" target="_blank">
																										<img src="${baseUrl}/resources/images/email/cat_icon_05.gif" alt="Travel" title="Travel" border="0" style="display: block;" />
																									</a>
																								</td>
																								<td width="38">
																									<a href="#" target="_blank">
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
																		<td height="1" bgcolor="#fa9ead"></td>
																	</tr>
																	<tr>
																		<td height="30" bgcolor="#fa9ead"></td>
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
											<img src="${baseUrl}/resources/images/email/wed_theDays_logo.gif" alt="The Days" width="103" height="89" border="0" style="display: block;" />
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
												<td align="center" bgcolor="#fa9ead">
													<img src="${baseUrl}/resources/images/email/wedding_tit.gif" alt="오늘은 즐겁고 행복한 일만 가득하길 바랍니다. 축하합니다!" border="0" style="display:block;" />
												</td>
											</tr>
											<tr>
												<td align="center" bgcolor="#fa9ead" style="color:#ffffff; line-height: 22px; font-family: dotum; font-size:12px;">
													<b>${name } 고객님</b>의 결혼기념일을 진심으로 축하드리며,<br /> 
													회원님을 위해 더데이즈가 작지만 소중한 선물을 준비했습니다.<br />
													<span style="color:#fef964; line-height: 22px; font-family: dotum; font-size:12px;">(마이페이지에서 쿠폰을 확인해보세요)</span>
												</td>
											</tr>
											<tr>
												<td>
													<img src="${baseUrl}/resources/images/email/wed_coupon.jpg" alt="thedays 10% 할인쿠폰" border="0" style="display:block;" />
												</td>
											</tr>
											<tr>
												<td align="center" bgcolor="#fa9ead"><img src="${baseUrl}/resources/images/email/wed_bottom.jpg" usemap="#thedays_map" style="display:block;vertical-align:top;border:0;" alt="" /></td>
											</tr>
										</table>
										<map name="thedays_map">
											<area coords="258,0,468,44" href="${baseUrl }" target="_blank" alt="더데이즈 바로가기" />
										</map>
										<!-- end content core -->
									</td>
								</tr>
							</table><!-- end box body -->
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