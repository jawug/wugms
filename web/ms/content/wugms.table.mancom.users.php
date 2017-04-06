<?php

/* Include the validation checker */
include($_SERVER['DOCUMENT_ROOT'] . '/auth/validate.php');
/* This is required for custom branding */
require($_SERVER['DOCUMENT_ROOT'] . '/content/branding.php');
require($_SERVER['DOCUMENT_ROOT'] . '/content/functions.php');

    /* Default output */
    $outp = "[{}]";    
if (isset($_SESSION["id"])) {
    
    $wugms_table_mancom_users_row = '';

    $wugms_table_mancom_users_query = "
SELECT a.idtbl_base_user 'user_id',
       a.username,
       a.irc_nick,
       a.firstName,
       a.lastName,
       a.acc_status,
       b.roles
  FROM tbl_base_user a,
       (SELECT username_id, group_concat(role) AS 'roles'
          FROM (SELECT b.username_id, group_concat(b.roll_id) AS 'role'
                  FROM tbl_ae_user_rolls b
                GROUP BY b.username_id, b.roll_id
                ORDER BY b.username_id, b.roll_id) tbl
        GROUP BY username_id) AS b
 WHERE     idtbl_base_user <> 1
       AND a.idtbl_base_user = b.username_id
       AND a.idtbl_base_user <> :logged_in_user
ORDER BY a.firstName, a.lastName;";
    
        /* Assign the parameters as per the selected level */
        $wugms_table_mancom_users_query_params = array(
            ':logged_in_user' => $_SESSION["id"]
        ); 

        $wugms_table_mancom_users_stmt         = $db->prepare($wugms_table_mancom_users_query);
        if ($wugms_table_mancom_users_stmt->execute($wugms_table_mancom_users_query_params)) {
            $wugms_table_mancom_users_row = $wugms_table_mancom_users_stmt->fetchAll();
        }

    
    // Check if the site_name supplied has not already been used
    
    
    ;
    
    if ($wugms_table_mancom_users_row) {
        $outp = "[";
        foreach ($wugms_table_mancom_users_row as $x) {
            
            if ($outp != "[") {
                $outp .= ",";
            }
            $outp .= '{"irc_nick":"' . $x["irc_nick"] . '",';
            $outp .= '"firstName":"' . $x["firstName"] . '",';
            $outp .= '"lastName":"' . $x["lastName"] . '",';
			$outp .= '"acc_status":"' . $x["acc_status"] . '",';
			$outp .= '"roles":"' . $x["roles"] . '",';
            $outp .= '"user_id":"' . $x["user_id"] . '"}';

        }
        $outp .= "]";
    }

}
/* echo the result(s) */
echo ($outp);
?>