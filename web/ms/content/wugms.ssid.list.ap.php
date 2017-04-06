<?php
/* Start session */
session_start();
/* Load required functions */
require($_SERVER['DOCUMENT_ROOT'] . '/content/functions.php');
require($_SERVER['DOCUMENT_ROOT'] . '/auth/config.php');

/* Set the default output */
$outp         = "[{}]";
$user_rbs_row = '';

/* Check if there is a user logged in */
if (isset($_SESSION["id"])) {
    
	/* Check if a serial number was supplied */
    if (isset($_GET['device'])) {
        $device         = $_GET['device'];
        $user_rbs_query = "
SELECT Serial_Number,
       ID,
       descr,
       IFace_Type
  FROM tbl_base_snmp_common_interfaces_now
 WHERE     Serial_Number = :device_id
       AND (IFace_Type = 'ethernet-csmacd' OR IFace_Type = 'ieee80211')
ORDER BY id;";
        
        
        /* Set parameters for the query */
        $user_rbs_query_params = array(
            ':device_id' => $device
        );
        
		/* Try and execute the SQL */
        $user_rbs_stmt = $db->prepare($user_rbs_query);
        if ($user_rbs_stmt->execute($user_rbs_query_params)) {
            $user_rbs_row = $user_rbs_stmt->fetchAll();
        }
		
        if ($user_rbs_row) {
			/* There was feedback from the sql query so pack up thos results */
            foreach ($user_rbs_row as $key => $value) {
                $data[] = array(
                    'id' => $value['ID'] . "___" . $value["descr"] . "___" . $value["IFace_Type"],
                    'text' => $value["descr"]
                );
            }
            $api_status_code     = 1;
            $response['status']  = $api_response_code[$api_status_code]['HTTP Response'];
            $response['message'] = $api_response_code[$api_status_code]['Message'];
            $response['data']    = $data;
        } else {
            /* Seems like there were no results from the SQL query */
            $api_status_code     = 7;
            $response['status']  = $api_response_code[$api_status_code]['HTTP Response'];
            $response['message'] = $api_response_code[$api_status_code]['Message'];
            $data[]              = array(
                'id' => '0',
                'text' => 'No Interfaces Found'
            );
        }
        

    } else {
		/* Someone didn't supply a devices serial number */
        $api_status_code     = 7;
        $response['status']  = $api_response_code[$api_status_code]['HTTP Response'];
        $response['message'] = $api_response_code[$api_status_code]['Message'];
        $data[]              = array(
            'id' => '0',
            'text' => 'No Interfaces Found'
        );
    }
    
} else {
	/* Seems like someone wasn't logged in */
    $api_status_code     = 3;
    $response['status']  = $api_response_code[$api_status_code]['HTTP Response'];
    $response['message'] = $api_response_code[$api_status_code]['Message'];
}

/* Publish the results */
header('HTTP/1.1 ' . $response['status'] . ' ' . $http_response_code[$response['status']]);
header('Content-Type: application/json; charset=utf-8');
$json_response = json_encode($response);
echo $json_response;
?>