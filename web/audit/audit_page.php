<?php
$ServerArray = filter_input_array(INPUT_SERVER);
$PostArray = filter_input_array(INPUT_POST);
include($ServerArray['DOCUMENT_ROOT'] . '/../src/bwcfw.classes.php');
$page_auditing = new AuditService();
if ($PostArray) {
    $auditResults = $page_auditing->DAOUserAudit($PostArray['username'], $PostArray['user_id'], $PostArray['session_id'], $PostArray['user_ip'], $PostArray['section'], $PostArray['level'], $PostArray['area'], $PostArray['type'], $PostArray['action'], $PostArray['status'], $PostArray['msg'], $PostArray['browser_agent'], $PostArray['page'], $PostArray['extended_status'], $PostArray['line']);
    $page_auditing->LogBasicEntry(2, '{' . basename(__FILE__) . '} == ' . get_class($page_auditing), $auditResults->getStatusStr(), $auditResults->getStatusCode(), $auditResults->getExtendedStatusCode(), $auditResults->getLine());
} 