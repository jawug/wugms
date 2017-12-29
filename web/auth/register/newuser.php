<?php
require("../auth/config.php");
require($_SERVER['DOCUMENT_ROOT'].'/content/branding.php');

/* variables*/
$baseurl   = "http://wugms.bwcsystem.net:20080";
$newuser   = true;
$iserror   = false;
$errorcode = "";

if (!empty($_POST)) {
    
    
    /* Check and validate the password that was supplied */
    if (empty($_POST['password'])) {
        // If the password is blank then fail
        die("Please enter a password.");
        // Set the error flag as we do not want the process to run further
        $iserror   = true;
        // Set the error code
        $errorcode = "isBlankPassword";
    } else {
        // Check if the password supplied fits into regex ^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?!.*\s).{6,20}$
        if (!preg_match("/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?!.*\s).{6,20}$/i", $_POST['password'])) {
            // Set the error flag as we do not want the process to run further
            $iserror   = true;
            // Set the error code
            $errorcode = "isPasswordNotCorrect";
        }
    }
    ;
    
    /* Check and validate the ircnick that was supplied */
    if ($iserror === false) {
        if (empty($_POST['ircnick'])) {
            // If the ircnick is blank then fail
            die("Please enter a ircnick.");
            // Set the error flag as we do not want the process to run further
            $iserror   = true;
            // Set the error code
            $errorcode = "isBlankIRCNick";
        } else {
            // Check if the ircnick supplied is within the regex parameters
            if (!preg_match("/^[A-Za-z0-9_]+$/", $_POST['ircnick'])) {
                // Set the error flag as we do not want the process to run further
                $iserror   = true;
                // Set the error code
                $errorcode = "isIRCNickNotCorrectRegEx";
            }
            if (!$iserror) {
                // Check if the ircnick supplied has not already been used
                $query        = "SELECT 1 FROM tbl_base_user WHERE upper(irc_nick) = upper(:ircnick) ";
                $query_params = array(
                    ':ircnick' => $_POST['ircnick']
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
                    $errorcode = "isIRCNickTaken";
                }
            }
        }
    }
    ;
    
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
    
    //    if (empty($_POST['ircnick'])) {
    //        die("Please enter a irc.");
    //}
    //if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
    //die("Invalid E-Mail Address/username");
    //}
    
    // Check if the username is already taken
    /*    $query        = "SELECT 1 FROM tbl_base_user WHERE username = :username ";
    $query_params = array(
    ':username' => $_POST['username']
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
    die("This username is already in use");
    }
    */
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
        $salt     = dechex(mt_rand(0, 2147483647)) . dechex(mt_rand(0, 2147483647));
        $password = hash('sha256', $_POST['password'] . $salt);
        for ($round = 0; $round < 65536; $round++) {
            $password = hash('sha256', $password . $salt);
        }
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
            ':password' => $password,
            ':salt' => $salt,
            ':acc_val_key' => substr($user_auth_code, 0, 32)
        );
        try {
            $stmt   = $db->prepare($query);
            $result = $stmt->execute($query_params);
        }
        catch (PDOException $ex) {
            $newuser = false;
            die("Failed to run query: " . $ex->getMessage());
        }
    }
}

if (!$iserror and $newuser) {
    /* Place code here that sends the email */
    $usrurl  = $baseurl . "/auth/accountval.php?user=" . $_POST['email'] . "&verify=" . substr($user_auth_code, 0, 32);
    $to      = $_POST['email'];
    $subject = "WUGMS - Confirmation of your account is needed";
    $message = "
                    
                    <html lang='en'>
                       <head>
                          <meta charset='utf-8'>
                          <meta http-equiv='X-UA-Compatible' content='IE=edge'>
                          <meta name='viewport' content='width=device-width, initial-scale=1'>
                          <meta name='description' content='Confirmation of your account is needed'>
                          <meta name='author' content='That_One_Guy'>
                          <title>WUGMS - Confirmation of your account is needed</title>
                       </head>
                       <body>
                          <h2>Thank you for creating a new account at WUGMS</h2>
                          <p>Use use the URL shown below in order to confirm your account so that you can get started.</p>
                          <a href='" . $usrurl . "'>" . $usrurl . "</a>
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
    $headers .= 'From: no-reply@wugms.jawug.org.za' . "\r\n";
    $headers .= 'Bcc: dev.duncane@gmail.com' . "\r\n";
    
    $retval = mail($to, $subject, $message, $headers);
    if ($retval == true) {
        header("Location: /register/success.php");
        die("Redirecting to success.php");
    } else {
        // Show msg for failure
        header("Location: /register/whoops.php");
        die("Redirecting to whoops.php");
    }
    
    header("Location: index.php");
    die("Redirecting to index.php");
}

?>