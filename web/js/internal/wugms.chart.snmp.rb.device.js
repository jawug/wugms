$(document).ready(function() {
    var options3 = {
        chart: {
            renderTo: 'dev_readings',
            type: 'spline',
			zoomType: 'x',
//            marginBottom: 25,
            borderWidth: 0,
            borderColor: '#C0C0C0',
            plotBorderWidth: 0,
			plotBorderColor: '#C0C0C0'
        },
		colors: [
				'#105D9A', // something
		'#FB0000', // electrical

		'#B9B900'
//		'#7cb5ec'
//		'#7cb5ec' -- light blue
//		'#434348',
//		-- Dark grey
//		'#90ed7d'  -- Light green
//		'#f7a35c'		-- light orange
//		'#8085e9'     -- Light purple
//		'#8085e9'  -- Light purple
//		'#f15c80',
//		-- light red/pink
//		'#e4d354'  -- light yellow
//		'#8085e8'
//		-- med purple
//		'#8d4653'		-- dark red
//		'#91e8e1'  -- light blue/green
		],
        title: {
            text: 'Device sensor reading(s)',
			style: {
			color: '#009800'}
        },
        credits: {
            enabled: false
        },
        subtitle: {
            text: ''
        },
        xAxis: {
			type: 'datetime',
            minRange: 1 * 600000
        },
/*        yAxis: {
            title: {
                text: 'Reading(s)'
            },
			floor: 0,
            labels: {
                formatter: function() {
                    return this.value
                },
            }
        }, */
        yAxis: [{ 
            gridLineWidth: 0,
            title: {
                text: 'Current'
/*                style: {
                    color: Highcharts.getOptions().colors[0]
                }*/
            },
            labels: {
                format: '{value} mA'
/*                style: {
                    color: Highcharts.getOptions().colors[0]
                } */
            }
        },{ 
            gridLineWidth: 0,
            title: {
                text: 'Temperature'
/*                style: {
                    color: Highcharts.getOptions().colors[1]
                }*/
            },
            labels: {
                format: '{value}°C'
/*                style: {
                    color: Highcharts.getOptions().colors[1]
                }*/
            },
            opposite: true
        }, { 
            gridLineWidth: 0,
            title: {
                text: 'Voltage'
/*                style: {
                    color: Highcharts.getOptions().colors[3]
                }*/
            },
            labels: {
                format: '{value} VDC'
/*                style: {
                    color: Highcharts.getOptions().colors[3]
                }*/
            },
            opposite: true

        }],		
        tooltip: {
			crosshairs: false,
                shared: true
//				valueSuffix: ' DC'
        },
		legend: {
			enabled: false
		},
        plotOptions: {
            spline: {
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
/*		series: [{
			tooltip: {
                    valueSuffix: ' A'
                }
    
            }, {
                tooltip: {
                    valueSuffix: '°C'
                }
            }, {
                tooltip: {
                    valueSuffix: 'VDC'
                }
            }] */		
    }


	$.ajax({
		url: "/content/snmp_device_data.php",
		dataType: 'json',
		success: function(data){
//			console.log('yes');
//			console.log(data.data);
//        options3.series = data.data;
        options3.series = [{
            name : data.data[0].name,
            type : "spline",
			tooltip: {
                    valueSuffix: ' mA'
                },			
			data: data.data[0].data
          }, {
            name : data.data[1].name,
            type : "spline",
                tooltip: {
                    valueSuffix: ' °C'
                },
			data: data.data[1].data
          }, {
            name : data.data[2].name,
            type : "spline",
                tooltip: {
                    valueSuffix: ' VDC'
                },
			data: data.data[2].data
          }];
		  device_snmp_chart = new Highcharts.Chart(options3);
		  
		},
		error: function(){
//			console.log('no');
			options3.series = [{"name" : "a","data" : []}, {"name" : "b","data" : []}, {"name" : "c","data" : []}];
			device_snmp_chart = new Highcharts.Chart(options3);
		}
		
});	
	device_snmp_chart = new Highcharts.Chart(options3);

	/*
    $.getJSON("/content/snmp_device_data.php", function(json) {
        options3.series = json.data;
        options3.series = [{
            name : json.data[0].name,
            type : "spline",
			tooltip: {
                    valueSuffix: ' mA'
                },			
			data: json.data[0].data
          }, {
            name : json.data[1].name,
            type : "spline",
                tooltip: {
                    valueSuffix: ' °C'
                },
			data: json.data[1].data
          }, {
            name : json.data[2].name,
            type : "spline",
                tooltip: {
                    valueSuffix: ' VDC'
                },
			data: json.data[2].data
          }]; 		
        device_snmp_chart = new Highcharts.Chart(options3);
    }); */
});