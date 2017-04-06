<?php
/* Load required functions */
require($_SERVER['DOCUMENT_ROOT'] . '/content/functions.php');
require($_SERVER['DOCUMENT_ROOT'] . '/auth/config.php');

/* Set the default output */
$user_rbs_row = '';
	/* Check if a serial number was supplied */
        $user_rbs_query = "select count(*)'counter' from tbl_base_rb_routerboard where upper(active) = 'Y';";
        
		/* Try and execute the SQL */
        $user_rbs_stmt = $db->prepare($user_rbs_query);
        if ($user_rbs_stmt->execute()) {
            $user_rbs_row = $user_rbs_stmt->fetchAll();
        }
		
        if ($user_rbs_row) {
			/* There was feedback from the sql query so pack up thos results */
            foreach ($user_rbs_row as $key => $value) {
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