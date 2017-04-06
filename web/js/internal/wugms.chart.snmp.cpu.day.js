$(document).ready(function() {
    var options1 = {
        chart: {
            renderTo: 'cpu24hours',
            type: 'area',
			zoomType: 'x',
/*            marginRight: 25, */
            marginBottom: 25
        },
		colors: ['#7cb5ec'],
        title: {
            text: 'CPU reading(s) for the last 48 hours',
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
                text: '%'
            },
			floor: 0,
            labels: {
                formatter: function() {
                    return this.value
                },
            }
        },
        tooltip: {
			enabled: true,
			shared: true
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

	
    $.getJSON("/content/snmp_cpu_data.php?interval=5min", function(json) {
		options1.series = json;
//        options1.xAxis.categories = json[0]['data'];
       // options1.series[0] = json[0];		
        //options1.xAxis.categories = json[0];
   //     options1.series[0].setdata(json[0]);
        cpu_day_chart = new Highcharts.Chart(options1);		

		
    }); 
});