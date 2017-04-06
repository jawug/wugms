	<body>
		<div class="pagetitle" id="page_adm_users"> </div>
		<!-- Help modal -->
		<div class="modal fade"  id="myHelpModal" >
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title">Help - Audit</h4>
					</div>
					<div class="modal-body">
						<p>This page shows a list of actions made by users.</p>
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
						<li><a href="../users">Users <span class='glyphicon glyphicon-edit' aria-hidden='true'></span></a></li>
						<li class="active"><a href="#">Audit <span class='glyphicon glyphicon-check' aria-hidden='true'></span></a></li>
					</ul>
				</div>
				<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main" id="header">
					<h1 class="page-header">Audit</h1>
					<div align="center">
						<p> Show below are the actions performed by the selected user. </p>
					</div>
					<div>
						<div class="col-sm-offset-4 col-sm-3">
							<div class="form-group">
								<select class="combobox form-control"  id="select_user" name="select_user">
									<option value="" selected="selected">Select user...</option>
										<?php
											/* Set up the SQL query */
											$subquery = "SELECT a.idtbl_base_user, a.irc_nick 'user'
														FROM tbl_base_user a
														ORDER BY a.irc_nick;";
											/* Prepare the SQL for execute */
											$substmt = $db->prepare($subquery);
											/* Execute the query */
											if ($substmt->execute()) {
												$subresult = $substmt->fetchAll(PDO::FETCH_ASSOC);
											}
											/* Display the returned row(s) */
											foreach ($subresult as $row) {
												echo "<option value='" . $row['idtbl_base_user'] . "'>" . $row['user'] . "</option>";
											}
										?>	
								</select>
							</div>
						</div>
					</div>
				</div>
				<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main" id="header">
					<br />
					<div class="panel panel-primary">
						<div class="panel-heading">
							<h2 class="panel-title"><b>User Audit History</b></h2>
						</div>
<!--						<div class="panel-body"> -->
							<table id='user_audit_table' data-url="/content/wugms.table.admin.user.audit.php" data-toggle="table" data-classes="table table-hover table-condensed" data-striped="true" data-search="true" >
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
<!--						</div>  -->
					</div>
				</div>
			</div>
		</div>
