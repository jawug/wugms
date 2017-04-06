<?php

/* Include the validation checker */
include($_SERVER['DOCUMENT_ROOT'] . '/auth/validate.php');
/* This is required for custom branding */
require($_SERVER['DOCUMENT_ROOT'] . '/content/branding.php');
require($_SERVER['DOCUMENT_ROOT'] . '/content/functions.php');

if (isValueInRoleArray($_SESSION["roles"], "admin")) {

    $wugms_table_devices_client_row = '';
    $outp                           = '';
    
    #
    $wugms_table_devices_client_query = "
SELECT @row_number := @row_number + 1 AS row_number,
       x.device_make,
       x.device_model,
       x.os_ver,
       x.device_name,
       x.seen_rbcp,
       x.dev_id,
       x.sn,
       x.cdn_owner,
       x.sitename,
       x.site_owner_name,
       y.seen_snmp
  FROM (SELECT a.device_make,
               a.device_model,
               a.os_ver,
               a.device_name,
               a.seen_rbcp,
               a.dev_id,
               a.sn,
               a.cdn_owner,
               b.sitename,
               b.site_owner_name
          FROM (SELECT 'Mikrotik' AS 'device_make',
                       a.Board_model 'device_model',
                       a.OS_Version 'os_ver',
                       a.RB_identity 'device_name',
                       a.File_Date 'seen_rbcp',
                       a.Software_ID 'dev_id',
                       a.Serial_Number 'sn',
                       c.irc_nick 'cdn_owner',
                       siteID
                  FROM tbl_base_rb_routerboard a, tbl_base_user c
                 WHERE c.idtbl_base_user = a.idSite_Owner) AS a,
               (SELECT b.siteID,
                       b.Name 'sitename',
                       b.idSite_Owner,
                       c.irc_nick 'site_owner_name'
                  FROM tbl_base_sites b, tbl_base_user c
                 WHERE b.idSite_Owner = c.idtbl_base_user) AS b
         WHERE b.siteID = a.siteID
				  order by b.sitename) AS x
       LEFT JOIN (SELECT max(d.RDate) 'seen_snmp', d.SoftwareID 'dev_id'
                    FROM tbl_base_snmp_mikrotik_cdp_now d
                   WHERE d.IPAddressStr LIKE '172.16.%'
                  GROUP BY d.SoftwareID
                  ORDER BY max(d.RDate)) AS y
          ON x.dev_id = y.dev_id, (SELECT @row_number := 0) AS t";

        $wugms_table_devices_client_stmt         = $db->prepare($wugms_table_devices_client_query);
        if ($wugms_table_devices_client_stmt->execute()) {
            $wugms_table_devices_client_row = $wugms_table_devices_client_stmt->fetchAll();
        }

    
    if ($wugms_table_devices_client_row) {
        $outp = "[";
        foreach ($wugms_table_devices_client_row as $x) {
            
            if ($outp != "[") {
                $outp .= ",";
            }
        $outp .= '{"row_number":"' . $x["row_number"] . '",';            
			$outp .= '"device_make":"' . $x["device_make"] . '",';
            $outp .= '"device_model":"' . $x["device_model"] . '",';
            $outp .= '"os_ver":"' . $x["os_ver"] . '",';
            $outp .= '"device_name":"' . $x["device_name"] . '",';
			$outp .= '"sn":"' . $x["sn"] . '",';
            $outp .= '"sitename":"' . $x["sitename"] . '",';
            $outp .= '"cdn_owner":"' . $x["cdn_owner"] . '",';
            $outp .= '"site_owner_name":"' . $x["site_owner_name"] . '",';
            $outp .= '"seen_rbcp":"' . $x["seen_rbcp"] . '",';
            $outp .= '"seen_snmp":"' . $x["seen_snmp"] . '"}';
        }
        $outp .= "]";
    }
    
}
/* echo the result(s) */
echo ($outp);
?>