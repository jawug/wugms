$(document).ready(function() {
    var options1 = {
        chart: {
            renderTo: 'ap_client_signal',
            type: 'spline',
            zoomType: 'x',
            borderWidth: 0,
            plotBorderWidth: 0
        },
/*        colors: [
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
        ],*/
        title: {
            /*text: 'Client signal reading(s)',*/
			text: '',
            style: {
                color: '#980000'
            }
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
				reversed: true,
                showFirstLabel: false,
                showLastLabel: true,			
            title: {
                text: 'dBm'
            },
            plotLines: [{
                value: 0,
                width: 1,
                color: '#808080'
            }],
/*            floor: 0,*/
            labels: {
                formatter: function() {
                    return this.value
                },
            }
        },
        tooltip: {
            enabled: true,
            shared: true,
            valueSuffix: ' dBm'
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
        url: "/content/snmp_ssid_client_signal_data.php",
        dataType: 'json',
        success: function(data) {
            options1.series = data.data;

            ap_client_signal_snmp_chart = new Highcharts.Chart(options1);
        },
        error: function() {
            options1.series = [{
                "name": "CPU_1",
                "data": []
            }, {
                "name": "CPU_2",
                "data": []
            }];
            ap_client_signal_snmp_chart = new Highcharts.Chart(options1);
        }

    });

});