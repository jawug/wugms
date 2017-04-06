$(document).ready(function() {
    var options1 = {
        chart: {
            renderTo: 'cpu_load',
            type: 'spline',
            zoomType: 'x',
//            marginBottom: 25,
            borderWidth: 0,
//            borderColor: '#C0C0C0'
            plotBorderWidth: 0
//			plotBorderColor: '#C0C0C0'
        },
     //   colors: ['#7cb5ec'],
		colors: [
		'#008080',
//		'#7cb5ec' -- light blue
//		'#434348'  -- Dark grey
//		'#90ed7d'  -- Light green
//		'#f7a35c'  -- light orange
//		'#8085e9'  -- Light purple
//		'#8085e9'  -- Light purple
//		'#f15c80'  -- light red/pink
//		'#e4d354'  -- light yellow
//		'#8085e8'  -- med purple
		'#FF6600'  
//		-- dark red
//		'#91e8e1'  -- light blue/green
		],		
        title: {
            text: 'CPU reading(s)',
			style: {
			color: '#980000'}
//            x: -20 
        },
        credits: {
            enabled: false
        },
        subtitle: {
            text: ''
        },
        xAxis: {
            type: 'datetime',
			gridLineWidth: 1,
			minorGridLineWidth: 1,
            minRange: 1 * 600000
        },
        yAxis: {
            title: {
                text: '%'
            },
            plotLines: [{
                value: 0,
                width: 1,
                color: '#808080'
            }],
            floor: 0,
            labels: {
                formatter: function() {
                    return this.value
                },
            }
        },
        tooltip: {
            enabled: true,
            shared: true,
			valueSuffix: ' %'
        },
        legend: {
            enabled: false
        },
        plotOptions: {
            spline: {
/*                fillColor: {
                    linearGradient: {
                        x1: 0,
                        y1: 0,
                        x2: 0,
                        y2: 1
                    },
                    stops: [
                        [0, '#7cb5ec'],
                        [1, 'rgba(124, 181, 236, 0.1)']
                    ]
                },*/
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


	$.ajax({
		url: "/content/snmp_cpu_data.php",
		dataType: 'json',
		success: function(data){
//			console.log('yes');
//			console.log(data.data);
			options1.series = data.data;

			cpu_snmp_chart = new Highcharts.Chart(options1);
		},
		error: function(){
//			console.log('no');
			options1.series = [{"name" : "CPU_1","data" : []}, {"name" : "CPU_2","data" : []}];
			cpu_snmp_chart = new Highcharts.Chart(options1);
		}
		
});
	
	/*
    $.getJSON("/content/snmp_cpu_data.php", function(json) {
		console.log(json.data);
        options1.series = json.data;
        cpu_snmp_chart = new Highcharts.Chart(options1);
    }); 
	*/
});