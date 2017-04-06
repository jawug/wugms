<?php

/* Include the validation checker */
include($_SERVER['DOCUMENT_ROOT'] . '/auth/validate.php');
/* This is required for custom branding */
require($_SERVER['DOCUMENT_ROOT'] . '/content/branding.php');
require($_SERVER['DOCUMENT_ROOT'] . '/content/functions.php');

if (isValueInRoleArray($_SESSION["roles"], "mancom")) {
    
    $wugms_table_user_audit_row = '';
    $outp                           = '';
    
    $wugms_table_user_audit_query = "
SELECT a.session_date,
       b.irc_nick 'username',
       a.username_id,
       a.level,
	   a.area,
       a.action,
       a.msg
  FROM tbl_base_user_audit a, tbl_base_user b
 WHERE a.level = 'mancom' AND a.username_id = b.idtbl_base_user
ORDER BY a.session_date;";
    
    
    
        /* Assign the parameters as per the selected level */
/*        $wugms_table_user_audit_query_params = array(
            ':user_id' => $_SESSION["id"]
        ); */
        $wugms_table_user_audit_stmt         = $db->prepare($wugms_table_user_audit_query);
        if ($wugms_table_user_audit_stmt->execute()) {
            $wugms_table_user_audit_row = $wugms_table_user_audit_stmt->fetchAll();
        }
    
    // Check if the site_name supplied has not already been used
    
    
    ;
    
    if ($wugms_table_user_audit_row) {
        $outp = "[";
        foreach ($wugms_table_user_audit_row as $x) {
            
            if ($outp != "[") {
                $outp .= ",";
            }
            $outp .= '{"session_date":"' . $x["session_date"] . '",';
            $outp .= '"username":"' . $x["username"] . '",';
            $outp .= '"level":"' . $x["level"] . '",';
			$outp .= '"area":"' . $x["area"] . '",';
            $outp .= '"action":"' . $x["action"] . '",';
            $outp .= '"msg":"' . $x["msg"] . '"}';

        }
        $outp .= "]";
    } else {
        $outp = "[{}]";
    }

} else {
    /* Default output if you're not an admin */
    $outp = "[{}]";
}
/* echo the result(s) */
echo ($outp);
?>