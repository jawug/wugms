		<!-- Scripts! -->
		<?php include($_SERVER['DOCUMENT_ROOT'].'/footreq.php'); ?>
	<script src="/js/highstock.js" type="text/javascript"></script>
	<script src="/js/modules/data.js" type="text/javascript"></script>
	<script src="/js/themes/grid.js" type="text/javascript" ></script>
	<script src="/js/select2.min.js" type="text/javascript"></script>
	<script src="/js/moment.min.js" type="text/javascript"></script>	
	<script src="/js/bootstrap-datetimepicker.min.js" type="text/javascript"></script>
	
	<!-- Custom charts -->
	<script src="/js/wugms.chart.snmp.interfaces.js" type="text/javascript"></script>
	<script src="/js/wugms.chart.snmp.interfaces.packets.js" type="text/javascript"></script>
	<script src="/js/wugms.chart.snmp.interfaces.data.js" type="text/javascript"></script>

<script type="text/javascript">
$(document).ready(function() {
	/* * This section inits and sets various componets * */
	/* * Init the date/time selectors * */
	/* Start datetime */
	var olddate = new Date(); // create a date of Jun 15/2011, 8:32:00am
	var subbed = new Date(olddate - 12*60*60*1000); // subtract 3 hours
	
	/* Setup the start date component */
	$('#sdatepicker').datetimepicker({
		format: "YYYY-MM-DD HH:mm",
		defaultDate: subbed
	});
	/* Look for any on change events for the start date component */
    $("#sdatepicker").on("dp.change",function (e) {
		$('input[name="device_data_start_date_change"]').val($("#sdatepickertext").val());
    });
	
	/* End dateimte */
	/* Setup the end date component */	
	$('#edatepicker').datetimepicker({
		format: 'YYYY-MM-DD HH:mm',
		showTodayButton: true,
		defaultDate: new Date()

	});
	/* Look for any on change events for the start date component */
    $("#edatepicker").on("dp.change",function (e) {
		$('input[name="device_data_end_date_change"]').val($("#edatepickertext").val());
    });	

	/* Selector for Routerboards*/	
	/* Init */
	$(".selector2_rb").select2({
		placeholder: "Select a routerboard",
		allowClear: true,
		theme: "classic"
		});
	$('#selector2_rb').select2('val','');

	/* Selector for Routerboards*/	
	/* Init */	
	$(".selector2_interfaces").select2({
		placeholder: "Select an interface",
		allowClear: true,
		theme: "classic"
		});

	/* Selector for time interval*/
	/* Init */
   $(".selector2_interval").select2({
		placeholder: "Select an interval",
		allowClear: true,
		theme: "classic"
	});
	
	/* On change event */
	$("#selector2_rb").on('change', function(e) {
    /* As there was a change, we must get the new Id and then pass that on to the other selector */
		var str = $("#selector2_rb").val();
		var res = str.split("___");
		
	/* Using the serial number, get teh list of interfaces */
    $.getJSON("/content/wugms.user.list.routerboards.interfaces.php?device=" + res[0], function (data) {
		/* Clear */
		$('#selector2_interfaces').html('');

		/* Load the data that is returned from the ajax call */
		$(".selector2_interfaces").select2({
			data: data.data
			})
		
//		$('#selector2_interfaces').select2('val','');
        })
	});

});
</script>	
	


