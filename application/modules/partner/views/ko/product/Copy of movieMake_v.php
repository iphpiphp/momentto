<jsp:directive.page contentType="text/html;charset=UTF-8" />
<jsp:directive.include file="/WEB-INF/views/common/lib/taglib.jsp"/>
<!DOCTYPE html>
<html lang="ko">
<head>
	<title>무비메이커 | theDays</title>
	
	<script type="text/javascript" src="/resources/scripts/libs/jquery.min.js"></script>
	<script type="text/javascript" src="/resources/scripts/libs/swfobject.js"></script>
	<script type="text/javascript">
		<%--
		/* original
		var flashvars = {
			orderid: "${movieMaker.orderId }",
			makeid: "${movieMaker.id }",
			memberid: "${order.memberId }",
			memberUserid: "${order.memberUserId }",
			memberUserName: "${order.memberUserId }",
			vimeoid: "${orderItem.movieVimeoId }",
			presetPath: "${orderItem.preset1}",
			isFirst: "${empty movieMaker.fileName }",
			saveData: "${movieMaker.fileName }"
		};
		*/
		
		/* dec
		var flashvars = {
			orderid: "${crypto.decrypt(crypto.encrypt(movieMaker.orderId)) }",
			makeid: "${crypto.decrypt(crypto.encrypt(movieMaker.id)) }",
			memberid: "${crypto.decrypt(crypto.encrypt(order.memberId)) }",
			memberUserid: "${crypto.decrypt(crypto.encrypt(order.memberUserId)) }",
			memberName: "${crypto.decrypt(crypto.encrypt(order.memberName)) }",
			vimeoid: "${crypto.decrypt(crypto.encrypt(orderItem.movieVimeoId)) }",
			presetPath: "${crypto.decrypt(crypto.encrypt(orderItem.preset1)) }",
			isFirst: "${empty movieMaker.fileName }",
			saveData: "${crypto.decrypt(crypto.encrypt(movieMaker.fileName)) }"
		};
		*/
		--%>

		/* enc */
		var flashvars = {
			orderid: "${crypto.encrypt(movieMaker.orderId) }",
			makeid: "${crypto.encrypt(movieMaker.id) }",
			memberid: "${crypto.encrypt(order.memberId) }",
			memberUserid: "${crypto.encrypt(order.memberUserId) }",
			memberName: "${crypto.encrypt(order.memberName) }",
			vimeoid: "${crypto.encrypt(orderItem.movieVimeoId) }",
			presetPath: "${crypto.encrypt(orderItem.preset1)}",
			isFirst: "${empty movieMaker.fileName }",
			saveData: "${crypto.encrypt(movieMaker.fileName) }"
		};
		
		var params = {
			menu: "false",
			scale: "noScale",
			allowFullscreen: "true",
			allowScriptAccess: "always",
			bgcolor: "",
			base: ".",
			wmode: "window" // can cause issues with FP settings & webcam
		};
		var attributes = {
			id:"thedaysMovieMaker"
		};

		//"/resources/swf/ldr.swf", 
		//"http://res.thedays.co.kr/ldr.swf"
		swfobject.embedSWF(
			"/resources/swf/ldr.swf",
			"altContent", "1008", "653", "11.7.0", 
			"expressInstall.swf", 
			flashvars, params, attributes);
		
		$(document).ready(function(){
			try {
				opener.location.reload();
				
			} catch(err){}
			
			setInterval(function(){
				$("#ifrm").attr("src", "/common/loginCheck");
			}, 600000);
		});
		
	</script>
	<style>
		html, body { height:100%; overflow:hidden; }
		body { margin:0; }
	</style>
	
</head>

<body>

	<div id="altContent">
		<h1>thedays_MovieMaker</h1>
		<p><a href="http://www.adobe.com/go/getflashplayer">Get Adobe Flash player</a></p>
	</div>
	
	<iframe id="ifrm" width="1" height="1" style="display:none;" src="/common/loginCheck"></iframe>
</body>

</html>
