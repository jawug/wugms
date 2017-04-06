<?php
/*     Header information     */
/* Filename   : members.php   */
/* Version    : 1.0           */
/* Mod Date   : 2015/11/29    */
/* Parameters : -             */

/* Init reqs */
session_start();
require($_SERVER['DOCUMENT_ROOT'] . '/auth/config.php');
require($_SERVER['DOCUMENT_ROOT'] . '/content/functions.php');

/* Default params setting */
$member_param  = "";
$member_data   = '';
$user_data_row = "";

/* main query */
$user_data_query = "		
SELECT g.member,
       g.account_status,
       g.pdate 'last_payment',
       g.payment_type
  FROM (SELECT m.irc_nick 'member',
               if(
                  m.num_assigned_cnd > 0,
                  if(
                         d.pdate >
                            DATE_FORMAT(now() - INTERVAL 1 YEAR, '%Y-03-01')
                     AND d.pdate < DATE_FORMAT(now(), '%Y-03-01'),
                     'No payment required',
                     'Outstanding'),
                  'No payment required')
                  'account_status',
               ifnull(DATE_FORMAT(d.pdate, '%Y-%m-%d'), '') pdate,
               ifnull(d.idpayment_type, '-') 'payment_type'
          FROM (SELECT q.idtbl_base_user,
                       q.irc_nick,
                       q.max_sites,
                       q.used 'used_sites',
                       p.num_assigned_cnd
                  FROM (SELECT a.idtbl_base_user,
                               a.irc_nick,
                               a.max_sites,
                               ifnull(b.used, '0') 'used'
                          FROM (SELECT a.idtbl_base_user,
                                       a.irc_nick,
                                       a.max_sites,
                                       a.area
                                  FROM tbl_base_user a
                                 WHERE     a.idtbl_base_user <> 1
                                       AND a.idtbl_base_user <> 54) a
                               LEFT JOIN
                               (SELECT count(*) 'used', idSite_Owner
                                  FROM tbl_base_sites
                                GROUP BY idSite_Owner) b
                                  ON a.idtbl_base_user = b.idSite_Owner) q
                       LEFT JOIN
                       (SELECT count(*) 'num_assigned_cnd',
                               a.idSite_Owner 'owner',
                               c.irc_nick
                          FROM tbl_base_sites a,
                               tbl_ae_sites_rbs b,
                               tbl_base_user c
                         WHERE     b.ae_siteID = a.siteID
                               AND a.idSite_Owner = c.idtbl_base_user
                               AND c.idtbl_base_user <> 1
                               AND c.idtbl_base_user <> 54
                        GROUP BY a.idSite_Owner) p
                          ON q.idtbl_base_user = p.owner) m
               LEFT JOIN
               (SELECT b.idtbl_base_user_payments,
                       b.iduser,
                       b.pdate,
                       b.irc_nick,
                       b.idpayment_type,
                       b.comment
                  FROM tbl_base_user_payments b,
                       (SELECT b.iduser, max(b.pdate) 'last_pdate'
                          FROM tbl_base_user_payments b
                        GROUP BY b.iduser) x
                 WHERE     b.iduser = x.iduser
                       AND b.pdate = x.last_pdate
                       AND b.idpayment_type LIKE 'Membership') d
                  ON m.idtbl_base_user = d.iduser
        ORDER BY m.irc_nick) AS g
 WHERE g.account_status = 'Outstanding' OR g.payment_type = 'Membership';";

/*(g.account_status = 'Outstanding' OR g.payment_type = 'Membership') */
/* member='dfdfddf' */

/* Execute the SQL query */
$user_data_stmt = $db->prepare($user_data_query);
if ($user_data_stmt->execute()) {
    $user_data_row = $user_data_stmt->fetchAll();
}

/* Check is there are any returned datasets */
if ($user_data_row) {
	/* Works through the results and get them into an array */	
    foreach ($user_data_row as $key => $value) {
        $data[] = array(
            'member' => $value['member'],
            'account_status' => $value["account_status"],
            'last_payment' => $value["last_payment"],
            'payment_type' => $value["payment_type"]
        );
    }
	/* Build a response */
    $api_status_code     = 1;
    $response['status']  = $api_response_code[$api_status_code]['HTTP Response'];
    $response['message'] = $api_response_code[$api_status_code]['Message'] . " " . date("Y-m-d H:i:s");
    $response['data']    = $data;

} else {
	/* There are no datasets returned */
    /* Build a response */
    $api_status_code     = 8;
    $response['status']  = $api_response_code[$api_status_code]['HTTP Response'];
    $response['message'] = $api_response_code[$api_status_code]['Message'] . " " . date("Y-m-d H:i:s");
	$response['data']    = 'No data';
    
}

/* Build the header */
header('HTTP/1.1 ' . $response['status'] . ' ' . $http_response_code[$response['status']]);
header('Content-Type: application/json; charset=utf-8');
$json_response = json_encode($response, JSON_NUMERIC_CHECK);
/* Deliver results */
echo $json_response;
?>