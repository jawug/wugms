		<div class="pagetitle" id="page_mancom"> </div>
<!-- New payment modal -->
 <div class="modal fade" id="NewPaymentModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"> 
	<div class="modal-dialog">
	<form id="paymentForm" method="post" enctype="multipart/form-data" class="form-horizontal" action=""> 
<!--	<form id="paymentForm" method="post" enctype="multipart/form-data" class="form-horizontal" action=""> -->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				<h4 class="modal-title">New payment details</h4>
			</div>
			<div class="modal-body">
					
				<div class="form-group">
					<label class="control-label col-sm-3">User</label>
					<div class="col-sm-6">
						<select required="required" class="form-control combobox" name="puser" >
							<option value="" selected="selected">Select a user...</option>
								<?php
									/* Set up the SQL query */
									$subquery = "SELECT idtbl_base_user, username, irc_nick, firstName, lastName FROM wugms.tbl_base_user WHERE idtbl_base_user <> 1 AND idtbl_base_user <> 54 order by irc_nick;";
									/* Prepare the SQL for execute */
									$substmt = $db->prepare($subquery);
									/* Execute the query */
									if ($substmt->execute()) {
										$subresult = $substmt->fetchAll(PDO::FETCH_ASSOC);
									}
									/* Display the returned row(s) */
									foreach ($subresult as $row) {
										echo "<option value='" . $row['idtbl_base_user'] . "'>" . $row['irc_nick'] . " (" . $row['firstName'] . " " . $row['lastName'] . ")</option>";
									}
								?>	
						</select>
					</div>
				</div>				

						
				<div class="form-group">
					<label for="longitude" class="col-sm-3 control-label">Payment date</label>
					<div class="col-sm-5">
						<div class="input-group input-append date" id="dateRangePicker">
							<input type="text" class="form-control" id="pdate" name="pdate" />
							<span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
						</div>
					</div>
				</div>

				<div class="form-group">
					<label class="control-label col-sm-3">Payment Method</label>
					<div class="col-sm-7">
						<select required="required" class="form-control combobox" id="pmethod" name="pmethod" >
							<option value="" selected="selected">Select Payment Method...</option>
								<?php
									/* Set up the SQL query */
									$subquery = "SELECT payment_method, comment FROM wugms.tbl_base_payment_method;";
									/* Prepare the SQL for execute */
									$substmt = $db->prepare($subquery);
									/* Execute the query */
									if ($substmt->execute()) {
										$subresult = $substmt->fetchAll(PDO::FETCH_ASSOC);
									}
									/* Display the returned row(s) */
									foreach ($subresult as $row) {
										echo "<option value='" . $row['payment_method'] . "'>" . $row['payment_method'] . " (" . $row['comment'] . ")</option>";
									}
								?>	
						</select>
					</div>
				</div>	
	
				<div class="form-group">
					<label class="control-label col-sm-3">Payment type</label>
					<div class="col-sm-7">
						<select required="required" class="form-control combobox" id="ptype" name="ptype" >
							<option value="" selected="selected">Select Payment Type...</option>
								<?php
									/* Set up the SQL query */
									$subquery = "SELECT payment_type, comment FROM wugms.tbl_base_payment_type;";
									/* Prepare the SQL for execute */
									$substmt = $db->prepare($subquery);
									/* Execute the query */
									if ($substmt->execute()) {
										$subresult = $substmt->fetchAll(PDO::FETCH_ASSOC);
									}
									/* Display the returned row(s) */
									foreach ($subresult as $row) {
										echo "<option value='" . $row['payment_type'] . "'>" . $row['payment_type'] . " (" . $row['comment'] . ")</option>";
									}
								?>	
						</select>
					</div>
				</div>	
					
				<div class="form-group">
					<label for="suburb" class="col-sm-3 control-label">Amount</label>
					<div class="col-sm-5">
						<div class="input-group">
							<span class="input-group-addon">R</span>
							<input class="form-control" name="pamount" value="0.00" placeholder="0.00" type="text">
						</div>
					</div>
				</div>
				
				<div class="form-group">
					<label for="height" class="col-sm-3 control-label">Comment</label>
					<div class="col-sm-8">
						<textarea class="form-control" id="pcomment" name="pcomment" rows="3"></textarea>
							<!--<input class="form-control" name="comment" placeholder="4" type="text"> -->
					</div>
				</div>
				<!--</form> -->
			</div>
			<div class="modal-footer">
				<div class="btn-group" role="group" aria-label="...">
					<button id="cancelnewpatment" type="button" data-dismiss="modal" data-target="#NewPaymentModal" class="btn btn-default">Cancel</button>
					<input class="btn btn-success" type="submit" value="Create" id="postvalues">
				</div>			
			</div>
		</div>
		</form> 
	</div>
