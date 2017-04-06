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
    //$user_ip = '172.16.250.127';
	$user_ip = '';
}
if (isset($_GET['sel_area'])) {
    $flow = $_GET['sel_area'];
} else {
    $flow = 'SNMP';
	//$flow = '';
}
/*
$wugms_chart_qos_query = "
SELECT (UNIX_TIMESTAMP(curr.curr_fdate) + 7200) * 1000 'idate',
       curr.curr_name,
       if(curr.curr_bytes >= prev.prev_bytes,
          curr.curr_bytes - prev.prev_bytes,
          curr.curr_bytes)
          'bytes'
  FROM (SELECT DATE_FORMAT(l.RDate, '%Y-%m-%d %H:30:00') 'curr_fdate',
               l.Name 'curr_name',
               l.Bytes 'curr_bytes'
          FROM tbl_base_snmp_mikrotik_queuetree l
         WHERE     l.RDate > SUBdate(NOW(), interval 7 day)
               AND l.IPAddressStr = :user_ip
               AND l.Flow = :flow_type
        ORDER BY l.rdate, l.name) curr
       INNER JOIN
       (SELECT DATE_FORMAT(l.RDate, '%Y-%m-%d %H:30:00') 'prev_fdate',
               l.Name 'prev_name',
               l.Bytes 'prev_bytes'
          FROM tbl_base_snmp_mikrotik_queuetree l
         WHERE     l.RDate > SUBdate(NOW(), interval 7 day)
               AND l.IPAddressStr = :user_ip
               AND l.Flow = :flow_type
        ORDER BY l.rdate, l.name) prev
          ON curr.curr_fdate = adddate(prev.prev_fdate, interval 1 hour)
 WHERE curr.curr_name = prev.prev_name
ORDER BY curr.curr_name, curr.curr_fdate ;
"; */

$wugms_chart_qos_query = "
SELECT (UNIX_TIMESTAMP(curr.qdate) + 7200) * 1000 'idate',
       curr.name,
       if(curr.bytes >= prev.bytes, curr.bytes - prev.bytes, curr.bytes)
          'bytes'
  FROM (SELECT DATE_FORMAT(l.RDate, '%Y-%m-%d %H:00:00') 'qdate',
               l.Name 'name',
               l.Bytes 'bytes'
          FROM tbl_base_snmp_mikrotik_queuetree l
         WHERE     l.RDate > NOW() - INTERVAL 7 DAY
          and     l.RDate < DATE_FORMAT(NOW(), '%Y-%m-%d %H:00:00')
               AND l.IPAddressStr = :user_ip
               AND l.Flow = :flow_type
        ORDER BY l.rdate, l.name) curr
       INNER JOIN
       (SELECT DATE_FORMAT(l.RDate, '%Y-%m-%d %H:00:00') 'qdate',
               l.Name 'name',
               l.Bytes 'bytes'
          FROM tbl_base_snmp_mikrotik_queuetree l
         WHERE     l.RDate >= NOW() - INTERVAL 7 DAY
         and     l.RDate < DATE_FORMAT(NOW(), '%Y-%m-%d %H:00:00')
               AND l.IPAddressStr = :user_ip
               AND l.Flow = :flow_type
        ORDER BY l.rdate, l.name) prev
          ON curr.qdate = (prev.qdate + INTERVAL 1 HOUR)
 WHERE curr.name = prev.name
ORDER BY curr.name, curr.qdate;";

$snmp_chart_qos_query_params = array(
    ':user_ip' => $user_ip,
	':flow_type' => $flow
);

/* Default value */
$outp = "[{\"name\":\"nothing\",\"data\":[[1425915000000,0]]}]";

/* Excute the SQL query */
$wugms_chart_qos_stmt = $db->prepare($wugms_chart_qos_query);
if ($wugms_chart_qos_stmt->execute($snmp_chart_qos_query_params)) {
    $wugms_chart_qos_row = $wugms_chart_qos_stmt->fetchAll();
}
$series1 = array();
//    $result = array();
if ($wugms_chart_qos_row) {
    if ($user_ip <> '') {
		$rows = array();
		$d=array();
        foreach ($wugms_chart_qos_row as $x) {
			/* Loop through the data and insert it in to the array */
                /*$series1['data'][] = array(
                    $x['idate'],
                    $x['bytes']
                );
                $result            = array();
                array_push($result, $series1);*/
//				$rows['name'][$x['curr_name']][$x['idate']][]=$x['bytes'];
//				$series1['name'][$x['curr_name']]['data'] = array($x['idate'],$x['bytes']);
//				$series1['name'][]=array($x['curr_name'], array($x['idate'],$x['bytes']));
				//$series1['name']=$x['curr_name']=array($x['idate'],$x['bytes']);
				//$result            = array();
//                array_push($result, $series1);
			$res[$x['name']][] =  array($x['idate'], $x['bytes']);
			}
			foreach ($res as $k=>$i) {
				$tmp['name']=$k;
				$tmp['data']=$i;
				$result[] = $tmp;
				}
		/* post the data */
		print json_encode($result, JSON_NUMERIC_CHECK);

        } else {
		    /* Send default output */
    echo $outp;
		}
    
} else {
    /* Send default output */
    echo $outp;
}

?>