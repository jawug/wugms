<?php
if (!isset($_SESSION)) {
    session_start();
}
$ServerArray = filter_input_array(INPUT_SERVER);
require_once($ServerArray['DOCUMENT_ROOT'] . '/../src/bwcfw.classes.php');
$page_data = new wugms\services\PageLogging(__FILE__, true);
$page_data->PageData->setRoleRequired("user");

$GetArray = filter_input_array(INPUT_GET);
$Validation = new wugms\services\Validation();


if (!$GetArray) {
    $page_data->PageActions->setStatus(false);
    $page_data->PageActions->setStatusCode("Missing Parameter(s)");
}
if ($page_data->PageActions->getStatus()) {
    if (array_key_exists('page', $GetArray)) {
        try {
            $page_name = $Validation->validateStringLengthMinMax($GetArray['page'], 5, 20);
        } catch (Exception $e) {
            $page_data->PageActions->setStatus(false);
            $page_data->PageActions->setStatusCode($e->getMessage());
            $page_data->PageActions->setExtendedStatusCode("Sub function located in " . $e->getFile());
            $page_data->PageActions->setLine($e->getLine());
            $page_data->LogPageEntry(3);
        }
    } else {
        $page_data->PageActions->setStatus(false);
        $page_data->PageActions->setStatusCode("Missing 'page' Parameter");
    }
}

if ($page_data->PageActions->getStatus()) {

    switch ($page_name) {
        case "corenetworkdevices":
            //$page_data->setParams($page_name);
            break;
        case "networkstats":
            //$page_data->setParams($page_name);
            break;
        case "userstats":
            //$page_data->setParams($page_name);
            break;
        case "wifistats":
            //$page_data->setParams($page_name);
            break;
        case "contactus":
            //$page_data->setParams($page_name);
            break;
        case "aboutus":
            //$page_data->setParams($page_name);
            break;
        case "gettingstarted":
            //$page_data->setParams($page_name);
            break;
        default:
            $page_name = 'main_section';
    }
} else {
    $page_name = 'main_section';
}

#Header section
include '../header_section.php';
#Menu
include '../menu_main.php';
#Main
include $page_name . '.php';
#footer
include 'footer_section.php';
