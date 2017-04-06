<?php

/* Include the validation checker */
include($_SERVER['DOCUMENT_ROOT'] . '/auth/validate.php');
/* This is required for custom branding */
require($_SERVER['DOCUMENT_ROOT'] . '/content/branding.php');
require($_SERVER['DOCUMENT_ROOT'] . '/content/functions.php');

if (isValueInRoleArray($_SESSION["roles"], "mancom")) {
    
    $wugms_table_user_accounts_row = '';
    $outp                           = '';
    
    $wugms_table_user_accounts_query = "
SELECT m.username,
       m.irc_nick,
       m.firstName,
       m.lastName,
       m.mancom_account_nr,
       if( m.num_assigned_cnd > 0, if( d.pdate > DATE_FORMAT(now() - INTERVAL 1 YEAR, '%Y-03-01')
                                   AND d.pdate < DATE_FORMAT(now(), '%Y-03-01'), 'No payment required', 'Outstanding'),
          'No payment required') 'acc_status',
       ifnull(DATE_FORMAT(d.pdate, '%Y-%m-%d'), 'N/P') pdate,
       ifnull(d.idpayment_type,'N/A') 'payment_type',
       ifnull(d.idpayment_method,'N/A')'payment_method',
       ifnull(d.amount,0)'amount'
  FROM (SELECT q.idtbl_base_user,
               q.username,
               q.irc_nick,
               q.firstName,
               q.lastName,
               q.max_sites,
               q.mancom_account_nr,
               q.acc_status,
               q.phone_num,
               q.used 'used_sites',
               p.num_assigned_cnd
          FROM (SELECT a.idtbl_base_user,
                       a.username,
                       a.irc_nick,
                       a.firstName,
                       a.lastName,
                       a.max_sites,
                       ifnull(a.mancom_account_nr, 'N/A') 'mancom_account_nr',
                       a.acc_status,
                       a.phone_num,
                       ifnull(b.used, '0') 'used'
                  FROM (SELECT a.idtbl_base_user,
                               a.username,
                               a.irc_nick,
                               a.firstName,
                               a.lastName,
                               a.max_sites,
                               a.mancom_account_nr,
                               a.acc_status,
                               a.phone_num,
                               a.area
                          FROM tbl_base_user a
                         WHERE     a.idtbl_base_user <> 1
                               AND a.idtbl_base_user <> 54) a
                       LEFT JOIN (SELECT count(*) 'used', idSite_Owner
                                    FROM tbl_base_sites
                                  GROUP BY idSite_Owner) b
                          ON a.idtbl_base_user = b.idSite_Owner) q
               LEFT JOIN
               (SELECT count(*) 'num_assigned_cnd',
                       a.idSite_Owner 'owner',
                       c.irc_nick
                  FROM tbl_base_sites a, tbl_ae_sites_rbs b, tbl_base_user c
                 WHERE     b.ae_siteID = a.siteID
                       AND a.idSite_Owner = c.idtbl_base_user
                       AND c.idtbl_base_user <> 1
                       AND c.idtbl_base_user <> 54
                GROUP BY a.idSite_Owner) p
                  ON q.idtbl_base_user = p.owner) m
       LEFT JOIN (SELECT b.idtbl_base_user_payments,
                         b.iduser,
                         b.pdate,
                         b.firstName,
                         b.lastName,
                         b.irc_nick,
                         b.idpayment_type,
                         b.idpayment_method,
                         b.comment,
                         b.amount
                    FROM tbl_base_user_payments b,
                         (SELECT b.iduser, max(b.pdate) 'last_pdate'
                            FROM tbl_base_user_payments b
                          GROUP BY b.iduser) x
                   WHERE b.iduser = x.iduser AND b.pdate = x.last_pdate
				   and b.idpayment_type like 'Membership') d
          ON m.idtbl_base_user = d.iduser
          order by m.irc_nick;";
    
    
    
    if (isset($_SESSION["id"])) {
        /* Assign the parameters as per the selected level */
/*        $wugms_table_user_accounts_query_params = array(
            ':user_id' => $_SESSION["id"]
        ); */
        $wugms_table_user_accounts_stmt         = $db->prepare($wugms_table_user_accounts_query);
        if ($wugms_table_user_accounts_stmt->execute()) {
            $wugms_table_user_accounts_row = $wugms_table_user_accounts_stmt->fetchAll();
        }
    }
    
    // Check if the site_name supplied has not already been used
    
    
    ;
    
    if ($wugms_table_user_accounts_row) {
        $outp = "[";
        foreach ($wugms_table_user_accounts_row as $x) {
            
            if ($outp != "[") {
                $outp .= ",";
            }
            $outp .= '{"username":"' . $x["username"] . '",';
            $outp .= '"irc_nick":"' . $x["irc_nick"] . '",';
            $outp .= '"firstName":"' . $x["firstName"] . '",';
            $outp .= '"lastName":"' . $x["lastName"] . '",';
			$outp .= '"mancom_account_nr":"' . $x["mancom_account_nr"] . '",';
            $outp .= '"acc_status":"' . $x["acc_status"] . '",';
            $outp .= '"pdate":"' . $x["pdate"] . '",';
            $outp .= '"payment_type":"' . $x["payment_type"] . '",';
            $outp .= '"payment_method":"' . $x["payment_method"] . '",';
            $outp .= '"amount":"' . $x["amount"] . '"}';

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