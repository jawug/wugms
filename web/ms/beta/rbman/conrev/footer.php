		<!-- Scripts! -->
		<?php include($_SERVER['DOCUMENT_ROOT'].'/footreq.php'); ?>
		<script src="/js/highstock.js" type="text/javascript"></script>

<!-- The Chosen selector for the  -->
<script type="text/javascript">	
$(document).ready(function() {
    $('.chzn-select').each(function() {
        if ($(this).html().trim().length > 0) {
            pimpSelect($(this));
        }
    });

});

function pimpSelect(select, options) {
    var prepend = '';
    if (select.attr('data-placeholder')) {
        prepend = '<option></option>';
    }
    if (options) {
        options = prepend + options;
        select.empty().html(options);
    } else {
        select.prepend(prepend);
    }
    if (select.hasClass('chzn-select')) {
        var _width = select.css('width');
        select.chosen({
            width: _width
        });
    }
};
</script>

<script type="text/javascript">	
$(document).ready(function() {
/* Detect is there was a selection change */
	$('#cdn_select').on('change', function(event, params) {
/* Set the heading to show which rb has been selected */			
		$('#sel_device').html("<h3 class='sub-header'>Selected device: <span style='color: rgb(0, 0, 153);'>" + $('#cdn_select option:selected').text() + "</span></h3>");
/* This is the selected value */
		//console.log("cdn_select: " +  $("#cdn_select").val());
		/* Update the tables */
		$('#rb_header_table').bootstrapTable('refresh',{url: '/content/wugms.table.user.rb.header.php?sn=' +  $("#cdn_select").val()});
		$('#rb_int_ether').bootstrapTable('refresh',{url: '/content/wugms.table.user.rb.interface.ether.php?sn=' +  $("#cdn_select").val()});
		$('#rb_int_wifi').bootstrapTable('refresh',{url: '/content/wugms.table.user.rb.interface.wifi.php?sn=' +  $("#cdn_select").val()});
		$('#rb_ipv4').bootstrapTable('refresh',{url: '/content/wugms.table.user.rb.ipv4.php?sn=' +  $("#cdn_select").val()});
		$('#rb_ipv4_route').bootstrapTable('refresh',{url: '/content/wugms.table.user.rb.ipv4.route.php?sn=' +  $("#cdn_select").val()});
		$('#rb_radius').bootstrapTable('refresh',{url: '/content/wugms.table.user.rb.radius.php?sn=' +  $("#cdn_select").val()});
		$('#rb_bgp_instance').bootstrapTable('refresh',{url: '/content/wugms.table.user.rb.bgp.instance.php?sn=' +  $("#cdn_select").val()});
		$('#rb_bgp_peer').bootstrapTable('refresh',{url: '/content/wugms.table.user.rb.bgp.peer.php?sn=' +  $("#cdn_select").val()});
		$('#rb_bgp_network').bootstrapTable('refresh',{url: '/content/wugms.table.user.rb.bgp.network.php?sn=' +  $("#cdn_select").val()});
		$('#rb_bgp_aggregate').bootstrapTable('refresh',{url: '/content/wugms.table.user.rb.bgp.aggregate.php?sn=' +  $("#cdn_select").val()});
		$('#rb_services').bootstrapTable('refresh',{url: '/content/wugms.table.user.rb.services.php?sn=' +  $("#cdn_select").val()});
		$('#rb_snmp').bootstrapTable('refresh',{url: '/content/wugms.table.user.rb.snmp.php?sn=' +  $("#cdn_select").val()});
		$('#rb_snmp_community').bootstrapTable('refresh',{url: '/content/wugms.table.user.rb.snmp.community.php?sn=' +  $("#cdn_select").val()});
		});
});
</script>
</html>
