<!-- Scripts! -->
<?php include($_SERVER['DOCUMENT_ROOT'] . '/footreq.php'); ?>
<script src="/js/highstock.js" type="text/javascript"></script>
<script src="/js/bootstrap-table-filter-control.min.js" type="text/javascript"></script>
<script src="/js/select2.min.js" type="text/javascript"></script>

<script type="text/javascript">
    $(".selector2_rb").select2({
        placeholder: "Select a routerboard",
        allowClear: true,
        theme: "classic"
    });
    $('#selector2_rb').select2('val', '');
</script>

<script type="text/javascript">
    $("#selector2_rb").on('change', function (e) {
        /* Get the value of the selected option */
        var str = $("#selector2_rb").val();
        /* If there is no selected routerboard then warn the user */
        if (!str) {
            return false;
        }
        /* Set the heading to show which rb has been selected */
        $('#sel_device').html("Selected device: <span style='color: rgb(0, 0, 153);'>" + $('#selector2_rb').select2('data')[0].text + "</span>");
        $('#rb_header_table').bootstrapTable('refresh', {url: '/content/wugms.table.admin.rb.header.php?sn=' + $("#selector2_rb").val()});
        $('#rb_int_ether').bootstrapTable('refresh', {url: '/content/wugms.table.admin.rb.interface.ether.php?sn=' + $("#selector2_rb").val()});
        $('#rb_int_wifi').bootstrapTable('refresh', {url: '/content/wugms.table.admin.rb.interface.wifi.php?sn=' + $("#selector2_rb").val()});
        $('#rb_ipv4').bootstrapTable('refresh', {url: '/content/wugms.table.admin.rb.ipv4.php?sn=' + $("#selector2_rb").val()});
        $('#rb_ipv4_route').bootstrapTable('refresh', {url: '/content/wugms.table.admin.rb.ipv4.route.php?sn=' + $("#selector2_rb").val()});
        $('#rb_radius').bootstrapTable('refresh', {url: '/content/wugms.table.admin.rb.radius.php?sn=' + $("#selector2_rb").val()});
        $('#rb_bgp_instance').bootstrapTable('refresh', {url: '/content/wugms.table.admin.rb.bgp.instance.php?sn=' + $("#selector2_rb").val()});
        $('#rb_bgp_peer').bootstrapTable('refresh', {url: '/content/wugms.table.admin.rb.bgp.peer.php?sn=' + $("#selector2_rb").val()});
        $('#rb_bgp_network').bootstrapTable('refresh', {url: '/content/wugms.table.admin.rb.bgp.network.php?sn=' + $("#selector2_rb").val()});
        $('#rb_bgp_aggregate').bootstrapTable('refresh', {url: '/content/wugms.table.admin.rb.bgp.aggregate.php?sn=' + $("#selector2_rb").val()});
        $('#rb_services').bootstrapTable('refresh', {url: '/content/wugms.table.admin.rb.services.php?sn=' + $("#selector2_rb").val()});
        $('#rb_snmp').bootstrapTable('refresh', {url: '/content/wugms.table.admin.rb.snmp.php?sn=' + $("#selector2_rb").val()});
        $('#rb_snmp_community').bootstrapTable('refresh', {url: '/content/wugms.table.admin.rb.snmp.community.php?sn=' + $("#selector2_rb").val()});
    });
</script>
</html>
