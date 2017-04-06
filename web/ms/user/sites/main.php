<div class="pagetitle" id="page_usr_sites"> </div>
 <?php 
 if (!isValueInRoleArray($_SESSION["roles"], "readonly")) { ?>
<!-- New site modal -->
<div class="modal fade" id="NewSiteModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"> 
    <div class="modal-dialog">
        <form id="siteForm" method="post" enctype="multipart/form-data" class="form-horizontal" action=""> 
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title">New site details</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="site_name" class="col-sm-3 control-label">Name</label>
                        <div class="col-sm-5">
                            <input class="form-control" name="site_name" placeholder="Enter unique site name" type="text">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="longitude" class="col-sm-3 control-label">Longitude</label>
                        <div class="col-sm-5">
                            <input class="form-control" name="longitude" placeholder="27.00000000" type="text">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="latitude" class="col-sm-3 control-label">Latitude</label>
                        <div class="col-sm-5">
                            <input class="form-control" name="latitude" placeholder="-26.00000000" type="text">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="height" class="col-sm-3 control-label">Height</label>
                        <div class="col-sm-5">
                            <input class="form-control" name="height" placeholder="4" type="text">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-3">Suburb</label>
                        <div class="col-sm-7">
                            <select required="required" class="form-control combobox" id="suburb" name="suburb" >
                                <option value="" selected="selected">Select suburb...</option>
                                <option value="not_listed">**Not Listed**</option>
                                <?php
                                /* Set up the SQL query */
                                $subquery = "SELECT name 'suburb', name 'suburb_id' FROM wugms.tbl_base_suburbs;";
                                /* Prepare the SQL for execute */
                                $substmt = $db->prepare($subquery);
                                /* Execute the query */
                                if ($substmt->execute()) {
                                    $subresult = $substmt->fetchAll(PDO::FETCH_ASSOC);
                                }
                                /* Display the returned row(s) */
                                foreach ($subresult as $row) {
                                    echo "<option value='" . $row['suburb_id'] . "'>" . $row['suburb'] . "</option>";
                                }
                                ?>	
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="btn-group" role="group" aria-label="...">
                        <button id="cancelsite" type="button" data-dismiss="modal" data-target="#NewSiteModal" class="btn btn-default">Cancel</button>
                        <input class="btn btn-success" type="submit" value="Create" id="postvalues">
                    </div>			
                </div>
            </div>
        </form> 
    </div>
</div>

<!-- Edit site modal -->
<div class="modal fade" id="EditSiteModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2" aria-hidden="true"> 
    <div class="modal-dialog">
        <form id="EditsiteForm" method="post" enctype="multipart/form-data" class="form-horizontal" action=""> 
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title">Edit site details</h4>
                </div>
                <div class="modal-body" id="Edit_modal_body">
                    <div class="form-group">
                        <label for="edit_site_name" class="col-sm-3 control-label">Name</label>
                        <div class="col-sm-5" >
                            <input class="form-control" name="edit_site_name" id="edit_site_name" placeholder="Enter unique site name" type="text">
                            <input class="form-control" name="Editsite_name_oem" id="edit_site_name_oem" type="hidden" value="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="edit_longitude" class="col-sm-3 control-label">Longitude</label>
                        <div class="col-sm-5">
                            <input class="form-control" name="edit_longitude" id="edit_longitude" placeholder="27.00000000" type="text">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="edit_latitude" class="col-sm-3 control-label">Latitude</label>
                        <div class="col-sm-5">
                            <input class="form-control" name="edit_latitude" id="edit_latitude" placeholder="-26.00000000" type="text">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="edit_height" class="col-sm-3 control-label">Height</label>
                        <div class="col-sm-5">
                            <input class="form-control" name="edit_height" id="edit_height" placeholder="4" type="text">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-3">Suburb</label>
                        <div class="col-sm-7">
                            <select required="required" class="form-control combobox" id="edit_suburb" name="edit_suburb" >
                                <option value="" selected="selected">Select suburb...</option>
                                <option value="not_listed">**Not Listed**</option>
                                <?php
                                /* Set up the SQL query */
                                $subquery = "SELECT name 'suburb', name 'suburb_id' FROM wugms.tbl_base_suburbs;";
                                /* Prepare the SQL for execute */
                                $substmt = $db->prepare($subquery);
                                /* Execute the query */
                                if ($substmt->execute()) {
                                    $subresult = $substmt->fetchAll(PDO::FETCH_ASSOC);
                                }
                                /* Display the returned row(s) */
                                foreach ($subresult as $row) {
                                    echo "<option value='" . $row['suburb_id'] . "'>" . $row['suburb'] . "</option>";
                                }
                                ?>	
                            </select>
                        </div>
                    </div>
                    <input type="hidden" name="edit_siteid" id="edit_siteid" value="">
                </div>
                <div class="modal-footer">
                    <div class="btn-group" role="group" aria-label="...">
                        <button id="canceleditsite" type="button" data-dismiss="modal" data-target="#EditSiteModal" class="btn btn-default">Cancel</button>
                        <input class="btn btn-primary" type="submit" value="Update" id="postvalues">
                    </div>
                </div>
            </div>
        </form> 
    </div>
</div>

<!-- Delete site modal -->
<div class="modal fade" id="DeleteSiteModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel3" aria-hidden="true"> 
    <div class="modal-dialog">
        <form id="DeletesiteForm" method="post" enctype="multipart/form-data" class="form-horizontal" action=""> 
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title">Delete site</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="delete_site_name" class="col-sm-5 control-label">Site name</label>
                        <div class="col-sm-6">
                            <input class="form-control" name="delete_site_name" id="delete_site_name" type="text" readonly="readonly" >
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="delete_suburb" class="col-sm-5 control-label">Suburb</label>
                        <div class="col-sm-6">
                            <input class="form-control" name="delete_suburb" id="delete_suburb" type="text" readonly="readonly" >
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="delete_longitude" class="col-sm-5 control-label">Longitude</label>
                        <div class="col-sm-6">
                            <input class="form-control" name="delete_longitude" id="delete_longitude" type="text" readonly="readonly" >
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="delete_latitude" class="col-sm-5 control-label">Latitude</label>
                        <div class="col-sm-6">
                            <input class="form-control" name="delete_latitude" id="delete_latitude" type="text" readonly="readonly" >
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="delete_height" class="col-sm-5 control-label">Height</label>
                        <div class="col-sm-6">
                            <input class="form-control" name="delete_height" id="delete_height" type="text" readonly="readonly" >
                        </div>
                    </div>	

                    <div class="alert alert-danger" role="alert">
                        <div class="form-group">
                            <div class="checkbox col-sm-8 control-label"> 
                                <label>
                                    <input type="checkbox" name="confirmdelete" id="confirmdelete"> <b>Confirm deletion of site</b>
                                </label>
                            </div> 
                        </div>
                    </div>
                    <input type="hidden" name="delete_siteid" id="delete_siteid" value="">
                    <input type="hidden" name="delete_sitename" id="delete_sitename" value="">
                    <div class="alert alert-danger" role="alert">
                        <p class="text-center" ><b>Warning you are about to delete a site entry.</b></p>
                        <p class="text-center" ><b>Any network devices allocated to this site will become "unassigned".</b></p>
                        <p class="text-center" ><b>Once the deletion has taken place there is no going back.</b></p>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="btn-group" role="group" aria-label="...">
                        <button id="canceldeletesite" type="button" data-dismiss="modal" data-target="#DeleteSiteModal" class="btn btn-default">Cancel</button>
                        <input class="btn btn-danger" type="submit" value="Delete" id="postvalues">
                    </div>
                </div>
            </div>
        </form> 
    </div>
</div>
 <?php } ?>