</div>

<!-- Edit payment modal -->
 <div class="modal fade" id="EditPaymentModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2" aria-hidden="true"> 
	<div class="modal-dialog">
	<form id="EditpaymentForm" method="post" enctype="multipart/form-data" class="form-horizontal" action=""> 
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				<h4 class="modal-title">Edit payment details</h4>
			</div>
			<div class="modal-body">
					
				<div class="form-group">
					<label class="control-label col-sm-3">User</label>
					<div class="col-sm-6">
						<select required="required" class="form-control combobox" name="euser" id="euser">
							<option value="" selected="selected">Select a user...</option>
								<?php
									/* Set up the SQL query */
									$subquery = "SELECT idtbl_base_user, username, irc_nick, firstName, lastName FROM wugms.tbl_base_user WHERE idtbl_base_user <> 1 AND idtbl_base_user <> 54 order by irc_nick;";
									/* Prepare the SQL for execute */
									$substmt = $db->prepare($subquery);
									/* Execute the query */
									if ($substmt->execute()) {
										$subresult = $substmt->fetchAll(PDO::FETCH_ASSOC);
									}
									/* Display the returned row(s) */
									foreach ($subresult as $row) {
										echo "<option value='" . $row['idtbl_base_user'] . "'>" . $row['irc_nick'] . " (" . $row['firstName'] . " " . $row['lastName'] . ")</option>";
									}
								?>	
						</select>
					</div>
				</div>				

				<div class="form-group">
					<label for="edate" class="col-sm-3 control-label">Payment date</label>
					<div class="col-sm-5">
						<div class="input-group input-append date" id="edateRangePicker">
							<input type="text" class="form-control" id="edate"  name="edate"/>
							<span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
						</div>
					</div>
				</div>

				<div class="form-group">
					<label class="control-label col-sm-3">Payment Method</label>
					<div class="col-sm-7">
						<select required="required" class="form-control combobox" id="emethod" name="emethod" >
							<option value="" selected="selected">Select Payment Method...</option>
								<?php
									/* Set up the SQL query */
									$subquery = "SELECT payment_method, comment FROM wugms.tbl_base_payment_method;";
									/* Prepare the SQL for execute */
									$substmt = $db->prepare($subquery);
									/* Execute the query */
									if ($substmt->execute()) {
										$subresult = $substmt->fetchAll(PDO::FETCH_ASSOC);
									}
									/* Display the returned row(s) */
									foreach ($subresult as $row) {
										echo "<option value='" . $row['payment_method'] . "'>" . $row['payment_method'] . " (" . $row['comment'] . ")</option>";
									}
								?>	
						</select>
					</div>
				</div>	
	
				<div class="form-group">
					<label class="control-label col-sm-3">Payment type</label>
					<div class="col-sm-7">
						<select required="required" class="form-control combobox" id="etype" name="etype" >
							<option value="" selected="selected">Select Payment Type...</option>
								<?php
									/* Set up the SQL query */
									$subquery = "SELECT payment_type, comment FROM wugms.tbl_base_payment_type;";
									/* Prepare the SQL for execute */
									$substmt = $db->prepare($subquery);
									/* Execute the query */
									if ($substmt->execute()) {
										$subresult = $substmt->fetchAll(PDO::FETCH_ASSOC);
									}
									/* Display the returned row(s) */
									foreach ($subresult as $row) {
										echo "<option value='" . $row['payment_type'] . "'>" . $row['payment_type'] . " (" . $row['comment'] . ")</option>";
									}
								?>	
						</select>
					</div>
				</div>	
					
				<div class="form-group">
					<label for="suburb" class="col-sm-3 control-label">Amount</label>
					<div class="col-sm-5">
						<div class="input-group">
							<span class="input-group-addon">R</span>
							<input class="form-control" name="eamount" id="eamount" value="0.00" placeholder="0.00" type="text">
						</div>
					</div>
				</div>
				
				<div class="form-group">
					<label for="height" class="col-sm-3 control-label">Comment</label>
					<div class="col-sm-8">
						<textarea class="form-control" id="ecomment" name="ecomment" rows="3"></textarea>
							<!--<input class="form-control" name="comment" placeholder="4" type="text"> -->
					</div>
				</div>
				<!-- oem vals - start -->
				<input type="hidden" name="edit_payment_oem_id"        id="edit_payment_oem_id" value="">
				<input type="hidden" name="edit_payment_oem_user_id"   id="edit_payment_oem_user_id" value="">
				<input type="hidden" name="edit_payment_oem_firstName" id="edit_payment_oem_firstName" value="">
				<input type="hidden" name="edit_payment_oem_lastName"  id="edit_payment_oem_lastName" value="">
				<input type="hidden" name="edit_payment_oem_irc_nick"  id="edit_payment_oem_irc_nick" value="">
				<input type="hidden" name="edit_payment_oem_date"      id="edit_payment_oem_date" value="">
				<input type="hidden" name="edit_payment_oem_method"    id="edit_payment_oem_method" value="">
				<input type="hidden" name="edit_payment_oem_type"      id="edit_payment_oem_type" value="">
				<input type="hidden" name="edit_payment_oem_amount"    id="edit_payment_oem_amount" value="">
				<input type="hidden" name="edit_payment_oem_comment"   id="edit_payment_oem_comment" value="">

				
				<!-- oem vals - end -->
			</div>
			<div class="modal-footer">
				<div class="btn-group" role="group" aria-label="...">
					<button id="canceleditpayment" type="button" data-dismiss="modal" data-target="#EditPaymentModal" class="btn btn-default">Cancel</button>
					<input class="btn btn-primary" type="submit" value="Update" id="postvalues">
				</div>			
			</div>
		</div>
		</form> 
	</div>
