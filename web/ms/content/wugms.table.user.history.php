<?php
/* Include the validation checker */
include($_SERVER['DOCUMENT_ROOT'] . '/auth/validate.php');
/* This is required for custom branding */
require($_SERVER['DOCUMENT_ROOT'] . '/content/branding.php');
require($_SERVER['DOCUMENT_ROOT'] . '/content/functions.php');

/* Set the default output */
$outp = "[{}]";

/* Check if there is a loaded id*/
if (!isset($_SESSION["id"])) {
    $isUserName = false;
} else {
    $isUserName = true;
}

/* If there is a id hen run the query */
if ($isUserName) {
    /* Setup the SQL query */
    $uquery = "
	SELECT a.session_date 'adate',
       a.user_ip 'ip_address',
       a.level,
       a.area,
       a.action,
       trim(SUBSTRING(a.msg,1,LOCATE('UID', a.msg)-2))'msg',
       a.browser_agent 'browser_agent'
  FROM tbl_base_user_audit a
 WHERE username_id = :username_id
ORDER BY a.session_date DESC
 LIMIT 100;";
    /* Set up the parameters for teh query */
	$uquery_params = array(
		':username_id' => $_SESSION["id"]	
	);
	$ustmt   = $db->prepare($uquery);
    /* Execute the query */
    if ($ustmt->execute($uquery_params)) {
        $uresult = $ustmt->fetchAll(PDO::FETCH_ASSOC);
    }
    if ($uresult) {
        $outp = "[";
        foreach ($uresult as $x) {
            
            if ($outp != "[") {
                $outp .= ",";
            }
            $outp .= '{"adate":"' . $x["adate"] . '",';
            $outp .= '"ip_address":"' . $x["ip_address"] . '",';
   			$outp .= '"level":"' . $x["level"] . '",';
			$outp .= '"area":"' . $x["area"] . '",';
			$outp .= '"action":"' . $x["action"] . '",';
			$outp .= '"msg":"' . $x["msg"] . '",';
            $outp .= '"browser_agent":"' . $x["browser_agent"] . '"}';
        }
        $outp .= "]";
    }
}
echo $outp;

?>