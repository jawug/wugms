<?php

/* Include the validation checker */
include($_SERVER['DOCUMENT_ROOT'] . '/auth/validate.php');
/* This is required for custom branding */
require($_SERVER['DOCUMENT_ROOT'] . '/content/branding.php');
require($_SERVER['DOCUMENT_ROOT'] . '/content/functions.php');

/* Set the default output */
$outp = "[{}]";

if (isValueInRoleArray($_SESSION["roles"], "admin")) {
    
	wugmsaudit("ADMIN", "rb_review", "review_data", $_SESSION["irc_nick"] . " (" . $_SESSION["id"] .  ") viewed tbl_base_rb_ipv4_config ");
		
        $wugms_table_user_rb_header_row = '';
        $outp                           = '';
        
        $wugms_table_user_rb_header_query = "
SELECT p.ipv4,
       p.interface,
       p.network,
       p.maskbits,
       p.interface_name,
	   if (p.status = 'Enabled', concat('<span style=\'color: rgb(0, 153, 0);\'>','Enabled','</span>'),concat('<span style=\'color: rgb(153, 0, 0);\'>','Disabled','</span>'))'status',
       p.comment,
       p.addressStr,
       q.device_model,
       lower(REPLACE(concat(p.interface_name,
                      '.',
                      q.device_model,
                      '.',
                      q.device_name,
                      '.',
                      q.sitename,
                      '.jawug'),
               ' ',
               ''))
          'rdns',
       q.device_name,
       q.sitename
  FROM (SELECT a.Board_model 'device_model',
               a.RB_identity 'device_name',
               b.Name 'sitename',
               a.Serial_Number 'sn'
          FROM tbl_base_rb_routerboard a, tbl_base_sites b
         WHERE a.siteID = b.siteID
        ORDER BY b.Name, a.RB_identity) AS q
       LEFT JOIN (SELECT a.Serial_Number,
                         INET_NTOA(a.address) 'ipv4',
                         a.address 'address_raw',
                         a.interface_name 'interface',
                         a.network,
                         a.addressStr,
                         a.MaskBits 'maskbits',
                         if(a.disabled = 0, 'Enabled', 'Disabled') 'status',
                         a.interface_name,
                         a.comment
                    FROM tbl_base_rb_ipv4_config a
					where a.addressStr like '172.%'
                  ORDER BY a.address) AS p
          ON q.sn = p.Serial_Number
ORDER BY p.address_raw;";
        
        /* Assign the parameters as per the selected level */
    
    /* Assign the parameters as per the selected device */
    
        $wugms_table_user_rb_header_stmt   = $db->prepare($wugms_table_user_rb_header_query);
        if ($wugms_table_user_rb_header_stmt->execute()) {
            $wugms_table_user_rb_header_row = $wugms_table_user_rb_header_stmt->fetchAll();
        }

    
        // Check if the site_name supplied has not already been used
        
        
        if ($wugms_table_user_rb_header_row) {
            $outp = "[";
            foreach ($wugms_table_user_rb_header_row as $x) {
                
                if ($outp != "[") {
                    $outp .= ",";
                }
                $outp .= '{"ipv4":"' . $x["ipv4"] . '",';
                $outp .= '"interface":"' . $x["interface"] . '",';
                $outp .= '"network":"' . $x["network"] . '",';
                $outp .= '"maskbits":"' . $x["maskbits"] . '",';
                $outp .= '"status":"' . $x["status"] . '",';
				$outp .= '"addressStr":"' . $x["addressStr"] . '",';
                $outp .= '"comment":"' . $x["comment"] . '",';
                $outp .= '"device_model":"' . $x["device_model"] . '",';
				$outp .= '"rdns":"' . $x["rdns"] . '",';
                $outp .= '"device_name":"' . $x["device_name"] . '",';
                $outp .= '"sitename":"' . $x["sitename"] . '"}';
                
        }
        $outp .= "]";
    }
    
}
/* echo the result(s) */
echo ($outp);
?>