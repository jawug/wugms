<div id="wrapper">
    <!-- START: wrapper 1 -->
    <!-- Sidebar -->
    <ul class="sidebar navbar-nav" id="accordionSidebar">
        <!-- START: UL Sidebar 1 -->

        <!-- Sidebar - Brand -->
        <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
            <div class="sidebar-brand-text mx-3"><?php echo $page_data->getSiteTitle(); ?></div>
        </a>

        <!-- Divider -->
        <hr class="sidebar-divider my-0">

        <!-- Nav Item - Dashboard -->
        <li class="nav-item active">
            <a class="nav-link" href="/">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>Dashboard</span></a>
        </li>

        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                <i class="fas fa-fw fa-chart-area"></i>
                <span>Public</span>
            </a>
            <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <a class="dropdown-item" href="/public/corenetworkdevices">Core Network Devices</a>
                    <a class="dropdown-item" href="/public/wifistats">Wifi Stats</a>
                    <a class="dropdown-item" href="/public/networkstats">Network Stats</a>
                    <a class="dropdown-item" href="/public/userstats">User Stats</a>
                </div>
            </div>
        </li>


        <!-- Divider -->
        <hr class="sidebar-divider">

        <!-- Nav Item - Pages Collapse Menu -->

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

        <!-- Divider -->
        <hr class="sidebar-divider d-none d-md-block">

        <!-- Sidebar Toggler (Sidebar) -->
        <div class="text-center d-none d-md-inline">
            <button class="rounded-circle border-0" id="sidebarToggle"></button>
        </div>

    </ul> <!-- END: UL Sidebar 1 -->

    <!-- Navigation -->
    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">
        <!-- START: content-wrapper 1 -->
        <!-- Main Content -->
        <div id="content">
            <!-- START: content 1 -->
            <!-- Topbar -->
            <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                <!-- START: navbar 1 -->

                <!-- Sidebar Toggle (Topbar) -->
                <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3"><i class="fa fa-bars"></i></button>

                <!-- Topbar Navbar -->
                <ul class="navbar-nav ml-auto">
                    <!-- START: navbar-nav 1 -->
                    <li class="nav-item dropdown no-arrow mx-1">
                        <!-- START: Nav Item - Alerts 1 -->
                        <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-bell fa-fw"></i>
                            <span class="badge badge-danger badge-counter">3+</span>
                        </a>
                        <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="alertsDropdown">
                            <!-- START: DIV Alerts 1 -->
                            <h6 class="dropdown-header">
                                Alerts Center
                            </h6>
                            <a class="dropdown-item d-flex align-items-center" href="#">
                                <div class="mr-3">
                                    <div class="icon-circle bg-primary">
                                        <i class="fas fa-file-alt text-white"></i>
                                    </div>
                                </div>
                                <div>
                                    <div class="small text-gray-500">December 12, 2019</div>
                                    <span class="font-weight-bold">A new monthly report is ready to download!</span>
                                </div>
                            </a>
                            <a class="dropdown-item d-flex align-items-center" href="#">
                                <div class="mr-3">
                                    <div class="icon-circle bg-success">
                                        <i class="fas fa-donate text-white"></i>
                                    </div>
                                </div>
                                <div>
                                    <div class="small text-gray-500">December 7, 2019</div>
                                    $290.29 has been deposited into your account!
                                </div>
                            </a>
                            <a class="dropdown-item d-flex align-items-center" href="#">
                                <div class="mr-3">
                                    <div class="icon-circle bg-warning">
                                        <i class="fas fa-exclamation-triangle text-white"></i>
                                    </div>
                                </div>
                                <div>
                                    <div class="small text-gray-500">December 2, 2019</div>
                                    Spending Alert: We've noticed unusually high spending for your account.
                                </div>
                            </a>
                            <a class="dropdown-item text-center small text-gray-500" href="#">Show All Alerts</a>
                        </div> <!-- END: DIV Alerts 1 -->
                    </li> <!-- END: Nav Item - Alerts 1 -->

                    <!-- Nav Item - Messages -->
                    <li class="nav-item dropdown no-arrow mx-1">
                        <!-- START: Nav Item - Messages 1 -->
                        <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-envelope fa-fw"></i>
                            <span class="badge badge-danger badge-counter">7</span>
                        </a>
                        <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="messagesDropdown">
                            <!-- START: DIV Alerts 2 -->
                            <h6 class="dropdown-header">
                                Message Center
                            </h6>
                            <a class="dropdown-item text-center small text-gray-500" href="#">Read More Messages</a>
                        </div> <!-- END: DIV Alerts 2 -->
                    </li> <!-- END: Nav Item - Messages 1 -->

                    <div class="topbar-divider d-none d-sm-block"></div>

                    <li class="nav-item dropdown no-arrow">
                        <!-- START: Nav Item - User Information 1 -->
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="mr-2 d-none d-lg-inline text-gray-600 small">Valerie Luna</span>
                            <!--   <img class="img-profile rounded-circle" src="https://source.unsplash.com/QAB-WJcbgJk/60x60">-->$GLOBALS </a>
                        <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                            <!-- START: DIV Alerts 3 -->
                            <a class="dropdown-item" href="#">
                                <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                Profile
                            </a>
                            <a class="dropdown-item" href="#">
                                <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                                Settings
                            </a>
                            <a class="dropdown-item" href="#">
                                <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                                Activity Log
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                Logout
                            </a>
                        </div> <!-- END: DIV Alerts 3 -->
                    </li> <!-- END: Nav Item - User Information 1 -->

                </ul> <!-- END: navbar-nav 1 -->

            </nav> <!-- END: navbar 1 -->