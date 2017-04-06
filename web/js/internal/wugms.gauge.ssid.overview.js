$(document).ready(function() {
    var ssid_ov_txccq_guage_options = {
        chart: {
            renderTo: 'ssid_oa_txccq',
            type: 'solidgauge'
/*            marginBottom: 25*/
        },
        title: null,		
        pane: {
            center: ['50%', '85%'],
            size: '140%',
            startAngle: -90,
            endAngle: 90,
            background: {
                backgroundColor: (Highcharts.theme && Highcharts.theme.background2) || '#EEE', 
                innerRadius: '60%',
                outerRadius: '100%',
                shape: 'arc'
            }
        },
        tooltip: {
            enabled: false
        },
        credits: {
            enabled: false
        },
        // the value axis
        yAxis: {
            stops: [
                [0.1, '#DF5353'], // red
                [0.5, '#DDDF0D'], // yellow
                [0.9, '#55BF3B']  // green
            ],
            lineWidth: 0,
            minorTickInterval: null,
            tickPixelInterval: 400,
            tickWidth: 0,
            title: {
                y: -80
            },
            labels: {
                y: 16
            },
			min: 0,
            max: 100
/*            title: {
                text: 'TX CCQ %'
            } */
        },
        plotOptions: {
            solidgauge: {
                dataLabels: {
                    y: 5,
                    borderWidth: 0,
                    useHTML: true
                }
            }
        },
		series: []
}


$.getJSON("/content/wugms.guage.ssid.main.ccq.php", function(json) {
    ssid_ov_txccq_guage_options.series = json;
    ssid_ov_txccq_guage = new Highcharts.Chart(ssid_ov_txccq_guage_options);


});

});