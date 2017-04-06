<?php

/* Include the validation checker */
include($_SERVER['DOCUMENT_ROOT'] . '/auth/validate.php');
/* This is required for custom branding */
require($_SERVER['DOCUMENT_ROOT'] . '/content/branding.php');
require($_SERVER['DOCUMENT_ROOT'] . '/content/functions.php');

    /* Default output if you're not an admin */
    $outp = "[{}]";

if (isset($_SESSION["id"])) {
    
    $wugms_table_user_payments_row = '';
    $outp                           = '';
    
    $wugms_table_user_payments_query = "
		SELECT @row_number := @row_number + 1 AS row_number,
       a.pdate,
       a.idpayment_type,
       a.idpayment_method,
       a.comment,
       a.amount
  FROM tbl_base_user_payments a, (SELECT @row_number := 0) AS t
 WHERE a.iduser = :user_id
ORDER BY a.pdate;";
    
        /* Assign the parameters as per the selected level */
/*        $wugms_table_user_payments_query_params = array(
            ':user_id' => $_SESSION["id"]
        ); */
    if (isset($_SESSION["id"])) {
        $wugms_table_user_payments_params = array(
            ':user_id' => $_SESSION["id"]
        );
        $wugms_table_user_payments_stmt         = $db->prepare($wugms_table_user_payments_query);
        if ($wugms_table_user_payments_stmt->execute($wugms_table_user_payments_params)) {
            $wugms_table_user_payments_row = $wugms_table_user_payments_stmt->fetchAll();
        }
    }	
    
    // Check if the site_name supplied has not already been used
    
    
    ;
    
    if ($wugms_table_user_payments_row) {
        $outp = "[";
        foreach ($wugms_table_user_payments_row as $x) {
            
            if ($outp != "[") {
                $outp .= ",";
            }
            $outp .= '{"row_number":"' . $x["row_number"] . '",';
			$outp .= '"pdate":"' . $x["pdate"] . '",';
			$outp .= '"idpayment_type":"' . $x["idpayment_type"] . '",';
			$outp .= '"idpayment_method":"' . $x["idpayment_method"] . '",';
			$outp .= '"comment":"' . $x["comment"] . '",';
            $outp .= '"amount":"' . $x["amount"] . '"}';
        }
        $outp .= "]";
    }

}

/* echo the result(s) */
echo ($outp);
?>