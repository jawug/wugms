<?php
/* Includes */
require($_SERVER['DOCUMENT_ROOT'] . '/auth/config.php');
// get data and store in a json array
$ip_unique_query = "SELECT count(*) 'counter'
			FROM (SELECT count(*)
			FROM tbl_base_rb_interface_config
			WHERE     Interface_type = 'WIFI'
               AND disabled = 0
               AND Upper(wifi_ssid) LIKE '%JAWUG.%'
			GROUP BY wifi_ssid) a;";
 
/* Magic */
$ip_unique_stmt = $db->prepare($ip_unique_query);

if ($ip_unique_stmt->execute()) {
    $ip_unique_row = $ip_unique_stmt->fetchAll();
}

/* Work the results */
if ($ip_unique_row) {
    foreach ($ip_unique_row as $x) {
		$results[] = array(
			'counter' => $x['counter']
		);
	}
	/* Send the result(s) */
	echo json_encode($results);
}
?>