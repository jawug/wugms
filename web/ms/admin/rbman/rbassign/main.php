<!-- Edit rb modal -->
		<div class="pagetitle" id="page_adm_rb_man"> </div>
 <div class="modal fade" id="EditRBModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2" aria-hidden="true"> 
	<div class="modal-dialog">
		<form id="EditrbForm" method="post" enctype="multipart/form-data" class="form-horizontal" action=""> 
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
					<h4 class="modal-title">Edit Routerboard header details</h4>
				</div>
				<div class="modal-body" id="Edit_modal_body">
					<div class="form-group">
						<label for="edit_identity" class="col-sm-3 control-label">Identity</label>
						<div class="col-sm-5" >
							<input class="form-control" name="edit_identity" id="edit_identity" placeholder="rb Identity" type="text" readonly="readonly" >
<!--							<input class="form-control" name="Editsite_name_oem" id="edit_site_name_oem" type="hidden" value=""> -->
						</div>
					</div>
					<div class="form-group">
						<label for="edit_serial_number" class="col-sm-3 control-label">Serial Number</label>
						<div class="col-sm-5" >
							<input class="form-control" name="edit_serial_number" id="edit_serial_number" placeholder="Serial Number" type="text" readonly="readonly" >
<!--							<input class="form-control" name="Editsite_name_oem" id="edit_site_name_oem" type="hidden" value=""> -->
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-3">Site</label>
						<div class="col-sm-7">
							<select required="required" class="form-control combobox" id="edit_rb_sitename" name="edit_rb_sitename" >
								<option value="" selected="selected">Select site...</option>
								<option value="not_listed">**Not Listed**</option>
									<?php
										/* Set up the SQL query */
										$subquery = "SELECT siteID 'site_id', Name 'sitename' FROM tbl_base_sites ORDER BY name;;";
										/* Prepare the SQL for execute */
										$substmt = $db->prepare($subquery);
										/* Execute the query */
										if ($substmt->execute()) {
											$subresult = $substmt->fetchAll(PDO::FETCH_ASSOC);
										}
										/* Display the returned row(s) */
										foreach ($subresult as $row) {
											echo "<option value='" . $row['site_id'] . "'>" . $row['sitename'] . "</option>";
										}
									?>	
							</select>
						</div>
					</div>
					<div class="form-group">
						<label for="edit_use_site_info" class="col-sm-3 control-label">  </label>
						<div class="col-sm-7" >
							<div class="btn-group">
								<button type="button" class="btn btn-info" data-toggle="#rb_coords" name="edit_use_site_info" id="edit_use_site_info">Use site's information for co-ords</button>
							</div> 
						</div>
					</div>
					<div id="rb_coords" style="display: none; margin-bottom: 15px;">
						<div class="form-group">
							<label for="edit_rb_longitude" class="col-sm-3 control-label">Longitude</label>
							<div class="col-sm-5">
								<input class="form-control" name="edit_rb_longitude" id="edit_rb_longitude" placeholder="27.00000000" type="text">
							</div>
						</div>
						<div class="form-group">
							<label for="edit_rb_latitude" class="col-sm-3 control-label">Latitude</label>
							<div class="col-sm-5">
								<input class="form-control" name="edit_rb_latitude" id="edit_rb_latitude" placeholder="-26.00000000" type="text">
							</div>
						</div>
						<div class="form-group">
							<label for="edit_rb_height" class="col-sm-3 control-label">Height</label>
							<div class="col-sm-5">
								<input class="form-control" name="edit_rb_height" id="edit_rb_height" placeholder="4" type="text">
							</div>
						</div>
					</div>

					<div class="form-group">
						<label class="control-label col-sm-3">RB owner</label>
						<div class="col-sm-7">
							<select required="required" class="form-control combobox" id="edit_rb_owner" name="edit_rb_owner" >
								<option value="" selected="selected">Select equipment owner...</option>
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
					<input type="hidden" name="edit_rb_use_site_coords" id="edit_rb_use_site_coords" value=""> 
<!--					<input type="hidden" name="edit_rb_oem_sitename" id="edit_rb_oem_sitename" value=""> -->
				</div>
				<div class="modal-footer">
					<div class="btn-group" role="group" aria-label="...">
						<button id="canceleditsite" type="button" data-dismiss="modal" data-target="#EditSiteModal" class="btn btn-default">Cancel</button>
						<input class="btn btn-primary" type="submit" value="Update" id="postvalues">
					</div>
				</div>
			</div>
		</form> 
	</div>
</div>


<!-- Re-Assign rb modal -->
 <div class="modal fade" id="ReAssignRBModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel4" aria-hidden="true"> 
	<div class="modal-dialog">
		<form id="ReAssignrbForm" method="post" enctype="multipart/form-data" class="form-horizontal" action=""> 
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
					<h4 class="modal-title">Reassign Routerboard</h4>
				</div>
				<div class="modal-body">
