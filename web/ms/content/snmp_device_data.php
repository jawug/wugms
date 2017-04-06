<?php

session_start();
require($_SERVER['DOCUMENT_ROOT'] . '/auth/config.php');
require($_SERVER['DOCUMENT_ROOT'] . '/content/functions.php');

/* Default interval setting */
$interval      = "5min";
$start_date    = "";
$end_date      = "";
$date_selection   = "";
$cpu_snmp_data = '[{"name" : "current","data" : []}, {"name" : "temperature","data" : []}, {"name" : "voltage","data" : []}]';

/* check if the session vars are set */
/* required vars: user_id and rb_sn */
//echo "no";
if ((isset($_SESSION["id"])) && (isset($_SESSION["rb_sn"]))) {
    //	echo "yes";

    /* Dates */
    /* If the dates are set to "0" then we use default dates */
    /* default: interval of 5min means last 12 hours */
    /* default: interval of 60min means last 12 days */
    /* default: interval of day means last 12 weeks */
    if ((isset($_SESSION["rb_start_date"])) && (isset($_SESSION["rb_end_date"]))) {
        /* yes yes */
        //function StartEndDateCompare($sdate, $edate, $interval)	
        $snmp_cp_dates = StartEndDateCompare($_SESSION["rb_start_date"], $_SESSION["rb_end_date"], $interval);
    } else if ((isset($_SESSION["rb_start_date"])) && (!isset($_SESSION["rb_end_date"]))) {
        /* yes no */
        $snmp_cp_dates = StartEndDateCompare($_SESSION["rb_start_date"], 0, $interval);
    } else if ((!isset($_SESSION["rb_start_date"])) && (isset($_SESSION["rb_end_date"]))) {
        /* no yes */
        $snmp_cp_dates = StartEndDateCompare(0, $_SESSION["rb_end_date"], $interval);
    } else {
        /* no no */
        $snmp_cp_dates = StartEndDateCompare(0, 0, $interval);
    }
    /* Set the dates as per the returned values */
    $start_date = $snmp_cp_dates['start'];
    $end_date   = $snmp_cp_dates['end'];
    
    /* Check what the interval is set too */
    if (isset($_SESSION["rb_interval"])) {
        if ($_SESSION["rb_interval"] === "5min") {
            $interval = "5min";
			$date_selection ="WHERE a.RDate >= DATE_FORMAT('$start_date', '%Y/%m/%d %H:%i:%s') and a.RDate <= DATE_FORMAT('$end_date', '%Y/%m/%d %H:%i:00')";
        } else if ($_SESSION["rb_interval"] === "60min") {
            $interval = "60min";
			$date_selection ="WHERE a.RDate >= DATE_FORMAT('$start_date', '%Y/%m/%d %H:00:00') and a.RDate <= DATE_FORMAT('$end_date', '%Y/%m/%d %H:00:00')";
        } else if ($_SESSION["rb_interval"] === "day") {
            $interval = "day";
			$date_selection ="WHERE a.RDate >= DATE_FORMAT('$start_date', '%Y/%m/%d 00:00:00') and a.RDate <= DATE_FORMAT('$end_date', '%Y/%m/%d 00:00:00')";
        } else {
            $interval = "5min";
			$date_selection ="WHERE a.RDate >= DATE_FORMAT('$start_date', '%Y/%m/%d %H:%i:%s') and a.RDate <= DATE_FORMAT('$end_date', '%Y/%m/%d %H:%i:00')";
        }
    }	
	
    /* Now that we have done our checks we must get the data */
    /*$snmp_device_query  = "
	SELECT c.idate, c.Serial_Number, CONCAT('CPU ',c.CPU_ID ) as cpuid, c.Reading
		FROM tbl_summary_snmp_common_device_$interval c
		WHERE c.RDate >= '$start_date'
		and   c.RDate <  '$end_date'
		and c.Serial_Number = :rb_sn;"; */
		
		
    $snmp_device_query  = "
SELECT volt_reading.*
  FROM (SELECT a.idate, 'voltage' AS dev_type, a.Voltage AS 'reading'
          FROM tbl_summary_snmp_mikrotik_device_$interval a
         $date_selection
               AND a.Serial_Number = :rb_sn
        ORDER BY a.RDate) AS volt_reading
UNION
SELECT temp_reading.*
  FROM (SELECT a.idate, 'temperature' AS dev_type, a.temperature AS 'reading'
          FROM tbl_summary_snmp_mikrotik_device_$interval a
         $date_selection
               AND a.Serial_Number = :rb_sn
        ORDER BY a.RDate) AS temp_reading
UNION
SELECT curr_reading.*
  FROM (SELECT a.idate, 'current' AS dev_type, a.current AS 'reading'
          FROM tbl_summary_snmp_mikrotik_device_$interval a
         $date_selection
               AND a.Serial_Number = :rb_sn
        ORDER BY a.RDate) AS curr_reading
ORDER BY idate, dev_type;";		
		
    $series1         = array();
    $series1['name'] = 'Reading';
    
    /* Assign the variables to the parameters */
    $snmp_device_query_params = array(
        ':rb_sn' => $_SESSION["rb_sn"]
    );
	
    /* Execute the SQL query */
    $snmp_device_stmt = $db->prepare($snmp_device_query);
    if ($snmp_device_stmt->execute($snmp_device_query_params)) {
        $snmp_device_row = $snmp_device_stmt->fetchAll();
    }
	
    /* Works through the results and get them into an array */
    if ($snmp_device_row) {
        foreach ($snmp_device_row as $x) {
            $res[$x['dev_type']][] = array(
                $x['idate'],
                $x['reading']
            );
        }
        foreach ($res as $k => $i) {
            $tmp['name'] = $k;
            $tmp['data'] = $i;
            $result[]    = $tmp;
        }
        $cpu_snmp_data = $result;
        //		$cpu_snmp_data = json_encode($result, JSON_NUMERIC_CHECK);
    }
    /* Set vars to delivery */
    $api_status_code     = 1;
    $response['status']  = $api_response_code[$api_status_code]['HTTP Response'];
    $response['message'] = $api_response_code[$api_status_code]['Message'];
    $response['data']    = $cpu_snmp_data;
    
    //$json_response = json_encode($response);
    
} else {
    $api_status_code     = 7;
    $response['status']  = $api_response_code[$api_status_code]['HTTP Response'];
    $response['message'] = $api_response_code[$api_status_code]['Message'];
    //$json_response       = json_encode($response);
}
/* Deliver results */
header('HTTP/1.1 ' . $response['status'] . ' ' . $http_response_code[$response['status']]);
header('Content-Type: application/json; charset=utf-8');
$json_response = json_encode($response, JSON_NUMERIC_CHECK);
echo $json_response;

?>