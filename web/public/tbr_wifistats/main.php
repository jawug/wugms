	<div class="pagetitle" id="page_wifi"> </div> 
	<div class="container-fluid theme-showcase" role="main">
		<!-- modal start -->
		<div class="modal fade"  id="myHelpModal" >
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title">Help - SSID</h4>
					</div>
					<div class="modal-body">
						<p>This modal provides help on the page displayed.</p>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-success" data-dismiss="modal">Close</button>
					</div>
				</div>
			</div>
		</div>
		<!-- modal end -->
		<div class="container-fluid">
			<div class="col-md-12">
				<div class="panel panel-default">
					<div class="panel-heading">
						<h2 class="panel-title text-center"><b>Wifi Overview</b> <img src="../images/wifi.png" alt="..." class="img-rounded" width="24" height="24"></h2>
					</div>
<!--					<div class="panel-body">  -->
						<div class="row">
							<div class="col-md-6">
								<div id="wifi_24GHz" style="height: 400px; margin: 0 auto"></div>
							</div>
							<div class="col-md-6">
								<div id="wifi_58GHz" style="height: 400px; margin: 0 auto"></div>
							</div>
						</div>
						<hr>
						<div class="row">
							<div class="col-md-12">
								<table id='wifi_table' data-url="/content/wugms.table.rb.php" data-toggle="table" data-classes="table table-hover table-condensed" data-striped="true" data-search="true" >
									<thead>
										<tr>
											<th data-field="sitename" data-sortable="true">Sitename</th>
											<th data-field="owner" data-sortable="true">Equipment Owner</th>
											<th data-field="band" data-sortable="true">Band</th>
											<th data-field="frequency" data-sortable="true">Frequency</th>
											<th data-field="channel_width" data-sortable="true">Channel Width</th>
											<th data-field="antenna_gain" data-sortable="true">Antenna Gain</th>
											<th data-field="country" data-sortable="true">Country</th>
											<th data-field="ssid" data-sortable="true">SSID</th>
											<th data-field="wireless_protocol" data-sortable="true">Protocol</th>
										</tr>
									</thead>
								</table>
							</div>
						</div>
<!--					</div>  -->
				</div>
			</div>
		</div>
	</div>