<!--					<div class="form-group">
						<label for="reassign_oem_site_name" class="col-sm-3 control-label">Current Site</label>
						<div class="col-sm-6">
							<input class="form-control" name="reassign_oem_site_name" id="reassign_oem_site_name" type="text" readonly="readonly" >
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-3">New Site</label>
						<div class="col-sm-6">
							<select required="required" class="form-control combobox" id="reassign_site_name" name="reassign_site_name" >
								<option value="" selected="selected">Select site...</option>
								<option value="not_listed">**Not Listed**</option>
									<?php
										/* Set up the SQL query */
										$subquery = "SELECT siteID 'site_id', Name 'sitename' FROM tbl_base_sites ORDER BY name;;";
										/* Prepare the SQL for execute */
										$substmt = $db->prepare($subquery);
										/* Execute the query */
										if ($substmt->execute()) {
											$subresult = $substmt->fetchAll(PDO::FETCH_ASSOC);
										}
										/* Display the returned row(s) */
										foreach ($subresult as $row) {
											echo "<option value='" . $row['site_id'] . "'>" . $row['sitename'] . "</option>";
										}
									?>	
							</select>
						</div>
					</div> -->
					<div class="form-group">
						<label for="reassign_identity" class="col-sm-3 control-label">Identity</label>
						<div class="col-sm-5" >
							<input class="form-control" name="reassign_identity" id="reassign_identity" placeholder="rb Identity" type="text" readonly="readonly" >
						</div>
					</div>
					<div class="form-group">
						<label for="reassign_serial_number" class="col-sm-3 control-label">Serial Number</label>
						<div class="col-sm-5" >
							<input class="form-control" name="reassign_serial_number" id="reassign_serial_number" placeholder="Serial Number" type="text" readonly="readonly" >
						</div>
					</div>
					
					<div class="form-group">
						<label for="reassign_oem_rb_owner" class="col-sm-3 control-label">Current Routerboard Owner</label>
						<div class="col-sm-6">
							<input class="form-control" name="reassign_oem_rb_owner" id="reassign_oem_rb_owner" type="text" readonly="readonly" >
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-3">New Routerboard Owner</label>
						<div class="col-sm-6">
							<select required="required" class="form-control combobox" id="reassign_rb_owner" name="reassign_rb_owner" >
								<option value="" selected="selected">Select equipment owner...</option>
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
					
					<div class="alert alert-warning" role="alert">
						<div class="form-group">
							<div class="checkbox col-sm-8 control-label">
								<div class="col-sm-11">							
									<label>
										<input type="checkbox" name="confirmreassign" id="confirmreassign"> <b>Confirm changes</b>
									</label>
								</div> 
							</div> 
						</div>
					</div>
<!--					<input type="hidden" name="reassign_siteid" id="reassign_siteid" value=""> -->
					<input type="hidden" name="reassign_oem_site_owner_id" id="reassign_oem_site_owner_id" value="">
<!--					<input type="hidden" name="reassign_new_site_owner_id" id="reassign_new_site_owner_id" value=""> -->
				</div>
				<div class="modal-footer">
					<div class="btn-group" role="group" aria-label="...">
						<button id="cancelreassignsite" type="button" data-dismiss="modal" data-target="#ReAssignSiteModal" class="btn btn-default">Cancel</button>
					<input class="btn btn-success" type="submit" value="Reassign" id="postvalues">
				</div>
				</div>
			</div>
		</form>  
	</div>
</div>


		<!-- Help modal -->
		<div class="modal fade"  id="myHelpModal" >
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title">Help - Routerboard Allocation</h4>
					</div>
					<div class="modal-body">
						<p>This page displays the routerboards that are on record based on the RBCP scripts that run on them. On this page you can edit the details of the routerboard with regards to the site that it is installed at as well as manually override the co-ords for the routerboard. This page also allows you to set who the routerboard owner is. </p>
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
			<li><a href="../bgp"><img src="/images/arrow_switch-128.png" alt="..." class="img-rounded" width="24" height="24"> BGP Assignments </a></li>
			<li><a href="../remcmd"><img src="/images/settings.png" alt="..." class="img-rounded" width="24" height="24"> Remote Commands </a></li>
			<li class="active"><a href="#"><img src="/images/stock_task_assigned_to.png" alt="..." class="img-rounded" width="24" height="24"> Routerboard Allocation </a></li>
         </ul>
      </div>
      <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main" id="header">
         <!--			<h1 class="page-header"> </h1> -->

      </div>
   </div>
   <!-- <h2 class="sub-header">Results</h2> -->
   <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main" id="header">
	  <!-- table for connected clients -->
      <div class="panel panel-default">
         <div class="panel-heading"><b>Routerboards as per RBCP data </b></div>
<!--         <div class="panel-body">  -->
            <table id='rb_table' data-url="/content/wugms.table.admin.rb.reassign.php" data-toggle="table" data-classes="table table-hover" data-striped="true" data-search="true" data-pagination="true" data-show-columns="true">
               <thead>
					<tr>
						<th data-formatter="runningFormatter">#</th>
						<th data-field="RB_identity" data-sortable="true">Identity</th>
						<th data-field="rb_owner_name" data-sortable="true">owner</th>
						<th data-field="Serial_Number" data-sortable="true">S/N</th>
						<th data-field="sitename" data-sortable="true">Sitename</th>
						<th data-field="Software_ID" data-sortable="true" data-visible="false">Software ID</th>
						<th data-field="OS_Version" data-sortable="true">ROS</th>
						<th data-field="Board_tech" data-sortable="true">Technology</th>
						<th data-field="Board_model" data-sortable="true">Model</th>
						<th data-field="isUseSiteinfo" data-sortable="true" data-visible="false">Uses Site info</th>
						<th data-field="rb_lat" data-sortable="true" data-visible="false">latitude</th>
						<th data-field="rb_long" data-sortable="true" data-visible="false">longitude</th>
						<th data-field="rb_height" data-sortable="true" data-visible="false">height</th>
						<th data-field="File_Date" data-sortable="true">RBCP Date</th>
						<th data-field="snmp_seen" data-sortable="true">SNMP Seen</th>
						<th data-field="actions" data-formatter="actionFormatter" data-events="actionEvents" data-align="center" data-width="150px">Actions</th>						
					</tr>
               </thead>
            </table>
<!--         </div> -->
      </div>
      <!--     </div> -->
   </div>
</div>