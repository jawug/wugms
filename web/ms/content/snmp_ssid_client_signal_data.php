<?php
 
session_start();
require($_SERVER['DOCUMENT_ROOT'] . '/auth/config.php');
require($_SERVER['DOCUMENT_ROOT'] . '/content/functions.php');

/* Default interval setting */
$interval                = "5min";
$start_date              = "";
$end_date                = "";
$date_selection          = "";
$client_signal_snmp_data = "";

/* check if the session vars are set */
/* required vars: user_id and rb_sn */

if ((isset($_SESSION["id"])) && (isset($_SESSION["ov_ssid_sn"])) && (isset($_SESSION["ov_ssid_id"]))) {
    /* Dates */
    /* If the dates are set to "0" then we use default dates */
    /* default: interval of 5min means last 12 hours */
    /* default: interval of 60min means last 12 days */
    /* default: interval of day means last 12 weeks */
    if ((isset($_SESSION["rb_start_date"])) && (isset($_SESSION["rb_end_date"]))) {
        /* yes yes */
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
            $interval       = "5min";
            $date_selection = "WHERE c.RDate >= DATE_FORMAT('$start_date', '%Y/%m/%d %H:%i:%s') and c.RDate <= DATE_FORMAT('$end_date', '%Y/%m/%d %H:%i:00')";
            
        } else if ($_SESSION["rb_interval"] === "60min") {
            $interval       = "60min";
            $date_selection = "WHERE c.RDate >= DATE_FORMAT('$start_date', '%Y/%m/%d %H:00:00') and c.RDate <= DATE_FORMAT('$end_date', '%Y/%m/%d %H:00:00')";
            
        } else if ($_SESSION["rb_interval"] === "day") {
            $interval       = "day";
            $date_selection = "WHERE c.RDate >= DATE_FORMAT('$start_date', '%Y/%m/%d 00:00:00') and c.RDate <= DATE_FORMAT('$end_date', '%Y/%m/%d 00:00:00')";
            
        } else {
            $interval       = "5min";
            $date_selection = "WHERE c.RDate >= DATE_FORMAT('$start_date', '%Y/%m/%d %H:%i:%s') and c.RDate <= DATE_FORMAT('$end_date', '%Y/%m/%d %H:%i:00')";
        }
    }
    
    /* Now that we have done our checks we must get the data */
    $client_signal_snmp_query = "
SELECT cli_tx_signal.*
  FROM (SELECT apc.idate,
               CONCAT(apc.MAC_Addr, '-', 'TX') AS client,
               apc.TxStrengthCh0 AS 'reading'
          FROM tbl_summary_snmp_mikrotik_ap_clients_signal_5min apc
         WHERE     apc.rdate > now() - INTERVAL 24 HOUR
               AND apc.Serial_Number = :rb_sn
               AND apc.AP_ID = :ssid_id
        ORDER BY apc.rdate) AS cli_tx_signal
UNION
SELECT cli_rx_signal.*
  FROM (SELECT apc.idate,
               CONCAT(apc.MAC_Addr, '-', 'RX') AS client,
               apc.RxStrengthCh0 AS 'reading'
          FROM tbl_summary_snmp_mikrotik_ap_clients_signal_5min apc
         WHERE     apc.rdate > now() - INTERVAL 24 HOUR
               AND apc.Serial_Number = :rb_sn
               AND apc.AP_ID = :ssid_id
        ORDER BY apc.rdate) AS cli_rx_signal
ORDER BY idate, client;";
    
    $series1         = array();
    $series1['name'] = 'reading';
    
    /* Assign the variables to the parameters */
    /* $_SESSION["ov_ssid_id"]   = $x["AP_ID"];
    $_SESSION["ov_ssid_name"] = $_POST["ov_ssid_name"];
    $_SESSION["ov_ssid_sn"]   = $_POST["ov_ssid_sn"]; */
    $client_signal_snmp_query_params = array(
        ':rb_sn' => $_SESSION["ov_ssid_sn"],
        ':ssid_id' => $_SESSION["ov_ssid_id"]
    );
    
    /* Execute the SQL query */
    $client_signal_snmp_stmt = $db->prepare($client_signal_snmp_query);
    if ($client_signal_snmp_stmt->execute($client_signal_snmp_query_params)) {
        $client_signal_snmp_row = $client_signal_snmp_stmt->fetchAll();
    }
    //                $x['TxStrengthCh0'],	
    /* Works through the results and get them into an array */
    if ($client_signal_snmp_row) {
        foreach ($client_signal_snmp_row as $x) {
            $res[$x['client']][] = array(
                $x['idate'],
                $x['reading']
            );
        }
        foreach ($res as $k => $i) {
            $tmp['name'] = $k;
            $tmp['data'] = $i;
            $result[]    = $tmp;
        }
        $client_signal_snmp_data = $result;
        //		$client_signal_snmp_data = json_encode($result, JSON_NUMERIC_CHECK);
    }
    /* Set vars to delivery */
    $api_status_code     = 1;
    $response['status']  = $api_response_code[$api_status_code]['HTTP Response'];
    $response['message'] = $api_response_code[$api_status_code]['Message'];
    $response['data']    = $client_signal_snmp_data;
    
    //$json_response = json_encode($response);
    
} else {
    $api_status_code     = 7;
    $response['status']  = $api_response_code[$api_status_code]['HTTP Response'];
    $response['message'] = $api_response_code[$api_status_code]['Message'];
}
/* Deliver results */
header('HTTP/1.1 ' . $response['status'] . ' ' . $http_response_code[$response['status']]);
header('Content-Type: application/json; charset=utf-8');
$json_response = json_encode($response, JSON_NUMERIC_CHECK);
echo $json_response;

?>