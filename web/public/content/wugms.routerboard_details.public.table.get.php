<?php

if (!isset($_SESSION)) {
    session_start();
}
$ServerArray = filter_input_array(INPUT_SERVER);
require_once($ServerArray['DOCUMENT_ROOT'] . '/../lib/bwcfw.classes.php');
$page_data = new LoggingService(__FILE__, TRUE, TRUE);
$page_data->PageData->setRoleRequired("user");
//include($ServerArray['DOCUMENT_ROOT'] . '/../lib/bwcfw.api.user.validation.get.php');
//$page_data->PageData->setFileRecord(__FILE__);
//if ($page_data->PageActions->getStatus()) {


$GetArray = filter_input_array(INPUT_GET);
$Validation = new entity_validation();

if (!$GetArray) {
    $page_data->PageActions->setStatus(FALSE);
    $page_data->PageActions->setStatusCode("Missing Parameter(s)");
}

if ($page_data->PageActions->getStatus()) {
    if (array_key_exists('param', $GetArray)) {
        try {

            $qwerty = substr($GetArray['param'], 0, 5);
            if ($qwerty == "Ver. ") {
                $var = substr($GetArray['param'], 5, strlen($GetArray['param']) - 4);
            } else {
                $var = trim($GetArray['param']);
            }
        } catch (Exception $e) {
            $page_data->PageActions->setStatus(FALSE);
            $page_data->PageActions->setStatusCode($e->getMessage());
            $page_data->PageActions->setExtendedStatusCode("Sub function located in " . $e->getFile());
            $page_data->PageActions->setLine($e->getLine());
        }
    } else {
        $page_data->PageActions->setStatus(FALSE);
        $page_data->PageActions->setStatusCode("Missing 'param' Parameter");
    }
}

if ($page_data->PageActions->getStatus()) {
    /* SQL - Query */
    $select_routerboard_details_query = "SELECT a.OS_Version 'version', a.Board_model 'model', a.RB_identity 'identity', a.File_Date 'rbcp_last_seen', a.SiteName 'sitename', b.irc_nick 'owner' FROM tbl_base_rb_routerboard a, tbl_base_user b WHERE (a.Board_model = :var or a.OS_Version = :var ) and upper(a.active) ='Y' and a.idSite_Owner = b.idtbl_base_user order by a.SiteName;";
    $select_routerboard_details_query_param = array(
        ':var' => $var
    );
    /* SQL - Exec */
    try {
        $select_routerboard_details_stmt = $page_data->DAO_Service->DAO_Service->prepare($select_routerboard_details_query);
        $select_routerboard_details_result = $select_routerboard_details_stmt->execute($select_routerboard_details_query_param);
    } catch (PDOException $ex) {
        /* SQL - Error Handling */
        $page_data->PageActions->setStatus(FALSE);
        $page_data->PageActions->setStatusCode("edit_leave_request_stmt");
        $page_data->PageActions->setExtendedStatusCode(htmlspecialchars(str_replace(PHP_EOL, '', $ex->getMessage())));
        $page_data->PageActions->setLine($ex->getLine());
    }
    if ($page_data->PageActions->getStatus()) {
        /* SQL - Get results */
        $select_routerboard_details_row = $select_routerboard_details_stmt->fetchall();
        /* Process Result(s) */
        if ($select_routerboard_details_row) {
            $page_data->PageData->PageWebStatus->setAPIResponse(1);
            $page_data->PageData->PageWebStatus->setAPIResponseData($select_routerboard_details_row);
            $page_data->PageActions->setStatusCode("Data Size: " . count($select_routerboard_details_row) . " row(s)");
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
} else {
    /* No user logged in or else not enough permission(s) */
    $page_data->PageData->PageWebStatus->setAPIResponse(1);
    $page_data->PageActions->setStatusCode("Invalid parameters");
    $page_data->PageData->PageWebStatus->setAPIResponseData("");
}

/* Auditing/logging */
$page_data->LogEntry((($page_data->PageActions->getStatus()) ? 1 : 3));
$page_data->page_metric->page_metric($ServerArray, $_SESSION, $page_data->PageActions, session_id(), $page_data->PageData->getPageInfo());
/* Deliver results */
header('HTTP/1.1 ' . $page_data->PageData->PageWebStatus->getAPIResponseStatus() . ' ' . $page_data->PageData->PageWebStatus->getHTTPResponseCode());
header('Content-Type: application/json; charset=utf-8');
$json_response = json_encode($page_data->PageData->PageWebStatus->getAPIResponse(), JSON_NUMERIC_CHECK);
echo $json_response;
?>