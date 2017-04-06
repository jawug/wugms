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
        /* Check and validate the value is not blank */
        if (empty($_POST['edit_serial_number'])) {
            // Set the error flag as we do not want the process to run further
            $iserror   = true;
            // Set the error code
            $errorcode = "isBlankSN";
        }
        
        /* Check and validate the value is not blank */
        if (empty($_POST['edit_rb_sitename'])) {
            // Set the error flag as we do not want the process to run further
            $iserror   = true;
            // Set the error code
            $errorcode = "isBlankSiteID";
        }
        
        /* Check and make sure that the user exists */
        if (!empty($_POST['edit_rb_owner'])) {
            // Check if the site_name supplied has not already been used
            $snquery        = "SELECT 1 FROM tbl_base_user WHERE idtbl_base_user = :idtbl_base_user;";
            $snquery_params = array(
                ':idtbl_base_user' => $_POST['edit_rb_owner']
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
        
        /* Check and validate the site_name that was supplied */
        if (empty($_POST['edit_rb_use_site_coords'])) {
            // Set the error flag as we do not want the process to run further
            $iserror   = true;
            // Set the error code
            $errorcode = "isBlankUseCoOrds";
            // If the site_name is blank then fail
            // die("Please enter a site_name.");
        } else {
            if ($_POST['edit_rb_use_site_coords'] == '1') {
                /* Check and validate the longitude that was supplied */
                if ($iserror === false) {
                    if (empty($_POST['edit_rb_longitude'])) {
                        // Set the error flag as we do not want the process to run further
                        $iserror   = true;
                        // Set the error code
                        $errorcode = "isBlankLongitude";
                    } else {
                        // Check if the longitude supplied is within the parameters
                        if (!($_POST['edit_rb_longitude'] >= 16) or !($_POST['edit_rb_longitude'] <= 33)) {
                            // Set the error flag as we do not want the process to run further
                            $iserror   = true;
                            // Set the error code
                            $errorcode = "isLongitudeOutOfLimits";
                        }
                    }
                }
                /* Check and validate the latitude that was supplied */
                if ($iserror === false) {
                    if (empty($_POST['edit_rb_latitude'])) {
                        // If the latitude is blank then fail
                        //die("Please enter a latitude.");
                        // Set the error flag as we do not want the process to run further
                        $iserror   = true;
                        // Set the error code
                        $errorcode = "isBlankLatitude";
                    } else {
                        // Check if the latitude supplied is within the parameters
                        if (!($_POST['edit_rb_latitude'] >= -35) or !($_POST['edit_rb_latitude'] <= -22)) {
                            // Set the error flag as we do not want the process to run further
                            $iserror   = true;
                            // Set the error code
                            $errorcode = "isLatitudeOutOfLimits";
                        }
                    }
                }
                /* Check and validate the height that was supplied */
                if ($iserror === false) {
                    if (empty($_POST['edit_rb_height'])) {
                        // If the height is blank then fail
                        //die("Please enter a height.");
                        // Set the error flag as we do not want the process to run further
                        $iserror   = true;
                        // Set the error code
                        $errorcode = "isBlankHeight";
                    } else {
                        // Check if the height supplied is within the parameters
                        if (!($_POST['edit_rb_height'] >= 1) or !($_POST['edit_rb_height'] <= 100)) {
                            // Set the error flag as we do not want the process to run further
                            $iserror   = true;
                            // Set the error code
                            $errorcode = "isHeightOutOfLimits";
                        }
                    }
                }
                /* End of edit_rb_use_site_coords = 1 */
            }
        }
        
        /* Seeing as there is no error then edit the entry */
        if ($iserror === false) {
            
            /* Check if the AE table needs to be updated. If the sn and siteID are the same as an entry then no changes */
            $snquery_confirm        = "SELECT 1 FROM wugms.tbl_ae_sites_rbs a WHERE ae_Serial_Number = :ae_serial_number and a.ae_siteID = :ae_siteID ;";
            $snquery_params_confirm = array(
                ':ae_serial_number' => $_POST['edit_serial_number'],
                ':ae_siteID' => $_POST['edit_rb_sitename']
            );
            try {
                $snstmt_confirm   = $db->prepare($snquery_confirm);
                $snresult_confirm = $snstmt_confirm->execute($snquery_params_confirm);
            }
            catch (PDOException $ex) {
                die("Failed to run query: " . $ex->getMessage());
            }
            $snrow_confirm = $snstmt_confirm->fetch();
            if ($snrow_confirm) {
                /* Well the entry existed so nothing to update */
            } else {
                // Check if the AE table has an entry for teh serial number
                $snquery        = "SELECT 1 FROM tbl_ae_sites_rbs WHERE ae_Serial_Number = :ae_serial_number;";
                $snquery_params = array(
                    ':ae_serial_number' => $_POST['edit_serial_number']
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
                    /* If there is an entry then delete it */
                    $snquerycleanup        = "DELETE FROM tbl_ae_sites_rbs WHERE ae_Serial_Number = :ae_serial_number;";
                    $snquerycleanup_params = array(
                        ':ae_serial_number' => $_POST['edit_serial_number']
                    );
                    try {
                        $snstmtcleanup   = $db->prepare($snquerycleanup);
                        $snresultcleanup = $snstmtcleanup->execute($snquerycleanup_params);
                    }
                    catch (PDOException $ex) {
                        die("Failed to run query: " . $ex->getMessage());
                    }
                }
                /* Now add an entry to the AE table */
                $snquery_update        = "INSERT INTO tbl_ae_sites_rbs (ae_siteID, ae_Serial_Number) VALUES (:siteID, :serial_number);";
                $snquery_params_update = array(
                    ':serial_number' => $_POST['edit_serial_number'],
                    ':siteID' => $_POST['edit_rb_sitename']
                );
                try {
                    $snstmt_update   = $db->prepare($snquery_update);
                    $snresult_update = $snstmt_update->execute($snquery_params_update);
                }
                catch (PDOException $ex) {
                    die("Failed to run query: " . $ex->getMessage());
                }
            }
            
            /* Depending on the changes selected do the magic */
            if ($_POST['edit_rb_use_site_coords'] == '1') {
                /* Query for manual co-ords */
                $query        = "  UPDATE tbl_base_rb_routerboard a, tbl_base_sites b
						   SET a.latitude = :latitude,
						       a.longitude = :longitude,
						       a.height = :height,
						       a.SiteName = b.Name,
						       a.idSite_Owner = :idSite_Owner,
						       a.isUseSiteinfo = :isUseSiteinfo,
						       a.siteID = b.siteID
						 WHERE a.Serial_Number = :serial_sumber AND b.siteID = :siteID;";
                /* Setting the params */
                $query_params = array(
                    ':latitude' => $_POST['edit_rb_latitude'],
                    ':longitude' => $_POST['edit_rb_longitude'],
                    ':height' => $_POST['edit_rb_height'],
                    ':idSite_Owner' => $_POST['edit_rb_owner'],
                    ':isUseSiteinfo' => $_POST['edit_rb_use_site_coords'],
                    ':serial_sumber' => $_POST['edit_serial_number'],
                    ':siteID' => $_POST['edit_rb_sitename']
                );
            } else {
                /* Query for site co-ords */
                $query        = "  UPDATE tbl_base_rb_routerboard a, tbl_base_sites b
						   SET a.latitude = b.latitude,
						       a.longitude = b.longitude,
						       a.height = b.height,
						       a.SiteName = b.Name,
						       a.idSite_Owner = :idSite_Owner,
						       a.isUseSiteinfo = :isUseSiteinfo,
						       a.siteID = b.siteID
						 WHERE a.Serial_Number = :serial_sumber AND b.siteID = :siteID;";
                /* Setting the params */
                $query_params = array(
                    ':idSite_Owner' => $_POST['edit_rb_owner'],
                    ':isUseSiteinfo' => $_POST['edit_rb_use_site_coords'],
                    ':serial_sumber' => $_POST['edit_serial_number'],
                    ':siteID' => $_POST['edit_rb_sitename']
                );
            }
            
            try {
                $stmt   = $db->prepare($query);
                $result = $stmt->execute($query_params);
                /* First log into the audit table that there was a change request and it met the requirements */
                wugmsaudit("admin", "edit", "routerboard", "Edited RB - " . $_POST['edit_serial_number'] . " UID" . $_POST['edit_rb_owner']);
            }
            catch (PDOException $ex) {
                $newuser = false;
                echo "<span class=\"alert alert-danger\" >Failed to edit rb1. Reason " . $ex->getMessage() . "</span><br><br>";
            }
        } else {
            echo "<span class=\"alert alert-danger\" >Failed to edit rb2. Reason " . $errorcode . "</span><br><br>";
        }
    } else {
        echo "<span class=\"alert alert-danger\" >Failed to edit rb3. Reason DATA_NOT_POSTED</span><br><br>";
    }
}
?>