<?php 
/* Start session */
/* No validation will be done because this is a public page */
session_start();
/* This is required for custom branding */
require($_SERVER['DOCUMENT_ROOT'].'/content/branding.php');
/* This is required for custom functions */
require($_SERVER['DOCUMENT_ROOT'].'/content/functions.php');
/* Load the DB connection */
require($_SERVER['DOCUMENT_ROOT'] . "/auth/config.php");
#Header section
include 'header.php';
#Menu
include 'menu.php';
#Main
include 'main.php';
#footer
include 'footer.php';

?>