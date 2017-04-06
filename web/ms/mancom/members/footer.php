		<!-- Scripts! -->
		<?php include($_SERVER['DOCUMENT_ROOT'].'/footreq.php'); ?>
		<script language="javascript" type="text/javascript">
/*		$(function () {
			var $result = $('#eventsResult');
			$('#user_accounts_table').on('all.bs.table', function (e, name, args) {
//				console.log('Event:', name, ', data:', args); 
			})
			.on('check.bs.table', function (e, row) {
				$result.text('Event: check.bs.table');
				console.log('user_id:', row.user_id); 
			})
			.on('uncheck.bs.table', function (e, row) {
				$result.text('Event: uncheck.bs.table');
				console.log('user_id: -', row.user_id); 
			})*/
/*			.on('check-all.bs.table', function (e) {
				$result.text('Event: check-all.bs.table');
				console.log('user_id:', row.user_id); 				
			})
			.on('uncheck-all.bs.table', function (e) {
				$result.text('Event: uncheck-all.bs.table');
				console.log('user_id: -', row.user_id); 
			});
		});			*/
		</script>
		
		<script language="javascript" type="text/javascript">
		var $table = $('#user_accounts_table'),
			$button = $('#update_btn');
		$(function () {
			$button.click(function () {
				var minions = [];
				var data = $table.bootstrapTable('getSelections'); <!-- This works when there are items that are selected. -->
				/*alert('getSelections: ' + JSON.stringify($table.bootstrapTable('getSelections'))); */
				/*alert('getSelections: ' + JSON.stringify(data));*/
				var ids = $.map(data, function (item) {
					minions.push(item.user_id);  
				})
/*				console.log(minions); <!-- This will display the user's ID -->
				console.log(minions.length);*/
				
				if (minions.length>0) {
					var jsonString = JSON.stringify(minions);
					$.ajax({
						type: "POST",
						url: '../../../content/wugms.table.mancom.users.update.php',
						data: {data : jsonString}, 
						cache: false,
						success: function(){
							//alert("OK");
							$('#user_accounts_table').bootstrapTable('refresh','/content/snmp_ssid_ap.php');
						}
					});
				}
				
			});
		});
		</script>
	</body>
</html>
