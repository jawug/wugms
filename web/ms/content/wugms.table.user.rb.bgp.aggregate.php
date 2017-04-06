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
SELECT if(a.advertise_filter = '', '-', a.advertise_filter) 'advertise_filter',
       if(a.attribute_filter = '', '-', a.attribute_filter) 'attribute_filter',
	   if (a.disabled = 0, concat('<span style=\'color: rgb(0, 153, 0);\'>','Enabled','</span>'),concat('<span style=\'color: rgb(153, 0, 0);\'>','Disabled','</span>'))'status',
       if(a.include_igp = 0, 'No', 'Yes') 'include_igp',
       if(a.inherit_attributes = 0, 'No', 'Yes') 'inherit_attributes',
       a.instance,
       a.prefixStr,
       if(a.summary_only = 0, 'No', 'Yes') 'summary_only',
       if(a.suppress_filter = '', '-', a.suppress_filter) 'suppress_filter'
  FROM tbl_base_rb_routing_bgp_aggregate_config a
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
            $outp .= '{"advertise_filter":"' . $x["advertise_filter"] . '",';
            $outp .= '"attribute_filter":"' . $x["attribute_filter"] . '",';
            $outp .= '"status":"' . $x["status"] . '",';
			
            $outp .= '"include_igp":"' . $x["include_igp"] . '",';
            $outp .= '"inherit_attributes":"' . $x["inherit_attributes"] . '",';
            $outp .= '"instance":"' . $x["instance"] . '",';
			
            $outp .= '"prefixStr":"' . $x["prefixStr"] . '",';
			$outp .= '"summary_only":"' . $x["summary_only"] . '",';
            $outp .= '"suppress_filter":"' . $x["suppress_filter"] . '"}';
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