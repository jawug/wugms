		<!-- Scripts! -->
		<?php include($_SERVER['DOCUMENT_ROOT'].'/footreq.php'); ?>
	<script src="/js/bootstrap-combobox.js"></script>
	<script type="text/javascript">
	$(document).ready(function(){
		/* Init the combobox */
		$('.combobox').combobox();
		
		$('#select_user').on("change", function () {
			$('#user_audit_table').bootstrapTable('refresh',{url: '/content/wugms.table.admin.user.audit.php?user=' + $('#select_user').val()});
			});
	});
</script>
</body>
</html>
