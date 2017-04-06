<?php
/*     Header information     */
/* Filename   : sites.php     */
/* Version    : 1.0           */
/* Mod Date   : 2015/12/05    */
/* Parameters : site_name     */

/* Init reqs */
session_start();
require($_SERVER['DOCUMENT_ROOT'] . '/auth/config.php');
require($_SERVER['DOCUMENT_ROOT'] . '/content/functions.php');

/* Default params setting */
$site_name          = '';
$site_name_data_row = "";


/* Get the site_name */
if (isset($_GET['site_name'])) {
    $site_name = $_GET['site_name'];
} else {
    $site_name = '';
}

/* main query */
$site_name_data_query = "
SELECT t.sitename, t.status
  FROM (SELECT i.sitename, i.status
          FROM (SELECT a.Name 'sitename', 'active' AS status
                  FROM tbl_base_sites a,
                       tbl_base_user b,
                       tbl_ae_sites_rbs d,
                       tbl_base_rb_routerboard e
                 WHERE     a.siteID = d.ae_siteID
                       AND d.ae_Serial_Number = e.Serial_Number
                       AND a.idSite_Owner = b.idtbl_base_user
                GROUP BY a.name
                ORDER BY a.name) AS i
        UNION
        SELECT u.sitename, u.status
          FROM (SELECT x.sitename, 'planning' AS status
                  FROM (SELECT a.Name 'sitename', a.siteid
                          FROM tbl_base_sites a, tbl_base_user b
                         WHERE     a.idSite_Owner = b.idtbl_base_user
                               AND b.idtbl_base_user <> 1
                        ORDER BY a.Name) AS x
                       LEFT JOIN (SELECT c.ae_siteID
                                    FROM tbl_ae_sites_rbs c
                                  GROUP BY c.ae_siteID) AS y
                          ON x.siteid = y.ae_siteID
                 WHERE y.ae_siteID IS NULL
                ORDER BY x.sitename) AS u) AS t
 WHERE upper(t.sitename) LIKE :site_name_param 
  order by t.sitename;";

/* Set parameters for the query */
$site_name_data_params = array(
    ':site_name_param' => '%' . strtoupper($site_name) . '%'
);

/* Execute the SQL query */
$site_name_data_stmt = $db->prepare($site_name_data_query);
if ($site_name_data_stmt->execute($site_name_data_params)) {
    $site_name_data_row = $site_name_data_stmt->fetchAll();
}

/* Check is there are any returned datasets */
if ($site_name_data_row) {
    /* Works through the results and get them into an array */
    foreach ($site_name_data_row as $key => $value) {
        $data[] = array(
            'sitename' => $value['sitename'],
            'status' => $value['status']
        );
    }
    /* Build a response */
    $api_status_code     = 1;
    $response['status']  = $api_response_code[$api_status_code]['HTTP Response'];
    $response['message'] = $api_response_code[$api_status_code]['Message'] . " " . date("Y-m-d H:i:s");
    $response['data']    = $data;
    
} else {
    /* There are no datasets returned */
    /* Build a response */
    $api_status_code     = 8;
    $response['status']  = $api_response_code[$api_status_code]['HTTP Response'];
    $response['message'] = $api_response_code[$api_status_code]['Message'] . " " . date("Y-m-d H:i:s");
    $response['data']    = 'No data';
    
}

/* Build the header */
header('HTTP/1.1 ' . $response['status'] . ' ' . $http_response_code[$response['status']]);
header('Content-Type: application/json; charset=utf-8');
$json_response = json_encode($response, JSON_NUMERIC_CHECK);
/* Deliver results */
echo $json_response;
?>