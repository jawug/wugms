		<!-- Scripts! -->
		<?php include($_SERVER['DOCUMENT_ROOT'].'/footreq.php'); ?>
		<script src="/js/highcharts.js" type="text/javascript"></script>
		<script src="/js/modules/data.js" type="text/javascript"></script>		
		<script src="/js/highcharts-3d.js"></script>
		<!-- Section one : core network devices-->
		<!-- Custom charts -->
		<!-- Section one -->
		<script src="/js/wugms.chart.admin.routerboard.qos.overview.js"></script>
		<script src="/js/wugms.chart.admin.routerboard.qos.selected.js"></script>
		<script src="/js/wugms.chart.admin.routerboard.qos.area.js"></script>
		<script id="rb_status" language="javascript" type="text/javascript">
		$(function () 
		{
		//-----------------------------------------------------------------------
		// 2) Send a http request with AJAX http://api.jquery.com/jQuery.ajax/
		//-----------------------------------------------------------------------
			$.getJSON('../../../../content/qos_stats.php', function (results,textStatus) {
				$('#qos_date').html("&nbsp;<span style='float:left;');'>Sample date <b><span style='color: rgb(0, 153, 0);'>" + results[0].rdate + "</span></span></b> <span style='float:right;');'> No. of QoS samplers: <b><span style='color: rgb(0, 0, 153);'>" + results[0].samplers  + "</span></span></b>");
			//	$('#qos_samplers').html("No. of QoS samplers: <b><span style='color: rgb(0, 0, 153);'>" + results[0].samplers + "</span></b>");
			}); 
		});
		</script>
	</body>
</html>