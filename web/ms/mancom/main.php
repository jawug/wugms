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
					<li class="active"><a href="#">Overview</a></li>
					<li><a href="payments">Payments <span class='glyphicon glyphicon-edit' aria-hidden='true'></span></a></li>
					<li><a href="audit">Audit <span class='glyphicon glyphicon-check' aria-hidden='true'></span></a></li>
					<li><a href="members">Members <span class='glyphicon glyphicon-user' aria-hidden='true'></span></a></li>
				</ul>
			</div>
<!--		<form name="form_field"> -->
			<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main" id="header">
				<h1 class="page-header">Overview</h1>
				<div align="center">
					<p> Shown below is the user list as well and account status of each user. </p>
				</div>
			</div>
			<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main" id="header">
				<div class="panel panel-primary">
					<div class="panel-heading"><b>User accounts - Membership status</b></div>
					<div class="panel-body">
						<table id='user_accounts_table' data-url="/content/wugms.table.mancom.user.current.account.php" data-toggle="table" data-classes="table table-hover table-condensed" data-striped="true" data-search="true" >
							<thead>
								<tr>
									<th data-field="irc_nick" data-sortable="true">User</th>
									<th data-field="mancom_account_nr" data-sortable="true">Account No.</th>
									<th data-field="acc_status" data-sortable="true">Account Status</th>
									<th data-field="pdate" data-sortable="true">Payment Date(Last)</th>
<!--									<th data-field="payment_type" data-sortable="true">payment_type</th> -->
									<th data-field="payment_method" data-sortable="true">Payment Method</th>
									<th data-field="amount" data-sortable="true">Amount</th>
								</tr>
							</thead>
						</table>
					</div>
				</div>
				<div class="panel panel-info">
					<div class="panel-heading"><b>Payments received (Last 90 days)</b></div>
					<div class="panel-body">
						<table id='user_accounts_table' data-url="/content/wugms.table.mancom.payments.received.php" data-toggle="table" data-classes="table table-hover table-condensed" data-striped="true" data-search="true" >
							<thead>
								<tr>
									<th data-field="pdate" data-sortable="true">Payment Date</th>
									<th data-field="irc_nick" data-sortable="true">User</th>
									<th data-field="payment_type" data-sortable="true">Payment Type</th>
									<th data-field="payment_method" data-sortable="true">Payment Method</th>
									<th data-field="amount" data-sortable="true">Amount</th>
									<th data-field="comment" data-sortable="true">Comment</th>
								</tr>
							</thead>
						</table>
					</div>
				</div>
				<div class="panel panel-info">
					<div class="panel-heading"><b>Current MANCOM members</b></div>
					<div class="panel-body">
						<table id='user_accounts_table' data-url="/content/wugms.table.mancom.users.php?role=mancom" data-toggle="table" data-classes="table table-hover table-condensed" data-striped="true" data-search="true" >
							<thead>
								<tr>
									<th data-field="irc_nick" data-sortable="true">IRC Nick</th>
									<th data-field="firstName" data-sortable="true">Name</th>
									<th data-field="lastName" data-sortable="true">Surname</th>
									<th data-field="mancom_account_nr" data-sortable="true">MANCOM Account No.</th>
									<th data-field="acc_status" data-sortable="true">WUGMS Account Status</th>
									<th data-field="max_sites" data-sortable="true">Max Sites</th>
									<th data-field="cdate" data-sortable="true">Reg. Date</th>
								</tr>
							</thead>
						</table>
					</div>
				</div>				
			</div>				
		</div>		
	</div>