<?php
/* Load required functions */
require($_SERVER['DOCUMENT_ROOT'] . '/content/functions.php');
require($_SERVER['DOCUMENT_ROOT'] . '/auth/config.php');

/* Set the default output */
$wifi_ssid_ap_row = '';
	/* Check if a serial number was supplied */
        $wifi_ssid_ap_query = "SELECT count(*) 'counter'
  FROM tbl_base_rb_interface_config a,
       (SELECT b.Serial_Number
          FROM tbl_base_rb_routerboard b
         WHERE upper(b.active) = 'Y') AS x
 WHERE     x.Serial_Number = a.Serial_Number
       AND a.Interface_type = 'WIFI'
       AND upper(a.wifi_ssid) LIKE '%JAWUG%'
       AND upper(a.wifi_mode) LIKE '%AP%'
       AND a.disabled = '0';";
        
		/* Try and execute the SQL */
        $wifi_ssid_ap_stmt = $db->prepare($wifi_ssid_ap_query);
        if ($wifi_ssid_ap_stmt->execute()) {
            $wifi_ssid_ap_row = $wifi_ssid_ap_stmt->fetchAll();
        }
		
        if ($wifi_ssid_ap_row) {
			/* There was feedback from the sql query so pack up thos results */
            foreach ($wifi_ssid_ap_row as $key => $value) {
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