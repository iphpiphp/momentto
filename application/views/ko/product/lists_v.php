<div id="container" class="clearfix">

<!-- 페이지 시작-->

<div id="indexTab"></div>
<div id="index">

<section id="sect2" class="row pb20">
		<h2 class="sr-only">item</h2>
		<!-- 카테고리탭 -->
		<ul class="category_tab clearfix">
			<li><a class="keyword_tg collapsed" href="#keyword"  data-toggle="collapse" item="keyword" id="key_head">키워드 <i class="glyphicon glyphicon-menu-up"></i></a></li>
			<li><a href="javascript:;" <?=(!$this->input->get('cate_id',true) || $this->input->get('cate_id',true) == 'all')? 'class="on"':'' ?> item="all" id="cate_head">ALL</a></li>
			<li><a href="javascript:;" item="1" <?=($this->input->get('cate_id',true) == 1)? 'class="on"':'' ?>>BABY&amp;KIDS</a></li>
			<li><a href="javascript:;" item="2" <?=($this->input->get('cate_id',true) == 2)? 'class="on"':'' ?>>LOVE</a></li>
			<li><a href="javascript:;" item="3" <?=($this->input->get('cate_id',true) == 3)? 'class="on"':'' ?>>WEDDING</a></li>
			<li><a href="javascript:;" item="4" <?=($this->input->get('cate_id',true) == 4)? 'class="on"':'' ?>>ANNIVERSARY</a></li>
			<li><a href="javascript:;" item="5" <?=($this->input->get('cate_id',true) == 5)? 'class="on"':'' ?>>TRAVEL</a></li>
			<li><a href="javascript:;" item="6" <?=($this->input->get('cate_id',true) == 6)? 'class="on"':'' ?>>D-CARD</a></li>
			<li><a href="javascript:;" item="7" <?=($this->input->get('cate_id',true) == 7)? 'class="on"':'' ?>>BUSINESS</a></li>
		</ul>
		
		<!-- 키워드 -->
		<div id="keyword" class="collapse">
			<i></i>
			<ul class="row">
				<? foreach($keyword_list as $key => $val): ?>
					<li class="col-sm-3 col-xs-6"><a href="#" class="keyword_tag" item="<?=$val['tag_name']?>"><?=$val['tag_name']?></a></li>							
				<? endforeach; ?>
				<!-- li class="col-sm-3 col-xs-6"><a href="">고급스러운</a></li -->				
			</ul>
		</div>
		<!-- 아이템 목록 -->
		<div class="lst">
			<ul class="row main_list">
				<? $i=1; foreach($product_list as $key => $val): ?>
				<li class="col-sm-6 col-xs-12 itm">					
					<div>
						<a href="/product/detail/<?=$val['id']?>">
							<!-- img class="img-responsive" src="<?=PATH2?>_temp/tmb.jpg" alt="" -->
							<img class="img-responsive" src="<?=IMG_O_PATH.$val['imagePath']."/".$val['imageLFile']?>" alt="" item="<?=$val['movieVimeoId']?>">
						</a>
						<div class="cnt_wrp">
							<h4><a href="<?=Base_url()?>product/detail/<?=$val['id']?>"><?=$val['name']?></a></h4>
							<div class="summary">
								<? // $val['keyword']?>
								<?// print_r($val['keywords']); ?>
							</div>
							<div class="meta clearfix">
								<div class="pull-left">
									<? foreach($val['keywords'] as $key2 => $val2): ?>
									<span class="label bg_red"><?=$val2['name']?></span>
									<? endforeach; ?>
								</div>
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
				
			</ul>
		</div>
	</section>
	
</div>
</div>

<?
if($this->input->get('cate_id',true)){
?>
	<script>$(document).ready(function () { cate_choise(); });</script>
	
<?	
}
?>
<script>
	$(document).ready(function () {

//카테고리 클릭
	$(".category_tab > li > a").click(function(){	
		
		var cate = $(this).attr("item");
		var keyword = "";
		var i = $("#i").val();
		
		if(cate != 'keyword'){
			$(".category_tab > li > a").attr("class","");
			$(this).attr("class","on");
			$("#key_head").attr("class","keyword_tg collapsed");
			$(".main_list > li").remove();
			
			
			//$('body, html').animate({ scrollTop: $("#indexTab").offset().top }, 1000); 
			$(".main_list ").load("/main/main_list_html/"+cate+"/"+i+"/"+keyword);
			
			
		}		
	});
	//키워드 클릭
	$(".keyword_tag").click(function(){	
		
		var cate = 'all';
		var keyword = $(this).attr("item");
		var i = 1;
		
		$(".category_tab > li > a").attr("class","");
		$("#cate_head").attr("class","on");
		$("#key_head").attr("class","keyword_tg collapsed");
			
		$(".main_list > li").remove();
		//$('body, html').animate({ scrollTop: $("#indexTab").offset().top }, 1000);
		$(".main_list ").load("/main/main_list_html/"+cate+"/"+i+"/"+keyword);
		
	});
});
function cate_choise(){
	//$(".category_tab > li > a ")
}
</script>
