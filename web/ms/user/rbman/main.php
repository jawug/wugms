<div class="pagetitle" id="page_usr_rb_man"> </div>
<!-- Help modal -->
<div class="modal fade"  id="myHelpModal" >
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Help - Overview</h4>
            </div>
            <div class="modal-body">
                <p>This is the landing page for the "My Dashboards" section of WUGMS.
                    It lists all of the "core network devices" that are attributed to the logged in user.</p>
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
                <li class="active"><a href="#"><img src="/images/switch.png" alt="..." class="img-rounded" width="24" height="24"> My Routerboard Management </a></li>
                <li><a href="conrev"><img src="/images/folder_network.png" alt="..." class="img-rounded" width="24" height="24"> Config Review </a></li>
                <li><a href="ipv4"><img src="/images/ip_pyramid.png" alt="..." class="img-rounded" width="24" height="24"> IPv4 Assignments </a></li>
                <li><a href="remcmd"><img src="/images/settings.png" alt="..." class="img-rounded" width="24" height="24"> Remote Commands </a></li>
            </ul>
        </div>
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main" id="header">
            <h1 class="page-header">Overview</h1>
            <div align="center">
                <p> These dashboards are designed in order to provide you, the user, with the means to review the performance of your core network devices that are connected to the JAWUG network </p>
                <p> The dashboards only work is you have enabled snmp on your equipment so that the wugms node servers can poll for information. </p>
            </div>
        </div>
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main" id="header">
            <div class="panel panel-primary">
                <div class="panel-heading"><b>My devices</b></div>
                <table id='ssid_ap_table' data-url="/content/wugms.table.user.devices.php" data-toggle="table" data-classes="table table-hover table-condensed" data-striped="true" >
                    <thead>
                        <tr>
                            <th data-formatter="runningFormatter">#</th>
                            <th data-field="sitename" data-sortable="true">Site</th>
                            <th data-field="device_name" data-sortable="true">Device name</th>
                            <th data-field="device_make" data-sortable="true">Make</th>
                            <th data-field="device_model" data-sortable="true">Model</th>
                            <th data-field="os_ver" data-sortable="true">OS ver</th>
                            <th data-field="seen_rbcp" data-sortable="true">Last seen by RBCP</th>
                            <th data-field="seen_snmp" data-sortable="true">Last seen by SNMP</th>
                        </tr>
                    </thead>
                </table>
            </div>		
        </div>				
    </div>		
</div>