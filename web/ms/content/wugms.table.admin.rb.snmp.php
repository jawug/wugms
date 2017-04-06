<?php

/* Include the validation checker */
include($_SERVER['DOCUMENT_ROOT'] . '/auth/validate.php');
/* This is required for custom branding */
require($_SERVER['DOCUMENT_ROOT'] . '/content/branding.php');
require($_SERVER['DOCUMENT_ROOT'] . '/content/functions.php');

/* Set the default output */
$outp = "[{}]";

if (isValueInRoleArray($_SESSION["roles"], "admin") && isset($_GET['sn'])) {
    
	wugmsaudit("ADMIN", "rb_review", "review_data", $_SESSION["irc_nick"] . " (" . $_SESSION["id"] .  ") viewed tbl_base_rb_snmp_config for " . $_GET['sn']);
		
    $wugms_table_user_rb_header_row = '';
    $outp                           = '';
    
    $wugms_table_user_rb_header_query = "
SELECT if(a.contact = '', '-', a.contact) 'contact',
       if(a.location = '', '-', a.location) 'location',
	   if (a.enabled = -1, concat('<span style=\'color: rgb(0, 153, 0);\'>','Enabled','</span>'),concat('<span style=\'color: rgb(153, 0, 0);\'>','Disabled','</span>'))'status',
       if(a.trap_community = '', 'Not Configured', a.trap_community) 'trap_community',
       if(a.engine_id = '', '-', a.engine_id) 'engine_id',
       if(a.trap_generators = '', '-', a.trap_generators) 'trap_generators',
       a.trap_target,
       a.trap_version
  FROM tbl_base_rb_snmp_config a
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
            $outp .= '{"contact":"' . $x["contact"] . '",';
            $outp .= '"location":"' . $x["location"] . '",';
   			$outp .= '"status":"' . $x["status"] . '",';
            $outp .= '"trap_community":"' . $x["trap_community"] . '",';
			
   			$outp .= '"engine_id":"' . $x["engine_id"] . '",';
            $outp .= '"trap_generators":"' . $x["trap_generators"] . '",';
   			$outp .= '"trap_target":"' . $x["trap_target"] . '",';
            $outp .= '"trap_version":"' . $x["trap_version"] . '"}';
        }
        $outp .= "]";
    }
    
}
/* echo the result(s) */
echo ($outp);
?>