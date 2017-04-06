$(function () {
    var options = {
        chart: {
            events: {
                load: function () {
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
                redraw: function () {
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
            renderTo: 'wifi_24GHz',
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false
        },
        title: {
            text: '2.4GHz Frequency usage'
        },
        tooltip: {
            formatter: function () {
                return '<b>' + this.point.name + '</b>: ' + this.point.y + ' AP(s) ';
                /*				return '<b>' + this.point.name + '</b>: ' + this.point.y + ' AP(s) '; */
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
                    formatter: function () {
                        return '<b>' + this.point.name + '</b>: ';
                        /*return '<b>' + this.point.name + '</b>: ' + this.point.y + '  '; */
                    }
                }
            },
            series: {
                cursor: 'pointer',
                point: {
                    events: {
                        click: function () {
                            /*theWifiTable.fnReloadAjax( '/content/wugms.table.wifi.php?param=' + this.name );*/
                            $('#wifi_table').bootstrapTable('refresh', {url: '/content/wugms.table.wifi.php?param=' + this.name});
                        }
                    }
                }
            }
        },
        series: [{
                type: 'pie',
                name: 'Browser share',
                data: [
                ]
            }
        ]
    };

    $.getJSON("/content/wugms.chart.wifi.24ghz.php", function (json) {
        options.series[0].data = json;
        chart = new Highcharts.Chart(options);
    });

});
