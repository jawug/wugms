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
/*
				<input type="hidden" name="edit_payment_oem_id"        id="edit_payment_oem_id" value="">
				<input type="hidden" name="edit_payment_oem_user_id"   id="edit_payment_oem_user_id" value="">

				<input type="hidden" name="edit_payment_oem_date"      id="edit_payment_oem_date" value="">
				<input type="hidden" name="edit_payment_oem_method"    id="edit_payment_oem_method" value="">
				<input type="hidden" name="edit_payment_oem_type"      id="edit_payment_oem_type" value="">
				<input type="hidden" name="edit_payment_oem_amount"    id="edit_payment_oem_amount" value="">
				<input type="hidden" name="edit_payment_oem_comment"   id="edit_payment_oem_comment" value=""	
*/
    /* Check and validate the "oem" user ID */
	
	if (!empty($_POST['edit_payment_oem_id'])&&!empty($_POST['edit_payment_oem_user_id'])&&!empty($_POST['edit_payment_oem_method'])&&!empty($_POST['edit_payment_oem_type'])){
        // Check if the edit_payment_oem_user_id id supplied does exist
        $snquery        = "SELECT 1 FROM tbl_base_user_payments WHERE 
		idtbl_base_user_payments = :check_id and iduser = :iduser and idpayment_type = :idpayment_type and idpayment_method = :idpayment_method and amount = :amount ;";
        $snquery_params = array(
            ':check_id' => $_POST['edit_payment_oem_id'],
			':iduser' => $_POST['edit_payment_oem_user_id'],
			':idpayment_method' => $_POST['edit_payment_oem_method'],
			':idpayment_type' => $_POST['edit_payment_oem_type'],
			':amount' => $_POST['edit_payment_oem_amount']
        );
        try {
            $snstmt   = $db->prepare($snquery);
            $snresult = $snstmt->execute($snquery_params);
        }
        catch (PDOException $ex) {
            die("Failed to run query1: " . $ex->getMessage() . " edit_payment_oem_user_id:" . $_POST['edit_payment_oem_user_id']);
        }
        $snrow = $snstmt->fetch();
        if ($snrow) {
            // Assign the results to vars

        } else {
            // Set the error flag as we do not want the process to run further
            $iserror   = true;
            // Set the error code
            $errorcode = "isUnknownOEMPayment";
        }
	} else {
            // Set the error flag as we do not want the process to run further
            $iserror   = true;
            // Set the error code
            $errorcode = "isOEMMissingSomething";	
	}

    /* Check and validate the user ID that the payment entry must be allocated to */
    if (empty($_POST['euser'])) {
        // Set the error flag as we do not want the process to run further
        $iserror   = true;
        // Set the error code
        $errorcode = "isBlankUserID";
        // If the euser is blank then fail
    } else {
        // Check if the euser id supplied does exist
        $snquery        = "SELECT irc_nick, firstName, lastName FROM tbl_base_user WHERE idtbl_base_user = :check_id ;";
        $snquery_params = array(
            ':check_id' => $_POST['euser']
        );
        try {
            $snstmt   = $db->prepare($snquery);
            $snresult = $snstmt->execute($snquery_params);
        }
        catch (PDOException $ex) {
            die("Failed to run query1: " . $ex->getMessage() . " euser:" . $_POST['euser']);
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
        if (empty($_POST['emethod'])) {
            // Set the error flag as we do not want the process to run further
            $iserror   = true;
            // Set the error code
            $errorcode = "isBlankMethod";
            // If the emethod is blank then fail
        } else {
            
            // Check if the emethod id supplied does exist
            $snquery        = "SELECT 1 FROM tbl_base_payment_method WHERE payment_method = :check_id ;";
            $snquery_params = array(
                ':check_id' => $_POST['emethod']
            );
            try {
                $snstmt   = $db->prepare($snquery);
                $snresult = $snstmt->execute($snquery_params);
            }
            catch (PDOException $ex) {
                die("Failed to run query2: " . $ex->getMessage() . " emethod:" . $_POST['emethod']);
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
        if (empty($_POST['etype'])) {
            // Set the error flag as we do not want the process to run further
            $iserror   = true;
            // Set the error code
            $errorcode = "isBlankType";
            // If the etype is blank then fail
        } else {
            
            // Check if the etype id supplied does exist
            $snquery        = "SELECT 1 FROM tbl_base_payment_type WHERE payment_type = :check_id ;";
            $snquery_params = array(
                ':check_id' => $_POST['etype']
            );
            try {
                $snstmt   = $db->prepare($snquery);
                $snresult = $snstmt->execute($snquery_params);
            }
            catch (PDOException $ex) {
                die("Failed to run query3: " . $ex->getMessage() . " etype:" . $_POST['etype']);
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
        if (empty($_POST['edate'])) {
            // Set the error flag as we do not want the process to run further
            $iserror   = true;
            // Set the error code
            $errorcode = "isBlankDate";
        } else {
            if (!preg_match("/^[0-9]{4}-[0-9]{2}-[0-9]{2}$/", $_POST['edate'])) {
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
        if (empty($_POST['eamount'])) {
            // Set the error flag as we do not want the process to run further
            $iserror   = true;
            // Set the error code
            $errorcode = "isBlankAmount";
        } else {
            if ($_POST['eamount'] >= 0) {
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
        if (!empty($_POST['ecomment'])) {
            $comment = $_POST['ecomment'];
        }
    }
    
    /* Seeing as there is no error then create the site entry */
    if ($iserror === false) {
        // Section of how the user gets adds 
        $query = "
UPDATE wugms.tbl_base_user_payments
   SET iduser = :userid,
       pdate = :pdate,
       firstName = :firstName,
       lastName = :lastName,
       irc_nick = :irc_nick,
       idpayment_type = :idpayment_type,
       idpayment_method = :idpayment_method,
       comment = :comment,
       amount = :amount
 WHERE idtbl_base_user_payments = :idtbl_base_user_payments;";
        
        $query_params = array(
            ':idtbl_base_user_payments' => $_POST['edit_payment_oem_id'],
            ':userid' => $_POST['euser'],
            ':pdate' => $_POST['edate'],
            ':firstName' => $firstName,
            ':lastName' => $lastName,
            ':irc_nick' => $irc_nick,
            ':idpayment_type' => $_POST['etype'],
            ':idpayment_method' => $_POST['emethod'],
            ':comment' => $comment,
            ':amount' => $_POST['eamount']
        );
        try {
            $stmt   = $db->prepare($query);
            $result = $stmt->execute($query_params);
            /* First log into the audit table that there was a change request and it met the requirements */
            wugmsaudit("MANCOM", "edit", "payments", "Payment entry edited; Changed by " . $_SESSION["irc_nick"] . " (" . $_SESSION["id"] . ") Original entry, User: " . $_POST['edit_payment_oem_firstName'] . " (" . $_POST['edit_payment_oem_irc_nick'] . ") " . $_POST['edit_payment_oem_lastName'] . ". Ptype: " . $_POST['edit_payment_oem_type'] . ". PMethod: " . $_POST['edit_payment_oem_method'] . ". Amount: " . $_POST['edit_payment_oem_amount'] . " Comment: " . $_POST['edit_payment_oem_comment']. " Updated entry, User: " . $firstName . " (" . $irc_nick . ") " . $lastName . " Etype: " . $_POST['etype'] . " EMethod: " . $_POST['emethod'] . " EAmount: " . $_POST['eamount'] . ". EComment: " . $_POST['ecomment']); 
			
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