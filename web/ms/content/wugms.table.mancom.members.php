<?php

/* Include the validation checker */
include($_SERVER['DOCUMENT_ROOT'] . '/auth/validate.php');
/* This is required for custom branding */
require($_SERVER['DOCUMENT_ROOT'] . '/content/branding.php');
require($_SERVER['DOCUMENT_ROOT'] . '/content/functions.php');

    /* Default output */
    $outp = "[{}]";    
if (isset($_SESSION["id"])) {
    
    $wugms_table_mancom_members_row = '';

    $wugms_table_mancom_members_query = "
SELECT a.idtbl_base_user,
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
       a.acc_val_key
  FROM wugms.tbl_base_user a,wugms.tbl_ae_user_rolls b
  WHERE b.roll_id = 'mancom'
  and  b.username_id = a.idtbl_base_user
  order by a.firstName, a.lastName;";
    
        /* Assign the parameters as per the selected level */
/*        $wugms_table_mancom_members_query_params = array(
            ':user_id' => $_SESSION["id"]
        ); */

        $wugms_table_mancom_members_stmt         = $db->prepare($wugms_table_mancom_members_query);
        if ($wugms_table_mancom_members_stmt->execute()) {
            $wugms_table_mancom_members_row = $wugms_table_mancom_members_stmt->fetchAll();
        }

    
    // Check if the site_name supplied has not already been used
    
    
    ;
    
    if ($wugms_table_mancom_members_row) {
        $outp = "[";
        foreach ($wugms_table_mancom_members_row as $x) {
            
            if ($outp != "[") {
                $outp .= ",";
            }
            $outp .= '{"irc_nick":"' . $x["irc_nick"] . '",';
            $outp .= '"firstName":"' . $x["firstName"] . '",';
            $outp .= '"lastName":"' . $x["lastName"] . '",';
            $outp .= '"mancom_account_nr":"' . $x["mancom_account_nr"] . '",';
			$outp .= '"acc_status":"' . $x["acc_status"] . '",';
            $outp .= '"max_sites":"' . $x["max_sites"] . '",';
            $outp .= '"cdate":"' . $x["cdate"] . '"}';

        }
        $outp .= "]";
    }

}
/* echo the result(s) */
echo ($outp);
?>