<div class="modal fade" id="UserLoginModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"> 
    <div class="modal-dialog">
        <form id="UserLoginForm" name="UserLoginForm" class="form-horizontal" action="">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span class='glyphicon glyphicon-remove' aria-hidden='true'></button>
                    <h4 class="modal-title">User - Login</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="geusername" class="col-sm-3 control-label">Username</label>
                        <div class="col-sm-8">
                            <input class="form-control" id="geusername" name="geusername" placeholder="user@domain.somewhere" type="text" required autofocus>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="gepasswd" class="col-sm-3 control-label">Password</label>
                        <div class="col-sm-8">
                            <input class="form-control" id="gepasswd" name="gepasswd" placeholder="Password" type="password" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="form-group">
                        <button class="btn btn-lg btn-primary btn-block" value="submit" name="submit" type="submit">Login</button>
                        <?php if ($page_data->getSMTPUsage()) { ?>
                            <div style="text-align:right;">
                                <a href='/pm/auth/bwcfw.password.lost.php'>Forgot your password?</a>
                            </div>
                        <?php } ?>
                        <br />	
                    </div>
                </div>
            </div>
        </form> 
    </div>
</div>