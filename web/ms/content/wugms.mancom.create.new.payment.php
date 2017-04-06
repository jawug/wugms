<?php
/* Include the validation checker */
include($_SERVER['DOCUMENT_ROOT'] . '/auth/validate.php');
/* This is required for custom branding */
require($_SERVER['DOCUMENT_ROOT'] . '/content/branding.php');
require($_SERVER['DOCUMENT_ROOT'] . '/content/functions.php');


/* variables*/
$iserror   = false;
$errorcode = "";

$irc_nick  = "";
$firstName = "";
$lastName  = "";
$comment   = "N/C";


if (!empty($_POST) && (isValueInRoleArray($_SESSION["roles"], "mancom"))) {
    
    /* Check and validate the user ID that the payment entry must be allocated to */
    if (empty($_POST['puser'])) {
        // Set the error flag as we do not want the process to run further
        $iserror   = true;
        // Set the error code
        $errorcode = "isBlankUserID";
        // If the puser is blank then fail
    } else {
        // Check if the puser id supplied does exist
        $snquery        = "SELECT irc_nick, firstName, lastName FROM tbl_base_user WHERE idtbl_base_user = :check_id ;";
        $snquery_params = array(
            ':check_id' => $_POST['puser']
        );
        try {
            $snstmt   = $db->prepare($snquery);
            $snresult = $snstmt->execute($snquery_params);
        }
        catch (PDOException $ex) {
            die("Failed to run query1: " . $ex->getMessage() . " puser:" . $_POST['puser']);
        }
        $snrow = $snstmt->fetch();
        if ($snrow) {
            // Assign the results to vars
            $irc_nick  = $snrow["irc_nick"];
            $firstName = $snrow["firstName"];
            $lastName  = $snrow["lastName"];
        } else {
            // Set the error flag as we do not want the process to run further
            $iserror   = true;
            // Set the error code
            $errorcode = "isUnknownUserID";
        }
    }
    
    /* Check and validate the payment method */
    if ($iserror === false) {
        if (empty($_POST['pmethod'])) {
            // Set the error flag as we do not want the process to run further
            $iserror   = true;
            // Set the error code
            $errorcode = "isBlankMethod";
            // If the pmethod is blank then fail
        } else {
            
            // Check if the pmethod id supplied does exist
            $snquery        = "SELECT 1 FROM tbl_base_payment_method WHERE payment_method = :check_id ;";
            $snquery_params = array(
                ':check_id' => $_POST['pmethod']
            );
            try {
                $snstmt   = $db->prepare($snquery);
                $snresult = $snstmt->execute($snquery_params);
            }
            catch (PDOException $ex) {
                die("Failed to run query2: " . $ex->getMessage() . " pmethod:" . $_POST['pmethod']);
            }
            $snrow = $snstmt->fetch();
            if ($snrow) {
                //
            } else {
                // Set the error flag as we do not want the process to run further
                $iserror   = true;
                // Set the error code
                $errorcode = "isUnknownMethod";
            }
        }
    }
    
    /* Check, validate and get teh user's information */
    if ($iserror === false) {
        if (empty($_POST['pmethod'])) {
            // Set the error flag as we do not want the process to run further
            $iserror   = true;
            // Set the error code
            $errorcode = "isBlankMethod";
            // If the pmethod is blank then fail
        } else {
            
            // Check if the pmethod id supplied does exist
            $snquery        = "SELECT 1 FROM tbl_base_payment_method WHERE payment_method = :check_id ;";
            $snquery_params = array(
                ':check_id' => $_POST['pmethod']
            );
            try {
                $snstmt   = $db->prepare($snquery);
                $snresult = $snstmt->execute($snquery_params);
            }
            catch (PDOException $ex) {
                die("Failed to run query2: " . $ex->getMessage() . " pmethod:" . $_POST['pmethod']);
            }
            $snrow = $snstmt->fetch();
            if ($snrow) {
                //
            } else {
                // Set the error flag as we do not want the process to run further
                $iserror   = true;
                // Set the error code
                $errorcode = "isUnknownMethod";
            }
        }
    }
    
    /* Check and validate the payment type */
    if ($iserror === false) {
        if (empty($_POST['ptype'])) {
            // Set the error flag as we do not want the process to run further
            $iserror   = true;
            // Set the error code
            $errorcode = "isBlankType";
            // If the ptype is blank then fail
        } else {
            
            // Check if the ptype id supplied does exist
            $snquery        = "SELECT 1 FROM tbl_base_payment_type WHERE payment_type = :check_id ;";
            $snquery_params = array(
                ':check_id' => $_POST['ptype']
            );
            try {
                $snstmt   = $db->prepare($snquery);
                $snresult = $snstmt->execute($snquery_params);
            }
            catch (PDOException $ex) {
                die("Failed to run query3: " . $ex->getMessage() . " ptype:" . $_POST['ptype']);
            }
            $snrow = $snstmt->fetch();
            if ($snrow) {
                //
            } else {
                // Set the error flag as we do not want the process to run further
                $iserror   = true;
                // Set the error code
                $errorcode = "isUnknownType";
            }
        }
    }
    
    /* Check that a date was supplied */
    if ($iserror === false) {
        if (empty($_POST['pdate'])) {
            // Set the error flag as we do not want the process to run further
            $iserror   = true;
            // Set the error code
            $errorcode = "isBlankDate";
        } else {
            if (!preg_match("/^[0-9]{4}\/[0-9]{2}\/[0-9]{2}$/", $_POST['pdate'])) {
                // Set the error flag as we do not want the process to run further
                $iserror   = true;
                // Set the error code
                $errorcode = "isWrongDate";
                
                // ???
            } else {
                //
            }
            
        }
    }
    
    /* Check that an amount was supplied */
    if ($iserror === false) {
        if (empty($_POST['pamount'])) {
            // Set the error flag as we do not want the process to run further
            $iserror   = true;
            // Set the error code
            $errorcode = "isBlankAmount";
        } else {
            if ($_POST['pamount'] >= 0) {
                // Well the amount is correct as it is 0 or bigger
            } else {
                // Set the error flag as we do not want the process to run further
                $iserror   = true;
                // Set the error code
                $errorcode = "isNegativeAmount";
            }
        }
    }
    
    /* Check that an amount was supplied */
    if ($iserror === false) {
        if (!empty($_POST['pcomment'])) {
            $comment = $_POST['pcomment'];
        }
    }
    
    /* Seeing as there is no error then create the site entry */
    if ($iserror === false) {
        // Section of how the user gets adds 
        $query = "
        INSERT INTO tbl_base_user_payments(
                iduser,
                pdate,
                firstName,
                lastName,
                irc_nick,
                idpayment_type,
                idpayment_method,
                comment,
                amount)
        VALUES ( 
                 :userid,
                 :pdate,
                 :firstName,
                 :lastName,
                 :irc_nick,
                 :idpayment_type,
                 :idpayment_method,
                 :comment,
                 :amount);";
		 
        $query_params = array(
            ':userid'           => $_POST['puser'],
            ':pdate'            => $_POST['pdate'],
            ':firstName'        => $firstName,
            ':lastName'         => $lastName,
            ':irc_nick'         => $irc_nick,
            ':idpayment_type'   => $_POST['ptype'],
            ':idpayment_method' => $_POST['pmethod'],
            ':comment'          => $comment,
            ':amount'           => $_POST['pamount']
        );
        try {
            $stmt   = $db->prepare($query);
            $result = $stmt->execute($query_params);
            /* First log into the audit table that there was a change request and it met the requirements */
            wugmsaudit("MANCOM", "add", "payments", "New payment entry; Entered by " . $_SESSION["irc_nick"] . " (" . $_SESSION["id"] . ") For User: " . $firstName . " (" . $irc_nick . ") " . $lastName . " Ptype: " . $_POST['ptype'] . " PMethod: " . $_POST['pmethod'] . " Amount: " . $_POST['pamount'] . " Comment: " . $_POST['pcomment']);
            //echo "<span class=\"alert alert-success\" >Your site has been created.</span><br><br>";
        }
        catch (PDOException $ex) {
            $newuser = false;
            echo "<span class=\"alert alert-danger\" >Failed to create new payment entry. Reason " . $ex->getMessage() . "</span><br><br>";
        }
    } else {
        echo "<span class=\"alert alert-danger\" >Failed to create new payment entry. Reason " . $errorcode . "</span><br><br>";
    }
} else {
    echo "<span class=\"alert alert-danger\" >Failed to create new payment entry. Reason DATA_NOT_POSTED</span><br><br>";
}

?>