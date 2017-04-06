<?php
/* Includes */
require($_SERVER['DOCUMENT_ROOT'] . '/auth/config.php');
// get data and store in a json array
$wifi_24_query = "SELECT CONCAT(a.wifi_frequency,' GHz') 'freq', count(*) 'counter'
  FROM tbl_base_rb_interface_config a
 WHERE     a.Interface_type = 'WIFI'
       AND upper(a.wifi_ssid) LIKE '%JAWUG%'
       AND upper(a.wifi_mode) LIKE '%AP%'
       AND a.disabled = '0'
       AND a.wifi_band LIKE '2%'
       group by a.wifi_frequency 
       order by a.wifi_frequency;";
 
/* Magic */
$wifi_24_stmt = $db->prepare($wifi_24_query);

if ($wifi_24_stmt->execute()) {
    $wifi_24_row = $wifi_24_stmt->fetchAll();
}

/* Work the results */
$rows = array();
if ($wifi_24_row) {
    foreach ($wifi_24_row as $x) {
	$row[0] = $x['freq'];
	$row[1] = $x['counter'];
	array_push($rows,$row);
	}
	/* Send the result(s) */
	echo json_encode($rows, JSON_NUMERIC_CHECK);
}
?>