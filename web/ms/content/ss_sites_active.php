<?php
/* Includes */
require($_SERVER['DOCUMENT_ROOT'] . '/auth/config.php');
// get data and store in a json array
$us_active_sites_query = "SELECT count(*) 'Counter'
  FROM (SELECT ae_siteID
          FROM tbl_ae_sites_rbs
         WHERE ae_Serial_Number <> ''
        GROUP BY ae_siteID) AS b;";
 
/* Magic */
$us_active_sites_stmt = $db->prepare($us_active_sites_query);

if ($us_active_sites_stmt->execute()) {
    $us_active_sites_row = $us_active_sites_stmt->fetchAll();
}

/* Work the results */
if ($us_active_sites_row) {
    foreach ($us_active_sites_row as $x) {
		$results[] = array(
			'Counter' => $x['Counter']
		);
	}
	/* Send the result(s) */
	echo json_encode($results);
}
?>