<?php
/* Start a session */
session_start();

/* Load required function files */
require($_SERVER['DOCUMENT_ROOT'].'/auth/config.php');
require($_SERVER['DOCUMENT_ROOT'].'/content/functions.php');

if (isset($_SESSION["id"])) {
    /* Write to the db in mark that the client has logged out */
    /* see if the user is logged in */
    $query        = " SELECT 1 FROM tbl_base_user_audit WHERE username_id = :id and session_id = :sessionid ";
    $query_params = array(
        ':id' => $_SESSION["id"],
        ':sessionid' => session_id()
    );
    
    try {
        $stmt   = $db->prepare($query);
        $result = $stmt->execute($query_params);
    }
    catch (PDOException $ex) {
        die("Failed to run query 1: " . $ex->getMessage());
    }
    $can_log_out = false;
    $row         = $stmt->fetch();
	/* If there is a row returned that matches the username and sessionID then set the flag to update the db */
    if ($row) {
        $can_log_out = true;
    }
    /* Update the DB */
    if ($can_log_out) {
		/* First log into the audit table that there was a change request and it met the requirements */
		wugmsaudit("user", "auth", "logout", "User logged out");
        
    }
} else {
    /* do nothing */
}
 
/* null all vars in the session */
$_SESSION = array();
/* Clear the cookie */
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000, $params["path"], $params["domain"], $params["secure"], $params["httponly"]);
}
/* destroy the session */
session_destroy();
/* Once we're done then we redirect to the home page */
header("Location: /");
die("Redirecting to: /");

?>