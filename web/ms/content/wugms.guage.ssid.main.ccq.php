<?php

session_start();
require($_SERVER['DOCUMENT_ROOT'] . '/auth/config.php');
require($_SERVER['DOCUMENT_ROOT'] . '/content/functions.php');


//if (isset($_SESSION["rb_ssid_id"])) {

$series1         = array();
$series1['name'] = 'Reading';
$result          = array();

if (isset($_SESSION['ov_ssid_name'])) {
    
    
    
    $snmp_ssid_main_oa_txccq_query = "SELECT overalltxccq FROM tbl_base_snmp_mikrotik_ap_now WHERE Serial_Number = :rb_sn and upper(SSID) = upper(:ssid_name);";
    
    // Check if the site_name supplied has not already been used
    $snmp_ssid_main_oa_txccq_query_params = array(
        ':rb_sn' => $_SESSION["ov_ssid_sn"],
        ':ssid_name' => $_SESSION["ov_ssid_name"]
    );
    
    $snmp_ssid_main_oa_txccq_stmt = $db->prepare($snmp_ssid_main_oa_txccq_query);
    if ($snmp_ssid_main_oa_txccq_stmt->execute($snmp_ssid_main_oa_txccq_query_params)) {
        $snmp_ssid_main_oa_txccq_row = $snmp_ssid_main_oa_txccq_stmt->fetchAll();
    }
    ;
    
    if ($snmp_ssid_main_oa_txccq_row) {
        
        foreach ($snmp_ssid_main_oa_txccq_row as $x) {
            
            $series1['data'][] = array(
                $x['overalltxccq']
            );
            array_push($result, $series1);
            
        }
        
        
    }
} else {
    $series1['data'][] = "";
    array_push($result, $series1);
    
}


print json_encode($result, JSON_NUMERIC_CHECK);
?>