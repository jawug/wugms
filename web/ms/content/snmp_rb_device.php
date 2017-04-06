<?php

session_start();
require($_SERVER['DOCUMENT_ROOT'] . '/auth/config.php');
require($_SERVER['DOCUMENT_ROOT'] . '/content/functions.php');

$area    = "";
$areasql = "";
if (isset($_GET['area'])) {
    $area = $_GET['area'];
    
    //	$category         = array();
    //    $category['name'] = 'rdate';
    $snmp_device_row = '';
    $series1         = array();
    #
    if ($area == "volt") {
        $series1['name'] = 'Voltage';
        $areasql         = ", round(a.Voltage/10,1)'reading'";
        //		  $areasql = ", round(a.Voltage/10,1)'voltage'";
    } elseif ($area == "temp") {
        $series1['name'] = 'Temperature';
        $areasql         = ", round(a.Temperature/10,0)'reading'";
        //		  $areasql = ", round(a.Temperature/10,0)'temperature'";
    } elseif ($area == "current") {
        $series1['name'] = 'Current';
        $areasql         = ", a.Current 'reading'";
        //		  $areasql = ", a.Current 'current'";
    }
    /* Common SQL query*/
    $snmp_device_query = "
SELECT (UNIX_TIMESTAMP(a.rdate) + 7200) * 1000 'idate' " . $areasql . "
  FROM tbl_base_snmp_mikrotik_device a
 WHERE     (RDate BETWEEN (DATE_ADD(NOW(), INTERVAL -7 DAY))
                      AND (NOW() - INTERVAL 10 MINUTE))
       AND a.Serial_Number = :rb_sn
ORDER BY a.RDate;
";
    if (isset($_SESSION["rb_sn"])) {
        // Check if the site_name supplied has not already been used
        $snmp_device_query_params = array(
            ':rb_sn' => $_SESSION["rb_sn"]
        );
        
        $snmp_device_stmt = $db->prepare($snmp_device_query);
        if ($snmp_device_stmt->execute($snmp_device_query_params)) {
            $snmp_device_row = $snmp_device_stmt->fetchAll();
        }
    }
    
    if ($snmp_device_row) {
        
        foreach ($snmp_device_row as $x) {
            //            $category['data'][] = $x['idate'];
            //            $series1['data'][]  = $x['reading'];
            $series1['data'][] = array(
                $x['idate'],
                $x['reading']
            );
            
            $result = array();
            //            array_push($result, $category);
            array_push($result, $series1);
            
        }
        print json_encode($result, JSON_NUMERIC_CHECK);
        
    } else {
        $series1['data'][] = array();
        $result            = array();
        array_push($result, $series1);
        print json_encode($result, JSON_NUMERIC_CHECK);
    }
}
?>