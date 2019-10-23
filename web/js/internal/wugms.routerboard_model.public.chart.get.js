$(function() {
    var options = {
        chart: {
            events: {
                load: function() {
                    var chart = this;
                    if (!chart.hasData()) {
                        var r = Math.min(chart.plotWidth / 2, chart.plotHeight / 2),
                            y = chart.plotHeight / 2 + chart.plotTop,
                            x = chart.plotWidth / 2 + chart.plotLeft;
                        chart.pieOutline = chart.renderer.circle(x, y, r).attr({
                            fill: '#ddd',
                            stroke: 'black',
                            'stroke-width': 1
                        }).add();
                    }
                },
                redraw: function() {
                    var chart = this;
                    if (chart.pieOutline && chart.pieOutline.element) {
                        if (chart.hasData()) {
                            chart.pieOutline.destroy();
                        } else {
                            var r = Math.min(chart.plotWidth / 2, chart.plotHeight / 2),
                                y = chart.plotHeight / 2 + chart.plotTop,
                                x = chart.plotWidth / 2 + chart.plotLeft;
                            chart.pieOutline.attr({
                                cx: x,
                                cy: y,
                                r: r
                            });
                        }
                    } else if (!chart.hasData()) {
                        var r = Math.min(chart.plotWidth / 2, chart.plotHeight / 2),
                            y = chart.plotHeight / 2 + chart.plotTop,
                            x = chart.plotWidth / 2 + chart.plotLeft;
                        chart.pieOutline = chart.renderer.circle(x, y, r).attr({
                            fill: '#ddd',
                            stroke: 'black',
                            'stroke-width': 1
                        }).add();
                    }
                }
            },
            renderTo: 'chart_routerboard_models',
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false
        },
        title: {
            text: 'Routerboards by models'
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
            name: 'Routerboards by models',
            data: []
        }]
    };

    $.ajaxSetup({
        cache: false,
        async: false
    });

    $.ajax({
        url: "/public/content/wugms.routerboard_model.public.chart.get.php",
        dataType: 'json',
        success: function(data, textStatus, jqXHR) {
            if (textStatus === "success") {
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