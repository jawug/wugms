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
          FROM (SELECT 
                       b.IPAddressStr 'hs_ip',
                       b.IPAddressStr 'latest_ip',
                       b.Bytes 'latest_bytes',
                       b.flow 'latest_flow'
                  FROM (SELECT x.sn, e.IP_Address, x.SiteName
                          FROM (SELECT b.sn, b.SiteName
                                  FROM (SELECT sn
                                          FROM (SELECT b.ae_Serial_Number
                                                          'sn'
                                                  FROM tbl_ae_sites_rbs b,
                                                       tbl_base_sites a,
                                                       tbl_base_sites c
                                                 WHERE     a.idSite_Owner =
                                                              :user_id
                                                       AND b.ae_siteID =
                                                              a.siteID
                                                       AND a.idSite_Owner =
                                                              c.idSite_Owner)
                                               a
                                        UNION
                                        SELECT sn
                                          FROM (SELECT d.Serial_Number 'sn'
                                                  FROM tbl_base_rb_routerboard d
                                                 WHERE idSite_Owner =
                                                          :user_id) b) AS a
                                       INNER JOIN
                                       (SELECT a.Serial_Number 'sn',
                                               b.Name 'sitename'
                                          FROM tbl_base_rb_routerboard a,
                                               tbl_base_sites b
                                         WHERE a.siteID = b.siteID) AS b
                                          ON a.sn = b.sn) AS x
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
                          ON a.IP_Address = b.IPAddressStr) l,
               (SELECT b.IPAddressStr 'previous_ip',
                       b.Bytes 'previous_bytes',
                       b.Flow 'previous_flow'
                  FROM (SELECT x.sn, e.IP_Address, x.SiteName
                          FROM (SELECT b.sn, b.SiteName
                                  FROM (SELECT sn
                                          FROM (SELECT b.ae_Serial_Number
                                                          'sn'
                                                  FROM tbl_ae_sites_rbs b,
                                                       tbl_base_sites a,
                                                       tbl_base_sites c
                                                 WHERE     a.idSite_Owner =
                                                              :user_id
                                                       AND b.ae_siteID =
                                                              a.siteID
                                                       AND a.idSite_Owner =
                                                              c.idSite_Owner)
                                               a
                                        UNION
                                        SELECT sn
                                          FROM (SELECT d.Serial_Number 'sn'
                                                  FROM tbl_base_rb_routerboard d
                                                 WHERE idSite_Owner =
                                                          :user_id) b) AS a
                                       INNER JOIN
                                       (SELECT a.Serial_Number 'sn',
                                               b.Name 'sitename'
                                          FROM tbl_base_rb_routerboard a,
                                               tbl_base_sites b
                                         WHERE a.siteID = b.siteID) AS b
                                          ON a.sn = b.sn) AS x
                               INNER JOIN
                               (SELECT Serial_Number, IP_Address
                                  FROM wugms.view_ipv4_unique
                                 WHERE IP_Address LIKE '172.16.%') e
                                  ON x.sn = e.Serial_Number) AS a
                       INNER JOIN
                       (SELECT g.RDate,
                               g.IPAddressStr,
                               g.flow,
                               sum(g.bytes) 'bytes'
                          FROM tbl_base_snmp_mikrotik_queuetree g,
                               (SELECT max(a.rdate) 'previous_rdate',
                                       a.IPAddressStr 'previous_ip'
                                  FROM tbl_base_snmp_mikrotik_queuetree a,
                                       (SELECT max(rdate) 'latest',
                                               IPAddressStr
                                          FROM tbl_base_snmp_mikrotik_queuetree_now
                                        GROUP BY IPAddressStr) b
                                 WHERE     a.rdate < b.latest
                                       AND a.IPAddressStr = b.IPAddressStr
                                GROUP BY a.IPAddressStr) z
                         WHERE     g.flow <> ''
                               AND z.previous_rdate = g.RDate
                               AND z.previous_ip = g.IPAddressStr
                        GROUP BY g.RDate, g.IPAddressStr, g.flow
                        ORDER BY g.RDate, g.IPAddressStr, g.flow) AS b
                          ON a.IP_Address = b.IPAddressStr) p
         WHERE     l.latest_ip = p.previous_ip
               AND l.latest_flow = p.previous_flow) y
GROUP BY y.hs_ip;"; */

