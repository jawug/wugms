<!-- Scripts! -->
<?php include($_SERVER['DOCUMENT_ROOT'] . '/footreq.php'); ?>
<!--	<script src="/js/chosen.jquery.js" type="text/javascript"></script> -->
<script src="/js/highstock.js" type="text/javascript"></script>
<script src="/js/modules/data.js" type="text/javascript"></script>
<script src="/js/themes/grid.js" type="text/javascript" ></script>
<script src="/js/select2.min.js" type="text/javascript"></script>
<script src="/js/moment.min.js" type="text/javascript"></script>
<script src="/js/bootstrap-datetimepicker.min.js" type="text/javascript"></script>

<!-- Custom charts -->
<script src="/js/wugms.chart.snmp.cpu.js" type="text/javascript"></script>
<script src="/js/wugms.chart.snmp.storage.js" type="text/javascript"></script>
<script src="/js/wugms.chart.snmp.rb.device.js" type="text/javascript"></script> 
<!--	<script src="/js/wugms.ms.dashboard.cpu.misc.js" type="text/javascript"></script>  -->


<script type="text/javascript">
    $(document).ready(function () {
        /* * This section inits and sets various componets * */
        /* * Init the date/time selectors * */
        /* Start datetime */
        var olddate = new Date(); // create a date of Jun 15/2011, 8:32:00am
        var subbed = new Date(olddate - 12 * 60 * 60 * 1000); // subtract 3 hours

        /* Setup the start date component */
        $('#sdatepicker').datetimepicker({
            format: "YYYY-MM-DD HH:mm",
            defaultDate: subbed
        });
        /* Look for any on change events for the start date component */
        $("#sdatepicker").on("dp.change", function (e) {
            $('input[name="device_data_start_date_change"]').val($("#sdatepickertext").val());
        });

        /* End dateimte */
        /* Setup the end date component */
        $('#edatepicker').datetimepicker({
            format: 'YYYY-MM-DD HH:mm',
            showTodayButton: true,
            defaultDate: new Date()

        });
        /* Look for any on change events for the start date component */
        $("#edatepicker").on("dp.change", function (e) {
            $('input[name="device_data_end_date_change"]').val($("#edatepickertext").val());
        });

        /* Selector for Routerboards*/
        /* Init */
        $(".selector2_rb").select2({
            placeholder: "Select a routerboard",
            allowClear: true,
            theme: "classic"
        });
        $('#selector2_rb').select2('val', '');


        /* Selector for time interval*/
        /* Init */
        $(".selector2_interval").select2({
            placeholder: "Select an interval",
            allowClear: true,
            theme: "classic"
        });

    });
</script>

