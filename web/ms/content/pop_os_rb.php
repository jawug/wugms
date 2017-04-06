<?php
/* Load required functions */
require($_SERVER['DOCUMENT_ROOT'] . '/content/functions.php');
require($_SERVER['DOCUMENT_ROOT'] . '/auth/config.php');

/* Set the default output */
$most_installed_rb_os_row = '';
	/* Check if a serial number was supplied */
        $most_installed_rb_os_query = "SELECT count(*)'Counter', os_version 'OS_Level' FROM view_rb_overview where upper(rb_active) = 'Y' GROUP BY os_version ORDER BY Counter desc limit 1;";
        
		/* Try and execute the SQL */
        $most_installed_rb_os_stmt = $db->prepare($most_installed_rb_os_query);
        if ($most_installed_rb_os_stmt->execute()) {
            $most_installed_rb_os_row = $most_installed_rb_os_stmt->fetchAll();
        }
		
        if ($most_installed_rb_os_row) {
			/* There was feedback from the sql query so pack up thos results */
            foreach ($most_installed_rb_os_row as $key => $value) {
                $data[] = array(
					'Counter' => $value['Counter'],
					'OS_Level' => $value['OS_Level']
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