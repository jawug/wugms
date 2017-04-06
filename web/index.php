<?php

session_start();
$ServerArray = filter_input_array(INPUT_SERVER);
/* This is required for classes */
require(realpath($ServerArray['DOCUMENT_ROOT'] . '/../lib') . '/bwcfw.classes.php');

$PageEntity = new LoggingService(__FILE__);

#Header section
include 'header_section.php';
#Menu
include 'menu_main.php';
#Main
include 'main_section.php';
#footer
include 'footer_section.php';
?>
