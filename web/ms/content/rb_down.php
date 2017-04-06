<?php
/* Includes */
require($_SERVER['DOCUMENT_ROOT'] . '/auth/config.php');
// get data and store in a json array
$rb_down_query = "SELECT a.days, a.Comment, a.Status, b.items
  FROM (SELECT v.limit 'days', v.Comment, v.Status
          FROM view_cfg_status_down v) a,
       (SELECT count(*) 'items'
          FROM view_rb_overview
         WHERE RB_Status = 'Down') b;";
 
/* Magic */
$rb_down_stmt = $db->prepare($rb_down_query);

if ($rb_down_stmt->execute()) {
    $rb_down_row = $rb_down_stmt->fetchAll();
}

/* Work the results */
if ($rb_down_row) {
    foreach ($rb_down_row as $x) {
		$results[] = array(
        'items' => $row['items']
		);
	}
	/* Send the result(s) */
	echo json_encode($results);
}
?>