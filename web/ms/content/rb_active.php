<?php
/* Includes */
require($_SERVER['DOCUMENT_ROOT'] . '/auth/config.php');
// get data and store in a json array
$rb_active_query = "SELECT a.days, a.Comment, a.Status, b.items
  FROM (SELECT v.limit 'days', v.Comment, v.Status
          FROM view_cfg_status_active v) a,
       (SELECT count(*) 'items'
          FROM view_rb_overview
         WHERE RB_Status = 'Active') b;";
 
/* Magic */
$rb_active_stmt = $db->prepare($rb_active_query);

if ($rb_active_stmt->execute()) {
    $rb_active_row = $rb_active_stmt->fetchAll();
}

/* Work the results */
if ($rb_active_row) {
    foreach ($rb_active_row as $x) {
		$results[] = array(
        'items' => $row['items']
		);
	}
	/* Send the result(s) */
	echo json_encode($results);
}
?>