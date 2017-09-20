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
																${emailInquiry.member.name}
															</td>
														</tr>
														<tr>
															<td align="left" width="79" height="38" style="padding-left: 23px; border: 1px solid #e6e6e6; font-family: dotum;">
																문의유형
															</td>
															<td align="left" height="38" style="padding:0 17px; border: 1px solid #e6e6e6; font-family: dotum;">
																<c:choose>
																	<c:when test="${emailInquiry.type == '01' }">회원서비스</c:when>
																	<c:when test="${emailInquiry.type == '02' }">비밀번호 찾기 서비스</c:when>
																	<c:when test="${emailInquiry.type == '03' }">아이디 찾기 서비스</c:when>
																	<c:when test="${emailInquiry.type == '04' }">결제서비스</c:when>
																	<c:when test="${emailInquiry.type == '05' }">마이페이지</c:when>
																	<c:when test="${emailInquiry.type == '06' }">사진/영상 업로드</c:when>
																	<c:when test="${emailInquiry.type == '07' }">이벤트</c:when>
																	<c:when test="${emailInquiry.type == '99' }">기타</c:when>
																</c:choose>
															</td>
														</tr>
														<tr>
															<td align="left" width="79" height="38" style="padding-left: 23px; border: 1px solid #e6e6e6; font-family: dotum;">
																등록일
															</td>
															<td align="left" height="38" style="padding:0 17px; border: 1px solid #e6e6e6; font-family: dotum;">
																<fmt:formatDate value="${emailInquiry.createDatetime}" pattern="yyyy.MM.dd" />
															</td>
														</tr>
														<tr>
															<td align="left" width="79" height="38" style="padding-left: 23px; border: 1px solid #e6e6e6; font-family: dotum;">
																제목
															</td>
															<td align="left" height="38" style="padding:0 17px; border: 1px solid #e6e6e6; font-family: dotum;">
																${emailInquiry.title}
															</td>
														</tr>
														<tr>
															<td align="left" width="79" style="padding-top: 11px; padding-bottom: 11px; padding-left: 23px; border: 1px solid #e6e6e6; font-family: dotum;">
																내용
															</td>
															<td align="left" style="padding:11px 17px; border: 1px solid #e6e6e6; line-height: 22px; font-family: dotum;">
																${fn:replace(emailInquiry.content, cn, '<br/>') }
															</td>
														</tr>
														<tr>
															<td align="left" width="79" style="padding-top: 11px; padding-bottom: 11px; padding-left: 23px; border: 1px solid #e6e6e6; font-family: dotum;">
																첨부파일
															</td>
															<td align="left" style="padding:11px 17px; border: 1px solid #e6e6e6; line-height: 22px; font-family: dotum;">
																<a href="${baseUrl }/resources/uploads/emailQa/${emailInquiry.fileName}">${emailInquiry.fileName}</a>
															</td>
														</tr>
													</table>
													<!-- end qa content table -->
												</td>
											</tr>
											<tr>
												<td align="center" style="padding-top:32px; padding-bottom: 51px;">
													<a href="${baseUrl}/myPage" target="_blank">
														<%-- <img src="${baseUrl}/resources/images/email/btn_mypage.gif" alt="마이페이지에서 확인하기" border="0" style="display:block;" /> --%>
														<a href="${baseUrl }/admin">관리자 로그인</a>
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

