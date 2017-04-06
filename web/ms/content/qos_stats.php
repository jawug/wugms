<?php
/* DB connection */
require($_SERVER['DOCUMENT_ROOT'] . '/auth/config.php');
/* This is required for custom branding */
require($_SERVER['DOCUMENT_ROOT'] . '/content/branding.php');
require($_SERVER['DOCUMENT_ROOT'] . '/content/functions.php');

/* Setup the basic SQL query */
/*$wugms_qos_basic_stats_query = "
SELECT max(x.rdate) 'rdate', count(x.current_host) 'samplers'
  FROM (SELECT a.current_hour 'rdate', a.current_host
          FROM (SELECT DATE_FORMAT(a.rdate, '%Y-%m-%d %H:00') 'current_hour',
                       a.IPAddressStr 'current_host'
                  FROM tbl_base_snmp_mikrotik_queuetree a
                 WHERE (a.RDate BETWEEN DATE_FORMAT(now() - INTERVAL 1 HOUR,
                                                    '%Y-%m-%d %H:00:00')
                                    AND DATE_FORMAT(now(),
                                                    '%Y-%m-%d %H:00:00'))
                GROUP BY a.IPAddressStr) AS a,
               (SELECT DATE_FORMAT(a.rdate, '%Y-%m-%d %H:00') 'previous_hour',
                       a.IPAddressStr 'previous_host'
                  FROM tbl_base_snmp_mikrotik_queuetree a
                 WHERE (a.RDate BETWEEN DATE_FORMAT(now() - INTERVAL 2 HOUR,
                                                    '%Y-%m-%d %H:00:00')
                                    AND DATE_FORMAT(now() - INTERVAL 1 HOUR,
                                                    '%Y-%m-%d %H:00:00'))
                GROUP BY a.IPAddressStr) AS b
         WHERE a.current_host = b.previous_host) AS x
GROUP BY x.rdate;;"; */

    $wugms_qos_basic_stats_query = "
SELECT curr.testd 'rdate',

       curr.hosts'samplers'
  FROM (SELECT DATE_FORMAT(a.RDate, '%Y-%m-%d %H:00:00') AS 'testd',
               a.RDate,
               a.IPAddressStr,
               sum(a.bytes) 'bytes',
               c.hosts
          FROM tbl_base_snmp_mikrotik_queuetree a,
               (SELECT count(*) AS hosts
                  FROM (SELECT DISTINCT (a.IPAddressStr)
                          FROM tbl_base_snmp_mikrotik_queuetree a
                         WHERE     a.RDate >= DATE_FORMAT(now() - INTERVAL 1 HOUR, '%Y-%m-%d %H:00:00')
                               AND a.RDate < DATE_FORMAT(now(), '%Y-%m-%d %H:00:00')
                               AND a.flow <> ''
                        GROUP BY a.IPAddressStr) AS c) c
        WHERE     a.RDate >= DATE_FORMAT(now() - INTERVAL 1 HOUR, '%Y-%m-%d %H:00:00')
                               AND a.RDate < DATE_FORMAT(now(), '%Y-%m-%d %H:00:00')
               AND a.flow <> ''
        GROUP BY a.IPAddressStr) AS curr
       LEFT JOIN
       (SELECT DATE_FORMAT(a.RDate, '%Y-%m-%d %H:00:00') AS 'testd',
               a.RDate,
               a.IPAddressStr,
               sum(a.bytes) 'bytes'
          FROM tbl_base_snmp_mikrotik_queuetree a
         WHERE     a.RDate >= DATE_FORMAT(now() - INTERVAL 2 HOUR, '%Y-%m-%d %H:00:00')
               AND a.RDate < DATE_FORMAT(now() - INTERVAL 1 HOUR, '%Y-%m-%d %H:00:00')
               AND a.flow <> ''
        GROUP BY a.IPAddressStr) AS prev
          ON curr.IPAddressStr = prev.IPAddressStr
		  limit 1
		  ;";

/* Do the DB magics */
$wugms_qos_basic_stats_stmt = $db->prepare($wugms_qos_basic_stats_query);
if ($wugms_qos_basic_stats_stmt->execute()) {
    $wugms_qos_basic_stats_row = $wugms_qos_basic_stats_stmt->fetchAll();
}


/* Get the results */
if ($wugms_qos_basic_stats_row) {
    foreach ($wugms_qos_basic_stats_row as $x) {
        $results[] = array(
            'rdate' => $x['rdate'],
            'samplers' => $x['samplers']
        );
    }
    /**/
echo json_encode($results);	
}

?>