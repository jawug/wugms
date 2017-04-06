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
					<li><a href="../">My Routerboard Management</a></li>
					<li><a href="../conrev">Config Review <span class='glyphicon glyphicon-cog' aria-hidden='true'></span></a></li>
					<li><a href="../ipv4">IPv4 Assignments <span class='glyphicon glyphicon-import' aria-hidden='true'></span></a></li>
					<li class="active"><a href="#">Remote Commands <span class='glyphicon glyphicon-share' aria-hidden='true'></span></a></li>
				</ul>
			</div>

			<div class="row">
				<div class="col-md-1"></div>
				<!-- IP/host -->
				<div class="col-md-5">
					<div class="panel panel-primary">
						<div class="panel-heading">IP/hostname and user credentials</div>
						<div class="panel-body">
							<label for="inputHost" class="sr-only">Host</label>
							<input type="text" id="inputHost" value="172.16.83.12" class="form-control" placeholder="a.b.c.d" required autofocus>
							<p></p>
							<label for="inputUser" class="sr-only">User</label>
							<input type="text" id="inputUser" value="qwerty" class="form-control" placeholder="admin" required autofocus>	
							<p></p>
							<label for="inputPassword" class="sr-only">Password</label>
							<input type="password" id="inputPassword" value="qwerty" class="form-control" placeholder="Password" >
						</div>
					</div>
				</div>
				<!-- Commands -->
				<div class="col-md-5">
					<div class="panel panel-info">
						<div class="panel-heading">Remote command</div>
						<div class="panel-body">
							<label for="inputCMD" class="sr-only">Command</label>
							<select data-placeholder="Select network device..." class="chzn-select-rbcmd" style="width:437px;" id="inputCMD" name="inputCMD" >
								<option value="rbcmd1">Display Resources</option>
								<option value="rbcmd2">Reboot Device</option>
								<option value="rbcmd3">Ping</option>
								<option value="rbcmd4">Traceroute</option>
								<option value="rbcmd5">Log entries</option>
								<option value="rbcmd6">Neighbour List</option>
								<option value="rbcmd7">Wireless Tables - Registration</option>
							</select>
							<p></p>
							<div id="iphost" style="display:none">
								<input type="text" id="inputRemAddress" value="127.0.0.1" class="form-control" placeholder="IP or host name">
							</div>
							<p></p>
							<div id="usedns" style="display:none">
								<div class="checkbox">
									<label><input type="checkbox" id="inputUseDNS" value="" > Use DNS</label>
								</div>
							</div>
							<p></p>
							<button class="btn btn-lg btn-info btn-block" id="qwerty" >Send command</button>
						</div>
					</div>
				</div>
				<div class="col-md-4"></div> 
			</div>
			<div class="row">
				<hr>
				<div class="col-md-1"></div>
				<div class="col-md-10">
					<div id="results"></div>
				</div>
				<div class="col-md-1"></div>
			</div>
			<div class="log"></div>
		</div>
	</div> 