<?php
/* This is required for custom branding */
require($_SERVER['DOCUMENT_ROOT'] . '/content/branding.php');
/* Check if there something posted */
if (!empty($_POST)) {
    /* Start a session */
    session_start();
    /* Nuke the current session as this will create issues */
    //$_SESSION = array();
    /* Clear the cookie */
    //if (ini_get("session.use_cookies")) {
    //$params = session_get_cookie_params();
    //setcookie(session_name(), '', time() - 42000, $params["path"], $params["domain"], $params["secure"], $params["httponly"]);
    //}
    /* destroy the session */
    //    session_destroy();
    /* variables */
    $baseurl = "http://wugms.bwcsystem.net:20080";
    /* Load required function files */
    require($_SERVER['DOCUMENT_ROOT'] . '/auth/config.php');
    require($_SERVER['DOCUMENT_ROOT'] . '/content/functions.php');


    // Ensure that the user fills out fields
    if (empty($_POST['inputPhone']) or ! filter_var($_POST['inputusername'], FILTER_VALIDATE_EMAIL)) {

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
                <title>WUGMS - Reset password</title>
                <!-- Bootstrap core CSS -->
                <link href="/css/bootstrap.min.css" rel="stylesheet">
                <link href="/css/jumbotron.css" rel="stylesheet">
                <link href="/css/sticky-footer-navbar.css" rel="stylesheet">
                <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->

                <script src="/js/ie-emulation-modes-warning.js"></script>
                <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
                <!--[if lt IE 9]>
                <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
                <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
                <![endif]-->
            </head>
            <body>
                <div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
                    <div class="container-fluid">
                        <div class="navbar-header">
                            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                                <span class="sr-only">Toggle navigation</span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                            </button>
        <?php echo "<a class='navbar-brand' >" . $ShortName . "-" . $WShortSiteName . "</a>"; ?>
                        </div>
                        <div class="collapse navbar-collapse">
                            <ul class="nav navbar-nav">
                                <li class="active"><a href="/">Home</a></li>
                                <?php include($_SERVER['DOCUMENT_ROOT'] . '/public.php'); ?>
                                <?php include($_SERVER['DOCUMENT_ROOT'] . '/sites.php'); ?>
        <?php include($_SERVER['DOCUMENT_ROOT'] . '/dashboard.php'); ?>
                                <li><a href="/gettingstarted">Getting Started</a></li>
                                <li><a href="/contact">Contact us</a></li>
                                <li><a href="/about">About</a></li>
                            </ul>
        <?php include($_SERVER['DOCUMENT_ROOT'] . '/user.php'); ?>
                        </div>
                    </div>
                </div>
                <div class="jumbotron">
                    <div class="container-fluid">
                        <h1>Lost password</h1>
                        <p class="lead">Please fill in the required fields</p>
                    </div>
                </div>
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-6 col-md-4 col-md-offset-4">
                            <form class="form-horizontal" role="form" method="post" action="" >

                                <div class="alert alert-danger" role="danger">Email address/phone number is incorrect. Please try again.</div>
                                <br />
                                <div class="input-group">
                                    <span class="input-group-addon" ><span class="glyphicon glyphicon-envelope" ></span></span>
                                    <input type="text" id="inputusername" name="inputusername" class="form-control" placeholder="user@domain.somewhere" aria-describedby="basic-addon1" required autofocus>
                                </div>
                                <br />
                                <div class="input-group">
                                    <span class="input-group-addon" id="basic-addon2"><span class="glyphicon glyphicon-earphone" id="basic-addon2"></span></span>
                                    <input type="text" id="inputPhone" name="inputPhone" class="form-control" placeholder="+27000000000" aria-describedby="basic-addon2" required autofocus>
                                </div>
                                <br />
                                <br />
                                <div class="alert alert-warning" role="alert">Please note that this function only works with accounts that are active. If you have used this function before and not followed the instructions provided in the email sent to you, then this will also not work.</div>
                                <br />
                                <button class="btn btn-lg btn-info btn-block" value="Submit" name="submit" type="submit">Reset my password</button>
                                <a href="/" class="btn btn-lg btn-success btn-block">Return to the WUGMS home page</a>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
                <script src="/js/ie10-viewport-bug-workaround.js"></script>
            </body>
        </html>
        <?php
        die(" ");
    }
    /* if (!filter_var($_POST['inputusername'], FILTER_VALIDATE_EMAIL)) {         die("Invalid E-Mail Address/username");     } */
    $query = " SELECT 1 FROM tbl_base_user WHERE username = :username and phone_num = :phone_num ";
    $query_params = array(
        ':username' => $_POST['inputusername'],
        ':phone_num' => $_POST['inputPhone']
    );
    try {
        $stmt = $db->prepare($query);
        $result = $stmt->execute($query_params);
    } catch (PDOException $ex) {
        die("Failed to run query: " . $ex->getMessage());
    }
    $row = $stmt->fetch();
    if ($row) {
        /* Add code here to determine if the user has a readonly account */
        $roles_query = "SELECT b.roll_id FROM tbl_base_user a, wugms.tbl_ae_user_rolls b WHERE a.username = :username AND a.idtbl_base_user = b.username_id";
        $roles_query_params = array(
            ':username' => $_POST['inputusername']
        );
        try {
            $roles_stmt = $db->prepare($roles_query);
            $roles_result = $roles_stmt->execute($roles_query_params);
        } catch (PDOException $ex) {
            die("Failed to run query11: " . $ex->getMessage());
        }
        $roles_row = $roles_stmt->fetchAll();
        if ($roles_row) {
            foreach ($roles_row as $item) {
//				print_r $item;
                if (strval($item['roll_id']) == 'readonly') {
                    /* Check and make sure that the account is not in pending and if it is not then fail and tell the user */

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
                            <title>WUGMS - Reset password</title>
                            <!-- Bootstrap core CSS -->
                            <link href="/css/bootstrap.min.css" rel="stylesheet">
                            <link href="/css/jumbotron.css" rel="stylesheet">
                            <link href="/css/sticky-footer-navbar.css" rel="stylesheet">
                            <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->

                            <script src="/js/ie-emulation-modes-warning.js"></script>
                            <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
                            <!--[if lt IE 9]>
                            <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
                            <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
                            <![endif]-->
                        </head>
                        <body>
                            <div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
                                <div class="container-fluid">
                                    <div class="navbar-header">
                                        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                                            <span class="sr-only">Toggle navigation</span>
                                            <span class="icon-bar"></span>
                                            <span class="icon-bar"></span>
                                            <span class="icon-bar"></span>
                                        </button>
                                        <?php echo "<a class='navbar-brand' >" . $ShortName . "-" . $WShortSiteName . "</a>"; ?>
                                    </div>
                                    <div class="collapse navbar-collapse">
                                        <ul class="nav navbar-nav">
                                            <li class="active"><a href="/">Home</a></li>
                                            <?php include($_SERVER['DOCUMENT_ROOT'] . '/public.php'); ?>
                                            <?php include($_SERVER['DOCUMENT_ROOT'] . '/sites.php'); ?>
                                            <?php include($_SERVER['DOCUMENT_ROOT'] . '/dashboard.php'); ?>
                                            <li><a href="/gettingstarted">Getting Started</a></li>
                                            <li><a href="/contact">Contact us</a></li>
                                            <li><a href="/about">About</a></li>
                                        </ul>
                                        <?php include($_SERVER['DOCUMENT_ROOT'] . '/user.php'); ?>
                                    </div>
                                </div>
                            </div>
                            <div class="jumbotron">
                                <div class="container-fluid">

                                </div>
                            </div>
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-sm-4 col-md-6 col-md-offset-2">
                                        <div class="panel panel-danger">
                                            <div class="panel-heading">
                                                <h3 class="panel-title"><b>Well now this is rather awkward...</b></h3>
                                            </div>
                                            <div class="panel-body">
                                                <p>Your account has the attribute of "readonly". That means certain things can not be changed. Lostpassword/reset password is one of those things. Check with the wugms-admins on IRC to determine on how to get that changed.</p>
                                                <br />
                                                <div align="center">
                                                    <a href="/" class="btn btn-success btn-lg">Return to the WUGMS home page</a>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <footer class="footer">
                                <div class="container-fluid">
                                    <?php echo $footercopy; ?>
                                </div>
                            </footer>
                            <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
                            <script src="/js/ie10-viewport-bug-workaround.js"></script>
                        </body>
                    </html>
                    <?php
                    die("");
                }
            }
        }

        /* Add code here to get account status */
        $acc_stat_query = "SELECT a.acc_status FROM tbl_base_user a WHERE a.username = :username";
        $acc_stat_query_params = array(
            ':username' => $_POST['inputusername']
        );
        try {
            $acc_stat_stmt = $db->prepare($acc_stat_query);
            $acc_stat_result = $acc_stat_stmt->execute($acc_stat_query_params);
        } catch (PDOException $ex) {
            die("Failed to run query22: " . $ex->getMessage());
        }
        $acc_error = false;
        $acc_stat_row = $acc_stat_stmt->fetch();
        if ($acc_stat_row) {
            /* Check and make sure that the account is not in pending and if it is not then fail and tell the user */
            foreach ($acc_stat_row as $item) {
                if ($item == 'pending') {

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
                            <title>WUGMS - Reset password</title>
                            <!-- Bootstrap core CSS -->
                            <link href="/css/bootstrap.min.css" rel="stylesheet">
                            <link href="/css/jumbotron.css" rel="stylesheet">
                            <link href="/css/sticky-footer-navbar.css" rel="stylesheet">
                            <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->

                            <script src="/js/ie-emulation-modes-warning.js"></script>
                            <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
                            <!--[if lt IE 9]>
                            <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
                            <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
                            <![endif]-->
                        </head>
                        <body>
                            <div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
                                <div class="container-fluid">
                                    <div class="navbar-header">
                                        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                                            <span class="sr-only">Toggle navigation</span>
                                            <span class="icon-bar"></span>
                                            <span class="icon-bar"></span>
                                            <span class="icon-bar"></span>
                                        </button>
                                        <?php echo "<a class='navbar-brand' >" . $ShortName . "-" . $WShortSiteName . "</a>"; ?>
                                    </div>
                                    <div class="collapse navbar-collapse">
                                        <ul class="nav navbar-nav">
                                            <li class="active"><a href="/">Home</a></li>
                                            <?php include($_SERVER['DOCUMENT_ROOT'] . '/public.php'); ?>
                                            <?php include($_SERVER['DOCUMENT_ROOT'] . '/sites.php'); ?>
                                            <?php include($_SERVER['DOCUMENT_ROOT'] . '/dashboard.php'); ?>
                                            <li><a href="/gettingstarted">Getting Started</a></li>
                                            <li><a href="/contact">Contact us</a></li>
                                            <li><a href="/about">About</a></li>
                                        </ul>
                                        <?php include($_SERVER['DOCUMENT_ROOT'] . '/user.php'); ?>
                                    </div>
                                </div>
                            </div>
                            <div class="jumbotron">
                                <div class="container-fluid">

                                </div>
                            </div>
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-sm-4 col-md-6 col-md-offset-2">
                                        <div class="panel panel-danger">
                                            <div class="panel-heading">
                                                <h3 class="panel-title"><b>There seems to be a problem with account...</b></h3>
                                            </div>
                                            <div class="panel-body">
                                                <p>Your account status is <b>"pending"</b>. That means you still need to click on the URL in the email that was sent to you, when you registered, so that you can access your account.</p>
                                                <br />
                                                <div align="center">
                                                    <a href="/" class="btn btn-success btn-lg">Return to the WUGMS home page</a>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <footer class="footer">
                                <div class="container-fluid">
                                    <?php echo $footercopy; ?>
                                </div>
                            </footer>
                            <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
                            <script src="/js/ie10-viewport-bug-workaround.js"></script>
                        </body>
                    </html>
                    <?php
                    die("");
                }
            }
        }



        /* First log into the audit table that there was a change request and it met the requirements */
        wugmsaudit("user", "auth", "lost_password", "User has forgot their password");
        /* Update the user table */
        /* Create register key */
        $user_auth_salt = dechex(mt_rand(0, 2147483647)) . dechex(mt_rand(0, 2147483647));
        $user_auth_code = hash('sha256', date("Y-m-d h:i:sa") . $user_auth_salt);
        for ($round = 0; $round < 65536; $round++) {
            $user_auth_code = hash('sha256', $user_auth_code . $user_auth_salt);
        }

        $query = " UPDATE tbl_base_user SET acc_status = :acc_status , acc_val_key = :acc_val_key WHERE username = :username ";
        $query_params = array(
            ':username' => $_POST['inputusername'],
            ':acc_status' => "lostpassword",
            ':acc_val_key' => substr($user_auth_code, 0, 32)
        );

        try {
            $pstmt = $db->prepare($query);
            $result = $pstmt->execute($query_params);
        } catch (PDOException $ex) {
            die("Failed to run query 3: " . $ex->getMessage());
        }
        /* Place code here that sends the email */
        $usrurl = $baseurl . "/auth/resetpw.php?user=" . $_POST['inputusername'] . "&verify=" . substr($user_auth_code, 0, 32);
        $to = $_POST['inputusername'];
        $subject = "WUGMS - Lost password";
        $message = "

                    <html lang='en'>
                       <head>
                          <meta charset='utf-8'>
                          <meta http-equiv='X-UA-Compatible' content='IE=edge'>
                          <meta name='viewport' content='width=device-width, initial-scale=1'>
                          <meta name='description' content='Lost password emailer for WUGMS'>
                          <meta name='author' content='That_One_Guy'>
                          <title>WUGMS - Reset password</title>
                       </head>
                       <body>
                          <h2>You have requested that your password be reset</h2>
                          <p>Use use the URL shown below in order to reset your password.</p>
                          <a href='" . $usrurl . "'>" . $usrurl . "</a>
                          <br />
                          <br />
                          <p>If you have any problems then please come and chat to us in IRC #jawug so that we can help you.</p>
                          <br />
                          <p>Keep on wugging!</p>
                       </body>
                    </html>";
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

        // More headers
        $headers .= 'From: no-reply@wugms.jawug.org.za' . "\r\n";
        $retval = mail($to, $subject, $message, $headers);
        if ($retval == true) {

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
                    <title>WUGMS - Lost password</title>
                    <!-- Bootstrap core CSS -->
                    <link href="/css/bootstrap.min.css" rel="stylesheet">
                    <link href="/css/jumbotron.css" rel="stylesheet">
                    <link href="/css/sticky-footer-navbar.css" rel="stylesheet">
                    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->

                    <script src="/js/ie-emulation-modes-warning.js"></script>
                    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
                    <!--[if lt IE 9]>
                    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
                    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
                    <![endif]-->
                </head>
                <body>
                    <div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
                        <div class="container-fluid">
                            <div class="navbar-header">
                                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                                    <span class="sr-only">Toggle navigation</span>
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                </button>
                                <?php echo "<a class='navbar-brand' >" . $ShortName . "-" . $WShortSiteName . "</a>"; ?>
                            </div>
                            <div class="collapse navbar-collapse">
                                <ul class="nav navbar-nav">
                                    <li class="active"><a href="/">Home</a></li>
                                    <?php include($_SERVER['DOCUMENT_ROOT'] . '/public.php'); ?>
                                    <?php include($_SERVER['DOCUMENT_ROOT'] . '/sites.php'); ?>
                                    <?php include($_SERVER['DOCUMENT_ROOT'] . '/dashboard.php'); ?>
                                    <li><a href="/gettingstarted">Getting Started</a></li>
                                    <li><a href="/contact">Contact us</a></li>
                                    <li><a href="/about">About</a></li>
                                </ul>
                                <?php include($_SERVER['DOCUMENT_ROOT'] . '/user.php'); ?>
                            </div>
                        </div>
                    </div>
                    <div class="jumbotron">
                        <div class="container-fluid">

                        </div>
                    </div>
                    <div class="container-fluid" align="center" >
                        <h3 class="form-signin-heading">An email has been sent to <?php echo $_POST['inputusername']; ?> </h3>
                        <h3>Please follow the instructions in the email in order to get your account going again.</h3>
                        <br />
                        <a href="/" class="btn btn-success btn-lg">Return to the WUGMS home page</a>
                    </div>
                    <footer class="footer">
                        <div class="container-fluid">
                            <?php echo $footercopy; ?>
                        </div>
                    </footer>
                    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
                    <script src="/js/ie10-viewport-bug-workaround.js"></script>
                </body>
            </html>
            <?php
        } else {
            echo "Message could not be sent...";
        }
    } else {
        /* Send the user a msg that things failed */

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
                <title>WUGMS - Reset password</title>
                <!-- Bootstrap core CSS -->
                <link href="/css/bootstrap.min.css" rel="stylesheet">
                <link href="/css/jumbotron.css" rel="stylesheet">
                <link href="/css/sticky-footer-navbar.css" rel="stylesheet">
                <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->

                <script src="/js/ie-emulation-modes-warning.js"></script>
                <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
                <!--[if lt IE 9]>
                <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
                <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
                <![endif]-->
            </head>
            <body>
                <div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
                    <div class="container-fluid">
                        <div class="navbar-header">
                            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                                <span class="sr-only">Toggle navigation</span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                            </button>
                            <?php echo "<a class='navbar-brand' >" . $ShortName . "-" . $WShortSiteName . "</a>"; ?>
                        </div>
                        <div class="collapse navbar-collapse">
                            <ul class="nav navbar-nav">
                                <li class="active"><a href="/">Home</a></li>
                                <?php include($_SERVER['DOCUMENT_ROOT'] . '/public.php'); ?>
                                <?php include($_SERVER['DOCUMENT_ROOT'] . '/sites.php'); ?>
                                <?php include($_SERVER['DOCUMENT_ROOT'] . '/dashboard.php'); ?>
                                <li><a href="/gettingstarted">Getting Started</a></li>
                                <li><a href="/contact">Contact us</a></li>
                                <li><a href="/about">About</a></li>
                            </ul>
                            <?php include($_SERVER['DOCUMENT_ROOT'] . '/user.php'); ?>
                        </div>
                    </div>
                </div>
                <div class="jumbotron">
                    <div class="container-fluid">
                        <h1>Lost password</h1>
                        <p class="lead">Please fill in the required fields</p>
                    </div>
                </div>
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-6 col-md-4 col-md-offset-4">
                            <form class="form-horizontal" role="form" method="post" action="" >

                                <div class="alert alert-danger" role="danger">Email address/phone number is incorrect. Please try again.</div>
                                <br />
                                <div class="input-group">
                                    <span class="input-group-addon" ><span class="glyphicon glyphicon-envelope" ></span></span>
                                    <input type="text" id="inputusername" name="inputusername" class="form-control" placeholder="user@domain.somewhere" aria-describedby="basic-addon1" required autofocus>
                                </div>
                                <br />
                                <div class="input-group">
                                    <span class="input-group-addon" id="basic-addon2"><span class="glyphicon glyphicon-earphone" id="basic-addon2"></span></span>
                                    <input type="text" id="inputPhone" name="inputPhone" class="form-control" placeholder="+27000000000" aria-describedby="basic-addon2" required autofocus>
                                </div>
                                <br />
                                <br />
                                <div class="alert alert-warning" role="alert">Please note that this function only works with accounts that are active. If you have used this function before and not followed the instructions provided in the email sent to you, then this will also not work.</div>
                                <br />
                                <button class="btn btn-lg btn-info btn-block" value="Submit" name="submit" type="submit">Reset my password</button>
                                <a href="/" class="btn btn-lg btn-success btn-block">Return to the WUGMS home page</a>
                            </form>
                        </div>
                    </div>
                </div>
                <footer class="footer">
                    <div class="container-fluid">
                        <?php echo $footercopy; ?>
                    </div>
                </footer>
                <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
                <script src="/js/ie10-viewport-bug-workaround.js"></script>
            </body>
        </html>
        <?php
    }
} else {
    /* Display the "normal" page that the clietn/user needs to fill in */
    session_start();
    /* Nuke the current session as this will create issues */
    $_SESSION = array();
    /* Clear the cookie */
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000, $params["path"], $params["domain"], $params["secure"], $params["httponly"]);
    }
    /* destroy the session */
    session_destroy();

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
            <title>WUGMS - Reset password</title>
            <!-- Bootstrap core CSS -->
            <link href="/css/bootstrap.min.css" rel="stylesheet">
            <link href="/css/jumbotron.css" rel="stylesheet">
            <link href="/css/sticky-footer-navbar.css" rel="stylesheet">
            <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->

            <script src="/js/ie-emulation-modes-warning.js"></script>
            <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
            <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
            <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
            <![endif]-->
        </head>
        <body>
            <div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
                <div class="container-fluid">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <?php echo "<a class='navbar-brand' >" . $ShortName . "-" . $WShortSiteName . "</a>"; ?>
                    </div>
                    <div class="collapse navbar-collapse">
                        <ul class="nav navbar-nav">
                            <li class="active"><a href="/">Home</a></li>
                            <?php include($_SERVER['DOCUMENT_ROOT'] . '/public.php'); ?>
                            <?php include($_SERVER['DOCUMENT_ROOT'] . '/sites.php'); ?>
                            <?php include($_SERVER['DOCUMENT_ROOT'] . '/dashboard.php'); ?>
                            <li><a href="/gettingstarted">Getting Started</a></li>
                            <li><a href="/contact">Contact us</a></li>
                            <li><a href="/about">About</a></li>
                        </ul>
                        <?php include($_SERVER['DOCUMENT_ROOT'] . '/user.php'); ?>
                    </div>
                </div>
            </div>
            <div class="jumbotron">
                <div class="container-fluid">
                    <h1>Lost password</h1>
                    <p class="lead">Please fill in the required fields</p>
                </div>
            </div>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6 col-md-4 col-md-offset-4">
                        <form class="form-horizontal" role="form" method="post" action="" >
                            <div class="input-group">
                                <span class="input-group-addon" ><span class="glyphicon glyphicon-envelope" ></span></span>
                                <input type="text" id="inputusername" name="inputusername" class="form-control" placeholder="user@domain.somewhere" aria-describedby="basic-addon1" required autofocus>
                            </div>
                            <br />
                            <div class="input-group">
                                <span class="input-group-addon" id="basic-addon2"><span class="glyphicon glyphicon-earphone" id="basic-addon2"></span></span>
                                <input type="text" id="inputPhone" name="inputPhone" class="form-control" placeholder="+27000000000" aria-describedby="basic-addon2" required autofocus>
                            </div>
                            <br />
                            <br />
                            <div class="alert alert-warning" role="alert">Please note that this function only works with accounts that are active. If you have used this function before and not followed the instructions provided in the email sent to you, then this will also not work.</div>
                            <br />
                            <button class="btn btn-lg btn-info btn-block" value="Submit" name="submit" type="submit">Reset my password</button>
                            <a href="/" class="btn btn-lg btn-success btn-block">Return to the WUGMS home page</a>
                        </form>
                    </div>
                </div>
            </div>
            <footer class="footer">
                <div class="container-fluid">
                    <?php echo $footercopy; ?>
                </div>
            </footer>
            <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
            <script src="/js/ie10-viewport-bug-workaround.js"></script>
        </body>
    </html>
    <?php
}

?>