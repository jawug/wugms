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
       a.instance,
       a.remote_addressStr,
       a.remote_as,
       	   if (a.disabled = 0, concat('<span style=\'color: rgb(0, 153, 0);\'>','Enabled','</span>'),concat('<span style=\'color: rgb(153, 0, 0);\'>','Disabled','</span>'))'status',
       a.nexthop_choice,
       if(a.multihop = 0, 'No', 'Yes') 'multihop',
       if(a.route_reflect = 0, 'No', 'Yes') 'route_reflect',
       a.hold_time,
       a.ttl,
       a.in_filter,
       a.out_filter,
       if(a.remove_private_as = 0, 'No', 'Yes') 'remove_private_as',
       if(a.as_override = 0, 'No', 'Yes') 'as_override',
       a.default_originate,
       if(a.passive = 0, 'No', 'Yes') 'passive',
       if(a.use_bfd = 0, 'No', 'Yes') 'use_bfd',
       a.address_families,
       a.update_source
  FROM tbl_base_rb_routing_bgp_peer_config a
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
            $outp .= '"instance":"' . $x["instance"] . '",';
            $outp .= '"remote_addressStr":"' . $x["remote_addressStr"] . '",';
            $outp .= '"remote_as":"' . $x["remote_as"] . '",';
			$outp .= '"status":"' . $x["status"] . '",';
            $outp .= '"nexthop_choice":"' . $x["nexthop_choice"] . '",';
			$outp .= '"multihop":"' . $x["multihop"] . '",';
			$outp .= '"route_reflect":"' . $x["route_reflect"] . '",';
			$outp .= '"hold_time":"' . $x["hold_time"] . '",';
			$outp .= '"ttl":"' . $x["ttl"] . '",';
			$outp .= '"in_filter":"' . $x["in_filter"] . '",';
			$outp .= '"out_filter":"' . $x["out_filter"] . '",';
			$outp .= '"remove_private_as":"' . $x["remove_private_as"] . '",';
			$outp .= '"as_override":"' . $x["as_override"] . '",';
			$outp .= '"default_originate":"' . $x["default_originate"] . '",';
			$outp .= '"passive":"' . $x["passive"] . '",';			
			$outp .= '"use_bfd":"' . $x["use_bfd"] . '",';
			$outp .= '"address_families":"' . $x["address_families"] . '",';
            $outp .= '"update_source":"' . $x["update_source"] . '"}';
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