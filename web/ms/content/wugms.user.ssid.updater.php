<?php
/* Start a session */
session_start();
/* Load required functions */
require($_SERVER['DOCUMENT_ROOT'] . '/content/functions.php');
require($_SERVER['DOCUMENT_ROOT'] . '/auth/config.php');

/* Basic vars */
/*
ov_ssid_name	WWW.JAWUG.ZA.NET/NR1
ov_ssid_sn		51A50418D389
*/
/* If no user is logged in then abort */
if (isset($_SESSION["id"])) {
    /* If empty post then abort */
    if (!empty($_POST)) {
        /* If rquired vars are not there then abort */
        if ((isset($_POST["ov_ssid_name"])) && (isset($_POST["ov_ssid_sn"]))) {
            /* there is a user*/
            /* See if the user has access to the selected serial number */
            $ssid_id_sn_check_query = "
            SELECT ap.AP_ID
              FROM tbl_base_snmp_mikrotik_ap_now ap
             WHERE     ap.Serial_Number = :rb_sn
                   AND upper(ap.SSID) LIKE :ssid_name
            GROUP BY ap.rdate, ap.Serial_Number, ap.ssid
            ORDER BY ap.rdate DESC
             LIMIT 1;";
            /* Assign the variables */
            $ssid_id_sn_check_query_params = array(
                ':rb_sn' => $_POST["ov_ssid_sn"],
                ':ssid_name' => strtoupper($_POST["ov_ssid_name"])
                
                //':ssid_name' => "WWW.JAWUG.ZA.NET/NR1"
                //':rb_sn' => "51A50418D389"
            );
            /* Run the SQL query */
            $ssid_id_sn_check_stmt = $db->prepare($ssid_id_sn_check_query);
            if ($ssid_id_sn_check_stmt->execute($ssid_id_sn_check_query_params)) {
                $ssid_id_sn_check_row = $ssid_id_sn_check_stmt->fetchAll();
            }
            /* Work with the results */
            if ($ssid_id_sn_check_row) {
                foreach ($ssid_id_sn_check_row as $x) {
                    /* The supplied user and serial number are allowed */
                    /* Using the posted vars */
                    $_SESSION["ov_ssid_id"]   = $x["AP_ID"];
                    $_SESSION["ov_ssid_name"] = $_POST["ov_ssid_name"];
                    $_SESSION["ov_ssid_sn"]   = $_POST["ov_ssid_sn"];
                }
                $api_status_code     = 1;
                $response['status']  = $api_response_code[$api_status_code]['HTTP Response'];
                $response['message'] = $api_response_code[$api_status_code]['Message'];
                $response['data']    = "Selection updated.";
            } else {
                /* The supplied user and serial number are NOT allowed */
                $api_status_code     = 7;
                $response['status']  = $api_response_code[$api_status_code]['HTTP Response'];
                $response['message'] = $api_response_code[$api_status_code]['Message'];
            }
        } else {
            /* There is no logged in user */
            $api_status_code     = 7;
            $response['status']  = $api_response_code[$api_status_code]['HTTP Response'];
            $response['message'] = $api_response_code[$api_status_code]['Message'];
            $response['data']    = "weird posting";
        }
    } else {
        /* There is no logged in user */
        $api_status_code     = 7;
        $response['status']  = $api_response_code[$api_status_code]['HTTP Response'];
        $response['message'] = $api_response_code[$api_status_code]['Message'];
        $response['data']    = "empty posting";
    }
} else {
    $api_status_code     = 3;
    $response['status']  = $api_response_code[$api_status_code]['HTTP Response'];
    $response['message'] = $api_response_code[$api_status_code]['Message'];
    $response['data']    = "not logged in";
}

/* Deliver results */
header('HTTP/1.1 ' . $response['status'] . ' ' . $http_response_code[$response['status']]);
header('Content-Type: application/json; charset=utf-8');
$json_response = json_encode($response);
echo $json_response;
?>