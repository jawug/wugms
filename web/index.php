<?php
if (!isset($_SESSION)) {
    session_start();
}
$ServerArray = filter_input_array(INPUT_SERVER);
require_once($ServerArray['DOCUMENT_ROOT'] . '/../src/bwcfw.classes.php');
$page_data = new PageLoggingService(__FILE__, false);
$page_data->PageData->setRoleRequired("user");

#Header section
include 'header_section.php';
#Menu
include 'menu_main.php';
#Main
include 'main_section.php';
#footer
include 'footer_section.php';

