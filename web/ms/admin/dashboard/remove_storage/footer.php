		<!-- Scripts! -->
		<?php include($_SERVER['DOCUMENT_ROOT'].'/footreq.php'); ?>
<script src="/js/chosen.jquery.js" type="text/javascript"></script>
<!--<script src="/js/docsupport/prism.js" type="text/javascript" charset="utf-8"></script> -->
<script src="/js/highcharts.js" type="text/javascript"></script>
<!--<script src="/js/highcharts-more.js" type="text/javascript"></script> -->
<script src="/js/modules/data.js" type="text/javascript"></script>
<!--<script src="/js/modules/exporting.js" type="text/javascript"></script> -->
<!--<script src="/js/highslide-full.min.js" type="text/javascript"></script>
<script src="/js/highslide.config.js" type="text/javascript" charset="utf-8"></script> -->
<!-- Custom charts -->
<script src="/js/wugms.chart.snmp.storage.day.js" type="text/javascript"></script>
<script src="/js/wugms.chart.snmp.storage.month.js" type="text/javascript"></script>
<script src="/js/wugms.chart.snmp.storage.year.js" type="text/javascript"></script>
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
			$('#sel_device').html("<h3 class='sub-header'>Storage graphs for : <span style='color: rgb(0, 0, 153);'>" + $('#cdn_select option:selected').text() + "</span></h3>");
/* This is the selected value */
//			console.log($(this).val());
/* Assign the select val to local var */
			var $row = $(this).val();
			/*   2F060105B02F_65536 */
			var n = $row.indexOf("_");
//			console.log(n);
			var $dev_id = $row.slice(0,n);
//			console.log($dev_id);
			var $stor_id = $row.slice(n+1);
//			console.log($stor_id);			
				$.ajax({
					type: "POST",
					url: "/content/updaterb.php",
					data: { sdev_id: $dev_id, 
					sdev_des: $('#cdn_select option:selected').text(),
					stor_id: $stor_id
					},
					success: function(){
//						console.log('yes');
						/* Clear the series in teh charts */
/*						if (storage_day_chart.series.length) {
							storage_day_chart.series[0].remove();
							storage_day_chart.series[0].remove();
						};
						if (storage_month_chart.series.length) {
							storage_month_chart.series[0].remove();
							storage_month_chart.series[0].remove();
						};
						if (storage_year_chart.series.length) {
							storage_year_chart.series[0].remove();
							storage_year_chart.series[0].remove();
						}; */
						/* Get the data based on teh selection */
						/* day data */
						$.getJSON("/content/snmp_storage_data.php?interval=day", function(json) {
							storage_day_chart.series[0].setData(json[0].data);
							storage_day_chart.series[1].setData(json[1].data);
							storage_day_chart.redraw();
						});
						/* month data */
						$.getJSON("/content/snmp_storage_data.php?interval=month", function(json) {
							storage_month_chart.series[0].setData(json[0].data);
							storage_month_chart.series[1].setData(json[1].data);
							storage_month_chart.redraw();
						});
						/* year data */
						$.getJSON("/content/snmp_storage_data.php?interval=month", function(json) {
							storage_year_chart.series[0].setData(json[0].data);
							storage_year_chart.series[1].setData(json[1].data);
							storage_year_chart.redraw();
						});
					},
					error: function(){
						console.log('no');
					}
				});		
		
        });

   });				
</script>
	
	
</body>
</html>
