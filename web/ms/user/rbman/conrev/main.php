<body>
    <div class="pagetitle" id="page_usr_rb_man"> </div>	
    <!-- Help modal -->
    <div class="modal fade"  id="myHelpModal" >
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Help - Access Point (AP)</h4>
                </div>
                <div class="modal-body">
                    <p>The graphs on this page shows usage for the selected SSID. </p>
                    <p>The "selector" shows SSIDs where the user is either the owner or the equipment is located at the user's site. </p>
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
                    <li><a href="../"><img src="/images/switch.png" alt="..." class="img-rounded" width="24" height="24"> My Routerboard Management </a></li>
                    <li class="active"><a href="#"><img src="/images/folder_network.png" alt="..." class="img-rounded" width="24" height="24"> Config Review </a></li>
                    <li><a href="../ipv4"><img src="/images/ip_pyramid.png" alt="..." class="img-rounded" width="24" height="24"> IPv4 Assignments </a></li>
                    <li><a href="../remcmd"><img src="/images/settings.png" alt="..." class="img-rounded" width="24" height="24"> Remote Commands </a></li>
                </ul>
            </div>
            <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main" id="header">
                <div align="center">
                    <?php
                    /* Set up the SQL query */
                    $subquery = "
					SELECT device_make,
       device_model,
       os_ver,
       device_name,
       sitename,
       b.sn
  FROM (SELECT sn
          FROM (SELECT b.ae_Serial_Number 'sn'
                  FROM tbl_ae_sites_rbs b, tbl_base_sites a, tbl_base_sites c
                 WHERE     a.idSite_Owner = " . $_SESSION["id"] . "
                       AND b.ae_siteID = a.siteID
                       AND a.idSite_Owner = c.idSite_Owner) a
        UNION
        SELECT sn
          FROM (SELECT d.Serial_Number 'sn'
                  FROM tbl_base_rb_routerboard d
                 WHERE idSite_Owner = " . $_SESSION["id"] . ") b) AS a
       INNER JOIN (SELECT 'Mikrotik' AS 'device_make',
                          a.Board_model 'device_model',
                          a.OS_Version 'os_ver',
                          a.RB_identity 'device_name',
                          b.Name 'sitename',
                          a.Serial_Number 'sn'
                     FROM tbl_base_rb_routerboard a, tbl_base_sites b
                    WHERE a.siteID = b.siteID) AS b
          ON a.sn = b.sn
