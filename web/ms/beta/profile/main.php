		<!-- Help modal -->
		<div class="modal fade" id="myHelpModal" >
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title">Help - User Profile</h4>
					</div>
					<div class="modal-body">
						<p>This page displays the user's information as per when the registration form was filled in. 
						The "user roles" detail what type of access the user has on this site as well as what functions they can perform. </p>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-success" data-dismiss="modal">Close</button>
					</div>
				</div><!-- /.modal-content -->
			</div><!-- /.modal-dialog -->
		</div><!-- /.modal -->
		<!-- Profile display -->
		
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-12">
					<div class="panel panel-primary">
						<div class="panel-heading">
							<h3 class="panel-title">Profile</h3>
						</div>
						<div class="panel-body">
							<form class="form-horizontal">
							<!-- Display the user's profile -->
								<div class="form-group">
									<label for="name" class="col-md-4 control-label">Name</label>
									<div class="col-md-6">
										<input type="text" class="form-control" id="name" value="<?php echo $_SESSION["firstName"] ?>" readonly>
									</div>
								</div>
								
								<div class="form-group">
									<label for="surname" class="col-md-4 control-label">Surname</label>
									<div class="col-md-6">
										<input type="text" class="form-control" id="surname" value="<?php echo $_SESSION["lastName"] ?>" readonly>
									</div>
								</div>
					
								<div class="form-group">
									<label for="ircnick" class="col-md-4 control-label">IRCNick</label>
									<div class="col-md-6">
										<input type="text" class="form-control" id="ircnick" value="<?php echo $_SESSION["irc_nick"] ?>" readonly>
									</div>
								</div>

								<div class="form-group">
									<label for="username" class="col-md-4 control-label">Username</label>
									<div class="col-md-6">
										<input type="email" class="form-control" id="username" value="<?php echo $_SESSION["username"] ?>" readonly>
									</div>
								</div>
								
								<div class="form-group">
									<label for="maxsites" class="col-md-4 control-label">Max Sites</label>
									<div class="col-md-6">
										<input type="text" class="form-control" id="maxsites" value="<?php echo $_SESSION["max_sites"] ?>" readonly>
									</div>
								</div>
								
								<div class="form-group">
									<label for="phonenum" class="col-md-4 control-label">Phone number</label>
									<div class="col-md-6">
										<input type="text" class="form-control" id="phonenum" value="<?php echo $_SESSION["phone_num"] ?>" readonly>
									</div>
								</div>

								<div class="form-group">
									<label for="dob" class="col-md-4 control-label">Date of Birth</label>
									<div class="col-md-6">
										<input type="text" class="form-control" id="dob" value="<?php echo $_SESSION["dob"] ?>" readonly>
									</div>
								</div>
								
								<div class="form-group">
									<label for="joindate" class="col-md-4 control-label">Join date</label>
									<div class="col-md-6">
										<input type="text" class="form-control" id="joindate" value="<?php echo $_SESSION["join_date"] ?>" readonly>
									</div>
								</div>

								<div class="form-group">
									<label for="accountstatus" class="col-md-4 control-label">Account Status</label>
									<div class="col-md-6">
										<input type="text" class="form-control" id="accountstatus" value="<?php echo $_SESSION["acc_status"] ?>" readonly>
									</div>
								</div>

								<div class="form-group">
									<label for="mancom_account_nr" class="col-md-4 control-label">MANCOM Account number</label>
									<div class="col-md-6">
										<input type="text" class="form-control" id="mancom_account_nr" value="<?php echo $_SESSION["mancom_account_nr"] ?>" readonly>
									</div>
								</div>
						</div>
					</div>
				</div>
			</div>

			<hr>
		
			<div class="row">
				<div class="col-md-12">
					<div class="panel panel-info">
						<div class="panel-heading">
							<h3 class="panel-title">User roles</h3>
						</div>
						<div class="panel-body">
							<table id='user_roles_table' data-url="/content/wugms.table.user.roles.php" data-toggle="table" data-classes="table table-hover table-condensed" data-striped="true">
								<thead>
									<tr>
										<th data-formatter="runningFormatter">#</th>
										<th data-field="roll_id" data-sortable="true">Role</th>
										<th data-field="comment" data-sortable="true">Description</th>
									</tr>
								</thead>
							</table>	
						</div>
					</div>
				</div>
			</div>

			<hr>
		
			<div class="row">
				<div class="col-md-12">
					<div class="panel panel-success">
						<div class="panel-heading">
							<h3 class="panel-title">Payments made</h3>
						</div>
						<div class="panel-body">
							<table id='user_roles_table' data-url="/content/wugms.table.user.payments.php" data-toggle="table" data-classes="table table-hover table-condensed" data-striped="true">
								<thead>
									<tr>
										<th data-formatter="runningFormatter">#</th>
										<th data-field="pdate" data-sortable="true">Date</th>
										<th data-field="idpayment_type" data-sortable="true">Type</th>
										<th data-field="idpayment_method" data-sortable="true">Method</th>
										<th data-field="comment" data-sortable="true">Comment</th>
										<th data-field="amount" data-sortable="true">Amount</th>
									</tr>
								</thead>
							</table>	
						</div>
					</div>
				</div>
			</div>
		</div>