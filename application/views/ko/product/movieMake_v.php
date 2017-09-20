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
		
		$userName = $this->secretlib->enc_aes128_ecb($movieMake['username']);
		
		if(!$movieMake['username']){
			$email = explode("@", $movieMake['email']);
			$userName = $this->secretlib->enc_aes128_ecb($email[0]);
		}
		
		//echo "<br>".$movieMake['id'];
		//echo $userName;
		
		$first = 'true';	
		$fileName = $this->secretlib->enc_aes128_ecb($movieMake['movieFileName']);
		
	}
	if($movieMake['movieFileName']) $first = 'false';
?>

	<head>
		<title>무비메이커 | theDays</title>
		<script type="text/javascript" src="<?=S3_IMG_PATH?>/resources/scripts/libs/jquery.min.js?_=v1"></script>
		<script type="text/javascript" src="<?=S3_IMG_PATH?>/resources/scripts/libs/swfobject.js?_=v1"></script>
		<script type="text/javascript">
			/* enc */


			var flashvars = {
				orderid: "<?=$orderId?>",
				makeid: "<?=$makeid?>",
				memberid: "b2eac1aebbe372a76ef67eb869764823",
				memberUserid: "b2eac1aebbe372a76ef67eb869764823",
				memberName: "<?=$userName?>",
				vimeoid: "<?=$movieVimeoId?>",
				presetPath: "<?=$preset1?>",
				isFirst: "<?=$first?>",
				saveData: "<?=$fileName?>",
				imgFile: "<?=$fileName?>"
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
				id: "thedaysMovieMaker"
			};

			var swf_ldr = "";
			var d = new Date();
			swf_ldr = "<?=S3_IMG_PATH?>/resources/swf/ldr.swf?date=" + d.getHours() + d.getTime();

			swfobject.embedSWF(
				swf_ldr,
				"altContent", "1008", "653", "11.7.0",
				"expressInstall.swf",
				flashvars, params, attributes);

			$(document).ready(function() {
				try {
					opener.location.reload();

				} catch (err) {}


				setInterval(function() {
					$("#ifrm").attr("src", "/auth/loginCheck");
				}, 600000);


			});

		</script>
		<style>
			html,
			body {
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
					<br>
					<br>모바일에서는 무비메이커가 정상 작동 하지 않습니다.
					<br>
					<br>PC로 접속하여 진행하여 주십시오.
					<? }else{ ?>
						<a href="http://www.adobe.com/go/getflashplayer">Get Adobe Flash player</a>
						<br>
						<br>플래시 파일이 설치 되어야 실행 가능 합니다. 크롬이나 IE 브라우저에서 진행해 주십시오.
						<? } ?>
			</p>
		</div>

		<iframe id="ifrm" width="1" height="1" style="display:none;" src="/auth/loginCheck"></iframe>
	</body>

</html>
