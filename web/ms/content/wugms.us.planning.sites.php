<?php
/* Includes */
require($_SERVER['DOCUMENT_ROOT'] . '/auth/config.php');

/* vars */
$us_planning_sites_row ='';
$outp ='[{}]';

/* Main SQL */
$us_planning_sites_query = "
SELECT x.sitename,
       x.site_owner,
       x.cdate,
       x.mdate,
       if(x.suburb='','-',x.suburb) 'suburb'
  FROM (SELECT a.Name 'sitename',
               b.irc_nick 'site_owner',
               a.cdate,
               a.mdate,
               a.suburb,
               a.siteid
          FROM tbl_base_sites a, tbl_base_user b
         WHERE a.idSite_Owner = b.idtbl_base_user
		 and b.idtbl_base_user <> 1
        ORDER BY a.Name) AS x
       LEFT JOIN (SELECT c.ae_siteID
                    FROM tbl_ae_sites_rbs c
                  GROUP BY c.ae_siteID) AS y
          ON x.siteid = y.ae_siteID
 WHERE y.ae_siteID IS NULL
ORDER BY x.sitename, x.site_owner;
         ";

/* Magic */
$us_planning_sites_stmt = $db->prepare($us_planning_sites_query);

if ($us_planning_sites_stmt->execute()) {
    $us_planning_sites_row = $us_planning_sites_stmt->fetchAll();
}

/* Work the results */
if ($us_planning_sites_row) {
    $outp = "[";
    foreach ($us_planning_sites_row as $x) {
        
        if ($outp != "[") {
            $outp .= ",";
        }
        $outp .= '{"sitename":"' . $x["sitename"] . '",';
        $outp .= '"site_owner":"' . $x["site_owner"] . '",';
        $outp .= '"cdate":"' . $x["cdate"] . '",';
        $outp .= '"mdate":"' . $x["mdate"] . '",';
        $outp .= '"suburb":"' . $x["suburb"] . '"}';
    }
    $outp .= "]";
}
/* Send the result(s) */
echo ($outp);
?>