<?php

/* Include the validation checker */
include($_SERVER['DOCUMENT_ROOT'] . '/auth/validate.php');
/* This is required for custom branding */
require($_SERVER['DOCUMENT_ROOT'] . '/content/branding.php');
require($_SERVER['DOCUMENT_ROOT'] . '/content/functions.php');

    /* Default output if you're not an admin */
    $outp = "[{}]";

if (isset($_SESSION["id"])) {
    
    $wugms_table_user_roles_row = '';
    $outp                           = '';
    
    $wugms_table_user_roles_query = "
		SELECT a.roll_id, b.comment FROM tbl_ae_user_rolls a, tbl_base_user_rolls b WHERE username_id = :user_id and a.roll_id = b.roll;";
    
        /* Assign the parameters as per the selected level */
/*        $wugms_table_user_roles_query_params = array(
            ':user_id' => $_SESSION["id"]
        ); */
    if (isset($_SESSION["id"])) {
        $wugms_table_user_roles_params = array(
            ':user_id' => $_SESSION["id"]
        );
        $wugms_table_user_roles_stmt         = $db->prepare($wugms_table_user_roles_query);
        if ($wugms_table_user_roles_stmt->execute($wugms_table_user_roles_params)) {
            $wugms_table_user_roles_row = $wugms_table_user_roles_stmt->fetchAll();
        }
    }	
    
    // Check if the site_name supplied has not already been used
    
    
    ;
    
    if ($wugms_table_user_roles_row) {
        $outp = "[";
        foreach ($wugms_table_user_roles_row as $x) {
            
            if ($outp != "[") {
                $outp .= ",";
            }
            $outp .= '{"roll_id":"' . $x["roll_id"] . '",';
            $outp .= '"comment":"' . $x["comment"] . '"}';

        }
        $outp .= "]";
    }

}

/* echo the result(s) */
echo ($outp);
?>