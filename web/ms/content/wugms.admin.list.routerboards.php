<?php
/* Start session */
session_start();
require($_SERVER['DOCUMENT_ROOT'] . '/auth/config.php');
require($_SERVER['DOCUMENT_ROOT'] . '/content/functions.php');

/* Set the default output */
$outp         = "[{}]";
$user_rbs_row = '';

if (isset($_SESSION["id"])) {
    $user_rbs_query = "
SELECT device_make,
       device_model,
       os_ver,
       device_name,
       sitename,
       b.sn
  FROM (SELECT sn
          FROM (SELECT b.ae_Serial_Number 'sn'
                  FROM tbl_ae_sites_rbs b, tbl_base_sites a, tbl_base_sites c
                 WHERE     a.idSite_Owner = :user_id
                       AND b.ae_siteID = a.siteID
                       AND a.idSite_Owner = c.idSite_Owner) a
        UNION
        SELECT sn
          FROM (SELECT d.Serial_Number 'sn'
                  FROM tbl_base_rb_routerboard d
                 WHERE idSite_Owner = :user_id) b) AS a
       INNER JOIN (SELECT 'Mikrotik' AS 'device_make',
                          a.Board_model 'device_model',
                          a.OS_Version 'os_ver',
                          a.RB_identity 'device_name',
                          b.Name 'sitename',
                          a.Serial_Number 'sn'
                     FROM tbl_base_rb_routerboard a, tbl_base_sites b
                    WHERE a.siteID = b.siteID) AS b
          ON a.sn = b.sn
ORDER BY b.SiteName, b.device_name;";
    
    
    // Set parameters for the query
    $user_rbs_query_params = array(
        ':user_id' => $_SESSION["id"]
    );
    
    $user_rbs_stmt = $db->prepare($user_rbs_query);
    if ($user_rbs_stmt->execute($user_rbs_query_params)) {
        $user_rbs_row = $user_rbs_stmt->fetchAll();
    }
    

   foreach ($user_rbs_row as $key => $value) {
//	$data[] = array('id' => $value['sn'], 'text' => $value['device_name']);	
//          $data[] = array('id' => $value['sn'], 'text' => $value["sitename"] . " -> " . $value["device_name"] );
	$data[] = array('id' => $value['sn'] . "___" . $value["sitename"] . "___" . $value["device_name"], 'text' => $value["sitename"] . " -> " . $value["device_name"] );	
   } 
} else {
   $data[] = array('id' => '0', 'text' => 'No Routerboards Found');
}

// return the result in json
//echo json_encode($data);	
print json_encode($data, JSON_NUMERIC_CHECK);
    
    

/* echo the result(s) */
//echo $outp;
//print json_encode($outp, JSON_NUMERIC_CHECK);
?>