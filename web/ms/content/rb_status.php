<?php
/* Load required functions */
require($_SERVER['DOCUMENT_ROOT'] . '/content/functions.php');
require($_SERVER['DOCUMENT_ROOT'] . '/auth/config.php');

/* Set the default output */
$user_rbs_row = '';
	/* Check if a serial number was supplied */
        $user_rbs_query = "select a.active, b.down, c.lost from (SELECT count(*) 'active'
					FROM view_rb_overview
			WHERE RB_Status = 'active') a,
      (SELECT count(*) 'down'
					FROM view_rb_overview
			WHERE RB_Status = 'down') b,
      (SELECT count(*) 'lost'
					FROM view_rb_overview
			WHERE RB_Status = 'lost') c;";
        
		/* Try and execute the SQL */
        $user_rbs_stmt = $db->prepare($user_rbs_query);
        if ($user_rbs_stmt->execute()) {
            $user_rbs_row = $user_rbs_stmt->fetchAll();
        }
		
        if ($user_rbs_row) {
			/* There was feedback from the sql query so pack up thos results */
            foreach ($user_rbs_row as $key => $value) {
                $data[] = array(
					'active' => $value['active'],
					'down' => $value['down'],
					'lost' => $value['lost']
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