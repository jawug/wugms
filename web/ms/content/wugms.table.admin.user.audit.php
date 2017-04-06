<?php

/* Include the validation checker */
include($_SERVER['DOCUMENT_ROOT'] . '/auth/validate.php');
/* This is required for custom branding */
require($_SERVER['DOCUMENT_ROOT'] . '/content/branding.php');
require($_SERVER['DOCUMENT_ROOT'] . '/content/functions.php');

/* default output */
$outp = "[{}]";

if (isValueInRoleArray($_SESSION["roles"], "admin")) {
    if (isset($_GET['user'])) {
        $wugms_table_user_audit_row = '';
        $outp                       = '';
        
        $wugms_table_user_audit_query = "
SELECT a.session_date,
       b.irc_nick 'username',
       a.username_id,
       a.level,
       a.area,
       a.action,
       a.msg
  FROM tbl_base_user_audit a, tbl_base_user b
 WHERE a.username_id = b.idtbl_base_user AND b.idtbl_base_user = :user_id
ORDER BY a.session_date DESC;";
        
        /* Set teh params */
        $wugms_table_user_audit_params = array(
            ':user_id' => $_GET['user']
        );
        /* teh magic */
        $wugms_table_user_audit_stmt   = $db->prepare($wugms_table_user_audit_query);
        if ($wugms_table_user_audit_stmt->execute($wugms_table_user_audit_params)) {
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
        }
        
    }
    /* echo the result(s) */
    echo ($outp);
}
?>