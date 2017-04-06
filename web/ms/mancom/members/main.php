		<div class="pagetitle" id="page_mancom"> </div>
		<!-- Help modal -->
		<div class="modal fade"  id="myHelpModal" >
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title">Help - Overview</h4>
					</div>
					<div class="modal-body">
						<p>This is the landing page for the "MANCOM" section of WUGMS.
						It lists all of the functions that are attributed to the MANCOM group.</p>
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
					<li><a href="../audit">Audit <span class='glyphicon glyphicon-check' aria-hidden='true'></span></a></li>
					<li class="active"><a href="#">Members <span class='glyphicon glyphicon-user' aria-hidden='true'></span></a></li>
				</ul>
			</div>
<!--		<form name="form_field"> -->
			<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main" id="header">
				<h1 class="page-header">Promote/Demote Users to MANCOM role</h1>
				<div align="center">
					<p> Shown below is the user list as well and account status of each user. </p>
				</div>
			</div>
			<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main" id="header">
				<div class="panel panel-info">
					<div class="panel-heading"><b>Select which users are to have the role of "MANCOM" access</b></div>
					<div class="panel-body">
						<div id="toolbar">
							<button id="update_btn" class="btn btn-default">Update MANCOM members</button>
						</div>
						<table id='user_accounts_table' data-url="/content/wugms.table.mancom.users.php" data-toggle="table" data-classes="table table-hover table-condensed" data-striped="true" data-search="true" data-click-to-select="true">
							<thead>
								<tr>
									<th data-field="state" data-checkbox="true"></th>
									<th data-formatter="runningFormatter">#</th>
									<th data-field="firstName" data-sortable="true">Name</th>
									<th data-field="lastName" data-sortable="true">Surname</th>									
									<th data-field="irc_nick" data-sortable="true">IRC Nick</th>
									<th data-field="acc_status" data-sortable="true">WUGMS Account Status</th>
									<th data-field="roles" data-sortable="true">Current Roles</th>
								</tr>
							</thead>
						</table>
					</div>
				</div>				
			</div>				
		</div>		
	</div>