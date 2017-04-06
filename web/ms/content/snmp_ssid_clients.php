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
$outp                 = '';

#
$snmp_ssid_client_query = "
SELECT a.rdate,
       a.connect_time,
       a.strength,
       a.signaltonoise,
       a.tx_speed,
       a.rx_speed,
       a.tx_bytes,
       a.rx_bytes,
       a.mac_addr,
       IFNULL(b.SiteName, 'No Data') 'sitename',
       IFNULL(b.RB_identity, 'No Data') 'rb_identity',
       IFNULL(b.Board_model, 'No Data') 'board_model',
       IFNULL(b.ros, 'No Data') 'ros',
       IFNULL(b.user, 'No Data') 'user',
       IFNULL(b.iface_name, a.MAC_Addr) 'iface_name',
       IFNULL(b.wifi_radio_name, 'No Data') 'wifi_radio_name',
       IFNULL(b.wifi_antenna_gain, 'No Data') 'wifi_antenna_gain',
       IFNULL(b.mac_address, 'No Data') 'mac_address'
  FROM (SELECT cn.rdate,
       cn.UptimeStr 'connect_time',
       cn.strength,
       cn.signaltonoise,
       concat(round(cn.TxRate / 1000000, 0), ' Mbps') 'tx_speed',
       concat(round(cn.RxRate / 1000000, 0), ' Mbps') 'rx_speed',
       concat(round(cn.txbytes / 1048576, 1), ' MiB') 'tx_bytes',
       concat(round(cn.rxbytes / 1048576, 1), ' MiB') 'rx_bytes',
       cn.MAC_Addr
  FROM tbl_base_snmp_mikrotik_ap_clients_now cn,
       tbl_base_snmp_mikrotik_ap_now ap
 WHERE     cn.rdate > now() - INTERVAL 60 DAY
       AND ap.Serial_Number = :rb_sn
       AND upper(ap.SSID) = :ssid_name
       AND ap.Serial_Number = cn.Serial_Number
       AND ap.AP_ID = cn.AP_ID) a
       LEFT JOIN
       (SELECT s.Name 'sitename',
               a.rb_identity,
               a.board_model,
               a.OS_Version 'ros',
               u.irc_nick 'user',
               ic.name 'iface_name',
               ic.wifi_radio_name,
               ic.wifi_antenna_gain,
               ic.mac_address
          FROM tbl_base_rb_routerboard a,
               tbl_base_sites s,
               tbl_base_user u,
               tbl_base_rb_interface_config ic
         WHERE     s.idSite_Owner = u.idtbl_base_user
               AND a.siteID = s.siteID
               AND ic.Serial_Number = a.Serial_Number) b
          ON a.MAC_Addr = b.mac_address
ORDER BY a.rdate;";


if ($type_sel == "mov") {
    if (isset($_SESSION["ov_ssid_sn"]) && isset($_SESSION["ov_ssid_name"])) {
        /* Assign the parameters as per the selected level */
        $snmp_ssid_client_query_params = array(
            ':rb_sn' => $_SESSION["ov_ssid_sn"],
            ':ssid_name' => $_SESSION["ov_ssid_name"]
        );
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
        $snmp_ssid_client_stmt         = $db->prepare($snmp_ssid_client_query);
        if ($snmp_ssid_client_stmt->execute($snmp_ssid_client_query_params)) {
            $snmp_ssid_client_row = $snmp_ssid_client_stmt->fetchAll();
        }
    }
}
// Check if the site_name supplied has not already been used


;

if ($snmp_ssid_client_row) {
    $outp = "[";
    foreach ($snmp_ssid_client_row as $x) {
        
        if ($outp != "[") {
            $outp .= ",";
        }
        $outp .= '{"rdate":"' . $x["rdate"] . '",';
        $outp .= '"sitename":"' . $x["sitename"] . '",';
        $outp .= '"rb_identity":"' . $x["rb_identity"] . '",';
        $outp .= '"board_model":"' . $x["board_model"] . '",';
        $outp .= '"ros":"' . $x["ros"] . '",';
        $outp .= '"user":"' . $x["user"] . '",';
        $outp .= '"connect_time":"' . $x["connect_time"] . '",';
        $outp .= '"iface_name":"' . $x["iface_name"] . '",';
        $outp .= '"wifi_radio_name":"' . $x["wifi_radio_name"] . '",';
        $outp .= '"wifi_antenna_gain":"' . $x["wifi_antenna_gain"] . '",';
        $outp .= '"strength":"' . $x["strength"] . '",';
        $outp .= '"signaltonoise":"' . $x["signaltonoise"] . '",';
        $outp .= '"tx_speed":"' . $x["tx_speed"] . '",';
        $outp .= '"rx_speed":"' . $x["rx_speed"] . '",';
        $outp .= '"tx_bytes":"' . $x["tx_bytes"] . '",';
        $outp .= '"rx_bytes":"' . $x["rx_bytes"] . '"}';
        
        
        
    }
    $outp .= "]";
} else {
    $outp = "[{}]";
}


echo ($outp);
// }
//}

?>