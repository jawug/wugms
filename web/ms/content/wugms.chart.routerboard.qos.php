<?php
/* Start session */
session_start();
/* If someone is posting this as empty and there is no username set then do not run */

#Include the connect.php file
require($_SERVER['DOCUMENT_ROOT'] . '/auth/config.php');
/* Init the vars */
$wugms_chart_qos_row = '';
$outp                = '';
$data_format         = '';
$data_select         = '';
$qos_snmp_data       = '[{"name" : "Flow_1","data" : []}, {"name" : "Flow_2","data" : []}]';

if (isset($_GET['type'])) {
    $data_format = strtoupper($_GET['type']);
}

switch ($data_format) {
    case "CHART":
        $data_select = '1';
        $bytes       = "if(sum(x.bytes) = 0,1,sum(x.bytes))";
        break;
    case "TABLE":
        $data_select = '2';
        $bytes       = "FORMAT(sum(x.bytes),0)";
        break;
    case "HOUR":
        $data_select = '3';
        $bytes       = "FORMAT(sum(x.bytes),0)";
        break;
    default:
        $data_select = '';
}

if (($data_format != '') && ($data_select != '')) {
    
    switch ($data_select) {
        /* Set the parameters for chart data request */
        case "1":
            
            $wugms_chart_qos_query = "SELECT a.idate, a.flow, a.bytes
  FROM tbl_summary_snmp_mikrotik_queuetree_overview_60min a
 WHERE     a.RDate >= DATE_FORMAT(now() - INTERVAL 24 HOUR, '%Y-%m-%d %H:00:00')
       AND a.RDate < now()
ORDER BY a.idate, a.flow;";
            
            break;
        case "2":
            /* Set the parameters for table data request */
            
            $wugms_chart_qos_query = "
SELECT x.flow,
       FORMAT(sum(x.bytes), 0) 'bytes',
       FORMAT(sum(x.packets), 0) 'packets',
       FORMAT(sum(x.hcbytes), 0) 'hcbytes',
       FORMAT(sum(x.pcqqueues), 0) 'pcqqueues',
       FORMAT(sum(x.dropped), 0) 'dropped'
  FROM (SELECT a.flow,
               a.bytes,
               a.packets,
               a.hcbytes,
               a.pcqqueues,
               a.dropped
          FROM tbl_summary_snmp_mikrotik_queuetree_overview_60min a
         WHERE     a.RDate >=
                      DATE_FORMAT(now() - INTERVAL 24 HOUR,
                                  '%Y-%m-%d %H:00:00')
               AND a.RDate < now()) AS x
GROUP BY x.Flow
ORDER BY x.flow;";
            break;
        case "3":
            /* Set the parameters for table data request */
            
            $wugms_chart_qos_query = "
SELECT x.flow,
       FORMAT(sum(x.bytes), 0) 'bytes',
       FORMAT(sum(x.packets), 0) 'packets',
       FORMAT(sum(x.hcbytes), 0) 'hcbytes',
       FORMAT(sum(x.pcqqueues), 0) 'pcqqueues',
       FORMAT(sum(x.dropped), 0) 'dropped'
  FROM (SELECT a.flow,
               a.bytes,
               a.packets,
               a.hcbytes,
               a.pcqqueues,
               a.dropped
          FROM tbl_summary_snmp_mikrotik_queuetree_overview_60min a,
               (SELECT max(rdate) AS last
                  FROM tbl_summary_snmp_mikrotik_queuetree_overview_60min)
               AS b
         WHERE a.RDate = b.last) AS x
GROUP BY x.Flow
ORDER BY x.flow;";
            break;
        default:
            $outp = '';
    }
    
    $wugms_chart_qos_stmt = $db->prepare($wugms_chart_qos_query);
    if ($wugms_chart_qos_stmt->execute()) {
        $wugms_chart_qos_row = $wugms_chart_qos_stmt->fetchAll();
    }
    
    /* If there is data returned then we work with that */
    if ($wugms_chart_qos_row) {
        switch ($data_select) {
            /* Set the parameters for chart data request */
            case "1":
                /* Works through the results and get them into an array */
                foreach ($wugms_chart_qos_row as $x) {
                    $res[$x['flow']][] = array(
                        $x['idate'],
                        $x['bytes']
                    );
                }
                foreach ($res as $k => $i) {
                    $tmp['name'] = $k;
                    $tmp['data'] = $i;
                    $result[]    = $tmp;
                }
                $qos_snmp_data = json_encode($result, JSON_NUMERIC_CHECK);
                break;
            case "2":
                $outp = "[";
                foreach ($wugms_chart_qos_row as $x) {
                    if ($outp != "[") {
                        $outp .= ",";
                    }
                    $outp .= '{"flow":"' . $x["flow"] . '",';
                    $outp .= '"bytes":"' . $x["bytes"] . '",';
                    $outp .= '"packets":"' . $x["packets"] . '",';
                    $outp .= '"hcbytes":"' . $x["hcbytes"] . '",';
                    $outp .= '"pcqqueues":"' . $x["pcqqueues"] . '",';
                    $outp .= '"dropped":"' . $x["dropped"] . '"}';
                    
                }
                $outp .= "]";
                $qos_snmp_data = $outp;
                break;
            case "3":
                $outp = "[";
                foreach ($wugms_chart_qos_row as $x) {
                    if ($outp != "[") {
                        $outp .= ",";
                    }
                    $outp .= '{"flow":"' . $x["flow"] . '",';
                    $outp .= '"bytes":"' . $x["bytes"] . '",';
                    $outp .= '"packets":"' . $x["packets"] . '",';
                    $outp .= '"hcbytes":"' . $x["hcbytes"] . '",';
                    $outp .= '"pcqqueues":"' . $x["pcqqueues"] . '",';
                    $outp .= '"dropped":"' . $x["dropped"] . '"}';
                    
                }
                $outp .= "]";
                $qos_snmp_data = $outp;
                break;
            default:
                $qos_snmp_data = '';
        }
    }
}
echo $qos_snmp_data;
?>