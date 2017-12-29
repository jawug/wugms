<?php

require_once '../classes/wugms.classes.php';

$auditor = new wugms_audit();
$page_data = new wugms_file_record(__FILE__);
//$page_auditing = new wugms_logging_service();
//$page_data = new wugms_file_record();
//$page_data->setRolesRequired("guest");
//$page_data->setAction("display");
//$page_data->setLevel("guest");
//$page_data->setName(__FILE__);
//$page_data->setArea("public");
//$page_actions = new wugms_function_record();
//$page_decorator = new wugms_decorator();
//$logger = Logger::getLogger(basename(__FILE__));
//$logger->debug('Status: debug');
//$logger->info('Result(s) sent.');

var_dump($auditor);
echo PHP_EOL;
echo "<br>";
echo PHP_EOL;
var_dump($page_data);
?>