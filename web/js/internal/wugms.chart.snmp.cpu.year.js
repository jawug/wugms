$(document).ready(function() {
    var options3 = {
        chart: {
            renderTo: 'cpu12months',
            type: 'area',
			zoomType: 'x',
/*            marginRight: 100, */
            marginBottom: 25
        },
		colors: ['#7cb5ec'],
        title: {
            text: 'CPU reading(s) for the last 12 months',
            x: -20 //center
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
            minRange: 7 * 24 * 3600000
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

    $.getJSON("/content/snmp_cpu_data.php?interval=day", function(json) {
		options3.series = json;
//        options3.xAxis.categories = json[0]['data'];
  //      options3.series[0] = json[1];
        cpu_year_chart = new Highcharts.Chart(options3);
    });
});