$(document).ready(function() {
    var options3 = {
        chart: {
            renderTo: 'rb_volt',
            type: 'area',
			zoomType: 'x',
/*            marginRight: 25, */
            marginBottom: 25
        },
		colors: [
		'#7cb5ec'
//		'#7cb5ec' -- light blue
//		'#434348'  -- Dark grey
//		'#90ed7d'  -- Light green
//		'#f7a35c'  -- light orange
//		'#8085e9'  -- Light purple
//		'#8085e9'  -- Light purple
//		'#f15c80'  -- light red/pink
//		'#e4d354'  -- light yellow
//		'#8085e8'  -- med purple
//		'#8d4653'  -- dark red
//		'#91e8e1'  -- light blue/green
		],
        title: {
            text: 'Voltage reading(s) for the last 7 days',
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
/*			dateTimeLabelFormats: {
                        second: '%Y-%m-%d<br/>%H:%M:%S',
                        minute: '%Y-%m-%d<br/>%H:%M',
                        hour: '%Y-%m-%d<br/>%H:%M',
                        day: '%Y<br/>%m-%d',
                        week: '%Y<br/>%m-%d',
                        month: '%Y-%m',
                        year: '%Y'
                    }, 
			tickInterval: 3600 * 1000 */
//            categories: []
        },
        yAxis: {
            title: {
                text: 'VDC'
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
				valueSuffix: ' DC'
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
            area: {
                fillColor: {
                    linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1},
                    stops: [
                        [0, '#7cb5ec'],
                        [1, 'rgba(124, 181, 236, 0.1)']
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

	
    $.getJSON("/content/snmp_rb_device.php?area=volt", function(json) {
//        options3.xAxis.categories = json[0]['data'];
        options3.series = json;
        rb_voltage_chart = new Highcharts.Chart(options3);
    });
});