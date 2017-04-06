$(document).ready(function() {
    var options1 = {
        chart: {
            renderTo: 'rb_storage_devices',
            type: 'spline',
            zoomType: 'x',
//            marginBottom: 25,
            borderWidth: 0,
            borderColor: '#C0C0C0',
            plotBorderWidth: 0,
			plotBorderColor: '#C0C0C0'
        },
		colors: [
//		'#7cb5ec'
//		'#7cb5ec' -- light blue
//		'#434348'  -- Dark grey
//		'#90ed7d'  -- Light green
		'#f7a35c',
//		-- light orange
		'#8085e9',
//  -- Light purple
//		'#8085e9'  -- Light purple
//		'#f15c80'  -- light red/pink
//		'#e4d354'  -- light yellow
//		'#8085e8'  -- med purple
		'#8d4653'
//		-- dark red
//		'#91e8e1'  -- light blue/green
		],		
        title: {
            text: 'Storage device(s)',
			style: {
			color: '#000098'}
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
            minRange: 1 * 600000
        },
        yAxis: {
            title: {
                text: 'Free (%)'
            },
            min: 0
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
                marker: {
                    radius: 1
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
		url: "/content/snmp_storage_data.php",
		dataType: 'json',
		success: function(data){
//			console.log('yes');
//			console.log(data.data);
			options1.series = data.data;
			storage_snmp_chart = new Highcharts.Chart(options1);
		},
		error: function(){
//			console.log('no');
			options1.series = [{"name" : "Storage 1","data" : []}, {"name" : "Storage 2","data" : []}];
			storage_snmp_chart = new Highcharts.Chart(options1);
		}
		
});		
	
/*    $.getJSON("/content/snmp_storage_data.php", function(json) {
        options1.series = json.data; */
        
//    });
});