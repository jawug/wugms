<?php
	require("classes/coord.php");
	require("classes/geo.php");
	require("classes/range.php");
	require("classes/loscalculator.php");
    
    $losCalculator = new LosCalculator();

    $startPos = new CoOrd($_REQUEST['lat1'], $_REQUEST['lon1'], $_REQUEST['h1']);
    $endPos = new CoOrd($_REQUEST['lat2'], $_REQUEST['lon2'],$_REQUEST['h2']);
    
    //    $startPos = new CoOrd(-25, 27.3, 10);
    //    $endPos = new CoOrd(-26.093600, 27.971213,10);
	// ?lat1=-25&lon1=27.3&h1=10&lat2=-26.093600&lon2=27.971213&h2=10
    // http://localhost/los/index.php?lat1=-25&lon1=27.3&h1=10&lat2=-26.093600&lon2=27.971213&h2=10&points=50
    
    $result = $losCalculator->Calculate($startPos, $endPos, $_REQUEST['points']);
    
?>
<html>
<head></head>
<body>
	<H1>JAWUG LOS UTILITY (2)</H1>
	<?php 
	
			$chartData = array();
			
			$groundData = new Range("ground");
			$beamData = new Range("beam");
			$lowercurveData = new Range("lowercurve");
			$uppercurveData = new Range("uppercurve");
	
			$chartData[] = $groundData;
			$chartData[] = $beamData;
			$chartData[] = $lowercurveData;
			$chartData[] = $uppercurveData;
				
			//$firstHeight = $coord[0]->Height;	
			//echo "<H1>MOO</H1>";//.json_encode($result);
				
			$i = 0;
			foreach ($result as &$coord) {
				$i++;
				// create ground data
				$bit = array();
				$bit[] = $i;
				$bit[] = $coord->Height;
				$groundData->data[] = $bit;
				// create beam data
				$bit = array();
				$bit[] = $i;
				$bit[] = 0;
				$beamData->data[] = $bit;
				// create lower curve data
				$bit = array();
				$bit[] = $i;
				$bit[] = 0;
				$lowercurveData->data[] = $bit;
				// create upper curve data
				$bit = array();
				$bit[] = $i;
				$bit[] = 0;
				$uppercurveData->data[] = $bit;
			}
			
			echo json_encode($chartData);
	
	 ?>
</body>
</html>
