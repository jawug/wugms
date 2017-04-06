<?php
/* Include the validation checker */
include($_SERVER['DOCUMENT_ROOT'] . '/auth/validate.php');
/* This is required for custom branding */
require($_SERVER['DOCUMENT_ROOT'] . '/content/branding.php');
require($_SERVER['DOCUMENT_ROOT'] . '/content/functions.php');

/* variables*/
$iserror   = false;
$errorcode = "";

if (isValueInRoleArray($_SESSION["roles"], "admin")) {
    if (!empty($_POST)) {
        /* Check and validate the site_name that was supplied */
        if (empty($_POST['site_name'])) {
            // Set the error flag as we do not want the process to run further
            $iserror   = true;
            // Set the error code
            $errorcode = "isBlankSiteName";
            // If the site_name is blank then fail
            // die("Please enter a site_name.");
        } else {
            // Check if the site_name supplied fits into regex ^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?!.*\s).{6,20}$
            if (!preg_match("/^(\([A-Z]{1,3}\))?[A-Za-z0-9]+$/i", $_POST['site_name'])) {
                // Set the error flag as we do not want the process to run further
                $iserror   = true;
                // Set the error code
                $errorcode = "isSiteNameNotCorrect";
            } else {
                // Check if the site_name supplied has not already been used
                $snquery        = "SELECT 1 FROM tbl_base_sites WHERE upper(name) = upper(:site_name) and idSite_Owner = :idSite_Owner ;";
                $snquery_params = array(
                    ':site_name' => $_POST['site_name'],
                    ':idSite_Owner' => $_SESSION["id"]
                );
                try {
                    $snstmt   = $db->prepare($snquery);
                    $snresult = $snstmt->execute($snquery_params);
                }
                catch (PDOException $ex) {
                    die("Failed to run query1: " . $ex->getMessage() . " id:" . $_SESSION["id"] . " site_name:" . $_POST['site_name']);
                }
                $snrow = $snstmt->fetch();
                if ($snrow) {
                    // Set the error flag as we do not want the process to run further
                    $iserror   = true;
                    // Set the error code
                    $errorcode = "isSiteNameTaken";
                }
            }
        }
        
        /* Check and make sure that the user does not have more than 5 sites */
        if (isset($_SESSION["id"])) {
            // Check if the site_name supplied has not already been used
            $snumquery        = "SELECT count(*) 'sites' FROM tbl_base_sites WHERE idSite_Owner = :idSite_Owner ;";
            $snumquery_params = array(
                ':idSite_Owner' => $_SESSION["id"]
            );
            try {
                $snumstmt   = $db->prepare($snumquery);
                $snumresult = $snumstmt->execute($snumquery_params);
            }
            catch (PDOException $ex) {
                die("Failed to run query2: " . $ex->getMessage());
            }
            $snrow = $snstmt->fetch();
            if ($snumresult) {
                if ($snumresult["sites"] < $_SESSION["max_sites"]) {
                    /**/
                } else {
                    // Set the error flag as we do not want the process to run further
                    $iserror   = true;
                    // Set the error code
                    $errorcode = "isMaxSites";
                }
                ;
            } else {
                // Set the error flag as we do not want the process to run further
                $iserror   = true;
                // Set the error code
                $errorcode = "isMaxSites";
            }
        }
        
        /* Check and validate the longitude that was supplied */
        if ($iserror === false) {
            if (empty($_POST['longitude'])) {
                // Set the error flag as we do not want the process to run further
                $iserror   = true;
                // Set the error code
                $errorcode = "isBlankLongitude";
            } else {
                // Check if the longitude supplied is within the parameters
                if (!($_POST['longitude'] >= 16) or !($_POST['longitude'] <= 33)) {
                    // Set the error flag as we do not want the process to run further
                    $iserror   = true;
                    // Set the error code
                    $errorcode = "isLongitudeOutOfLimits";
                }
            }
        }
        
        /* Check and validate the latitude that was supplied */
        if ($iserror === false) {
            if (empty($_POST['latitude'])) {
                // If the latitude is blank then fail
                //die("Please enter a latitude.");
                // Set the error flag as we do not want the process to run further
                $iserror   = true;
                // Set the error code
                $errorcode = "isBlankLatitude";
            } else {
                // Check if the latitude supplied is within the parameters
                if (!($_POST['latitude'] >= -35) or !($_POST['latitude'] <= -22)) {
                    // Set the error flag as we do not want the process to run further
                    $iserror   = true;
                    // Set the error code
                    $errorcode = "isLatitudeOutOfLimits";
                }
            }
        }
        
        /* Check and validate the height that was supplied */
        if ($iserror === false) {
            if (empty($_POST['height'])) {
                // If the height is blank then fail
                //die("Please enter a height.");
                // Set the error flag as we do not want the process to run further
                $iserror   = true;
                // Set the error code
                $errorcode = "isBlankHeight";
            } else {
                // Check if the height supplied is within the parameters
                if (!($_POST['height'] >= 1) or !($_POST['height'] <= 100)) {
                    // Set the error flag as we do not want the process to run further
                    $iserror   = true;
                    // Set the error code
                    $errorcode = "isHeightOutOfLimits";
                }
            }
        }
        
        /* Seeing as there is no error then create the site entry */
        if ($iserror === false) {
            // Section of how the user gets adds 
            $query = "
                  insert into tbl_base_sites (
                    Name
                    ,longitude
                    ,latitude
                    ,height
                    ,idSite_Owner
					,suburb
					,mdate
                  ) VALUES (
                    :site_name
                    ,:longitude
                    ,:latitude
                    ,:height
                    ,:idSite_Owner
					,:suburb
					,now()
                  )";
            
            $query_params = array(
                ':site_name' => $_POST['site_name'],
                ':longitude' => $_POST['longitude'],
                ':latitude' => $_POST['latitude'],
                ':height' => $_POST['height'],
                ':suburb' => $_POST['suburb'],
                ':idSite_Owner' => $_POST['site_owner']
            );
            try {
                $stmt   = $db->prepare($query);
                $result = $stmt->execute($query_params);
                /* First log into the audit table that there was a change request and it met the requirements */
                wugmsaudit("admin", "add", "sites", "Created site - " . $_POST['site_name'] . " UID" . $_POST["site_owner"]);
                //echo "<span class=\"alert alert-success\" >Your site has been created.</span><br><br>";
            }
            catch (PDOException $ex) {
                $newuser = false;
                echo "<span class=\"alert alert-danger\" >Failed to create new site1. Reason " . $ex->getMessage() . "</span><br><br>";
            }
        } else {
            echo "<span class=\"alert alert-danger\" >Failed to create new site2. Reason " . $errorcode . "</span><br><br>";
        }
    } else {
        echo "<span class=\"alert alert-danger\" >Failed to create new site3. Reason DATA_NOT_POSTED</span><br><br>";
    }
}
?>