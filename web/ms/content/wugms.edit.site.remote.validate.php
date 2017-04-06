<?php
/* Start session */
session_start();
/* If someone is posting this as empty and there is no username set then do not run */

if (!empty($_POST) && isset($_SESSION["id"])) {
    #Include the connect.php file
    require($_SERVER['DOCUMENT_ROOT'] . '/auth/config.php');
    $isAvailable = true;
	/* Check to see which type of post is incoming */    
    switch ($_POST['type']) {
        case 'edit_name_of_site':
            $snquery        = "SELECT 1 FROM tbl_base_sites WHERE upper(name) = upper(:site_name) and not upper(name) = upper(:oem_name) and idSite_Owner = :user_id ;";
            $snquery_params = array(
                ':site_name' => $_POST['edit_site_name'],
				':oem_name' => $_POST['oem_name'],
				':user_id' => $_SESSION["id"]
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
            break;
        
        case 'name_of_site_admin':
        default:
            $snquery        = "SELECT 1 FROM tbl_base_sites WHERE upper(name) = upper(:site_name) and idSite_Owner = :user_id ;";
            $snquery_params = array(
                ':site_name' => $_POST['edit_site_name'],
				':user_id' => $_SESSION["id"]
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
            break;
    }
    
    // Finally, return a JSON
    echo json_encode(array(
        'valid' => $isAvailable
    ));
    /* Close the db connection */
    //    mysqli_close($con);
}

?>