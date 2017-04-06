	<body>
		<div class="pagetitle" id="page_adm_dash"> </div>
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
            <li><a href="../"><img src="/images/bar_chart.png" alt="..." class="img-rounded" width="24" height="24"> Dashboards </a></li>
            <li class="active"><a href="#"><img src="/images/switch.png" alt="..." class="img-rounded" width="24" height="24"> Routerboard </a></li>
            <li><a href="../interfaces"><img src="/images/network_wired.png" alt="..." class="img-rounded" width="24" height="24"> Interfaces </a></li>
<!--			<li><a href="../qos">QoS <span class='glyphicon glyphicon-list-alt' aria-hidden='true'></a></li>
			<li><a href="../storage">Storage <span class='glyphicon glyphicon-hdd' aria-hidden='true'></span></a></li>
            <li><a href="../device">Router Device (Mikrotik) <span class='glyphicon glyphicon-dashboard' aria-hidden='true'></span></a></li>
			<li><a href="../ap">AP (Mikrotik) <span class='glyphicon glyphicon-link' aria-hidden='true'></span></a></li>
			<li><a href="../ap_clients">Wifi Connections (Mikrotik) <span class='glyphicon glyphicon-signal' aria-hidden='true'></span></a></li> -->
          </ul>
        </div>
		
<!-- Start/end date/time selection -->
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main" id="dtselection">
			<div class="panel panel-default">
				<div class="panel-body"> 
					<div class="row vertical-align">
						<div class='col-xs-3'> 
							<div class="form-group">
								<select style="width:100%" class="selector2_rb form-control" name="selector2_rb" id="selector2_rb">
<?php
$user_rbs_row = '';
if (isset($_SESSION["id"])) {
    $user_rbs_query = "
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
    /* Set the parameters */

    /* Excute the sql */
    $user_rbs_stmt = $db->prepare($user_rbs_query);
    if ($user_rbs_stmt->execute()) {
        $user_rbs_row = $user_rbs_stmt->fetchAll();
    }
	/* Process the results */
   foreach ($user_rbs_row as $key => $value) {
	echo "<option value='" . $value['sn'] . "___" . $value["sitename"] . "___" . $value["device_name"] . "___" . $value["device_model"] . "'>" . $value["sitename"] . " -> " . $value["device_name"] . "</option>";
   } 
} 
?>
								</select>
							</div>
						</div> 
						<div class='col-xs-2'>
							<div class="form-group">
								<div class='input-group date' id='sdatepicker'>
									<input type='text' class="form-control" name="sdatepickertext" id="sdatepickertext" />
									<span class="input-group-addon">
										<span class="glyphicon glyphicon-calendar"></span>
									</span>
								</div>
							</div>
						</div> 
						<div class='col-xs-2' > 
							<div class="form-group">
								<div class='input-group date' id='edatepicker'> 
									<input type='text' class="form-control" name="edatepickertext" id="edatepickertext" />
									<span class="input-group-addon">
										<span class="glyphicon glyphicon-calendar"></span>
									</span>
								</div> 
							</div>
						</div> 
						<div class='col-xs-2'> 
							<div class="form-group">
									<select style="width:100%" class="selector2_interval form-control" name="selector2_interval" id="selector2_interval">
										<option value="5min">5 minute</option>
										<option value="60min">60 minute</option>
										<option value="day">Day</option>
									</select>
							</div>
						</div> 
						<div class='col-xs-2'> 
							<div class="form-group">
								<button type="button" class="btn btn-default" name="update_selection" id="update_selection">Update</button>
							</div>
						</div>
						<?php 
							if (isset($_SESSION["rb_end_date"])) {
								echo "<input type='hidden' name='device_data_end_date_init' id='device_data_end_date_init' value='" . $_SESSION["rb_end_date"] . "'>"; 
							} else { 
								echo "<input type='hidden' name='device_data_end_date_init' id='device_data_end_date_init' value=''>"; 
							}

							if (isset($_SESSION["rb_start_date"])) {
								echo "<input type='hidden' name='device_data_start_date_init' id='device_data_start_date_init' value='" . $_SESSION["rb_start_date"] . "'>"; 
							} else { 
								echo "<input type='hidden' name='device_data_start_date_init' id='device_data_start_date_init' value=''>"; 
							}

							if (isset($_SESSION["rb_interval"])) {
								echo "<input type='hidden' name='device_data_interval_init' id='device_data_interval_init' value='" . $_SESSION["rb_interval"] . "'>"; 
							} else { 
								echo "<input type='hidden' name='device_data_interval_init' id='device_data_interval_init' value=''>"; 
							}

							if (isset($_SESSION["rb_des"])) {
								echo "<input type='hidden' name='device_des_init' id='device_des_init' value='" . $_SESSION["rb_des"] . "'>"; 
							} else { 
								echo "<input type='hidden' name='device_des_init' id='device_des_init' value=''>"; 
							}

							if (isset($_SESSION["rb_site"])) {
								echo "<input type='hidden' name='device_site_init' id='device_site_init' value='" . $_SESSION["rb_site"] . "'>"; 
							} else { 
								echo "<input type='hidden' name='device_site_init' id='device_site_init' value=''>"; 
							}
						
							if (isset($_SESSION["rb_sn"])) {
								echo "<input type='hidden' name='device_sn_init' id='device_sn_init' value='" . $_SESSION["rb_sn"] . "'>"; 
							} else { 
								echo "<input type='hidden' name='device_sn_init' id='device_sn_init' value=''>"; 
							}
						?>
						<input type="hidden" name="device_data_end_date_change" id="device_data_end_date_change" value="0">
						<input type="hidden" name="device_data_start_date_change" id="device_data_start_date_change" value="0">					
					</div>
					<div class="row">
						<div class='col-xs-5'>
							<div id="feedback"></div>
						</div>
					</div>
				</div> 
			</div>
		</div>
			

          <!-- <h2 class="sub-header">Results</h2> -->
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main" id="results">
				<div class="panel panel-default">
					<div class="panel-heading">
						<h3 class="panel-title"><div id="sel_device"> <?php if (isset($_SESSION["rb_des"])) { echo "Site: <span style='color: rgb(0, 0, 153);'><b>" . $_SESSION["rb_site"] . "</span></b> Routerboard: <span style='color: rgb(0, 0, 153);'><b>" . $_SESSION["rb_des"] . "</span></b> "; } else { echo "No routerboard has been selected "; } ?></div></h3>
					</div>
				</div>
	
			<!-- <div align="center">-->
				<div class="panel panel-default">
					<div class="panel-body">
						<div class="row">
							<div class='col-md-12'> 
								<div id="cpu_load" style="height: 400px; width: 100%; margin: 0 auto"></div>
							</div>
						</div>	
						<div class="row">
							<div class="col-md-12">
								<div id="rb_storage_devices" style="height: 400px; width: 100%; margin: 0 auto"></div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<div id="dev_readings" style="height: 400px; width: 100%; margin: 0 auto"></div>
							</div>
						</div>
					</div>
				</div>
<!--			<div align="center">
				<div id="cpu_load" style="height: 400px; width: 100%; margin: 0 auto"></div>
				<div id="rb_storage_devices" style="height: 400px; width: 100%; margin: 0 auto"></div>
				<div id="dev_readings" style="height: 400px; width: 100%; margin: 0 auto"></div>
			</div> -->
		</div>
	  

    </div>
    