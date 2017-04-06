<?php
/* Includes */
require($_SERVER['DOCUMENT_ROOT'] . '/auth/config.php');
// get data and store in a json array
$us_reg_users_query = "SELECT count(*) 'Counter' FROM tbl_base_user a where a.idtbl_base_user <> 1;";
 
/* Magic */
$us_reg_users_stmt = $db->prepare($us_reg_users_query);

if ($us_reg_users_stmt->execute()) {
    $us_reg_users_row = $us_reg_users_stmt->fetchAll();
}

/* Work the results */
if ($us_reg_users_row) {
    foreach ($us_reg_users_row as $x) {
		$results[] = array(
			'Counter' => $x['Counter']
		);
	}
	/* Send the result(s) */
	echo json_encode($results);
}

?>