<?php

/* Include the validation checker */
include($_SERVER['DOCUMENT_ROOT'] . '/auth/validate.php');
/* This is required for custom branding */
require($_SERVER['DOCUMENT_ROOT'] . '/content/branding.php');
require($_SERVER['DOCUMENT_ROOT'] . '/content/functions.php');

if (isValueInRoleArray($_SESSION["roles"], "mancom")) {

$inttimelen = '0';
if (isset($_GET['intlen'])) {
	$timelen = $_GET['intlen'];
} else {
	$timelen = '90'; 
}

/* <td ><button id='editsitebtn" . $row['siteID'] . "' type='button' data-toggle='modal' data-target='#EditSiteModal' class='btn btn-primary'>Edit</button> */
/* <button id=''deletesitebtn',idtbl_base_user_payments,''' type=''button'' data-toggle=''modal'' data-target=''#DeleteSiteModal'' class=''btn btn-danger''>Delete</button> */
/*   <button id=''editsitebtn',idtbl_base_user_payments,''' type=''button'' data-toggle=''modal'' data-target=''#EditPaymentModal'' class=''btn btn-primary''>Edit</button>*/
    $wugms_table_user_accounts_row = '';
    $outp                           = '';
    
    $wugms_table_user_accounts_query = "
SELECT DATE_FORMAT(pdate, '%Y-%m-%d') 'pdate',
       firstName,
       lastName,
       irc_nick,
       idpayment_type,
       idpayment_method,
       comment,
       amount,
	   iduser,
/*	   concat('<button id=''editpaymentbtn',idtbl_base_user_payments,''' type=''button'' data-toggle=''modal'' data-target=''#EditPaymentModal'' class=''btn btn-primary''>Edit</button> <button id=''deletepaymentbtn',idtbl_base_user_payments,''' type=''button'' data-toggle=''modal'' data-target=''#DeletePaymentModal'' class=''btn btn-danger''>Delete</button>') 'action'*/
       idtbl_base_user_payments 'id'
  FROM wugms.tbl_base_user_payments
 WHERE pdate > now() - INTERVAL :interval_length DAY
 order by pdate desc;";
    

        /* Assign the parameters as per the selected level */
        $wugms_table_user_accounts_query_params = array(
            ':interval_length' => $timelen
        ); 
        $wugms_table_user_accounts_stmt         = $db->prepare($wugms_table_user_accounts_query);
        if ($wugms_table_user_accounts_stmt->execute($wugms_table_user_accounts_query_params)) {
            $wugms_table_user_accounts_row = $wugms_table_user_accounts_stmt->fetchAll();
        }

    
    // Check if the site_name supplied has not already been used
        
    ;
    
    if ($wugms_table_user_accounts_row) {
        $outp = "[";
        foreach ($wugms_table_user_accounts_row as $x) {
            
            if ($outp != "[") {
                $outp .= ",";
            }
            $outp .= '{"pdate":"' . $x["pdate"] . '",';
            $outp .= '"irc_nick":"' . $x["irc_nick"] . '",';
            $outp .= '"firstName":"' . $x["firstName"] . '",';
            $outp .= '"lastName":"' . $x["lastName"] . '",';
			$outp .= '"payment_type":"' . $x["idpayment_type"] . '",';
            $outp .= '"payment_method":"' . $x["idpayment_method"] . '",';
            $outp .= '"comment":"' . $x["comment"] . '",';
			$outp .= '"amount":"' . $x["amount"] . '",';
			$outp .= '"iduser":"' . $x["iduser"] . '",';
            $outp .= '"id":"' . $x["id"] . '"}';

        }
        $outp .= "]";
    } else {
        $outp = "[{}]";
    }

} else {
    /* Default output if you're not an admin */
    $outp = "[{}]";
}
/* echo the result(s) */
echo ($outp);
?>