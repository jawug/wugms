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
            <li><a href="../">My Dashboards</a></li>
            <li><a href="../routerboard">CPU <span class='glyphicon glyphicon-tasks' aria-hidden='true'></span></a></li>
            <li><a href="../interfaces">Interfaces <span class='glyphicon glyphicon-random' aria-hidden='true'></a></li>
			<li><a href="../qos">QoS <span class='glyphicon glyphicon-list-alt' aria-hidden='true'></a></li>
            <li><a href="../storage">Storage <span class='glyphicon glyphicon-hdd' aria-hidden='true'></span></a></li>
            <li><a href="../device">Router Device (Mikrotik) <span class='glyphicon glyphicon-dashboard' aria-hidden='true'></span></a></li>
            <li class="active"><a href="#">AP (Mikrotik) <span class='glyphicon glyphicon-link' aria-hidden='true'></span></a></li>
            <li><a href="../ap_clients">Wifi Connections (Mikrotik) <span class='glyphicon glyphicon-signal' aria-hidden='true'></span></a></li>
         </ul>
      </div>
      <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main" id="header">
         <!--			<h1 class="page-header"> </h1> -->
         <div align="center">
            <?php
               /* Set up the SQL query */
               $subquery = "
               SELECT x.sitename,
                 x.sn,
                 z.SSID,
                 z.AP_ID
               FROM (SELECT device_make,
                         device_model,
                         os_ver,
                         device_name,
                         sitename,
                         b.sn
                    FROM (SELECT sn
                            FROM (SELECT b.ae_Serial_Number 'sn'
                                    FROM tbl_ae_sites_rbs b,
                                         tbl_base_sites a,
                                         tbl_base_sites c
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
                  ORDER BY b.SiteName, b.device_name) AS x
                 INNER JOIN
                 (SELECT Serial_Number, AP_ID, SSID
                    FROM wugms.tbl_base_snmp_mikrotik_ap_now
                   WHERE     RDate > now() - INTERVAL 14 DAY
                         AND upper(ssid) LIKE '%JAWUG.%'
                  GROUP BY Serial_Number) AS z
                    ON x.sn = z.Serial_Number
               ORDER BY x.SiteName, z.SSID;;";
               /* Prepare the SQL for execute */
               $substmt = $db->prepare($subquery);
               /* Execute the query */
               if ($substmt->execute()) {
               	$subresult = $substmt->fetchAll(PDO::FETCH_ASSOC);
               }
               ?>
            <!-- Show a selector with all the values that the user can select from -->
            <select data-placeholder="Select SSID..." class="chzn-select" style="width:350px;" id="cdn_select" name="cdn_select" >
               <option value=""></option>
               <?php
                  /* Display the returned row(s) */
                  foreach ($subresult as $row) {
                  	echo "<option value='" . $row['sn'] . "_" . $row['AP_ID'] . "'>". $row['sitename'] . " -> " . $row['SSID'] . "</option>";
                  }
                  ?>
            </select>
         </div>
         <div id="selection"> </div>
      </div>
   </div>
   <!-- <h2 class="sub-header">Results</h2> -->
   <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main" id="header">
      <div id="sel_device"> <?php if (isset($_SESSION["rb_ssid_des"])) { echo "<h3 class='sub-header'>SSID information for : <span style='color: rgb(0, 0, 153);'>" . $_SESSION["rb_ssid_des"] . "</span></h3>"; } else { echo "<h3 class='sub-header'>No SSID has been selected</h3> "; } ?></div>
      <!-- Table for SSID overview -->
      <div class="panel panel-primary">
         <div class="panel-heading"><b>Overview</b></div>
         <div class="panel-body">
            <table id='ssid_ap_table' data-url="/content/snmp_ssid_ap.php" data-toggle="table" data-classes="table table-hover table-condensed" data-striped="true" >
               <thead>
                  <tr>
                     <th data-field="freq" data-sortable="true">Frequency</th>
                     <th data-field="band" data-sortable="true">Band</th>
                     <th data-field="noisefloor" data-sortable="true">Noise Floor</th>
                     <th data-field="overalltxccq" data-sortable="true">Overall Tx CCQ</th>
                     <th data-field="clientcount" data-sortable="true">Clients</th>
                     <th data-field="authclientcount" data-sortable="true">Authenticated Clients</th>
                  </tr>
               </thead>
            </table>
         </div>
      </div>
      <hr>
	  <!-- table for connected clients -->
      <div class="panel panel-info">
         <div class="panel-heading"><b>Connected Clients</b></div>
         <div class="panel-body">
            <table id='ssid_client_table' data-url="/content/snmp_ssid_clients.php" data-toggle="table" data-classes="table table-hover table-condensed" data-striped="true" data-show-columns="true" data-search="true" data-show-toggle="true">
               <thead>
                  <tr>
                     <th data-field="rdate" data-sortable="true">Last Seen</th>
                     <th data-field="sitename" data-sortable="true">Site</th>
                     <th data-field="rb_identity" data-sortable="true">RB Name</th>
                     <th data-field="board_model" data-sortable="true">Model</th>
                     <th data-field="ros" data-sortable="true">ROS</th>
                     <th data-field="user" data-sortable="true">User</th>
                     <th data-field="connect_time" data-sortable="true">Uptime</th>
                     <th data-field="iface_name" data-sortable="true">Interface</th>
                     <th data-field="wifi_radio_name" data-sortable="true">Radio Name</th>
                     <th data-field="wifi_antenna_gain" data-sortable="true">Antenna Gain</th>
                     <th data-field="strength" data-sortable="true">Strength</th>
                     <th data-field="tx_speed" data-sortable="true">Tx Speed</th>
                     <th data-field="rx_speed" data-sortable="true">Rx Speed</th>
                     <th data-field="tx_bytes" data-sortable="true">Tx Bytes</th>
                     <th data-field="rx_bytes" data-sortable="true">Rx Bytes</th>
                  </tr>
               </thead>
            </table>
         </div>
      </div>
      <!--     </div> -->
   </div>
</div>