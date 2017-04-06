<?php
session_start();
require($_SERVER['DOCUMENT_ROOT'] . '/auth/config.php');
        $snmp_cpu_query = "
SELECT *
  FROM (SELECT g.Serial_Number 'sn',
               g.RB_identity 'rb_name',
               g.Board_model 'rb_model',
               g.Board_tech 'rb_tech',
               g.OS_Version 'rb_ros',
               g.File_Date 'rbcp_seen',
               h.irc_nick 'rb_owner',
               h.Name 'site_name',
               g.irc_nick 'site_owner'
          FROM (SELECT w.Serial_Number,
                       w.RB_identity,
                       w.Board_model,
                       w.Board_tech,
                       w.OS_Version,
                       w.File_Date,
                       w.idSite_Owner,
                       w.siteID,
                       z.irc_nick
                  FROM tbl_base_rb_routerboard w, tbl_base_user z
                 WHERE w.idSite_Owner = z.idtbl_base_user) AS g
               LEFT JOIN (SELECT x.siteID,
                                 x.Name,
                                 x.idSite_Owner,
                                 z.irc_nick
                            FROM tbl_base_sites x, tbl_base_user z
                           WHERE x.idSite_Owner = z.idtbl_base_user) AS h
                  ON g.siteID = h.siteID
        ORDER BY h.Name, g.RB_identity) AS a
       LEFT JOIN
       (SELECT b.Serial_Number,
               if(b.disabled = '0', 'Enabled', 'Disabled') 'Interface_state',
               b.mac_address,
               b.name,
               b.Interface_type,
               c.addressStr,
               if(c.disabled = '0', 'Enabled', 'Disabled') 'IP_state',
               c.interface_name,
               c.network
          FROM tbl_base_rb_interface_config b, view_ipv4_unique c
         WHERE     b.Serial_Number = c.Serial_Number
               AND b.name = c.interface_name) AS b
          ON a.sn = b.Serial_Number;";
    
    
//	$uquery_params = array(
		//':username' => $_SESSION["username"]	
	//);
//	$ustmt   = $db->prepare($uquery);
    /* Execute the query */
  //  if ($ustmt->execute($uquery_params)) {
    //    $uresult = $ustmt->fetchAll(PDO::FETCH_ASSOC);
    //}
   
    /*  */
    //echo json_encode($uresult);
	
	
    $snmp_cpu_stmt   = $db->prepare($snmp_cpu_query);
//    $snmp_cpu_stmt = $db->prepare($snmp_cpu_query);
    if ($snmp_cpu_stmt->execute()) {
        $snmp_cpu_row = $snmp_cpu_stmt->fetchAll();
    }    ;
    
    if ($snmp_cpu_row) {
        
//        foreach ($snmp_cpu_row as $x) {
            //$category['data'][] = $x['idate'];
            //$series1['data'][]  = $x['Reading'];
            
            //$result = array();
            //array_push($result, $category);
            //array_push($result, $series1);
			echo json_encode($snmp_cpu_row);
        }
// http://wugms.bwcsystem.net:20080/content/wugms.rb.ip.php
?>