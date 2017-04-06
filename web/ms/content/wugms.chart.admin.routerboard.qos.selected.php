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
    $bytes = "FORMAT(sum(a.Bytes),0)";
} else {
    $bytes = "sum(a.Bytes)";
}


if (isset($_GET['sel_ip'])) {
    $user_ip = $_GET['sel_ip'];
} else {
    /*$user_ip = '172.16.250.127';*/
	$user_ip = '';
}

/*$wugms_chart_qos_query = "
SELECT l.latest_date 'date',
       l.latest_flow 'flow',
       l.latest_bytes - p.previous_bytes 'bytes'
  FROM (SELECT a.rdate 'latest_date',
               a.Flow 'latest_flow',
               sum(a.Bytes) 'latest_bytes'
          FROM wugms.tbl_base_snmp_mikrotik_queuetree_now a
         WHERE a.Flow <> '' AND a.IPAddressStr = :user_ip
        GROUP BY a.flow
        ORDER BY a.flow) AS l,
       (SELECT g.RDate 'previous_date',
               g.Flow 'previous_flow',
               sum(g.Bytes) 'previous_bytes'
          FROM tbl_base_snmp_mikrotik_queuetree g,
               (SELECT max(a.rdate) 'previous_rdate',
                       a.IPAddressStr 'previous_ip',
                       b.latest
                  FROM tbl_base_snmp_mikrotik_queuetree a,
                       (SELECT max(rdate) 'latest', IPAddressStr
                          FROM tbl_base_snmp_mikrotik_queuetree_now
                         WHERE IPAddressStr = :user_ip) b
                 WHERE a.rdate < b.latest AND a.IPAddressStr = b.IPAddressStr
                ORDER BY a.rdate) z
         WHERE     g.flow <> ''
               AND z.previous_rdate = g.RDate
               AND z.previous_ip = g.IPAddressStr
        GROUP BY g.flow) AS p
 WHERE l.latest_flow = p.previous_flow;"; */
/*$wugms_chart_qos_query = "
SELECT *
  FROM (SELECT l.latest_flow 'flow',
               if(l.latest_bytes >= p.previous_bytes,
                  l.latest_bytes - p.previous_bytes,
                  l.latest_bytes)
                  'bytes'
          FROM (SELECT a.rdate 'latest_date',
                       concat(a.Flow,'__' ,a.IPAddressStr) 'latest_flow',
                       sum(a.Bytes) 'latest_bytes'
                  FROM wugms.tbl_base_snmp_mikrotik_queuetree_now a
                 WHERE a.Flow <> '' AND a.IPAddressStr = :user_ip
                GROUP BY a.flow
                ORDER BY a.flow) AS l,
               (SELECT g.RDate 'previous_date',
                       concat(g.Flow,'__' ,g.IPAddressStr) 'previous_flow',
                       sum(g.Bytes) 'previous_bytes'
                  FROM tbl_base_snmp_mikrotik_queuetree g,
                       (SELECT max(a.rdate) 'previous_rdate',
                               a.IPAddressStr 'previous_ip',
                               b.latest
                          FROM tbl_base_snmp_mikrotik_queuetree a,
                               (SELECT max(rdate) 'latest', IPAddressStr
                                  FROM tbl_base_snmp_mikrotik_queuetree_now
                                 WHERE IPAddressStr = :user_ip) b
                         WHERE     a.rdate < b.latest
                               AND a.IPAddressStr = b.IPAddressStr
                        ORDER BY a.rdate) z
                 WHERE     g.flow <> ''
                       AND z.previous_rdate = g.RDate
                       AND z.previous_ip = g.IPAddressStr
                GROUP BY g.flow) AS p
         WHERE l.latest_flow = p.previous_flow) y
 WHERE y.bytes > 0;
";*/

$wugms_chart_qos_query = "
SELECT data.flow AS flow, if(data.bytes = 0, 1, data.bytes) AS bytes
  FROM (SELECT l.latest_flow 'flow',
               if(l.latest_bytes >= p.previous_bytes,
                  l.latest_bytes - p.previous_bytes,
                  l.latest_bytes)
                  'bytes'
          FROM (SELECT a.rdate 'latest_date',
                       concat(a.Flow, '__', a.IPAddressStr) 'latest_flow',
                       sum(a.Bytes) 'latest_bytes'
                  FROM wugms.tbl_base_snmp_mikrotik_queuetree a
                 WHERE     a.RDate >=
                              DATE_FORMAT(now() - INTERVAL 1 HOUR,
                                          '%Y-%m-%d %H:00:00')
                       AND a.RDate < DATE_FORMAT(now(), '%Y-%m-%d %H:00:00')
                       AND a.IPAddressStr = :user_ip
                       AND a.Flow <> ''
                GROUP BY a.flow
                ORDER BY a.flow) AS l,
               (SELECT a.rdate 'previous_date',
                       concat(a.Flow, '__', a.IPAddressStr) 'previous_flow',
                       sum(a.Bytes) 'previous_bytes'
                  FROM wugms.tbl_base_snmp_mikrotik_queuetree a
                 WHERE     a.RDate >=
                              DATE_FORMAT(now() - INTERVAL 2 HOUR,
                                          '%Y-%m-%d %H:00:00')
                       AND a.RDate <
                              DATE_FORMAT(now() - INTERVAL 1 HOUR,
                                          '%Y-%m-%d %H:00:00')
                       AND a.IPAddressStr = :user_ip
                       AND a.Flow <> ''
                GROUP BY a.flow
                ORDER BY a.flow) AS p
         WHERE l.latest_flow = p.previous_flow) AS data;
";

$snmp_chart_qos_query_params = array(
    ':user_ip' => $user_ip
);

/* Excute the SQL query */
$wugms_chart_qos_stmt = $db->prepare($wugms_chart_qos_query);
if ($wugms_chart_qos_stmt->execute($snmp_chart_qos_query_params)) {
    $wugms_chart_qos_row = $wugms_chart_qos_stmt->fetchAll();
}
$series1 = array();
//    $result = array();
if ($wugms_chart_qos_row) {
    if ($user_ip <> '') {
        foreach ($wugms_chart_qos_row as $x) {
			/* Loop through the data and insert it in to the array */
            $results[] = array(
                'name' => $x['flow'],
                'y' => $x['bytes']
            );
        }
		/* post the data */
        print json_encode($results, JSON_NUMERIC_CHECK);
    }
    
} else {
    /* placement holder data*/
    $outp = "[[\"No_selection\",1]]";
    echo $outp;
}

?>