<!-- Set the pagetitle -->
<div class="pagetitle" id="page_qos"> </div>
<div id="wrapper">

    <!-- Sidebar -->
    <!--     <ul class="sidebar navbar-nav">
        <li class="nav-item">
            <a class="nav-link" href="/">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>Dashboard</span>
            </a>
        </li>
        <li class="nav-item dropdown active">
            <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fa fa-database fa-fw"></i>
                <span>Public</span>
            </a>
            <div class="dropdown-menu" aria-labelledby="pagesDropdown">
                <a class="dropdown-item" href="/public/corenetworkdevices">Core Network Devices</a>
                <a class="dropdown-item active" href="/public/wifistats">Wifi Stats</a>
                <a class="dropdown-item" href="/public/networkstats">Network Stats</a>
                <a class="dropdown-item" href="/public/userstats">User Stats</a>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="/public/gettingstarted">
                <i class="fa fa-share fa-fw"></i>
                <span>Getting Started</span></a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="/public/contactus">
                <i class="fa fa-comments fa-fw"></i>
                <span>Contact Us</span></a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="/public/aboutus">
                <i class="fa fa-play fa-fw"></i>
                <span>About Us</span></a>
        </li>
    </ul> -->

    <div id="content-wrapper">
        <div class="container-fluid">
            <!-- Breadcrumbs-->
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="#">Public</a>
                </li>
                <li class="breadcrumb-item active">Wifi Stats</li>
            </ol>


            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="panel panel-default marginRow">
                        <div class="row">
                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                <div id="chart_wifi_frequency2" style="min-width: 310px; height: 400px; max-width: 600px; margin: 0 auto"></div>
                            </div>
                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                <div id="chart_wifi_frequency5" style="min-width: 310px; height: 400px; max-width: 600px; margin: 0 auto"></div>
                            </div>
                        </div>
                        <hr>
                        <div class="row marginRow">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 marginRow">
                                <table id='cnd_table' data-url="/public/content/wugms.wifi_details.public.table.get.php" data-toggle="table" data-classes="table table-hover table-condensed" data-striped="true" data-search="true">
                                    <thead>
                                        <tr>
                                            <th data-field="sitename" data-sortable="true">Sitename</th>
                                            <th data-field="owner" data-sortable="true">Equipment Owner</th>
                                            <th data-field="band" data-sortable="true">Band</th>
                                            <th data-field="frequency" data-sortable="true">Frequency</th>
                                            <th data-field="channel_width" data-sortable="true">Channel Width</th>
                                            <th data-field="antenna_gain" data-sortable="true">Antenna Gain</th>
                                            <th data-field="country" data-sortable="true">Country</th>
                                            <th data-field="ssid" data-sortable="true">SSID</th>
                                            <th data-field="wireless_protocol" data-sortable="true">Protocol</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /.content-wrapper -->
</div>
<!-- /#wrapper -->

<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>