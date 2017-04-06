<?php

session_start();
require($_SERVER['DOCUMENT_ROOT'] . '/auth/config.php');
require($_SERVER['DOCUMENT_ROOT'] . '/content/functions.php');
$outp = '[{}]';

if (isset($_SESSION["id"])) {
    
    $snmp_storage_row = '';
    
    #
    $snmp_storage_query = "
SELECT a.rdate,
       a.idate,
       a.Serial_Number,
       a.Description,
       free_percentage AS store_free_per
  FROM tbl_summary_snmp_common_storage_5min a
 WHERE     RDate > NOW() - INTERVAL 7 DAY
       AND a.Serial_Number = :rb_sn
       AND a.Description IS NOT NULL
ORDER BY a.RDate;";
    
    // Check if the site_name supplied has not already been used
    $snmp_storage_query_params = array(
        ':rb_sn' => $_SESSION["rb_sn"]
    );
    
    $snmp_storage_stmt = $db->prepare($snmp_storage_query);
    if ($snmp_storage_stmt->execute($snmp_storage_query_params)) {
        $snmp_storage_row = $snmp_storage_stmt->fetchAll();
    }
    
    
    $series1 = array();
    //    $result = array();
    if ($snmp_storage_row) {
        $rows = array();
        $d    = array();
        foreach ($snmp_storage_row as $x) {
            
            $res[$x['Description']][] = array(
                $x['idate'],
                $x['store_free_per']
            );
        }
        foreach ($res as $k => $i) {
            $tmp['name'] = $k;
            $tmp['data'] = $i;
            $result[]    = $tmp;
        }
        /* post the data */
        print json_encode($result, JSON_NUMERIC_CHECK);
        
        
        
        
    }
    /* Send default output */
    
} else {
    echo $outp;
}
?>