<?php

/* Include the validation checker */
include($_SERVER['DOCUMENT_ROOT'] . '/auth/validate.php');
/* This is required for custom branding */
require($_SERVER['DOCUMENT_ROOT'] . '/content/branding.php');
require($_SERVER['DOCUMENT_ROOT'] . '/content/functions.php');

if (isset($_SESSION["id"])) {
    
    $wugms_table_user_rb_header_row = '';
    $outp                           = '';
    
    $wugms_table_user_rb_header_query = "
SELECT p.ipv4,
       p.interface,
       p.network,
       p.maskbits,
	   if (p.status = 'Enabled', concat('<span style=\'color: rgb(0, 153, 0);\'>','Enabled','</span>'),concat('<span style=\'color: rgb(153, 0, 0);\'>','Disabled','</span>'))'status',
       p.comment,
       q.device_model,
       q.device_name,
       q.sitename
  FROM (SELECT device_model,
               device_name,
               sitename,
               b.sn
          FROM (SELECT sn
                  FROM (SELECT b.ae_Serial_Number 'sn'
                          FROM tbl_ae_sites_rbs b,
                               tbl_base_sites a,
                               tbl_base_sites c
                         WHERE     a.idSite_Owner = :id
                               AND b.ae_siteID = a.siteID
                               AND a.idSite_Owner = c.idSite_Owner) a
                UNION
                SELECT sn
                  FROM (SELECT d.Serial_Number 'sn'
                          FROM tbl_base_rb_routerboard d
                         WHERE idSite_Owner = :id) b) AS a
               INNER JOIN (SELECT a.Board_model 'device_model',
                                  a.RB_identity 'device_name',
                                  b.Name 'sitename',
                                  a.Serial_Number 'sn'
                             FROM tbl_base_rb_routerboard a, tbl_base_sites b
                            WHERE a.siteID = b.siteID) AS b
                  ON a.sn = b.sn
        ORDER BY b.SiteName, b.device_name) AS q
       LEFT JOIN (SELECT a.Serial_Number,
                         INET_NTOA(a.address) 'ipv4',
                         a.address 'address_raw',
                         a.interface_name 'interface',
                         a.network,
                         a.MaskBits 'maskbits',
                         if(a.disabled = 0, 'Enabled', 'Disabled') 'status',
                         a.comment
                    FROM tbl_base_rb_ipv4_config a
                  ORDER BY a.address) AS p
          ON q.sn = p.Serial_Number
ORDER BY p.address_raw";
    
    /* Assign the parameters as per the selected level */
    
    if (isset($_SESSION["id"])) {
        $wugms_table_user_rb_header_params = array(
            ':id' => $_SESSION["id"]
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
            $outp .= '{"ipv4":"' . $x["ipv4"] . '",';
            $outp .= '"interface":"' . $x["interface"] . '",';
            $outp .= '"network":"' . $x["network"] . '",';
            $outp .= '"maskbits":"' . $x["maskbits"] . '",';
            $outp .= '"status":"' . $x["status"] . '",';
            $outp .= '"comment":"' . $x["comment"] . '",';
            $outp .= '"device_model":"' . $x["device_model"] . '",';
            $outp .= '"device_name":"' . $x["device_name"] . '",';
            $outp .= '"sitename":"' . $x["sitename"] . '"}';
            
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