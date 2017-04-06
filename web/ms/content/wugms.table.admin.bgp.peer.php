<?php

/* Include the validation checker */
include($_SERVER['DOCUMENT_ROOT'] . '/auth/validate.php');
/* This is required for custom branding */
require($_SERVER['DOCUMENT_ROOT'] . '/content/branding.php');
require($_SERVER['DOCUMENT_ROOT'] . '/content/functions.php');

/* Set the default output */
$outp = "[{}]";

if (isValueInRoleArray($_SESSION["roles"], "admin")) {
    
	wugmsaudit("ADMIN", "rb_review", "review_data", $_SESSION["irc_nick"] . " (" . $_SESSION["id"] .  ") viewed tbl_base_rb_routing_bgp_instance_config ");
		
    $wugms_table_admin_bgp_instance_row = '';
    $outp                           = '';
    
    $wugms_table_admin_bgp_instance_query = "
SELECT a.Serial_Number,
       a.address_families,
       a.as_override,
       a.default_originate,
	   if (a.disabled = 0, concat('<span style=\'color: rgb(0, 153, 0);\'>','Enabled','</span>'),concat('<span style=\'color: rgb(153, 0, 0);\'>','Disabled','</span>'))'disabled',
       a.hold_time,
       a.in_filter,
       a.instance,
       a.multihop,
       a.name,
       a.nexthop_choice,
       a.out_filter,
       a.passive,
       a.remote_addressStr,
       a.remote_as,
       a.remove_private_as,
       a.route_reflect,
       a.ttl,
       a.update_source,
       a.use_bfd,
       b.RB_identity,
       b.SiteName,
       c.as_value 'local_as'
  FROM tbl_base_rb_routing_bgp_peer_config a,
       tbl_base_rb_routerboard b,
       tbl_base_rb_routing_bgp_instance_config c
 WHERE     a.Serial_Number = b.Serial_Number
       AND a.Serial_Number = c.Serial_Number
       AND a.instance = c.name";
    
        $wugms_table_admin_bgp_instance_stmt   = $db->prepare($wugms_table_admin_bgp_instance_query);
        if ($wugms_table_admin_bgp_instance_stmt->execute()) {
            $wugms_table_admin_bgp_instance_row = $wugms_table_admin_bgp_instance_stmt->fetchAll();
        }

    
    if ($wugms_table_admin_bgp_instance_row) {
        $outp = "[";
        foreach ($wugms_table_admin_bgp_instance_row as $x) {
            
            if ($outp != "[") {
                $outp .= ",";
            }
            $outp .= '{"Serial_Number":"' . $x["Serial_Number"] . '",';
            $outp .= '"address_families":"' . $x["address_families"] . '",';
            $outp .= '"as_override":"' . $x["as_override"] . '",';
            $outp .= '"default_originate":"' . $x["default_originate"] . '",';
            $outp .= '"disabled":"' . $x["disabled"] . '",';
            $outp .= '"hold_time":"' . $x["hold_time"] . '",';
            $outp .= '"in_filter":"' . $x["in_filter"] . '",';
            $outp .= '"instance":"' . $x["instance"] . '",';
            $outp .= '"multihop":"' . $x["multihop"] . '",';
            $outp .= '"name":"' . $x["name"] . '",';
            $outp .= '"nexthop_choice":"' . $x["nexthop_choice"] . '",';
            $outp .= '"out_filter":"' . $x["out_filter"] . '",';
            $outp .= '"passive":"' . $x["passive"] . '",';
            $outp .= '"remote_addressStr":"' . $x["remote_addressStr"] . '",';
            $outp .= '"remote_as":"' . $x["remote_as"] . '",';
            $outp .= '"remove_private_as":"' . $x["remove_private_as"] . '",';
            $outp .= '"route_reflect":"' . $x["route_reflect"] . '",';
            $outp .= '"ttl":"' . $x["ttl"] . '",';
            $outp .= '"update_source":"' . $x["update_source"] . '",';
            $outp .= '"use_bfd":"' . $x["use_bfd"] . '",';
            $outp .= '"RB_identity":"' . $x["RB_identity"] . '",';
			$outp .= '"local_as":"' . $x["local_as"] . '",';
            $outp .= '"SiteName":"' . $x["SiteName"] . '"}';
        }
        $outp .= "]";
    }
    
}
/* echo the result(s) */
echo ($outp);
?>