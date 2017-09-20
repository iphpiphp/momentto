	

	<!-- #container -->
	<div id="container" class="clearfix">

<!-- 페이지 시작-->

<div id="review" class="row side_page w1140">
	
		
	<div class="input_review">
		<table class="table">
			<tr>
				<th>제목</th>
				<td>
					<input type="text" name="title" value="" />
				</td>
			</tr>
		</table>		
	</div>

	<!-- 카테고리 선택 -->
	<!-- 리뷰 리스트에서 글 쓰기로 들어 왔을 경우 -->	
	<div class="select_group form-inline">
		<? ajax_cate(); ?>
	</div>

	<!-- 1. 수정 하기 2. 글쓰기 에서는 textarea 3. 보기에는 div -->
	<div class="row">
		<div class="col-xs-12 mt15">
			<textarea rows="8" cols="100" class="form-control icon-textarea" style="width:100%"></textarea>
		</div>		
		<!--
			* 해당 권한이 있을 경우 버튼이 노출 됨. 아니면 노출 안됨
		 * case 1 수정 
		 * 수정 일때는 수정 버튼 , 삭제 버튼
		 * case 2 뷰
		 * 수정 버튼, 삭제 버튼 
		 * case 3 글쓰기
		 * 쓰기 버튼	
		-->
		<div class="col-xs-12 btn_group pt10 pb10 text-right">
			<a href="#" class="btn btn_blk  w80 mb5">수정</a>
			<a href="#" class="btn btn_blk  w80 mb5">삭제</a>
			<a href="#" class="btn btn_blk  w80 mb5" style="color: ##DA4A61;">글쓰기</a>
		</div>
	</div>

	<!-- 댓글 등록 폼 -->
	<div class="cmt_wrt_wrp pt15-xs pb15-xs">
		<div>
			<form class="bx2">
				
				
				<div class="form-group">
					<textarea rows="5" class="form-control input-lg" placeholder="내용 (무비에 대한 문의사항은 고객센터를 이용해 주세요.)"></textarea>
				</div>				
				<div class="row">
					
					<div class="col-sm-3 col-xs-12">
						<button type="submit" class="btn btn-lg btn-block bg_red">댓글 등록</button><span>로그인 하셔야 댓글을 등록 하실 수 있습니다.</span>
					</div>
				</div>
			</form>
		</div>
	</div>
	<!-- 댓글 리스트 -->
	<div class="row pb40 cmt_lst">
		<!-- 댓글 리스트 -->
	<style>
		.reply_block_left {
			float: left;
		}
		.reply_block_right {
			float: left;
		}
	</style>
	<div class="row">
		<h3>댓글 리스트 [마진값 적당히 조절- 글과 글 사이 솔리드 라인 추가 ]</h3>
		<div>
			<? foreach($reply as $key => $val):?>
				<div class="reply_block clearfix">
					<div class="reply_block_left"><img width=50 height=50 src="<?=IMG_PATH ?>img/profile/profile.png" class="img-circle img-thumbnail" /></div>
					<div class="reply_block_right">
						<div class="reply_info"><?=$val['memberName'] ?></div>
						<div class="reply_content"><?=$val['content'] ?></div>
					</div>
					<!-- div class="reply_img"><? if($val['fileName']){echo '<br /><img  style="max-width: 400px" src="' . Base_url() . 'resources/uploads/review/' . $val["fileName"] . '">';} ?></div -->
				</div>
			<? endforeach; ?>
		</div>
	</div>
	</div>
	
		
</div>

<!-- //페이지 끝-->

	</div>
	<!-- //container -->
	<script>
	$(document).ready(function() {
				
		ajax_find_category();//카테고리 init
				
		//카테고리 선택시
		$("select[name ='cate']" ).change(function (){
			var cate_num = $("#cate option:selected").val();
			if(cate_num > 0 ){
				
				ajax_find_product_list(cate_num);
			}
		});
		//상품 선택시
		$("select[name ='product']" ).change(function (){
			var product_id = $("#product option:selected").val();
			if(product_id > 0 ){
				ajax_find_product(product_id);
			}
		});
		
	});

	
	
	function ajax_find_product_list(cate_num){		
		$.ajax({
			type: "POST",
			data: {cate_id:cate_num},
			cache: false,
			async: false,
			url: "/api/productlists",
			dataType: "json",
			success: function(data){				
				var temp_options = "<option calss='cate_options' value=''>제품을 선택하세요</option>";
				$.each(data.productlist, function (key, value) {
					temp_options = temp_options + "<option class='cate_options' value='"+value['id']+"' >"+value['name']+"</option>";
				});
				alert(temp_options);
				$("#product").html(temp_options); //옵션 채워넣고
			}
		 });
	}
	
	function ajax_find_category(){		
		$.ajax({
			type: "POST",
			data: {},
			cache: false,
			async: false,
			url: "/api/catelist",
			dataType: "json",
			success: function(data){
				
				var temp_options = "";
				
				$.each(data.catelist, function (key, value) {					
					temp_options = temp_options + "<option class='cate_options' value='"+value['id']+"' >"+value['name']+"</option>";
					
				});
				
				$("#cate").append(temp_options);
			}
		 });
	
	}

	function comma(str) {
		str = String(str);
		return str.replace(/(\d)(?=(?:\d{3})+(?!\d))/g, '$1,');
	}


	
</script>