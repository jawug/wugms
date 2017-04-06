<?php
/* Start session */
session_start();
/* Load required functions */
require($_SERVER['DOCUMENT_ROOT'] . '/content/functions.php');
require($_SERVER['DOCUMENT_ROOT'] . '/auth/config.php');

/* init vars */
$isAvailable      = true;
$req_type         = '';
$site_name        = '';
$name_of_site_row = '';
$api_status_code  = '';

if (!empty($_POST) && isset($_SESSION["id"])) {
    /* If the type is not set then exit */
	/* Check and set the parameters */
    if (!empty($_POST['type'])) {
        $req_type = strtoupper($_POST['type']);
		
		if (!empty($_POST['site_name'])) {
			$site_name = strtoupper($_POST['site_name']);
		}

        switch ($req_type) {
            /* Seeing as this is the checking of the site's name this will be the procedure */
            case 'NAME_OF_SITE':
                /* SQL query */
                $name_of_site_query = "SELECT 1 FROM tbl_base_sites WHERE upper(name) = :site_name and idSite_Owner = :idSite_Owner;";
                /* Parameters that will be used */
                $name_of_site_query_params = array(
                    ':site_name' => $site_name,
                    ':idSite_Owner' => $_SESSION["id"]
                );
                /* Run the sql query */
                $name_of_site_stmt = $db->prepare($name_of_site_query);
                if ($name_of_site_stmt->execute($name_of_site_query_params)) {
                    $name_of_site_row = $name_of_site_stmt->fetchAll();
                }
                /* Work with the results */
                if ($name_of_site_row) {
                    $isAvailable = false;
                }
                break;
            
            case 'NAME_OF_SITE_ADMIN':
            default:
                /* SQL query */
                $name_of_site_admin_query = "SELECT 1 FROM tbl_base_sites WHERE upper(name) = :site_name and idSite_Owner = :idSite_Owner;";
                /* Parameters that will be used */
                $name_of_site_admin_query_params = array(
                    ':site_name' => $site_name,
                    ':idSite_Owner' => $_SESSION["id"]
                );
                /* Run the sql query */
                $name_of_site_admin_stmt = $db->prepare($name_of_site_admin_query);
                if ($name_of_site_admin_stmt->execute($name_of_site_admin_query_params)) {
                    $name_of_site_row = $name_of_site_admin_stmt->fetchAll();
                }
                /* Work with the results */
                if ($name_of_site_row) {
                    $isAvailable = false;
                }
                break;
        }
    } else {
        $api_status_code     = 7;
        $response['status']  = $api_response_code[$api_status_code]['HTTP Response'];
        $response['message'] = $api_response_code[$api_status_code]['Message'];

    }
 
} else {
    $api_status_code     = 6;
    $response['status']  = $api_response_code[$api_status_code]['HTTP Response'];
    $response['message'] = $api_response_code[$api_status_code]['Message'];
}

if (!$api_status_code){
    echo json_encode(array(
        'valid' => $isAvailable
    ));	
	
} else {
	/* Publish the results */
header('HTTP/1.1 ' . $response['status'] . ' ' . $http_response_code[$response['status']]);
header('Content-Type: application/json; charset=utf-8');
$json_response = json_encode($response);
echo $json_response;
}

?>