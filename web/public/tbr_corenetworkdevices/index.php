<?php

/* Start session */
/* No validation will be done because this is a public page */
session_start();
/* This is required for classes */
require($_SERVER['DOCUMENT_ROOT'] . '/ms/classes/wugms.classes.php');


$user_id = 'N/A';
$page_auditing = new wugms_auditing();
$page_data = new wugms_file_record();
$page_data->setRolesRequired("guest");
$page_data->setAction("display");
$page_data->setLevel("public");
$page_data->setName(__FILE__);
$page_data->setArea("public");
$page_actions = new Status_VO();
$page_decorator = new wugms_decorator();
#Header section
include 'header.php';
#Menu
//include($page_decorator->server_base . '/header_required.php'); 
include '../../menu_main.php';
#Main
include 'main.php';
#footer
include 'footer.php';
?>