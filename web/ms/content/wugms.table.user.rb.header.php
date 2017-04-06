<?php

/* Include the validation checker */
include($_SERVER['DOCUMENT_ROOT'] . '/auth/validate.php');
/* This is required for custom branding */
require($_SERVER['DOCUMENT_ROOT'] . '/content/branding.php');
require($_SERVER['DOCUMENT_ROOT'] . '/content/functions.php');

if (isset($_GET['sn'])) {
    
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
       a.File_Date,
       a.Name,
       b.snmp_seen,
       b.dversion 'snmp_ros',
       b.firmware,
       b.uptimestr
  FROM (SELECT a.Software_ID,
               a.Serial_Number,
               a.Gen_Date,
               a.OS_Version,
               a.Board_tech,
               a.Board_model,
               a.RB_identity,
               a.File_Date,
               a.SiteName,
               c.Name
          FROM tbl_base_rb_routerboard a, tbl_base_sites c
         WHERE Serial_Number = :rb_id AND a.siteID = c.siteID) AS a
       LEFT JOIN (SELECT m.snmp_seen,
                         m.dversion,
                         m.SoftwareID,
                         n.Firmware,
                         n.UptimeStr
                    FROM (SELECT max(RDate) 'snmp_seen', dversion, SoftwareID
                            FROM tbl_base_snmp_mikrotik_cdp_now
                          GROUP BY SoftwareID) AS m,
                         (SELECT y.SoftwareID, y.Firmware, y.UptimeStr
                            FROM tbl_base_snmp_header_now y) AS n
                   WHERE m.SoftwareID = n.SoftwareID) AS b
          ON a.Software_ID = b.SoftwareID;";
    
    /* Assign the parameters as per the selected level */
    
    if (isset($_SESSION["id"])) {
        $wugms_table_user_rb_header_params = array(
            ':rb_id' => $_GET['sn']
        );
        $wugms_table_user_rb_header_stmt   = $db->prepare($wugms_table_user_rb_header_query);
        if ($wugms_table_user_rb_header_stmt->execute($wugms_table_user_rb_header_params)) {
            $wugms_table_user_rb_header_row = $wugms_table_user_rb_header_stmt->fetchAll();
        }
    }
    
    // Check if the site_name supplied has not already been used
    
    
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
            $outp .= '"File_Date":"' . $x["File_Date"] . '",';
            $outp .= '"Name":"' . $x["Name"] . '",';
            $outp .= '"snmp_seen":"' . $x["snmp_seen"] . '",';
			$outp .= '"firmware":"' . $x["firmware"] . '",';
			$outp .= '"uptimestr":"' . $x["uptimestr"] . '",';
            $outp .= '"snmp_ros":"' . $x["snmp_ros"] . '"}';
            
        }
        $outp .= "]";
    } else {
        $outp = "[{}]";
    }
    
} else {
    /* Default output if you're not an admin */
    $outp = "[{}]";
}
/* echo the result(s) */
echo ($outp);
?>