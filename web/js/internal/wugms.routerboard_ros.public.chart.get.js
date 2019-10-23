$(function() {
    var options = {
        chart: {
            renderTo: 'chart_routerboard_ros',
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false
        },
        title: {
            text: 'Routerboards by ROS'
        },
        tooltip: {
            formatter: function() {
                return '<b>' + this.point.name + '</b>: ' + this.point.y + ' unit(s) ';
            }
        },
        credits: {
            enabled: false
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: true,
                    color: '#000000',
                    connectorColor: '#000000',
                    formatter: function() {
                        return '<b>' + this.point.name + '</b>: ';
                    }
                }
            },
            series: {
                cursor: 'pointer',
                point: {
                    events: {
                        click: function() {
                            $('#cnd_table').bootstrapTable('refresh', { url: '/public/content/wugms.routerboard_details.public.table.get.php?param=' + this.name + '&dataonly=true' });
                        }
                    }
                }
            }
        },
        series: [{
            type: 'pie',
            name: 'Routerboards by ROS',
            data: []
        }]
    };

    $.ajaxSetup({
        cache: false,
        async: false
    });

    $.ajax({
        url: "/public/content/wugms.routerboard_ros.public.chart.get.php",
        dataType: 'json',
        success: function(data, textStatus, jqXHR) {
            if (textStatus === "success") {
                /* Add the series data */
                options.series[0].data = data.data;
                chart = new Highcharts.Chart(options);
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.log("error");
            console.log("jqXHR: " + jqXHR);
            console.log("textStatus: " + textStatus);
            console.log("errorThrown: " + errorThrown);
        }
    });
});