	<body>
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
					<li><a href="../">My Routerboard Management</a></li>
					<li class="active"><a href="#">Config Review <span class='glyphicon glyphicon-cog' aria-hidden='true'></span></a></li>
					<li><a href="../ipv4">IPv4 Assignments <span class='glyphicon glyphicon-import' aria-hidden='true'></span></a></li>
					<li><a href="../remcmd">Remote Commands <span class='glyphicon glyphicon-share' aria-hidden='true'></span></a></li>
         </ul>
      </div>
      <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main" id="header">
         <!--			<h1 class="page-header"> </h1> -->
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
            <!-- Show a selector with all the values that the user can select from -->
            <select data-placeholder="Select network device..." class="chzn-select" style="width:350px;" id="cdn_select" name="cdn_select" >
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
      <div id="sel_device"> <?php 
	  //if (isset($_SESSION["rb_ssid_des"])) { echo "<h3 class='sub-header'>Selected device: <span style='color: rgb(0, 0, 153);'>" . $_SESSION["rb_ssid_des"] . "</span></h3>"; } else { 
	  echo "<h3 class='sub-header'>No device has been selected</h3> ";  ?></div>
      <!-- Table for SSID overview -->
      <div class="panel panel-primary">
         <div class="panel-heading"><b>RouterBoard Header</b></div>
         <div class="panel-body">
            <table id='rb_header_table' data-url="/content/wugms.table.user.rb.header.php" data-toggle="table" data-classes="table table-hover table-condensed" data-striped="true" data-card-view="true" >
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
         </div>
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
		  <div class="panel-body">
		  <br>
		  <p><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Ethernet&nbsp;</b></p>
			<table id='rb_int_ether' data-url="/content/wugms.table.user.rb.interface.ether.php" data-toggle="table" data-classes="table table-hover table-condensed" data-striped="true" data-card-view="false" >
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
			<p><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Wireless&nbsp;</b></p>
			<table id='rb_int_wifi' data-url="/content/wugms.table.user.rb.interface.wifi.php" data-toggle="table" data-classes="table table-hover table-condensed" data-striped="true" data-card-view="false" >
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
          </div>
        </div>
		</div>
        <div class="panel panel-info">
          <div class="panel-heading">
            <h4 class="panel-title">
              <a data-toggle="collapse" data-parent="#accordion" href="#collapse2">IP Address Configuration <span class='glyphicon glyphicon-tasks' aria-hidden='true'></span></a>
            </h4>
          </div>
          <div id="collapse2" class="panel-collapse collapse">
		  <div class="panel-body">
		  <br>
		  <p><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;IPv4&nbsp;</b></p>
			<table id='rb_ipv4' data-url="/content/wugms.table.user.rb.ipv4.php" data-toggle="table" data-classes="table table-hover table-condensed" data-striped="true" data-card-view="false" >
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
			<p><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Routes&nbsp;</b></p>
			<table id='rb_ipv4_route' data-url="/content/wugms.table.user.rb.ipv4.route.php" data-toggle="table" data-classes="table table-hover table-condensed" data-striped="true" data-card-view="false" >
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
          </div>
        </div>
		</div>
        <div class="panel panel-info">
          <div class="panel-heading">
            <h4 class="panel-title">
              <a data-toggle="collapse" data-parent="#accordion" href="#collapse3">Radius <span class='glyphicon glyphicon-tasks' aria-hidden='true'></span></a>
            </h4>
          </div>
          <div id="collapse3" class="panel-collapse collapse">
		  <div class="panel-body">
			<table id='rb_radius' data-url="/content/wugms.table.user.rb.radius.php" data-toggle="table" data-classes="table table-hover table-condensed" data-striped="true" data-card-view="false" >
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
          </div>
        </div>
		</div>
        <div class="panel panel-info">
          <div class="panel-heading">
            <h4 class="panel-title">
              <a data-toggle="collapse" data-parent="#accordion" href="#collapse4">BGP <span class='glyphicon glyphicon-tasks' aria-hidden='true'></span></a>
            </h4>
          </div>
          <div id="collapse4" class="panel-collapse collapse">
		  <div class="panel-body">
		  <br>
		  <p><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Instance&nbsp;</b></p>
			<table id='rb_bgp_instance' data-url="/content/wugms.table.user.rb.bgp.instance.php" data-toggle="table" data-classes="table table-hover table-condensed" data-striped="true" data-card-view="false" >
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
		  <p><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Peer&nbsp;</b></p>
			<table id='rb_bgp_peer' data-url="/content/wugms.table.user.rb.bgp.peer.php" data-toggle="table" data-classes="table table-hover table-condensed" data-striped="true" data-card-view="false" >
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
		  <p><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Network&nbsp;</b></p>
			<table id='rb_bgp_network' data-url="/content/wugms.table.user.rb.bgp.network.php" data-toggle="table" data-classes="table table-hover table-condensed" data-striped="true" data-card-view="false" >
               <thead>
					<tr>
						<th data-field="network">Network</th>
						<th data-field="status">Status</th>
						<th data-field="synchronize">Synchronize</th>
					</tr>
               </thead>
            </table>
					  <br>
		  <p><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Aggregate&nbsp;</b></p>
			<table id='rb_bgp_aggregate' data-url="/content/wugms.table.user.rb.bgp.aggregate.php" data-toggle="table" data-classes="table table-hover table-condensed" data-striped="true" data-card-view="false" >
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
          </div>
        </div>
		</div>
        <div class="panel panel-info">
          <div class="panel-heading">
            <h4 class="panel-title">
              <a data-toggle="collapse" data-parent="#accordion" href="#collapse5">Routerboard Services <span class='glyphicon glyphicon-tasks' aria-hidden='true'></span></a>
            </h4>
          </div>
          <div id="collapse5" class="panel-collapse collapse">
		  <div class="panel-body">
			<table id='rb_services' data-url="/content/wugms.table.user.rb.services.php" data-toggle="table" data-classes="table table-hover table-condensed" data-striped="true" data-card-view="false" >
               <thead>
					<tr>
						<th data-field="service_name">Service</th>
						<th data-field="service_address">Service Address</th>
						<th data-field="port">Port</th>
						<th data-field="status">Status</th>
					</tr>
               </thead>
            </table>
          </div>
        </div>
		</div>
		<div class="panel panel-info">
          <div class="panel-heading">
            <h4 class="panel-title">
              <a data-toggle="collapse" data-parent="#accordion" href="#collapse6">SNMP <span class='glyphicon glyphicon-tasks' aria-hidden='true'></span></a>
            </h4>
          </div>
          <div id="collapse6" class="panel-collapse collapse">
		  <div class="panel-body">
		  <br>
		  <p><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Main&nbsp;</b></p>
			<table id='rb_snmp' data-url="/content/wugms.table.user.rb.snmp.php" data-toggle="table" data-classes="table table-hover table-condensed" data-striped="true" data-card-view="false" >
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
			<p><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Community&nbsp;</b></p>
			<table id='rb_snmp_community' data-url="/content/wugms.table.user.rb.snmp.community.php" data-toggle="table" data-classes="table table-hover table-condensed" data-striped="true" data-card-view="false" >
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
          </div>
        </div>
      </div> 
	  </div>
      <!--     </div> -->
   </div>
</div>