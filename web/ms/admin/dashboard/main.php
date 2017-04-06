		<div class="pagetitle" id="page_adm_dash"> </div>
		<!-- Help modal -->
		<div class="modal fade"  id="myHelpModal" >
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title">Help - Overview</h4>
					</div>
					<div class="modal-body">
						<p>This is the landing page for the "Dashboards" section of WUGMS for admin use.
						It lists all of the "core network devices" that are been loaded via RBCP.</p>
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
					<li class="active"><a href="#"><img src="/images/bar_chart.png" alt="..." class="img-rounded" width="24" height="24"> Dashboards </a></li>
					<!--<li><a href="routerboard">Routerboard <span class='glyphicon glyphicon-tasks' aria-hidden='true'></span></a></li> -->
					<li><a href="routerboard"><img src="/images/switch.png" alt="..." class="img-rounded" width="24" height="24"> Routerboard </a></li>
					<li><a href="interfaces"><img src="/images/network_wired.png" alt="..." class="img-rounded" width="24" height="24"> Interfaces </a></li>
					<!--<li><a href="interfaces">Interfaces <span class='glyphicon glyphicon-random' aria-hidden='true'></span></a></li> -->
				</ul>
			</div>
<!--		<form name="form_field"> -->
			<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main" id="header">
				<h1 class="page-header">Overview</h1>
				<div align="center">
					<p> These dashboards are designed to provide the admin group, with the means to review the performance of core network devices that are connected to the JAWUG network </p>
					<p> The dashboards only work if snmp is enabled on the devices and wugms ETL has been set to collect data from them. </p>
				</div>
			</div>
			<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main" id="header">
				<div class="panel panel-primary">
					<div class="panel-heading"><b>Core Network Devices</b></div>
<!--					<div class="panel-body">  -->
						<table id='ssid_ap_table' data-url="/content/wugms.table.admin.devices.php" data-toggle="table" data-classes="table table-hover table-condensed" data-striped="true" data-search="true" >
							<thead>
								<tr>
									<th data-formatter="runningFormatter">#</th>
									<th data-field="sitename" data-sortable="true">Site</th>
									<th data-field="device_name" data-sortable="true">Device name</th>
									<th data-field="device_make" data-sortable="true">Make</th>
									<th data-field="device_model" data-sortable="true">Model</th>
									<th data-field="sn" data-sortable="true">Serial Number</th>
									<th data-field="os_ver" data-sortable="true">OS ver</th>
									<th data-field="cdn_owner" data-sortable="true">Device Owner</th>
									<th data-field="site_owner_name" data-sortable="true">Site Owner</th>
									<th data-field="seen_rbcp" data-sortable="true">Last seen by RBCP</th>
									<th data-field="seen_snmp" data-sortable="true">Last seen on the network</th>
								</tr>
							</thead>
						</table>
<!--					</div> -->
				</div>		
			</div>				
		</div>		
	</div>