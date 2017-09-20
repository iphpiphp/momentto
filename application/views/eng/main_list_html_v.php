<?
$exchange = exchange("USD"); 
foreach($product_list as $key => $val): ?>
	<li class="col-sm-6 col-xs-12 itm">					
					<div>
						<a href="/product/detail/<?=$val['id']?>">
							<!-- img class="img-responsive" src="<?=PATH2?>_temp/tmb.jpg" alt="" -->
							<img class="img-responsive" src="<?=IMG_O_PATH.$val['imagePath']."/".$val['imageLFile']?>" alt="" item="<?=$val['movieVimeoId']?>">
						</a>
						<div class="cnt_wrp">
							<h4><a href="<?=Base_url()?>product/detail/<?=$val['id']?>"><?=$val['name']?></a></h4>
							<div class="summary">
								<?=$val['keyword']?>
							</div>
							<div class="meta clearfix">
								<div class="pull-left"><span class="label bg_red"><?=$val['tag']?></span></div>
								<div class="pull-right">
									<? 
													$price = $val['price'];
													if($val['eventPrice']>0)$price =$val['eventPrice']; 
													$USD = $val['usd'];
									?>
									<strong class="color_red">￦<?=number_format($price)?>  /  ($<?=$USD?>)</strong>
								</div>
							</div>
						</div>
					</div>
				</li>
<? endforeach; ?>

<script>
	$(".vimeo_play").hover(		
		function (){
		//alert($(this).attr("id"));
		//alert($(this).children("div").attr("class"));
		var num = $(this).children("img").attr("item");
		//$(this).children("div").load("http://player.vimeo.com/video/"+num+"?api=1&player_id="+num+"&color=e54b63");
		var html = '<iframe class="_vimeoPlayer" style="width:100%; max-width:738px; height:186px"  id="vimeoPlayer" src="http://player.vimeo.com/video/'+num+'?api=1&player_id='+num+'&color=e54b63&autoplay=1" width="" height="" frameborder="0"  webkitAllowFullScreen mozallowfullscreen allowFullScreen >';		
		$(this).children("div").html(html);
		$(this).children("img").hide();
	},
		function (){
			$(this).children("img").show();
			$(this).children("div").html("");
		}
	);
</script>