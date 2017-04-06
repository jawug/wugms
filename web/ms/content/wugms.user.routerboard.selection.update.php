<?php
/* Start a session */
session_start();
/* Load required functions */
require($_SERVER['DOCUMENT_ROOT'] . '/content/functions.php');
require($_SERVER['DOCUMENT_ROOT'] . '/auth/config.php');

/* Basic vars */
/*$api_status_code    = "";
$api_status_msg     = "";
$api_data           = "";
$api_response_code  = array(
    0 => array(
        'HTTP Response' => 400,
        'Message' => 'Unknown Error'
    ),
    1 => array(
        'HTTP Response' => 200,
        'Message' => 'Success'
    ),
    2 => array(
        'HTTP Response' => 403,
        'Message' => 'HTTPS Required'
    ),
    3 => array(
        'HTTP Response' => 401,
        'Message' => 'Authentication Required'
    ),
    4 => array(
        'HTTP Response' => 401,
        'Message' => 'Authentication Failed'
    ),
    5 => array(
        'HTTP Response' => 404,
        'Message' => 'Invalid Request'
    ),
    6 => array(
        'HTTP Response' => 400,
        'Message' => 'Invalid Response Format'
    ),
    7 => array(
        'HTTP Response' => 400,
        'Message' => 'Invalid Request'
    )
);
$http_response_code = array(
    200 => 'OK',
    400 => 'Bad Request',
    401 => 'Unauthorized',
    403 => 'Forbidden',
    404 => 'Not Found'
);
$response           = "";*/

if (!empty($_POST)) {
    if ((isset($_SESSION["id"])) && (isset($_POST["device_sn"]))) {
        /* there is a user*/
        /* See if the user has access to the selected serial number */
        $user_id_rb_sn_query = "
		SELECT 1
		  FROM (SELECT sn
		          FROM (SELECT b.ae_Serial_Number 'sn'
		                  FROM tbl_ae_sites_rbs b, tbl_base_sites a, tbl_base_sites c
		                 WHERE     a.idSite_Owner = :user_id
		                       AND b.ae_siteID = a.siteID
		                       AND a.idSite_Owner = c.idSite_Owner) a
		        UNION
        		SELECT sn
          		FROM (SELECT d.Serial_Number 'sn'
                		  FROM tbl_base_rb_routerboard d
                 		WHERE idSite_Owner = :user_id) b) AS a
       		INNER JOIN (SELECT 'Mikrotik' AS 'device_make',
            		              a.Board_model 'device_model',
                    		      a.OS_Version 'os_ver',
                          		a.RB_identity 'device_name',
                          		b.Name 'sitename',
                          		a.Serial_Number 'sn'
                     		FROM tbl_base_rb_routerboard a, tbl_base_sites b
                    		WHERE a.siteID = b.siteID) AS b
          		ON a.sn = b.sn
 		WHERE b.sn = :rb_sn
		ORDER BY b.SiteName, b.device_name;";
        
        /* Assign the variables */
        $user_id_rb_sn_query_params = array(
            ':user_id' => $_SESSION["id"],
            ':rb_sn' => $_POST["device_sn"]
            //':rb_sn' => "2E2E0166A3B1"
            //':rb_sn' => "2E2E0166A3"
        );

		/* Run the SQL query */
        $user_id_rb_sn_stmt = $db->prepare($user_id_rb_sn_query);
        if ($user_id_rb_sn_stmt->execute($user_id_rb_sn_query_params)) {
            $user_id_rb_sn_row = $user_id_rb_sn_stmt->fetchAll();
        }
		
        /* Work with the results */
        if ($user_id_rb_sn_row) {
            /* The supplied user and serial number are allowed */
			/* Using the posted vars */
			
			$_SESSION["rb_sn"] = $_POST["device_sn"];
//			$_SESSION["rb_sn"] = "qqqqqq";
			/* Set the device description */
			if (isset($_POST["device_des"])) {
			/* Assign the posted var to the session var */	
				$_SESSION["rb_des"] = $_POST["device_des"];
			} else {
			/* Seeing as there isn't a posted var assign a default value */
				$_SESSION["rb_des"] = "-";
			}

			/* Set the sitename */
			if (isset($_POST["device_site"])) {
			/* Assign the posted var to the session var */	
				$_SESSION["rb_site"] = $_POST["device_site"];
			} else {
			/* Seeing as there isn't a posted var assign a default value */
				$_SESSION["rb_site"] = "-";
			}

			/* Set the model */
			if (isset($_POST["device_model"])) {
			/* Assign the posted var to the session var */	
				$_SESSION["rb_model"] = $_POST["device_model"];
			} else {
			/* Seeing as there isn't a posted var assign a default value */
				$_SESSION["rb_model"] = "-";
			}
			
			/* Set the data query start date */
			if (isset($_POST["device_data_start_date"])) {
			/* Assign the posted var to the session var */	
				$_SESSION["rb_start_date"] = $_POST["device_data_start_date"];
			} else {
			/* Seeing as there isn't a posted var assign a default value */
				$_SESSION["rb_start_date"] = "0";
			}
			
			/* Set the data query end date */
			if (isset($_POST["device_data_end_date"])) {
			/* Assign the posted var to the session var */	
				$_SESSION["rb_end_date"] = $_POST["device_data_end_date"];
			} else {
			/* Seeing as there isn't a posted var assign a default value */
				$_SESSION["rb_end_date"] = "0";
			}
			
			/* Set the data query end date */
			if (isset($_POST["device_data_interval"])) {
			/* Assign the posted var to the session var */	
				$_SESSION["rb_interval"] = $_POST["device_data_interval"];
			} else {
			/* Seeing as there isn't a posted var assign a default value */
				$_SESSION["rb_interval"] = "5min";
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
            $response['data']    = "[[serial_number,". $_SESSION["rb_sn"] ."],[site," . $_SESSION["rb_site"] . "],[description," . $_SESSION["rb_des"] . "],[model," . $_SESSION["rb_model"] . "],[start_date," . $_SESSION["rb_start_date"] . "],[end_date," . $_SESSION["rb_end_date"] . "],[interval," . $_SESSION["rb_interval"] . "]]";
        } else {
            /* The supplied user and serial number are NOT allowed */
            $api_status_code     = 7;
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