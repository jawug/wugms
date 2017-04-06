$(document).ready(function() {
    var options2 = {
        chart: {
            renderTo: 'interface_packets',
            type: 'spline',
            zoomType: 'x',
            borderWidth: 0,
            plotBorderWidth: 0
        },
		colors: ['#00ff00','#ff0000'],
        title: {
            text: ' ',
            x: -20 //center
        },
        credits: {
            enabled: false
        },
        subtitle: {
            text: '',
            x: -20
        },
        xAxis: {
			type: 'datetime',
            minRange: 1 * 3600000
        },
        yAxis: {
            title: {
                text: 'Packets per second'
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
			valueSuffix: ' Pps'
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
	
	
	$.ajax({
		url: "/content/snmp_interface_data.php?dtype=packet",
		dataType: 'json',
		success: function(data){
            //			console.log('yes');
            //options1.series = data.data;
			var series0 = data.data[0].data;
			var series1 = data.data[1].data;

		options2.series = [{type: 'areaspline',
				name: 'Tx',
                color: '#007f00',
				marker: {
                    enabled: false,
                    states: {
                        hover: {
                            enabled: true,
                            radius: 1
                        }
                    }
                },
                gapSize: 1,
                lineWidth: 1,
                states: {
                    hover: {
                        lineWidth: 1
                    }
                },
                fillColor: {
                    linearGradient: {
                        x1: 0,
                        y1: 0,
                        x2: 0,
                        y2: 1
                    },
                    stops: [
                        [0, '#007f00'],
                        [1, 'rgba(0, 127, 0, 0.1)']
                    ]
                },
				data: series0
            }, {
                type: 'spline',
				name: 'Rx',
                color: '#00007f',
				marker: {
                    enabled: false,
                    states: {
                        hover: {
                            enabled: true,
                            radius: 1
                        }
                    }
                },
                gapSize: 1,
                lineWidth: 1,
                states: {
                    hover: {
                        lineWidth: 1
                    }
                },
				data: series1
            }];		
			

			interfaces_packets_snmp_chart = new Highcharts.Chart(options2);	
		},
		error: function(){
//			console.log('no');
			options2.series = [{"name" : "Tx","data" : []}, {"name" : "Rx","data" : []}];
			interfaces_packets_snmp_chart = new Highcharts.Chart(options2);				
		}
		
});

});