$(function() {
    var options = {
        chart: {
            type: 'pie',
            options3d: {
                enabled: true,
                alpha: 45
            },
            renderTo: 'ov_qos'
        },
        title: {
            text: null
        },
        tooltip: {
            formatter: function() {
                return '<b>' + this.point.name + '</b>: ' + Highcharts.numberFormat(this.percentage, 2) + ' %'
            }
        }, 
        credits: {
            enabled: false
        },
        xAxis: {
            categories: ['QoS'],
            title: {
                text: null
            }
        },
        yAxis: {
            min: 0,
            title: {
                text: 'Bytes (millions)',
                align: 'high'
            },
            labels: {
                //overflow: 'justify'
				text: null
            }
        },		
        plotOptions: {
            pie: {
                innerSize: 100,
                depth: 45
            },
            series: {
				showInLegend: false,
                cursor: 'pointer',
                point: {
                    events: {
                        click: function() {
                            var $row = this.name;
                            $.getJSON("/content/wugms.chart.admin.routerboard.qos.selected.php?sel_ip=" + this.name, function(json) {
                                sel_rb_qos_chart.series[0].setData(json,false);
                                sel_rb_qos_chart.redraw();
								$('#sel_rb_qos_name').html("Selected site: <span style='color: rgb(0, 0, 153);'>" + $row + "</span>");
                            });
                        }
                    }
                }
            },
        }, 
/*		plotOptions: {
            column: {
                dataLabels: {
                    enabled: true
                }
            },
            series: {
				showInLegend: false,
                cursor: 'pointer',
                point: {
                    events: {
                        click: function() {
                            var $row = this.series.name;
                            $.getJSON("/content/wugms.chart.admin.routerboard.qos.selected.php?sel_ip=" + $row, function(json) {
                                sel_rb_qos_chart.series[0].setData(json,false);
                                sel_rb_qos_chart.redraw();
								$('#sel_rb_qos_name').html("Selected site: <span style='color: rgb(0, 0, 153);'>" + $row + "</span>");
                            });
                        }
                    }
                }
            }
        },*/
/*		legend: {
            layout: 'vertical',
            align: 'right',
            verticalAlign: 'top',
            x: -40,
            y: 80,
            floating: true,
            borderWidth: 1,
            backgroundColor: ((Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF'),
            shadow: true
        },*/
        series: [{}]
    }
    $.getJSON("/content/wugms.chart.admin.routerboard.qos.overview.php", function(json) {
        options.series[0].data = json[0].data;
        ov_qos_chart = new Highcharts.Chart(options);
    });

});