<script type="text/javascript">	
$(document).ready(function() {
/* Update button code goes here */
    $("#update_selection").click(function(){
		$('#feedback').empty();
		/* Get the value of the selected option */
		var str = $("#selector2_rb").val();
		var str2 = $("#selector2_interfaces").val();
		/* If there is no selected routerboard then warn the user */
		if (! str) {
			$('#feedback').html("<div class='alert alert-warning alert-dismissible' role='alert'>No <b>routerboard</b> has been selected from the drop down. <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");
			return false;
		}
//		$('#feedback').html("<b><span style='color: rgb(0, 153, 0);'>" + results[0].active + "</span></b>");
		
		var res = str.split("___");
		
		var res2 = str2.split("___");		
//	echo "<option value='" . $value['sn'] . "___" . $value["sitename"] . "___" . $value["device_name"] . "___" . $value["device_model"] . "'>" . $value["sitename"] . " -> " . $value["device_name"] . "</option>";
		/*  */		
		$.ajax({
			type: "POST",
			url: "/content/wugms.user.routerboard.interface.selection.update.php",
			data: { 
				device_sn: res[0],
				device_iface: res2[0],
				device_iface_des: res2[1],
				device_iface_type: res2[2],
				device_site: res[1],
				device_des: res[2],
				device_model: res[3],
				device_data_interval: $("#selector2_interval").val(),
				device_data_start_date: $("#sdatepickertext").val(),
				device_data_end_date: $("#edatepickertext").val()
			}, 
			success: function(){
				/* Update the different inputs with the values that were posted */
				/* Start with the hidden inputs */
				$("#device_data_end_date_init").val();
				$("#device_data_start_date_init").val();
				$("#device_data_end_date_change").val($("#device_data_end_date_change").val());
				$("#device_data_start_date_change").val($("#device_data_start_date_change").val());					
				$("#device_data_interval_init").val($("#selector2_interval").val());
				$("#device_des_init").val(res[2]);
				$("#device_site_init").val(res[1]);
				$("#device_sn_init").val(res[0]);
				$("#device_iface_init").val(res2[0]);
				$("#device_iface_des").val(res2[1]);
//				$("#sel_device").val("Selected device: " + res[2] + " Interface: " +res2[1]);
				$('#sel_device').html("Site: <span style='color: rgb(0, 0, 153);'><b>" + res[1] + "</span></b> Routerboard: <span style='color: rgb(0, 0, 153);'><b>" + res[2] + "</span></b> Interface: <span style='color: rgb(0, 0, 153);'><b>" + res2[1] + "</span></b> Type: <span style='color: rgb(0, 0, 153);'><b>" + res2[2] + "</span></b>");
				
				
				
				/* Refresh the Interface data based on the settings */
				while (interfaces_speed_snmp_chart.series.length > 0)
					interfaces_speed_snmp_chart.series[0].remove(true);
/*                $.getJSON("/content/snmp_interface_data.php", function(json) {
					for (var i = 0; i < json.data.length; i++) {
						if (i == 0) {
							interfaces_speed_snmp_chart.addSeries({
								name : json.data[i].name,
								type : "spline",
								color: '#008080', 
								tooltip: {
									valueSuffix: ' B/s'
								},
								data: json.data[i].data
							});
						};
						
						if (i == 1) {
							interfaces_speed_snmp_chart.addSeries({
								name : json.data[i].name,
								type : "spline",
								color: '#FF6600', 
								tooltip: {
									valueSuffix: ' B/s'
								},
								data: json.data[i].data
							});
						};						
					}
					interfaces_speed_snmp_chart.redraw();
                }); */
				/* Update the speed chart */
                $.getJSON("/content/snmp_interface_data.php?dtype=speed", function(json) {
					for (var i = 0; i < json.data.length; i++) {
						if (i == 0) {
							interfaces_speed_snmp_chart.addSeries({
								type: 'areaspline',
								name: 'Tx',
								color: '#00cf00',
								marker: {
									enabled: false,
									states: {
										hover: {
											enabled: true,
											radius: 1
										}
									}
								},
								gapSize: 1,
								lineWidth: 1,
								states: {
									hover: {
										lineWidth: 1
									}
								},
								fillColor: {
									linearGradient: {
										x1: 0,
										y1: 0,
										x2: 0,
										y2: 1
									},
									stops: [
										[0, '#00cf00'],
										[1, 'rgba(0, 207, 0, 0.1)']
									]
								},
								data: json.data[i].data
							});
						};
						
						if (i == 1) {
							interfaces_speed_snmp_chart.addSeries({
								type: 'spline',
								name: 'Rx',
								color: '#002A97',
								marker: {
									enabled: false,
										states: {
											hover: {
												enabled: true,
												radius: 1
											}
										}
								},
								gapSize: 1,
								lineWidth: 1,
								states: {
									hover: {
										lineWidth: 1
									}
								},
								data: json.data[i].data
							});
						};						
					}
					interfaces_speed_snmp_chart.redraw();
                });

				
				/* Refresh the Interface data based on the settings */
				while (interfaces_packets_snmp_chart.series.length > 0)
					interfaces_packets_snmp_chart.series[0].remove(true);				
				/* Update teh packets graph */
                $.getJSON("/content/snmp_interface_data.php?dtype=packet", function(json) {
					for (var i = 0; i < json.data.length; i++) {
						if (i == 0) {
							interfaces_packets_snmp_chart.addSeries({
								type: 'areaspline',
								name: 'Tx',
								color: '#007f00',
								marker: {
									enabled: false,
									states: {
										hover: {
											enabled: true,
											radius: 1
										}
									}
								},
								gapSize: 1,
								lineWidth: 1,
								states: {
									hover: {
										lineWidth: 1
									}
								},
								fillColor: {
									linearGradient: {
										x1: 0,
										y1: 0,
										x2: 0,
										y2: 1
									},
									stops: [
										[0, '#007f00'],
										[1, 'rgba(0, 127, 0, 0.1)']
									]
								},
								data: json.data[i].data
							});
						};
						
						if (i == 1) {
							interfaces_packets_snmp_chart.addSeries({
								type: 'spline',
								name: 'Rx',
								color: '#00007f',
								marker: {
									enabled: false,
										states: {
											hover: {
												enabled: true,
												radius: 1
											}
										}
								},
								gapSize: 1,
								lineWidth: 1,
								states: {
									hover: {
										lineWidth: 1
									}
								},
								data: json.data[i].data
							});
						};						
					}
					interfaces_packets_snmp_chart.redraw();
                });				
				
				
				/* Refresh the Interface data based on the settings */
				while (interfaces_data_snmp_chart.series.length > 0)
					interfaces_data_snmp_chart.series[0].remove(true);				
				/* Update teh packets graph */
                $.getJSON("/content/snmp_interface_data.php?dtype=data", function(json) {
					for (var i = 0; i < json.data.length; i++) {
						if (i == 0) {
							interfaces_data_snmp_chart.addSeries({
								type: 'areaspline',
								name: 'Tx',
								color: '#00fa00',
								marker: {
									enabled: false,
									states: {
										hover: {
											enabled: true,
											radius: 1
										}
									}
								},
								gapSize: 1,
								lineWidth: 1,
								states: {
									hover: {
										lineWidth: 1
									}
								},
								fillColor: {
									linearGradient: {
										x1: 0,
										y1: 0,
										x2: 0,
										y2: 1
									},
									stops: [
										[0, '#00fa00'],
										[1, 'rgba(0, 250, 0, 0.1)']
									]
								},
								data: json.data[i].data
							});
						};
						
						if (i == 1) {
							interfaces_data_snmp_chart.addSeries({
								type: 'spline',
								name: 'Rx',
								color: '#0000fa',
								marker: {
									enabled: false,
										states: {
											hover: {
												enabled: true,
												radius: 1
											}
										}
								},
								gapSize: 1,
								lineWidth: 1,
								states: {
									hover: {
										lineWidth: 1
									}
								},
								data: json.data[i].data
							});
						};						
					}
					interfaces_data_snmp_chart.redraw();
                });						
				/* Refresh the Storage data based on the settings */
/*				while (storage_snmp_chart.series.length > 0)
					storage_snmp_chart.series[0].remove(true);
                $.getJSON("/content/snmp_storage_data.php", function(json) {
					for (var i = 0; i < json.data.length; i++) {
						storage_snmp_chart.addSeries(json.data[i]);
					}
					storage_snmp_chart.redraw();
                }); */

				/* Refresh the Device data based on the settings */
/*				while (device_snmp_chart.series.length > 0)
					device_snmp_chart.series[0].remove(true);
                $.getJSON("/content/snmp_device_data.php", function(json) {
					for (var i = 0; i < json.data.length; i++) {
						if (i == 0) {
							device_snmp_chart.addSeries({
								name : json.data[i].name,
								type : "spline",
								color: '#105D9A', 
								tooltip: {
									valueSuffix: ' mA'
								},
								data: json.data[i].data
							});
						};
						
						if (i == 1) {
							device_snmp_chart.addSeries({
								name : json.data[i].name,
								type : "spline",
								color: '#FB0000',
								tooltip: {
									valueSuffix: ' °C'
								},
								data: json.data[i].data
							});
						};
						
						if (i == 2) {
							device_snmp_chart.addSeries({
								name : json.data[i].name,
								type : "spline",
								color: '#B9B900',
								tooltip: {
									valueSuffix: ' VDC'
								},
								data: json.data[i].data
							});
						};

					}		
					device_snmp_chart.redraw();
                });	*/
				},
				error: function(data){
					/* Display an alert to let the user know that something happened, something bad. */
					$('#feedback').html("<div class='alert alert-danger alert-dismissible' role='alert'>Seems like there was a problem. Returned status: <b>" + data.status + "</b> message: <b>" + data.message + "</b><br/>Please refresh the page and try again or else contact the wugms admins. <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");
//					console.log('no'); {"status":400,"message":"Invalid Request"}
//					console.log(data);
				}
			});
		});
});			
</script>

	
</body>
</html>
