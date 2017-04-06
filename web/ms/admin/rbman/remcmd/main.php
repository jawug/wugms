<body>
    <div class="pagetitle" id="page_adm_rb_man"> </div>	
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
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-3 col-md-2 sidebar">
                <ul class="nav nav-sidebar">
                    <li><a href="../"><img src="/images/switch.png" alt="..." class="img-rounded" width="24" height="24"> My Routerboard Management </a></li>
                    <li><a href="../conrev"><img src="/images/folder_network.png" alt="..." class="img-rounded" width="24" height="24"> Config Review </a></li>
                    <li><a href="../ipv4"><img src="/images/ip_pyramid.png" alt="..." class="img-rounded" width="24" height="24"> IPv4 Assignments </a></li>
                    <li><a href="../bgp"><img src="/images/arrow_switch-128.png" alt="..." class="img-rounded" width="24" height="24"> BGP Assignments </a></li>
                    <li class="active"><a href="#"><img src="/images/settings.png" alt="..." class="img-rounded" width="24" height="24"> Remote Commands </a></li>
                    <li><a href="../rbassign"><img src="/images/stock_task_assigned_to.png" alt="..." class="img-rounded" width="24" height="24"> Routerboard Allocation </a></li>
                </ul>
            </div>

            <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main" id="header">
                <div class="row placeholders">
                    <div class="col-md-5">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title"><b>IP/hostname and user credentials</b></h3>
                            </div>
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
                            <div class="panel-heading">
                                <h3 class="panel-title"><b>Remote command</b></h3>
                            </div>
                            <div class="panel-body">
                                <label for="inputCMD" class="sr-only">Command</label>
                                <select style="width:100%" class="inputCMD form-control" name="inputCMD" id="inputCMD">
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
                </div>

                <div id="results"></div>

                <div class="log"></div>
            </div>

