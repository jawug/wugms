<?php
if (!isset($_SESSION)) {
    session_start();
}
$ServerArray = filter_input_array(INPUT_SERVER);
require_once($ServerArray['DOCUMENT_ROOT'] . '/../src/bwcfw.classes.php');


$rrr = new wugms\valueobjects\Status();
var_dump($rrr);


$page_data = new PageLoggingService(__FILE__, true);
