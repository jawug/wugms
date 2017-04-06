<body>
    <div class="pagetitle" id="page_adm_rb_man"> </div>	
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
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-3 col-md-2 sidebar">
                <ul class="nav nav-sidebar">
                    <li><a href="../"><img src="/images/switch.png" alt="..." class="img-rounded" width="24" height="24"> Routerboard Management </a></li>
                    <li class="active"><a href="#"><img src="/images/folder_network.png" alt="..." class="img-rounded" width="24" height="24"> Config Review </a></li>
                    <li><a href="../ipv4"><img src="/images/ip_pyramid.png" alt="..." class="img-rounded" width="24" height="24"> IPv4 Assignments </a></li>
                    <li><a href="../bgp"><img src="/images/arrow_switch-128.png" alt="..." class="img-rounded" width="24" height="24"> BGP Assignments </a></li>
                    <li><a href="../remcmd"><img src="/images/settings.png" alt="..." class="img-rounded" width="24" height="24"> Remote Commands </a></li>
                    <li><a href="../rbassign"><img src="/images/stock_task_assigned_to.png" alt="..." class="img-rounded" width="24" height="24"> Routerboard Allocation </a></li>
                </ul>
            </div>
            <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main" id="header">
                <!--			<h1 class="page-header"> </h1> -->
                <div align="center">
                    <?php
                    /* Set up the SQL query */
                    $subquery = "
SELECT a.device_make,
       a.device_model,
       a.os_ver,
       a.device_name,
       b.sitename,
       a.sn
  FROM (SELECT 'Mikrotik' AS 'device_make',
               a.Board_model 'device_model',
               a.OS_Version 'os_ver',
               a.RB_identity 'device_name',
               a.Software_ID 'dev_id',
               a.Serial_Number 'sn',
               c.irc_nick 'cdn_owner',
               siteID
          FROM tbl_base_rb_routerboard a, tbl_base_user c
         WHERE c.idtbl_base_user = a.idSite_Owner) AS a,
       (SELECT b.siteID,
               b.Name 'sitename',
               b.idSite_Owner,
               c.irc_nick 'site_owner_name'
          FROM tbl_base_sites b, tbl_base_user c
         WHERE b.idSite_Owner = c.idtbl_base_user) AS b
 WHERE b.siteID = a.siteID
ORDER BY b.SiteName, a.device_name;";
                    /* Prepare the SQL for execute */
                    $substmt = $db->prepare($subquery);
                    /* Execute the query */
                    if ($substmt->execute()) {
                        $subresult = $substmt->fetchAll(PDO::FETCH_ASSOC);
                    }
                    ?>
                    <!-- Show a selector with all the values that the user can select from -->
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
                <div id="selection"> </div>
            </div>
        </div>
        <!-- <h2 class="sub-header">Results</h2> -->
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main" id="header">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><div id="sel_device">No device selected</div></h3>
                </div>
            </div>
            <!-- Table for SSID overview -->
            <div class="panel panel-default">
                <div class="panel-heading"><b>RouterBoard Header</b></div>
                <!--         <div class="panel-body"> -->
                <table id='rb_header_table' data-url="/content/wugms.table.admin.rb.header.php" data-toggle="table" data-classes="table table-hover table-condensed" data-striped="true" data-card-view="true" >
                    <thead>
                        <tr>
                            <th data-field="Serial_Number">Serial Number</th>
                            <th data-field="Software_ID">License Key</th>
                            <th data-field="OS_Version">RBCP ROS</th>
                            <th data-field="Board_tech">Technology</th>
                            <th data-field="Board_model">Model</th>
                            <th data-field="RB_identity">Identity</th>
                            <th data-field="File_Date">Last RBCP</th>
                            <th data-field="Name">Sitename</th>
                            <th data-field="snmp_seen">SNMP Seen</th>
                            <th data-field="snmp_ros">SNMP ROS</th>
                        </tr>
                    </thead>
                </table>
                <!--         </div>  -->
            </div>
            <hr>
            <!-- table for connected clients -->
            <div class="panel-group" id="accordion">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapse1">Interface(s) <span class='glyphicon glyphicon-tasks' aria-hidden='true'></span></a>
                        </h4>
                    </div>
                    <div id="collapse1" class="panel-collapse collapse">
                        <!--		  <div class="panel-body">  -->
                        <br>
      <!--		  <p><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Ethernet&nbsp;</b></p> -->
                        <p class="text-left"><h4>&nbsp;Ethernet</h4></p>
                        <table id='rb_int_ether' data-url="/content/wugms.table.admin.rb.interface.ether.php" data-toggle="table" data-classes="table table-hover table-condensed" data-striped="true" data-card-view="false" >
                            <thead>
                                <tr>
                                    <th data-field="name">Name</th>
                                    <th data-field="mac_address">MAC Address</th>
                                    <th data-field="status">Status</th>
                                    <th data-field="ether_auto_negotiation">Auto Negotiation</th>
                                    <th data-field="ether_bandwidth">Bandwidth</th>
                                    <th data-field="ether_full_duplex">Full Duplex</th>
                                    <th data-field="ether_l2mtu">L2MTU</th>
                                    <th data-field="ether_speed">Speed</th>
                                    <th data-field="comment">Comment</th>
                                </tr>
                            </thead>
                        </table>
                        <br>
