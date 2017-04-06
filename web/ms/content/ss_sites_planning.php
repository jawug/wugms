<?php
/* Includes */
require($_SERVER['DOCUMENT_ROOT'] . '/auth/config.php');
// get data and store in a json array
$us_planning_sites_query = "SELECT count(*) 'Counter'
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
 WHERE y.ae_siteID IS NULL";
 
/* Magic */
$us_planning_sites_stmt = $db->prepare($us_planning_sites_query);

if ($us_planning_sites_stmt->execute()) {
    $us_planning_sites_row = $us_planning_sites_stmt->fetchAll();
}

/* Work the results */
if ($us_planning_sites_row) {
    foreach ($us_planning_sites_row as $x) {
		$results[] = array(
			'Counter' => $x['Counter']
		);
	}
	/* Send the result(s) */
	echo json_encode($results);
}
?>