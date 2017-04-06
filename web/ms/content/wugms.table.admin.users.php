<?php

/* Include the validation checker */
include($_SERVER['DOCUMENT_ROOT'] . '/auth/validate.php');
/* This is required for custom branding */
require($_SERVER['DOCUMENT_ROOT'] . '/content/branding.php');
require($_SERVER['DOCUMENT_ROOT'] . '/content/functions.php');

/* default output */
$outp = "[{}]";

if (isValueInRoleArray($_SESSION["roles"], "admin")) {
        $wugms_table_user_row = '';
        $outp                       = '';
        
        $wugms_table_user_query = "
SELECT a.idtbl_base_user 'user_id',
       a.username,
       a.irc_nick,
       a.firstName,
       a.lastName,
       a.password,
       a.max_sites,
       a.mancom_account_nr,
       a.salt,
       a.cdate,
       a.acc_status,
       a.dob,
       a.phone_num,
       a.area,
       a.acc_val_key,
       b.roles
  FROM tbl_base_user a,
       (SELECT username_id, group_concat(role) AS 'roles'
          FROM (SELECT b.username_id, group_concat(b.roll_id) AS 'role'
                  FROM tbl_ae_user_rolls b
                GROUP BY b.username_id, b.roll_id
                ORDER BY b.username_id, b.roll_id) tbl
        GROUP BY username_id) AS b
 WHERE     idtbl_base_user <> 1
       AND idtbl_base_user <> 68
       AND a.idtbl_base_user = b.username_id
ORDER BY a.firstName";
        

        /* teh magic */
        $wugms_table_user_stmt   = $db->prepare($wugms_table_user_query);
        if ($wugms_table_user_stmt->execute()) {
            $wugms_table_user_row = $wugms_table_user_stmt->fetchAll();
        }
        
        // Check if the site_name supplied has not already been used
        
        
        ;
        
        if ($wugms_table_user_row) {
            $outp = "[";
            foreach ($wugms_table_user_row as $x) {
                
                if ($outp != "[") {
                    $outp .= ",";
                }
                $outp .= '{"user_id":"' . $x["user_id"] . '",';
                $outp .= '"username":"' . $x["username"] . '",';
                $outp .= '"irc_nick":"' . $x["irc_nick"] . '",';
				$outp .= '"max_sites":"' . $x["max_sites"] . '",';
                $outp .= '"firstName":"' . $x["firstName"] . '",';
                $outp .= '"lastName":"' . $x["lastName"] . '",';
				$outp .= '"cdate":"' . $x["cdate"] . '",';
				$outp .= '"dob":"' . $x["dob"] . '",';
				$outp .= '"phone_num":"' . $x["phone_num"] . '",';
				$outp .= '"phone_num":"' . $x["phone_num"] . '",';
				$outp .= '"roles":"' . $x["roles"] . '",';
                $outp .= '"acc_status":"' . $x["acc_status"] . '"}';
                
            }
            $outp .= "]";
        }
        

    /* echo the result(s) */
    echo ($outp);
}
?>