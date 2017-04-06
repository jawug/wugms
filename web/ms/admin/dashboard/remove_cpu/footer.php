		<!-- Scripts! -->
		<?php include($_SERVER['DOCUMENT_ROOT'].'/footreq.php'); ?>
<script src="/js/chosen.jquery.js" type="text/javascript"></script>
<script src="/js/highstock.js" type="text/javascript"></script>
<script src="/js/modules/data.js" type="text/javascript"></script>

<!-- Custom charts -->
<script src="/js/wugms.chart.snmp.cpu.day.js" type="text/javascript"></script>
<script src="/js/wugms.chart.snmp.cpu.month.js" type="text/javascript"></script>
<script src="/js/wugms.chart.snmp.cpu.year.js" type="text/javascript"></script> 
<script src="/js/wugms.ms.dashboard.cpu.misc.js" type="text/javascript"></script>

<!--	
<script>
    $(document).ready(
            function() {
                setInterval(function() {
                    $('#chart').title.text('qwerty5');
                }, 5000);
            });
</script>
-->

<script type="text/javascript">	
$(document).ready(function() {
/* Detect is there was a selection change */
        $('#cdn_select').on('change', function(event, params) {
/* Set the heading to show which rb has been selected */			
			$('#sel_device').html("<h3 class='sub-header'>CPU graphs for : <span style='color: rgb(0, 0, 153);'>" + $('#cdn_select option:selected').text() + "</span></h3>");
/* This is the selected value */
	//		console.log($(this).val());
/*  */		
				$.ajax({
					type: "POST",
					url: "/content/updaterb.php",
					data: { dev_id: $(this).val(), dev_des: $('#cdn_select option:selected').text() },
					success: function(){
				//		console.log('yes');
						/* Clear the series in teh charts */
						if (cpu_day_chart.series.length) {
							cpu_day_chart.series[0].remove();
						};
						if (cpu_month_chart.series.length) {
							cpu_month_chart.series[0].remove();
						};
						if (cpu_year_chart.series.length) {
							cpu_year_chart.series[0].remove();
						};						
						/* Get the data based on teh selection */
						/* day data */
						$.getJSON("/content/snmp_cpu_data.php?interval=day", function(json) {
//							cpu_day_chart.xAxis[0].setCategories(json[0]['data']);
							//cpu_day_chart.series[0].setData(json,false);
							cpu_day_chart.addSeries(json[0]);
							cpu_day_chart.redraw();
						});
						/* month data */
						$.getJSON("/content/snmp_cpu_data.php?interval=month", function(json) {
	//						cpu_month_chart.xAxis[0].setCategories(json[0]['data']);
							cpu_month_chart.addSeries(json[0]);
							cpu_month_chart.redraw();
						});
						/* year data */
						$.getJSON("/content/snmp_cpu_data.php?interval=year", function(json) {
		//					cpu_year_chart.xAxis[0].setCategories(json[0]['data']);
							cpu_year_chart.addSeries(json[0]);
							cpu_year_chart.redraw();
						});
					},
					error: function(){
						console.log('no');
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