</div>

<!-- <div class="modal fade" id="DeletePaymentModal"> -->
 <div class="modal fade" id="DeletePaymentModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel3" aria-hidden="true"> 
	<div class="modal-dialog">
	<form id="DeletepaymentForm" method="post" enctype="multipart/form-data" class="form-horizontal" action=""> 
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				<h4 class="modal-title">Delete payment entry</h4>
			</div>
			<div class="modal-body">
					<div class="form-group">
						<label for="duser" class="col-sm-5 control-label">User</label>
						<div class="col-sm-6">
						<!--<label for="duser" class="col-sm-5 control-label" name="delete_user_payment" id="delete_user_payment">qqq</label>-->
							<input class="form-control" name="duser" id="duser" type="text" readonly="readonly" >
						</div>
					</div>
					<div class="form-group">
						<label for="ddate" class="col-sm-5 control-label">Date</label>
						<div class="col-sm-6">
						<!--<label for="duser" class="col-sm-5 control-label" name="delete_user_payment" id="delete_user_payment">qqq</label>-->
							<input class="form-control" name="ddate" id="ddate" type="text" readonly="readonly" >
						</div>
					</div>
					<div class="form-group">
						<label for="dmethod" class="col-sm-5 control-label">Payment Method</label>
						<div class="col-sm-6">
						<!--<label for="duser" class="col-sm-5 control-label" name="delete_user_payment" id="delete_user_payment">qqq</label>-->
							<input class="form-control" name="dmethod" id="dmethod" type="text" readonly="readonly" >
						</div>
					</div>
					<div class="form-group">
						<label for="dtype" class="col-sm-5 control-label">Payment Type</label>
						<div class="col-sm-6">
						<!--<label for="duser" class="col-sm-5 control-label" name="delete_user_payment" id="delete_user_payment">qqq</label>-->
							<input class="form-control" name="dtype" id="dtype" type="text" readonly="readonly" >
						</div>
					</div>
					<div class="form-group">
						<label for="damount" class="col-sm-5 control-label">Amount</label>
						<div class="col-sm-6">
						<!--<label for="duser" class="col-sm-5 control-label" name="delete_user_payment" id="delete_user_payment">qqq</label>-->
							<input class="form-control" name="damount" id="damount" type="text" readonly="readonly" >
						</div>
					</div>					
					
					<div class="alert alert-danger" role="alert">
					<div class="form-group">
						<div class="checkbox col-sm-8 control-label"> 
							<label>
