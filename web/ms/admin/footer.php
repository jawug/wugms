		<!-- Scripts! -->
		<?php include($_SERVER['DOCUMENT_ROOT'].'/footreq.php'); ?>
		<!-- Section one : core network devices-->
		<script id="rb_reg" language="javascript" type="text/javascript">
			$(function () 
			{
			//-----------------------------------------------------------------------
			// 2) Send a http request with AJAX http://api.jquery.com/jQuery.ajax/
			//-----------------------------------------------------------------------
				$.getJSON('/content/rb_reg.php', function (results,textStatus) {
				$('#RB_Reg_Num').html("Routerboards registered: <b>" + results[0].counter + "</b>");
				}); 
			});
		</script>
	</body>
</html>