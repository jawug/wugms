<body>
    <div class="pagetitle" id="page_adm_rb_man"> </div>	
    <!-- Help modal -->
    <div class="modal fade"  id="myHelpModal" >
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Help - SSID</h4>
                </div>
                <div class="modal-body">
                    <p>This page displays the wifi connections back to the routerboard, consider this data the "opposite" end of an AP. </p>
                    <p>The selector displays data based on the user's equipment and sites.</p>
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
                    <li><a href="../"><img src="/images/switch.png" alt="..." class="img-rounded" width="24" height="24"> Routerboard Management </a></li>
                    <li><a href="../conrev"><img src="/images/folder_network.png" alt="..." class="img-rounded" width="24" height="24"> Config Review </a></li>
                    <li class="active"><a href="#"><img src="/images/ip_pyramid.png" alt="..." class="img-rounded" width="24" height="24"> IPv4 Assignments </a></li>
                    <li><a href="../bgp"><img src="/images/arrow_switch-128.png" alt="..." class="img-rounded" width="24" height="24"> BGP Assignments </a></li>
                    <li><a href="../remcmd"><img src="/images/settings.png" alt="..." class="img-rounded" width="24" height="24"> Remote Commands </a></li>
                    <li><a href="../rbassign"><img src="/images/stock_task_assigned_to.png" alt="..." class="img-rounded" width="24" height="24"> Routerboard Allocation </a></li>
                </ul>
            </div>
            <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main" id="header">
            </div>
        </div>
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main" id="header">
            <div class="panel panel-default">
                <div class="panel-heading"><img src="/images/ip_pyramid.png" alt="..." class="img-rounded" width="24" height="24"> <b>Configured IP Addresses (IPv4)</b></div>
                <table id='ssid_client_table' data-url="/content/wugms.table.admin.rb.ipv4.all.php" data-toggle="table" data-classes="table table-hover table-condensed" data-striped="true" data-show-columns="true" data-filter-control="true" >
                    <thead>
                        <tr>
                            <th data-field="ipv4" data-sortable="true" data-filter-control="input">Address</th>
                            <th data-field="device_name" data-sortable="true" data-filter-control="input">Device Identity</th>
                            <th data-field="interface" data-sortable="true" data-filter-control="input">Interface</th>
                            <th data-field="addressStr" data-sortable="true" data-filter-control="input">Full Address</th>
                            <th data-field="network" data-sortable="true" data-filter-control="input"data-visible="false">Network</th>
                            <th data-field="maskbits" data-sortable="true" data-filter-control="input"data-visible="false">Maskbits</th>
                            <th data-field="status" data-sortable="true" data-filter-control="input">Status</th>
                            <th data-field="comment" data-sortable="true" data-filter-control="input">Comment</th>
                            <th data-field="device_model" data-sortable="true" data-filter-control="input">Device Model</th>
                            <th data-field="rdns" data-sortable="true" data-filter-control="input">Reverse DNS Entry</th>
                            <th data-field="sitename" data-sortable="true" data-filter-control="input">Sitename</th>
                        </tr>
                    </thead>
                </table>
                <!--         </div> -->
            </div>
            <!--     </div> -->
        </div>
    </div>