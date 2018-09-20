<div class="pagetitle" id="page_cnd"> </div>
<div id="wrapper">
    <!-- Sidebar -->
    <ul class="sidebar navbar-nav">
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
                <a class="dropdown-item active" href="/public/corenetworkdevices">Core Network Devices</a>
                <a class="dropdown-item" href="/public/wifistats">Wifi Stats</a>
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
    </ul>

    <div id="content-wrapper">
        <div class="container-fluid">
            <!-- Breadcrumbs-->
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="#">Public</a>
                </li>
                <li class="breadcrumb-item active">Core Network Devices</li>
            </ol>

            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="panel panel-default marginRow">
                        <div class="row">
                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                <div id="chart_routerboard_models" style="min-width: 310px; height: 400px; max-width: 600px; margin: 0 auto"></div>
                            </div>
                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                <div id="chart_routerboard_ros" style="min-width: 310px; height: 400px; max-width: 600px; margin: 0 auto"></div>
                            </div>
                        </div>
                        <hr>
                        <div class="row marginRow">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 marginRow">
                                <table id='cnd_table' data-url="/public/content/wugms.routerboard_details.public.table.get.php" data-toggle="table" data-classes="table table-hover table-condensed" data-striped="true" data-search="true" >
                                    <thead>
                                        <tr>
                                            <th data-field="sitename" data-sortable="true">Sitename</th>
                                            <th data-field="owner" data-sortable="true">Equipment Owner</th>
                                            <th data-field="identity" data-sortable="true">Identity</th>
                                            <th data-field="rbcp_last_seen" data-sortable="true">RBCP Last seen</th>
                                            <th data-field="model" data-sortable="true">Model</th>
                                            <th data-field="version" data-sortable="true">Version</th>
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