<!-- Help modal -->
<div class="modal fade" id="myHelpModal" >
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Help - Overview</h4>
            </div>
            <div class="modal-body">
                <p>This page shows all the functions that a user needs in order to create and manage their sites.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" data-dismiss="modal">Close</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="container-fluid theme-showcase" role="main">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h2 class="panel-title"><b>My Sites</b></h2>
        </div>		
        <div class="row">
            <div class="col-md-12" id="header">
                <div class="panel panel-default">
                    <div align="center">
                        Registered sites: <b><?php echo $_SESSION["used_sites"]; ?></b> / Max sites: <b><?php echo $_SESSION["max_sites"]; ?></b> <br>
                        Shown below are the current sites per your account. <br>
                        Please note that no additional sites can be created if you have already used you allocated "max sites".
                    </div>
                </div>
                
                <?php
                /* Check if the user can add more sites */
                if (($_SESSION["used_sites"] < $_SESSION["max_sites"]) or (!isValueInRoleArray($_SESSION["roles"], "readonly"))) {
                    echo "<button id='NewSiteModalBtn' type='button' data-toggle='modal' data-target='#NewSiteModal' class='btn btn-success'>Create new site</button>";
                } else {
                    echo "<div class='alert alert-warning' role='alert'>You've used the maximum allocated sites <b>'" . $_SESSION["max_sites"] . "'</b> assigned for your account. Either delete a site not in use or else ask the admins to increase the maximum allocated sites for your account.</div>";
                }
                ?>
                <br>
                <br>

            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h2 class="panel-title"><b>Site(s)</b></h2>
                    </div>
                    <table id='user_accounts_table' data-url="/content/wugms.table.user.sites.php" data-toggle="table" data-classes="table table-hover" data-striped="true" data-search="true" data-show-toggle="true" >
                        <thead>
                            <tr>
                                <th data-formatter="runningFormatter">#</th>
                                <th data-field="Name" data-sortable="true">Site name</th>
                                <th data-field="suburb" data-sortable="true">Suburb</th>
                                <th data-field="longitude" data-sortable="true">Longitude</th>
                                <th data-field="latitude" data-sortable="true">Latitude</th>
                                <th data-field="height" data-sortable="true">Height</th>
                                <th data-field="CDate" data-sortable="true">Date Added</th>
                                <th data-field="MDate" data-sortable="true">Last Modified</th>
                                <th data-field="actions" data-formatter="actionFormatter" data-events="actionEvents" data-sortable="true" data-align="center">Actions</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h2 class="panel-title"><b>Site changes (audit)</b></h2>
                    </div>
                    <table id='user_accounts_table' data-url="/content/wugms.table.user.sites.audit.php" data-toggle="table" data-classes="table table-hover" data-striped="true" data-search="true" data-show-toggle="true" data-pagination="false" >
                        <thead>
                            <tr>
                                <th data-formatter="runningFormatter">#</th>
                                <th data-field="user" data-sortable="true">User</th>
                                <th data-field="tdate" data-sortable="true">Date/Time</th>
                                <th data-field="level" data-sortable="true">Level</th>
                                <th data-field="action" data-sortable="true">Action</th>
                                <th data-field="msg" data-sortable="true">Changes</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>		
    </div>
</div>	