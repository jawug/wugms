<?php
/* Start session */
session_start();
require($_SERVER['DOCUMENT_ROOT'] . '/auth/config.php');
require($_SERVER['DOCUMENT_ROOT'] . '/content/functions.php');
require($_SERVER['DOCUMENT_ROOT'] . '/content/branding.php');

/* variables*/
$edituser                = true;
$iserror                 = false;
$errorcode               = "";
$var_currentacc          = "";
$var_edit_dob            = "";
$var_edit_ircnick        = "";
$var_edit_ircnick_oem    = "";
$var_edit_name           = "";
$var_edit_phonenum       = "";
$var_edit_surname        = "";
$var_edit_username       = "";
$var_edit_username_oem   = "";
$var_edit_verifyusername = "";
$var_newpw               = "";
$var_verpw               = "";


if (isValueInRoleArray($_SESSION["roles"], "user") && !isValueInRoleArray($_SESSION["roles"], "readonly")) {
    
    
    if (!empty($_POST)) {
        /*
        edit_dob			1976-07-24
        edit_ircnick		Neji
        edit_name			Duncan
        edit_phonenum		+2700000000
        edit_surname		Ewan
        edit_username		systemlorddice@gmail.com
        edit_verifyusername	systemlorddice@gmail.com
        currentacc			
        newpw				
        verpw				
        */
        
        /* Check and validate the ircnick that was supplied */
        if ($iserror === false) {
            /* check if any of the irc_nick fields are blank */
            if (empty($_POST['ircnick']) || empty($_POST['ircnick_oem'])) {
                // If the ircnick is blank then fail
                // Set the error flag as we do not want the process to run further
                $iserror   = true;
                // Set the error code
                $errorcode = "isBlankIRCNick";
            } else {
                $var_edit_ircnick     = $_POST['ircnick'];
                $var_edit_ircnick_oem = $_POST['ircnick_oem'];
                // Check if the ircnick supplied is within the regex parameters
                if (!preg_match("/^[A-Za-z0-9_]+$/", $var_edit_ircnick) || !preg_match("/^[A-Za-z0-9_]+$/", $var_edit_ircnick_oem)) {
                    // Set the error flag as we do not want the process to run further
                    $iserror   = true;
                    // Set the error code
                    $errorcode = "isIRCNickNotCorrect";
                }
                if (!$iserror) {
                    /* Check and make sure that the ircnicks don't exist. */
                    /* SQL query */
                    $edit_ircnick_check_query        = "SELECT 1 FROM tbl_base_user WHERE upper(irc_nick) = upper(:ircnick) and not upper(irc_nick) = upper(:ircnick_oem);";
                    /* Parameters that will be used */
                    $edit_ircnick_check_query_params = array(
                        ':ircnick' => $var_edit_ircnick,
                        ':ircnick_oem' => $var_edit_ircnick_oem
                    );
                    /* Run the sql query */
                    $edit_ircnick_check_stmt         = $db->prepare($edit_ircnick_check_query);
                    if ($edit_ircnick_check_stmt->execute($edit_ircnick_check_query_params)) {
                        $edit_ircnick_check_row = $edit_ircnick_check_stmt->fetchAll();
                    }
                    /* Work with the results */
                    if ($edit_ircnick_check_row) {
                        $iserror   = true;
                        // Set the error code
                        $errorcode = "isIRCNickExists";
                    }
                }
            }
        }
        
        
        /* Check and validate the email that was supplied */
        if ($iserror === false) {
            if (empty($_POST['email'])) {
                // If the email is blank then fail
                die("Please enter a email.");
                // Set the error flag as we do not want the process to run further
                $iserror   = true;
                // Set the error code
                $errorcode = "isBlankEmail";
            } else {
                // Check if the email supplied is within the regex parameters
                if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
                    // Set the error flag as we do not want the process to run further
                    $iserror   = true;
                    // Set the error code
                    $errorcode = "isEmailNotCorrect";
                }
                if (!$iserror) {
                    // Check if the email supplied has not already been used
                    $query        = "SELECT 1 FROM tbl_base_user WHERE upper(username) = upper(:email) ";
                    $query_params = array(
                        ':email' => $_POST['email']
                    );
                    try {
                        $stmt   = $db->prepare($query);
                        $result = $stmt->execute($query_params);
                    }
                    catch (PDOException $ex) {
                        die("Failed to run query: " . $ex->getMessage());
                    }
                    $row = $stmt->fetch();
                    if ($row) {
                        // Set the error flag as we do not want the process to run further
                        $iserror   = true;
                        // Set the error code
                        $errorcode = "isEmailTaken";
                    }
                }
            }
        }
        ;
        
        
        if ($iserror === false) {
            // Section of how the user gets adds 
            $query = " 
    INSERT INTO tbl_base_user ( 
        username,
        irc_nick,
        firstName,
        lastName,
        password,
        salt,
        dob,
        phone_num,
        acc_val_key
    ) VALUES ( 
        :username, 
        :ircnick,
        :firstName,
        :lastName,
        :password, 
        :salt,
        :dob,
        :phone,
        :acc_val_key
    )
        ";
            
            // Security measures
            /*        $salt     = dechex(mt_rand(0, 2147483647)) . dechex(mt_rand(0, 2147483647));
            $password = hash('sha256', $_POST['password'] . $salt);
            for ($round = 0; $round < 65536; $round++) {
            $password = hash('sha256', $password . $salt);
            } */
            // Create register key
            $user_auth_salt = dechex(mt_rand(0, 2147483647)) . dechex(mt_rand(0, 2147483647));
            $user_auth_code = hash('sha256', date("Y-m-d h:i:sa") . $user_auth_salt);
            for ($round = 0; $round < 65536; $round++) {
                $user_auth_code = hash('sha256', $user_auth_code . $user_auth_salt);
            }
            
            $query_params = array(
                ':username' => $_POST['email'],
                ':ircnick' => $_POST['ircnick'],
                ':firstName' => $_POST['firstName'],
                ':lastName' => $_POST['lastName'],
                ':dob' => $_POST['dob'],
                ':phone' => $_POST['phone'],
                ':password' => 'this_is_a_password',
                ':salt' => 'this_is_salt',
                ':acc_val_key' => substr($user_auth_code, 0, 32)
            );
            try {
                $stmt   = $db->prepare($query);
                $result = $stmt->execute($query_params);
            }
            catch (PDOException $ex) {
                $edituser = false;
                die("Failed to run query: " . $ex->getMessage());
            }
        }
        
        
        if (!$iserror and $edituser) {
            /* Place code here that sends the email */
            $usrurl  = "http://" . $wugmsSiteURL . "/auth/resetpw.php?user=" . $_POST['email'] . "&verify=" . substr($user_auth_code, 0, 32);
            $to      = $_POST['email'];
            $subject = "WUGMS - user account has been created on your behalf";
            $message = "<html lang='en'>
                       <head>
                          <meta charset='utf-8'>
                          <meta http-equiv='X-UA-Compatible' content='IE=edge'>
                          <meta name='viewport' content='width=device-width, initial-scale=1'>
                          <meta name='description' content='Confirmation of your account is needed'>
                          <meta name='author' content='That_One_Guy'>
                          <title>WUGMS - Confirmation of your account is needed</title>
                       </head>
                       <body>
						  Dear " . $_POST['firstName'] . "  " . $_POST['lastName'] . ",
                          <p>Please note that a user account has been created for you on our system. Your login information is as follows</p>
						  <p>Username: " . $_POST['email'] . "</p>
						  <p>Default phone number: " . $_POST['phone'] . "</p>
						  Click this link in order to set your password and then login, <a href='" . $usrurl . "'>" . $usrurl . "</a>
                          <br />
                          <br />
                          <p>If you have any problems then please come and chat to us in IRC #jawug so that we can help you.</p>
                          <br />
                          <p>Keep on wugging!</p>
                       </body>
                    </html>";
            /* Header */
            $headers = "MIME-Version: 1.0" . "\r\n";
            $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
            // More headers
            $headers .= "From: no-reply@wugms.jawug.org.za" . "\r\n";
            $headers .= "Bcc: " . $wugmsadminemail . "\r\n";
            
            $retval = mail($to, $subject, $message, $headers);
            if ($retval == true) {
                /*        echo "woohoo";
                echo "<br>";
                echo $to;
                echo "<br>";
                echo $headers;
                echo "<br>";
                echo $subject;
                echo "<br>";		
                echo $message; */
            } else {
                // Show msg for failure
                echo "booooo";
            }
        }
    } else {
        $api_status_code     = 7;
        $response['status']  = $api_response_code[$api_status_code]['HTTP Response'];
        $response['message'] = $api_response_code[$api_status_code]['Message'];
        $response['data']    = "Missing data";
    }
} else {
    $api_status_code     = 3;
    $response['status']  = $api_response_code[$api_status_code]['HTTP Response'];
    $response['message'] = $api_response_code[$api_status_code]['Message'];
    $response['data']    = "User not logged on or user does not have required privleges to make changes";
}
/* Publish the results */
header('HTTP/1.1 ' . $response['status'] . ' ' . $http_response_code[$response['status']]);
header('Content-Type: application/json; charset=utf-8');
$json_response = json_encode($response);
echo $json_response;
?>