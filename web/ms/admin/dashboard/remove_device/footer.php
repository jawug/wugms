		<!-- Scripts! -->
		<?php include($_SERVER['DOCUMENT_ROOT'].'/footreq.php'); ?>
<script src="/js/chosen.jquery.js" type="text/javascript"></script>
<script src="/js/highstock.js" type="text/javascript"></script>

<script src="/js/modules/data.js" type="text/javascript"></script>

<!-- Custom charts -->
<script src="/js/wugms.chart.snmp.rb.device.volt.js" type="text/javascript"></script>
<script src="/js/wugms.chart.snmp.rb.device.temperature.js" type="text/javascript"></script>
<script src="/js/wugms.chart.snmp.rb.device.current.js" type="text/javascript"></script>
<!--<script src="/js/wugms.ms.dashboard.storage.misc.js" type="text/javascript"></script> -->
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
	

<script type="text/javascript">	
$(document).ready(function() {
/* Detect is there was a selection change */
        $('#cdn_select').on('change', function(event, params) {
/* Set the heading to show which rb has been selected */			
			$('#sel_device').html("<h3 class='sub-header'>Device dependant graphs for : <span style='color: rgb(0, 0, 153);'>" + $('#cdn_select option:selected').text() + "</span></h3>");
/* This is the selected value */
//			console.log($(this).val());
/*  */		
				$.ajax({
					type: "POST",
					url: "/content/updaterb.php",
					data: { dev_id: $(this).val(), dev_des: $('#cdn_select option:selected').text() },
					success: function(){
//						console.log('yes');
						/* Clear the series in teh charts */
						if (rb_voltage_chart.series.length) {
							rb_voltage_chart.series[0].remove();
						};
						if (rb_temp_chart.series.length) {
							rb_temp_chart.series[0].remove();
						};
						if (rb_current_chart.series.length) {
							rb_current_chart.series[0].remove();
						};						
						/* Get the data based on teh selection */
						/* day data */
						$.getJSON("/content/snmp_rb_device.php?area=volt", function(json) {
//							rb_voltage_chart.xAxis[0].setCategories(json[0]['data']);
							rb_voltage_chart.addSeries(json[0]);
							rb_voltage_chart.redraw();
						});
						/* month data */
						$.getJSON("/content/snmp_rb_device.php?area=temp", function(json) {
//							rb_temp_chart.xAxis[0].setCategories(json[0]['data']);
							rb_temp_chart.addSeries(json[0]);
							rb_temp_chart.redraw();
						});
						/* year data */
						$.getJSON("/content/snmp_rb_device.php?area=current", function(json) {
//							rb_current_chart.xAxis[0].setCategories(json[0]['data']);
							rb_current_chart.addSeries(json[0]);
							rb_current_chart.redraw();
						});
					},
					error: function(){
//						console.log('no');
					}
				});		
		
        });

   });				
</script>	
	
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

	
	
</body>
</html>
