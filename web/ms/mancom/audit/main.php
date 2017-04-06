		<div class="pagetitle" id="page_mancom"> </div>
		<!-- Help modal -->
		<div class="modal fade"  id="myHelpModal" >
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title">Help - Audit</h4>
					</div>
					<div class="modal-body">
						<p>This page shows a list of actions made by mancom members with regards to the payments/donations by members.</p>
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
						<li><a href="../">Overview</a></li>
						<li><a href="../payments">Payments <span class='glyphicon glyphicon-edit' aria-hidden='true'></span></a></li>
						<li class="active"><a href="#">Audit <span class='glyphicon glyphicon-check' aria-hidden='true'></span></a></li>
						<li><a href="../members">Members <span class='glyphicon glyphicon-user' aria-hidden='true'></span></a></li>
					</ul>
				</div>
				<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main" id="header">
					<h1 class="page-header">Audit</h1>
					<div align="center">
						<p> Shown below are auditing logs with regards to mancom members who have made additions, changes and deletions with regards to payments/donations made by members of this organisation. </p>
					</div>
				</div>
				<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main" id="header">
					<br />
					<div class="panel panel-primary">
						<div class="panel-heading">
							<h2 class="panel-title"><b>Payments Audit History</b></h2>
						</div>
						<div class="panel-body">
							<table id='user_accounts_table' data-url="/content/wugms.table.mancom.audit.php" data-toggle="table" data-classes="table table-hover table-condensed" data-striped="true" data-search="true" >
								<thead>
									<tr>
										<th data-field="session_date" data-sortable="true">Date</th>
										<th data-field="username" data-sortable="true">User</th>
										<th data-field="level" data-sortable="true">Level</th>
										<th data-field="area" data-sortable="true">Area</th>
										<th data-field="action" data-sortable="true">Action</th>
										<th data-field="msg" data-sortable="true">Description</th>
									</tr>
								</thead>
							</table>				
						</div>
					</div>
				</div>
			</div>
		</div>
