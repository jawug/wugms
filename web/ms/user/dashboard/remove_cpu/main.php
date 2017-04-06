	<body>
		<!-- Help modal -->
		<div class="modal fade"  id="myHelpModal" >
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title">Help - CPU Graphs</h4>
					</div>
					<div class="modal-body">
						<p>The graphs on this page shows CPU usage for the selected "core network device". </p>
						<p>The "selector" shows routerboards where the user is either the owner or the equipment is located at the user's site. </p>
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
            <li class="active"><a href="#">CPU <span class='glyphicon glyphicon-tasks' aria-hidden='true'></span></a></li>
            <li><a href="../interfaces">Interfaces <span class='glyphicon glyphicon-random' aria-hidden='true'></a></li>
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

          <!-- <h1 class="page-header">Header section</h1> -->
			<!-- <div align="center">

			</div> -->
		<!-- </form> -->
			<br>

			<br>

          <!-- <h2 class="sub-header">Results</h2> -->
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main" id="header">
			<div id="sel_device"> <?php if (isset($_SESSION["rb_des"])) { echo "<h3 class='sub-header'>CPU graphs for <span style='color: rgb(0, 0, 153);'>" . $_SESSION["rb_des"] . "</span></h3>"; } else { echo "<h3 class='sub-header'>No network device has been selected</h3> "; } ?></div>
			<div align="center">
				<div id="cpu24hours" style="height: 400px; width: 100%; margin: 0 auto"></div>
				<hr>
				<div id="cpu30days" style="height: 400px; width: 100%; margin: 0 auto"></div>
				<hr>
				<div id="cpu12months" style="height: 400px; width: 100%; margin: 0 auto"></div>
			</div>
		</div>
	  

    </div>
    