$(document).ready(function() {
    var options1 = {
        chart: {
            renderTo: 'interface_speed',
            zoomType: 'x',
            borderWidth: 0,
            plotBorderWidth: 0
        },
        title: {
            text: '',
            x: -20 
        },
        credits: {
            enabled: false
        },
        subtitle: {
            text: '',
            x: -20
        },
        xAxis: {
            type: 'datetime',
            minRange: 1 * 3600000
        },
        yAxis: {
            title: {
                text: 'Bytes per second'
            },
            labels: {
                formatter: function() {
                    return this.value
                },
            }
        },
        tooltip: {
            enabled: true,
            shared: true,
            valueSuffix: ' Bps'
        },
        legend: {
            enabled: false
        },
        series: [{
                type: 'areaspline',
                name: 'Tx',
                color: '#00cf00',
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
                fillColor: {
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
                },
                data: []
            }, {
                type: 'spline',
                name: 'Rx',
                color: '#002A97',
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
                data: []
            }
        ]
    }

    $.ajax({
        url: "/content/snmp_interface_data.php?dtype=speed",
        dataType: 'json',
        success: function(data) {
            var series0 = data.data[0].data;
            var series1 = data.data[1].data;
            options1.series = [{
                type: 'areaspline',
                name: 'Tx',
                color: '#00cf00',
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
                fillColor: {
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
                },
                data: series0
            }, {
                type: 'spline',
                name: 'Rx',
                color: '#002A97',
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
                data: series1
            }];
            interfaces_speed_snmp_chart = new Highcharts.Chart(options1);
        },
        error: function() {
            options1.series = [{
                "name": "Tx",
                "data": []
            }, {
                "name": "Rx",
                "data": []
            }];
            interfaces_speed_snmp_chart = new Highcharts.Chart(options1);
        }
    });
});