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
            text: ' '
        },
        tooltip: {
            formatter: function() {
                return '<b>' + this.point.name + '</b>: ' + Highcharts.numberFormat(this.percentage, 2) + ' %'
            }
        },
        credits: {
            enabled: false
        },
        plotOptions: {
            pie: {
                innerSize: 100,
                depth: 45
            },
            series: {
                cursor: 'pointer',
                point: {
                    events: {
                        click: function() {
/*                            while (sel_rb_qos_chart.series.length > 0)
                                sel_rb_qos_chart.series[0].remove(true);*/
                            var $row = this.name;
                            //var n = $row.indexOf(" ");
//                            var $sel_ip = $row.slice(0, n);
                            //console.log($sel_ip + "test")
                            $.getJSON("/content/wugms.chart.user.routerboard.qos.selected.php?sel_ip=" + this.name, function(json) {
                                /*sel_rb_qos_chart_area.addSeries(json);*/
                                sel_rb_qos_chart.series[0].setData(json,false);
                                sel_rb_qos_chart.redraw();
						//		console.log($row);
								$('#sel_rb_qos_name').html("Selected site: <span style='color: rgb(0, 0, 153);'>" + $row + "</span>");
                            });
                        }
                    }
                }
            },
        },
        series: [{}]
    }
    $.getJSON("/content/wugms.chart.user.routerboard.qos.overview.php", function(json) {
        options.series[0].data = json;
        ov_qos_chart = new Highcharts.Chart(options);
    });

});