<?php
/*      Header information      */
/* Filename   : site_owner.php  */
/* Version    : 1.0             */
/* Mod Date   : 2015/11/29      */
/* Parameters : site_name       */

/* Init reqs */
session_start();
require($_SERVER['DOCUMENT_ROOT'] . '/auth/config.php');
require($_SERVER['DOCUMENT_ROOT'] . '/content/functions.php');

/* Default params setting */
$site_name          = 'DAFFY';
$site_name_data_row = "";


if (isset($_GET['site_name'])) {
    $site_name = $_GET['site_name'];
    
    if ($site_name != '') {
        /* The varible is not empty so we can work with it */
        /* main query */
        $site_name_data_query = "		
        SELECT b.irc_nick 'site_owner'
          FROM tbl_base_sites a, tbl_base_user b
         WHERE a.idSite_Owner = b.idtbl_base_user AND upper(a.Name) LIKE :site_name_param
        ORDER BY a.idSite_Owner DESC
         LIMIT 1;";
        
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
                    'site_owner' => $value['site_owner']
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
    } else {
        /* Build a response */
        $api_status_code     = 9;
        $response['status']  = $api_response_code[$api_status_code]['HTTP Response'];
        $response['message'] = $api_response_code[$api_status_code]['Message'] . " " . date("Y-m-d H:i:s");
        $response['data']    = 'Parameter supplied is empty';
    }
    
} else {
    /* No parameter value was passed */
    /* Build a response */
    $api_status_code     = 7;
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