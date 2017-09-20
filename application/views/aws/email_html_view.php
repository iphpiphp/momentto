<?
$domain = base_url();
$image_path  = base_url();
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no">
    <title> :: The days :: </title>
    <!--[if IE]><meta http-equiv="x-ua-compatible" content="IE=9" /><![endif]-->

	<style>
		
		
		
	</style>
</head>
<body >
<div class="content" style="padding: 0; margin: 0;">
	<div class="rap" style="position: relative;   margin: 0 auto;   width: 740px;">
		<table style="width: 740px;height: 30; border-collapse: collapse;">
			<tbody class="ctd" style="text-align: center;">
				<tr><td style="height:30px;"></td></tr>
				<tr><td style="margin:00; padding:0px; border-collapse:collapse;"><a href="http://thedays.co.kr/" target="_blank"><img src="<?=$image_path?>/images/Layer-3.png" /></a></td></tr>
				<tr><td>
						<a href="http://thedays.co.kr/product/products/1?v=&limit=100" target="_blank"><img src="<?=$image_path?>/images/cate1.png" /></a>
						<a href="http://thedays.co.kr/product/products/2?v=&limit=100" target="_blank"><img src="<?=$image_path?>/images/cate2.png" /></a>
						<a href="http://thedays.co.kr/product/products/3?v=&limit=100" target="_blank"><img src="<?=$image_path?>/images/cate3.png" /></a>
						<a href="http://thedays.co.kr/product/products/4?v=&limit=100" target="_blank"><img src="<?=$image_path?>/images/cate4.png" /></a>
						<a href="http://thedays.co.kr/product/products/5?v=&limit=100" target="_blank"><img src="<?=$image_path?>/images/cate5.png" /></a>
						<a href="http://thedays.co.kr/product/products/6?v=&limit=100" target="_blank"><img src="<?=$image_path?>/images/cate6.png" /></a>
						<a href="http://thedays.co.kr/product/products/7?v=&limit=100" target="_blank"><img src="<?=$image_path?>/images/cate7.png" /></a>
					</td></tr>
				<tr><td style="height:15px;"></td></tr>
			</tbody>
		</table>

		<? 
			
			if(isset($serialize_s1)){
			$i = 0;	
			foreach($serialize_s1 as $key => $val):
			$product = product_info($val); //아이디가 들어있다
			//print_r($db_data);
			$price = $product['price'];
			if($product['eventPrice'] > 0) $price = $product['eventPrice'];
		?>
		<div class="block2" style='width: 740px; height: 46px; background:url(<?=$image_path?>/images/Layer-7.png); margin-top: 20px; margin-bottom: 20px; color: #fff; font-size: 20px; font-weight: bold; font-family: Malgun Gothic;'><div class="block_text" style='margin-left: 78px; padding-top: 9px;'><?=$s1_title[$i]?></div></div>
			<table class="section tsection" style="border: solid 1px #cecece; width: 370px; border-collapse: collapse; ">
				<tbody class="ctd" style="text-align: center;">
					<!-- 1-->
					<tr><td style="margin:0; padding:0px; border-collapse:collapse;"><a href="http://thedays.co.kr/product/<?=$val?>" target="_blank"><img src="https://d359hdvta3sq5o.cloudfront.net/resources/uploads/product/image/<?=$product['imageLFile']?>" /></a></td></tr>
					<tr><td style="padding-top: 25px;"><span style="color:#9b9b9b; font-size:24px; font-weight: bold; font-family: Malgun Gothic;">
						[<?=$product['cateName']?>]</span> <span style="font-size:24px; font-weight: bold; font-family: Malgun Gothic;"><?=$product['name']?></span></td></tr>
					<tr>
						<td class="boder_bottom_dotted" style='border-bottom: #cecece; border-bottom-style: dotted; border-bottom-width:1px; padding-bottom: 30px;'>
							<span style=" font-family: Malgun Gothic; color: #d22e48; font-size:22px; font-weight: bold;">￦<?=number_format($price)?></span> <span style="font-family: Malgun Gothic; font-size:13.9px; font-weight: bold;">($<?=$product['usd']?>)</span></td>
					</tr>
					<tr>
						<td class="boder_bottom_solid" style='border-bottom: #cecece; border-bottom-style: solid;  border-bottom-width:1px; text-align:left; padding: 20px;'>
							<div style="float:left; margin-top: 3px;"><img src="<?=$image_path?>/images/ss1.png" /></div>
							<div style="float:left; font-size:15px; font-weight: bold; font-family: Malgun Gothic; margin-left:15px; "><?=nl2br($s1_text[$i])?></div>
						</td>
					</tr>
					<tr><td height="70"><a href="http://thedays.co.kr/product/<?=$val?>" target="_blank" style="text-decoration:none"><img src="<?=$image_path?>/images/dd1.png" /></a></td></tr>
				</tbody>
			</table>
		<? $i++; endforeach; }?>
		
		
		<? if(isset($s2_title) && isset($serialize_s2)): ?>
			<div class="block2" style='width: 740px; height: 46px; background:url(<?=$image_path?>/images/Layer-5.png); margin-top: 20px; margin-bottom: 20px; color: #fff;font-weight: bold; font-family: Malgun Gothic; font-size:20px;'><div class="block_text" style='margin-left: 78px; padding-top: 9px;'><?=$s2_title?></div></div>
			<table class="tsection" style='width: 370px;  border-collapse: collapse;'>
				<tbody class="ctd" style='text-align: center;'>
					<tr>
		
		<? 
			$i = 0;
			$j = 0;
			foreach($serialize_s2 as $key => $val):
			$product = product_info($val); //아이디가 들어있다
			//print_r($db_data);
			$price = $product['price'];
			$j++;
			if($product['eventPrice'] > 0) $price = $product['eventPrice'];
		?>		
					
					<td valign="top" style="<?if(($j % 2) == 0) echo "padding-left:32px;"; ?>">
						<table class="section_2" style='border: solid 1px #cecece; width:335px;  border-collapse: collapse;'>
							<tbody class="ctd" style='text-align: center;'>
								<tr><td style="margin:0; padding:0px; border-collapse:collapse;"><a href="http://thedays.co.kr/product/<?=$val?>" target="_blank"><img width=350px src="https://d359hdvta3sq5o.cloudfront.net/resources/uploads/product/image/<?=$product['imageLFile']?>" /></a></td></tr>
								<tr><td style="padding-top: 25px;"><span style="font-family: Malgun Gothic; font-size:24px; font-weight: bold;"><?=$product['name']?></span></td></tr>
								<tr><td class="boder_bottom_dotted" style='border-bottom: #cecece; border-bottom-style: dotted; border-bottom-width:1px; padding-bottom: 40px; '> <span style="font-family: Malgun Gothic; color: #d22e48; font-size:22px; font-weight: bold;">￦<?=number_format($price)?></span> <span style="font-family: Malgun Gothic; font-size:13.9px; font-weight: bold;">($<?=$product['usd']?>)</span></td></tr>
								<tr>
									<td class="boder_bottom_solid" style='border-bottom: #cecece;  border-bottom-style: solid;  border-bottom-width:1px; text-align:left; padding: 20px;'>
										<div style="float:left; margin-top: 3px;"><img src="<?=$image_path?>/images/ss1.png" /></div>
										<div style="float:left; font-size:15px; font-weight: bold; font-family: Malgun Gothic; margin-left:15px; width:279px;"><?=nl2br($s2_text[$i])?></div>
									</td>
								</tr>
								<tr><td height="70"><a href="http://thedays.co.kr/product/<?=$val?>" target="_blank" style="text-decoration:none; color:#000000;"><img src="<?=$image_path?>/images/dd1.png" /></a></td></tr>
							</tbody>
						</table>
					</td>
		<? if(($j % 2) == 0) : ?>
					</tr>
					<tr>
		<? endif; ?>					
		<? $i++; endforeach;?>
					</tr>				
			</table>
		<? endif ?>
		
		<?	
			$enkey = "thedays";		
			$this->encryption->initialize(
					array(
							'cipher' => 'aes-128',
							'mode' => 'cbc',
							'key' => $enkey
					)
			);


			$plain_text = "v2016&id=".$memberId."&cid=".$cid;
			$sig = $this->encryption->encrypt($plain_text);
			//echo urlencode($sig);
		?>
		<div class="section3" style="width: 740px; height: 240px; float: left; display: inline-block; background: url(<?=$image_path?>/images/Layer-9-2.png); margin-top: 20px; position: relative;">
			<div id="title" style='margin-left: 20px; margin-top: 15px;'><img src="<?=$image_path?>/images/email_title.png" /></div>
			<div id="coupon" style='float: left; display: inline-block; margin-left: 40px; margin-top: 16px'><img src="<?=$image_path?>/images/coupon/coupon_<?=$coupon_price?>.png" /></div>
			<div id="download" style='float: left; display: inline-block; margin-left: 33px;'><a href="<?=$domain?>awsa/auto_coupon/?signature=<?=urlencode($sig)?>" target="_blank"><img src="<?=$image_path?>/images/MergedLayers.png" /></a></div>
		</div>	
		<div class="footer" style='font-family: "나눔고딕", nanumgothic, "Nanum Gothic", sans-serif; text-align:center; padding-top: 50px;  clear: both; font-size:12px;'>
			본 메일은 발신 전용 메일로서 고객님은 현재 더데이즈 메일 수신 동의를 하신 상태입니다.<br>
			더 이상 메일 수신을 원치 않으시면 <a href="<?=$domain?>awsa/email_not?signature=<?=$sig?>" >여기를</a> 눌러 메일 서비스를 변경하시기 바랍니다.<br>
			(If you don't want this type ofinfomation or e-mail, please click here) <br>
			서울 강서구 양천로 551-24, 506호 (가양동, 한화비즈메트로 2차)(주)위드비디오 | 더데이트 고객센터 02.562.3618 | cs@thedays.co.kr<br>
			copyright(c) 2013-2014 theDays. All rights Reserved. Contact web master for more infomation.
		</div>
	</div>
</div>
</body>
</html>
