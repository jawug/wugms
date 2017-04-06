<?php
/* Load required functions */
require($_SERVER['DOCUMENT_ROOT'] . '/content/functions.php');
require($_SERVER['DOCUMENT_ROOT'] . '/auth/config.php');

/* Set the default output */
$most_installed_rb_row = '';
	/* Check if a serial number was supplied */
        $most_installed_rb_query = "select count(*)'Counter', board_model 'Routerboards'  from view_rb_overview where upper(rb_active) = 'Y' group by Board_model order by Counter desc limit 1;";
        
		/* Try and execute the SQL */
        $most_installed_rb_stmt = $db->prepare($most_installed_rb_query);
        if ($most_installed_rb_stmt->execute()) {
            $most_installed_rb_row = $most_installed_rb_stmt->fetchAll();
        }
		
        if ($most_installed_rb_row) {
			/* There was feedback from the sql query so pack up thos results */
            foreach ($most_installed_rb_row as $key => $value) {
                $data[] = array(
					'Counter' => $value['Counter'],
					'Routerboards' => $value['Routerboards']
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