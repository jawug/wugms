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
SELECT if (a.disabled = 0, concat('<span style=\'color: rgb(0, 153, 0);\'>','Enabled','</span>'),concat('<span style=\'color: rgb(153, 0, 0);\'>','Disabled','</span>'))'status',
       a.mac_address,
       a.name,
       a.comment,
       a.wifi_antenna_gain,
       a.wifi_channel_width,
       a.wifi_country,
       a.wifi_frequency,
       a.wifi_mode,
       a.wifi_radio_name,
       a.wifi_ssid,
       a.wifi_wireless_protocol
  FROM tbl_base_rb_interface_config a
 WHERE a.Serial_Number = :rb_id
 and a.Interface_type = 'WIFI'
 order by a.mac_address;";
    
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
            $outp .= '{"status":"' . $x["status"] . '",';
            $outp .= '"mac_address":"' . $x["mac_address"] . '",';
            $outp .= '"name":"' . $x["name"] . '",';
            $outp .= '"comment":"' . $x["comment"] . '",';
            $outp .= '"wifi_antenna_gain":"' . $x["wifi_antenna_gain"] . '",';
            $outp .= '"wifi_channel_width":"' . $x["wifi_channel_width"] . '",';
            $outp .= '"wifi_country":"' . $x["wifi_country"] . '",';
            $outp .= '"wifi_frequency":"' . $x["wifi_frequency"] . '",';
			$outp .= '"wifi_mode":"' . $x["wifi_mode"] . '",';
			$outp .= '"wifi_radio_name":"' . $x["wifi_radio_name"] . '",';
			$outp .= '"wifi_ssid":"' . $x["wifi_ssid"] . '",';
            $outp .= '"wifi_wireless_protocol":"' . $x["wifi_wireless_protocol"] . '"}';
            
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