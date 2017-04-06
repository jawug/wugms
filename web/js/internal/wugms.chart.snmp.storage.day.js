$(document).ready(function() {
    var options1 = {
        chart: {
            renderTo: 'storage24hours',
            type: 'spline',
			zoomType: 'x',
            marginBottom: 25
        },
		colors: ['#00ff00','#ff0000'],
        title: {
            text: 'Storage reading(s) for the last 48 hours',
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

    $.getJSON("/content/snmp_storage_data.php?interval=day", function(json) {
        options1.series = [{
            name : json[0].name,
            type : "area",
            fillColor : {
              linearGradient : [0, 0, 0, 300],
              stops : [
                [0,  'rgba(0, 255, 0, 1)'],
                [1, 'rgba(0,255,0,0.1)']
              ]
            },
			data: json[0].data
			
          }, {
            name : json[1].name,
            type : "spline",
			data: json[1].data
          }
        ]; 
        storage_day_chart = new Highcharts.Chart(options1);
    });
});