$wugms_chart_qos_query = "
SELECT q.current_host 'hs_ip', sum(q.calc_bytes) 'bytes'
  FROM (SELECT x.current_host,
               x.current_flow,
               if(x.current_bytes >= y.previous_bytes,
                  x.current_bytes - y.previous_bytes,
                  x.current_bytes)
                  'calc_bytes'
          FROM (SELECT b.current_host, b.current_bytes, b.current_flow
                  FROM (SELECT x.sn, e.IP_Address, x.SiteName
                          FROM (SELECT b.sn, b.SiteName
                                  FROM (SELECT sn
                                          FROM (SELECT sn
                                                  FROM view_sn_users
                                                 WHERE owner_id = :user_id) a
                                        UNION
                                        SELECT sn
                                          FROM (SELECT d.Serial_Number 'sn'
                                                  FROM tbl_base_rb_routerboard d
                                                 WHERE idSite_Owner =
                                                          :user_id) b) AS a
                                       INNER JOIN
                                       (SELECT a.Serial_Number 'sn',
                                               b.Name 'sitename'
                                          FROM tbl_base_rb_routerboard a,
                                               tbl_base_sites b
                                         WHERE a.siteID = b.siteID) AS b
                                          ON a.sn = b.sn) AS x
                               INNER JOIN
                               (SELECT Serial_Number, IP_Address
                                  FROM wugms.view_ipv4_unique
                                 WHERE IP_Address LIKE '172.16.%') e
                                  ON x.sn = e.Serial_Number) AS a
                       INNER JOIN
                       (SELECT DATE_FORMAT(a.rdate, '%Y-%m-%d %H:00')
                                  'current_hour',
                               a.IPAddressStr 'current_host',
                               a.Flow 'current_flow',
                               sum(a.Bytes) 'current_bytes'
                          FROM tbl_base_snmp_mikrotik_queuetree a
                         WHERE     (a.RDate BETWEEN DATE_FORMAT(
                                                         now()
                                                       - INTERVAL 1 HOUR,
                                                       '%Y-%m-%d %H:00:00')
                                                AND DATE_FORMAT(
                                                       now(),
                                                       '%Y-%m-%d %H:00:00'))
                               AND a.flow <> ''
                        GROUP BY a.IPAddressStr, a.Flow) AS b
                          ON a.IP_Address = b.current_host) AS x,
               (SELECT b.previous_host, b.previous_bytes, b.previous_flow
                  FROM (SELECT x.sn, e.IP_Address, x.SiteName
                          FROM (SELECT b.sn, b.SiteName
                                  FROM (SELECT sn
                                          FROM (SELECT sn
                                                  FROM view_sn_users
                                                 WHERE owner_id = :user_id) a
                                        UNION
                                        SELECT sn
                                          FROM (SELECT d.Serial_Number 'sn'
                                                  FROM tbl_base_rb_routerboard d
                                                 WHERE idSite_Owner =
                                                          :user_id) b) AS a
                                       INNER JOIN
                                       (SELECT a.Serial_Number 'sn',
                                               b.Name 'sitename'
                                          FROM tbl_base_rb_routerboard a,
                                               tbl_base_sites b
                                         WHERE a.siteID = b.siteID) AS b
                                          ON a.sn = b.sn) AS x
                               INNER JOIN
                               (SELECT Serial_Number, IP_Address
                                  FROM wugms.view_ipv4_unique
                                 WHERE IP_Address LIKE '172.16.%') e
                                  ON x.sn = e.Serial_Number) AS a
                       INNER JOIN
                       (SELECT DATE_FORMAT(a.rdate, '%Y-%m-%d %H:00')
                                  'previous_hour',
                               a.IPAddressStr 'previous_host',
                               a.Flow 'previous_flow',
                               sum(a.Bytes) 'previous_bytes'
                          FROM tbl_base_snmp_mikrotik_queuetree a
                         WHERE     (a.RDate BETWEEN DATE_FORMAT(
                                                         now()
                                                       - INTERVAL 2 HOUR,
                                                       '%Y-%m-%d %H:00:00')
                                                AND DATE_FORMAT(
                                                         now()
                                                       - INTERVAL 1 HOUR,
                                                       '%Y-%m-%d %H:00:00'))
                               AND a.flow <> ''
                        GROUP BY a.IPAddressStr, a.Flow) AS b
                          ON a.IP_Address = b.previous_host) AS y
         WHERE     x.current_host = y.previous_host
               AND x.current_flow = y.previous_flow) AS q
GROUP BY q.current_host;
";
    
	
	
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

//    $result = array();
    if ($wugms_chart_qos_row) {

			foreach ($wugms_chart_qos_row as $x) {
				$row[0] = $x['hs_ip'];
				$row[1] = $x['bytes'];
				array_push($series1,$row);
				}
				
				}		
			/* Export the data */
				print json_encode($series1, JSON_NUMERIC_CHECK);
//echo "[[\"172.16.250.14 (BJU) ZS6BJU\",5],[\"172.16.250.127 (BP) BryanPark\",10]]";
//echo "[[\"172.16.250.14 (BJU) ZS6BJU\",10],[\"172.16.250.127 (BP) BryanPark\",5]]";
//echo "[[\"172.16.250.127 (BP) BryanPark\",5],[\"172.16.250.14 (BJU) ZS6BJU\",10]]";
//echo "[[\"172.16.250.127 (BP) BryanPark\",10],[\"172.16.250.14 (BJU) ZS6BJU\",5]]";
?>