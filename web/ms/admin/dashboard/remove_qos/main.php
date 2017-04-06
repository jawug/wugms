	<body>
		<!-- Help modal -->
		<div class="modal fade"  id="myHelpModal" >
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title">Help - QoS Graphs</h4>
					</div>
					<div class="modal-body">
						<p>The graphs on this page shows usage for the selected core network device. </p>
						<p>The devices shown in the "QoS Overview pis chart are all the devices that are currently reporting in for the last 6 hours. </p>
						<p>By clicking on a chart slice the "Selected site" pie chart will then be populated with the flow breakdown for that selected slice. </p>
						<p>The "Flow data for" spline chart shows the data for the selected flow from the "Selected site" pie chart. </p>
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
            <li><a href="../">Admin Dashboards</a></li>
            <li><a href="../cpu">CPU <span class='glyphicon glyphicon-tasks' aria-hidden='true'></span></a></li>
            <li><a href="../interfaces">Interfaces <span class='glyphicon glyphicon-random' aria-hidden='true'></a></li>
			<li class="active"><a href="../qos">QoS <span class='glyphicon glyphicon-list-alt' aria-hidden='true'></a></li>
			<li><a href="../storage">Storage <span class='glyphicon glyphicon-hdd' aria-hidden='true'></span></a></li>
            <li><a href="../device">Router Device (Mikrotik) <span class='glyphicon glyphicon-dashboard' aria-hidden='true'></span></a></li>
			<li><a href="../ap">AP (Mikrotik) <span class='glyphicon glyphicon-link' aria-hidden='true'></span></a></li>
			<li><a href="../ap_clients">Wifi Connections (Mikrotik) <span class='glyphicon glyphicon-signal' aria-hidden='true'></span></a></li>
          </ul>
        </div>
<!--		<form name="form_field"> -->
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main" id="header">
<!--			<h1 class="page-header"> </h1> -->
			<div align="center">

			</div>
			<div id="selection"> </div>
		</div>
<!-- here -->
            <div class="col-sm-offset-3 col-md-4">
				<div class="panel panel-primary">
					<div class="panel-heading">
						<h3 class="panel-title">QoS Overview</h3>
					</div>
					<div class="panel-body">
						<div id="ov_qos"> </div>
					</div>
					<div class="panel-footer"><div id="qos_date"> </div></div>
				</div>
			</div>
            <div class="col-md-4">
				<div class="panel panel-info">
					<div class="panel-heading">
						<h3 class="panel-title"><div id="sel_rb_qos_name">Selected site: none selected</div></h3>
					</div>
					<div class="panel-body">
						<div id="sel_rb_qos"> </div>
					</div>
					<div class="panel-footer">&nbsp;<div id="qos_sel"> </div></div>
				</div>
            </div>
			<hr>
			<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main" id="header">
				<div class="panel panel-success">
					<div class="panel-heading">
						<h3 class="panel-title"><div id="sel_rb_sel_ip_flow">Flow data for: none selected</div></h3>
					</div>
					<div class="panel-body">
						<div id="sel_qos_stackedarea"> </div>
					</div>
				</div>
			</div>
		
      </div>
    </div>