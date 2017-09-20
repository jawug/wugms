<!-- New users modal -->
<div class="modal fade" id="NewUserModal" tabindex="-1" role="dialog" aria-hidden="true"> 
    <div class="modal-dialog">
        <!--        <form id="NewUserForm" method="post" enctype="multipart/form-data" class="form-horizontal" action=""> -->
        <form id="NewUserForm" name="NewUserForm" class="form-horizontal" action="" > 
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span class='glyphicon glyphicon-remove' aria-hidden='true'></span></button>
                    <h4 class="modal-title"><img alt="Users" class='img-rounded' width='24' src="/images/user.svg"> New User</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="user_name" class="col-sm-3 control-label">First Name</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="user_name" name="user_name" placeholder="Name">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="user_surname" class="col-sm-3 control-label">Last Name</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="user_surname" name="user_surname" placeholder="Surname">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="user_email" class="col-sm-3 control-label">email Address</label>
                        <div class="col-sm-8">
                            <input type="email" class="form-control" id="user_email" name="user_email" placeholder="user.doe@somewhere.com">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="user_role_select" class="col-sm-3 control-label">Role</label>
                        <div class="col-sm-8">
                            <select style="width:100%" class="user_role_select form-control" name="user_role_select" id="user_role_select">
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="user_site_select" class="col-sm-3 control-label">Site</label>
                        <div class="col-sm-8">
                            <select style="width:100%" class="user_site_select form-control" name="user_site_select" id="user_site_select">
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="user_end_date" class="col-sm-3 control-label">Expiry date</label>
                        <div class="col-sm-8">
                            <div class='input-group input-append date' id='user_end_date_picker'>
                                <input type='text' class="form-control" name="user_end_date" id="user_end_date" />
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                            </div>
                        </div>
                    </div>
                    <?php if ($page_data->getSMTPUsage()) { ?>
                        <div class="form-group">
                            <label class="col-sm-3 control-label"> </label>
                            <div class="col-sm-8">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" id="send_activation" name="send_activation" > Send Activation email
                                    </label>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
                <div class="modal-footer">
                    <div class="btn-group" role="group" aria-label="...">
                        <button id="cancelnewuser" type="button" data-dismiss="modal" data-target="#NewUserModal" class="btn btn-default">Cancel</button>
                        <input class="btn btn-success" value="Create" name="submit" type="submit">
                    </div>
                </div>
            </div>
        </form> 
    </div>
</div>

<!-- Edit users modal -->
<div class="modal fade" id="EditUserModal" tabindex="-1" role="dialog" aria-hidden="true"> 
    <div class="modal-dialog">
        <form id="EditUserForm" method="post" enctype="multipart/form-data" class="form-horizontal" action=""> 
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span class='glyphicon glyphicon-remove' aria-hidden='true'></span></button>
                    <h4 class="modal-title"><img alt="Users" class='img-rounded' width='24' src="/images/edit.svg">Edit User</h4>
                </div>
                <div class="modal-body" id="Edit_modal_body">
                    <div class="form-group">
                        <label for="edit_user_name" class="col-sm-3 control-label">Name</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="edit_user_name" name="edit_user_name" placeholder="Name">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="edit_user_surname" class="col-sm-3 control-label">Surname</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="edit_user_surname" name="edit_user_surname" placeholder="Surname">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="edit_user_email" class="col-sm-3 control-label">email address</label>
                        <div class="col-sm-8">
                            <input type="email" class="form-control" id="edit_user_email" name="edit_user_email" placeholder="user.doe@somewhere.com">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="edit_user_role_select" class="col-sm-3 control-label">Role</label>
                        <div class="col-sm-8">
                            <select style="width:100%" class="edit_user_role_select form-control" name="edit_user_role_select" id="edit_user_role_select">
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="edit_user_site_select" class="col-sm-3 control-label">Site</label>
                        <div class="col-sm-8">
                            <select style="width:100%" class="edit_user_site_select form-control" name="edit_user_site_select" id="edit_user_site_select">
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="edit_user_status_select" class="col-sm-3 control-label">Status</label>
                        <div class="col-sm-8">
                            <select style="width:100%" class="edit_user_status_select form-control" name="edit_user_status_select" id="edit_user_status_select">
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="edit_user_end_date" class="col-sm-3 control-label">End date</label>
                        <div class="col-sm-8">
                            <div class='input-group input-append date' id='edit_user_end_date_picker'>
                                <input type='text' class="form-control" name="edit_user_end_date" id="edit_user_end_date" />
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="edit_user_id" id="edit_user_id" value="">
                    <input type="hidden" name="edit_user_email_oem" id="edit_user_email_oem" value="">
                </div>
                <div class="modal-footer">
                    <div class="btn-group" role="group" aria-label="...">
                        <button id="canceledituser" type="button" data-dismiss="modal" data-target="#EditUserModal" class="btn btn-default">Cancel</button>
                        <input class="btn btn-primary" type="submit" value="Update" id="edituser">
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- User Info modal -->
<div class="modal fade" id="UserLogInfoModal" tabindex="-1" role="dialog" aria-hidden="true"> 
    <div class="modal-dialog">
        <form id="UserInfoForm" method="post" enctype="multipart/form-data" class="form-horizontal" action=""> 
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span class='glyphicon glyphicon-remove' aria-hidden='true'></span></button>
                    <h4 class="modal-title"><img alt="Users" class='img-rounded' width='24' src="/images/info.svg">Last login details</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="user_date" class="col-sm-3 control-label">Date</label>
                        <div class="col-sm-8">
                            <text class="form-control" name="user_date" id="user_date" readonly></text>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="user_ip" class="col-sm-3 control-label">From IP address</label>
                        <div class="col-sm-8">
                            <text class="form-control" name="user_ip" id="user_ip" readonly></text>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="user_browser_agent" class="col-sm-3 control-label">Browser Agent</label>
                        <div class="col-sm-8">
                            <textarea class="form-control" name="user_browser_agent" id="user_browser_agent" rows="3" readonly></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="btn-group" role="group" aria-label="...">
                        <button id="okusers" type="button" data-dismiss="modal" data-target="#UserLogInfoModal" class="btn btn-default">Ok</button>
                    </div>
                </div>
            </div>
        </form> 
    </div>
</div>

<!-- User Password Update modal -->
<div class="modal fade" id="UserPasswdModal" tabindex="-1" role="dialog" aria-hidden="true"> 
    <div class="modal-dialog">
        <form id="UserPasswdForm" method="post" enctype="multipart/form-data" class="form-horizontal" action=""> 
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span class='glyphicon glyphicon-remove' aria-hidden='true'></span></button>
                    <h4 class="modal-title"><img alt="Users" class='img-rounded' width='24' src="/images/input.svg">Change User Password</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="user_passwd" class="col-sm-3 control-label">New Password</label>
                        <div class="col-sm-8">
                            <input type="password" class="form-control" id="user_passwd" name="user_passwd" placeholder="Surname">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="user_passwd_confirm" class="col-sm-3 control-label">Retype Password</label>
                        <div class="col-sm-8">
                            <input type="password" class="form-control" id="user_passwd_confirm" name="user_passwd_confirm" placeholder="Surname">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label"> </label>
                        <div class="col-sm-8">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" id="passwd_confirm" name="passwd_confirm" > Confirm password change
                                </label>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="passwd_user_id" id="passwd_user_id" value="">
                </div>
                <div class="modal-footer">
                    <div class="btn-group" role="group" aria-label="...">
                        <button id="canceluserpasswd" type="button" data-dismiss="modal" data-target="#UserPasswdModal" class="btn btn-default">Cancel</button>
                        <input class="btn btn-warning" value="Update Password" name="submit" type="submit">
                    </div>
                </div>
            </div>
        </form> 
    </div>
</div>