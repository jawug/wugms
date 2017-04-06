<div class="pagetitle" id="page_adm_users"> </div>
<!-- New user modal -->
<div class="modal fade" id="NewUserModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form id="userForm" method="post" enctype="multipart/form-data" class="form-horizontal" action="">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title">New user details</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label class="col-sm-3 control-label">First name</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="firstName" name="firstName" placeholder="First name">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label">Last name</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="lastName" name="lastName" placeholder="Last name" />
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label">IRC Nick</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="ircnick" name="ircnick" placeholder="IRC Nick" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label">Phone</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="phone" name="phone" placeholder="+27000000000" value="+27000000000" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label">Email</label>
                        <div class="col-sm-8">
                            <input type="email" class="form-control" id="email" name="email" placeholder="Email address" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label">Verify email</label>
                        <div class="col-sm-8">
                            <input type="email" class="form-control" id="verifyemail" name="verifyemail" placeholder="Email verification" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="dob" class="col-sm-3 control-label">Date of Birth</label>
                        <div class="col-sm-5">
                            <div class="input-group input-append date" id="dateRangePicker">
                                <input type="text" class="form-control" id="dob" name="dob" />
                                <span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <div class="btn-group" role="group" aria-label="...">
                        <button id="cancelnewpatment" type="button" data-dismiss="modal" data-target="#NewUserModal" class="btn btn-default">Cancel</button>
                        <input class="btn btn-success" type="submit" value="Create" id="postvalues">
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Edit user modal -->
<div class="modal fade" id="EditUserModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2" aria-hidden="true">
    <div class="modal-dialog">
        <form id="EditUserForm" method="post" enctype="multipart/form-data" class="form-horizontal" action="">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title">Edit user details</h4>
                </div>
                <div class="modal-body">

                    <div class="form-group">
                        <label class="col-sm-3 control-label">First name</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="editfirstName" name="editfirstName" placeholder="First name" />
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label">Last name</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="editlastName" name="editlastName" placeholder="Last name" />
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label">IRC Nick</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="editircnick" name="editircnick" placeholder="IRC Nick" />
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label">Phone</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="editphone" name="editphone" placeholder="+27000000000" />
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label">Email</label>
                        <div class="col-sm-6">
                            <input type="email" class="form-control" id="editemail" name="editemail" placeholder="Email address" />
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label">Verify email</label>
                        <div class="col-sm-6">
                            <input type="email" class="form-control" id="editverifyemail" name="editverifyemail" placeholder="Email verification" />
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="editdob" class="col-sm-3 control-label">Date of Birth</label>
                        <div class="col-sm-6">
                            <div class="input-group input-append date" id="editdateRangePicker">
                                <input type="text" class="form-control" id="editdob" name="editdob" />
                                <span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-3">Account Status</label>
                        <div class="col-sm-7">
                            <select required="required" class="form-control combobox" id="editaccstatus" name="editaccstatus">
                                <option value="" selected="selected">Select account status...</option>
                                <option value="active">Active</option>
                                <option value="banned">Banned</option>
                                <option value="disabled">Disabled</option>
                                <option value="lostpassword">Lost Password</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="height" class="col-sm-3 control-label">Comment</label>
                        <div class="col-sm-8">
                            <textarea class="form-control" id="editcomment" name="editcomment" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Max Sites</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="editmaxsites" name="editmaxsites" placeholder="5" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">User roles</label>
                        <div class="col-sm-6">
                            <div class="checkbox">
                                <label>
                                    <input id="userlevel" name="userlevel" type="checkbox" value="checked" disabled="disabled">User
                                </label>
                            </div>
                            <div class="checkbox">
                                <label>
                                    <input id="readonlylevel" name="readonlylevel" type="checkbox" value="">Readonly
                                </label>
                            </div>

                            <div class="checkbox">
                                <label>
                                <input id="adminlevel" name="adminlevel" type="checkbox" value="">Admin
                                </label>
                            </div>

                            <div class="checkbox">
                                <label>
                                    <input id="mancomlevel" name="mancomlevel" type="checkbox" value="" disabled="disabled">MANCOM
                                </label>
                            </div>

                            <div class="checkbox">
                                <label>
                                    <input id="betalevel" name="betalevel" type="checkbox" value="">Beta
                                </label>
                            </div>
                        </div>
                    </div>

                    <input type="hidden" name="edit_user_oem_user_id" id="edit_user_oem_user_id" value="">
                    <input type="hidden" name="edit_user_oem_irc_nick" id="edit_user_oem_irc_nick" value="">
                    <input type="hidden" name="edit_user_oem_email" id="edit_user_oem_email" value="">
                    <input type="hidden" name="readonlylevel_val" id="readonlylevel_val" value="">
                    <input type="hidden" name="adminlevel_val" id="adminlevel_val" value="">
                    <input type="hidden" name="betalevel_val" id="betalevel_val" value="">
                </div>
                <div class="modal-footer">
                    <div class="btn-group" role="group" aria-label="...">
                        <button id="canceleditpayment" type="button" data-dismiss="modal" data-target="#EditPaymentModal" class="btn btn-default">Cancel</button>
                        <input class="btn btn-primary" type="submit" value="Update" id="postvalues">
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>


