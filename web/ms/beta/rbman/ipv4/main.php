	<body>
		<!-- Help modal -->
		<div class="modal fade"  id="myHelpModal" >
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title">Help - SSID</h4>
					</div>
					<div class="modal-body">
						<p>This page displays the wifi connections back to the routerboard, consider this data the "opposite" end of an AP. </p>
						<p>The selector displays data based on the user's equipment and sites.</p>
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
					<li class="active"><a href="#">IPv4 Assignments <span class='glyphicon glyphicon-import' aria-hidden='true'></span></a></li>
					<li><a href="../remcmd">Remote Commands <span class='glyphicon glyphicon-share' aria-hidden='true'></span></a></li>
         </ul>
      </div>
      <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main" id="header">
         <!--			<h1 class="page-header"> </h1> -->

      </div>
   </div>
   <!-- <h2 class="sub-header">Results</h2> -->
   <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main" id="header">
	  <!-- table for connected clients -->
      <div class="panel panel-info">
         <div class="panel-heading"><b>Configured IP Addresses (V4)</b></div>
         <div class="panel-body">
            <table id='ssid_client_table' data-url="/content/wugms.table.user.rb.ipv4.all.php" data-toggle="table" data-classes="table table-hover table-condensed" data-striped="true" data-show-columns="true" data-search="true" data-show-toggle="true">
               <thead>
                  <tr>
                     <th data-field="ipv4" data-sortable="true">Address</th>
                     <th data-field="interface" data-sortable="true">Interface</th>
                     <th data-field="network" data-sortable="true">Network</th>
                     <th data-field="maskbits" data-sortable="true">Maskbits</th>
                     <th data-field="status" data-sortable="true">Status</th>
                     <th data-field="comment" data-sortable="true">Comment</th>
                     <th data-field="device_model" data-sortable="true">Device Model</th>
                     <th data-field="device_name" data-sortable="true">Device Identity</th>
                     <th data-field="sitename" data-sortable="true">Sitename</th>
                  </tr>
               </thead>
            </table>
         </div>
      </div>
      <!--     </div> -->
   </div>
</div>