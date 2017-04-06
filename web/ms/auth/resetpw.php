<?php
/* This is required for custom branding */
require($_SERVER['DOCUMENT_ROOT'] . '/content/branding.php');
/* Check if there something posted */
if (!empty($_POST)) {
//	if (!filter_var($_POST['user'], FILTER_VALIDATE_EMAIL) or empty($_POST['verify']) or empty($_POST['newpw']) or !preg_match("/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?!.*\s).{6,20}$/", $_POST['newpw']) ) {
    if (empty($_POST['user']) or empty($_POST['verify']) or empty($_POST['newpw'])) {
        /* Show the error page telling them that the submit went wrong */
        echo "500";
    } else {
        /* Include some files */
        require($_SERVER['DOCUMENT_ROOT'] . '/auth/config.php');
        require($_SERVER['DOCUMENT_ROOT'] . '/content/functions.php');
        $row1 = "";
        /* Do checks here */
        /* Check if the username/acc_key are valid */
        $query1 = " SELECT 1 FROM tbl_base_user WHERE username = :username and acc_val_key = :acc_val_key ";
        $query1_params = array(
            ':username' => $_POST['user'],
            ':acc_val_key' => $_POST['verify']
        );



        /* SQL - parameters */
        $stmt1 = $db->prepare($query1);
        if ($stmt1->execute($query1_params)) {
            $row1 = $stmt1->fetchAll();
        }
        /* 			try {
          $stmt1   = $db->prepare($query1);
          $result1 = $stmt1->execute($query1_params);
          }
          catch (PDOException $ex) {
          die("Failed to run query: " . $ex->getMessage());
          } */
        /* 			$row1 = $stmt1->fetch(); */
        if ($row1) {
            /* check and make sure that the account is not readonly ??/ */
            /* update the password */
            $query = "UPDATE tbl_base_user set password = :password , salt = :salt , acc_val_key = :acc_val_key , acc_status =:acc_status where username = :username ;";

            // Security measures
            $salt = dechex(mt_rand(0, 2147483647)) . dechex(mt_rand(0, 2147483647));
            $password = hash('sha256', $_POST['newpw'] . $salt);
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
                ':username' => $_POST['user'],
                ':password' => $password,
                ':salt' => $salt,
                ':acc_status' => 'active',
                ':acc_val_key' => $user_auth_code
            );

            try {
                $stmt = $db->prepare($query);
                $result = $stmt->execute($query_params);
            } catch (PDOException $ex) {
                die("Failed to run query: " . $ex->getMessage());
            }

            echo "200";
            die(" ");
        } else {
            echo "300";
            die(" ");
        }
    }
} else {

    /* Display the form so that the use can fill in the page */
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
            <title>WUGMS - Reset Password</title>
            <!-- Bootstrap core CSS -->
            <link href="/css/bootstrap.min.css" rel="stylesheet">
            <link href="/css/jumbotron.css" rel="stylesheet">
            <link href="/css/formValidation.min.css" rel="stylesheet">
            <style type="text/css">
                #rstpw .form-control-feedback{
                    top: 0;
                    right: -30px;
                }
            </style>
            <!-- Custom styles for this template -->
            <!--<link href="/css/signin.css" rel="stylesheet"> -->
            <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->

        <!-- <script src="/js/ie-emulation-modes-warning.js"></script> -->
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
            <!-- Success modal -->
            <div class="modal fade" data-keyboard="false" data-backdrop="static" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="myModalLabel"><div class="alert alert-success" role="alert" align="center">Password reset successful!</div></h4>
                        </div>
                        <div class="modal-footer">
                            <a href="/" class="btn btn-default" role="button">Return to main page</a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- -->
            <!-- verify code is wrong modal -->
            <div class="modal fade" data-keyboard="false" data-backdrop="static" id="myModal300" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="myModalLabel"><div class="alert alert-danger" role="alert" align="center">Supplied username and/or verification code invalid</div></h4>
                        </div>
                        <div class="modal-footer">
                            Please try the <a href="../auth/lostpassword.php">Forgot your password</a> function again.
                        </div>
                    </div>
                </div>
            </div>
            <!-- -->
            <!-- parameters are wrong -->
            <div class="modal fade" data-keyboard="false" data-backdrop="static" id="myModal500" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="myModalLabel"><div class="alert alert-warning" role="alert" align="center">Supplied data is incorrect</div></h4>
                        </div>
                        <div class="modal-footer">
                            <a href="#" id="winfo" name="winfo" class="btn btn-default" role="button">Let's try this again, shall we?</a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- -->
            <div class="jumbotron">
                <div class="container-fluid">
                    <h1>Reset Password</h1>

                </div>
            </div>
            <!-- Container that has the form --> 
            <div id="userreg" class="container-fluid">
                <div class="row">
                    <div class="col-sm-4 col-md-6 col-md-offset-2">
                        <div id="results"> </div>
                        <form class="form-horizontal" role="form" id="rstpw" name="rstpw" enctype="multipart/form-data" method="post" action="">
                            <div class="alert alert-success" style="display: none;"></div>
                            <!-- Password first entry -->
                            <div class="form-group">
                                <label for="newpw" class="control-label col-sm-4">Password:</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <span class="input-group-addon" ><span class="glyphicon glyphicon-lock" ></span></span>
                                        <input type="password" id="newpw" name="newpw" class="form-control" aria-describedby="basic-addon" required autofocus>
                                    </div>
                                </div>
                            </div>
                            <!-- Password second entry -->
                            <div class="form-group">
                                <label for="verpw" class="control-label col-sm-4">Verify password:</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <span class="input-group-addon" ><span class="glyphicon glyphicon-check" ></span></span>
                                        <input type="password" id="verpw" name="verpw" class="form-control" aria-describedby="basic-addon" required autofocus>
                                    </div>
                                </div>
                            </div>

                            <!-- Hidden inputs needs for the id -->
                            <input type="hidden" name="user" value="<?php
                            if (!isset($_GET['user'])) {
                                print " ";
                            } else {
                                print $_GET['user'];
                            }
                            ?>">
                            <!--<input type="hidden" name="user" value=""> -->
                            <input type="hidden" name="verify" value="<?php
                            if (!isset($_GET['verify'])) {
                                print " ";
                            } else {
                                print $_GET['verify'];
                            }
                            ?>">

                            <div class="col-sm-12" align="center">
                                <div class="input-group">
                                    <button class="btn btn-primary" id="qwerty" type="submit">Update password</button>
                                </div> 
                            </div>
                        </form>
                    </div>
                </div>				
            </div>

            <br>
            <h2>&nbsp;</h2>
            <!-- Scripts! -->
    <?php include($_SERVER['DOCUMENT_ROOT'] . '/footreq.php'); ?>
            <!-- FormValidation plugin and the class supports validating Bootstrap form -->
            <script src="/js/formValidation.min.js"></script>
            <script src="/js/framework/bootstrap.min.js"></script>
            <script language="javascript" type="text/javascript">
                $(document).ready(function () {
                    $("#winfo").click(function () {
                        $('#rstpw').formValidation('resetForm', true);
                        $('#myModal500').modal('hide');
                    });
                });
            </script>			
            <script language="javascript" type="text/javascript">
                $(document).ready(function () {
                    $('#rstpw').formValidation({
                        framework: 'bootstrap',
                        feedbackIcons: {
                            valid: 'glyphicon glyphicon-ok',
                            invalid: 'glyphicon glyphicon-remove',
                            validating: 'glyphicon glyphicon-refresh'
                        },
                        excluded: ':disabled',
                        fields: {
                            newpw: {
                                validators: {
                                    notEmpty: {
                                        message: 'Required field'
                                    },
                                    stringLength: {
                                        min: 6,
                                        max: 20,
                                        message: 'The password must be more than 6 characters and less than 20 characters'
                                    },
                                    regexp: {
                                        regexp: /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?!.*\s).{6,20}$/,
                                        message: 'The Password must include at least one upper case letter, one lower case letter, and one numeric digit.'
                                    }
                                }
                            },
                            verpw: {
                                validators: {
                                    notEmpty: {
                                        message: 'Required field'
                                    },
                                    identical: {
                                        field: 'newpw',
                                        message: 'Password does not match'
                                    }
                                }
                            },
                        },
                    })

                            .on('success.form.fv', function (e) {
    // Prevent form submission
                                e.preventDefault();

                                var $form = $(e.target),
                                        fv = $form.data('formValidation');

    // Use Ajax to submit form data
                                $.ajax({
                                    url: '../auth/resetpw.php',
                                    type: 'POST',
                                    data: $form.serialize(),
                                    success: function (response) {
                                        /*$("#results").html(response);*/
                                        $res = response;
                                        if ($res == 200) {
                                            $('#myModal').modal('show');
                                        } else if ($res == 300) {
                                            $('#myModal300').modal('show');
                                        } else if ($res == 500) {
                                            $('#myModal500').modal('show');
                                        } else {
                                            console.log('who really knows what you are trying to do');
                                        }
                                        /*$('#myModal').modal('show'); */
                                    },
                                    error: function () {
                                        alert("There is a problem.");
                                    }
                                });
                            })
                });
            </script>
        </body>
    </html>
    <?php
}
?>
