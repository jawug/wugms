<?php
/* Start session */
/* No validation will be done because this is a public page */
/* session_start(); */
/* This is required for custom branding */
/* require($_SERVER['DOCUMENT_ROOT'].'/content/branding.php'); */
/* This is required for custom functions */
 require($_SERVER['DOCUMENT_ROOT'].'/content/functions.php'); 
 require($_SERVER['DOCUMENT_ROOT'].'/auth/config.php'); 
	$end_date = time();
	//('Y-m-d H:i:s')
//	echo $end_date;
//	date_create
	echo "<br />";
//$today_time = strtotime($today);
//$expire_time = strtotime($expire);	
	
	/* hours */
	$start_date = date("Y-m-d H:m:s", strtotime('-12 hours', time()));
	$test = strtotime($start_date);
	if ($end_date>$test) {
		echo "<b>HOURS</b>";
		echo "<br />";
		echo "end date";
		echo "<br />";
		echo date("Y-m-d H:m:s", $end_date);
		echo "<br />";
		echo "start date";
		echo "<br />";
		echo $start_date;
		echo "<br />";
		echo "<br />";
		echo "<br />";
	} else {
		echo "no ";
		echo "<br />";
	} 
	/* days */
	$start_date = date("Y-m-d H:m:s", strtotime('-12 days', time()));
	$test = strtotime($start_date);
	if ($end_date>$test) {
		echo "<b>DAYS</b>";
		echo "<br />";		
		echo "end date";
		echo "<br />";
		echo date("Y-m-d H:m:s", $end_date);
		echo "<br />";
		echo "start date";
		echo "<br />";
		echo $start_date;
		echo "<br />";
		echo "<br />";
		echo "<br />";
	} else {
		echo "no ";
		echo "<br />";
	}	
	
	/* weeks */
	$start_date = date("Y-m-d H:m:s", strtotime('-12 weeks', time()));
	$test = strtotime($start_date);
	if ($end_date>$test) {
		echo "<b>WEEKS</b>";
		echo "<br />";		
		echo "end date";
		echo "<br />";
		echo date("Y-m-d H:m:s", $end_date);
		echo "<br />";
		echo "start date";
		echo "<br />";
		echo $start_date;
		echo "<br />";		
	} else {
		echo "no ";
		echo "<br />";
	}		
	echo "<br />";
	echo "<br />";
	echo "<br />";
	echo "<br />";
	
	
	
//function StartEndDateCompare($sdate, $edate, $interval)	
$qwerty = StartEndDateCompare("2015-09-07 19:08:39", 0, "day");

foreach ($qwerty as $item) {
	echo  $item;
echo "<br />";

	}

echo $qwerty['start'];
echo "<br />";	
echo $qwerty['end'];
echo "<br />";	
print_r($qwerty);
	
//echo $qwerty[0];
echo "<br />";
//echo $qwerty[1];
echo "<br />";
//echo date_diff($datetime1, $end_date);

$user_rbs_row = '';
/*if (isset($_SESSION["id"])) {*/
    $user_rbs_query = "
  SELECT device_make,
       device_model,
       os_ver,
       device_name,
       sitename,
       b.sn
  FROM (SELECT sn
          FROM (SELECT b.ae_Serial_Number 'sn'
                  FROM tbl_ae_sites_rbs b, tbl_base_sites a, tbl_base_sites c
                 WHERE     a.idSite_Owner = :user_id
                       AND b.ae_siteID = a.siteID
                       AND a.idSite_Owner = c.idSite_Owner) a
        UNION
        SELECT sn
          FROM (SELECT d.Serial_Number 'sn'
                  FROM tbl_base_rb_routerboard d
                 WHERE idSite_Owner = :user_id) b) AS a
       INNER JOIN (SELECT 'Mikrotik' AS 'device_make',
                          a.Board_model 'device_model',
                          a.OS_Version 'os_ver',
                          a.RB_identity 'device_name',
                          b.Name 'sitename',
                          a.Serial_Number 'sn'
                     FROM tbl_base_rb_routerboard a, tbl_base_sites b
                    WHERE a.siteID = b.siteID) AS b
          ON a.sn = b.sn
ORDER BY b.SiteName, b.device_name;";
    /* Set the parameters */
    $user_rbs_query_params = array(
        ':user_id' => 23
    );
    /* Excute the sql */
    $user_rbs_stmt = $db->prepare($user_rbs_query);
    if ($user_rbs_stmt->execute($user_rbs_query_params)) {
        $user_rbs_row = $user_rbs_stmt->fetchAll();
    }
	/* Process the results */
   foreach ($user_rbs_row as $key => $value) {
	echo "<option value='" . $value['sn'] . "___" . $value["sitename"] . "___" . $value["device_name"] . "___" . $value["device_model"] . "'>" . $value["sitename"] . " -> " . $value["device_name"] . "</option>";
   } 
/*}*/

?>