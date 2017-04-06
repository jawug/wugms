$(document).ready(function() {
    var options1 = {
        chart: {
            renderTo: 'sel_qos_stackedarea',
            type: 'spline',
            zoomType: 'x',
            /*            marginRight: 25, */
            marginBottom: 25
        },
        /*colors: ['#7cb5ec','#f7a35c'],*/
        title: {
            text: 'QoS flow reading(s) for the last 7 days',
            x: -20 //center
        },
        credits: {
            enabled: false
        },
        subtitle: {
            text: 'Values displayed is at time of device polling. Null data means that there was no valid reading for that time.',
            x: -20
        },
        xAxis: {
            type: 'datetime',
            minRange: 24 * 3600000
                /*			dateTimeLabelFormats: {
                                        second: '%Y-%m-%d<br/>%H:%M:%S',
                                        minute: '%Y-%m-%d<br/>%H:%M',
                                        hour: '%Y-%m-%d<br/>%H:%M',
                                        day: '%Y<br/>%m-%d',
                                        week: '%Y<br/>%m-%d',
                                        month: '%Y-%m',
                                        year: '%Y'
                                    }, */
//                			tickInterval: 3600 * 1000 
                //            categories: []
        },
        /*        yAxis: {
                    title: {
                        text: 'Bytes'
                    },
        			floor: 0,
                    labels: {
                        formatter: function() {
                            return this.value
                        },
                    }
                },*/
        yAxis: {
            title: {
                text: 'Bytes per hour (b)'
            },
            min: 0
        },
        tooltip: {
            enabled: true,
            shared: true,
            valueSuffix: ' Bytes'
        },
        /*        tooltip: {
                    headerFormat: '<b>{series.name}</b><br>',
                    pointFormat: '{point.x:%e. %b}: {point.y:.2f} m'
                },*/
        /*        legend: {
                    layout: 'vertical',
                    align: 'right',
                    verticalAlign: 'top',
                    x: -10,
                    y: 100,
                    borderWidth: 0
                },*/
        legend: {
            enabled: false
        },
        plotOptions: {
            spline: {
                /*                fillColor: {
                                    linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1},
                                    stops: [
                                        [0, 'rgba(144, 237, 125, 0.5)'],
                                        [1, 'rgba(241, 92, 128, 0.5)']
                                    ]
                                }, */
                marker: {
                    radius: 1
                },
                gapSize: 1,
                stacking: 'normal',
                lineWidth: 1,
                states: {
                    hover: {
                        lineWidth: 1
                    }
                }
                /* threshold: null*/
            }
        },
        /*		plotOptions: {
        			area: {
                        marker: {
                            enabled: true
                        }
                    }
                },*/
        series: [{}]
    }

    $.getJSON("/content/wugms.chart.user.routerboard.qos.area.php", function(json) {
        //$.getJSON("/content/wugms.chart.user.routerboard.qos.area.php?sel_ip=172.16.250.127&sel_area=ICMP", function(json) {
        options1.series = json;
        sel_rb_qos_chart_area = new Highcharts.Chart(options1);
    });
});