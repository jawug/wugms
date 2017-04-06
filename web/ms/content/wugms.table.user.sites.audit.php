<?php

/* Include the validation checker */
include($_SERVER['DOCUMENT_ROOT'] . '/auth/validate.php');
/* This is required for custom branding */
require($_SERVER['DOCUMENT_ROOT'] . '/content/branding.php');
require($_SERVER['DOCUMENT_ROOT'] . '/content/functions.php');

    /* Default output if you're not an admin */
    $outp = "[{}]";

if (isset($_SESSION["id"])) {
    
    $wugms_table_user_sites_row = '';
    
    $wugms_table_user_sites_query = "
SELECT b.irc_nick 'user',
       a.session_date 'tdate',
       a.level,
       a.area,
       a.action,
       trim(SUBSTRING(a.msg,1,LOCATE('UID', a.msg)-2))'msg'
  FROM tbl_base_user_audit a, tbl_base_user b
 WHERE     upper(a.area) = 'SITES'
       AND a.username_id = b.idtbl_base_user
       AND msg LIKE :user_id
ORDER BY a.session_date DESC;";
    
        /* Assign the parameters as per the selected level */
/*        $wugms_table_user_sites_query_params = array(
            ':user_id' => $_SESSION["id"]
        ); */
    if (isset($_SESSION["id"])) {
        $wugms_table_user_sites_params = array(
            ':user_id' => '%UID' . $_SESSION["id"]
        );
        $wugms_table_user_sites_stmt         = $db->prepare($wugms_table_user_sites_query);
        if ($wugms_table_user_sites_stmt->execute($wugms_table_user_sites_params)) {
            $wugms_table_user_sites_row = $wugms_table_user_sites_stmt->fetchAll();
        }
    }	
    
    // Check if the site_name supplied has not already been used
    
    
    ;
    
    if ($wugms_table_user_sites_row) {
        $outp = "[";
        foreach ($wugms_table_user_sites_row as $x) {
            
            if ($outp != "[") {
                $outp .= ",";
            }
            $outp .= '{"user":"' . $x["user"] . '",';
			$outp .= '"tdate":"' . $x["tdate"] . '",';
			$outp .= '"level":"' . $x["level"] . '",';
			$outp .= '"action":"' . $x["action"] . '",';
            $outp .= '"msg":"' . $x["msg"] . '"}';
        }
        $outp .= "]";
    }

}

/* echo the result(s) */
echo ($outp);
?>