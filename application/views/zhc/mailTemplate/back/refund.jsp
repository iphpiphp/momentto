<jsp:directive.page contentType="text/html;charset=UTF-8" />
<jsp:directive.include file="/WEB-INF/views/common/lib/taglib.jsp"/>

<c:set var="payment" value="${order.payment }" />
<c:set var="isMember" value="${not empty order.memberId }" />


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>주문 무비 취소/환불 안내드립니다 | theDays</title>
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
																<img src="${baseUrl}/resources/images/email/ord_border_round_tl.gif" alt=" " width="26" height="83" border="0" style="display: block;" />
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
																		<td height="1" bgcolor="#d1c8c4"></td>
																	</tr>
																	<tr>
																		<td height="30" bgcolor="#d1c8c4"></td>
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
											<img src="${baseUrl}/resources/images/email/ord_theDays_logo.gif" alt="The Days" width="103" height="89" border="0" style="display: block;" />
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
									<td align="center" bgcolor="#d1c8c4" style="padding: 0 35px; border-left: 2px solid #d1c8c4; border-right: 2px solid #d1c8c4;">
										<!-- start content core -->
										<table border="0" cellpadding="0" cellspacing="0" width="622" style="border-collapse:collapse">
											<tr>
												<td align="center">
													<img src="${baseUrl}/resources/images/email/cancel_tit.gif" alt="주문 무비 취소/환불 안내드립니다. 취소/환불해 드렸습니다" border="0" style="display:block;" />
												</td>
											</tr>
											<tr>
												<td>
													<!-- start order content table -->
													<table border="0" cellpadding="0" cellspacing="0" width="100%" style="border-collapse:collapse; color:#818181; font-family: dotum; font-size: 12px;">
														<tr>
															<td>
																<img src="${baseUrl}/resources/images/email/cancel_header.gif" alt="고객님을 만족시켜드릴 수 있도록 노력하는 더데이즈가 되겠습니다." border="0" style="display:block;" />
															</td>
														</tr>
														<tr>
															<td align="center" bgcolor="#4d4947" style="padding-top:23px; padding-bottom:28px; color:#cac9c8; line-height:20px;">
																<b>${order.memberName }<c:if test="${!isMember }">(비회원)</c:if> 고객님</b>! 주문시 사용하신 적립금은 취소/환불시 그대로 반환되며,<br />
																할인쿠폰을 사용하여 주문하신 후 취소/환불하신 경우 쿠폰은 재사용 하실 수 없습니다.
															</td>
														</tr>
														<tr>
															<td>
																<!-- start order list table -->
																<table bgcolor="#ffffff" border="0" cellpadding="0" cellspacing="0" width="100%" style="border-collapse:collapse; color:#818181; font-family:dotum; font-size:12px;">
																	<tr>
																		<td align="center" width="231" height="41" style="color:#4c4c4c; font-family: dotum; vertical-align:middle;">
																			<b>상품명</b>
																		</td>
																		<td align="center" width="152" style="border-left:1px solid #e2e2e2; color:#4c4c4c; font-family: dotum; vertical-align:middle;">
																			<b>주문번호</b>
																		</td>
																		<td align="center" width="66" style="border-left:1px solid #e2e2e2; color:#4c4c4c; font-family: dotum; vertical-align:middle;">
																			<b>수량</b>
																		</td>
																		<td align="center" width="170" style="border-left:1px solid #e2e2e2; color:#4c4c4c; font-family: dotum; vertical-align:middle;">
																			<b>상품가격</b>
																		</td>
																	</tr>
																	<c:forEach items="${order.orderItems }" var="item">
																	<tr>
																		<td align="left" style="padding-left:26px; padding-top:18px; padding-bottom:13px; border-top:1px solid #e2e2e2;">
																			<!-- start prd item -->
																			<table border="0" cellpadding="0" cellspacing="0" width="100%" style="border-collapse:collapse;">
																				<tr>
																					<td>
																						<a href="#">
																							<img src="${baseUrl}${item.imagePath}/${item.imageSFile}" alt="" border="0" style="display:block; border:1px solid #c5c5c4;" />
																						</a>
																					</td>
																				</tr>
																				<tr>
																					<td style="padding-top:6px;">
																						<a href="#" target="_blank" style="color:#818181; font-family:dotum; font-size:11px; text-decoration:none;">${item.name }</a>
																					</td>
																				</tr>
																			</table>
																			<!-- end prd item -->
																		</td>
																		<td align="center" style="font-family:dotum; font-size:11px; border-top:1px solid #e2e2e2; border-left:1px solid #e2e2e2; vertical-align:middle;">
																			${order.id }
																		</td>
																		<td align="center" style="font-family:dotum; font-size:11px; border-top:1px solid #e2e2e2; border-left:1px solid #e2e2e2; vertical-align:middle;">
																			1
																		</td>
																		<td align="center" style="font-family:dotum; font-size:11px; border-top:1px solid #e2e2e2; border-left:1px solid #e2e2e2; vertical-align:middle;">
																			<fmt:formatNumber type="currency" currencySymbol="￦" value="${item.price }" />
																		</td>
																	</tr>
																	</c:forEach>
																</table>
																<!-- end order list table -->
															</td>
														</tr>
														<tr>
															<td bgcolor="#ededed" style="padding: 18px;">
																<!-- start payment info -->
																<table bgcolor="#ffffff" border="0" cellpadding="0" cellspacing="0" width="100%" style="border-collapse:collapse; color:#818181; font-size:12px;">
																	<tr>
																		<td align="left" width="140" height="38" style="padding-left:26px; vertical-align:middle;"><b>총 주문금액</b></td>
																		<td align="left" width="420" style="vertical-align:middle;"><fmt:formatNumber value="${payment.price }" />원</td>
																	</tr>
																	
																	<c:if test="${isMember }">
																		<tr>
																			<td align="left" width="140" height="38" style="padding-left:26px; border-top:1px solid #ededed; vertical-align:middle;"><b>쿠폰할인</b></td>
																			<td align="left" width="420"style="border-top:1px solid #ededed; vertical-align:middle;">
																				<c:forEach items="${order.memberCoupons }" var="coupon">
																					-<fmt:formatNumber value="${coupon.applyPrice }" />원<br/>
																				</c:forEach>
																			</td>
																		</tr>
																		<tr>
																			<td align="left" width="140" height="38" style="padding-left:26px; border-top:1px solid #ededed; vertical-align:middle;"><b>적립금 사용</b></td>
																			<td align="left" width="420"style="border-top:1px solid #ededed; vertical-align:middle;"><fmt:formatNumber value="${order.useSavedMoney }" />원</td>
																		</tr>
																	</c:if>
																	
																	<tr>
																		<td align="left" width="140" height="38" style="padding-left:26px; border-top:1px solid #ededed; vertical-align:middle;"><b>결제방법</b></td>
																		<td align="left" width="420"style="border-top:1px solid #ededed; vertical-align:middle;">
																			<c:if test="${order.payment.payMethod == 'card' }">
																				카드 결제
																			</c:if>
																			<c:if test="${order.payment.payMethod == 'vbank' }">
																				무통장 입금 (주문 후 7일이내)
																			</c:if>
																			<c:if test="${order.payment.payMethod == 'directbank' }">
																				실시간 계좌이체
																			</c:if>
																			<c:if test="${order.payment.payMethod == 'hpp' }">
																				모바일 결제
																			</c:if>
																			<c:if test="${order.payment.payMethod == 'point' }">
																				적립금 구매
																			</c:if>
																		</td>
																	</tr>
																	<tr>
																		<td align="left" width="140" height="38" style="padding-left:26px; border-top:1px solid #ededed; vertical-align:middle;"><b>최종결제금액</b></td>
																		<td align="left" width="420"style="border-top:1px solid #ededed; color:#e54b63; vertical-align:middle;"><b><fmt:formatNumber value="${payment.price }" />원</b></td>
																	</tr>
																	<tr>
																		<td align="left" bgcolor="#f9f9f9" width="140" height="38" style="padding-left:26px; border-top:1px solid #ededed; vertical-align:middle;"><b>취소/환불 요청일</b></td>
																		<td align="left" bgcolor="#f9f9f9" width="420"style="border-top:1px solid #ededed; vertical-align:middle;"><fmt:formatDate value="${order.refundApplyDatetime }" pattern="yyyy년 MM월 dd일" /> </td>
																	</tr>
																	<tr>
																		<td align="left" bgcolor="#f9f9f9" width="140" height="38" style="padding-left:26px; border-top:1px solid #ededed; vertical-align:middle;"><b>취소/환불 처리일</b></td>
																		<td align="left" bgcolor="#f9f9f9" width="420"style="border-top:1px solid #ededed; vertical-align:middle;">
																			<fmt:formatDate value="${refundApply.confirmDatetime }" pattern="yyyy년 MM월 dd일" />
																		</td>
																	</tr>
																	<tr>
																		<td align="left" bgcolor="#f9f9f9" width="140" height="38" style="padding-left:26px; border-top:1px solid #ededed; vertical-align:middle;"><b>처리내용</b></td>
																		<td align="left" bgcolor="#f9f9f9" width="420"style="border-top:1px solid #ededed; vertical-align:middle;">
																			<!-- 현금환불(예금주 : 신현숙 / 입금되는데 1~2일 소요됩니다.) -->${refund.message }
																		</td>
																	</tr>
																</table>
																<!-- end payment info -->
															</td>
														</tr>
													</table>
													<!-- end order content table -->
												</td>
											</tr>
											<tr>
												<td height="35">&nbsp;</td>
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
										<img src="${baseUrl}/resources/images/email/ord_border_round_bl.gif" alt=" " width="20" height="20" border="0" style="display: block;" />
									</td>
									<td>
										<table border="0" cellpadding="0" cellspacing="0" width="100%" style="border-collapse:collapse">
											<tr>
												<td height="18" bgcolor="#d1c8c4"></td>
											</tr>
											<tr>
												<td height="2" bgcolor="#d1c8c4">
													<img src="${baseUrl}/resources/images/email/blank.gif" alt=" " width="1" height="2" border="0" style="display: block;" />
												</td>
											</tr>
										</table>
									</td>
									<td width="20" height="20">
										<img src="${baseUrl}/resources/images/email/ord_border_round_br.gif" alt=" " width="20" height="20" border="0" style="display: block;" />
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