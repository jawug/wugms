<?php

/* Include the validation checker */
include($_SERVER['DOCUMENT_ROOT'] . '/auth/validate.php');
/* This is required for custom branding */
require($_SERVER['DOCUMENT_ROOT'] . '/content/branding.php');
require($_SERVER['DOCUMENT_ROOT'] . '/content/functions.php');

if (isset($_SESSION["id"])) {
    
    $wugms_table_user_rb_header_row = '';
    $outp                           = '';
    
    $wugms_table_user_rb_header_query = "
SELECT a.RDate 'snmp_seen',
       a.Device_Description 'device_description',
       a.Version 'ros',
       a.Firmware 'firmware',
       a.UptimeStr 'uptime',
       b.SiteName 'sitename'
  FROM tbl_base_snmp_header_now a,
       (SELECT b.Serial_Number, c.Name 'sitename'
          FROM tbl_base_rb_routerboard b, tbl_base_sites c
         WHERE b.siteID = c.siteID
         and upper(b.active) = 'Y') b
 WHERE     a.Serial_Number = b.Serial_Number
       AND a.rdate < DATE_SUB(now(), INTERVAL 1 DAY)
ORDER BY a.rdate DESC;";
    
    /* Assign the parameters as per the selected level */
    
        $wugms_table_user_rb_header_stmt   = $db->prepare($wugms_table_user_rb_header_query);
        if ($wugms_table_user_rb_header_stmt->execute()) {
            $wugms_table_user_rb_header_row = $wugms_table_user_rb_header_stmt->fetchAll();
        }
    
    // Check if the site_name supplied has not already been used
    
    
    if ($wugms_table_user_rb_header_row) {
        $outp = "[";
        foreach ($wugms_table_user_rb_header_row as $x) {
            
            if ($outp != "[") {
                $outp .= ",";
            }
            $outp .= '{"snmp_seen":"' . $x["snmp_seen"] . '",';
            $outp .= '"device_description":"' . $x["device_description"] . '",';
            $outp .= '"ros":"' . $x["ros"] . '",';
            $outp .= '"firmware":"' . $x["firmware"] . '",';
            $outp .= '"uptime":"' . $x["uptime"] . '",';
            $outp .= '"sitename":"' . $x["sitename"] . '"}';
            
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