<script type="text/javascript">
    $(document).ready(function () {
        /* Update button code goes here */
        $("#update_selection").click(function () {
            $('#feedback').empty();
            /* Get the value of the selected option */
            var str = $("#selector2_rb").val();
            /* If there is no selected routerboard then warn the user */
            if (!str) {
                $('#feedback').html("<div class='alert alert-warning alert-dismissible' role='alert'>No <b>routerboard</b> has been selected from the drop down. <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");
                return false;
            }
            var res = str.split("___");

//	echo "<option value='" . $value['sn'] . "___" . $value["sitename"] . "___" . $value["device_name"] . "___" . $value["device_model"] . "'>" . $value["sitename"] . " -> " . $value["device_name"] . "</option>";
            /*  */
            $.ajax({
                type: "POST",
                url: "/content/wugms.user.routerboard.selection.update.php",
                data: {
                    device_sn: res[0],
                    device_site: res[1],
                    device_des: res[2],
                    device_model: res[3],
                    device_data_interval: $("#selector2_interval").val(),
//				device_data_start_date: $("#sdatepickertext").val(),

                    device_data_start_date: $("#sdatepickertext").val(),
                    device_data_end_date: $("#edatepickertext").val()
//				device_data_end_date: $("#edatepickertext").val()
                },
                success: function () {
                    /* Update the different inputs with the values that were posted */
                    /* Start with the hidden inputs */
                    $("#device_data_end_date_init").val();
                    $("#device_data_start_date_init").val();
                    $("#device_data_end_date_change").val($("#device_data_end_date_change").val());
                    $("#device_data_start_date_change").val($("#device_data_start_date_change").val());
                    $("#device_data_interval_init").val($("#selector2_interval").val());
                    $("#device_des_init").val(res[2]);
                    $("#device_site_init").val(res[1]);
                    $("#device_sn_init").val(res[0]);
                    $('#sel_device').html("Site: <span style='color: rgb(0, 0, 153);'><b>" + res[1] + "</span></b> Routerboard: <span style='color: rgb(0, 0, 153);'><b>" + res[2] + "</span></b>");


                    /* Refresh the CPU data based on the settings */
                    while (cpu_snmp_chart.series.length > 0)
                        cpu_snmp_chart.series[0].remove(true);
                    $.getJSON("/content/snmp_cpu_data.php", function (json) {
                        for (var i = 0; i < json.data.length; i++) {
                            if (i == 0) {
                                cpu_snmp_chart.addSeries({
                                    name: json.data[i].name,
                                    type: "spline",
                                    color: '#008080', // something
                                    tooltip: {
                                        valueSuffix: ' %'
                                    },
                                    data: json.data[i].data
                                });
                            }
                            ;

                            if (i === 1) {
                                cpu_snmp_chart.addSeries({
                                    name: json.data[i].name,
                                    type: "spline",
                                    color: '#FF6600', // something
                                    tooltip: {
                                        valueSuffix: ' %'
                                    },
                                    data: json.data[i].data
                                });
                            }
                            ;

                            //cpu_snmp_chart.addSeries(json.data[i]						);
                        }
                        cpu_snmp_chart.redraw();
                    });

                    /* Refresh the Storage data based on the settings */
                    while (storage_snmp_chart.series.length > 0)
                        storage_snmp_chart.series[0].remove(true);
                    $.getJSON("/content/snmp_storage_data.php", function (json) {
                        for (var i = 0; i < json.data.length; i++) {
                            storage_snmp_chart.addSeries(json.data[i]);
                        }
                        storage_snmp_chart.redraw();
                    });

                    /* Refresh the Device data based on the settings */
                    while (device_snmp_chart.series.length > 0)
                        device_snmp_chart.series[0].remove(true);
                    $.getJSON("/content/snmp_device_data.php", function (json) {
                        for (var i = 0; i < json.data.length; i++) {
                            if (i === 0) {
                                device_snmp_chart.addSeries({
                                    name: json.data[i].name,
                                    type: "spline",
                                    color: '#105D9A', // something
                                    tooltip: {
                                        valueSuffix: ' mA'
                                    },
                                    data: json.data[i].data
                                });
                            }
                            ;

                            if (i === 1) {
                                device_snmp_chart.addSeries({
                                    name: json.data[i].name,
                                    type: "spline",
                                    color: '#FB0000',
                                    tooltip: {
                                        valueSuffix: ' °C'
                                    },
                                    data: json.data[i].data
                                });
                            }
                            ;

                            if (i === 2) {
                                device_snmp_chart.addSeries({
                                    name: json.data[i].name,
                                    type: "spline",
                                    color: '#B9B900',
                                    tooltip: {
                                        valueSuffix: ' VDC'
                                    },
                                    data: json.data[i].data
                                });
                            }
                            ;

                        }
                        device_snmp_chart.redraw();
                    });
                },
                error: function (data) {
                    /* Display an alert to let the user know that something happened, something bad. */
                    $('#feedback').html("<div class='alert alert-danger alert-dismissible' role='alert'>Seems like there was a problem. Returned status: <b>" + data.status + "</b> message: <b>" + data.message + "</b><br/>Please refresh the page and try again or else contact the wugms admins. <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");
//					console.log('no'); {"status":400,"message":"Invalid Request"}
//					console.log(data);
                }
            });
        });
    });

</script>
</body>
</html>
