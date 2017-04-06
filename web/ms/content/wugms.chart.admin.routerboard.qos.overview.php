<?php
/* Start session */
session_start();
/* If someone is posting this as empty and there is no username set then do not run */

    #Include the connect.php file
    require($_SERVER['DOCUMENT_ROOT'] . '/auth/config.php');
    /* Init the vars */
    $wugms_chart_qos_row = '';
    $outp                = '';
    
		
    
/*    $wugms_chart_qos_query = "
SELECT y.hs_ip, sum(y.calc_bytes) 'bytes'
  FROM (SELECT l.hs_ip,
               l.latest_flow,
               if(l.latest_bytes >= p.previous_bytes,
                  l.latest_bytes - p.previous_bytes,
                  l.latest_bytes)
                  'calc_bytes'
          FROM (SELECT b.IPAddressStr 'hs_ip',
                       b.IPAddressStr 'latest_ip',
                       b.Bytes 'latest_bytes',
                       b.flow 'latest_flow',
                       b.rdate
                  FROM (SELECT x.sn, e.IP_Address, x.SiteName
                          FROM (SELECT b.sn, b.SiteName
                                  FROM (SELECT a.Serial_Number 'sn',
                                               b.Name 'sitename'
                                          FROM tbl_base_rb_routerboard a,
                                               tbl_base_sites b
                                         WHERE a.siteID = b.siteID) AS b)
                               AS x
                               INNER JOIN
                               (SELECT Serial_Number, IP_Address
                                  FROM wugms.view_ipv4_unique
                                 WHERE IP_Address LIKE '172.16.%') e
                                  ON x.sn = e.Serial_Number) AS a
                       INNER JOIN
                       (SELECT RDate,
                               flow,
                               IPAddressStr,
                               sum(bytes) 'bytes'
                          FROM wugms.tbl_base_snmp_mikrotik_queuetree_now
                         WHERE flow <> ''
                        GROUP BY IPAddressStr, flow
                        ORDER BY IPAddressStr, flow) AS b
                          ON a.IP_Address = b.IPAddressStr
                ORDER BY b.IPAddressStr, b.flow) l,
               (SELECT g.RDate,
                       g.IPAddressStr 'previous_ip',
                       g.flow 'previous_flow',
                       sum(g.bytes) 'previous_bytes'
                  FROM tbl_base_snmp_mikrotik_queuetree g,
                       (SELECT max(a.rdate) 'previous_rdate',
                               a.IPAddressStr 'previous_ip'
                          FROM tbl_base_snmp_mikrotik_queuetree a,
                               (SELECT max(rdate) 'latest', IPAddressStr
                                  FROM tbl_base_snmp_mikrotik_queuetree_now
                                GROUP BY IPAddressStr) b
                         WHERE     a.rdate < b.latest
                               AND a.IPAddressStr = b.IPAddressStr
                        GROUP BY a.IPAddressStr) z
                 WHERE     g.flow <> ''
                       AND z.previous_rdate = g.RDate
                       AND z.previous_ip = g.IPAddressStr
                GROUP BY g.RDate, g.IPAddressStr, g.flow
                ORDER BY g.IPAddressStr, g.flow) p
         WHERE     l.latest_ip = p.previous_ip
               AND l.latest_flow = p.previous_flow) y
GROUP BY y.hs_ip;"; */
    $wugms_chart_qos_query = "
SELECT curr.testd,
       curr.IPAddressStr AS 'hs_ip',
       curr.hosts,
       if(curr.Bytes >= IFNULL(prev.Bytes, 0),if(IFNULL(prev.Bytes, 0) > 0,curr.Bytes - IFNULL(prev.Bytes, 0),1), curr.Bytes) AS 'bytes'
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
          ON curr.IPAddressStr = prev.IPAddressStr;";
	
	
    if (isset($_SESSION["id"])) {
        $snmp_chart_qos_query_params = array(
            ':user_id' => $_SESSION["id"]
        );
        /* Excute the SQL query */
		$wugms_chart_qos_stmt = $db->prepare($wugms_chart_qos_query);
		if ($wugms_chart_qos_stmt->execute($snmp_chart_qos_query_params)) {
			$wugms_chart_qos_row = $wugms_chart_qos_stmt->fetchAll();
			}
    }	
			$series1         = array();
    $series1         = array();
    $series1['name'] = 'QoS';

//    $result = array();
    if ($wugms_chart_qos_row) {
/*
			foreach ($wugms_chart_qos_row as $x) {
				
				$row[0] = $x['hs_ip'];
				$row[1] = $x['bytes'];
				array_push($series1,$row);
				}

				}*/
        foreach ($wugms_chart_qos_row as $x) {
            $series1['data'][] = array(
                $x['hs_ip'],
                $x['bytes']
            );
            
            $result = array();
            
            array_push($result, $series1);
        }
        print json_encode($result, JSON_NUMERIC_CHECK);				
			/* Export the data */
			//	print json_encode($series1, JSON_NUMERIC_CHECK);
			}
?>