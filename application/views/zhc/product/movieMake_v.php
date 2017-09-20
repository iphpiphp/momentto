<!DOCTYPE html>
<html lang="ko">
<?
	
	if ($this->agent->is_mobile()){		
		//
	}else{
		
		$this->load->library('Secretlib');
		$orderId = $this->secretlib->enc_aes128_ecb($movieMake['orderId']);
		$makeid = $this->secretlib->enc_aes128_ecb($movieMake['movieId']);
		$movieVimeoId = $this->secretlib->enc_aes128_ecb($movieMake['movieVimeoId']);
		$preset1 = $this->secretlib->enc_aes128_ecb($movieMake['preset1']);
		//echo "<br>".$movieMake['id'];
		
		$first = 'true';	
		$fileName = $this->secretlib->enc_aes128_ecb($movieMake['movieFileName']);
		
	}
	
	//echo "<br><br>==>".$movieMake['movieFileName'];
	if($movieMake['movieFileName']) $first = 'flase';
	//$first = 'true';	
	//echo "b2eac1aebbe372a76ef67eb869764823 ____  ".$fileName;
	
?>

	<head>	
		<title>무비메이커 | theDays</title>		
		<script type="text/javascript" src="/resources/scripts/libs/jquery.min.js"></script>		
		<script type="text/javascript" src="/resources/scripts/libs/swfobject.js"></script>
		<script type="text/javascript">
			
	/* enc */
	/* thedayssecretkey
	*

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
	*/

	var flashvars = {
	orderid: "<?=$orderId?>",
	makeid: "<?=$makeid?>",
	memberid: "b2eac1aebbe372a76ef67eb869764823",
	memberUserid: "b2eac1aebbe372a76ef67eb869764823",
	memberName: "b2eac1aebbe372a76ef67eb869764823",
	vimeoid: "<?=$movieVimeoId?>",
	presetPath: "<?=$preset1?>",
	isFirst: "<?=$first?>",
	saveData: "<?=$fileName?>"
	};

	/*
	var flashvars = {
	orderid: "f0730704456d24e96918f413550863f6",
	makeid: "89043cb2851448f9ba4086c2c6dffd5483dc46dd856dd29b875ae20b7875b4de",
	memberid: "acaa9f0bfc8bee8916279b4054d10e9a",
	memberUserid: "8d609900ec85ffe69d060d75e8d25589",
	memberName: "cbdaed228030ddfc44a86746549a63e0",
	vimeoid: "84544b65f4f261ff7b19495bf5199e96",
	presetPath: "d9a3d92dd077e232e328215ff3055668919ae73b518200b64ad0ffe79443f16081a6770a4d817581fc202b829256470377efc47e12d1d2e6ef6e571ec9986449ed7d236ca3d8dd3b016fc133fdc2ed15",
	isFirst: "true",
	saveData: "b2eac1aebbe372a76ef67eb869764823"
	};
	100000000003997
	*/

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
	swfobject.embedSWF(
	"/resources/swf/ldr.swf",
	"altContent", "1008", "653", "11.7.0",
	"expressInstall.swf",
	flashvars, params, attributes);

	$(document).ready(function(){
	try {
	opener.location.reload();

	} catch(err){}

	/*
	setInterval(function(){
	$("#ifrm").attr("src", "/common/loginCheck");
	}, 600000);
	*/
	});

		</script>
		<style>
			html, body {
				height: 100%;
				overflow: hidden;
			}
			body {
				margin: 0;
			}
		</style>

	</head>

	<body>

		<div id="altContent">
			<h1>thedays_MovieMaker</h1>
			<p>
				
				<?if ($this->agent->is_mobile()){	?>
				<br><br>모바일에서는 무비메이커가 정상 작동 하지 않습니다.
				<br><br>PC로 접속하여 진행하여 주십시오.
				<? }else{ ?>
					<a href="http://www.adobe.com/go/getflashplayer">Get Adobe Flash player</a>
					<br><br>플래시 파일이 설치 되어야 실행 가능 합니다.
				<? } ?>
			</p>
		</div>

		<!-- iframe id="ifrm" width="1" height="1" style="display:none;" src="/common/loginCheck"></iframe -->
	</body>

</html>
