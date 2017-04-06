<?php

session_start();
require($_SERVER['DOCUMENT_ROOT'] . '/auth/config.php');
require($_SERVER['DOCUMENT_ROOT'] . '/content/functions.php');


/* Determine if the ssid_level has been set */
$type_sel = "";
if (isset($_GET['ssid_level'])) {
    $type_sel = $_GET['ssid_level'];
}

$wugms_table_devices_client_row = '';
$outp                 = '';

#
$wugms_table_devices_client_query = "
SELECT device_make,
       device_model,
       os_ver,
       device_name,
       sitename,
       ifnull(seen_rbcp, 'N/A') 'seen_rbcp',
       ifnull(seen_snmp, 'N/A') 'seen_snmp'
  FROM (SELECT device_make,
               device_model,
               os_ver,
               device_name,
               sitename,
               seen_rbcp,
               dev_id
          FROM (SELECT sn
                  FROM (SELECT b.ae_Serial_Number 'sn'
                          FROM tbl_ae_sites_rbs b,
                               tbl_base_sites a,
                               tbl_base_sites c
                         WHERE     a.idSite_Owner = :user_id
                               AND b.ae_siteID = a.siteID
                               AND a.idSite_Owner = c.idSite_Owner) a
                UNION
                SELECT sn
                  FROM (SELECT d.Serial_Number 'sn'
                          FROM tbl_base_rb_routerboard d
                         WHERE idSite_Owner = :user_id ) b) AS a
               INNER JOIN (SELECT 'Mikrotik' AS 'device_make',
                                  a.Board_model 'device_model',
                                  a.OS_Version 'os_ver',
                                  a.RB_identity 'device_name',
                                  b.Name 'sitename',
                                  a.File_Date 'seen_rbcp',
                                  a.Software_ID 'dev_id',
                                  a.Serial_Number 'sn'
                             FROM tbl_base_rb_routerboard a, tbl_base_sites b
                            WHERE a.siteID = b.siteID) AS b
                  ON a.sn = b.sn
				  order by b.sitename) AS x
       LEFT JOIN (SELECT max(d.RDate) 'seen_snmp', d.SoftwareID 'dev_id'
                    FROM tbl_base_snmp_mikrotik_cdp_now d
                   WHERE d.IPAddressStr LIKE '172.16.%'
                  GROUP BY d.SoftwareID
                  ORDER BY max(d.RDate)) as y
                  on x.dev_id = y.dev_id;";



    if (isset($_SESSION["id"])) {
        /* Assign the parameters as per the selected level */
        $wugms_table_devices_client_query_params = array(
            ':user_id' => $_SESSION["id"]
        );
        $wugms_table_devices_client_stmt         = $db->prepare($wugms_table_devices_client_query);
        if ($wugms_table_devices_client_stmt->execute($wugms_table_devices_client_query_params)) {
            $wugms_table_devices_client_row = $wugms_table_devices_client_stmt->fetchAll();
        }
    }

// Check if the site_name supplied has not already been used


;

if ($wugms_table_devices_client_row) {
    $outp = "[";
    foreach ($wugms_table_devices_client_row as $x) {
        
        if ($outp != "[") {
            $outp .= ",";
        }
        $outp .= '{"device_make":"' . $x["device_make"] . '",';
        /*$outp .= '"device_make":"' . $x["device_make"] . '",'; */
        $outp .= '"device_model":"' . $x["device_model"] . '",';
        $outp .= '"os_ver":"' . $x["os_ver"] . '",';
        $outp .= '"device_name":"' . $x["device_name"] . '",';
        $outp .= '"sitename":"' . $x["sitename"] . '",';
        $outp .= '"seen_rbcp":"' . $x["seen_rbcp"] . '",';
        $outp .= '"seen_snmp":"' . $x["seen_snmp"] . '"}';

    }
    $outp .= "]";
} else {
    $outp = "[{}]";
}


echo ($outp);
// }
//}

?>