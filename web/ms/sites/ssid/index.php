<?php 
/* Include the validation checker */
include($_SERVER['DOCUMENT_ROOT'].'/auth/validate.php');
/* This is required for custom branding */
require($_SERVER['DOCUMENT_ROOT'].'/content/branding.php');
require($_SERVER['DOCUMENT_ROOT'].'/content/functions.php');
#Header section
include 'header.php';
#Menu
include 'menu.php';
#Main
include 'main.php';
#footer
include 'footer.php';

?>