<!--			<p><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Wireless&nbsp;</b></p>  -->
                        <p class="text-left"><h4>&nbsp;Wireless</h4></p>
                        <table id='rb_int_wifi' data-url="/content/wugms.table.admin.rb.interface.wifi.php" data-toggle="table" data-classes="table table-hover table-condensed" data-striped="true" data-card-view="false" >
                            <thead>
                                <tr>
                                    <th data-field="name">Name</th>
                                    <th data-field="mac_address">MAC Address</th>
                                    <th data-field="status">Status</th>
                                    <th data-field="wifi_antenna_gain">Antenna Gain</th>
                                    <th data-field="wifi_channel_width">Channel Width</th>
                                    <th data-field="wifi_country">Country</th>
                                    <th data-field="wifi_frequency">Frequency</th>
                                    <th data-field="wifi_mode">Mode</th>
                                    <th data-field="wifi_radio_name">Radio Name</th>
                                    <th data-field="wifi_ssid">SSID</th>
                                    <th data-field="wifi_wireless_protocol">Protocol</th>
                                    <th data-field="comment">Comment</th>
                                </tr>
                            </thead>
                        </table>
                        <!--          </div>  -->
                    </div>
                </div>
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapse2">IP Address Configuration <span class='glyphicon glyphicon-tasks' aria-hidden='true'></span></a>
                        </h4>
                    </div>
                    <div id="collapse2" class="panel-collapse collapse">
                        <!--		  <div class="panel-body">  -->
                        <br>
      <!--		  <p><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;IPv4&nbsp;</b></p>  -->
                        <p class="text-left"><h4>&nbsp;IPv4</h4></p>
                        <table id='rb_ipv4' data-url="/content/wugms.table.admin.rb.ipv4.php" data-toggle="table" data-classes="table table-hover table-condensed" data-striped="true" data-card-view="false" >
                            <thead>
                                <tr>
                                    <th data-field="ipv4">Address</th>
                                    <th data-field="interface">Interface</th>
                                    <th data-field="network">Network</th>
                                    <th data-field="maskbits">Maskbits</th>
                                    <th data-field="status">Status</th>
                                    <th data-field="comment">Comment</th>
                                </tr>
                            </thead>
                        </table>
                        <br>
