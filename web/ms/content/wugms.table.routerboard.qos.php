<?php
/* Start session */
session_start();
/* If someone is posting this as empty and there is no username set then do not run */

    #Include the connect.php file
    require($_SERVER['DOCUMENT_ROOT'] . '/auth/config.php');
    /* Init the vars */
    $wugms_chart_qos_row = '';
    $outp                = '';
    
	if (isset($_GET['type'])) {
		$bytes = "FORMAT(x.latest_bytes - y.previous_bytes,0)";
	} else {
		$bytes = "x.latest_bytes - y.previous_bytes";
	}
		
    
    $wugms_chart_qos_query = "
SELECT x.latest_flow 'flow',
		" . $bytes . " 'bytes',
       FORMAT(x.latest_packets - y.previous_packets, 0) 'packets',
       FORMAT(x.latest_hcbytes - y.previous_hcbytes, 0) 'hcbytes',
       FORMAT(x.latest_pcqqueues - y.previous_pcqqueues, 0) 'pcqqueues',
       FORMAT(x.latest_dropped - y.previous_dropped, 0) 'dropped'
  FROM (SELECT a.Flow 'latest_flow',
               sum(a.Bytes) 'latest_bytes',
               sum(a.Packets) 'latest_packets',
               sum(a.HCBytes) 'latest_hcbytes',
               sum(a.PCQQueues) 'latest_pcqqueues',
               sum(a.Dropped) 'latest_dropped'
          FROM wugms.tbl_base_snmp_mikrotik_queuetree_now a
         WHERE a.Flow <> ''
        GROUP BY a.flow
        ORDER BY a.flow) x,
       (SELECT a.Flow 'previous_flow',
               sum(a.Bytes) 'previous_bytes',
               sum(a.Packets) 'previous_packets',
               sum(a.HCBytes) 'previous_hcbytes',
               sum(a.PCQQueues) 'previous_pcqqueues',
               sum(a.Dropped) 'previous_dropped'
          FROM wugms.tbl_base_snmp_mikrotik_queuetree a,
               (SELECT max(a.rdate) 'previous_rdate',
                       a.IPAddressStr 'previous_ip'
                  FROM tbl_base_snmp_mikrotik_queuetree a,
                       (SELECT max(rdate) 'latest', IPAddressStr
                          FROM tbl_base_snmp_mikrotik_queuetree_now
                        GROUP BY IPAddressStr) b
                 WHERE     a.rdate <> b.latest
                       AND a.IPAddressStr = b.IPAddressStr
                GROUP BY a.IPAddressStr) z
         WHERE     a.Flow <> ''
               AND z.previous_rdate = a.RDate
               AND z.previous_ip = a.IPAddressStr
        GROUP BY a.flow
        ORDER BY a.flow) y
 WHERE x.latest_flow = y.previous_flow;";
    
    $wugms_chart_qos_stmt = $db->prepare($wugms_chart_qos_query);
    if ($wugms_chart_qos_stmt->execute()) {
        $wugms_chart_qos_row = $wugms_chart_qos_stmt->fetchAll();
    }

//    $result = array();
    if ($wugms_chart_qos_row) {
		if (isset($_GET['type'])) {
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
			echo ($outp);
		} else {	
			$series1         = array();
			foreach ($wugms_chart_qos_row as $x) {
				$row[0] = $x['flow'];
				$row[1] = $x['bytes'];
				array_push($series1,$row);
				}
			/* Export the data */
				print json_encode($series1, JSON_NUMERIC_CHECK);					
				}
		}

?>