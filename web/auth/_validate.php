<?php
/* Start session */
session_start();

/* Set vars */
$isError = false;

/* Load the DB connection */
require($_SERVER['DOCUMENT_ROOT'] . "/auth/config.php");

/* Check if there is a loaded username*/
if (!isset($_SESSION["id"])) {
    $isUserName = false;
} else {
    $isUserName = true;
}

/* Check if the session ID matches the user name based on our records. */
if ($isUserName) {
    $query        = "SELECT * FROM tbl_base_user_audit WHERE username_id = :username_id and session_id = :sessionid;";
    $query_params = array(
        ':username_id' => $_SESSION["id"],
        ':sessionid' => session_id()
    );
    try {
        $stmt   = $db->prepare($query);
        $result = $stmt->execute($query_params);
    }
    catch (PDOException $ex) {
        die("Failed to run query: " . $ex->getMessage());
        $isError = true;
    }
    if (!$result) {
        /* Redirect to the user to a page that tells them to login*/
        header("Location: /auth/noaccess.php");
        die("Redirecting to: /auth/noaccess.php");
    }
} else {
    header("Location: /auth/noaccess.php");
    die("Redirecting to: /auth/noaccess.php");
}

/* Get the user's access and details and set the session vars */
if ($isUserName) {
    $uquery        = "SELECT * FROM tbl_base_user WHERE idtbl_base_user = :username_id;";
    $uquery_params = array(
        ':username_id' => $_SESSION["id"]
    );
    //try{ 
    $ustmt         = $db->prepare($uquery);
    //		$uresult = $ustmt->execute($uquery_params); 
    //}
    if ($ustmt->execute($uquery_params)) {
        $uresult = $ustmt->fetch();
    }
    
    if ($uresult) {
	/* Get the session varibles */
        $_SESSION["irc_nick"]          = $uresult["irc_nick"];
        $_SESSION["firstName"]         = $uresult["firstName"];
        $_SESSION["lastName"]          = $uresult["lastName"];
        $_SESSION["max_sites"]         = $uresult["max_sites"];
        $_SESSION["mancom_account_nr"] = $uresult["mancom_account_nr"];
        $_SESSION["acc_status"]        = $uresult["acc_status"];
        $_SESSION["phone_num"]         = $uresult["phone_num"];
        $_SESSION["dob"]               = $uresult["dob"];
        $_SESSION["id"]                = $uresult["idtbl_base_user"];
        $_SESSION["join_date"]         = $uresult["cdate"];
        
		/* Determine which roles the user has assigned to them */        
		$rquery        = "SELECT a.roll_id, b.comment FROM tbl_ae_user_rolls a, tbl_base_user_rolls b WHERE username_id = :username_id and a.roll_id = b.roll;";
		$rquery_params = array(
			':username_id' => $_SESSION["id"]
		);
		/* Run the query */
		$rstmt         = $db->prepare($rquery);
		/* Execute the query to get the list of user roles */
		if ($rstmt->execute($rquery_params)) {
			$rresult = $rstmt->fetchAll();
		}
		if ($rresult) {
			$_SESSION["roles"]         = $rresult;  
		}
		
		/* Determine how many sites the user has left */
		$squery        = "Select count(*)'used' from tbl_base_sites where idSite_Owner = :username_id; ;";
		$squery_params = array(
        ':username_id' => $_SESSION["id"]
    );
    //try{ 
    $sstmt         = $db->prepare($squery);
    //		$uresult = $ustmt->execute($uquery_params); 
    //}
    if ($sstmt->execute($squery_params)) {
        $sresult = $sstmt->fetch();
    }
    if ($sresult) {
	$_SESSION["used_sites"] = $sresult["used"];
	$_SESSION["aval_sites"] = $_SESSION["max_sites"] - $_SESSION["used_sites"];
	}
    } else {
        header("Location: /auth/noaccess.php");
        die("Redirecting to: /auth/noaccess.php");
    }
}

/* Check the users account status */
/*
So wugms accounts can have only one of the following statues
active - User has validated their email address and has access
pending_validation - the user still needs to validate their email address
disabled - added this because I am not sure why
banned - Yeah... someone pissed someone and did bad things
*/

/* Pending */
if ($_SESSION["acc_status"] == "pending") {
    header("Location: /auth/pending.php");
    die("Redirecting to: /auth/pending.php");
}
/* disabled */
if ($_SESSION["acc_status"] == "disabled") {
    header("Location: /auth/disabled.php");
    die("Redirecting to: /auth/disabled.php");
}
/* banned */
if ($_SESSION["acc_status"] == "banned") {
    header("Location: /auth/banned.php");
    die("Redirecting to: /auth/banned.php");
}

?>