<?php
/* Load required functions */
require($_SERVER['DOCUMENT_ROOT'] . '/content/functions.php');
require($_SERVER['DOCUMENT_ROOT'] . '/auth/config.php');

/* Set the default output */
$ip_dups_row = '';
	/* Check if a serial number was supplied */
        $ip_dups_query = "Select count(*)'counter' from view_IPv4_Dups;";
        
		/* Try and execute the SQL */
        $ip_dups_stmt = $db->prepare($ip_dups_query);
        if ($ip_dups_stmt->execute()) {
            $ip_dups_row = $ip_dups_stmt->fetchAll();
        }
		
        if ($ip_dups_row) {
			/* There was feedback from the sql query so pack up thos results */
            foreach ($ip_dups_row as $key => $value) {
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