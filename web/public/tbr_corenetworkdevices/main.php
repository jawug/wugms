<div class="pagetitle" id="page_cnd"> </div> 
<div class="container-fluid theme-showcase" role="main">
    <?php include($page_decorator->server_base . '/public/wugms.modal.public.php'); ?>
    <div class="container-fluid">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h2 class="panel-title text-center"><b>Core Network Devices</b> <img src="/images/cnd.png" alt="..." class="img-rounded" width="24" height="24"></h2>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div id="rb_models" style="height: 400px; margin: 0 auto"></div>
                    </div>
                    <div class="col-md-6">
                        <div id="rb_ros" style="height: 400px; margin: 0 auto"></div>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-12">
                        <table id='cnd_table' data-url="/public/content/wugms.table.rb.php" data-toggle="table" data-classes="table table-hover table-condensed" data-striped="true" data-search="true" >
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