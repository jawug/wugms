<?php
/* init and include the required items */
session_start();
require($_SERVER['DOCUMENT_ROOT'] . '/auth/config.php');
require($_SERVER['DOCUMENT_ROOT'] . '/content/functions.php');

/*
$type = "";
if (isset($_GET['type'])) {
    $type = $_GET['type'];
    */


$interval = "";
if (isset($_GET['interval'])) {
    $interval = $_GET['interval'];
	
    /* AS we are using two series in order to display data we need to setup and config them */
    $series1         = array();
    $series1['name'] = 'Tx';
    
    $series2             = array();
    $series2['name']     = 'Rx';
    $snmp_interfaces_row = '';        
    
    if ($interval == "day") {
        $snmp_interfaces_query = "SELECT a.idate, rx_bytes_calc AS rx_bps, tx_bytes_calc AS tx_bps
  FROM tbl_summary_snmp_common_interfaces_day a
 WHERE     (a.RDate BETWEEN (NOW() - INTERVAL 30 day)
                        AND NOW())
       AND a.serial_number = :rb_sn
       AND a.Iface_ID = :rb_iface";
    } elseif ($interval == "60min") {
        $snmp_interfaces_query = "SELECT a.idate, rx_bytes_calc AS rx_bps, tx_bytes_calc AS tx_bps
  FROM tbl_summary_snmp_common_interfaces_60min a
 WHERE     (a.RDate BETWEEN (NOW() - INTERVAL 7 day)
                        AND NOW())
       AND a.serial_number = :rb_sn
       AND a.Iface_ID = :rb_iface;";
    } else {
        $snmp_interfaces_query = "SELECT a.idate, rx_bytes_calc AS rx_bps, tx_bytes_calc AS tx_bps
  FROM tbl_summary_snmp_common_interfaces_5min a
 WHERE     (a.RDate BETWEEN (NOW() - INTERVAL 12 hour)
                        AND NOW())
       AND a.serial_number = :rb_sn
       AND a.Iface_ID = :rb_iface;";
    }  
//	SELECT DATE_FORMAT(now()- INTERVAL 1 hour,'%Y-%m-%d %H:00:00') AS rdate from dual;
    
/*    $snmp_interfaces_query = "
SELECT (UNIX_TIMESTAMP(a.rdate) + 7200) * 1000 'idate',
       Round((b.InOctets - a.InOctets) / 300, 0) AS rx_bps,
       Round((b.OutOctets - a.OutOctets) / 300, 0) AS tx_bps,
                    Round((b.InUcastPkts - a.InUcastPkts) / 300, 0) AS rx_pps,
                    Round((b.OutUcastPkts - a.OutUcastPkts) / 300, 0) AS tx_pps 
  FROM (SELECT RDate,
               serial_number,
               ID,
               InOctets,
               InUcastPkts,
               OutOctets,
               OutUcastPkts
          FROM tbl_base_snmp_common_interfaces
         WHERE     (RDate BETWEEN (NOW() - INTERVAL 2 DAY)
                              AND (NOW() - INTERVAL 10 MINUTE))
               AND serial_number = :rb_sn
               AND id = :rb_iface
               AND InOctets IS NOT NULL
               AND OutOctets IS NOT NULL
               AND InOctets <> 0
               AND OutOctets <> 0) a
       INNER JOIN
       (SELECT RDate,
               serial_number,
               ID,
               InOctets,
               InUcastPkts,
               OutOctets,
               OutUcastPkts
          FROM tbl_base_snmp_common_interfaces
         WHERE     (RDate BETWEEN (DATE_ADD(NOW(), INTERVAL -2 DAY))
                              AND (NOW() - INTERVAL 10 MINUTE))
               AND serial_number = :rb_sn
               AND id = :rb_iface
               AND InOctets IS NOT NULL
               AND OutOctets IS NOT NULL
               AND InOctets <> 0
               AND OutOctets <> 0) b
          ON a.RDate = b.RDate - INTERVAL 5 MINUTE
 WHERE b.InOctets > a.InOctets AND b.OutOctets > a.OutOctets;";*/
/*    $snmp_interfaces_query = "SELECT a.idate,
       Round(a.rx_bytes_diff / 300, 0) AS rx_bps,
       Round(a.tx_bytes_diff / 300, 0) AS tx_bps,
       Round(a.rx_packets_diff / 300, 0) AS rx_pps,
       Round(a.tx_packets_diff / 300, 0) AS tx_pps
  FROM tbl_summary_snmp_common_interfaces_5min a
 WHERE     (a.RDate BETWEEN (DATE_ADD(NOW(), INTERVAL -7 DAY))
                      AND (NOW() - INTERVAL 10 MINUTE))
       AND a.serial_number = :rb_sn
       AND a.Iface_ID = :rb_iface;";    
    */
    /* Sanitise the parameters */
    if (isset($_SESSION["rb_sni"]) && isset($_SESSION["rb_iface"])) {
        $snmp_interfaces_query_params = array(
            ':rb_sn' => $_SESSION["rb_sni"],
            ':rb_iface' => $_SESSION["rb_iface"]
        );
        /* Excute the SQL query */
        $snmp_interfaces_stmt         = $db->prepare($snmp_interfaces_query);
        if ($snmp_interfaces_stmt->execute($snmp_interfaces_query_params)) {
            $snmp_interfaces_row = $snmp_interfaces_stmt->fetchAll();
        }
    }
    
    
/*    if ($type == "bytes") {*/
        if ($snmp_interfaces_row) {
            /* If the type that was selected was bytes then return the bytes per second values */
            foreach ($snmp_interfaces_row as $x) {
                $series1['data'][] = array(
                    $x['idate'],
                    $x['tx_bps']
                );
                $series2['data'][] = array(
                    $x['idate'],
                    $x['rx_bps']
                );
                $result            = array();
                array_push($result, $series1);
                array_push($result, $series2);
            }
            print json_encode($result, JSON_NUMERIC_CHECK);
        } else {
            $series1['data'][] = array();
            $series2['data'][] = array();
            $result            = array();
            array_push($result, $series1);
            array_push($result, $series2);
            
            print json_encode($result, JSON_NUMERIC_CHECK);
        }
   /* } elseif ($type == "packets") {
        if ($snmp_interfaces_row) {

            foreach ($snmp_interfaces_row as $x) {
                $series1['data'][] = array(
                    $x['idate'],
                    $x['tx_pps']
                );
                $series2['data'][] = array(
                    $x['idate'],
                    $x['rx_pps']
                );
                $result            = array();
                array_push($result, $series1);
                array_push($result, $series2);
            }
            print json_encode($result, JSON_NUMERIC_CHECK);
        } else {
            $series1['data'][] = array();
            $series2['data'][] = array();
            $result            = array();
            array_push($result, $series1);
            array_push($result, $series2);
            
            print json_encode($result, JSON_NUMERIC_CHECK);
        }
    } else {
        $series1['data'][] = array();
        $series2['data'][] = array();
        $result            = array();
        array_push($result, $series1);
        array_push($result, $series2);
        
        print json_encode($result, JSON_NUMERIC_CHECK);
    }*/
}
/*}*/
?>