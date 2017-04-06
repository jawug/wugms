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
        if (empty($_POST['edit_site_name'])) {
            // Set the error flag as we do not want the process to run further
            $iserror   = true;
            // Set the error code
            $errorcode = "isBlankSiteName";
            // If the site_name is blank then fail
            // die("Please enter a site_name.");
        } else {
            // Check if the site_name supplied fits into regex ^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?!.*\s).{6,20}$
            if (!preg_match("/^(\([A-Z]{1,3}\))?[A-Za-z0-9]+$/i", $_POST['edit_site_name'])) {
                // Set the error flag as we do not want the process to run further
                $iserror   = true;
                // Set the error code
                $errorcode = "isSiteNameNotCorrect";
            }
            /* else {
            // Check if the site_name supplied has not already been used
            $snquery        = "SELECT 1 FROM tbl_base_sites WHERE upper(name) = upper(:site_name) and idSite_Owner = :siteID;";
            $snquery_params = array(
            ':site_name' => $_POST['edit_site_name'],
            ':siteID' =>  $_POST['siteID']
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
            // Set the error flag as we do not want the process to run further
            $iserror   = true;
            // Set the error code
            $errorcode = "isSiteNameTaken";
            }
            }*/
        }
        ;
        
        /* Check and make sure that the user does not have more than 5 sites */
        /*	if (isset($_SESSION["id"])) {
        // Check if the site_name supplied has not already been used
        $snquery        = "SELECT 1 FROM tbl_base_sites WHERE upper(name) = upper(':site_name') and idSite_Owner = " . $_SESSION["id"] . ";";
        $snquery_params = array(
        ':site_name' => $_POST['site_name']
        );
        try {
        $snstmt   = $db->prepare($snquery);
        $snresult = $snstmt->execute($snquery_params);
        }
        catch (PDOException $ex) {
        die("Failed to run query: " . $ex->getMessage());
        }
        $snrow = $snstmt->fetch();
        if ($row) {
        // Set the error flag as we do not want the process to run further
        $iserror   = true;
        // Set the error code
        $errorcode = "isMaxSites";
        }	*/
        
        /* Check and validate the longitude that was supplied */
        if ($iserror === false) {
            if (empty($_POST['edit_longitude'])) {
                // Set the error flag as we do not want the process to run further
                $iserror   = true;
                // Set the error code
                $errorcode = "isBlankLongitude";
            } else {
                // Check if the longitude supplied is within the parameters
                if (!($_POST['edit_longitude'] >= 16) or !($_POST['edit_longitude'] <= 33)) {
                    // Set the error flag as we do not want the process to run further
                    $iserror   = true;
                    // Set the error code
                    $errorcode = "isLongitudeOutOfLimits";
                }
            }
        }
        ;
        
        /* Check and validate the latitude that was supplied */
        if ($iserror === false) {
            if (empty($_POST['edit_latitude'])) {
                // If the latitude is blank then fail
                //die("Please enter a latitude.");
                // Set the error flag as we do not want the process to run further
                $iserror   = true;
                // Set the error code
                $errorcode = "isBlankLatitude";
            } else {
                // Check if the latitude supplied is within the parameters
                if (!($_POST['edit_latitude'] >= -35) or !($_POST['edit_latitude'] <= -22)) {
                    // Set the error flag as we do not want the process to run further
                    $iserror   = true;
                    // Set the error code
                    $errorcode = "isLatitudeOutOfLimits";
                }
            }
        }
        ;
        
        /* Check and validate the height that was supplied */
        if ($iserror === false) {
            if (empty($_POST['edit_height'])) {
                // If the height is blank then fail
                //die("Please enter a height.");
                // Set the error flag as we do not want the process to run further
                $iserror   = true;
                // Set the error code
                $errorcode = "isBlankHeight";
            } else {
                // Check if the height supplied is within the parameters
                if (!($_POST['edit_height'] >= 1) or !($_POST['edit_height'] <= 100)) {
                    // Set the error flag as we do not want the process to run further
                    $iserror   = true;
                    // Set the error code
                    $errorcode = "isHeightOutOfLimits";
                }
            }
        }
        ;
        
        /* Seeing as there is no error then create the site entry */
        if ($iserror === false) {
            // Section of how the site gets updated
            $query = "update tbl_base_sites SET
					Name = :site_name
					,longitude = :longitude
					,latitude = :latitude
					,height = :height
					,MDate = now()
					,suburb = :suburb
					,idSite_Owner = :userID
					WHERE siteID = :siteID ;";
            
            $query_params = array(
                ':site_name' => $_POST['edit_site_name'],
                ':longitude' => $_POST['edit_longitude'],
                ':latitude' => $_POST['edit_latitude'],
                ':height' => $_POST['edit_height'],
                ':suburb' => $_POST['edit_suburb'],
                ':siteID' => $_POST['edit_siteid'],
                ':userID' => $_POST['edit_site_owner']
            );
            try {
                $stmt   = $db->prepare($query);
                $result = $stmt->execute($query_params);
                /* First log into the audit table that there was a change request and it met the requirements */
                wugmsaudit("admin", "edit", "sites", "Edited site - " . $_POST['Editsite_name_oem'] . "->" . $_POST['edit_site_name'] . " UID" . $_POST['edit_site_owner']);
            }
            catch (PDOException $ex) {
                $newuser = false;
                echo "<span class=\"alert alert-danger\" >Failed to edit site1. Reason " . $ex->getMessage() . "</span><br><br>";
            }
			
/* Section to update all teh RBs that are allocated to that site and which are meant to be using the "use site's info" setting set */
            $query_rb_update_2       = "UPDATE tbl_base_rb_routerboard a, tbl_base_sites b
                                        SET a.latitude = b.latitude,
                                            a.longitude = b.longitude,
                                            a.height = b.height,
                                            a.SiteName = b.Name
                                      WHERE a.isUseSiteinfo = 2 AND b.siteID = :siteID AND a.siteID = :siteID";
            /* Setting the params */
            $query_params_rb_update_2 = array(
                ':siteID' => $_POST['edit_siteid']
            );
            try {
                $stmt_rb_update_2   = $db->prepare($query_rb_update_2);
                $result_rb_update_2 = $stmt_rb_update_2->execute($query_params_rb_update_2);
                /* First log into the audit table that there was a change request and it met the requirements */
                /* wugmsaudit("admin", "edit", "routerboard", "Edited RB - " . $_POST['edit_serial_number'] . " UID" . $_POST['edit_rb_owner']);*/
            }
            catch (PDOException $ex) {
                die("Failed to run query: " . $ex->getMessage());
            }

            /* Section to update all the RBs that are allocated to that site but just the sitename */
            $query_rb_update_1       = "UPDATE tbl_base_rb_routerboard a, tbl_base_sites b
                                        SET a.SiteName = b.Name
                                      WHERE a.isUseSiteinfo = 1 AND b.siteID = :siteID AND a.siteID = :siteID";
            /* Setting the params */
            $query_params_rb_update_1 = array(
                ':siteID' => $_POST['edit_siteid']
            );
            try {
                $stmt_rb_update_1   = $db->prepare($query_rb_update_1);
                $result_rb_update_1 = $stmt_rb_update_1->execute($query_params_rb_update_1);
                /* First log into the audit table that there was a change request and it met the requirements */
                /* wugmsaudit("admin", "edit", "routerboard", "Edited RB - " . $_POST['edit_serial_number'] . " UID" . $_POST['edit_rb_owner']);*/
            }
            catch (PDOException $ex) {
                die("Failed to run query: " . $ex->getMessage());
            }			
			
        } else {
            echo "<span class=\"alert alert-danger\" >Failed to edit site2. Reason " . $errorcode . "</span><br><br>";
        }
    } else {
        echo "<span class=\"alert alert-danger\" >Failed to edit site3. Reason DATA_NOT_POSTED</span><br><br>";
    }
}
?>