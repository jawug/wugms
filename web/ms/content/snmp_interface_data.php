<?php

session_start();
require($_SERVER['DOCUMENT_ROOT'] . '/auth/config.php');
require($_SERVER['DOCUMENT_ROOT'] . '/content/functions.php');

/* Default interval setting */
$interval            = "5min";
$start_date          = "";
$end_date            = "";
$interface_snmp_data = '[{"name" : "Tx","data" : []}, {"name" : "Rx","data" : []}]';
$series1             = array();
$series1['name']     = 'Tx';
$series2             = array();
$series2['name']     = 'Rx';

/* check if the session vars are set */
/* required vars: user_id and rb_iface_sn */
//echo "no";
//echo $_SESSION["id"];
//echo $_SESSION["rb_iface_sn"];
//echo $_SESSION["rb_iface_sel"];
if ((isset($_SESSION["id"])) && (isset($_SESSION["rb_iface_sn"])) && (isset($_SESSION["rb_iface_sel"]))) {
    //	echo "yes";

	
	/* Get the data type request */
	if (isset($_GET['dtype'])) {
		/* If the dtype parameter is set then try and see if it is a valid selection */
		$dtype = $_GET['dtype'];
		/* There are three types of selections */
		/* speed: this the data transfer rate per second */
		/* packet: this packets per second */
		/* data: this the data transferred per interval */
		if ($dtype == 'speed') {
			$data_sel = 'speed';
		} else if ($dtype == 'packet') {
			$data_sel = 'packet';
		} else if ($dtype == 'data') {
			$data_sel = 'data';
		} else {
			$data_sel = 'speed';
		}
	} else {
		/* The default value is speed */
		$data_sel = 'speed';
	}
	
    /* Dates */
    /* If the dates are set to "0" then we use default dates */
    /* default: interval of 5min means last 12 hours */
    /* default: interval of 60min means last 12 days */
    /* default: interval of day means last 12 weeks */
    if ((isset($_SESSION["rb_iface_start_date"])) && (isset($_SESSION["rb_iface_end_date"]))) {
        /* yes yes */
        //function StartEndDateCompare($sdate, $edate, $interval)	
        $snmp_cp_dates = StartEndDateCompare($_SESSION["rb_iface_start_date"], $_SESSION["rb_iface_end_date"], $interval);
    } else if ((isset($_SESSION["rb_iface_start_date"])) && (!isset($_SESSION["rb_iface_end_date"]))) {
        /* yes no */
        $snmp_cp_dates = StartEndDateCompare($_SESSION["rb_iface_start_date"], 0, $interval);
    } else if ((!isset($_SESSION["rb_iface_start_date"])) && (isset($_SESSION["rb_iface_end_date"]))) {
        /* no yes */
        $snmp_cp_dates = StartEndDateCompare(0, $_SESSION["rb_iface_end_date"], $interval);
    } else {
        /* no no */
        $snmp_cp_dates = StartEndDateCompare(0, 0, $interval);
    }
    /* Set the dates as per the returned values */
    $start_date = $snmp_cp_dates['start'];
    $end_date   = $snmp_cp_dates['end'];

    /* Check what the interval is set to and make if need be set a default */
    if (isset($_SESSION["rb_iface_interval"])) {
        if ($_SESSION["rb_iface_interval"] === "5min") {
            $interval = "5min";
			$date_selection ="WHERE RDate >= DATE_FORMAT('$start_date', '%Y/%m/%d %H:%i:%s') and RDate <= DATE_FORMAT('$end_date', '%Y/%m/%d %H:%i:00')";
        } else if ($_SESSION["rb_iface_interval"] === "60min") {
            $interval = "60min";
			$date_selection ="WHERE RDate >= DATE_FORMAT('$start_date', '%Y/%m/%d %H:00:00') and RDate <= DATE_FORMAT('$end_date', '%Y/%m/%d %H:00:00')";
        } else if ($_SESSION["rb_iface_interval"] === "day") {
            $interval = "day";
			$date_selection ="WHERE RDate >= DATE_FORMAT('$start_date', '%Y/%m/%d 00:00:00') and RDate <= DATE_FORMAT('$end_date', '%Y/%m/%d 00:00:00')";
        } else {
            $interval = "5min";
			$date_selection ="WHERE RDate >= DATE_FORMAT('$start_date', '%Y/%m/%d %H:%i:%s') and RDate <= DATE_FORMAT('$end_date', '%Y/%m/%d %H:%i:00')";
        }
    }
    
	/* SQL selections based on the parameters */
	if ($interval == "5min") {
		if ($data_sel == 'speed') {
			$sql_sel =" rx_bytes_calc AS rx_data, tx_bytes_calc AS tx_data";
		} else if ($data_sel == 'packet') {
			$sql_sel =" rx_packets_calc AS rx_data, tx_packets_calc AS tx_data";
		} else if ($data_sel == 'data') {
			$sql_sel =" rx_bytes_diff AS rx_data, tx_bytes_diff AS tx_data";
		}
	} else {
		if ($data_sel == 'speed') {
			$sql_sel =" rx_bytes_calc AS rx_data, tx_bytes_calc AS tx_data";
		} else if ($data_sel == 'packet') {
			$sql_sel =" rx_packets_calc AS rx_data, tx_packets_calc AS tx_data";
		} else if ($data_sel == 'data') {
			$sql_sel =" rx_bytes_sum AS rx_data, tx_bytes_sum AS tx_data";
		}
	}

	
	
    /* Now that we have done our checks we must get the data */

		
    $snmp_interface_query  = "		
SELECT idate, $sql_sel
  FROM tbl_summary_snmp_common_interfaces_$interval
$date_selection
       AND Serial_Number = :rb_iface_sn
       AND Iface_ID = :rb_iface_sel; ";	
		
/////    $series1         = array();
/////    $series1['name'] = 'Reading';
    
    /* Assign the variables to the parameters */
    $snmp_interface_query_params = array(
        ':rb_iface_sn' => $_SESSION["rb_iface_sn"],
		':rb_iface_sel' => $_SESSION["rb_iface_sel"]
    );
	
    /* Execute the SQL query */
    $snmp_interface_stmt = $db->prepare($snmp_interface_query);
    if ($snmp_interface_stmt->execute($snmp_interface_query_params)) {
        $snmp_interface_row = $snmp_interface_stmt->fetchAll();
    }
	
    /* Works through the results and get them into an array */
    if ($snmp_interface_row) {
/*        foreach ($snmp_interface_row as $x) {
            $res[$x['cpuid']][] = array(
                $x['idate'],
                $x['Reading']
            );
        }
        foreach ($res as $k => $i) {
            $tmp['name'] = $k;
            $tmp['data'] = $i;
            $result[]    = $tmp;
        }
        $cpu_snmp_data = $result;
    } */
		foreach ($snmp_interface_row as $x) {
			$series1['data'][] = array(
				$x['idate'],
				$x['tx_data']
			);
			$series2['data'][] = array(
				$x['idate'],
				$x['rx_data']
			);
			$result            = array();
			array_push($result, $series1);
			array_push($result, $series2);
			$interface_snmp_data = $result;
            }
		}
    /* Set vars to delivery */
    $api_status_code     = 1;
    $response['status']  = $api_response_code[$api_status_code]['HTTP Response'];
    $response['message'] = $api_response_code[$api_status_code]['Message'];
    $response['data']    = $interface_snmp_data;
    
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