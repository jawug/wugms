<?php

session_start();
require($_SERVER['DOCUMENT_ROOT'] . '/auth/config.php');
require($_SERVER['DOCUMENT_ROOT'] . '/content/functions.php');

/* Default interval setting */
$interval      = "5min";
$start_date    = "";
$end_date      = "";
$date_selection   = "";
$storage_snmp_data = '[{"name" : "main memory", "data" : []}, {"name" : "system disk","data" : []}]';


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
/*    $snmp_storage_query  = "
	SELECT c.idate, c.Serial_Number, CONCAT('CPU ',c.CPU_ID ) as cpuid, c.Reading
		FROM tbl_summary_snmp_common_storage_$interval c
		WHERE c.RDate >= '$start_date'
		and   c.RDate <  '$end_date'
		and c.Serial_Number = :rb_sn;"; */
    $snmp_storage_query  = "
SELECT a.idate,
       a.Serial_Number,
       a.description,
       free_percentage AS store_free_per
  FROM tbl_summary_snmp_common_storage_$interval a
		$date_selection
       AND a.Serial_Number = :rb_sn
       AND a.Description IS NOT NULL
ORDER BY a.RDate;";		
    $series1         = array();
    $series1['name'] = 'Reading';
    
    /* Assign the variables to the parameters */
    $snmp_storage_query_params = array(
        ':rb_sn' => $_SESSION["rb_sn"]
    );
	
    /* Execute the SQL query */
    $snmp_storage_stmt = $db->prepare($snmp_storage_query);
    if ($snmp_storage_stmt->execute($snmp_storage_query_params)) {
        $snmp_storage_row = $snmp_storage_stmt->fetchAll();
    }
	
    /* Works through the results and get them into an array */
    if ($snmp_storage_row) {
        foreach ($snmp_storage_row as $x) {
            $res[$x['description']][] = array(
                $x['idate'],
                $x['store_free_per']
            );
        }
        foreach ($res as $k => $i) {
            $tmp['name'] = $k;
            $tmp['data'] = $i;
            $result[]    = $tmp;
        }
        $storage_snmp_data = $result;
        //		$storage_snmp_data = json_encode($result, JSON_NUMERIC_CHECK);
    }
    /* Set vars to delivery */
    $api_status_code     = 1;
    $response['status']  = $api_response_code[$api_status_code]['HTTP Response'];
    $response['message'] = $api_response_code[$api_status_code]['Message'];
    $response['data']    = $storage_snmp_data;
    
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