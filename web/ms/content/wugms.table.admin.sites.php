<?php

/* Include the validation checker */
include($_SERVER['DOCUMENT_ROOT'] . '/auth/validate.php');
/* This is required for custom branding */
require($_SERVER['DOCUMENT_ROOT'] . '/content/branding.php');
require($_SERVER['DOCUMENT_ROOT'] . '/content/functions.php');
$json_data = "";
if (isValueInRoleArray($_SESSION["roles"], "admin")) {

    $wugms_table_admin_sites_row = '';
    /* SQL - Query */
    $wugms_table_admin_sites_query = "
SELECT a.siteID,
       a.Name 'sitename',
       b.irc_nick 'site_owner',
       a.longitude,
       a.latitude,
       a.height,
       a.idSite_Owner,
       a.CDate,
       if(a.MDate + 0 > 0, a.MDate, '-') 'mdate',
       ifnull(a.suburb, '-') 'suburb'
  FROM tbl_base_sites a, tbl_base_user b
 WHERE a.idSite_Owner = b.idtbl_base_user
ORDER BY a.Name;";
    /* SQL - Exec */
    $wugms_table_admin_sites_stmt = $db->prepare($wugms_table_admin_sites_query);
    if ($wugms_table_admin_sites_stmt->execute()) {
        $wugms_table_admin_sites_row = $wugms_table_admin_sites_stmt->fetchAll();
    }
    /* SQL - Result(s) */
    if ($wugms_table_admin_sites_row) {
        $json_data = json_encode($wugms_table_admin_sites_row);
    }
    echo ($json_data);
}
?>