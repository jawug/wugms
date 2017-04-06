<?php
/* Start session */
session_start();
/* Load required functions */
require($_SERVER['DOCUMENT_ROOT'] . '/content/functions.php');
require($_SERVER['DOCUMENT_ROOT'] . '/auth/config.php');

/* Set the default output */
$outp                      = "";
$user_rb_iface_details_row = '';
$isValidType               = 'no';


/* Check if there is a user logged in */
if (isset($_SESSION["id"])) {
    /* Confirm that the interface type varible is set */
    if (isset($_SESSION["rb_iface_type"])) {
        /* Check and see what type is selected and then set the correct vars */
        if ($_SESSION["rb_iface_type"] == 'ethernet-csmacd') {
            $isValidType                 = 'yes';
            $user_rb_iface_details_query = "
			SELECT a.arp,
			       if (a.disabled=0,'No','Yes') 'disabled',
			       a.mac_address,
			       a.mtu,
			       a.name,
			       a.Interface_type,
			       a.comment,
			       a.rawline,
			       a.ether_auto_negotiation,
			       a.ether_bandwidth,
			       if (a.ether_full_duplex=0,'Yes','No') 'ether_full_duplex',
			       a.ether_l2mtu,
			       a.ether_speed
			  FROM tbl_base_rb_interface_config a
			 WHERE Serial_Number = :dev_sn AND name = :iface_name;";
            
        } else if ($_SESSION["rb_iface_type"] == 'ieee80211') {
            $isValidType                 = 'yes';
            $user_rb_iface_details_query = "
			SELECT a.arp,
			       if (a.disabled=0,'No','Yes') 'disabled',
			       a.mac_address,
			       a.mtu,
			       a.comment,
			       a.rawline,
			       a.wifi_antenna_gain,
			       a.wifi_channel_width,
			       a.wifi_country,
			       a.wifi_frequency,
			       a.wifi_mode,
			       a.wifi_radio_name,
			       a.wifi_ssid,
			       a.wifi_wireless_protocol
			  FROM tbl_base_rb_interface_config a
			 WHERE Serial_Number = :dev_sn AND name = :iface_name;";
        }
        
        //ethernet-csmacd' OR IFace_Type = 'ieee80211
        //{"status":200,"message":"Success","data":"[[serial_number,45FF028700C7],[interface,1],[type,ethernet-csmacd],[interface_name,ether1],[site,(RS)RealityStorm],[description,RealityStorm],[model,RB Metal 5SHPn],[start_date,2015-11-09 05:41],[end_date,2015-11-09 17:41],[interval,5min]]"}
        
        
        if ($isValidType == 'yes') {
            /* Set parameters for the query */
            $user_rb_iface_details_query_params = array(
                ':dev_sn' => $_SESSION["rb_iface_sn"],
                ':iface_name' => $_SESSION["rb_iface_sel_des"]
            );
            
            /* Try and execute the SQL */
            $user_rb_iface_details_stmt = $db->prepare($user_rb_iface_details_query);
            if ($user_rb_iface_details_stmt->execute($user_rb_iface_details_query_params)) {
                $user_rb_iface_details_row = $user_rb_iface_details_stmt->fetchAll();
            }
            
            if ($user_rb_iface_details_row) {
                /* Get the enternet data */
                if ($_SESSION["rb_iface_type"] == 'ethernet-csmacd') {
                    			//$outp = "[";
$outp = "<thead><tr> <th>ARP</th> <th>Disabled</th> <th>MAC Address</th> <th>MTU</th> <th>Comment</th> <th>Auto Negotiation</th> <th>Bandwidth</th> <th>Full Duplex</th> <th>L2MTU</th> <th>Speed</th> </tr></thead><tbody>";								
                    foreach ($user_rb_iface_details_row as $x) {

$outp .= '<tr>';
$outp .= '<td>' . $x["arp"] . '</td>';
$outp .= '<td>' . $x["disabled"] . '</td>';
$outp .= '<td>' . $x["mac_address"] . '</td>';
$outp .= '<td>' . $x["mtu"] . '</td>';
$outp .= '<td>' . $x["comment"] . '</td>';
$outp .= '<td>' . $x["ether_auto_negotiation"] . '</td>';
$outp .= '<td>' . $x["ether_bandwidth"] . '</td>';
$outp .= '<td>' . $x["ether_full_duplex"] . '</td>';
$outp .= '<td>' . $x["ether_l2mtu"] . '</td>';
$outp .= '<td>' . $x["ether_speed"] . '</td>';

$outp .= '</tr></tbody>';

					$data = $outp;
					}
                    /* Get the wifi data */
                } else if ($_SESSION["rb_iface_type"] == 'ieee80211') {
                    //			$outp = "[";
                    foreach ($user_rb_iface_details_row as $x) {
                        //                if ($outp != "[") {
                        //					$outp .= ",";
                        //				}
//                        $outp .= 'arp:' . $x["arp"] . ',';
//                        $outp .= 'disabled:' . $x["disabled"] . ',';
//                        $outp .= 'mac_address:' . $x["mac_address"] . ',';
//                        $outp .= 'mtu:' . $x["mtu"] . ',';
//                        $outp .= 'comment:' . $x["comment"] . ',';
                        //				$outp .= 'rawline:' . $x["rawline"] . ',';
                        //$outp .= 'wifi_antenna_gain:' . $x["wifi_antenna_gain"] . ',';
//                        $outp .= 'wifi_channel_width:' . $x["wifi_channel_width"] . ',';
//                        $outp .= 'wifi_country:' . $x["wifi_country"] . ',';
//                        $outp .= 'wifi_frequency:' . $x["wifi_frequency"] . ',';
//                        $outp .= 'wifi_mode:' . $x["wifi_mode"] . ',';
//                        $outp .= 'wifi_radio_name:' . $x["wifi_radio_name"] . ',';
//                        $outp .= 'wifi_ssid:' . $x["wifi_ssid"] . ',';
  //                      $outp .= 'wifi_wireless_protocol:' . $x["wifi_wireless_protocol"];

$outp = "<thead><tr> <th>ARP</th> <th>Disabled</th> <th>MAC Address</th> <th>MTU</th> <th>Comment</th> <th>Antenna Gain</th> <th>Channel Width</th> <th>Country</th> <th>Frequency</th> <th>Mode</th> <th>Radio Name</th> <th>SSID</th> <th>Protocol</th> </tr></thead><tbody>";								
//                    foreach ($user_rb_iface_details_row as $x) {

$outp .= '<tr>';
$outp .= '<td>' . $x["arp"] . '</td>';
$outp .= '<td>' . $x["disabled"] . '</td>';
$outp .= '<td>' . $x["mac_address"] . '</td>';
$outp .= '<td>' . $x["mtu"] . '</td>';
$outp .= '<td>' . $x["comment"] . '</td>';
$outp .= '<td>' . $x["wifi_antenna_gain"] . '</td>';
$outp .= '<td>' . $x["wifi_channel_width"] . '</td>';
$outp .= '<td>' . $x["wifi_country"] . '</td>';
$outp .= '<td>' . $x["wifi_frequency"] . '</td>';
$outp .= '<td>' . $x["wifi_mode"] . '</td>';
$outp .= '<td>' . $x["wifi_radio_name"] . '</td>';
$outp .= '<td>' . $x["wifi_ssid"] . '</td>';
$outp .= '<td>' . $x["wifi_wireless_protocol"] . '</td>';


$outp .= '</tr></tbody>';
						
						
                    //			$outp .= "]";
                    $data = $outp;
                }
					}
                /* Set the global session so that we can show this again when the user changes pages */
				$_SESSION["rb_iface_config"] = $data;
                /* There was feedback from the sql query so pack up thos results */
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
        }
        
        
    } else {
        /* Someone didn't provide the required information */
        $api_status_code     = 7;
        $response['status']  = $api_response_code[$api_status_code]['HTTP Response'];
        $response['message'] = $api_response_code[$api_status_code]['Message'];
        $data[]              = array(
            'id' => '0',
            'text' => 'Interface type selected.'
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