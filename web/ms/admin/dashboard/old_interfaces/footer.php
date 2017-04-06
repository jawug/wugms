		<!-- Scripts! -->
		<?php include($_SERVER['DOCUMENT_ROOT'].'/footreq.php'); ?>
<script src="/js/highstock.js" type="text/javascript"></script>
<script src="/js/modules/data.js" type="text/javascript"></script>

<!-- Custom charts -->
<script src="/js/wugms.chart.snmp.interfaces.bytes.js" type="text/javascript"></script>
<script src="/js/wugms.chart.snmp.interfaces.packets.js" type="text/javascript"></script>
<!-- <script src="/js/wugms.chart.snmp.interfaces.month.js" type="text/javascript"></script>
<script src="/js/wugms.chart.snmp.interfaces.year.js" type="text/javascript"></script> -->

<!--<script src="/js/wugms.ms.dashboard.interfaces.misc.js" type="text/javascript"></script> -->
<!--<script type="text/javascript">
    var config = {
      '.chosen-select'           : {},
      '.chosen-select-deselect'  : {allow_single_deselect:true},
      '.chosen-select-no-single' : {disable_search_threshold:10},
      '.chosen-select-no-results': {no_results_text:'Oops, nothing found!'},
      '.chosen-select-width'     : {width:"95%"}
    }
    for (var selector in config) {
      $(selector).chosen(config[selector]);
    }
	</script> -->
	

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
			$('#sel_device').html("<h3 class='sub-header'>Interface graphs for : <span style='color: rgb(0, 0, 153);'>" + $('#cdn_select option:selected').text() + "</span></h3>");
/* This is the selected value */
//			console.log($(this).val());
/* Assign the select val to local var */
			var $row = $(this).val();
			/*   2F060105B02F_65536 */
			var n = $row.indexOf("_");
	//		console.log(n);
			var $dev_id = $row.slice(0,n);
	//		console.log($dev_id);
			var $iface_id = $row.slice(n+1);
	//		console.log($iface_id);			
				$.ajax({
					type: "POST",
					url: "/content/updaterb.php",
					data: { idev_id: $dev_id, 
					idev_des: $('#cdn_select option:selected').text(),
					iface_id: $iface_id
					},
					success: function(){
//						console.log('yes');
						/* Clear the series in teh charts */
//						if (interfaces_bytes_chart.series.length) {
/*							interfaces_bytes_chart.series[0].remove();
							interfaces_bytes_chart.series[0].remove();*/
//							interfaces_bytes_chart.series[0].setData([]);
//							interfaces_bytes_chart.series[1].setData([]);
//						}; 
//						if (interfaces_packets_chart.series.length) {
//							interfaces_packets_chart.series[0].remove();
//							interfaces_packets_chart.series[0].remove();
//						};
						/* Get the data based on teh selection */
						/* day data */
						$.getJSON("/content/snmp_interface_data.php?type=bytes", function(json) {
/*							interfaces_bytes_chart.addSeries(json[0]);
							interfaces_bytes_chart.addSeries(json[1]); */
							interfaces_bytes_chart.series[0].setData(json[0].data);
							interfaces_bytes_chart.series[1].setData(json[1].data);
							interfaces_bytes_chart.redraw();
						});
						$.getJSON("/content/snmp_interface_data.php?type=packets", function(json) {
							interfaces_packets_chart.series[0].setData(json[0].data);
							interfaces_packets_chart.series[1].setData(json[1].data);
							interfaces_packets_chart.redraw();
						});						
						/* month data 
						$.getJSON("/content/snmp_interfaces_data.php?interval=month", function(json) {
							interfaces_month_chart.addSeries(json[0]);
							interfaces_month_chart.addSeries(json[1]);
							interfaces_month_chart.redraw();
						}); */
						/* year data 
						$.getJSON("/content/snmp_interfaces_data.php?interval=year", function(json) {
							interfaces_year_chart.addSeries(json[0]);
							interfaces_year_chart.addSeries(json[1]);
							interfaces_year_chart.redraw();
						}); */
					},
					error: function(){
				//		console.log('no');
					}
				});		
		
        });

   });				
</script>
	
	
</body>
</html>
