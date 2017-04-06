<?php

session_start();
require($_SERVER['DOCUMENT_ROOT'] . '/auth/config.php');
require($_SERVER['DOCUMENT_ROOT'] . '/content/functions.php');

$interval = "";
if (isset($_SESSION["id"])) {
    
    #

        $snmp_cpu_query = "SELECT m.File_Date 'rbcp_last_seen',
       m.stats 'status',
       o.sitename 'name',
       o.longitude 'lng',
       o.latitude 'lat',
       o.height,
       o.site_owner 'owner'
  FROM tbl_ae_sites_rbs x,
       (SELECT b.siteID,
               b.Name 'sitename',
               b.longitude,
               b.latitude,
               b.height,
               a.irc_nick 'site_owner',
               b.idSite_Owner 'site_owner_id'
          FROM tbl_base_sites b, tbl_base_user a
         WHERE b.idSite_Owner = a.idtbl_base_user) AS o,
       (SELECT c.RB_identity 'identity',
               c.Serial_Number,
               c.File_Date,
               a.irc_nick 'equipment_owner',
               if(
                  c.File_Date > DATE_SUB(now(), INTERVAL 168 HOUR),
                  'active',
                  if(c.File_Date < DATE_SUB(now(), INTERVAL 336 HOUR),
                     'lost',
                     'down'))
                  'stats',
               c.siteID
          FROM tbl_base_rb_routerboard c, tbl_base_user a
         WHERE c.idSite_Owner = a.idtbl_base_user) AS m
 WHERE x.ae_siteID = o.siteID AND x.ae_Serial_Number = m.Serial_Number
GROUP BY x.ae_siteID
ORDER BY m.File_Date DESC, o.sitename;;";

    
    
    
    //$category         = array();
    //$category['name'] = 'rdate';
    
    $series1         = array();
    //$series1['sites'] = 'Reading'; 
    
    // Check if the site_name supplied has not already been used
    $snmp_cpu_query_params = array(
            ':rb_sn' => $_SESSION["rb_sn"]
        /*':rb_sn' => '39A50209BF0A'*/
    );
    
    $snmp_cpu_stmt = $db->prepare($snmp_cpu_query);
    if ($snmp_cpu_stmt->execute($snmp_cpu_query_params)) {
        $snmp_cpu_row = $snmp_cpu_stmt->fetchAll();
    }
    ;
    
    if ($snmp_cpu_row) {
		echo '{"sites":' . json_encode($snmp_cpu_row).'}';	        
/*        foreach ($snmp_cpu_row as $x) {
		$result = array();
			$series1['sites'][]=array('name'=>$x['sitename'], 'owner'=>$x['site_owner'], 'status'=>$x['status'],'lat'=>$x['latitude'],'lng'=>$x['longitude'],'rbcp_last_seen'=>$x['rbcp_last_seen']);
        array_push($result, $series1);    
        } */
		
  //      print json_encode($result, JSON_NUMERIC_CHECK);
    //    print json_encode($result);
    }
}
?>