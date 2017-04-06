<div class="pagetitle" id="page_usr_ssids"> </div>	
<!-- Help modal -->
<div class="modal fade"  id="myHelpModal" >
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Help - SSID</h4>
            </div>
            <div class="modal-body">
                <p>This modal provides help on the page displayed.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" data-dismiss="modal">Close</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->	
<div class="container-fluid">
    <div class="row">
        <br />
        <br />
        <div class="col-md-6">

            <div align="center">
                <?php
                /* Set up the SQL query */
                //$subquery = "SELECT ap.ssid, ap.ap_id, ap.Serial_Number 'sn' FROM wugms.tbl_base_snmp_mikrotik_ap_now ap WHERE ap.rdate > NOW() - INTERVAL 84 DAY AND upper(ap.SSID) LIKE '%JAWUG.%' ORDER BY ap.ssid;";
                $subquery = "					
					SELECT a.serial_number as sn, a.mac_address, upper(a.wifi_ssid) AS ssid
					  FROM tbl_base_rb_interface_config a, tbl_base_rb_routerboard b
					 WHERE     a.Serial_Number = b.Serial_Number
					       AND upper(b.active) = 'Y'
					       AND a.Interface_type = 'WIFI'
					       AND upper(a.wifi_ssid) LIKE '%JAWUG.%'
					       AND a.disabled = 0
					       AND upper(a.wifi_mode) LIKE 'AP-%'
					ORDER BY wifi_ssid;";
                /* Prepare the SQL for execute */
                $substmt = $db->prepare($subquery);
                /* Execute the query */
                if ($substmt->execute()) {
                    $subresult = $substmt->fetchAll(PDO::FETCH_ASSOC);
                }
                ?>
                <select style="width:100%" class="selector2_rb form-control" name="selector2_rb" id="selector2_rb">

                    <!-- Show a selector with all the values that the user can select from -->
                    <option value=""></option>
                    <?php
                    /* Display the returned row(s) */
                    foreach ($subresult as $row) {
                        echo "<option value='" . $row['sn'] . "__" . $row['ssid'] . "'>" . $row['ssid'] . "</option>";
                    }
                    ?>
                </select>

            </div>
            <div id="sel_device"> <?php if (isset($_SESSION["ov_ssid_name"])) {
                        echo "<h3 class='sub-header'>Selected SSID: <span style='color: rgb(0, 0, 153);'>" . $_SESSION["ov_ssid_name"] . "</span></h3>";
                    } else {
                        echo "<h3 class='sub-header'>No SSID has been selected</h3> ";
                    } ?></div>
            <div id="sel_device_res"> </div>
        </div>
    </div>
    <!-- Example row of columns -->
    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-primary">
                <div class="panel-heading"><b>Overview</b></div>
                <div class="panel-body" style="height: 260px; margin: 0 auto">
                    <table id='ssid_ap_table' data-url="/content/snmp_ssid_ap.php?ssid_level=mov" data-toggle="table" data-classes="table table-hover table-condensed" data-striped="true" data-card-view="true">
                        <thead>
                            <tr>
                                <th data-field="freq" data-sortable="true">Frequency</th>
                                <th data-field="band" data-sortable="true">Band</th>
                                <th data-field="noisefloor" data-sortable="true">Noise Floor</th>
                                <th data-field="overalltxccq" data-sortable="true">Overall Tx CCQ</th>
                                <th data-field="clientcount" data-sortable="true">Clients</th>
                                <th data-field="authclientcount" data-sortable="true">Auth. Clients</th>
                                <th data-field="name" data-sortable="true">Site</th>
                                <th data-field="board_model" data-sortable="true">Device Model</th>
                                <th data-field="version" data-sortable="true">ROS</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="panel panel-success">
                <div class="panel-heading"><b>Overall Tx CCQ (Last)</b></div>
                <div class="panel-body">				
                    <div id="ssid_oa_txccq" style="height: 230px; margin: 0 auto"></div>
                </div>
            </div>
        </div>
        <hr>
    </div>
    <div class="row">
        <div class="panel-group" id="accordion">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#accordion" href="#sct">Connected Clients (Last 60 days) <img src="../../images/table_data.png" alt="..." class="img-rounded" width="24" height="24"></a>
                    </h4>
                </div>						
                <!--					<b>Connected Clients (Last 60 days)</b></div> -->
                <div id="sct" class="panel-collapse collapse">
                    <!-- <div class="panel-body"> -->
                    <table id='ssid_client_table' data-url="/content/snmp_ssid_clients.php?ssid_level=mov" data-toggle="table" data-classes="table table-hover table-condensed" data-striped="true" data-show-columns="true" data-search="true" data-show-toggle="true">
                        <thead>
                            <tr>
                                <th data-field="rdate" data-sortable="true">Last Seen</th>
                                <th data-field="sitename" data-sortable="true">Site</th>
                                <th data-field="rb_identity" data-sortable="true">RB Name</th>
                                <th data-field="board_model" data-sortable="true">Model</th>
                                <th data-field="ros" data-sortable="true">ROS</th>
                                <th data-field="user" data-sortable="true">User</th>
                                <th data-field="connect_time" data-sortable="true">Uptime</th>
                                <th data-field="iface_name" data-sortable="true">Interface</th>
                                <th data-field="wifi_radio_name" data-sortable="true">Radio Name</th>
                                <th data-field="wifi_antenna_gain" data-sortable="true">Antenna Gain</th>  
                                <th data-field="strength" data-sortable="true">Strength</th>
                                <th data-field="tx_speed" data-sortable="true">Tx Speed</th>
                                <th data-field="rx_speed" data-sortable="true">Rx Speed</th>
                                <th data-field="tx_bytes" data-sortable="true">Tx Bytes</th>
                                <th data-field="rx_bytes" data-sortable="true">Rx Bytes</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>


    <div class="row">
        <div class="panel panel-warning"> 
            <div class="panel-heading"><b>Client signal reading(s) (Last 24 hours) <img src="../../images/bar_chart.png" alt="..." class="img-rounded" width="24" height="24"></b></div>
            <div class="panel-body">
                <div id="ap_client_signal"></div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="panel panel-default"> 
            <div class="panel-heading"><b>Client data reading(s) (Last 24 hours) <img src="../../images/bar_chart.png" alt="..." class="img-rounded" width="24" height="24"></b></div>
            <div class="panel-body">
                <div id="data_client_signal"></div>
            </div>
        </div>
    </div>

</div>


<!--
                        <div class="row">
                                <div class="panel panel-warning"  style="width: 80%; margin: 0 auto"> 
                                        <div class="panel-heading"><b>Layout</b></div>
                                        <div class="panel-body">
                                                <div class="popin">
                                                        <div id="map"></div>
                                                </div>
                                        </div>
                                </div>
                        </div>
-->
<!--</div> -->
