$(document).ready(function() {
    var options2 = {
        chart: {
            renderTo: 'storage30days',
            type: 'spline',
			zoomType: 'x',
            marginBottom: 25
        },
		colors: ['#00ff00','#ff0000'],
        title: {
            text: 'Storage reading(s) for the last 30 days',
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
			type: 'datetime'
//            minRange: 1 * 3600000
        },
        yAxis: {
            title: {
                text: 'MiB'
            },
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
				marker : {
					enabled : false,
					states : {
						hover : {
							enabled : true,
							radius : 5
						}
					}
				},
				gapSize: 1,
                lineWidth: 1,
                states: {
                    hover: {
                        lineWidth: 1
                    }
                }
            } 
        }, 
        series: [{}]
    }

    $.getJSON("/content/snmp_storage_data.php?interval=month", function(json) {
        options2.series = [{
            name : json[0].name,
            type : "area",
            fillColor : {
              linearGradient : [0, 0, 0, 300],
              stops : [
                [0,  'rgba(0, 255, 0, 1)'],
                [1, 'rgba(0,255,0,0.1)']
              ]
            },
			pointInterval: 24 * 3600 * 1000,
			data: json[0].data
			
          }, {
            name : json[1].name,
            type : "spline",
			data: json[1].data
          }
        ]; 
        storage_month_chart = new Highcharts.Chart(options2);
    });
});