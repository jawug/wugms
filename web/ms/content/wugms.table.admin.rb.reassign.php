<?php

/* Include the validation checker */
include($_SERVER['DOCUMENT_ROOT'] . '/auth/validate.php');
/* This is required for custom branding */
require($_SERVER['DOCUMENT_ROOT'] . '/content/branding.php');
require($_SERVER['DOCUMENT_ROOT'] . '/content/functions.php');

/* Set the default output */
$outp = "[{}]";

if (isValueInRoleArray($_SESSION["roles"], "admin")) {
    
	wugmsaudit("ADMIN", "rb_review", "review_data", $_SESSION["irc_nick"] . " (" . $_SESSION["id"] .  ") viewed tbl_base_rb_routerboard for ");
		
    $wugms_table_user_rb_header_row = '';
    $outp                           = '';
    
    $wugms_table_user_rb_header_query = "
SELECT a.Software_ID,
       a.Serial_Number,
       a.Gen_Date,
       a.OS_Version,
       a.Board_tech,
       a.Board_model,
       a.RB_identity,
       a.idSite_Owner 'rb_owner',
       a.File_Date,
       a.Name 'sitename',
       a.isUseSiteinfo,
       a.latitude 'rb_lat',
       a.longitude 'rb_long',
       a.height 'rb_height',
       b.snmp_seen,
       b.dversion 'snmp_ros',
       a.siteID,
       a.rb_owner_name
  FROM (SELECT a.Software_ID,
               a.Serial_Number,
               a.Gen_Date,
               a.OS_Version,
               a.Board_tech,
               a.Board_model,
               a.RB_identity,
               a.idSite_Owner,
               a.File_Date,
               a.latitude,
               a.longitude,
               a.height,
               a.SiteName,
               a.isUseSiteinfo,
               c.Name,
               c.siteID,
               b.irc_nick 'rb_owner_name'
          FROM tbl_base_rb_routerboard a, tbl_base_sites c, tbl_base_user b
         WHERE a.siteID = c.siteID AND a.idSite_Owner = b.idtbl_base_user)
       AS a
       LEFT JOIN (SELECT max(RDate) 'snmp_seen', dversion, SoftwareID
                    FROM tbl_base_snmp_mikrotik_cdp_now
                  GROUP BY SoftwareID) AS b
          ON a.Software_ID = b.SoftwareID;";
    
    /* Assign the parameters as per the selected device */

        $wugms_table_user_rb_header_stmt   = $db->prepare($wugms_table_user_rb_header_query);
        if ($wugms_table_user_rb_header_stmt->execute()) {
            $wugms_table_user_rb_header_row = $wugms_table_user_rb_header_stmt->fetchAll();
        }

    
    
    if ($wugms_table_user_rb_header_row) {
        $outp = "[";
        foreach ($wugms_table_user_rb_header_row as $x) {
            
            if ($outp != "[") {
                $outp .= ",";
            }
            $outp .= '{"Software_ID":"' . $x["Software_ID"] . '",';
            $outp .= '"Serial_Number":"' . $x["Serial_Number"] . '",';
            $outp .= '"Gen_Date":"' . $x["Gen_Date"] . '",';
            $outp .= '"OS_Version":"' . $x["OS_Version"] . '",';
            $outp .= '"Board_tech":"' . $x["Board_tech"] . '",';
            $outp .= '"Board_model":"' . $x["Board_model"] . '",';
            $outp .= '"RB_identity":"' . $x["RB_identity"] . '",';
			$outp .= '"rb_owner":"' . $x["rb_owner"] . '",';
            $outp .= '"File_Date":"' . $x["File_Date"] . '",';
            $outp .= '"sitename":"' . $x["sitename"] . '",';
			$outp .= '"rb_owner_name":"' . $x["rb_owner_name"] . '",';
			$outp .= '"siteID":"' . $x["siteID"] . '",';
			$outp .= '"isUseSiteinfo":"' . $x["isUseSiteinfo"] . '",';
			$outp .= '"rb_lat":"' . $x["rb_lat"] . '",';
			$outp .= '"rb_long":"' . $x["rb_long"] . '",';
			$outp .= '"rb_height":"' . $x["rb_height"] . '",';
            $outp .= '"snmp_seen":"' . $x["snmp_seen"] . '",';
            $outp .= '"snmp_ros":"' . $x["snmp_ros"] . '"}';
        }
        $outp .= "]";
    }
    
}
/* echo the result(s) */
echo ($outp);
?>