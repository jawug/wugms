<?php

/* Include the validation checker */
include($_SERVER['DOCUMENT_ROOT'] . '/auth/validate.php');
/* This is required for custom branding */
require($_SERVER['DOCUMENT_ROOT'] . '/content/branding.php');
require($_SERVER['DOCUMENT_ROOT'] . '/content/functions.php');

    /* Default output if you're not an admin */
    $outp = "[{}]";

if (isset($_SESSION["id"])) {
    
    $wugms_table_user_sites_row = '';
    $outp                           = '';
    
    $wugms_table_user_sites_query = "
		SELECT  a.siteID,
				                   a.Name,
				                   a.longitude,
				                   a.latitude,
				                   a.height,
				                   a.CDate,
								   a.MDate,
								   a.suburb
				              FROM tbl_base_sites a
				             WHERE idSite_Owner = :user_id
				             order by a.Name;";
    
        /* Assign the parameters as per the selected level */
/*        $wugms_table_user_sites_query_params = array(
            ':user_id' => $_SESSION["id"]
        ); */
    if (isset($_SESSION["id"])) {
        $wugms_table_user_sites_params = array(
            ':user_id' => $_SESSION["id"]
        );
        $wugms_table_user_sites_stmt         = $db->prepare($wugms_table_user_sites_query);
        if ($wugms_table_user_sites_stmt->execute($wugms_table_user_sites_params)) {
            $wugms_table_user_sites_row = $wugms_table_user_sites_stmt->fetchAll();
        }
    }	
    
    // Check if the site_name supplied has not already been used
    
    
    ;
    
    if ($wugms_table_user_sites_row) {
        $outp = "[";
        foreach ($wugms_table_user_sites_row as $x) {
            
            if ($outp != "[") {
                $outp .= ",";
            }
            $outp .= '{"siteID":"' . $x["siteID"] . '",';
			$outp .= '"Name":"' . $x["Name"] . '",';
			$outp .= '"longitude":"' . $x["longitude"] . '",';
			$outp .= '"latitude":"' . $x["latitude"] . '",';
			$outp .= '"height":"' . $x["height"] . '",';
			$outp .= '"CDate":"' . $x["CDate"] . '",';
			$outp .= '"MDate":"' . $x["MDate"] . '",';
            $outp .= '"suburb":"' . $x["suburb"] . '"}';
        }
        $outp .= "]";
    }

}

/* echo the result(s) */
echo ($outp);
?>