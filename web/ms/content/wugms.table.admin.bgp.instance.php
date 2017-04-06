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
SELECT p.Serial_Number,
       p.as_value,
       p.client_to_client_reflection,
	   if (p.disabled = 'Enabled', concat('<span style=\'color: rgb(0, 153, 0);\'>','Enabled','</span>'),concat('<span style=\'color: rgb(153, 0, 0);\'>','Disabled','</span>'))'disabled',
       p.name,
       p.out_filter,
       p.redistribute_connected,
       p.redistribute_other_bgp,
       p.router_idStr,
       q.device_model,
       q.device_name,
       q.sitename,
       q.sn
  FROM (SELECT Serial_Number,
               as_value,
               if(client_to_client_reflection = 0, 'No', 'Yes') 'client_to_client_reflection',
               if(disabled = 0, 'Enabled', 'Disabled') 'disabled',
               ignore_as_path_len,
               name,
               out_filter,
               if(redistribute_connected = 0, 'No', 'Yes') 'redistribute_connected',
               if(redistribute_other_bgp = 0, 'No', 'Yes') 'redistribute_other_bgp',
               router_idStr
          FROM tbl_base_rb_routing_bgp_instance_config) AS p
       LEFT JOIN (SELECT a.Board_model 'device_model',
                         a.RB_identity 'device_name',
                         b.Name 'sitename',
                         a.Serial_Number 'sn'
                    FROM tbl_base_rb_routerboard a, tbl_base_sites b
                   WHERE a.siteID = b.siteID
                  ORDER BY b.Name, a.RB_identity) AS q
          ON p.Serial_Number = q.sn
ORDER BY p.as_value;";
    
    /* Assign the parameters as per the selected device */
    

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
            $outp .= '{"name":"' . $x["name"] . '",';
            $outp .= '"as_value":"' . $x["as_value"] . '",';
            $outp .= '"client_to_client_reflection":"' . $x["client_to_client_reflection"] . '",';
            $outp .= '"disabled":"' . $x["disabled"] . '",';
			$outp .= '"out_filter":"' . $x["out_filter"] . '",';
			$outp .= '"device_name":"' . $x["device_name"] . '",';
            $outp .= '"redistribute_connected":"' . $x["redistribute_connected"] . '",';
			$outp .= '"redistribute_other_bgp":"' . $x["redistribute_other_bgp"] . '",';
			$outp .= '"router_idStr":"' . $x["router_idStr"] . '",';
            $outp .= '"sitename":"' . $x["sitename"] . '"}';
        }
        $outp .= "]";
    }
    
}
/* echo the result(s) */
echo ($outp);
?>