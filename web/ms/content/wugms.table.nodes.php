<?php

/* Include the validation checker */
include($_SERVER['DOCUMENT_ROOT'] . '/auth/validate.php');
/* This is required for custom branding */
require($_SERVER['DOCUMENT_ROOT'] . '/content/branding.php');
require($_SERVER['DOCUMENT_ROOT'] . '/content/functions.php');

$wugms_table_nodes_row = '';
$outp                  = '[{}]';
                               
if (isset($_SESSION["id"])) {
    $wugms_table_nodes_query = "SELECT REPLACE(REPLACE(a.Descr, '<', '&lt;'), '>', '&gt;') Descr,
       FORMAT(a.InOctets, 0) 'InOctets',
       FORMAT(a.InUcastPkts, 0) 'InUcastPkts',
       FORMAT(a.OutOctets, 0) 'OutOctets',
       FORMAT(a.OutUcastPkts, 0) 'OutUcastPkts',
       if(
          a.RDate > DATE_sub(now(), INTERVAL 60 MINUTE),
          concat('<span style=\'color: rgb(0, 153, 0);\'>',
                 a.RDate,
                 '</span>'),
          concat('<span style=\'color: rgb(153, 0, 0);\'>',
                 a.RDate,
                 '</span>'))
          'seen'
  FROM tbl_base_snmp_common_interfaces_now a,
       (SELECT max(x.RDate) AS rdate, x.Descr
          FROM tbl_base_snmp_common_interfaces_now x
         WHERE x.Descr LIKE '%ovpn%' AND x.Serial_Number = '8X4U-HZZ9'
        GROUP BY Descr
        ORDER BY rdate) AS b
 WHERE b.rdate = a.rdate AND b.Descr = a.Descr;";
    
    /* Assign the parameters as per the selected level */
    
    
    
    $wugms_table_nodes_stmt = $db->prepare($wugms_table_nodes_query);
    if ($wugms_table_nodes_stmt->execute()) {
        $wugms_table_nodes_row = $wugms_table_nodes_stmt->fetchAll();
    }
    
    if ($wugms_table_nodes_row) {
        $outp = "[";
        foreach ($wugms_table_nodes_row as $x) {
            
            if ($outp != "[") {
                $outp .= ",";
            }
            $outp .= '{"seen":"' . $x["seen"] . '",';
            $outp .= '"Descr":"' . $x["Descr"] . '",';
			$outp .= '"InOctets":"' . $x["InOctets"] . '",';
			$outp .= '"InUcastPkts":"' . $x["InUcastPkts"] . '",';
			$outp .= '"OutOctets":"' . $x["OutOctets"] . '",';
            $outp .= '"OutUcastPkts":"' . $x["OutUcastPkts"] . '"}';
        }
        $outp .= "]";
    }
}

/* echo the result(s) */
echo ($outp);
?>