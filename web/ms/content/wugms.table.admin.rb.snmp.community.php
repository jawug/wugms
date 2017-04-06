<?php

/* Include the validation checker */
include($_SERVER['DOCUMENT_ROOT'] . '/auth/validate.php');
/* This is required for custom branding */
require($_SERVER['DOCUMENT_ROOT'] . '/content/branding.php');
require($_SERVER['DOCUMENT_ROOT'] . '/content/functions.php');

/* Set the default output */
$outp = "[{}]";

if (isValueInRoleArray($_SESSION["roles"], "admin") && isset($_GET['sn'])) {
    
	wugmsaudit("ADMIN", "rb_review", "review_data", $_SESSION["irc_nick"] . " (" . $_SESSION["id"] .  ") viewed tbl_base_rb_snmp_community_config for " . $_GET['sn']);
		
    $wugms_table_user_rb_header_row = '';
    $outp                           = '';
    
    $wugms_table_user_rb_header_query = "
SELECT a.addresses,
       a.authentication_protocol,
       a.encryption_protocol,
       a.name,
	   if (a.read_access = -1, concat('<span style=\'color: rgb(0, 153, 0);\'>','Enabled','</span>'),concat('<span style=\'color: rgb(153, 0, 0);\'>','Disabled','</span>'))'read_access',
       a.security,
	   if (a.write_access = -1, concat('<span style=\'color: rgb(0, 153, 0);\'>','Enabled','</span>'),concat('<span style=\'color: rgb(153, 0, 0);\'>','Disabled','</span>'))'write_access'
  FROM tbl_base_rb_snmp_community_config a
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
            $outp .= '{"name":"' . $x["name"] . '",';
            $outp .= '"addresses":"' . $x["addresses"] . '",';
   			$outp .= '"read_access":"' . $x["read_access"] . '",';
            $outp .= '"write_access":"' . $x["write_access"] . '",';
			
   			$outp .= '"authentication_protocol":"' . $x["authentication_protocol"] . '",';
            $outp .= '"encryption_protocol":"' . $x["encryption_protocol"] . '",';
            $outp .= '"security":"' . $x["security"] . '"}';
        }
        $outp .= "]";
    }
    
}
/* echo the result(s) */
echo ($outp);
?>