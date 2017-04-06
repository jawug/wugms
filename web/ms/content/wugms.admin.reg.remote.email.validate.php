<?php
/* Include the validation checker */
include($_SERVER['DOCUMENT_ROOT'] . '/auth/validate.php');
/* This is required for custom branding */
require($_SERVER['DOCUMENT_ROOT'] . '/content/branding.php');
require($_SERVER['DOCUMENT_ROOT'] . '/content/functions.php');

if (!empty($_POST) && isValueInRoleArray($_SESSION["roles"], "admin")) {

	$isAvailable = true;
	$snquery        = "SELECT 1 FROM tbl_base_user WHERE upper(username) = upper(:editemail) and not upper(username) = upper(:oem_email) ;";
	/* Set up the parameters for teh query */
	$snquery_params = array(
		':editemail' => $_POST["editemail"],
		':oem_email' => $_POST["oem_email"]
		);
	try {
		$snstmt   = $db->prepare($snquery);
		$snresult = $snstmt->execute($snquery_params);
		}
	catch (PDOException $ex) {
		die("Failed to run query: " . $ex->getMessage());
		}
	$snrow = $snstmt->fetch();
	if ($snrow) {
		$isAvailable = false;
		}
	
    
    // Finally, return a JSON
    echo json_encode(array(
        'valid' => $isAvailable
    ));

}

?>