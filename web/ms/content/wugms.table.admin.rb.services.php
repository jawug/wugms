<?php

/* Include the validation checker */
include($_SERVER['DOCUMENT_ROOT'] . '/auth/validate.php');
/* This is required for custom branding */
require($_SERVER['DOCUMENT_ROOT'] . '/content/branding.php');
require($_SERVER['DOCUMENT_ROOT'] . '/content/functions.php');

/* Set the default output */
$outp = "[{}]";

if (isValueInRoleArray($_SESSION["roles"], "admin") && isset($_GET['sn'])) {
    
	wugmsaudit("ADMIN", "rb_review", "review_data", $_SESSION["irc_nick"] . " (" . $_SESSION["id"] .  ") viewed tbl_base_rb_services_config for " . $_GET['sn']);
		
    $wugms_table_user_rb_header_row = '';
    $outp                           = '';
    
    $wugms_table_user_rb_header_query = "
SELECT a.service_name,
       if(a.service_address = '', '-', a.service_address) 'service_address',
       a.port,
	   if (a.service_state = 0, concat('<span style=\'color: rgb(0, 153, 0);\'>','Enabled','</span>'),concat('<span style=\'color: rgb(153, 0, 0);\'>','Disabled','</span>'))'status'
  FROM tbl_base_rb_services_config a
 WHERE Serial_Number = :rb_id;";
    
    /* Assign the parameters as per the selected device */
    
        $wugms_table_user_rb_header_params = array(
            ':rb_id' => $_GET['sn']
        );
        $wugms_table_user_rb_header_stmt   = $db->prepare($wugms_table_user_rb_header_query);
        if ($wugms_table_user_rb_header_stmt->execute($wugms_table_user_rb_header_params)) {
            $wugms_table_user_rb_header_row = $wugms_table_user_rb_header_stmt->fetchAll();
        }

    
    if ($wugms_table_user_rb_header_row) {
        $outp = "[";
        foreach ($wugms_table_user_rb_header_row as $x) {
            
            if ($outp != "[") {
                $outp .= ",";
            }
            $outp .= '{"service_name":"' . $x["service_name"] . '",';
            $outp .= '"service_address":"' . $x["service_address"] . '",';
   			$outp .= '"port":"' . $x["port"] . '",';
            $outp .= '"status":"' . $x["status"] . '"}';
        }
        $outp .= "]";
    }
    
}
/* echo the result(s) */
echo ($outp);
?>