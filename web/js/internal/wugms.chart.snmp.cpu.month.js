$(document).ready(function() {
    var options2 = {
        chart: {
            renderTo: 'cpu30days',
            type: 'area',
			zoomType: 'x',
/*            marginRight: 100, */
            marginBottom: 25
        },
		colors: ['#7cb5ec'],
        title: {
            text: 'CPU reading(s) for the last 30 days',
        //    x: -20 //center
        },
        credits: {
            enabled: false
        },
        subtitle: {
            text: 'Data has been aggregated for the displayed period.',
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
                    }, 
			tickInterval: 3600 * 1000 */
//            categories: []
        },
        yAxis: {
            title: {
                text: '% average'
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

    $.getJSON("/content/snmp_cpu_data.php?interval=60min", function(json) {
		options2.series = json;
//        options2.xAxis.categories = json[0]['data'];
  //      options2.series[0] = json[1];
        cpu_month_chart = new Highcharts.Chart(options2);
    });
});