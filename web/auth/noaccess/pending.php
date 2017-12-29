<?php
/* Start a session */
session_start();
/* null all vars in the session */
$_SESSION = array();
/* Clear the cookies */
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
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

		<!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
		
		<script src="/js/ie-emulation-modes-warning.js"></script>

		<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
		<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->
		<link href="/css/branding.css" rel="stylesheet">
		<style type="text/css">
			body {
			padding-top: 20px;    padding-bottom: 40px;
			}  .sidebar-nav {
			padding: 9px 0;  }
		</style>


		<style type="text/css">
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
    </style>

		<style type="text/css">
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
		<div id="bg">
			<img src="/images/pending.jpg" alt="You'll need to login">
		</div>
		<div class="site-wrapper content">
			<div class="site-wrapper-inner">
				<div class="cover-container">
					<div class="inner cover">
						<h1 class="cover-heading">Your account has not been validated!</h1>
						<p class="lead">The email that was sent to you from wugms@wugms.jawug.org.za has a url that you will need to click on in order to validate your email address and then you will have access to this site.</p>
						<br />
						<p class="lead">
						<a href="/" class="btn btn-lg btn-default">Return to the home page</a>
						</p>
					</div>
					<div class="mastfoot">
						<div class="inner">
							<p>&copy; Johannesburg Wireless User Group (<a href="http://www.jawug.org.za/">JAWUG</a>) 2014</p>
						</div>
					</div>
				</div>
			</div>
		</div>

		<!-- Scripts! -->
		<?php include($_SERVER['DOCUMENT_ROOT'].'/footreq.php'); ?>
		<!-- <script src="/js/docs.min.js"></script> -->
		<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
		<script src="/js/ie10-viewport-bug-workaround.js"></script>
	</body>
</html>