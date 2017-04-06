	<body>
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
				</div><!-- /.modal-content -->
			</div><!-- /.modal-dialog -->
		</div><!-- /.modal -->
<div class="container-fluid">
   <div class="row">
      <div class="col-sm-3 col-md-2 sidebar">
         <ul class="nav nav-sidebar">
            <li><a href="../">Admin Dashboards</a></li>
            <li><a href="../cpu">CPU <span class='glyphicon glyphicon-tasks' aria-hidden='true'></span></a></li>
            <li><a href="../interfaces">Interfaces <span class='glyphicon glyphicon-random' aria-hidden='true'></a></li>
			<li><a href="../qos">QoS <span class='glyphicon glyphicon-list-alt' aria-hidden='true'></a></li>
            <li><a href="../storage">Storage <span class='glyphicon glyphicon-hdd' aria-hidden='true'></span></a></li>
            <li><a href="../device">Router Device (Mikrotik) <span class='glyphicon glyphicon-dashboard' aria-hidden='true'></span></a></li>
            <li><a href="../ap">AP (Mikrotik) <span class='glyphicon glyphicon-link' aria-hidden='true'></span></a></li>
            <li class="active"><a href="#">Wifi Connections (Mikrotik) <span class='glyphicon glyphicon-signal' aria-hidden='true'></span></a></li>
         </ul>
      </div>
      <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main" id="header">
         <!--			<h1 class="page-header"> </h1> -->
         <div align="center">
            <!-- Show a selector with all the values that the user can select from -->
            <select data-placeholder="Select network device..." class="chzn-select" style="width:350px;" id="cdn_select" name="cdn_select" >
				<option value=""></option>
				<?php
					if (isset($_SESSION["id"])) {
						/* The main sql statement */
						$wugms_table_devices_client_query  = "
						SELECT x.sitename,
       						x.sn,
       						x.device_model,
       						x.device_name,
       						z.AP_ID
  						FROM (SELECT a.device_make,
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
        						ORDER BY b.SiteName, a.device_name) AS x
       						INNER JOIN (SELECT Serial_Number, AP_ID
                     						FROM wugms.tbl_base_snmp_mikrotik_ap_clients_now
                    						WHERE RDate > now() - INTERVAL 28 DAY
                   						GROUP BY Serial_Number) AS z
          						ON x.sn = z.Serial_Number
						ORDER BY x.SiteName, x.device_name;
						";
						$wugms_table_devices_client_stmt         = $db->prepare($wugms_table_devices_client_query);
						if ($wugms_table_devices_client_stmt->execute($wugms_table_devices_client_query_params)) {
							$wugms_table_devices_client_row = $wugms_table_devices_client_stmt->fetchAll();
							}
						/* Display the returned row(s) */
						foreach ($wugms_table_devices_client_row as $row) {
							echo "<option value='" . $row['sn'] . "_" . $row['AP_ID'] . "'>". $row['sitename'] . " -> " . $row['device_name'] . "</option>";
							}
						}
                  ?>
            </select>
         </div>
         <div id="selection"> </div>
      </div>
   </div>
   <!-- <h2 class="sub-header">Results</h2> -->
   <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main" id="header">
      <div id="sel_device"> <?php if (isset($_SESSION["rb_ssid_des"])) { echo "<h3 class='sub-header'>Connection information for : <span style='color: rgb(0, 0, 153);'>" . $_SESSION["rb_ssid_des"] . "</span></h3>"; } else { echo "<h3 class='sub-header'>No network device has been selected</h3> "; } ?></div>
	  <!-- table for connected clients -->
      <div class="panel panel-info">
         <div class="panel-heading"><b>Connections</b></div>
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