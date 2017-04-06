<!-- Set the pagetitle -->
<div class="pagetitle" id="page_cnd"> </div>
<div id="page-wrapper">
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <h1 class="page-header"><img src="/images/cnd.png" alt="Core Network Devices" class="img-rounded" height="32"><b> Core Network Devices</b></h1>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="panel panel-default marginRow">
                <div class="row">
                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                        <div id="chart_routerboard_models" style="min-width: 310px; height: 400px; max-width: 600px; margin: 0 auto"></div>
                    </div>
                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                        <div id="chart_routerboard_ros" style="min-width: 310px; height: 400px; max-width: 600px; margin: 0 auto"></div>
                        <!--                        <div id="chart_routerboard_ros" style="min-width: 310px; height: 400px; max-width: 600px; margin: 0 auto"></div> -->
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