<div class="modal fade" id="DeletePaymentModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel3" aria-hidden="true">
    <div class="modal-dialog">
        <form id="DeleteuserForm" method="post" enctype="multipart/form-data" class="form-horizontal" action="">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title">Delete payment entry</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="duser" class="col-sm-5 control-label">User</label>
                        <div class="col-sm-6">
                            <input class="form-control" name="duser" id="duser" type="text" readonly="readonly">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="ddate" class="col-sm-5 control-label">Date</label>
                        <div class="col-sm-6">
                            <input class="form-control" name="ddate" id="ddate" type="text" readonly="readonly">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="dmethod" class="col-sm-5 control-label">Payment Method</label>
                        <div class="col-sm-6">
                            <input class="form-control" name="dmethod" id="dmethod" type="text" readonly="readonly">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="dtype" class="col-sm-5 control-label">Payment Type</label>
                        <div class="col-sm-6">
                            <input class="form-control" name="dtype" id="dtype" type="text" readonly="readonly">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="damount" class="col-sm-5 control-label">Amount</label>
                        <div class="col-sm-6">
                            <input class="form-control" name="damount" id="damount" type="text" readonly="readonly">
                        </div>
                    </div>

                    <div class="alert alert-danger" role="alert">
                        <div class="form-group">
                            <div class="checkbox col-sm-8 control-label">
                                <label>
                                    <input type="checkbox" name="confirmdelete" id="confirmdelete"> <b>Confirm deletion of payment</b>
                                </label>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="delete_paymentid" id="delete_paymentid" value="">
                    <div class="alert alert-danger" role="alert">
                        <p class="text-center"><b>Warning you are about to delete a payment entry.</b></p>
                        <p class="text-center"><b>Once the deletion has taken place there is no going back.</b></p>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="btn-group" role="group" aria-label="...">
                        <button id="canceldeletepayment" type="button" data-dismiss="modal" data-target="#DeletePaymentModal" class="btn btn-default">Cancel</button>
                        <input class="btn btn-danger" type="submit" value="Delete" id="postvalues">
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Help modal -->
<div class="modal fade" id="myHelpModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Help - Overview</h4>
            </div>
            <div class="modal-body">
                <p>This page allows admins to create and edit user accounts.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid">
    <div class="row">
        <div class="col-sm-3 col-md-2 sidebar">
            <ul class="nav nav-sidebar">
                <li><a href="../">Overview</a></li>
                <li class="active"><a href="#">Users <span class='glyphicon glyphicon-edit' aria-hidden='true'></span></a></li>
                <li><a href="../audit">Audit <span class='glyphicon glyphicon-check' aria-hidden='true'></span></a></li>
            </ul>
        </div>
        <div class="col-sm-8 col-sm-offset-3 col-md-10 col-md-offset-2 main" id="header">
            <h1 class="page-header">Users</h1>
            <div align="center">
                <p> Shown below is the user list. </p>
            </div>
<!--            <div class="btn-group" role="group" aria-label="...">
                <button id='NewUserModalBtn' type='button' data-toggle='modal' data-target='#NewUserModal' class='btn btn-success'>Add new user</button>
            </div> -->
        </div>
        <div class="col-sm-8 col-sm-offset-3 col-md-10 col-md-offset-2 main" id="header">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h2 class="panel-title"><b>Users</b></h2>
                </div>
                <div id="toolbar_new_user" class="btn-group">
                    <button id='NewUserModalBtn' type="button" class="btn btn-success" data-toggle="modal" data-target="#NewUserModal" >
                        <i class="glyphicon glyphicon-plus"></i>
                    </button>
                </div>
                <table id='user_table' data-url="/content/wugms.table.admin.users.php" data-toggle="table" data-classes="table table-hover" data-striped="true" data-search="true" data-toolbar="#toolbar_new_user">
                    <thead>
                        <tr>
                            <th data-formatter="runningFormatter">#</th>
                            <th data-field="firstName" data-sortable="true">Name</th>
                            <th data-field="lastName" data-sortable="true">Surname</th>
                            <th data-field="irc_nick" data-sortable="true">IRC Nick</th>
                            <th data-field="username" data-sortable="true">Username</th>
                            <th data-field="max_sites" data-sortable="true">Max Sites</th>
                            <th data-field="roles" data-sortable="true">Assigned Roles</th>
                            <th data-field="acc_status" data-sortable="true">Account Status</th>
                            <th data-field="cdate" data-sortable="true">Register Date</th>
                            <th data-field="actions" data-formatter="actionFormatter" data-events="actionEvents" data-sortable="true" data-align="center" data-width="200px">Actions</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>