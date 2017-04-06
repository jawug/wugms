$(document).ready(function() {
    var options1 = {
        chart: {
            renderTo: 'rb_current',
            type: 'areaspline',
			zoomType: 'x',
/*            marginRight: 25, */
            marginBottom: 25
        },
		colors: ['#e4d354'],
        title: {
            text: 'Current reading(s) for the last 7 days',
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
                text: 'mA'
            },
			floor: 0,
            labels: {
                formatter: function() {
                    return this.value
                },
            }
        },
        tooltip: {
			crosshairs: false,
                shared: true,
				valueSuffix:  'mA'
/*            formatter: function() {
                return 'CPU ID<b> 1</b><br/>Time<b> ' + this.x + '</b><br/>Reading <b>' + this.y + '%</b>';
            } */
        },
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
            areaspline: {
                fillColor: {
                    linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1},
                    stops: [
                        [0, '#e4d354'],
                        [1, 'rgba(228, 211, 84, 0.1)']
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
                },
                threshold: null
            }
        },	
        series: []
    }

	
    $.getJSON("/content/snmp_rb_device.php?area=current", function(json) {
//        options1.xAxis.categories = json[0]['data'];
        options1.series = json;
        rb_current_chart = new Highcharts.Chart(options1);
    });
});