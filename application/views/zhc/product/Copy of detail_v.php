<script>
  window.fbAsyncInit = function() {
    FB.init({
      appId      : '777581829031957',
      xfbml      : true,
      version    : 'v2.4'
    });
  };

  (function(d, s, id){
     var js, fjs = d.getElementsByTagName(s)[0];
     if (d.getElementById(id)) {return;}
     js = d.createElement(s); js.id = id;
     js.src = "//connect.facebook.net/en_US/sdk.js";
     fjs.parentNode.insertBefore(js, fjs);
   }(document, 'script', 'facebook-jssdk'));
  window.twttr = (function(d, s, id) {
	  var js, fjs = d.getElementsByTagName(s)[0],
	    t = window.twttr || {};
	  if (d.getElementById(id)) return t;
	  js = d.createElement(s);
	  js.id = id;
	  js.src = "https://platform.twitter.com/widgets.js";
	  fjs.parentNode.insertBefore(js, fjs);
	 
	  t._e = [];
	  t.ready = function(f) {
	    t._e.push(f);
	  };
	 
	  return t;
	}(document, "script", "twitter-wjs"));
</script>
	
<div class="container">
	<!-- ul class="breadcrumb clearfix">
		<li><a href="/">Home</a> <span class="divider"></span></li>
		<li><a href="/">Product</a> <span class="divider"></span></li>
	</ul -->
	
	
	<div class="social-buttons mt25">
		<button type="button" class="btn btn-info btn-right btn-lg ml5 mb10"><?=$product['name']?></button>
		<div style="">		
						<a href="javascript:facebookshare()" class="btn btn-primary btn-alt btn-round btn-lg mr10"><i class="fa fa-facebook s24"></i></a>
						<a href="javascript:twittershare()" class="btn btn-primary btn-alt btn-round btn-lg mr10"><i class="fa fa-twitter s24"></i></a>						
		</div>						
	</div>
	<div class="row">
		<div class="col-lg-8">
			<iframe class="_vimeoPlayer" style="width:100%; max-width:738px" id="vimeoPlayer" src="http://player.vimeo.com/video/<?=$product['movieVimeoId']?>?api=1&player_id=<?=$product['movieVimeoId']?>&color=e54b63" width="738px" height="416" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen>
			</iframe>
			<!-- div id="prd-thumb-slide">
				<div class="list-wrap">
					<ul class="thumb-list" style="width: 1764px;">
						<? foreach($product_content as $key => $val): ?>
							<li>
								<a href="#"><img width="82" height="47" src="http://test.thedays.co.kr/<?=$product['imagePath']?>/<?=$val['imageNFile']?>" alt="상품 스틸컷 썸네일" /></a>
							</li>
							<? endforeach; ?>
					</ul>
				</div>
				<nav class="list-nav">
					<a href="#" class="ir arrow btn-prev">이전</a>
					<a href="#" class="ir arrow btn-next">다음</a>
				</nav>
			</div -->
		</div>
		<div class="col-lg-2">
			<button type="button" class="btn btn-dark btn-block mb10 disabled">가격 <span><?=$product['price']?></span></button>
			<a class="btn btn-danger  btn-block mb10" href="<?=Base_url()?>cart_lib/link_one_add?product_id=<?=$product['id']?>">구매</a>
			<button type="button" class="btn btn-success btn-block mb10">사진 정리폴더 다운</button>
			<button type="button" class="btn btn-success btn-block mb10">제작 의뢰 신청</button>
		</div>
	</div>
</div>
<div class="container">
	<div class="row">
		<div class="col-lg-8">
	<h2>상품 상세 설명</h2>
	
	<div class="alert alert-info">템플릿 이용 전 꼭 읽어주세요!</div>
	
	<ul>
		
		<li class=""><div >이미지 16개</div></li>
		<li class="">텍스트 4개</li>
		<li>배경음악 '.....' 변경 가능</li>
		<li>영상길이 1분 22초</li>		
	</ul>
	</div>
	</div>
