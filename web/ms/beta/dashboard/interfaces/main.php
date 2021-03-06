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
						<p>The "selector" shows routerboards and interfaces where the user is either the owner or the equipment is located at the user's site. </p>
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
					<li><a href="../routerboard">Routerboard <span class='glyphicon glyphicon-tasks' aria-hidden='true'></span></a></li>
					<li class="active"><a href="../interfaces">Interfaces <span class='glyphicon glyphicon-random' aria-hidden='true'></a></li>
				</ul>
			</div>

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
  SELECT device_make,
       device_model,
       os_ver,
       device_name,
       sitename,
       b.sn
  FROM (SELECT sn
          FROM (SELECT b.ae_Serial_Number 'sn'
                  FROM tbl_ae_sites_rbs b, tbl_base_sites a, tbl_base_sites c
                 WHERE     a.idSite_Owner = :user_id
                       AND b.ae_siteID = a.siteID
                       AND a.idSite_Owner = c.idSite_Owner) a
        UNION
        SELECT sn
          FROM (SELECT d.Serial_Number 'sn'
                  FROM tbl_base_rb_routerboard d
                 WHERE idSite_Owner = :user_id) b) AS a
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
    /* Set the parameters */
    $user_rbs_query_params = array(
        ':user_id' => $_SESSION["id"]
    );
    /* Excute the sql */
    $user_rbs_stmt = $db->prepare($user_rbs_query);
    if ($user_rbs_stmt->execute($user_rbs_query_params)) {
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
									<select style="width:100%" class="selector2_interfaces form-control" name="selector2_interfaces" id="selector2_interfaces">
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
									<button type="button" class="btn btn-default" name="update_selection" id="update_selection" >Update</button>
								</div>
							</div>
							<?php 
								if (isset($_SESSION["rb_iface_end_date"])) {
									echo "<input type='hidden' name='device_data_end_date_init' id='device_data_end_date_init' value='" . $_SESSION["rb_iface_end_date"] . "'>"; 
								} else { echo "<input type='hidden' name='device_data_end_date_init' id='device_data_end_date_init' value=''>"; }

								if (isset($_SESSION["rb_iface_start_date"])) {
									echo "<input type='hidden' name='device_data_start_date_init' id='device_data_start_date_init' value='" . $_SESSION["rb_iface_start_date"] . "'>"; 
								} else { echo "<input type='hidden' name='device_data_start_date_init' id='device_data_start_date_init' value=''>"; }

								if (isset($_SESSION["rb_iface_interval"])) {
									echo "<input type='hidden' name='device_data_interval_init' id='device_data_interval_init' value='" . $_SESSION["rb_iface_interval"] . "'>"; 
								} else { echo "<input type='hidden' name='device_data_interval_init' id='device_data_interval_init' value=''>"; }

								if (isset($_SESSION["rb_iface_des"])) {
									echo "<input type='hidden' name='device_des_init' id='device_des_init' value='" . $_SESSION["rb_iface_des"] . "'>"; 
								} else { echo "<input type='hidden' name='device_des_init' id='device_des_init' value=''>"; }

								if (isset($_SESSION["rb_iface_site"])) {
									echo "<input type='hidden' name='device_site_init' id='device_site_init' value='" . $_SESSION["rb_iface_site"] . "'>"; 
								} else { echo "<input type='hidden' name='device_site_init' id='device_site_init' value=''>"; }					
						
								if (isset($_SESSION["rb_iface_sn"])) {
									echo "<input type='hidden' name='device_sn_init' id='device_sn_init' value='" . $_SESSION["rb_iface_sn"] . "'>"; 
								} else { echo "<input type='hidden' name='device_sn_init' id='device_sn_init' value=''>"; }
					
								if (isset($_SESSION["rb_iface_sel"])) {
									echo "<input type='hidden' name='device_iface_init' id='device_iface_init' value='" . $_SESSION["rb_iface_sel"] . "'>"; 
								} else { echo "<input type='hidden' name='device_iface_init' id='device_iface_init' value=''>"; }
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
<!--	  $('#sel_device').html("<h3 class='sub-header'>Results for: <span style='color: rgb(0, 0, 153);'>" + res[2] + "</span> interface: <span style='color: rgb(0, 0, 153);'>" + res2[1] + "</span></h3>"); -->
          <!-- <h2 class="sub-header">Results</h2> -->
			<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main" id="header">
				<div class="panel panel-default">
					<div class="panel-heading">
						<h3 class="panel-title"><div id="sel_device"> <?php if (isset($_SESSION["rb_iface_des"])) { echo "Site: <span style='color: rgb(0, 0, 153);'><b>" . $_SESSION["rb_iface_site"] . "</span></b> Routerboard: <span style='color: rgb(0, 0, 153);'><b>" . $_SESSION["rb_iface_des"] . "</span></b> Interface: <span style='color: rgb(0, 0, 153);'><b>" . $_SESSION["rb_iface_sel_des"] . "</b></span> Type: <span style='color: rgb(0, 0, 153);'><b>" . $_SESSION["rb_iface_type"] . "</b></span>"; } else { echo "No routerboard has been selected "; } ?></div></h3>
					</div>
				</div>
	
			<!-- <div align="center">-->
				<div class="panel panel-default">
					<div class="panel-body">
						<div class="row">
							<div class='col-md-12'> 
								<div id="interface_speed" style="height: 400px; width: 100%; margin: 0 auto"></div>
							</div>
						</div>	
						<div class="row">						
							<div class="col-md-6">
								<div id="interface_packets" style="height: 400px; width: 100%; margin: 0 auto"></div>
							</div>
							<div class="col-md-6">
								<div id="interface_data" style="height: 400px; width: 100%; margin: 0 auto"></div>
							</div>
						</div>
					</div>
				</div>
<!--				<div class="row">
					<div class='col-md-12'>   class='sub-header'
						<div id="interface_chart" style="height: 400px; width: 100%; margin: 0 auto"></div>
					</div>
					<div class='col-md-10'> 
						<div id="interface_packets" style="height: 400px; width: 50%; margin: 0 auto; diplay:inline"></div>
						<div id="interface_data" style="height: 400px; width: 50%; margin: 0 auto; diplay:inline"></div>
					</div>
				</div> -->
<!--			</div> -->
			</div>
		</div>
	</div>