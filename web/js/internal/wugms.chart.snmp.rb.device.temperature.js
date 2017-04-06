$(document).ready(function() {
    var options2 = {
        chart: {
            renderTo: 'rb_temp',
            type: 'area',
			zoomType: 'x',
/*            marginRight: 25, */
            marginBottom: 25
        },
		colors: ['#8d4653'],
        title: {
            text: 'Temperature reading(s) for the last 7 days',
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
            minRange: 1 * 3600000
        },
        yAxis: {
            title: {
                text: '°C'
            },
//			floor: 0,
            labels: {
                formatter: function() {
                    return this.value
                },
            }
        },
        tooltip: {
			crosshairs: false,
                shared: true,
				valueSuffix:  '°'
        },
		legend: {
			enabled: false
		},
        plotOptions: {
            area: {
                fillColor: {
                    linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1},
                    stops: [
                        [0, 'rgba(255, 0, 0, 1)'],
                        [1, 'rgba(255, 0, 0, 0.1)']
                    ]
                },
                marker: {
                    radius: 1
                }, 
                lineWidth: 1,
				gapSize: 1,
                states: {
                    hover: {
                        lineWidth: 1
                    }
                }
//                threshold: null
            }
        }, 
        series: []
    }

	
    $.getJSON("/content/snmp_rb_device.php?area=temp", function(json) {
//        options2.xAxis.categories = json[0]['data'];
        options2.series = json;
        rb_temp_chart = new Highcharts.Chart(options2);
    });
});