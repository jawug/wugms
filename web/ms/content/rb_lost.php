<?php
/* Includes */
require($_SERVER['DOCUMENT_ROOT'] . '/auth/config.php');
// get data and store in a json array
$rb_lost_query = "SELECT a.days, a.Comment, a.Status, b.items
			FROM (SELECT v.limit 'days', v.Comment, v.Status
					FROM view_cfg_status_lost v) a,
				 (SELECT count(*) 'items'
					FROM view_rb_overview
			WHERE RB_Status = 'lost') b;";
 
/* Magic */
$rb_lost_stmt = $db->prepare($rb_lost_query);

if ($rb_lost_stmt->execute()) {
    $rb_lost_row = $rb_lost_stmt->fetchAll();
}

/* Work the results */
if ($rb_lost_row) {
    foreach ($rb_lost_row as $x) {
		$results[] = array(
        'items' => $row['items']
		);
	}
	/* Send the result(s) */
	echo json_encode($results);
}
?>