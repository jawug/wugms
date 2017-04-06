<?php

session_start();
require($_SERVER['DOCUMENT_ROOT'] . '/auth/config.php');
require($_SERVER['DOCUMENT_ROOT'] . '/content/functions.php');
$outp = '[{"name" : "current","data" : []}, {"name" : "temperature","data" : []}, {"name" : "voltage","data" : []}]';

if (isset($_SESSION["rb_sn"])) {
    
    $snmp_device_row   = '';
    /* Common SQL query*/
    $snmp_device_query = "SELECT a.idate,
       a.Serial_Number,
	 a.dev_reading,
                  a.reading
  FROM tbl_summary_snmp_mikrotik_device_5min a
 WHERE     RDate > NOW() - INTERVAL 7 DAY
       AND a.Serial_Number = :rb_sn
ORDER BY a.RDate, a.dev_reading;";
    
    
    
    
    // Check if the site_name supplied has not already been used
    $snmp_device_query_params = array(
        ':rb_sn' => $_SESSION["rb_sn"]
    );
    
    $snmp_device_stmt = $db->prepare($snmp_device_query);
    if ($snmp_device_stmt->execute($snmp_device_query_params)) {
        $snmp_device_row = $snmp_device_stmt->fetchAll();
    }
    
    
    
    if ($snmp_device_row) {
        $rows = array();
        $d    = array();
        foreach ($snmp_device_row as $x) {
            
            $res[$x['dev_reading']][] = array(
                $x['idate'],
                $x['reading']
            );
        }
        foreach ($res as $k => $i) {
            $tmp['name'] = $k;
            $tmp['data'] = $i;
            $result[]    = $tmp;
        }
        /* post the data */
        print json_encode($result, JSON_NUMERIC_CHECK);
        
    } else {
    
	echo $outp;   }
} else {
    echo $outp;
    
}
?>