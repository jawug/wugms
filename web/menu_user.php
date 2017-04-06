<?php
if (!isset($_SESSION["username"])) {
    ?>
    <!-- If there is no username then show the menu to login or register -->
    <ul class='nav navbar-nav navbar-right'>
        <li><a href='../register'>Register</a></li>
        <li class='dropdown'>
            <a class='dropdown-toggle' href='#' data-toggle='dropdown'>Log In <strong class='caret'></strong></a>
            <div class='dropdown-menu' style='padding: 15px; padding-bottom: 0px;'>
                <div class="container"> 
                    <div class="row"> 
                        <div class="col-sm-6 col-md-4 col-md-offset-4">
                            <form class="form-horizontal" method="post" action="../auth/login.php" >
                                <div class="input-group">
                                    <span class="input-group-addon" ><span class="glyphicon glyphicon-envelope" ></span></span>
                                    <input type="text" id="sub_username" name="sub_username" class="form-control" placeholder="user@domain.somewhere" required autofocus>
                                </div>
                                <br />
                                <div class="input-group">
                                    <span class="input-group-addon" ><span class="glyphicon glyphicon-lock" ></span></span>
                                    <input type="password" id="sub_password" name="sub_password" class="form-control" placeholder="Password" required>
                                </div>
                                <br />
                                <button class="btn btn-lg btn-primary btn-block" value="Submit" name="submit" type="submit">Login</button>
                                <div style="text-align:right;">
                                    <a href='../auth/lostpassword.php'>Forgot your password?</a>
                                </div>
                                <br />
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </li>
        <li><a href="#" class="dropdown-toggle" data-toggle="modal"><span class='glyphicon glyphicon-question-sign' aria-hidden='true'></span></a></li>
    </ul>
    <?php
} else {
    ?>
    <ul class='nav navbar-nav navbar-right'>
        <li class='dropdown'>
            <a href='#' class='dropdown-toggle' data-toggle='dropdown'>
                <?php echo $_SESSION["display_name"]; ?>	
                <span class='caret'></span></a>
            <ul class='dropdown-menu' role='menu'>
                <li><a href='/ms/user/profile'>Profile</a></li>
                <li><a href='/ms/user/history'>History</a></li>
            </ul>
        </li>
        <li><a href='/auth/logout.php'>Logout</a></li>
        <li><a href="#" class="dropdown-toggle" data-toggle="modal" data-target="#myHelpModal"><span class='glyphicon glyphicon-question-sign' aria-hidden='true'></span></a></li>
    </ul>
    <?php
}
?>