<!--			<p><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Routes&nbsp;</b></p>  -->
                        <p class="text-left"><h4>&nbsp;Routes</h4></p>
                        <table id='rb_ipv4_route' data-url="/content/wugms.table.admin.rb.ipv4.route.php" data-toggle="table" data-classes="table table-hover table-condensed" data-striped="true" data-card-view="false" >
                            <thead>
                                <tr>
                                    <th data-field="dst_addressStr">Route</th>
                                    <th data-field="gateway">Gateway</th>
                                    <th data-field="scope">Scope</th>
                                    <th data-field="distance">Distance</th>
                                    <th data-field="target_scope">Scope</th>
                                    <th data-field="status">Status</th>
                                    <th data-field="comment">Comment</th>
                                </tr>
                            </thead>
                        </table>
                        <!--          </div>  -->
                    </div>
                </div>
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapse3">Radius <span class='glyphicon glyphicon-tasks' aria-hidden='true'></span></a>
                        </h4>
                    </div>
                    <div id="collapse3" class="panel-collapse collapse">
                        <!--		  <div class="panel-body">  -->
                        <table id='rb_radius' data-url="/content/wugms.table.admin.rb.radius.php" data-toggle="table" data-classes="table table-hover table-condensed" data-striped="true" data-card-view="false" >
                            <thead>
                                <tr>
                                    <th data-field="server">Server</th>
                                    <th data-field="status">Status</th>
                                    <th data-field="auth_port">Authentication Port</th>
                                    <th data-field="acc_port">Accounting Port</th>
                                    <th data-field="services">Services</th>
                                    <th data-field="timeout">Timeout</th>
                                    <th data-field="comment">Comment</th>
                                </tr>
                            </thead>
                        </table>
                        <!--          </div>  -->
                    </div>
                </div>
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapse4">BGP <span class='glyphicon glyphicon-tasks' aria-hidden='true'></span></a>
                        </h4>
                    </div>
                    <div id="collapse4" class="panel-collapse collapse">
                        <!--		  <div class="panel-body">  -->
                        <br>
      <!--		  <p><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Instance&nbsp;</b></p>  -->
                        <p class="text-left"><h4>&nbsp;Instance</h4></p>
                        <table id='rb_bgp_instance' data-url="/content/wugms.table.admin.rb.bgp.instance.php" data-toggle="table" data-classes="table table-hover table-condensed" data-striped="true" data-card-view="false" >
                            <thead>
                                <tr>
                                    <th data-field="name">Name</th>
                                    <th data-field="isdefault">is Default</th>
                                    <th data-field="as_value">AS</th>
                                    <th data-field="router_idStr">Router ID</th>
                                    <th data-field="status">Status</th>
                                    <th data-field="client_reflect">Client to Client <br> Reflection</th>
                                    <th data-field="redis_connect">Redistribute <br> Connected</th>
                                    <th data-field="redis_ospf">Redistribute <br> OSPF</th>
                                    <th data-field="redis_other_bgp">Redistribute <br> Other BGP</th>
                                    <th data-field="redis_rip">Redistribute <br> RIP</th>
                                    <th data-field="redis_static">Redistribute <br> Static</th>
                                    <th data-field="ignore_as_path_len">Ignore AS path Length</th>
                                    <th data-field="out_filter">Out Filter</th>
                                    <th data-field="routing_table">Routing Table</th>
                                </tr>
                            </thead>
                        </table>
                        <br>
      <!--		  <p><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Peer&nbsp;</b></p>  -->
                        <p class="text-left"><h4>&nbsp;Peer</h4></p>
                        <table id='rb_bgp_peer' data-url="/content/wugms.table.admin.rb.bgp.peer.php" data-toggle="table" data-classes="table table-hover table-condensed" data-striped="true" data-card-view="false" >
                            <thead>
                                <tr>
                                    <th data-field="name">Name</th>
                                    <th data-field="instance">Instance</th>
                                    <th data-field="remote_addressStr">Remote <br>Address</th>
                                    <th data-field="remote_as">Remote <br>AS</th>
                                    <th data-field="status">Status</th>

                                    <th data-field="nexthop_choice">Nexthop <br>Choice</th>
                                    <th data-field="multihop">Multihop</th>
                                    <th data-field="route_reflect">Route Reflect</th>
                                    <th data-field="hold_time">Hold <br>Time</th>
                                    <th data-field="ttl">TTL</th>

                                    <th data-field="in_filter">In <br>Filter</th>
                                    <th data-field="out_filter">Out <br>Filter</th>
                                    <th data-field="remove_private_as">Remove <br>Private AS</th>
                                    <th data-field="as_override">AS <br>Override</th>
                                    <th data-field="default_originate">Default <br>Originate</th>

                                    <th data-field="passive">Passive</th>
                                    <th data-field="use_bfd">Use <br>BFD</th>
                                    <th data-field="address_families">Address <br>families</th>
                                    <th data-field="update_source">Update <br>Source</th>

                                </tr>
                            </thead>
                        </table>
                        <br>
      <!--		  <p><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Network&nbsp;</b></p>  -->
                        <p class="text-left"><h4>&nbsp;Network</h4></p>		  
                        <table id='rb_bgp_network' data-url="/content/wugms.table.admin.rb.bgp.network.php" data-toggle="table" data-classes="table table-hover table-condensed" data-striped="true" data-card-view="false" >
                            <thead>
                                <tr>
                                    <th data-field="network">Network</th>
                                    <th data-field="status">Status</th>
                                    <th data-field="synchronize">Synchronize</th>
                                </tr>
                            </thead>
                        </table>
                        <br>
