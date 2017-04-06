<?php
	require("classes/coord.php");
	require("classes/range.php");
	require("classes/chart.php");
	require("classes/loscalculator.php");

    $losCalculator = new LosCalculator();

    $startPos = new CoOrd($_REQUEST['lat1'], $_REQUEST['lon1'], $_REQUEST['h1']);
    $endPos = new CoOrd($_REQUEST['lat2'], $_REQUEST['lon2'],$_REQUEST['h2']);
    $points = $_REQUEST['points'];
    
    //    $startPos = new CoOrd(-25, 27.3, 10);
    //    $endPos = new CoOrd(-26.093600, 27.971213,10);
	// ?lat1=-25&lon1=27.3&h1=10&lat2=-26.093600&lon2=27.971213&h2=10
    // http://localhost/los/index.php?lat1=-25&lon1=27.3&h1=10&lat2=-26.093600&lon2=27.971213&h2=10&points=50
    
    $result = $losCalculator->Calculate($startPos, $endPos, $points);
	$chartData = new Chart($result);

	$i = 0;
	$ghz2ok = 100;
	$ghz5ok = 100;
	$reason = "Link is possible!";
	
	$ghz2frez = 0.0;
	$ghz5frez = 0.0;
	
	foreach ($result as &$coord) {
		$i++;    
		if ($coord->BeamHeight < $coord->Height)
		{
			$ghz2ok = 0;
			$ghz5ok = 0;
			$reason = "Blocked by ground";
		}
		
		if ($coord->LowerCurve2 < $coord->Height)
		{
			// 2Ghz Frez blocked (count)
			$ghz2frez++;
		}

		if ($coord->LowerCurve5 < $coord->Height)
		{
			// 5Ghz Frez blocked (count)
			$ghz5frez++;
		}
	}

	if ($ghz2ok > 0)
		$ghz2ok = 100 - ($ghz2frez/$points)*100; // link quality at 2Ghz

	if ($ghz5ok > 0)
		$ghz5ok = 100 - ($ghz5frez/$points)*100; // link quality at 5Ghz

	if ($ghz5ok < 60 && $ghz5ok > 0) 
		$reason = "5Ghz freznel zone obscured, link not reccomended";

	if ($ghz2ok < 60 && $ghz2ok > 0) 
		$reason = "2.4Ghz freznel zone obscured, link not reccomended";


?>
<html>
<head>
	<script
			  src="http://code.jquery.com/jquery-1.9.1.min.js"
			  integrity="sha256-wS9gmOZBqsqWxgIVgA8Y9WcQOa7PgSIX+rPA0VL2rbQ="
			  crossorigin="anonymous"></script>
	 <script src="https://code.highcharts.com/highcharts.js"></script>
	<script src="https://code.highcharts.com/modules/exporting.js"></script>
</head>
<body>
	<H1>JAWUG LOS UTILITY</H1>
 
	<div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
	
	<div id="analysis">
		Estimated Link Quality at 2Ghz: <?php echo $ghz2ok."%" ?><br/>
		Estimated Link Quality at 5Ghz: <?php echo $ghz5ok."%" ?><br/>	
		Reason: <?php echo $reason ?><br/>	
	</div>
    <script type="text/javascript">
      $(function () {
    $('#container').highcharts({
		chart: {
          zoomType: 'x'
            },
        title: {
            text: 'Line Of Sight Calculation',
            x: -20 //center
        },
        subtitle: {
            text: 'Source: USGS (Thanks NASA)',
            x: -20
        },
        xAxis: {
            title: {
                text: 'Distance (km)'
            },
        },
        yAxis: {
            title: {
                text: 'Height above sealevel (m)'
            },
            plotLines: [{
                value: 0,
                width: 1,
                color: '#808080'
            }],
            min: <?php echo $chartData->lowestPoint - 50 ?>,
        },
        tooltip: {
            valueSuffix: 'm'
        },
        legend: {
            layout: 'vertical',
            align: 'right',
            verticalAlign: 'middle',
            borderWidth: 0
        },
        series: <?php echo json_encode($chartData->data); ?>
    });
});
    </script>
</body>
</html>
