	<div class="pagetitle" id="page_qos"> </div> 
	<div class="container-fluid theme-showcase" role="main">
		<!-- Help modal -->
		<div class="modal fade"  id="myHelpModal" >
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title">Help - QoS Stats</h4>
					</div>
					<div class="modal-body">
						<p>This page shows the data of the QoS stats.</p>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-success" data-dismiss="modal">Close</button>
					</div>
				</div><!-- /.modal-content -->
			</div>
		</div>
		<div id="main_section" class="container-fluid">
			<div class="col-md-12">
				<div class="panel panel-default">
					<div class="panel-heading">
						<h2 class="panel-title text-center"><b>Network stats</b> <img src="../images/bar_chart.png" alt="..." class="img-rounded" width="24" height="24"></h2>
					</div>
<!--					<div class="panel-body">			-->
						<div class="row">
							<div class="col-md-12">
								<div id="rb_qos"> </div>			
								<br>
								<div class="panel-group" id="accordion">
									<div class="panel panel-info">
										<div class="panel-heading">
											<h4 class="panel-title">
												<a data-toggle="collapse" data-parent="#accordion" href="#qosnum">QoS by the numbers <img src="../images/table_data.png" alt="..." class="img-rounded" width="24" height="24"></a>
											</h4>
										</div>
										<div id="qosnum" class="panel-collapse collapse">
											<!--<div class="panel-body"> -->
												<table id='qos_numbers_table' data-url="/content/wugms.chart.routerboard.qos.php?type=table" data-toggle="table" data-classes="table table-hover table-condensed" data-striped="true" >
													<thead>
														<tr>
															<th data-field="flow" data-sortable="true">Flow Name</th>
															<th data-field="bytes" data-sortable="true" data-align="right">Bytes</th>
															<th data-field="packets" data-sortable="true" data-align="right">Packets</th>
															<th data-field="hcbytes" data-sortable="true" data-align="right">HCBytes</th>
															<th data-field="pcqqueues" data-sortable="true" data-align="right">PCQQueues</th>
															<th data-field="dropped" data-sortable="true" data-align="right">Dropped</th>
														</tr>
													</thead>
												</table> 
											<!--</div> -->
										</div> 
									</div>
								</div>
							</div>
						</div>
<!--					</div>  -->
				</div>
			</div>
		</div>
	</div>