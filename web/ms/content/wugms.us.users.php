<?php
//session_start();
require($_SERVER['DOCUMENT_ROOT'] . '/auth/config.php');
        $us_users_query = "
SELECT @row_number := @row_number + 1 AS row_number,
       d.irc_nick 'user',
       d.date 'join_date',
       d.sites 'used_sites'
  FROM (SELECT a.irc_nick,
               DATE_FORMAT(a.cdate, '%Y-%m-%d') 'date',
               IFNULL(used_sites, 0) 'sites'
          FROM tbl_base_user a
               LEFT JOIN (SELECT count(*) 'used_sites', b.idSite_Owner
                            FROM tbl_base_sites b
                          GROUP BY b.idSite_Owner) b
                  ON a.idtbl_base_user = b.idSite_Owner
         WHERE username <> 'Unassigned'
        ORDER BY a.cdate DESC
         LIMIT 10) d,
       (SELECT @row_number := 0) AS t;";
	
    $us_users_stmt   = $db->prepare($us_users_query);

    if ($us_users_stmt->execute()) {
        $us_users_row = $us_users_stmt->fetchAll();
    }    ;
    
    if ($us_users_row) {
	
	
		$outp = "[";        
        foreach ($us_users_row as $x) {

    if ($outp != "[") {$outp .= ",";}
$outp .= '{"row_number":"'  . $x["row_number"] . '",';
$outp .= '"user":"'  . $x["user"] . '",';
$outp .= '"join_date":"'  . $x["join_date"] . '",';
$outp .= '"used_sites":"'  . $x["used_sites"]     . '"}';

			

}
$outp .="]";
        }
    echo($outp); 
?>