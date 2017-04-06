<?php
/* Load required functions */
require($_SERVER['DOCUMENT_ROOT'] . '/content/functions.php');
require($_SERVER['DOCUMENT_ROOT'] . '/auth/config.php');

/* Set the default output */
$ip_unique_row = '';
	/* Check if a serial number was supplied */
        $ip_unique_query = "Select count(*)'counter' from view_IPv4_Unique;";
        
		/* Try and execute the SQL */
        $ip_unique_stmt = $db->prepare($ip_unique_query);
        if ($ip_unique_stmt->execute()) {
            $ip_unique_row = $ip_unique_stmt->fetchAll();
        }
		
        if ($ip_unique_row) {
			/* There was feedback from the sql query so pack up thos results */
            foreach ($ip_unique_row as $key => $value) {
                $data[] = array(
					'counter' => $value['counter']
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
                'counter' => 'No data'
            );
        }

/* Publish the results */
header('HTTP/1.1 ' . $response['status'] . ' ' . $http_response_code[$response['status']]);
header('Content-Type: application/json; charset=utf-8');
$json_response = json_encode($response);
echo $json_response;
?>