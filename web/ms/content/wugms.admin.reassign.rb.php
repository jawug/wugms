<?php
/* Start session */
session_start();
require($_SERVER['DOCUMENT_ROOT'] . '/auth/config.php');
require($_SERVER['DOCUMENT_ROOT'] . '/content/functions.php');

/* variables*/
$iserror   = false;
$errorcode = "";

if (isValueInRoleArray($_SESSION["roles"], "admin")) {
    if (!empty($_POST)) {
        /* Check and validate the site_name that was supplied */
        if (empty($_POST['confirmreassign'])) {
            // Set the error flag as we do not want the process to run further
            $iserror   = true;
            // Set the error code
            $errorcode = "isBlankConfirm";
            // If the site_name is blank then fail
            // die("Please enter a site_name.");
        } else {
            // Check that the result is about right
            if ($_POST['confirmreassign'] !== "on") {
                // Set the error flag as we do not want the process to run further
                $iserror   = true;
                // Set the error code
                $errorcode = "isConfirmNotRight";
            }
        }
        
        /* Check and make sure that the user exists */
        if (!empty($_POST['reassign_rb_owner'])) {
            // Check if the site_name supplied has not already been used
            $snquery        = "SELECT 1 FROM tbl_base_user WHERE idtbl_base_user = :idtbl_base_user;";
            $snquery_params = array(
                ':idtbl_base_user' => $_POST['reassign_rb_owner']
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
                /* Nothing */
            } else {
                // Set the error flag as we do not want the process to run further
                $iserror   = true;
                // Set the error code
                $errorcode = "isNoValidUser";
            }
        }
        
        /* Check and make sure that the serial_number exists */
        if (!empty($_POST['reassign_serial_number'])) {
            // Check if the site_name supplied has not already been used
            $snquery        = "SELECT 1 FROM tbl_base_rb_routerboard WHERE Serial_Number = :Serial_Number ;";
            $snquery_params = array(
                ':Serial_Number' => $_POST['reassign_serial_number']
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
                /* Nothing */
            } else {
                // Set the error flag as we do not want the process to run further
                $iserror   = true;
                // Set the error code
                $errorcode = "isNoValidSN";
            }
        } else {
            // Set the error flag as we do not want the process to run further
            $iserror   = true;
            // Set the error code
            $errorcode = "isEmptySN";
        }
        
        
        /* Seeing as there is no error then create the site entry */
        if ($iserror === false) {
            // Section of how the user gets adds 
            $query = "UPDATE tbl_base_rb_routerboard
					SET idSite_Owner = :idSite_Owner
					WHERE Serial_Number = :Serial_Number ;";
            
            $query_params = array(
                ':idSite_Owner' => $_POST['reassign_rb_owner'],
                ':Serial_Number' => $_POST["reassign_serial_number"]
            );
            try {
                $stmt   = $db->prepare($query);
                $result = $stmt->execute($query_params);
                /* First log into the audit table that there was a change request and it met the requirements */
                wugmsaudit("admin", "reassign", "routerboard", "Reassigned routerboard - " . $_POST['reassign_serial_number'] . " UID" . $_POST["reassign_rb_owner"]);
                //echo "<span class=\"alert alert-success\" >Your site has been created.</span><br><br>";
            }
            catch (PDOException $ex) {
                $newuser = false;
                echo "<span class=\"alert alert-danger\" >Failed to reassign site1. Reason " . $ex->getMessage() . "</span><br><br>";
            }
        } else {
            echo "<span class=\"alert alert-danger\" >Failed to reassign site2. Reason " . $errorcode . "</span><br><br>";
        }
    } else {
        echo "<span class=\"alert alert-danger\" >Failed to reassign site3. Reason isBlank </span><br><br>";
    }
}
?>