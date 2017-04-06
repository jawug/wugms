<?php 
/* Start session */
/* No validation will be done because this is a public page */
session_start();
/* This is required for custom branding */
require($_SERVER['DOCUMENT_ROOT'].'/content/branding.php');
#Header section
include 'header.php';
#Menu
include 'menu.php';
#Main
include 'main.php';
#footer
include 'footer.php';

?>
