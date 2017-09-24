<?php
if (!isset($_SESSION)) {
    session_start();
}
$ServerArray = filter_input_array(INPUT_SERVER);
require_once($ServerArray['DOCUMENT_ROOT'] . '/../src/bwcfw.classes.php');
$page_data = new PageLoggingService(__FILE__, true);
$page_data->PageData->setRoleRequired("user");

/* SQL - Query */
$select_routerboard_model_query = "SELECT board_model as routerboards, count(*) as counter FROM tbl_base_rb_routerboard where upper(active) ='Y' GROUP BY board_model ORDER BY board_model, counter;";
/* SQL - Execute */
try {
    $select_routerboard_model_stmt = $page_data->ServiceDAO->ServicePDO->prepare($select_routerboard_model_query);
    $select_routerboard_model_result = $select_routerboard_model_stmt->execute();
} catch (PDOException $ex) {
    /* SQL - Error Handling */
    $page_data->PageActions->setStatus(false);
    $page_data->PageActions->setStatusCode("edit_leave_request_stmt");
    $page_data->PageActions->setExtendedStatusCode(htmlspecialchars(str_replace(PHP_EOL, '', $ex->getMessage())));
    $page_data->PageActions->setLine($ex->getLine());
    $page_data->LogEntry(3);
}
if ($page_data->PageActions->getStatus()) {
    /* SQL - Get results */
    $select_routerboard_model_row = $select_routerboard_model_stmt->fetchall();
    /* Process Result(s) */
    if ($select_routerboard_model_row) {
        $rows = array();
        foreach ($select_routerboard_model_row as $x) {
            $row[0] = $x['routerboards'];
            $row[1] = $x['counter'];
            array_push($rows, $row);
        }
        $page_data->PageData->PageWebStatus->setAPIResponse(1);
        $page_data->PageData->PageWebStatus->setAPIResponseData($rows);
        $page_data->PageActions->setStatusCode("Data Size: " . count($rows) . " row(s)");
    } else {
        /* There was no data */
        $page_data->PageActions->setStatusCode("No Data");
        $page_data->PageData->PageWebStatus->setAPIResponse(1);
        $page_data->PageData->PageWebStatus->setAPIResponseData("");
    }
} else {
    /* If there was a SQL error */
    $page_data->PageData->PageWebStatus->setAPIResponse(10);
    $page_data->PageData->PageWebStatus->setAPIResponseData($page_data->PageActions->getStatusCode());
}

/* Auditing/logging */
$page_data->LogPageEntry((($page_data->PageActions->getStatus()) ? 1 : 3));
//$page_data->page_metric->page_metric($ServerArray, $_SESSION, $page_data->PageActions, session_id(), $page_data->PageData->getPageInfo());
/* Deliver results */
header('HTTP/1.1 ' . $page_data->PageData->PageWebStatus->getAPIResponseStatus() . ' ' . $page_data->PageData->PageWebStatus->getHTTPResponseCode());
header('Content-Type: application/json; charset=utf-8');
$json_response = json_encode($page_data->PageData->PageWebStatus->getAPIResponse(), JSON_NUMERIC_CHECK);
echo $json_response;

?>