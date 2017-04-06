		<!-- Scripts! -->
		<?php include($_SERVER['DOCUMENT_ROOT'].'/footreq.php'); ?>
<script src="/js/chosen.jquery.js" type="text/javascript"></script>
<script src="/js/highstock.js" type="text/javascript"></script>

<!-- The Chosen selector for the  -->
<script type="text/javascript">	
$(document).ready(function() {
    $('.chzn-select').each(function() {
        if ($(this).html().trim().length > 0) {
            pimpSelect($(this));
        }
    });

});

function pimpSelect(select, options) {
    var prepend = '';
    if (select.attr('data-placeholder')) {
        prepend = '<option></option>';
    }
    if (options) {
        options = prepend + options;
        select.empty().html(options);
    } else {
        select.prepend(prepend);
    }
    if (select.hasClass('chzn-select')) {
        var _width = select.css('width');
        select.chosen({
            width: _width
        });
    }
};
</script>

<script type="text/javascript">	
$(document).ready(function() {
/* Detect is there was a selection change */
        $('#cdn_select').on('change', function(event, params) {
/* Set the heading to show which rb has been selected */			
			$('#sel_device').html("<h3 class='sub-header'>Connection information for : <span style='color: rgb(0, 0, 153);'>" + $('#cdn_select option:selected').text() + "</span></h3>");
/* This is the selected value */
//			console.log($(this).val());
/* Assign the select val to local var */
			var $row = $(this).val();
			/*   2F060105B02F_65536 */
			var n = $row.indexOf("_");
	//		console.log(n);
			var $dev_id = $row.slice(0,n);
	//		console.log($dev_id);
			var $ssid_id = $row.slice(n+1);
	//		console.log($iface_id);			
				$.ajax({
					type: "POST",
					url: "/content/updaterb.php",
					data: { ssid_dev: $dev_id, 
					ssid_des: $('#cdn_select option:selected').text(),
					ssid_id: $ssid_id
					},
					success: function(){
					$('#ssid_ap_table').bootstrapTable('refresh','/content/snmp_ssid_ap.php');
					$('#ssid_client_table').bootstrapTable('refresh','/content/snmp_ssid_clients.php');
					

				//	$('#table').bootstrapTable('resetView');
/*					$('#ssid_client_table').bootstrapTable('refresh'); */
//						console.log('yes');
/*						$.getJSON("/content/snmp_interface_data.php?type=bytes", function(json) {
							interfaces_bytes_chart.addSeries(json[0]);
							interfaces_bytes_chart.addSeries(json[1]);
							interfaces_bytes_chart.redraw();
						});
						$.getJSON("/content/snmp_interface_data.php?type=packets", function(json) {
							interfaces_packets_chart.addSeries(json[0]);
							interfaces_packets_chart.addSeries(json[1]);
							interfaces_packets_chart.redraw();
						});*/
					},
					error: function(){
				//		console.log('no');
					}
				});		
		
        });

   });				
</script>
</html>
