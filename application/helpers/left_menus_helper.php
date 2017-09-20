<? if ( ! defined('BASEPATH')) exit('No direct script access allowed');


function mypage_left_menu(){
    $CI =& get_instance();
    $args = func_get_args();
    //class="current-page"
    echo '
        <h2><a href="/mypage">마이페이지</a></h2>
        <ul class="menu">
            <li><a href="/mypage/my_movie">My Movie</a></li>
            <li><a href="/mypage/cart">장바구니</a></li>
            <li><a href="/mypage/coupon">쿠폰조회/등록</a></li>
            <li><a href="/mypage/point">나의 적립금</a></li>
            <li><a href="/mypage/retrun_order">취소/환불</a></li>
            <li><a href="/mypage/receipt_v/card">세금계산서/영수증발행</a></li>
            <li><a href="/mypage/review">나의 리뷰</a></li>
            <li><a href="/mypage/my_emailqa">내 문의내역</a></li>
            <li><a href="/mypage/myinfo_chk">개인정보 조회/변경</a></li>
            <li><a href="/mypage/delete_member">회원탈퇴</a></li>
        </ul>
    ';
}

//new
function aside_left_mypage(){
    $CI =& get_instance();
    $args = func_get_args();
	$uri = $CI -> uri->segment(2);
	
	$movie = "";
	$coupon = "";
	$point = "";
	$refund = "";	
	$mylogin = "";
	
	if($uri == '') $movie = 'on';
	if($uri == 'coupon' || $uri == 'coupon_fin') $coupon = 'on';
	if($uri == 'point') $point = 'on';
	if($uri == 'refund' || $uri == 'refund_app') $refund = 'on';
	if($uri == 'mylogin') $mylogin = 'on';
	
	
    echo '           
        <aside id="side" class="col-md-2">
		<h1>마이페이지</h1>
		<ul>
			<li><a class="'.$movie.'" href="/mypage/">My Movie <i class="fa fa-angle-right"></i></a></li>
			<li><a class="'.$coupon.'" href="/mypage/coupon/">쿠폰조회/등록 <i class="fa fa-angle-right"></i></a></li>
			<li><a class="'.$point.'" href="/mypage/point/">나의 적립금 <i class="fa fa-angle-right"></i></a></li>
			<li><a class="'.$refund.'" href="/mypage/refund/">취소/환불 <i class="fa fa-angle-right"></i></a></li>
			<li><a class="'.$mylogin.'" href="/mypage/mylogin/">개인정보 조회/변경 <i class="fa fa-angle-right"></i></a></li>
		</ul>
	</aside>
	';			
}
//new
function aside_left_customer(){
    $CI =& get_instance();
	$args = func_get_args();
	$uri = $CI -> uri->segment(2);
	$notice = "";
	$email = "";
	$faq = "";
	$guest_movie = "";
	if($uri == 'notice' || $uri == 'notice_view') $notice = "on";
	if($uri == 'faq') $faq = "on";
	if($uri == 'emailaq_view') $email = "on";
	if($uri == 'guest_movie') $guest_movie = "on";  
    echo '
    <aside id="side" class="col-sm-2">
		<h1>고객센터</h1>
    	<ul>
			<li><a class="'.$notice.'" href="/customer/notice">공지사항 <i class="fa fa-angle-right"></i></a></li>
			<li><a class="'.$faq.'" href="/customer/faq">FAQ <i class="fa fa-angle-right"></i></a></li>
			<li><a class="'.$email.'" href="/customer/emailaq_view">1:1 이메일 문의하기 <i class="fa fa-angle-right"></i></a></li>
			<li><a class="'.$guest_movie.'" href="/customer/guest_movie">비회원 주문/조회 <i class="fa fa-angle-right"></i></a></li>
		</ul>
	</aside>
		';			
}

//v3
function aside_top_mypage(){
	$CI =& get_instance();
    $args = func_get_args();
	$uri = $CI -> uri->segment(2);

	$movie = "";
	$coupon = "";
	$point = "";
	$refund = "";
	$mylogin = "";
	$myqa = "";

	if($uri == '') $movie = 'active';
	if($uri == 'coupon' || $uri == 'coupon_fin') $coupon = 'active';
	if($uri == 'point') $point = 'active';
	if($uri == 'refund' || $uri == 'refund_app') $refund = 'active';
	if($uri == 'mylogin') $mylogin = 'active';
	if($uri == 'myqa') $myqa = 'active';

	echo $html = '
		<nav class="lnb">
			<a href="#">마이페이지 <i class="fa fa-angle-down"></i></a>
			<ul>
				<li class="'.$movie.'"><a href="/mypage/">My Movie <i class="fa fa-angle-right"></i></a></li>
				<li class="'.$coupon.'"><a href="/mypage/coupon">쿠폰조회/등록 <i class="fa fa-angle-right"></i></a></li>
				<li class="'.$point.'"><a href="/mypage/point">나의 적립금 <i class="fa fa-angle-right"></i></a></li>
				<li class="'.$refund.'"><a href="/mypage/refund">취소/환불 <i class="fa fa-angle-right"></i></a></li>
				<li class="'.$mylogin.'"><a href="/mypage/mylogin">개인정보 조회/변경 <i class="fa fa-angle-right"></i></a></li>
				<li class="'.$myqa.'"><a href="/mypage/myqa/lists">1:1이메일문의 <i class="fa fa-angle-right"></i></a></li>
			</ul>
		</nav>
	';

}

//v3
function customer_top_menu(){
	$CI =& get_instance();
	$args = func_get_args();
	$uri = $CI -> uri->segment(2);
	$notice = "";
	$email = "";
	$faq = "";
	$guest_movie = "";

	$title = "";
	if($uri == 'notice' || $uri == 'notice_view') {
		$title = "공지사항";
		$notice= "active";
	}
	if($uri == 'faq') {
		$title = "고객센터 - FAQ ";
		$faq= "active";
	}
	if($uri == 'emailaq_view') {
		$title = "1:1이메일문의";
		$email= "active";
	}
	if($uri == 'guest_movie') {
		$title = "비회원주문/조회";
		$guest_movie= "active";
	}

	echo '
	<nav class="lnb">
		<a href="#">'.$title.'<i class="fa fa-angle-down"></i></a>
		<ul>
			<li class="'.$notice.'"><a href="/customer/notice">공지사항 <i class="fa fa-angle-right"></i></a></li>
			<li class="'.$faq.'"><a href="/customer/faq">FAQ <i class="fa fa-angle-right"></i></a></li>
			<li class="'.$email.'"><a href="/customer/emailaq_view">1:1 이메일 문의하기 <i class="fa fa-angle-right"></i></a></li>
			<li class="'.$guest_movie.'"><a href="/customer/guest_movie">비회원 주문/조회 <i class="fa fa-angle-right"></i></a></li>
		</ul>
	</nav>
	';
}
