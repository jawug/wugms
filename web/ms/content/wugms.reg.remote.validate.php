<?php
/* Start session */
session_start();
/* Load required functions */
require($_SERVER['DOCUMENT_ROOT'] . '/content/functions.php');
require($_SERVER['DOCUMENT_ROOT'] . '/auth/config.php');

/* init vars */
$isAvailable          = true;
$req_type             = '';
$site_name            = '';
$ircnick_check_row    = '';
$email_check_row      = '';
$edit_email_check_row = '';
$api_status_code      = '';

//if (!empty($_POST) && isset($_SESSION["id"])) {
if (!empty($_POST)) {	
    /* If the type is not set then exit */
    /* Check and set the parameters */
    if (!empty($_POST['type'])) {
        $req_type = strtoupper($_POST['type']);
        switch ($req_type) {
            case 'IRCNICK':
                if (!empty($_POST['ircnick'])) {
                    $ircnick                    = strtoupper($_POST['ircnick']);
                    /* SQL query */
                    $ircnick_check_query        = "SELECT 1 FROM tbl_base_user WHERE upper(irc_nick) = :ircnick;";
                    /* Parameters that will be used */
                    $ircnick_check_query_params = array(
                        ':ircnick' => $ircnick
                    );
                    /* Run the sql query */
                    $ircnick_check_stmt         = $db->prepare($ircnick_check_query);
                    if ($ircnick_check_stmt->execute($ircnick_check_query_params)) {
                        $ircnick_check_row = $ircnick_check_stmt->fetchAll();
                    }
                    /* Work with the results */
                    if ($ircnick_check_row) {
                        $isAvailable = false;
                    }
                    
                } else {
                    $api_status_code     = 0;
                    $response['status']  = $api_response_code[$api_status_code]['HTTP Response'];
                    $response['message'] = $api_response_code[$api_status_code]['Message'];
                }
                break;
            
            case 'EMAIL':
					if (!empty($_POST['email'])) { 
						$email                    = strtoupper($_POST['email']);

                    /* SQL query */
                    $email_check_query        = "SELECT 1 FROM tbl_base_user WHERE upper(username) = :email;";
                    /* Parameters that will be used */
                    $email_check_query_params = array(
                        ':email' => $email
                    );
                    /* Run the sql query */
                    $email_check_stmt         = $db->prepare($email_check_query);
                    if ($email_check_stmt->execute($email_check_query_params)) {
                        $email_check_row = $email_check_stmt->fetchAll();
                    }
                    /* Work with the results */
                    if ($email_check_row) {
                        $isAvailable = false;
                    }
                    
                } else {
                    $api_status_code     = 0;
                    $response['status']  = $api_response_code[$api_status_code]['HTTP Response'];
                    $response['message'] = $api_response_code[$api_status_code]['Message'];
                }
//                $email = $_POST['email'];
                break;

            case 'EDIT_EMAIL':
				if (!empty($_POST['edit_username'])&&!empty($_POST['edit_username_oem'])) { 
						$email     = strtoupper($_POST['edit_username']);
						$email_oem = strtoupper($_POST['edit_username_oem']);
                    /* SQL query */
                    $edit_email_check_query        = "SELECT 1 FROM tbl_base_user WHERE upper(username) = upper(:email) and not upper(username) = upper(:email_oem);";
                    /* Parameters that will be used */
                    $edit_email_check_query_params = array(
                        ':email' => $email,
						':email_oem' => $email_oem
                    );
                    /* Run the sql query */
                    $edit_email_check_stmt         = $db->prepare($edit_email_check_query);
                    if ($edit_email_check_stmt->execute($edit_email_check_query_params)) {
                        $edit_email_check_row = $edit_email_check_stmt->fetchAll();
                    }
                    /* Work with the results */
                    if ($edit_email_check_row) {
                        $isAvailable = false;
                    }
                    
                } else {
                    $api_status_code     = 0;
                    $response['status']  = $api_response_code[$api_status_code]['HTTP Response'];
                    $response['message'] = $api_response_code[$api_status_code]['Message'];
                }
                break;

            case 'EDIT_IRCNICK':
				if (!empty($_POST['edit_ircnick'])&&!empty($_POST['edit_ircnick_oem'])) { 
						$ircnick     = strtoupper($_POST['edit_ircnick']);
						$ircnick_oem = strtoupper($_POST['edit_ircnick_oem']);
                    /* SQL query */
                    $edit_ircnick_check_query        = "SELECT 1 FROM tbl_base_user WHERE upper(irc_nick) = upper(:ircnick) and not upper(irc_nick) = upper(:ircnick_oem);";
                    /* Parameters that will be used */
                    $edit_ircnick_check_query_params = array(
                        ':ircnick' => $ircnick,
						':ircnick_oem' => $ircnick_oem
                    );
                    /* Run the sql query */
                    $edit_ircnick_check_stmt         = $db->prepare($edit_ircnick_check_query);
                    if ($edit_ircnick_check_stmt->execute($edit_ircnick_check_query_params)) {
                        $edit_ircnick_check_row = $edit_ircnick_check_stmt->fetchAll();
                    }
                    /* Work with the results */
                    if ($edit_ircnick_check_row) {
                        $isAvailable = false;
                    }
                    
                } else {
                    $api_status_code     = 0;
                    $response['status']  = $api_response_code[$api_status_code]['HTTP Response'];
                    $response['message'] = $api_response_code[$api_status_code]['Message'];
                }
                break;
				
            default:
                $api_status_code     = 8;
                $response['status']  = $api_response_code[$api_status_code]['HTTP Response'];
                $response['message'] = $api_response_code[$api_status_code]['Message'];
                
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

if (!$api_status_code) {
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