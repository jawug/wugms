<?php
/* Start session */
/* No validation will be done because this is a public page */
session_start();
/* Load required function files */
require($_SERVER['DOCUMENT_ROOT'].'/auth/config.php');
require($_SERVER['DOCUMENT_ROOT'].'/content/functions.php');
/* init var */
$isError = false;


if (!isset($_SESSION["username"])) {
    
    /* If the vars are set then next phase */
    if (isset($_GET['user']) and isset($_GET['verify'])) {
        /* Check the username */
        if (!filter_var($_GET['user'], FILTER_VALIDATE_EMAIL)) {
            /* msg to say that the username is wrong */
            //print "User account name is wrong";
            //print "<br />";
            $isError = true;
        } else {
            /* msg to say that the username is right */
            //print "User account name is correct";
            //print "<br />";
            /* check the var code */
            if (preg_match("/^(?=.*\d)(?=.*[a-z])(?!.*\s).{32}$/i", $_GET['verify'])) {
                /* msg to say that the var code is more or less right */
                //print "Var code seems right";
                //print "<br />";
                //print "This is where the user validation will take place";
                //print "<br />";
                $query        = " SELECT 1 FROM tbl_base_user WHERE username = :username and acc_val_key = :acc_val_key and acc_status = :acc_status ";
                $query_params = array(
                    ':username' => $_GET['user'],
                    ':acc_val_key' => $_GET['verify'],
                    ':acc_status' => "pending"
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
                    /* The inputs match up... make magic */
                    /* First log into the audit table that there was a change request and it met the requirements */
					wugmsaudit("user", "auth", "account_validation_from_url", "Account verified using URL");

                    /* Update the user table */
                    
                    $query        = " UPDATE tbl_base_user SET acc_status = :acc_status WHERE username = :username ";
                    $query_params = array(
                        ':username' => $_GET['user'],
                        ':acc_status' => "active"
                    );
                    
                    try {
                        $pstmt  = $db->prepare($query);
                        $result = $pstmt->execute($query_params);
                    }
                    catch (PDOException $ex) {
                        die("Failed to run query 3: " . $ex->getMessage());
                    }
                    /* Place code here that displays success */

?>
<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <meta name="description" content="">
      <meta name="author" content="">
      <link rel="icon" href="/img/favicon.ico">
      <title>WUGMS - Your account has been verified!</title>
      <!-- Bootstrap core CSS -->
      <link href="/css/bootstrap.min.css" rel="stylesheet">
      <!-- Custom styles for this template -->
      <link href="/css/signin.css" rel="stylesheet">
      <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
      
      <script src="/js/ie-emulation-modes-warning.js"></script>
      <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
      <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
      <![endif]-->
   </head>
   <body>
      <div class="container-fluid" align="center" >
         <h1 >Congratulations!</h1>
         <h4>Your account has been verified. </h3>
		 <h4>You now go to the home page and login with your username:</h3>
		 <br />
		 <h3><?php echo $_GET['user']; ?></h3>
		 <br />
		 <a href="/" class="btn btn-success btn-lg">Return to the WUGMS home page</a>
      </div>
      <!-- /container -->
      <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
      <script src="/js/ie10-viewport-bug-workaround.js"></script>
   </body>
</html>
<?php
                } else {
                    //print "The username and val code do no match up or your account has already been validated";
                    $isError = true;
                }
            } else {
                /* msg to say that the var code is more wrong than right */
                //print "Var code is so wrong";
                //print "<br />";
                $isError = true;
            }
            /**/
        }
        /**/
    } else {
        /* One of the vars is empty so tell the user */
        //print "We are missing something. ";
        //print "<br />";
        //print "Either the username or the password. Check the url and try again";
        //print "<br />";
        $isError = true;
    }
    
    if ($isError) {
?>
<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <meta name="description" content="">
      <meta name="author" content="">
      <link rel="icon" href="/img/favicon.ico">
      <title>WUGMS - Your account has been verified!</title>
      <!-- Bootstrap core CSS -->
      <link href="/css/bootstrap.min.css" rel="stylesheet">
      <!-- Custom styles for this template -->
      <link href="/css/signin.css" rel="stylesheet">
      <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
      
      <script src="/js/ie-emulation-modes-warning.js"></script>
      <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
      <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
      <![endif]-->
   </head>
   <body>
      <div class="container-fluid" align="center" >
         <h1>Oops!</h1>
         <div class="alert alert-danger" role="alert">
            <h4>It seems that there was a problem while trying to verify your account!</h4>
            <br />Please check the following as a way to determine what went wrong
         </div>
         <br />
         <ul>
            <li>The url you have used was incorrect. Please copy and paste it from the email that was sent.</li>
            <li>Your account may have already been verified. Please try logging in from the home page</li>
         </ul>
         <br />
         <h4>If you have already tried the above then please chat to us in IRC so that we can get your account up and running ASAP.</h4>
         <br />
         <a href="/" class="btn btn-success btn-lg">Return to the WUGMS home page</a>
      </div>
      <!-- /container -->
      <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
      <script src="/js/ie10-viewport-bug-workaround.js"></script>
   </body>
</html>
<?php
    }
    
} else {
?>
<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <meta name="description" content="">
      <meta name="author" content="">
      <link rel="icon" href="/img/favicon.ico">
      <title>WUGMS - Your account has been verified!</title>
      <!-- Bootstrap core CSS -->
      <link href="/css/bootstrap.min.css" rel="stylesheet">
      <!-- Custom styles for this template -->
      <link href="/css/signin.css" rel="stylesheet">
      <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
      
      <script src="/js/ie-emulation-modes-warning.js"></script>
      <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
      <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
      <![endif]-->
   </head>
   <body>
      <div class="container-fluid" align="center" >
         <h1>It seems that you are currently logged in!</h1>
         <div class="alert alert-info" role="alert">
            <h4>Please log out and then try the validation URL.</h4>
         </div>
         <br />
         <br />
         <br />
         <a href="/" class="btn btn-success btn-lg">Return to the WUGMS home page</a>
      </div>
      <!-- /container -->
      <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
      <script src="/js/ie10-viewport-bug-workaround.js"></script>
   </body>
</html>
<?php
}


?>