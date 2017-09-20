<?
$time = time();
$offerPeriod = "";
$offerPeriod = date("Ymd") . "-" . date("Ymd", strtotime("+30 Day", $time));
//판매 후 30일 제품 보장
$vbank_date = date("Ymd", strtotime("+1 Week", $time));
//무통장 입금 결제일은 오늘 부터 1주일

$payViewType = "popup";
//overlay popup  : 모바일은 new
if ($this -> agent -> is_mobile())	$payViewType = "new";

$mail_id = "";
$mail_domain = "";
$readonly = "";
$disabled = "";
$display = "";
$is_login = "F";
if ($this -> session -> userdata['email'] != '') {
	$mail = explode('@', $this -> session -> userdata['email']);
	$mail_id = $mail[0];
	$mail_domain = $mail[1];
	$readonly = "readonly";
	$disabled = "disabled";
	$display = "display: none";
	$is_login = "T";
}

$use_point = use_point(); //사용자의 포인트 가져옴

# 테스트 URL
$pp_url = PP_URL;
$recv_mail = PP_RECV_MAIL;

# 상용 URL
// $pp_url = "https://www.paypal.com/cgi-bin/webscr";
// $recv_mail = "info@xxxxxx.com";

$exchange = exchange("USD");
$invoice = "P_".urlencode(uniqid(time()));

?>			
<form action="<?=$pp_url?>" method="post" id="paypal_pay">
	
	<div class="rounding-outline ">
			
					
			<p>Email</p>
			<div class="form-group">
					<div class="select_email">						
						<input type="text" id="email1" class="form-control" value="<?=$mail_id ?>" <?=$readonly?>> <span>@</span> 									
						<input type="text" id="email2" class="form-control" value="<?=$mail_domain ?>" <?=$readonly?>>
					</div>
			</div>
			
			<p>Product Name </p>
			<div class="form-group">
				<div class="form-group">
						<span class="" style="padding-left:30px; font-size: 20px;"><?=$product['0']['name'] ?></span>
				</div>
			</div>
			
			<p>Price </p>
			<div class="form-group">
				<div class="form-group">
						<span class="" style="padding-left:30px; font-size: 20px;">$ <?=$total_price_usd?></span>
				</div>
			</div>
			
			
			
	</div>
	
	
	
	<input type="hidden" name="cmd" value="_xclick">
	<input type="hidden" name="invoice" value="<?=$invoice?>">
	<input type="hidden" name="business" value="<?=$recv_mail?>">
	<input type="hidden" name="notify_url" value="<?=Base_url()?>order/paypal_noti_m">
	<input type="hidden" name="return" value="<?=Base_url()?>order/paypal_return_m?invoice=<?=$invoice?>">	
	<input type="hidden" name="cancel_return" value="<?=Base_url()?>order/paypal_cancel" />
	
	<input type="hidden" name="item_number" value="<?=$product['0']['id'] ?>"><br />
	<input type="hidden" name="item_name" value="<?=$product['0']['name'] ?>">
	<input type="hidden" name="amount" value="<?=$total_price_usd;?>"><br />
	<input type="hidden" name="charset" value="UTF-8">
	<input type="hidden" name="currency_code" value="USD">
	<input type="hidden" name="quantity" value="1" />	
	<input type="hidden" name="email" id="buyeremail" />
	
	
			
	<!-- input type="image" name="submit" border="0" src="https://www.paypalobjects.com/en_US/i/btn/btn_buynow_LG.gif" alt="PayPal - The safer, easier way to pay online" -->
</form>

<form id="hide_form" method="post">		
	<input type="hidden" id="total_price" 	name="total_price" 	value="<?=$total_price?>"  />
	<input type="hidden" id="username" 		name="username" 	value="<?=$this -> session -> userdata['username']?>" />
	<input type="hidden" id="hide_email" 	name="email" 		value="" />
	<input type="hidden" id="password" 		name="password" 	value="" />
	<input type="hidden" name="invoice" 	value="<?=$invoice?>">
</form>
<!-- 
	 
paypal_business = "info-facilitator@myemail.co.kr"
paypal_cmd = "_xclick"
success_url = "http://mysite.com/paypal/successTransfer.asp"
cancel_url = "http://mysite.com/paypal/cancelTransfer.asp"
notify_url = "http://mysite.com/paypal/notify.asp"
paypal_charset = "UTF-8"
paypal_currencyType = "USD"
paypal_amount = "50"
paypal_itemName = "꽃바구니"
paypal_quantity = "5"
paypal_itemNumber = "12345"


<body onload="init_orderid();">
    <form method="POST" name="paypal_form">
        <input type="text" name="business" value="<%=paypal_business%>" />
        <input type="text" name="cmd" value="<%=paypal_cmd%>" />
        <input type="text" name="return" value="<%=success_url%>" />
        <input type="text" name="notify_url" value="<%=notify_url%>" />
        <input type="text" name="cancel_return" value="<%=cancel_url%>" />
        <input type="text" name="quantity" value="<%=paypal_quantity%>" />
        <input type="text" name="item_name" value="<%=paypal_itemName%>" />
        <input type="text" name="item_number" value="<%=paypal_itemNumber%>" />
        <input type="text" name="amount" value="<%=paypal_amount%>" />
        <input type="text" name="charset" value="<%=paypal_charset%>" />
        <input type="text" name="currency_type" value="<%=paypal_currencyType%>" />
    </form>
</body -->
