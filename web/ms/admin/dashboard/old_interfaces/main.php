	<body>
		<!-- Help modal -->
		<div class="modal fade"  id="myHelpModal" >
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title">Help - Interface Graphs</h4>
					</div>
					<div class="modal-body">
						<p>The graphs on this page shows usage for the selected interface. </p>
						<p>The "selector" shows routerboards that are been loaded via RBCP. </p>
						<p><b>NOTE:</b> If there is no data then there is a chance that snmp data is not been collected from the device.</p>
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
            <li class="active"><a href="../interfaces">Interfaces <span class='glyphicon glyphicon-random' aria-hidden='true'></a></li>
			<li><a href="../qos">QoS <span class='glyphicon glyphicon-list-alt' aria-hidden='true'></a></li>
			<li><a href="../storage">Storage <span class='glyphicon glyphicon-hdd' aria-hidden='true'></span></a></li>
            <li><a href="../device">Router Device (Mikrotik) <span class='glyphicon glyphicon-dashboard' aria-hidden='true'></span></a></li>
			<li><a href="../ap">AP (Mikrotik) <span class='glyphicon glyphicon-link' aria-hidden='true'></span></a></li>
			<li><a href="../ap_clients">Wifi Connections (Mikrotik) <span class='glyphicon glyphicon-signal' aria-hidden='true'></span></a></li>
          </ul>
        </div>
<!--		<form name="form_field"> -->
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main" id="header">
<!--			<h1 class="page-header"> </h1> -->
			<div align="center">
				<?php
					/* Set up the SQL query */
					$subquery = "
SELECT x.device_make,
       x.device_model,
       x.os_ver,
       x.device_name,
       x.sitename,
       x.sn,
       z.ID,
       z.IFace_Type,
       z.Descr
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
       INNER JOIN
       (SELECT Serial_Number,
               ID,
               IFace_Type,
               Descr
          FROM wugms.tbl_base_snmp_common_interfaces_now
         WHERE   RDate > now() - INTERVAL 28 DAY
        GROUP BY Serial_Number, ID) AS z
          ON x.sn = z.Serial_Number
          order by x.SiteName, x.device_name,z.id;";

					/* Prepare the SQL for execute */
					$substmt = $db->prepare($subquery);
					/* Execute the query */
					if ($substmt->execute()) {
						$subresult = $substmt->fetchAll(PDO::FETCH_ASSOC);
					}
				?>
				<!-- Show a selector with all the values that the user can select from -->
				<select data-placeholder="Select core network device..." class="chzn-select" style="width:350px;" id="cdn_select" name="cdn_select" >
					<option value=""></option>
					<?php
						/* Display the returned row(s) */
						foreach ($subresult as $row) {
							echo "<option value='" . $row['sn'] . "_" . $row['ID'] . "'>". $row['sitename'] . " -> " . $row['device_name'] . " [" . $row['device_model'] . "," . $row['Descr'] . "]" . "</option>";
						}
					?>
				</select>
			</div>
			<div id="selection"> </div>
		</div>
      </div>
	  
          <!-- <h2 class="sub-header">Results</h2> -->
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main" id="header">
			<div id="sel_device"> <?php if (isset($_SESSION["rb_ifacedes"])) { echo "<h3 class='sub-header'>Interface graphs for : <span style='color: rgb(0, 0, 153);'>" . $_SESSION["rb_ifacedes"] . "</span></h3>"; } else { echo "<h3 class='sub-header'>No network device has been selected</h3> "; } ?></div>
			<div align="center">
				<div id="interfaces_bytes" style="height: 400px; width: 100%; margin: 0 auto"></div>
				<hr>
				<div id="interfaces_packets" style="height: 400px; width: 100%; margin: 0 auto"></div>
			</div>
		</div>
	  

    </div>