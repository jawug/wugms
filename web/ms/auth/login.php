<?php
/* Load required function files */
require($_SERVER['DOCUMENT_ROOT'] . '/auth/config.php');
require($_SERVER['DOCUMENT_ROOT'] . '/content/functions.php');
require($_SERVER['DOCUMENT_ROOT'] . '/content/branding.php');

if (!empty($_POST)) {
//    if (!filter_var($_POST['sub_username'], FILTER_VALIDATE_EMAIL) or empty($_POST['sub_password']) or ! preg_match("/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?!.*\s).{6,20}$/", $_POST['sub_password'])) {
    if (empty($_POST['sub_username']) or empty($_POST['sub_password'])) {
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
                <?php echo "<title>" . $WSiteName . " - " . $ShortName . " - Login</title>"; ?>
                <!-- Bootstrap core CSS -->
                <link href="/css/bootstrap.min.css" rel="stylesheet">
                <!-- Custom styles for this template -->
                <link href="/css/signin.css" rel="stylesheet">
                <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->

                <script src="/js/ie-emulation-modes-warning.js"></script>
                <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
                <!--[if lt IE 9]>
                <script src="/js/html5shiv.min.js"></script>
                <script src="/js/respond.min.js"></script>
                <![endif]-->
            </head>
            <body>
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-6 col-md-4 col-md-offset-4">
                            <form class="form-horizontal" role="form" method="post" action="" >
                                <h2 class="form-signin-heading">Login</h2>
                                <br />
                                <div class="panel panel-danger">
                                    <div class="panel-heading">
                                        <h3 class="panel-title"><span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span> Wrong username/password</h3>
                                    </div>
                                    <div class="panel-body">
                                        The username/password you have entered is incorrect. Please try again.
                                    </div>
                                </div>
                                <br />
                                <div class="input-group">
                                    <span class="input-group-addon" ><span class="glyphicon glyphicon-envelope" ></span></span>
                                    <input type="text" id="sub_username" name="sub_username" class="form-control" placeholder="user@domain.somewhere" aria-describedby="basic-addon1" required autofocus>
                                </div>
                                <br />
                                <div class="input-group">
                                    <span class="input-group-addon" ><span class="glyphicon glyphicon-lock" ></span></span>
                                    <input type="password" id="sub_password" name="sub_password" class="form-control" placeholder="Password" aria-describedby="basic-addon2" >
                                </div>	
                                <br />
                                <button class="btn btn-lg btn-primary btn-block" value="Submit" name="submit" type="submit">Login</button>
                                <div align="right">
                                    <a href='../../auth/lostpassword.php'>Forgot your password?</a>
                                </div>
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
    $query = "SELECT username, irc_nick, idtbl_base_user, password, salt, acc_status FROM tbl_base_user WHERE username = :username or irc_nick = :username ";
    $query_params = array(
        ':username' => $_POST['sub_username']
    );

    try {
        $stmt = $db->prepare($query);
        $result = $stmt->execute($query_params);
    } catch (PDOException $ex) {
        die("Failed to run query: " . $ex->getMessage());
    }
    $login_ok = false;
    $row = $stmt->fetch();
    if ($row) {
        $check_password = hash('sha256', $_POST['sub_password'] . $row['salt']);

        for ($round = 0; $round < 65536; $round++) {
            $check_password = hash('sha256', $check_password . $row['salt']);
        }

        if ($check_password === $row['password']) {
            $login_ok = true;
        }
    }

    if ($login_ok) {
        unset($row['salt']);
        unset($row['password']);
        session_start();
        $_SESSION["username"] = $row['username'];
        $_SESSION["id"] = $row['idtbl_base_user'];
        $_SESSION["display_name"] = $row['irc_nick'];

//		$_SESSION["rb_sn"] = '';
        /* First log into the audit table that there was a change request and it met the requirements */
        wugmsaudit("user", "auth", "login", "User logged in");



        header("Location: /ms/");
        die("Redirecting to: /ms/");
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
                <?php echo "<title>" . $WSiteName . " - " . $ShortName . " - Login</title>"; ?>
                <!-- Bootstrap core CSS -->
                <link href="/css/bootstrap.min.css" rel="stylesheet">
                <!-- Custom styles for this template -->
                <link href="/css/signin.css" rel="stylesheet">
                <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->

                <script src="/js/ie-emulation-modes-warning.js"></script>
                <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
                <!--[if lt IE 9]>
                <script src="/js/html5shiv.min.js"></script>
                <script src="/js/respond.min.js"></script>
                <![endif]-->
            </head>
            <body>
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-6 col-md-4 col-md-offset-4">
                            <form class="form-horizontal" role="form" method="post" action="" >
                                <h2 class="form-signin-heading">Login</h2>
                                <br />
                                <div class="panel panel-danger">
                                    <div class="panel-heading">
                                        <h3 class="panel-title"><span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span> Wrong username/password</h3>
                                    </div>
                                    <div class="panel-body">
                                        The username/password you have entered is incorrect. Please try again.
                                    </div>
                                </div>
                                <br />
                                <div class="input-group">
                                    <span class="input-group-addon" ><span class="glyphicon glyphicon-envelope" ></span></span>
                                    <input type="text" id="sub_username" name="sub_username" class="form-control" placeholder="user@domain.somewhere" aria-describedby="basic-addon1" required autofocus>
                                </div>
                                <br />
                                <div class="input-group">
                                    <span class="input-group-addon" ><span class="glyphicon glyphicon-lock" ></span></span>
                                    <input type="password" id="sub_password" name="sub_password" class="form-control" placeholder="Password" aria-describedby="basic-addon2" required autofocus>
                                </div>	
                                <br />
                                <button class="btn btn-lg btn-primary btn-block" value="Submit" name="submit" type="submit">Login</button>
                                <div align="right">
                                    <a href='../../auth/lostpassword.php'>Forgot your password?</a>
                                </div>
                            </form>
                        </div>
                    </div>
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
            <?php echo "<title>" . $WSiteName . " - " . $ShortName . " - Login</title>"; ?>
            <!-- Bootstrap core CSS -->
            <link href="/css/bootstrap.min.css" rel="stylesheet">
            <!-- Custom styles for this template -->
            <link href="/css/signin.css" rel="stylesheet">
            <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->

            <script src="/js/ie-emulation-modes-warning.js"></script>
            <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
            <!--[if lt IE 9]>
            <script src="/js/html5shiv.min.js"></script>
            <script src="/js/respond.min.js"></script>
            <![endif]-->
        </head>
        <body>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6 col-md-4 col-md-offset-4">
                        <form class="form-horizontal" role="form" method="post" action="" >
                            <h2 class="form-signin-heading">Login</h2>
                            <br />
                            <div class="input-group">
                                <span class="input-group-addon" ><span class="glyphicon glyphicon-envelope" ></span></span>
                                <input type="text" id="sub_username" name="sub_username" class="form-control" placeholder="user@domain.somewhere" aria-describedby="basic-addon1" required autofocus>
                            </div>
                            <br />
                            <div class="input-group">
                                <span class="input-group-addon" ><span class="glyphicon glyphicon-lock" ></span></span>
                                <input type="password" id="sub_password" name="sub_password" class="form-control" placeholder="Password" aria-describedby="basic-addon2" required autofocus>
                            </div>	
                            <br />
                            <button class="btn btn-lg btn-primary btn-block" value="Submit" name="submit" type="submit">Login</button>
                            <div align="right">
                                <a href='../../auth/lostpassword.php'>Forgot your password?</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- /container -->
            <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
            <script src="/js/ie10-viewport-bug-workaround.js"></script>
        </body>
    </html>

    <?php
    die(" ");
}
?> 