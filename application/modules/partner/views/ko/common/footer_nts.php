	<!-- Footer -->
	<footer id="ft">
		<div class="row w1140">			
		</div>
	</footer>

<!--[if lt IE 9]>
	<script type="text/javascript" src="assets/js/libs/excanvas.min.js"></script>
	<script type="text/javascript" src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<script type="text/javascript" src="assets/js/libs/respond.min.js"></script>
	
	<script src="js/jquery.placeholder.js"></script>
	<script src="js/ie9.js"></script>
<![endif]-->

<script type='text/javascript' language='javascript'>
	
	jQuery.browser = {};
	jQuery.browser.mozilla = /mozilla/.test(navigator.userAgent.toLowerCase()) && !/webkit/.test(navigator.userAgent.toLowerCase());
	jQuery.browser.webkit = /webkit/.test(navigator.userAgent.toLowerCase());
	jQuery.browser.opera = /opera/.test(navigator.userAgent.toLowerCase());
	jQuery.browser.msie = /msie/.test(navigator.userAgent.toLowerCase());
	jQuery.browser.chrome = /chrome/.test(navigator.userAgent.toLowerCase());

	if ($.browser.msie) { /*IE fix for on change handling */
		$("input:radio, input:checkbox").click(function () {
			this.blur();
			this.focus();
		});
	}	
</script>

<!-- ajax file upload plu -->
<script src="/assets/js/jquery.form.js"></script>
<!-- Bootstrap plugins -->
<script src="/assets/js/bootstrap/bootstrap.js"></script>
<!-- Core plugins ( not remove ) -->
<script src="/assets/js/libs/modernizr.custom.js"></script>
<!-- Handle responsive view functions -->
<script src="/assets/js/jRespond.min.js"></script>

<!-- Handle template sounds -->
<!-- script src="/assets/plugins/misc/ion-sound/ion.sound.js"></script -->

<!-- Proivde quick search for many widgets -->
<script src="/assets/plugins/core/quicksearch/jquery.quicksearch.js"></script>

<!-- Prompt modal -->
<script src="/assets/plugins/ui/bootbox/bootbox.js"></script>
<!-- Other plugins ( load only nessesary plugins for every page) -->

<!-- user custom -->
<script src="/assets/js/phpjs.js"></script>
<!-- script src="/resources/scripts/AjaxUploader.js"></script -->
<script src="/assets/js/common.js"></script>
<script src="/assets/js/register.js"></script>


</div>

</body>

</html>