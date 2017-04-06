<div class="pagetitle" id="page_ms"> </div> 
<div class="container-fluid theme-showcase" role="main">
    <div id="main_section" class="container-fluid">
        <div class="row">
            <div class="col-md-4">
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <h3 class="panel-title"><b>Last users</b></h3>
                    </div>
                    <table id='users_login_table' data-url="/content/wugms.table.ms.users.login.php" data-toggle="table" data-classes="table table-hover table-condensed" data-striped="true" data-card-view="false" data-show-header="false" >
                        <thead>
                            <tr>
                                <th data-field="login_time" data-sortable="true">Date</th>
                                <th data-field="user" data-sortable="true">User</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
            <div class="col-md-4">
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <h3 class="panel-title"><b>Spare so far</b></h3>
                    </div>
                    <div class="panel-body">
                        Panel content
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <h3 class="panel-title"><b>Spare so far</b></h3>
                    </div>
                    <div class="panel-body">
                        Panel content
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-warning">
                    <div class="panel-heading">
                        <h3 class="panel-title"><b>WUGMS Node(s) Status</b></h3>
                    </div>
                    <table id='nodes_table' data-url="/content/wugms.table.nodes.php" data-toggle="table" data-classes="table table-hover table-condensed" data-striped="true" data-card-view="false" data-show-header="true">
                        <thead>
                            <tr>
                                <th data-field="seen" data-sortable="true">Date</th>
                                <th data-field="Descr" data-sortable="true">Description</th>
                                <th data-field="InOctets" data-sortable="true">In Bytes</th>
                                <th data-field="OutOctets" data-sortable="true">Out Bytes</th>
                                <th data-field="InUcastPkts" data-sortable="true">InUcastPkts</th>
                                <th data-field="OutUcastPkts" data-sortable="true">OutUcastPkts</th>
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
                        <h3 class="panel-title"><b>Last SNMP data parsed, last day</b></h3>
                    </div>
                    <table id='snmp_parsed_last_day_table' data-url="/content/wugms.table.ms.snmp.parsed.last.day.php" data-toggle="table" data-classes="table table-hover table-condensed" data-striped="true" data-card-view="false" data-show-header="true" data-pagination="true" data-height="420" data-search="true" >
                        <thead>
                            <tr>
                                <th data-field="snmp_seen" data-sortable="true">Date</th>
                                <th data-field="device_description" data-sortable="true">Description</th>
                                <th data-field="ros" data-sortable="true">ROS</th>
                                <th data-field="firmware" data-sortable="true">Firmware</th>
                                <th data-field="uptime" data-sortable="true">Uptime</th>
                                <th data-field="sitename" data-sortable="true">Site</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-danger">
                    <div class="panel-heading">
                        <h3 class="panel-title"><b>Last SNMP data parsed > last day</b></h3>
                    </div>
                    <table id='snmp_parsed_older_tables' data-url="/content/wugms.table.ms.snmp.parsed.older.php" data-toggle="table" data-classes="table table-hover table-condensed" data-striped="true" data-card-view="false" data-show-header="true" data-pagination="true" data-height="420" data-search="true" >
                        <thead>
                            <tr>
                                <th data-field="snmp_seen" data-sortable="true">Date</th>
                                <th data-field="device_description" data-sortable="true">Description</th>
                                <th data-field="ros" data-sortable="true">ROS</th>
                                <th data-field="firmware" data-sortable="true">Firmware</th>
                                <th data-field="uptime" data-sortable="true">Uptime</th>
                                <th data-field="sitename" data-sortable="true">Site</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div> <!-- /container -->
</div>
