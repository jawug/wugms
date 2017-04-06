<div class="pagetitle" id="page_us"> </div> 
<div class="container-fluid theme-showcase" role="main">
    <!-- modal start -->
    <div class="modal fade" id="myHelpModal" >
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Help - User Stats</h4>
                </div>
                <div class="modal-body">
                    <p>This page show basic stats with regards to user activity .</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <!-- modal end -->
    <div class="container-fluid">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h2 class="panel-title text-center"><b>User Stats</b> <img src="../images/user_group.png" alt="..." class="img-rounded" width="24" height="24"></h2>
                </div>
                <div class="row">		
                    <div class="col-md-12">
                        <div class="panel-group" id="accordion">
                            <div class="panel panel-primary">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <a data-toggle="collapse" data-parent="#accordion" href="#collapse1"><b>Latest users </b> <img src="../images/users.png" alt="..." class="img-rounded" width="24" height="24"></a>
                                    </h4>
                                </div>
                                <div id="collapse1" class="panel-collapse collapse in">
                                    <table id='users_table' data-url="/content/wugms.us.users.php" data-toggle="table" data-classes="table table-hover table-condensed" data-striped="true" >
                                        <thead>
                                            <tr>
                                                <th data-formatter="runningFormatter">#</th>
                                                <th data-field="user" data-sortable="true">User</th>
                                                <th data-field="join_date" data-sortable="true">Join Date</th>
                                                <th data-field="used_sites" data-sortable="true">Used Sites</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                            <div class="panel panel-info">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <a data-toggle="collapse" data-parent="#accordion" href="#collapse2"><b>Recently Activated Sites</b> <img src="../images/active_site.png" alt="..." class="img-rounded" width="24" height="24"></a>
                                    </h4>
                                </div>
                                <div id="collapse2" class="panel-collapse collapse">
                                    <table id='aites_table' data-url="/content/wugms.us.active.sites.php" data-toggle="table" data-classes="table table-hover table-condensed" data-striped="true" >
                                        <thead>
                                            <tr>
                                                <th data-formatter="runningFormatter">#</th>
                                                <th data-field="sitename" data-sortable="true">Site</th>
                                                <th data-field="user" data-sortable="true">User</th>
                                                <th data-field="model" data-sortable="true">RB Model</th>
                                                <th data-field="ros" data-sortable="true">ROS</th>
                                                <th data-field="active_date" data-sortable="true">Activation Date</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                            <div class="panel panel-warning">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <a data-toggle="collapse" data-parent="#accordion" href="#collapse3"><b>Sites still in planning phase</b> <img src="../images/planning_site.png" alt="..." class="img-rounded" width="24" height="24"></a>
                                    </h4>
                                </div>
                                <div id="collapse3" class="panel-collapse collapse">
                                    <table id='sites_planning_table' data-url="/content/wugms.us.planning.sites.php" data-toggle="table" data-classes="table table-hover table-condensed" data-striped="true" >
                                        <thead>
                                            <tr>
                                                <th data-formatter="runningFormatter">#</th>
                                                <th data-field="sitename" data-sortable="true">Site</th>
                                                <th data-field="suburb" data-sortable="true">Suburb</th>										
                                                <th data-field="site_owner" data-sortable="true">Site Owner</th>
                                                <th data-field="cdate" data-sortable="true">Registered Date</th>
                                                <th data-field="mdate" data-sortable="true">Last Modified</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div> 
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>