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
$values   = "";


if (!empty($_POST) && (isValueInRoleArray($_SESSION["roles"], "mancom"))) {
    
    
$data = json_decode(stripslashes($_POST['data']));

  // here i would like use foreach:

  foreach($data as $d){
 //    echo $d;
	 $values .= "(" . $d . ",'mancom'),";
	 
//	echo "<br>";
  }
//substr($values, 0, -1);
  $sql_values = rtrim($values, ",");
//  echo $sql_values;
    
    /* Seeing as there is no error then create the site entry */
    if ($iserror === false) {
		/* Clear out all the current mancom members except for the current mancom member who is doing this */
		$wugms_mancom_cleanup_query = "DELETE FROM tbl_ae_user_rolls WHERE username_id <> :logged_in_user AND roll_id = 'mancom';;";

		$wugms_mancom_cleanup_query_params = array(
            ':logged_in_user' => $_SESSION["id"]
        ); 
		
		$wugms_mancom_cleanup_stmt         = $db->prepare($wugms_mancom_cleanup_query);
        if ($wugms_mancom_cleanup_stmt->execute($wugms_mancom_cleanup_query_params)) {
/*            $wugms_mancom_cleanup_row = $wugms_mancom_cleanup_stmt->fetchAll();*/
		//	echo "users cleaned out";
        }
		
		
		
		
        // Section of how the user gets adds 
        $query = " INSERT INTO tbl_ae_user_rolls (username_id, roll_id) VALUES " . $sql_values . ";";
		 

        try {
            $stmt   = $db->prepare($query);
            $result = $stmt->execute();
            // First log into the audit table that there was a change request and it met the requirements 
            wugmsaudit("MANCOM", "add", "user", "Users added to the role of MANCOM; Entered by " . $_SESSION["irc_nick"] . " (" . $_SESSION["id"] . ")");
        }
        catch (PDOException $ex) {
            $newuser = false;
            echo "<span class=\"alert alert-danger\" >Failed to update the MANCOM members entry. Reason " . $ex->getMessage() . "</span><br><br>";
        } 
    } else {
        echo "<span class=\"alert alert-danger\" >Failed to update the MANCOM members entry. Reason " . $errorcode . "</span><br><br>";
    }
} else {
    echo "<span class=\"alert alert-danger\" >Failed to update the MANCOM members entry. Reason DATA_NOT_POSTED</span><br><br>";
}

?>