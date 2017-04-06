<?php

if (!isset($_SESSION)) {
    session_start();
}
$ServerArray = filter_input_array(INPUT_SERVER);
/* This is required for classes */
require(realpath($ServerArray['DOCUMENT_ROOT'] . '/../lib') . '/bwcfw.classes.php');

$PageEntity = new LoggingService(__FILE__);

$GetArray = filter_input_array(INPUT_GET);
$Validation = new entity_validation();
//$page_name = 'main_section';
//if (isset($_GET['page'])) {
//    $page_name = filter_input(INPUT_GET, 'page');
//}

if (!$GetArray) {
    $PageEntity->PageActions->setStatus(FALSE);
    $PageEntity->PageActions->setStatusCode("Missing Parameter(s)");
}
if ($PageEntity->PageActions->getStatus()) {
    if (array_key_exists('page', $GetArray)) {
        try {
            $page_name = $Validation->validateStringLengthMinMax($GetArray['page'], 5, 20);
        } catch (Exception $e) {
            $PageEntity->PageActions->setStatus(FALSE);
            $PageEntity->PageActions->setStatusCode($e->getMessage());
            $PageEntity->PageActions->setExtendedStatusCode("Sub function located in " . $e->getFile());
            $PageEntity->PageActions->setLine($e->getLine());
            $PageEntity->LogEntry(3);
        }
    } else {
        $PageEntity->PageActions->setStatus(FALSE);
        $PageEntity->PageActions->setStatusCode("Missing 'page' Parameter");
    }
}



if ($PageEntity->PageActions->getStatus()) {

    switch ($page_name) {
        case "corenetworkdevices":
            //$PageEntity->setParams($page_name);
            break;
        case "networkstats":
            //$PageEntity->setParams($page_name);
            break;
        case "userstats":
            //$PageEntity->setParams($page_name);
            break;
        case "wifistats":
            //$PageEntity->setParams($page_name);
            break;
        case "contactus":
            //$PageEntity->setParams($page_name);
            break;
        case "aboutus":
            //$PageEntity->setParams($page_name);
            break;
        case "gettingstarted":
            //$PageEntity->setParams($page_name);
            break;
        default:
            $page_name = 'main_section';
    }
} else {
    $page_name = 'main_section';
}

#Header section
include 'header_section.php';
#Menu
include '../menu_main.php';
#Main
include $page_name . '.php';
#footer
include 'footer_section.php';
?>