ORDER BY b.SiteName, b.device_name;";
                    /* Prepare the SQL for execute */
                    $substmt = $db->prepare($subquery);
                    /* Execute the query */
                    if ($substmt->execute()) {
                        $subresult = $substmt->fetchAll(PDO::FETCH_ASSOC);
                    }
                    ?>
                    <select style="width:100%" class="selector2_rb form-control" name="selector2_rb" id="selector2_rb">
                        <option value=""></option> 
                        <?php
                        /* Display the returned row(s) */
                        foreach ($subresult as $row) {
                            echo "<option value='" . $row['sn'] . "'>" . $row['sitename'] . "  -> " . $row['device_name'] . " [" . $row['device_model'] . "]" . "</option>";
                        }
                        ?>
                    </select>
                </div>
            </div>
        </div>
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main" id="header">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><div id="sel_device">No device selected</div></h3>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <b>RouterBoard Header</b>
                </div>
                <table id='rb_header_table' data-url="/content/wugms.table.user.rb.header.php" data-toggle="table" data-classes="table table-hover table-condensed" data-striped="true" data-card-view="true" >
                    <thead>
                        <tr>
                            <th data-field="Serial_Number">Serial Number</th>
                            <th data-field="Software_ID">License Key</th>
                            <th data-field="OS_Version">RBCP ROS</th>
                            <th data-field="Board_tech">Technology</th>
                            <th data-field="Board_model">Model</th>
                            <th data-field="firmware">Firmware</th>
                            <th data-field="RB_identity">Identity</th>
                            <th data-field="uptimestr">Uptime</th>
                            <th data-field="File_Date">Last RBCP</th>
                            <th data-field="Name">Sitename</th>
                            <th data-field="snmp_seen">SNMP Seen</th>
                            <th data-field="snmp_ros">SNMP ROS</th>
                        </tr>
                    </thead>
                </table>
            </div>
            <hr>
            <!-- table for connected clients -->
            <div class="panel-group" id="accordion">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapse1"><span class='glyphicon glyphicon-tasks' aria-hidden='true'></span> Interface(s)</a>
                        </h4>
                    </div>
                    <div id="collapse1" class="panel-collapse collapse">
                        <br>
                        <p><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Ethernet&nbsp;</b></p>
                        <table id='rb_int_ether' data-url="/content/wugms.table.user.rb.interface.ether.php" data-toggle="table" data-classes="table table-hover table-condensed" data-striped="true" data-card-view="false" >
                            <thead>
                                <tr>
                                    <th data-field="name" data-sortable="true">Name</th>
                                    <th data-field="mac_address" data-sortable="true">MAC Address</th>
                                    <th data-field="status" data-sortable="true">Status</th>
                                    <th data-field="ether_auto_negotiation" data-sortable="true">Auto Negotiation</th>
                                    <th data-field="ether_bandwidth" data-sortable="true">Bandwidth</th>
                                    <th data-field="ether_full_duplex" data-sortable="true">Full Duplex</th>
                                    <th data-field="ether_l2mtu" data-sortable="true">L2MTU</th>
                                    <th data-field="ether_speed" data-sortable="true">Speed</th>
                                    <th data-field="comment" data-sortable="true">Comment</th>
                                </tr>
                            </thead>
                        </table>
                        <br>
                        <p><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Wireless&nbsp;</b></p>
                        <table id='rb_int_wifi' data-url="/content/wugms.table.user.rb.interface.wifi.php" data-toggle="table" data-classes="table table-hover table-condensed" data-striped="true" data-card-view="false" >
                            <thead>
                                <tr>
                                    <th data-field="name" data-sortable="true">Name</th>
                                    <th data-field="mac_address" data-sortable="true">MAC Address</th>
                                    <th data-field="status" data-sortable="true">Status</th>
                                    <th data-field="wifi_antenna_gain" data-sortable="true">Antenna Gain</th>
                                    <th data-field="wifi_channel_width" data-sortable="true">Channel Width</th>
                                    <th data-field="wifi_country" data-sortable="true">Country</th>
                                    <th data-field="wifi_frequency" data-sortable="true">Frequency</th>
                                    <th data-field="wifi_mode" data-sortable="true">Mode</th>
                                    <th data-field="wifi_radio_name" data-sortable="true">Radio Name</th>
                                    <th data-field="wifi_ssid" data-sortable="true">SSID</th>
                                    <th data-field="wifi_wireless_protocol" data-sortable="true">Protocol</th>
                                    <th data-field="comment" data-sortable="true">Comment</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapse2"><span class='glyphicon glyphicon-import' aria-hidden='true'></span> IP Address Configuration</a>
                        </h4>
                    </div>
                    <div id="collapse2" class="panel-collapse collapse">
                        <br>
                        <p><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;IPv4&nbsp;</b></p>
                        <table id='rb_ipv4' data-url="/content/wugms.table.user.rb.ipv4.php" data-toggle="table" data-classes="table table-hover table-condensed" data-striped="true" data-card-view="false" >
                            <thead>
                                <tr>
                                    <th data-field="ipv4" data-sortable="true">Address</th>
                                    <th data-field="interface" data-sortable="true">Interface</th>
                                    <th data-field="network" data-sortable="true">Network</th>
                                    <th data-field="maskbits" data-sortable="true">Maskbits</th>
                                    <th data-field="status" data-sortable="true">Status</th>
                                    <th data-field="comment" data-sortable="true">Comment</th>
                                </tr>
                            </thead>
                        </table>
                        <br>
                        <p><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Routes&nbsp;</b></p>
                        <table id='rb_ipv4_route' data-url="/content/wugms.table.user.rb.ipv4.route.php" data-toggle="table" data-classes="table table-hover table-condensed" data-striped="true" data-card-view="false" >
                            <thead>
                                <tr>
                                    <th data-field="dst_addressStr" data-sortable="true">Route</th>
                                    <th data-field="gateway" data-sortable="true">Gateway</th>
                                    <th data-field="scope" data-sortable="true">Scope</th>
                                    <th data-field="distance" data-sortable="true">Distance</th>
                                    <th data-field="target_scope" data-sortable="true">Scope</th>
                                    <th data-field="status" data-sortable="true">Status</th>
                                    <th data-field="comment" data-sortable="true">Comment</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapse3"><span class='glyphicon glyphicon-check' aria-hidden='true'></span> Radius</a>
                        </h4>
                    </div>
                    <div id="collapse3" class="panel-collapse collapse">
                        <table id='rb_radius' data-url="/content/wugms.table.user.rb.radius.php" data-toggle="table" data-classes="table table-hover table-condensed" data-striped="true" data-card-view="false" >
                            <thead>
                                <tr>
                                    <th data-field="server" data-sortable="true">Server</th>
                                    <th data-field="status" data-sortable="true">Status</th>
                                    <th data-field="auth_port" data-sortable="true">Authentication Port</th>
                                    <th data-field="acc_port" data-sortable="true">Accounting Port</th>
                                    <th data-field="services" data-sortable="true">Services</th>
                                    <th data-field="timeout" data-sortable="true">Timeout</th>
                                    <th data-field="comment" data-sortable="true">Comment</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapse4"><span class='glyphicon glyphicon-indent-left' aria-hidden='true'></span> BGP</a>
                    </div>
                    <div id="collapse4" class="panel-collapse collapse">
                        <br>
                        <p><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Instance&nbsp;</b></p>
                        <table id='rb_bgp_instance' data-url="/content/wugms.table.user.rb.bgp.instance.php" data-toggle="table" data-classes="table table-hover table-condensed" data-striped="true" data-card-view="false" >
                            <thead>
                                <tr>
                                    <th data-field="name" data-sortable="true">Name</th>
                                    <th data-field="isdefault" data-sortable="true">is Default</th>
                                    <th data-field="as_value" data-sortable="true">AS</th>
                                    <th data-field="router_idStr" data-sortable="true">Router ID</th>
                                    <th data-field="status" data-sortable="true">Status</th>
                                    <th data-field="client_reflect" data-sortable="true">Client to Client <br> Reflection</th>
                                    <th data-field="redis_connect" data-sortable="true">Redistribute <br> Connected</th>
                                    <th data-field="redis_ospf" data-sortable="true">Redistribute <br> OSPF</th>
                                    <th data-field="redis_other_bgp" data-sortable="true">Redistribute <br> Other BGP</th>
                                    <th data-field="redis_rip" data-sortable="true">Redistribute <br> RIP</th>
                                    <th data-field="redis_static" data-sortable="true">Redistribute <br> Static</th>
                                    <th data-field="ignore_as_path_len" data-sortable="true">Ignore AS path Length</th>
                                    <th data-field="out_filter" data-sortable="true">Out Filter</th>
                                    <th data-field="routing_table" data-sortable="true">Routing Table</th>
                                </tr>
                            </thead>
                        </table>
                        <br>
                        <p><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Peer&nbsp;</b></p>
                        <table id='rb_bgp_peer' data-url="/content/wugms.table.user.rb.bgp.peer.php" data-toggle="table" data-classes="table table-hover table-condensed" data-striped="true" data-card-view="false" >
                            <thead>
                                <tr>
                                    <th data-field="name" data-sortable="true">Name</th>
                                    <th data-field="instance" data-sortable="true">Instance</th>
                                    <th data-field="remote_addressStr" data-sortable="true">Remote <br>Address</th>
                                    <th data-field="remote_as" data-sortable="true">Remote <br>AS</th>
                                    <th data-field="status" data-sortable="true">Status</th>

                                    <th data-field="nexthop_choice" data-sortable="true">Nexthop <br>Choice</th>
                                    <th data-field="multihop" data-sortable="true">Multihop</th>
                                    <th data-field="route_reflect" data-sortable="true">Route Reflect</th>
                                    <th data-field="hold_time" data-sortable="true">Hold <br>Time</th>
                                    <th data-field="ttl" data-sortable="true">TTL</th>

                                    <th data-field="in_filter" data-sortable="true">In <br>Filter</th>
                                    <th data-field="out_filter" data-sortable="true">Out <br>Filter</th>
                                    <th data-field="remove_private_as" data-sortable="true">Remove <br>Private AS</th>
                                    <th data-field="as_override" data-sortable="true">AS <br>Override</th>
                                    <th data-field="default_originate" data-sortable="true">Default <br>Originate</th>

                                    <th data-field="passive" data-sortable="true">Passive</th>
                                    <th data-field="use_bfd" data-sortable="true">Use <br>BFD</th>
                                    <th data-field="address_families" data-sortable="true">Address <br>families</th>
                                    <th data-field="update_source" data-sortable="true">Update <br>Source</th>

                                </tr>
                            </thead>
                        </table>
                        <br>
                        <p><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Network&nbsp;</b></p>
                        <table id='rb_bgp_network' data-url="/content/wugms.table.user.rb.bgp.network.php" data-toggle="table" data-classes="table table-hover table-condensed" data-striped="true" data-card-view="false" >
                            <thead>
                                <tr>
                                    <th data-field="network" data-sortable="true">Network</th>
                                    <th data-field="status" data-sortable="true">Status</th>
                                    <th data-field="synchronize" data-sortable="true">Synchronize</th>
                                </tr>
                            </thead>
                        </table>
                        <br>
                        <p><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Aggregate&nbsp;</b></p>
                        <table id='rb_bgp_aggregate' data-url="/content/wugms.table.user.rb.bgp.aggregate.php" data-toggle="table" data-classes="table table-hover table-condensed" data-striped="true" data-card-view="false" >
                            <thead>
                                <tr>
                                    <th data-field="instance" data-sortable="true">Instance</th>
                                    <th data-field="status" data-sortable="true">Status</th>
                                    <th data-field="prefixStr" data-sortable="true">Prefix</th>
                                    <th data-field="advertise_filter" data-sortable="true">Advertise Filter</th>
                                    <th data-field="attribute_filter" data-sortable="true">Attribute Filter</th>
                                    <th data-field="include_igp" data-sortable="true">Include IGP</th>
                                    <th data-field="inherit_attributes" data-sortable="true">Inherit Attributes</th>
                                    <th data-field="summary_only" data-sortable="true">Summary only</th>
                                    <th data-field="suppress_filter" data-sortable="true">Suppress Filter</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapse5"><span class='glyphicon glyphicon-briefcase' aria-hidden='true'></span> Routerboard Services</a>
                        </h4>
                    </div>
                    <div id="collapse5" class="panel-collapse collapse">
                        <table id='rb_services' data-url="/content/wugms.table.user.rb.services.php" data-toggle="table" data-classes="table table-hover table-condensed" data-striped="true" data-card-view="false" >
                            <thead>
                                <tr>
                                    <th data-field="service_name" data-sortable="true">Service</th>
                                    <th data-field="service_address" data-sortable="true">Service Address</th>
                                    <th data-field="port" data-sortable="true">Port</th>
                                    <th data-field="status" data-sortable="true">Status</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapse6"><span class='glyphicon glyphicon-credit-card' aria-hidden='true'></span> SNMP</a>
                        </h4>
                    </div>
                    <div id="collapse6" class="panel-collapse collapse">
                        <br>
                        <p><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Main&nbsp;</b></p>
                        <table id='rb_snmp' data-url="/content/wugms.table.user.rb.snmp.php" data-toggle="table" data-classes="table table-hover table-condensed" data-striped="true" data-card-view="false" >
                            <thead>
                                <tr>
                                    <th data-field="contact" data-sortable="true">Contact</th>
                                    <th data-field="location" data-sortable="true">Location</th>
                                    <th data-field="status" data-sortable="true">Status</th>
                                    <th data-field="trap_community" data-sortable="true">Trap Community</th>
                                    <th data-field="engine_id" data-sortable="true">Engine ID</th>
                                    <th data-field="trap_generators" data-sortable="true">Trap Generators</th>
                                    <th data-field="trap_target" data-sortable="true">Trap Target</th>
                                    <th data-field="trap_version" data-sortable="true">Trap Version</th>
                                </tr>
                            </thead>
                        </table>
                        <br>
                        <p><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Community&nbsp;</b></p>
                        <table id='rb_snmp_community' data-url="/content/wugms.table.user.rb.snmp.community.php" data-toggle="table" data-classes="table table-hover table-condensed" data-striped="true" data-card-view="false" >
                            <thead>
                                <tr>
                                    <th data-field="name" data-sortable="true">Name</th>
                                    <th data-field="addresses" data-sortable="true">Addresses</th>
                                    <th data-field="read_access" data-sortable="true">Read Access</th>
                                    <th data-field="write_access" data-sortable="true">Write Access</th>
                                    <th data-field="authentication_protocol" data-sortable="true">Authentication Protocol</th>
                                    <th data-field="encryption_protocol" data-sortable="true">Encryption Protocol</th>
                                    <th data-field="security" data-sortable="true">Security</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div> 
            </div>
        </div>
    </div>