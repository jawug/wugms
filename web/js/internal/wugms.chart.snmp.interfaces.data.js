$(document).ready(function() {
    var options3 = {
        chart: {
            renderTo: 'interface_data',
            type: 'spline',
            zoomType: 'x',
            borderWidth: 0,
            plotBorderWidth: 0
        },
		colors: ['#00ff00','#ff0000'],
        title: {
            text: '',
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
                text: 'Data Transferred (MB)'
            },
//			floor: 0,
            labels: {
                formatter: function() {
                    return this.value / 1000000;
                },
            }
        },
        tooltip: {
			enabled: true,
			shared: true,
			valueSuffix: ' Bytes'
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
		url: "/content/snmp_interface_data.php?dtype=data",
		dataType: 'json',
		success: function(data){
//			console.log('yes');
			var series0 = data.data[0].data;
			var series1 = data.data[1].data;

		options3.series = [{type: 'areaspline',
				name: 'Tx',
                color: '#00fa00',
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
                        [0, '#00fa00'],
                        [1, 'rgba(0, 250, 0, 0.1)']
                    ]
                },
				data: series0
            }, {
                type: 'spline',
				name: 'Rx',
                color: '#0000fa',
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
			interfaces_data_snmp_chart = new Highcharts.Chart(options3);	
		},
		error: function(){
//			console.log('no');
			options3.series = [{"name" : "Tx","data" : []}, {"name" : "Rx","data" : []}];
			interfaces_data_snmp_chart = new Highcharts.Chart(options3);				
		}
		
});

});