<!--		  <p><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Aggregate&nbsp;</b></p>  -->
                        <p class="text-left"><h4>&nbsp;Aggregate</h4></p>
                        <table id='rb_bgp_aggregate' data-url="/content/wugms.table.admin.rb.bgp.aggregate.php" data-toggle="table" data-classes="table table-hover table-condensed" data-striped="true" data-card-view="false" >
                            <thead>
                                <tr>
                                    <th data-field="instance">Instance</th>
                                    <th data-field="status">Status</th>
                                    <th data-field="prefixStr">Prefix</th>
                                    <th data-field="advertise_filter">Advertise Filter</th>
                                    <th data-field="attribute_filter">Attribute Filter</th>
                                    <th data-field="include_igp">Include IGP</th>
                                    <th data-field="inherit_attributes">Inherit Attributes</th>
                                    <th data-field="summary_only">Summary only</th>
                                    <th data-field="suppress_filter">Suppress Filter</th>
                                </tr>
                            </thead>
                        </table>
                        <!--          </div>  -->
                    </div>
                </div>
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapse5">Routerboard Services <span class='glyphicon glyphicon-tasks' aria-hidden='true'></span></a>
                        </h4>
                    </div>
                    <div id="collapse5" class="panel-collapse collapse">
                        <!--		  <div class="panel-body">  -->
                        <table id='rb_services' data-url="/content/wugms.table.admin.rb.services.php" data-toggle="table" data-classes="table table-hover table-condensed" data-striped="true" data-card-view="false" >
                            <thead>
                                <tr>
                                    <th data-field="service_name">Service</th>
                                    <th data-field="service_address">Service Address</th>
                                    <th data-field="port">Port</th>
                                    <th data-field="status">Status</th>
                                </tr>
                            </thead>
                        </table>
                        <!--          </div>  -->
                    </div>
                </div>
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapse6">SNMP <span class='glyphicon glyphicon-tasks' aria-hidden='true'></span></a>
                        </h4>
                    </div>
                    <div id="collapse6" class="panel-collapse collapse">
                        <!--		  <div class="panel-body">  -->
                        <br>
      <!--		  <p><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Main&nbsp;</b></p>  -->
                        <p class="text-left"><h4>&nbsp;Main</h4></p>
                        <table id='rb_snmp' data-url="/content/wugms.table.admin.rb.snmp.php" data-toggle="table" data-classes="table table-hover table-condensed" data-striped="true" data-card-view="false" >
                            <thead>
                                <tr>
                                    <th data-field="contact">Contact</th>
                                    <th data-field="location">Location</th>
                                    <th data-field="status">Status</th>
                                    <th data-field="trap_community">Trap Community</th>
                                    <th data-field="engine_id">Engine ID</th>
                                    <th data-field="trap_generators">Trap Generators</th>
                                    <th data-field="trap_target">Trap Target</th>
                                    <th data-field="trap_version">Trap Version</th>
                                </tr>
                            </thead>
                        </table>
                        <br>
<!--			<p><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Community&nbsp;</b></p>  -->
                        <p class="text-left"><h4>&nbsp;Community</h4></p>
                        <table id='rb_snmp_community' data-url="/content/wugms.table.admin.rb.snmp.community.php" data-toggle="table" data-classes="table table-hover table-condensed" data-striped="true" data-card-view="false" >
                            <thead>
                                <tr>
                                    <th data-field="name">Name</th>
                                    <th data-field="addresses">Addresses</th>
                                    <th data-field="read_access">Read Access</th>
                                    <th data-field="write_access">Write Access</th>
                                    <th data-field="authentication_protocol">Authentication Protocol</th>
                                    <th data-field="encryption_protocol">Encryption Protocol</th>
                                    <th data-field="security">Security</th>
                                </tr>
                            </thead>
                        </table>
                        <!--          </div>  -->
                    </div>
                </div> 
            </div>
            <!--     </div> -->
        </div>
    </div>