<?php
/*     Header information     */
/* Filename   : site_info.php */
/* Version    : 1.0           */
/* Mod Date   : 2015/11/29    */
/* Parameters : site_name     */

/* Init reqs */
session_start();
require($_SERVER['DOCUMENT_ROOT'] . '/auth/config.php');
require($_SERVER['DOCUMENT_ROOT'] . '/content/functions.php');

/* Default params setting */
$site_name               = '';
$site_name_id_data_row   = "";
$site_equipment_data_row = "";
$site_wifi_ap_data_row   = "";
$site_id                 = "";
$site_data = array();
//$wifi_ap_data[]


if (isset($_GET['site_name'])) {
    $site_name                = strtoupper($_GET['site_name']);
    /* Seeing as there is a parameter supplied, we'll see if there more information */
    /* main query */
    $site_name_id_data_query  = "SELECT a.siteID FROM tbl_base_sites a, tbl_base_user b WHERE a.idSite_Owner = b.idtbl_base_user AND upper(a.Name) = :site_name_param;";
    /* Set parameters for the query */
    $site_name_id_data_params = array(
        ':site_name_param' => $site_name
    );
    /*':site_name_param' => '%' . $site_name . '%'*/
    /* Execute the SQL query */
    $site_name_id_data_stmt = $db->prepare($site_name_id_data_query);
    if ($site_name_id_data_stmt->execute($site_name_id_data_params)) {
        $site_name_id_data_row = $site_name_id_data_stmt->fetchAll();
    }
    
    /* Check is there are any returned datasets */
    if ($site_name_id_data_row) {
        /* Works through the results and get them into an array */
        foreach ($site_name_id_data_row as $x) {
            $site_id = $x["siteID"];
        }
        /* Seeing as there is a site_id then we'll look for equipment */
        $site_equipment_data_query  = "SELECT c.Serial_Number,
		    c.Board_model,
		    c.RB_identity,
		    c.File_Date 'rbcp_last_seen',
		    c.SiteName,
		    c.siteID
		    FROM tbl_base_rb_routerboard c, tbl_base_sites a
		    WHERE a.siteID = :site_id AND a.siteID = c.siteID";
        /* Set parameters for the query */
        $site_equipment_data_params = array(
            ':site_id' => $site_id
        );
        
        /* Execute the SQL query */
        $site_equipment_data_stmt = $db->prepare($site_equipment_data_query);
        if ($site_equipment_data_stmt->execute($site_equipment_data_params)) {
            $site_equipment_data_row = $site_equipment_data_stmt->fetchAll();
        }
        
        /* Check is there are any returned datasets */
        if ($site_equipment_data_row) {
            /* Works through the results and get them into an array */
            foreach ($site_equipment_data_row as $key => $value) {
                $equipment_data[] = array(
                    'rb_board_model' => $value['Board_model'],
                    'rb_identity' => $value["RB_identity"]
                );
            }
            /* Seeing as there is a site_id then we'll look for equipment */
            
        } else {
            $equipment_data = 'No equipment on site';
        }
        
        /* Seeing as there is a site_id then we'll look for equipment */
        $site_wifi_ap_data_query  = "SELECT e.wifi_frequency 'frequency', e.wifi_ssid
  FROM tbl_base_rb_interface_config e, tbl_base_rb_routerboard c
 WHERE     c.siteID = :site_id
       AND c.Serial_Number = e.Serial_Number
       AND upper(e.Interface_type) = 'WIFI'
       AND disabled = 0
       AND upper(wifi_mode) LIKE '%AP%'
       AND upper(wifi_ssid) LIKE '%JAWUG%';";
        /* Set parameters for the query */
        $site_wifi_ap_data_params = array(
            ':site_id' => $site_id
        );
        
        /* Execute the SQL query */
        $site_wifi_ap_data_stmt = $db->prepare($site_wifi_ap_data_query);
        if ($site_wifi_ap_data_stmt->execute($site_wifi_ap_data_params)) {
            $site_wifi_ap_data_row = $site_wifi_ap_data_stmt->fetchAll();
        }
        
        /* Check is there are any returned datasets */
        if ($site_wifi_ap_data_row) {
            /* Works through the results and get them into an array */
            foreach ($site_wifi_ap_data_row as $key => $value) {
                $wifi_ap_data[] = array(
                    'wifi_freq' => $value['frequency'],
                    'wifi_ssid' => $value["wifi_ssid"]
                );
            }
            /* Seeing as there is a site_id then we'll look for equipment */
            
        } else {
            $wifi_ap_data = 'No APs on site';
        }

		 $site_data[] = $equipment_data;
		 $site_data[] = $wifi_ap_data;
            /* Build a response */
            $api_status_code     = 1;
            $response['status']  = $api_response_code[$api_status_code]['HTTP Response'];
            $response['message'] = $api_response_code[$api_status_code]['Message'] . " " . date("Y-m-d H:i:s");
//            $response['data']    = $equipment_data;
			$response['data']    = $site_data;
			//$response['data']    .= $wifi_ap_data;
        
    } else {
        /* site name parameter is invalid */
        $api_status_code     = 8;
        $response['status']  = $api_response_code[$api_status_code]['HTTP Response'];
        $response['message'] = $api_response_code[$api_status_code]['Message'] . " " . date("Y-m-d H:i:s");
        $response['data']    = 'No data';
    }

} else {
    /* Build a response */
    $api_status_code     = 9;
    $response['status']  = $api_response_code[$api_status_code]['HTTP Response'];
    $response['message'] = $api_response_code[$api_status_code]['Message'] . " " . date("Y-m-d H:i:s");
    $response['data']    = 'Parameter supplied is empty';
}

//} else {
/* No parameter value was passed */
/* Build a response */
//    $api_status_code     = 7;
//    $response['status']  = $api_response_code[$api_status_code]['HTTP Response'];
//    $response['message'] = $api_response_code[$api_status_code]['Message'] . " " . date("Y-m-d H:i:s");
//    $response['data']    = 'No data';
//}

/* Build the header */
//header('HTTP/1.1 ' . $response['status'] . ' ' . $http_response_code[$response['status']]);
//header('Content-Type: application/json; charset=utf-8');
$json_response = json_encode($response, JSON_NUMERIC_CHECK);
/* Deliver results */
echo $json_response;
?>