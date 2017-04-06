$(document).ready(function() {
    var options1 = {
        chart: {
            renderTo: 'interfaces_bytes_day',
            type: 'spline',
			zoomType: 'x',
            marginBottom: 25
        },
		colors: ['#007f00','#7f0000'],
        title: {
            text: 'Interface reading(s) for the last 48 hours',
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
        },
        yAxis: {
            title: {
                text: 'Bytes per second'
            },
//			floor: 0,
            labels: {
                formatter: function() {
                    return this.value
                },
            }
        },
        tooltip: {
			enabled: true,
			shared: true,
			valueSuffix: ' B/s'
        },
		legend: {
			enabled: false
		},
        plotOptions: {
            spline: {
				marker : {
					enabled : false,
					states : {
						hover : {
							enabled : true,
							radius : 1
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
	
    $.getJSON("/content/snmp_interface_data.php?interval=day", function(json) {
        options1.series = [{
            name : json[0].name,
            type : "spline",
/*            fillColor : {
              linearGradient : [0, 0, 0, 300],
              stops : [
                [0,  'rgba(0, 255, 0, 1)'],
                [1, 'rgba(0,255,0,0.1)']
              ]
            },*/
			data: json[0].data
			
          }, {
            name : json[1].name,
            type : "spline",
/*            fillColor : {
              linearGradient : [0, 0, 0, 300],
              stops : [
                [0,  'rgba(255, 0, 0, 1)'],
                [1, 'rgba(255,0,0,0.1)']
              ]
            }, */
			data: json[1].data
          }
        ]; 

        interfaces_bytes_day_chart = new Highcharts.Chart(options1);		

		
    }); 
});