</div>
<div class="container">
	<h2>연관상품 리스트</h2>
	<div id="prd-thumb-slide">
	<div class="list-wrap">
	<ul class="thumb-list" style="width: 2016px;">
		<? foreach($product_chain_list as $key => $val): ?>
			<li>
				<a href="<?=Base_url()?>product/detail/<?=$val['id']?>" style="z-index: 9999;">
					<img width="82" height="47" src="/resources/uploads/product/image/<?=$val['imageSFile']?>" />
				</a>
			</li>
			<? endforeach; ?>
	</ul>
	</div>
	<nav class="list-nav" style="font-size:25px">
			<a href="#" ><i class="fa fa-angle-left"></i></a>
			<a href="#" class=" arrow btn-next"> <i class="fa fa-angle-right"></i> </a>
		</nav>
	</div>

	
</div>


<div class="container">	
	<div class="row">
		<h2>리뷰 리스트</h2>
		<div class="col-lg-8" style="height: 300px; overflow-y: auto; overflow-x:hidden;">			
			<table class="table" style="width:100%; overflow-x:hidden;">
				<thead>
					<th class="" style="width:50px">평점</th>
					<th class="per30">제목</th>
					
					
					<th></th>
				</thead>
				<tbody>
					<? foreach($product_review_list as $key => $val): ?>
						<tr>
							<td style="width:50px"><?=$val['score']?></td>
							<td><?=$val['title']?></td>
							<!-- td><?=$val['memberName']?></td -->
							<!-- td><?=$val['createDatetime']?></td -->
							<!-- td><?=$val['viewCount']?></td -->
							<td></td>
						</tr>
						<tr class="">
							<td></td>
							<td colspan="" style="max-width: 800px">
								<div class="bs-callout bs-callout-info" >
									<div class="txt-pre"><?=$val['content']?></div>
									<? if($val['fileName']) echo '<br /><img  style="max-width: 400px" src="'.Base_url().'resources/uploads/review/'.$val["fileName"].'">'; ?>
								</div>
							</td>							
							<td></td>
						</tr>
						<? endforeach; ?>
				</tbody>
			</table>
		</div>
	</div>

	<div class="clearfix" style="padding-top:50px;"></div>
	<div class="col-lg-8">
		<form action="/product/review/insert" method="post" enctype="multipart/form-data" id="form_post_review">
			<input type="hidden" name="productId" value="<?=$product['id']?>" />
			<input type="hidden" name="uri_1" value="<?=$this->uri->segment(1)?>" />
			<input type="hidden" name="uri_2" value="<?=$this->uri->segment(2)?>" />
			<input type="hidden" name="uri_3" value="<?=$this->uri->segment(3)?>" />
			<table class="">
				<thead>
					<th></th>
					<td></td>
				</thead>
				<tbody>
					<tr>
						<th><b>* </b>평점</th>
						<td>
							<fieldset class="radio-rating-fd">
								<input id="rating5" name="score" type="radio" value="5" checked>
								<label for="rating5"><span class="rating rating-5">별점 5점</span></label>
								<input id="rating4" name="score" type="radio" value="4">
								<label for="rating4"><span class="rating rating-4">별점 4점</span></label>
								<input id="rating3" name="score" type="radio" value="3">
								<label for="rating3"><span class="rating rating-3">별점 3점</span></label>
								<input id="rating2" name="score" type="radio" value="2">
								<label for="rating2"><span class="rating rating-2">별점 2점</span></label>
								<input id="rating1" name="score" type="radio" value="1">
								<label for="rating1"><span class="rating rating-1">별점 1점</span></label>
							</fieldset>
							<!-- .radio-rating-fd -->
						</td>
					</tr>
					<tr>
						<th><b>* </b>
							<label for="input-tit">제목</label>
						</th>
						<td>
							<input id="input-tit" name="title" class="form-control" type="text" value="">
						</td>
					</tr>
					<tr>
						<th><b>* </b>내용</th>
						<td>
							<textarea name="content" class="form-control icon-textarea" rows="3" placeholder="*무비에 대한 문의사항은 고객센터를 이용해주세요."></textarea>
						</td>
					</tr>
					<tr>
						<th>
							<label for="input-attach">사진 등록</label>
						</th>
						<td>
							<input type="file" name="userfile" id="input-attach" class="input-file styled-input">
						</td>
					</tr>
				</tbody>
			</table>
		</form>
		<a class="btn btn-danger mr5 mb10" href="javascript:insert('review');">리뷰등록</a>
	</div>
</div>