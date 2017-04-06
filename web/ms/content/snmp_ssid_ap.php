<?php

session_start();
require($_SERVER['DOCUMENT_ROOT'] . '/auth/config.php');
require($_SERVER['DOCUMENT_ROOT'] . '/content/functions.php');



/* Determine if the ssid_level has been set */
$type_sel = "";
if (isset($_GET['ssid_level'])) {
    $type_sel = $_GET['ssid_level'];
}

$snmp_ssid_client_row = '';
$outp = '';

/* This is the main SQL query */
$snmp_ssid_client_query = "
SELECT apn.freq,
       apn.band,
       apn.noisefloor,
       apn.overalltxccq,
       apn.clientcount,
       apn.authclientcount,
       rb.board_model,
       rb.rb_identity,
       sn.name,
       rbh.firmware,
       rbh.version,
       rbh.uptimestr
  FROM wugms.tbl_base_rb_routerboard rb,
       wugms.tbl_base_sites sn,
       wugms.tbl_base_snmp_header_now rbh,
       wugms.tbl_base_snmp_mikrotik_ap_now apn
 WHERE     apn.Serial_Number = :rb_sn
       AND upper(apn.ssid) = :ssid_name
       AND apn.Serial_Number = rb.Serial_Number
       AND rb.siteID = sn.siteID
       AND apn.Serial_Number = rbh.Serial_Number;";




if ($type_sel == "mov") {
    if (isset($_SESSION["ov_ssid_sn"]) && isset($_SESSION["ov_ssid_name"])) {
        /* Assign the parameters as per the selected level */
        $snmp_ssid_client_query_params = array(
            ':rb_sn' => $_SESSION["ov_ssid_sn"],
            ':ssid_name' => $_SESSION["ov_ssid_name"]
        );
        /* DB magic! */
        $snmp_ssid_client_stmt         = $db->prepare($snmp_ssid_client_query);
        if ($snmp_ssid_client_stmt->execute($snmp_ssid_client_query_params)) {
            $snmp_ssid_client_row = $snmp_ssid_client_stmt->fetchAll();
        }
    }
} else {
    if (isset($_SESSION["rb_sn_ssid"]) && isset($_SESSION["rb_ssid_id"])) {
        /* Assign the parameters as per the selected level */
        $snmp_ssid_client_query_params = array(
            ':rb_sn' => $_SESSION["rb_sn_ssid"],
            ':ssid_id' => $_SESSION["rb_ssid_id"]
        );
        /* DB magic! */
        $snmp_ssid_client_stmt         = $db->prepare($snmp_ssid_client_query);
        if ($snmp_ssid_client_stmt->execute($snmp_ssid_client_query_params)) {
            $snmp_ssid_client_row = $snmp_ssid_client_stmt->fetchAll();
        }
    }
}


if ($snmp_ssid_client_row) {
    $outp = "[";
    foreach ($snmp_ssid_client_row as $x) {
        if ($outp != "[") {
            $outp .= ",";
        }
        $outp .= '{"freq":"' . $x["freq"] . '",';
        $outp .= '"band":"' . $x["band"] . '",';
/*        $outp .= '"wifi_channel_width":"' . $x["wifi_channel_width"] . '",';
        $outp .= '"wifi_wireless_protocol":"' . $x["wifi_wireless_protocol"] . '",';*/
        $outp .= '"noisefloor":"' . $x["noisefloor"] . '",';
        $outp .= '"overalltxccq":"' . $x["overalltxccq"] . '",';
        $outp .= '"clientcount":"' . $x["clientcount"] . '",';
        $outp .= '"authclientcount":"' . $x["authclientcount"] . '",';
        $outp .= '"name":"' . $x["name"] . '",';
        $outp .= '"board_model":"' . $x["board_model"] . '",';
        $outp .= '"version":"' . $x["version"] . '"}';
    }
    $outp .= "]";

} else {
$outp = "[{}]";	
}

    echo ($outp);


/* Output the results */


?>