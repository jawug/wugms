<?php
//session_start();
require($_SERVER['DOCUMENT_ROOT'] . '/auth/config.php');
        $us_active_sites_query = "
SELECT @row_number := @row_number + 1 AS row_number,
       z.sitename,
       z.user,
       z.model,
       z.ros,
       z.active_date
  FROM (SELECT a.Name 'sitename',
               b.irc_nick 'user',
               e.Board_model 'model',
               e.OS_Version 'ros',
               d.ae_rb_to_site_allocate_date 'active_date'
          FROM tbl_base_sites a,
               tbl_base_user b,
               tbl_ae_sites_rbs d,
               tbl_base_rb_routerboard e
         WHERE     a.siteID = d.ae_siteID
               AND d.ae_Serial_Number = e.Serial_Number
               AND a.idSite_Owner = b.idtbl_base_user
        ORDER BY d.ae_rb_to_site_allocate_date DESC
         LIMIT 10) AS z,
       (SELECT @row_number := 0) AS t";
	
    $us_active_sites_stmt   = $db->prepare($us_active_sites_query);

    if ($us_active_sites_stmt->execute()) {
        $us_active_sites_row = $us_active_sites_stmt->fetchAll();
    }    ;
    
    if ($us_active_sites_row) {
	
	
		$outp = "[";        
        foreach ($us_active_sites_row as $x) {

    if ($outp != "[") {$outp .= ",";}
$outp .= '{"row_number":"'  . $x["row_number"] . '",';
$outp .= '"sitename":"'  . $x["sitename"] . '",';
$outp .= '"user":"'  . $x["user"] . '",';
$outp .= '"model":"'  . $x["model"] . '",';
$outp .= '"ros":"'  . $x["ros"] . '",';
$outp .= '"active_date":"'  . $x["active_date"]     . '"}';

			

}
$outp .="]";
        }
    echo($outp); 
?>