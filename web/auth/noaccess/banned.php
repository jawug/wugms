<?php
/* Start a session */
session_start();
/* This is required for custom branding */
require($_SERVER['DOCUMENT_ROOT'] . '/content/branding.php');
/* null all vars in the session */
$_SESSION = array();
/* Clear the cookies */
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000, $params["path"], $params["domain"], $params["secure"], $params["httponly"]
    );
}
// destroy the session
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
        <?php echo "<title>" . $WSiteName . " - " . $ShortName . "</title>"; ?>
        <!-- Bootstrap core CSS -->
        <link href="/css/bootstrap.min.css" rel="stylesheet">
        <!-- Custom styles for this template -->
        <link href="/css/cover.css" rel="stylesheet"> 
        <!--[if lt IE 9]>
        <script src="/js/html5shiv.min.js"></script>
        <script src="/js/respond.min.js"></script>
        <![endif]-->
        <link href="/css/branding.css" rel="stylesheet">
        <style type="text/css">
            body {
                padding-top: 20px;    padding-bottom: 40px;
            }  
            .sidebar-nav {
                padding: 9px 0;  }
            .leftie {
                text-align: left;
            }
            .blackie {
                colour: 333;
            }
            .show {
                text-decoration: underline;
                display: inline !important;
            }
            .content {
                position: relative;
            }
            #bg {
                position: fixed; 
                top: -50%; 
                left: -50%; 
                width: 200%; 
                height: 200%;
            }
            #bg img {
                opacity: 0.7;
                position: absolute; 
                top: 0; 
                left: 0; 
                right: 0; 
                bottom: 0; 
                margin: auto; 
                min-width: 50%;
                min-height: 50%;
                z-index: -1;
            }
        </style>
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
        <div id="bg">
            <img src="/images/banned-stamp.jpg" alt="I think you've taken a wrong turn">
        </div>
        <div class="site-wrapper content">
            <div class="site-wrapper-inner">
                <div class="cover-container">
                    <div class="inner cover">
                        <div class="panel panel-danger">
                            <div class="panel-heading">
                                <h1 class="panel-title">Your account has been BANNED!</h1>
                            </div>
                            <div class="panel-body">
                                <p>If you believe that there has been a mistake or require more information as to why you got ban hammered, send an email to whywasibanned@wugms.jawug.org.za</p>
                                <a href="/" class="btn btn-lg btn-primary">Return to the home page</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php include($_SERVER['DOCUMENT_ROOT'] . '/footreq.php'); ?>
        <script src="/js/ie10-viewport-bug-workaround.js"></script>
    </body>
</html>