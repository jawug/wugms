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

/*
confirmdelete	on
damount	360
ddate	2013-01-31
delete_paymentid	4
dmethod	EFT
dtype	Membership
*/


if (!empty($_POST) && (isValueInRoleArray($_SESSION["roles"], "mancom"))) {
    
    /* Check and validate the user ID that the payment entry must be allocated to */
    if (empty($_POST['delete_paymentid'])) {

        $iserror   = true;
        $errorcode = "isBlankPaymentID";
    } else {
        $snquery        = "SELECT 1 FROM tbl_base_user_payments WHERE idtbl_base_user_payments = :check_id ;";
        $snquery_params = array(
            ':check_id' => $_POST['delete_paymentid']
        );
        try {
            $snstmt   = $db->prepare($snquery);
            $snresult = $snstmt->execute($snquery_params);
        }
        catch (PDOException $ex) {
            die("Failed to run query1: " . $ex->getMessage() . " delete_paymentid:" . $_POST['delete_paymentid']);
        }
        $snrow = $snstmt->fetch();
        if ($snrow) {
        } else {
            $iserror   = true;
            $errorcode = "isUnknownPaymentID";
        }
    }
    
    /* Check and validate the payment method */
    if ($iserror === false) {
        if (empty($_POST['dmethod'])) {
            // Set the error flag as we do not want the process to run further
            $iserror   = true;
            // Set the error code
            $errorcode = "isBlankMethod";
            // If the dmethod is blank then fail
        } else {
            
            // Check if the dmethod id supplied does exist
            $snquery        = "SELECT 1 FROM tbl_base_payment_method WHERE payment_method = :check_id ;";
            $snquery_params = array(
                ':check_id' => $_POST['dmethod']
            );
            try {
                $snstmt   = $db->prepare($snquery);
                $snresult = $snstmt->execute($snquery_params);
            }
            catch (PDOException $ex) {
                die("Failed to run query2: " . $ex->getMessage() . " dmethod:" . $_POST['dmethod']);
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
        if (empty($_POST['dtype'])) {
            // Set the error flag as we do not want the process to run further
            $iserror   = true;
            // Set the error code
            $errorcode = "isBlankType";
            // If the dtype is blank then fail
        } else {
            
            // Check if the dtype id supplied does exist
            $snquery        = "SELECT 1 FROM tbl_base_payment_type WHERE payment_type = :check_id ;";
            $snquery_params = array(
                ':check_id' => $_POST['dtype']
            );
            try {
                $snstmt   = $db->prepare($snquery);
                $snresult = $snstmt->execute($snquery_params);
            }
            catch (PDOException $ex) {
                die("Failed to run query3: " . $ex->getMessage() . " dtype:" . $_POST['dtype']);
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
        if (empty($_POST['ddate'])) {
            // Set the error flag as we do not want the process to run further
            $iserror   = true;
            // Set the error code
            $errorcode = "isBlankDate";
        } else {
            if (!preg_match("/^[0-9]{4}-[0-9]{2}-[0-9]{2}$/", $_POST['ddate'])) {
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

    /* Check that the confirmation was sent */
    if ($iserror === false) {
        if (empty($_POST['confirmdelete'])) {
            // Set the error flag as we do not want the process to run further
            $iserror   = true;
            // Set the error code
            $errorcode = "isBlankDate";
        } else {
            if ($_POST['confirmdelete'] === 'on') {
				//
            } else {
                // Set the error flag as we do not want the process to run further
                $iserror   = true;
                // Set the error code
                $errorcode = "isWrongthing";
            }
        }
    }
    
    /* Seeing as there is no error then create the site entry */
    if ($iserror === false) {
        // Section of how the user gets adds 
        $query = "
			DELETE FROM wugms.tbl_base_user_payments
 			 WHERE     idtbl_base_user_payments = :delete_paymentid
       			AND pdate = :ddate
       			AND idpayment_type = :dtype
       			AND idpayment_method = :dmethod;";
		 
        $query_params = array(
            ':delete_paymentid' => $_POST['delete_paymentid'],
            ':ddate'            => $_POST['ddate'],
            ':dtype'            => $_POST['dtype'],
            ':dmethod'          => $_POST['dmethod']
        );
        try {
            $stmt   = $db->prepare($query);
            $result = $stmt->execute($query_params);
            /* First log into the audit table that there was a change request and it met the requirements */
            wugmsaudit("MANCOM", "delete", "payments", "Payment entry deleted; Deleted by " . $_SESSION["irc_nick"] . " (" . $_SESSION["id"] . ") For User: " . $_POST['duser'] . ". DDate: " . $_POST['ddate'] . ". DType: " . $_POST['dtype'] . ". DMethod: " . $_POST['dmethod'] . ". DAmount: " . $_POST['damount'] . ". ID: " . $_POST['delete_paymentid']);
            //echo "<span class=\"alert alert-success\" >Your site has been created.</span><br><br>";
        }
        catch (PDOException $ex) {
            $newuser = false;
            echo "<span class=\"alert alert-danger\" >Failed to delete payment entry. Reason " . $ex->getMessage() . "</span><br><br>";
        }
    } else {
        echo "<span class=\"alert alert-danger\" >Failed to delete payment entry. Reason " . $errorcode . "</span><br><br>";
    }
} else {
    echo "<span class=\"alert alert-danger\" >Failed to delete payment entry. Reason DATA_NOT_POSTED</span><br><br>";
}

?>