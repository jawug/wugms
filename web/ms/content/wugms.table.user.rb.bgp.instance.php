<?php

/* Include the validation checker */
include($_SERVER['DOCUMENT_ROOT'] . '/auth/validate.php');
/* This is required for custom branding */
require($_SERVER['DOCUMENT_ROOT'] . '/content/branding.php');
require($_SERVER['DOCUMENT_ROOT'] . '/content/functions.php');

if (isset($_GET['sn'])) {
    
    $wugms_table_user_rb_header_row = '';
    $outp                           = '';
    
    $wugms_table_user_rb_header_query = "
SELECT a.name,
       if(a.isDefault = 0, 'No', 'Yes') 'isdefault',
       a.as_value,
       a.router_idStr,
	   if (a.disabled = 0, concat('<span style=\'color: rgb(0, 153, 0);\'>','Enabled','</span>'),concat('<span style=\'color: rgb(153, 0, 0);\'>','Disabled','</span>'))'status',
       if(a.client_to_client_reflection = 0, 'No', 'Yes') 'client_reflect',
       if(a.redistribute_connected = 0, 'No', 'Yes') 'redis_connect',
       if(a.redistribute_ospf = 0, 'No', 'Yes') 'redis_ospf',
       if(a.redistribute_other_bgp = 0, 'No', 'Yes') 'redis_other_bgp',
       if(a.redistribute_rip = 0, 'No', 'Yes') 'redis_rip',
       if(a.redistribute_static = 0, 'No', 'Yes') 'redis_static',
       a.ignore_as_path_len,
       a.out_filter,
       a.routing_table
  FROM tbl_base_rb_routing_bgp_instance_config a
 WHERE Serial_Number = :rb_id;";
    
    /* Assign the parameters as per the selected level */
    
    if (isset($_SESSION["id"])) {
        $wugms_table_user_rb_header_params = array(
            ':rb_id' => $_GET['sn']
        );
        $wugms_table_user_rb_header_stmt   = $db->prepare($wugms_table_user_rb_header_query);
        if ($wugms_table_user_rb_header_stmt->execute($wugms_table_user_rb_header_params)) {
            $wugms_table_user_rb_header_row = $wugms_table_user_rb_header_stmt->fetchAll();
        }
    }
    
    // Check if the site_name supplied has not already been used
    
    
    if ($wugms_table_user_rb_header_row) {
        $outp = "[";
        foreach ($wugms_table_user_rb_header_row as $x) {
            
            if ($outp != "[") {
                $outp .= ",";
            }
            $outp .= '{"name":"' . $x["name"] . '",';
            $outp .= '"isdefault":"' . $x["isdefault"] . '",';
            $outp .= '"as_value":"' . $x["as_value"] . '",';
            $outp .= '"router_idStr":"' . $x["router_idStr"] . '",';
			$outp .= '"status":"' . $x["status"] . '",';
            $outp .= '"client_reflect":"' . $x["client_reflect"] . '",';
			$outp .= '"redis_connect":"' . $x["redis_connect"] . '",';
			$outp .= '"redis_ospf":"' . $x["redis_ospf"] . '",';
			$outp .= '"redis_other_bgp":"' . $x["redis_other_bgp"] . '",';
			$outp .= '"redis_rip":"' . $x["redis_rip"] . '",';
			$outp .= '"redis_static":"' . $x["redis_static"] . '",';
			$outp .= '"ignore_as_path_len":"' . $x["ignore_as_path_len"] . '",';
			$outp .= '"out_filter":"' . $x["out_filter"] . '",';
            $outp .= '"routing_table":"' . $x["routing_table"] . '"}';
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