<!-- Scripts! -->
<?php include($_SERVER['DOCUMENT_ROOT'] . '/footreq.php'); ?>
<script src="/js/select2.min.js" type="text/javascript"></script>
<script src="/js/highcharts.js" type="text/javascript"></script>
<script src="/js/highcharts-more.js" type="text/javascript"></script>
<script src="/js/modules/solid-gauge.js" type="text/javascript"></script>
<script src="/js/modules/data.js" type="text/javascript"></script>

<!--
<script type="text/javascript" src="//maps.google.com/maps/api/js?sensor=true"></script>
<script src="/js/gmaps.js" type="text/javascript"></script>
-->
<!-- Custom charts -->
<script src="/js/wugms.gauge.ssid.overview.js" type="text/javascript"></script> 
<script src="/js/wugms.chart.snmp.ap.clients.signal.js" type="text/javascript"></script>

<script type="text/javascript">
    $(document).ready(function () {
        /* Selector for Routerboards*/
        /* Init */
        $(".selector2_rb").select2({
            placeholder: "Select a SSID",
            allowClear: true,
            theme: "classic"
        });
        $('#selector2_rb').select2('val', '');

        /* On change event */
        $("#selector2_rb").on('change', function (e) {
            /* As there was a change, we must get the new Id and then pass that on to the other selector */
            var str = $("#selector2_rb").val();
            //  console.log($("#selector2_rb").val());
            if (str != '') {
                //      console.log(str);


                var split_row = str.split('__');
                var $ov_ssid_sn = split_row[0];
                /*console.log($ov_ssid_sn);*/
                var $ov_ssid_name = split_row[1];
                /*console.log($ov_ssid_name);*/
                //			var $ov_ssid_id = split_row[2];
                /*console.log($ov_ssid_id);*/

                //			var res = str.split("___");
                $.ajax({
                    type: "POST",
                    url: "/content/wugms.user.ssid.updater.php",
                    data: {
                        ov_ssid_sn: $ov_ssid_sn,
                        ov_ssid_name: $ov_ssid_name

                    },
                    success: function () {
                        $('#sel_device').html("<h3 class='sub-header'>Selected SSID: <span style='color: rgb(0, 0, 153);'>" + $ov_ssid_name + "</span></h3>");
                        $('#sel_device_res').html("<div class='alert alert-success alert-dismissible' role='alert'>Update successful. <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");
                        $('#ssid_ap_table').bootstrapTable('refresh', '/content/snmp_ssid_ap.php?ssid_level=mov');
                        $('#ssid_client_table').bootstrapTable('refresh', '/content/snmp_ssid_clients.php?ssid_level=mov');
                        /* Clear the series in teh charts */
                        /*if (ssid_ov_txccq_guage.series.length) {*/
                        if (ssid_ov_txccq_guage) {
                            ssid_ov_txccq_guage.series[0].remove();
                        }
                        ;
                        $.getJSON("/content/wugms.guage.ssid.main.ccq.php", function (json) {
                            ssid_ov_txccq_guage.addSeries(json[0]);
                            ssid_ov_txccq_guage.redraw();
                        });
                        /* Refresh the Interface data based on the settings */
                        while (ap_client_signal_snmp_chart.series.length > 0)
                            ap_client_signal_snmp_chart.series[0].remove(true);
                        /* Update the speed chart */
                        $.getJSON("/content/snmp_ssid_client_signal_data.php", function (json) {
                            for (var i = 0; i < json.data.length; i++) {
                                if (i == 0) {
                                    ap_client_signal_snmp_chart.addSeries({
                                        type: 'spline',
                                        name: json.data[i].name,
                                        /*								color: '#00cf00', */
                                        marker: {
                                            enabled: false,
                                            states: {
                                                hover: {
                                                    enabled: true,
                                                    radius: 1
                                                }
                                            }
                                        },
                                        gapSize: 1,
                                        lineWidth: 1,
                                        states: {
                                            hover: {
                                                lineWidth: 1
                                            }
                                        },
                                        /*                                    fillColor: {
                                         linearGradient: {
                                         x1: 0,
                                         y1: 0,
                                         x2: 0,
                                         y2: 1
                                         },
                                         stops: [
                                         [0, '#00cf00'],
                                         [1, 'rgba(0, 207, 0, 0.1)']
                                         ]
                                         }, */
                                        data: json.data[i].data
                                    });
                                }
                                ;

                                if (i >= 1) {
                                    ap_client_signal_snmp_chart.addSeries({
                                        type: 'spline',
                                        name: json.data[i].name,
                                        /*								color: '#002A97', */
                                        marker: {
                                            enabled: false,
                                            states: {
                                                hover: {
                                                    enabled: true,
                                                    radius: 1
                                                }
                                            }
                                        },
                                        gapSize: 1,
                                        lineWidth: 1,
                                        states: {
                                            hover: {
                                                lineWidth: 1
                                            }
                                        },
                                        data: json.data[i].data
                                    });
                                }
                                ;
                            }
                            ap_client_signal_snmp_chart.redraw();
                        });


                    },
                    error: function () {
                        $('#sel_device_res').html("<div class='alert alert-danger alert-dismissible' role='alert'>There was a problem with your selection. <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");
                        //	console.log('no');
                    }
                });
            }
        });
    });
</script>
</body>
</html>
