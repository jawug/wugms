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
    ;
    
    /* Check and validate the user Id and site id */
    if ($iserror === false) {
        if (empty($_POST['reassign_siteid'])) {
            // Set the error flag as we do not want the process to run further
            $iserror   = true;
            // Set the error code
            $errorcode = "isBlankID";
        } else {
            if (!isset($_SESSION["id"])) {
                // Set the error flag as we do not want the process to run further
                $iserror   = true;
                // Set the error code
                $errorcode = "isBlankID";
            } else {
                /* query to check that site id and user id are right */
                $snquery        = "SELECT 1 FROM tbl_base_sites WHERE siteID = :siteID;";
                $snquery_params = array(
                    ':siteID' => $_POST['reassign_siteid']
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
                } else {
                    // Set the error flag as we do not want the process to run further
                    $iserror   = true;
                    // Set the error code
                    $errorcode = "isBlankIDsite";
                }
            }
        }
    }
    ;
    
    /* Seeing as there is no error then create the site entry */
    if ($iserror === false) {
        // Section of how the user gets adds 
        $query = "update tbl_base_sites SET
					idSite_Owner = :user_ID
					WHERE siteID = :siteID;";
        
        $query_params = array(
            ':siteID' => $_POST['reassign_siteid'],
            ':user_ID' => $_POST["reassign_site_owner"]
        );
        try {
            $stmt   = $db->prepare($query);
            $result = $stmt->execute($query_params);
            /* First log into the audit table that there was a change request and it met the requirements */
            wugmsaudit("admin", "delete", "sites", "Reassigned site - " . $_POST['reassign_site_name'] . " UID" . $_POST["reassign_site_owner"]);
            //echo "<span class=\"alert alert-success\" >Your site has been created.</span><br><br>";
        }
        catch (PDOException $ex) {
            $newuser = false;
            echo "<span class=\"alert alert-danger\" >Failed to delete site1. Reason " . $ex->getMessage() . "</span><br><br>";
        }
    } else {
        echo "<span class=\"alert alert-danger\" >Failed to delete site2. Reason " . $errorcode . "</span><br><br>";
        //} else {
        //	echo "<span class=\"alert alert-danger\" >Failed to delete site3. Reason DATA_NOT_POSTED</span><br><br>";
    }
}
}
?>