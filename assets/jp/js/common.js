// Scroll move
function scrollMove(t,h) {
	"use strict";
	if(h==undefined) h=0;
	var o = jQuery('html, body');
	o.animate({
		scrollTop:jQuery(t).offset().top-h
	},500);
}

// Menu Open
function menuOpen(o){
	"use strict";
	$('#wrap').after('<button type="button" id="sidebarTg" onclick="menuClose();"><b class="sr-only">Close</b></button>');
	var a = -$(window).scrollTop();
	$('#'+o).show(0,function(){
		$('#sidebarTg').addClass('in');
		$('body').addClass('nav-open '+o+'-open');
		$('#wrap').addClass('if-m').css('top',a);
	});
}

// Menu Close
function menuClose(o){
	"use strict";
	$('#sidebarTg').removeClass('in');
	$('body').removeClass('snb-open');
	var originScroll = -$('#wrap').position().top;
	setTimeout(function(){
		$('div.side-nav').hide();
		$('body').removeClass('nav-open');
		$(window).scrollTop(originScroll);
		$('#wrap').removeClass('if-m').removeAttr('style');
		$('#sidebarTg').remove();
	},500);
}

jQuery(function ($) {
	"use strict";

	// faq
	$('.tb-faq .tit>a').on('click',function  () {
		$(this).parent().toggleClass('open').parent().next().toggle();
		return false;
	});

	//collapse
	$('.btn-collapse').on('click',function  () {
		$(this).parent('.collapse-title').toggleClass('open').next('.collapse-cnt').stop().slideToggle(200);
	});
})

