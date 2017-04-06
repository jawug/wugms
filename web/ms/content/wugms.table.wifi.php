<?php
/* Start session */
session_start();
/* If someone is posting this as empty and there is no username set then do not run */

#Include the connect.php file
require($_SERVER['DOCUMENT_ROOT'] . '/auth/config.php');
/* Init the vars */
$wugms_wifi_row = '';
$outp          = '[{}]';
$param  = "";
$var    = "";

/* Check if the param has been set */
if(isset($_GET['param'])){ $param = $_GET['param']; }
	$var = substr($param,0,4);

$wugms_wifi_row   = "";
$wugms_wifi_query = " 
SELECT a.wifi_frequency 'frequency',
       a.wifi_channel_width 'channel_width',
       a.wifi_antenna_gain 'antenna_gain',
       a.wifi_country 'country',
       a.wifi_ssid 'ssid',
	   a.wifi_band 'band',
       a.wifi_wireless_protocol 'wireless_protocol',
       b.SiteName 'sitename',
       c.irc_nick 'owner'
  FROM tbl_base_rb_interface_config a,
       tbl_base_rb_routerboard b,
       tbl_base_user c
 WHERE     a.Interface_type = 'WIFI'
       AND upper(a.wifi_ssid) LIKE '%JAWUG%'
       AND upper(a.wifi_mode) LIKE '%AP%'
       AND a.disabled = '0'
       AND a.wifi_frequency = :var
       AND b.idSite_Owner = c.idtbl_base_user
       AND a.Serial_Number = b.Serial_Number
ORDER BY b.SiteName, a.wifi_frequency ;";

$query_wifi_params = array(
    ':var' => $var
);

$wugms_wifi_stmt = $db->prepare($wugms_wifi_query);
if ($wugms_wifi_stmt->execute($query_wifi_params)) {
    $wugms_wifi_row = $wugms_wifi_stmt->fetchAll();
}

//    $result = array();
if ($wugms_wifi_row) {
    $outp = "[";
    foreach ($wugms_wifi_row as $x) {
        if ($outp != "[") {
            $outp .= ",";
        }
        $outp .= '{"frequency":"' . $x["frequency"] . '",';
        $outp .= '"channel_width":"' . $x["channel_width"] . '",';
        $outp .= '"antenna_gain":"' . $x["antenna_gain"] . '",';
        $outp .= '"country":"' . $x["country"] . '",';
        $outp .= '"ssid":"' . $x["ssid"] . '",';
		$outp .= '"band":"' . $x["band"] . '",';
        $outp .= '"wireless_protocol":"' . $x["wireless_protocol"] . '",';
        $outp .= '"sitename":"' . $x["sitename"] . '",';
        $outp .= '"owner":"' . $x["owner"] . '"}';
        
    }
    $outp .= "]";
    
}
echo ($outp);
?>