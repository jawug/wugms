	<body>
		<div class="pagetitle" id="page_adm_rb_man"> </div>	
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
					<li><a href="../"><img src="/images/switch.png" alt="..." class="img-rounded" width="24" height="24"> Routerboard Management </a></li>
					<li><a href="../conrev"><img src="/images/folder_network.png" alt="..." class="img-rounded" width="24" height="24"> Config Review </a></li>
					<li><a href="../ipv4"><img src="/images/ip_pyramid.png" alt="..." class="img-rounded" width="24" height="24"> IPv4 Assignments </a></li>
					<li class="active"><a href="#"><img src="/images/arrow_switch-128.png" alt="..." class="img-rounded" width="24" height="24"> BGP Assignments </a></li>
					<li><a href="../remcmd"><img src="/images/settings.png" alt="..." class="img-rounded" width="24" height="24"> Remote Commands </a></li>
					<li><a href="../rbassign"><img src="/images/stock_task_assigned_to.png" alt="..." class="img-rounded" width="24" height="24"> Routerboard Allocation </a></li>
         </ul>
      </div>
      <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main" id="header">
         <!--			<h1 class="page-header"> </h1> -->

      </div>
   </div>
   <!-- <h2 class="sub-header">Results</h2> -->
   <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main" id="header">
	  <!-- BGP Instances -->
      <div class="panel panel-default">
         <div class="panel-heading"><b>Configured BGP Instances</b></div>
<!--         <div class="panel-body">  -->
            <table id='ssid_client_table' data-url="/content/wugms.table.admin.bgp.instance.php" data-toggle="table" data-classes="table table-hover table-condensed" data-striped="true" data-show-columns="true" data-search="true" data-show-toggle="true">
               <thead>
                  <tr>
				     <th data-field="as_value" data-sortable="true">AS</th>
					 <th data-field="router_idStr" data-sortable="true">Router ID</th>
					 <th data-field="disabled" data-sortable="true">Status</th>
                     <th data-field="name" data-sortable="true">BGP Instance name</th>
					 <th data-field="out_filter" data-sortable="true">Out Filter</th>
					 <th data-field="sitename" data-sortable="true">Sitename</th>
					 <th data-field="device_name" data-sortable="true">RB Name</th>
                     <th data-field="client_to_client_reflection" data-sortable="true" data-visible="false">Client2Client Reflection</th>
                     <th data-field="redistribute_connected" data-sortable="true" data-visible="false">Redistribute Connected</th>
					 <th data-field="redistribute_other_bgp" data-sortable="true">Redistribute Other BGP</th>
                  </tr>
               </thead>
            </table>
<!--         </div> -->
      </div>
	  <!-- BGP Peers -->
      <div class="panel panel-info">
         <div class="panel-heading"><b>Configured BGP Peers</b></div>
<!--         <div class="panel-body"> -->
            <table id='ssid_client_table' data-url="/content/wugms.table.admin.bgp.peer.php" data-toggle="table" data-classes="table table-hover table-condensed" data-striped="true" data-show-columns="true" data-search="true" data-show-toggle="true">
               <thead>
                  <tr>
                     <th data-field="SiteName" data-sortable="true">Site</th>
                     <th data-field="RB_identity" data-sortable="true">Routerboard</th>
					 <th data-field="local_as" data-sortable="true">Local AS</th>
                     <th data-field="address_families" data-sortable="true">Address Families</th>
                     <th data-field="disabled" data-sortable="true">Status</th>
                     <th data-field="in_filter" data-sortable="true">IN Filter</th>
                     <th data-field="out_filter" data-sortable="true">OUT Filter</th>
                     <th data-field="remote_addressStr" data-sortable="true">Peer Remote Address</th>
                     <th data-field="remote_as" data-sortable="true">Peer AS</th>
                     <th data-field="update_source" data-sortable="true">Interface</th>
                  </tr>
               </thead>
            </table>
<!--         </div> -->
      </div>	  
      <!--     </div> -->
   </div>
</div>