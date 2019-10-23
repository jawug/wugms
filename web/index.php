<?php
if (!isset($_SESSION)) {
    session_start();
}
$ServerArray = filter_input_array(INPUT_SERVER);
//require_once($ServerArray['DOCUMENT_ROOT'] . '/../src/bwcfw.classes.php');
require_once(__DIR__ . '/../src/bwcfw.classes.php');
$page_data = new wugms\services\PageLogging(__FILE__, TRUE);
$page_data->PageData->setRoleRequired("user");

#Header section
include 'header_section.php';
#Menu
include 'menu_main.php';
#Main
include 'main_section.php';
#footer
include 'footer_section.php';
