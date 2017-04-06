<?php

if (!isset($_SESSION)) {
    session_start();
}
/* This is required for custom branding */
require($_SERVER['DOCUMENT_ROOT'] . '/content/branding.php');
/* Include the validation checker */
require($_SERVER['DOCUMENT_ROOT'] . '/content/functions.php');
$logger = Logger::getLogger(basename(__FILE__));
require($_SERVER['DOCUMENT_ROOT'] . '/auth/config.php');
/* Variables */
$SQLerrorcode = "";
$rows = array();

/* SQL Query */
$rb_ros_query = "select CONCAT('Ver. ', os_version) as os_level, count(*) as counter from tbl_base_rb_routerboard group by os_version order by (SUBSTRING_INDEX(os_version, '.', 1)+0), SUBSTRING_INDEX(SUBSTRING_INDEX(os_version, '.', -1), '.',1) +0;";

/* SQL Execute */
try {
    $rb_ros_stmt = $db->prepare($rb_ros_query);
    $rb_ros_result = $rb_ros_stmt->execute();
}
/* SQL Error Handling */ catch (PDOException $ex) {
    $SQLerrorcode = $ex->getMessage();
    $logger->debug("rb_ros_stmt: " . htmlspecialchars(str_replace(PHP_EOL, '', $SQLerrorcode)));
}
/* SQL Get results */
$rb_ros_row = $rb_ros_stmt->fetchall();

if ($rb_ros_row) {


    foreach ($rb_ros_row as $x) {
        $row[0] = $x['os_level'];
        $row[1] = $x['counter'];
        array_push($rows, $row);
    }
    $api_status_code = 1;
    $response['status'] = $api_response_code[$api_status_code]['HTTP Response'];
    $response['message'] = $api_response_code[$api_status_code]['Message'];
    $response['data'] = $rows;
} else {
    $logger->debug("rb_ros_stmt: NO DATA");
    $api_status_code = 8;
    $response['status'] = $api_response_code[$api_status_code]['HTTP Response'];
    $response['message'] = $api_response_code[$api_status_code]['Message'];
    $response['data'] = $SQLerrorcode;
}

/* Deliver results */
header('HTTP/1.1 ' . $response['status'] . ' ' . $http_response_code[$response['status']]);
header('Content-Type: application/json; charset=utf-8');
$json_response = json_encode($response, JSON_NUMERIC_CHECK);
echo $json_response;











// get data and store in a json array


/* Magic */
//$rb_ros_stmt = $db->prepare($rb_ros_query);
//if ($rb_ros_stmt->execute()) {
//    $rb_ros_row = $rb_ros_stmt->fetchAll();
//}

/* Work the results */
//$rows = array();
//if ($rb_ros_row) {
//    foreach ($rb_ros_row as $x) {
//      $row[0] = $x['Routerboards'];
//        $row[1] = $x['Counter'];
//  array_push($rows, $row);
//}
/* Send the result(s) */
//  echo json_encode($rows, JSON_NUMERIC_CHECK);
//}
?>