<!--							<input class="form-control" name="Editlatitude" id="edit_latitude" placeholder="-26.00000000" type="text"> -->
								<input type="checkbox" name="confirmdelete" id="confirmdelete"> <b>Confirm deletion of payment</b>
							</label>
						</div> 
					</div>
					</div>
					<input type="hidden" name="delete_paymentid" id="delete_paymentid" value="">
					<div class="alert alert-danger" role="alert">
					<p class="text-center" ><b>Warning you are about to delete a payment entry.</b></p>
					<p class="text-center" ><b>Once the deletion has taken place there is no going back.</b></p>
<!--					<span class="label label-warning">Warning you are about to delete a payment entry.</span>
					<span class="label label-warning">Any network devices allocated to this payment will become "unassigned".</span> -->
					</div>
				<!--</form> -->
			</div>
			<div class="modal-footer">
				<div class="btn-group" role="group" aria-label="...">
					<button id="canceldeletepayment" type="button" data-dismiss="modal" data-target="#DeletePaymentModal" class="btn btn-default">Cancel</button>
<!--					<button id="postvalues" type="button" data-toggle="modal" type="submit" class="btn btn-success">Create</button> -->
					<input class="btn btn-danger" type="submit" value="Delete" id="postvalues">
				</div>			
<!--	  	        	<button class="btn btn-primary" id="sendcv" type="submit">Submit details!</button>
				<a href="#" data-dismiss="modal" class="btn btn-default">Cancel</a> -->
				<!--<a href="#" class="btn btn-success">Create</a> -->
<!--				<input class="btn btn-success" type="submit" value="Create" id="postvalues"> -->
			</div>
		</div>
		</form> 
	</div>
</div>
<!--<div id="nsresult"></div> -->

		<!-- Help modal -->
		<div class="modal fade" id="myHelpModal" >
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
					<li class="active"><a href="#">Payments <span class='glyphicon glyphicon-edit' aria-hidden='true'></span></a></li>
					<li><a href="../audit">Audit <span class='glyphicon glyphicon-check' aria-hidden='true'></span></a></li>
					<li><a href="../members">Members <span class='glyphicon glyphicon-user' aria-hidden='true'></span></a></li>
				</ul>
			</div>
			<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main" id="header">
				<h1 class="page-header">Payments</h1>
				<div align="center">
					<p> Shown below is the user list as well and account status of each user. </p>
				</div>
				<div class="btn-group" role="group" aria-label="...">
					<button id='NewPaymentModalBtn' type='button' data-toggle='modal' data-target='#NewPaymentModal' class='btn btn-success'>Add new payment</button>
				</div>				
			</div>
			<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main" id="header">
				<div class="panel panel-primary">
					<div class="panel-heading">
						<h2 class="panel-title"><b>User Payments</b></h2>
					</div>
					<div class="panel-body">
						<table id='user_accounts_table' data-url="/content/wugms.table.mancom.payments.received.php?intlen=1825" data-toggle="table" data-classes="table table-hover" data-striped="true"  data-search="true" >
						<!--<table id='user_accounts_table' data-url="/content/wugms.table.mancom.payments.received.php?intlen=1825" data-toggle="table" data-classes="table table-hover table-condensed" data-striped="true"  data-search="true" > -->
							<thead>
								<tr>
									<th data-field="pdate" data-sortable="true">Payment Date</th>
									<th data-field="irc_nick" data-sortable="true">User</th>
									<th data-field="payment_type" data-sortable="true">Payment Type</th>
									<th data-field="payment_method" data-sortable="true">Payment Method</th>
									<th data-field="amount" data-sortable="true">Amount</th>
									<th data-field="comment" data-sortable="true">Comment</th>
									<!--<th data-field="actions" data-sortable="true">Actions</th>-->
									<th data-field="actions" data-formatter="actionFormatter" data-events="actionEvents" data-sortable="true" data-align="center">Actions</th>
								</tr>
							</thead>
						</table>				
					</div>
				</div>

			</div>
		</div>
	</div>
