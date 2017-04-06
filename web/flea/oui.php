<?php
/*     Header information     */
/* Filename   : sites.php     */
/* Version    : 1.0           */
/* Mod Date   : 2015/12/05    */
/* Parameters : oui     */

/* Init reqs */
session_start();
require($_SERVER['DOCUMENT_ROOT'] . '/auth/config.php');
require($_SERVER['DOCUMENT_ROOT'] . '/content/functions.php');

/* Default params setting */
$oui          = '';
$oui_data_row = "";


/* Get the oui */
if (isset($_GET['oui'])) {
    $oui = $_GET['oui'];
} else {
    $oui = '';
}

/* main query */
$oui_data_query = "SELECT b.mac_prefix, lower(b.mac_owner) as mac_owner FROM tbl_base_oui b where upper(mac_prefix) like :oui_param order by b.mac_prefix, b.mac_owner;";

/* Set parameters for the query */
$oui_data_params = array(
    ':oui_param' => '%' . strtoupper($oui) . '%'
);

/* Execute the SQL query */
$oui_data_stmt = $db->prepare($oui_data_query);
if ($oui_data_stmt->execute($oui_data_params)) {
    $oui_data_row = $oui_data_stmt->fetchAll();
}

/* Check is there are any returned datasets */
if ($oui_data_row) {
    /* Works through the results and get them into an array */
    foreach ($oui_data_row as $key => $value) {
        $data[] = array(
            'prefix' => $value['mac_prefix'],
            'owner' => ucwords($value['mac_owner'])
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