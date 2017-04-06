<div class="container-fluid theme-showcase" role="main">
    <!-- Help modal -->
    <div class="modal fade" id="myHelpModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Help - User Profile</h4>
                </div>
                <div class="modal-body">
                    <p>This page displays the user's information as per when the registration form was filled in. The "user roles" detail what type of access the user has on this site as well as what functions they can perform. </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" data-dismiss="modal">Close</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    <!-- Update Details modal -->
    <div class="modal fade" id="UpdateDetailsModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Update details</h4>
                </div>
                <div class="modal-body">
                    <form id="UpdateDetailsForm" method="post" enctype="multipart/form-data" class="form-horizontal" action="">
                        <!-- Display the user's profile -->
                        <div class="form-group">
                            <label for="edit_name" class="col-md-4 control-label">Name</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" id="edit_name" name="edit_name" value="<?php echo $_SESSION["firstName"] ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="edit_surname" class="col-md-4 control-label">Surname</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" id="edit_surname" name="edit_surname" value="<?php echo $_SESSION["lastName"] ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="edit_ircnick" class="col-md-4 control-label">IRCNick</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" id="edit_ircnick" name="edit_ircnick" value="<?php echo $_SESSION["irc_nick"] ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="edit_username" class="col-md-4 control-label">Username</label>
                            <div class="col-md-6">
                                <input type="email" class="form-control" id="edit_username" name="edit_username" value="<?php echo $_SESSION["username"] ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="edit_verifyusername" class="col-md-4 control-label">Verify Username</label>
                            <div class="col-md-6">
                                <input type="email" class="form-control" id="edit_verifyusername" name="edit_verifyusername" value="<?php echo $_SESSION["username"] ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="edit_phonenum" class="col-md-4 control-label">Phone number</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" id="edit_phonenum" name="edit_phonenum" value="<?php echo $_SESSION["phone_num"] ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="edit_dob" class="col-md-4 control-label">Date of Birth</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" id="edit_dob" name="edit_dob" value="<?php echo $_SESSION["dob"] ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="currentacc" class="col-md-4 control-label">Current Password</label>
                            <div class="col-md-6">
                                <input type="password" class="form-control" id="currentacc" name="currentacc" value="">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="newpw" class="col-md-4 control-label">New Password</label>
                            <div class="col-md-6">
                                <input type="password" class="form-control" id="newpw" name="newpw" value="">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="verpw" class="col-md-4 control-label">Verify New Password</label>
                            <div class="col-md-6">
                                <input type="password" class="form-control" id="verpw" name="verpw" value="">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <div class="btn-group" role="group" aria-label="...">
                                <button id="cancelsite" type="button" data-dismiss="modal" data-target="#UpdateDetailsModal" class="btn btn-default">Cancel</button>
                                <input class="btn btn-primary" type="submit" value="Update" id="postvalues">
                            </div>
                        </div>
                        <input type="hidden" name="edit_ircnick_oem" id="edit_ircnick_oem" value="<?php echo $_SESSION["irc_nick"] ?>">
                        <input type="hidden" name="edit_username_oem" id="edit_username_oem" value="<?php echo $_SESSION["username"] ?>">
                    </form>
                </div>

            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title"><b>Profile</b></h3>
                    </div>
                    <div class="panel-body">
                        <form class="form-horizontal">
                            <!-- Display the user's profile -->
                            <div class="form-group">
                                <label for="name" class="col-md-4 control-label">Name</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" id="name" value="<?php echo $_SESSION["firstName"] ?>" readonly>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="surname" class="col-md-4 control-label">Surname</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" id="surname" value="<?php echo $_SESSION["lastName"] ?>" readonly>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="ircnick" class="col-md-4 control-label">IRCNick</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" id="ircnick" value="<?php echo $_SESSION["irc_nick"] ?>" readonly>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="username" class="col-md-4 control-label">Username</label>
                                <div class="col-md-6">
                                    <input type="email" class="form-control" id="username" value="<?php echo $_SESSION["username"] ?>" readonly>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="maxsites" class="col-md-4 control-label">Max Sites</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" id="maxsites" value="<?php echo $_SESSION["max_sites"] ?>" readonly>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="phonenum" class="col-md-4 control-label">Phone number</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" id="phonenum" value="<?php echo $_SESSION["phone_num"] ?>" readonly>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="dob" class="col-md-4 control-label">Date of Birth</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" id="dob" value="<?php echo $_SESSION["dob"] ?>" readonly>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="joindate" class="col-md-4 control-label">Join date</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" id="joindate" value="<?php echo $_SESSION["join_date"] ?>" readonly>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="accountstatus" class="col-md-4 control-label">Account Status</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" id="accountstatus" value="<?php echo $_SESSION["acc_status"] ?>" readonly>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="mancom_account_nr" class="col-md-4 control-label">MANCOM Account number</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" id="mancom_account_nr" value="<?php echo $_SESSION["mancom_account_nr"] ?>" readonly>
                                </div>
                            </div>
                        </form>
                        <?php if (isValueInRoleArray($_SESSION["roles"], "readonly")) { ?>
                        <p class="text-center"><button class="btn btn-primary disabled" class="dropdown-toggle" ><b>Update details</b></button></p>
                        <?php } else { ?>
                        <p class="text-center"><button class="btn btn-primary" class="dropdown-toggle" data-toggle="modal" data-target='#UpdateDetailsModal'><b>Update details</b></button></p>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title"><b>Assigned user role(s)</b></h3>
                    </div>
                    <table id='user_roles_table' data-url="/content/wugms.table.user.roles.php" data-toggle="table" data-classes="table table-hover table-condensed" data-striped="true">
                        <thead>
                            <tr>
                                <th data-formatter="runningFormatter">#</th>
                                <th data-field="roll_id" data-sortable="true">Role</th>
                                <th data-field="comment" data-sortable="true">Description</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <h3 class="panel-title"><b>Payments made</b></h3>
                    </div>
                    <table id='user_roles_table' data-url="/content/wugms.table.user.payments.php" data-toggle="table" data-classes="table table-hover table-condensed" data-striped="true">
                        <thead>
                            <tr>
                                <th data-formatter="runningFormatter">#</th>
                                <th data-field="pdate" data-sortable="true">Date</th>
                                <th data-field="idpayment_type" data-sortable="true">Type</th>
                                <th data-field="idpayment_method" data-sortable="true">Method</th>
                                <th data-field="comment" data-sortable="true">Comment</th>
                                <th data-field="amount" data-sortable="true">Amount</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>