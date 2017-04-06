<?php
/* Includes */
require($_SERVER['DOCUMENT_ROOT'] . '/auth/config.php');
// get data and store in a json array
$snmp_rb_list_query = "SELECT IFNULL(b.SiteName, 'unassigned') 'SiteName',
       b.RB_identity,
       b.Board_model,
       a.Serial_Number
  FROM tbl_base_snmp_header_now a, tbl_base_rb_routerboard b
 WHERE a.Serial_Number = b.Serial_Number
ORDER BY IFNULL(b.SiteName, 'unassigned'), b.RB_identity, b.Board_model;";
 
/* Magic */
$snmp_rb_list_stmt = $db->prepare($snmp_rb_list_query);

if ($snmp_rb_list_stmt->execute()) {
    $snmp_rb_list_row = $snmp_rb_list_stmt->fetchAll();
}

/* Work the results */
if ($snmp_rb_list_row) {
    foreach ($snmp_rb_list_row as $x) {
		$results[] = array(
       'id' => "'" . $x['Serial_Number'],
	   'description' => $x['SiteName'] . " " . $x['RB_identity'] . " " . $x['Board_model']
		);
	}
	/* Send the result(s) */
	echo json_encode($results);
}
?>