<?php
if (!isset($_SESSION)) {
    session_start();
}
$ServerArray = filter_input_array(INPUT_SERVER);
require_once($ServerArray['DOCUMENT_ROOT'] . '/../src/bwcfw.classes.php');
$page_data = new wugms\services\PageLogging(__FILE__, true);
$page_data->PageData->setRoleRequired("user");

/* SQL - Query */
$select_network_stats_qos_chart_query = "SELECT a.idate, a.flow, a.bytes FROM tbl_summary_snmp_mikrotik_queuetree_overview_60min a WHERE a.RDate >= DATE_FORMAT(now() - INTERVAL 24 HOUR, '%Y-%m-%d %H:00:00') AND a.RDate < now() AND a.bytes <> 0 ORDER BY a.idate, a.flow;";
/* SQL - Execute */
try {
    $select_network_stats_qos_chart_stmt = $page_data->ServiceDAO->ServicePDO->prepare($select_network_stats_qos_chart_query);
    $select_network_stats_qos_chart_result = $select_network_stats_qos_chart_stmt->execute();
} catch (PDOException $ex) {
    /* SQL - Error Handling */
    $page_data->PageActions->setStatus(false);
    $page_data->PageActions->setStatusCode("select_network_stats_qos_chart_stmt");
    $page_data->PageActions->setExtendedStatusCode(htmlspecialchars(str_replace(PHP_EOL, '', $ex->getMessage())));
    $page_data->PageActions->setLine($ex->getLine());
}
if ($page_data->PageActions->getStatus()) {
    /* SQL - Get results */
    $select_network_stats_qos_chart_row = $select_network_stats_qos_chart_stmt->fetchall();
    /* Process Result(s) */
    if ($select_network_stats_qos_chart_row) {
        $rows = array();
        foreach ($select_network_stats_qos_chart_row as $x) {
            $res[$x['flow']][] = array(
                $x['idate'],
                $x['bytes']
            );
        }
        foreach ($res as $k => $i) {
            $tmp['name'] = $k;
            $tmp['data'] = $i;
            $rows[] = $tmp;
        }
        //  $rows = json_encode($result, JSON_NUMERIC_CHECK);
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
$page_data->page_metric->page_metric($ServerArray, $_SESSION, $page_data->PageActions, session_id(), $page_data->PageData->getPageInfo());
/* Deliver results */
header('HTTP/1.1 ' . $page_data->PageData->PageWebStatus->getAPIResponseStatus() . ' ' . $page_data->PageData->PageWebStatus->getHTTPResponseCode());
header('Content-Type: application/json; charset=utf-8');
$json_response = json_encode($page_data->PageData->PageWebStatus->getAPIResponse(), JSON_NUMERIC_CHECK);
echo $json_response;
