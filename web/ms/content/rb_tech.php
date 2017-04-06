<?php
/* Start session */
session_start();
/* If someone is posting this as empty and there is no username set then do not run */

#Include the connect.php file
require($_SERVER['DOCUMENT_ROOT'] . '/auth/config.php');
/* Init the vars */
$wugms_cpu_tech_row = '';
$outp               = '';




$wugms_cpu_tech_query = " 
SELECT count(*) 'counter', Board_tech AS 'cpu_tech'
  FROM tbl_base_rb_routerboard
 where  upper(active) = 'Y'
GROUP BY Board_tech
ORDER BY Board_tech;";

$wugms_cpu_tech_stmt = $db->prepare($wugms_cpu_tech_query);
if ($wugms_cpu_tech_stmt->execute()) {
    $wugms_cpu_tech_row = $wugms_cpu_tech_stmt->fetchAll();
}

//    $result = array();
if ($wugms_cpu_tech_row) {
//    $series1 = array();
    $outp = "[";
	foreach ($wugms_cpu_tech_row as $x) {
		if ($outp != "[") {
			$outp .= ",";
			}
		$outp .= '{"cpu_tech":"' . $x["cpu_tech"] . '",';
		$outp .= '"counter":"' . $x["counter"] . '"}';
		}
		$outp .= "]";
	}

//    foreach ($wugms_cpu_tech_row as $x) {
        //$row[0] = $x['counter'];
//        $row[1] = $x['cpu_tech'];
        //array_push($series1, $row);
//    }
    /* Export the data */
    echo $outp;

?>