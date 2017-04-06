	<body>
		<!-- Help modal -->
		<div class="modal fade"  id="myHelpModal" >
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title">Help - User History</h4>
					</div>
					<div class="modal-body">
						<p>This page displays the user's history on the site. Entries shown here include login/logout as well as site administration.</p>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-success" data-dismiss="modal">Close</button>
					</div>
				</div><!-- /.modal-content -->
			</div><!-- /.modal-dialog -->
		</div><!-- /.modal -->
		<div id="welcome_section" class="container-fluid">
			<div class="col-md-12"><h2>User history</h2>
					
			</div>
			<div class="row">
				<div class="col-md-12" id="header"> 
					<br />
					<div class="panel panel-primary">
<!--						<div class="panel-heading">
							<h2 class="panel-title"><b>Payments Audit History</b></h2>
						</div> -->
						<div class="panel-body">
							<table id='user_accounts_table' data-url="/content/wugms.table.user.history.php" data-toggle="table" data-classes="table table-hover table-condensed" data-striped="true" data-search="true" >
								<thead>
									<tr>
										<th data-field="adate" data-sortable="true">Date</th>
										<th data-field="ip_address" data-sortable="true">IP Address</th>
										<th data-field="level" data-sortable="true">Level</th>
										<th data-field="area" data-sortable="true">Area</th>
										<th data-field="action" data-sortable="true">Action</th>
										<th data-field="msg" data-sortable="true">Description</th>
										<th data-field="browser_agent" data-sortable="true">Browser Agent</th>
									</tr>
								</thead>
							</table>
						</div>
					</div>
				</div>

		</div> 
		</div> <!-- /container -->