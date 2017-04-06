<?php
/* Start a session */
session_start();
/* Load required functions */
require($_SERVER['DOCUMENT_ROOT'] . '/content/functions.php');
require($_SERVER['DOCUMENT_ROOT'] . '/auth/config.php');

/* Basic vars */


if (!empty($_POST)) {
    if ((isset($_SESSION["id"])) && (isset($_POST["device_sn"]))) {
        /* there is a user*/
        /* See if the user has access to the selected serial number */

		
        /* Work with the results */
        if (isValueInRoleArray($_SESSION["roles"], "admin")) {
            /* The supplied user and serial number are allowed */
			/* Using the posted vars */
			
			$_SESSION["rb_iface_sn"] = $_POST["device_sn"];

			/* Set the interface ID */
			if (isset($_POST["device_iface"])) {
			/* Assign the posted var to the session var */	
				$_SESSION["rb_iface_sel"] = $_POST["device_iface"];
			} else {
			/* Seeing as there isn't a posted var assign a default value */
				$_SESSION["rb_iface_sel"] = "-";
			}

			/* Set the interface description */
			if (isset($_POST["device_iface_des"])) {
			/* Assign the posted var to the session var */	
				$_SESSION["rb_iface_sel_des"] = $_POST["device_iface_des"];
			} else {
			/* Seeing as there isn't a posted var assign a default value */
				$_SESSION["rb_iface_sel_des"] = "-";
			}

			/* Set the interface description */
			if (isset($_POST["device_iface_type"])) {
			/* Assign the posted var to the session var */	
				$_SESSION["rb_iface_type"] = $_POST["device_iface_type"];
			} else {
			/* Seeing as there isn't a posted var assign a default value */
				$_SESSION["rb_iface_type"] = "-";
			}
			
			/* Set the device description */
			if (isset($_POST["device_des"])) {
			/* Assign the posted var to the session var */	
				$_SESSION["rb_iface_des"] = $_POST["device_des"];
			} else {
			/* Seeing as there isn't a posted var assign a default value */
				$_SESSION["rb_iface_des"] = "-";
			}

			/* Set the sitename */
			if (isset($_POST["device_site"])) {
			/* Assign the posted var to the session var */	
				$_SESSION["rb_iface_site"] = $_POST["device_site"];
			} else {
			/* Seeing as there isn't a posted var assign a default value */
				$_SESSION["rb_iface_site"] = "-";
			}

			/* Set the model */
			if (isset($_POST["device_model"])) {
			/* Assign the posted var to the session var */	
				$_SESSION["rb_iface_model"] = $_POST["device_model"];
			} else {
			/* Seeing as there isn't a posted var assign a default value */
				$_SESSION["rb_iface_model"] = "-";
			}
			
			/* Set the data query start date */
			if (isset($_POST["device_data_start_date"])) {
			/* Assign the posted var to the session var */	
				$_SESSION["rb_iface_start_date"] = $_POST["device_data_start_date"];
			} else {
			/* Seeing as there isn't a posted var assign a default value */
				$_SESSION["rb_iface_start_date"] = "0";
			}
			
			/* Set the data query end date */
			if (isset($_POST["device_data_end_date"])) {
			/* Assign the posted var to the session var */	
				$_SESSION["rb_iface_end_date"] = $_POST["device_data_end_date"];
			} else {
			/* Seeing as there isn't a posted var assign a default value */
				$_SESSION["rb_iface_end_date"] = "0";
			}
			
			/* Set the data query end date */
			if (isset($_POST["device_data_interval"])) {
			/* Assign the posted var to the session var */	
				$_SESSION["rb_iface_interval"] = $_POST["device_data_interval"];
			} else {
			/* Seeing as there isn't a posted var assign a default value */
				$_SESSION["rb_iface_interval"] = "5min";
			}
/*			device_data_end_date	0
			device_data_interval	5min
			device_data_start_date	0
			device_des	(BJU)ZS6BJU rb_des
			device_site	NorthRiding_Sector1
			device_sn	51A50418D389 */
			
            $api_status_code     = 1;
            $response['status']  = $api_response_code[$api_status_code]['HTTP Response'];
            $response['message'] = $api_response_code[$api_status_code]['Message'];
            $response['data']    = "[[serial_number,". $_SESSION["rb_iface_sn"] . "],[interface," . $_SESSION["rb_iface_sel"] . "],[type," . $_SESSION["rb_iface_type"] . "],[site," . $_SESSION["rb_iface_site"] . "],[description," . $_SESSION["rb_iface_des"] . "],[model," . $_SESSION["rb_iface_model"] . "],[start_date," . $_SESSION["rb_iface_start_date"] . "],[end_date," . $_SESSION["rb_iface_end_date"] . "],[interval," . $_SESSION["rb_iface_interval"] . "]]";
        } else {
            /* The supplied user and serial number are NOT allowed */
            $api_status_code     = 3;
            $response['status']  = $api_response_code[$api_status_code]['HTTP Response'];
            $response['message'] = $api_response_code[$api_status_code]['Message'];
            
        }
        
    } else {
        /* There is no logged in user */
        $api_status_code     = 3;
        $response['status']  = $api_response_code[$api_status_code]['HTTP Response'];
        $response['message'] = $api_response_code[$api_status_code]['Message'];
    }
} else {
    $api_status_code     = 7;
    $response['status']  = $api_response_code[$api_status_code]['HTTP Response'];
    $response['message'] = $api_response_code[$api_status_code]['Message'];
}

/* Deliver results */
header('HTTP/1.1 ' . $response['status'] . ' ' . $http_response_code[$response['status']]);
header('Content-Type: application/json; charset=utf-8');
$json_response = json_encode($response);
echo $json_response;
?>