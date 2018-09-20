$(function () {
    var options = {
        chart: {
            type: 'area',
            renderTo: 'chart_network_stats'
        },
        title: {
            text: 'QoS traffic data for the last 24 hours'
        },
        /*		tooltip : {
         formatter : function () {
         return'<b>'+ this.point.name +'</b>: '+ Highcharts.numberFormat(this.percentage, 2) +' %'
         }
         },*/
        tooltip: {
            pointFormat: '<span style="color:{series.color}">{series.name}</span>: <b>{point.percentage:.1f}%</b> ({point.y:,.0f} bytes)<br/>',
            shared: true
        },
        credits: {
            enabled: false
        },
        xAxis: {
            type: 'datetime',
            minRange: 24 * 3600000,
            tickmarkPlacement: 'on',
            title: {
                enabled: false
            }
        },
        plotOptions: {
            area: {
                stacking: 'percent',
                lineColor: '#ffffff',
                lineWidth: 1,
                marker: {
                    lineWidth: 1,
                    lineColor: '#ffffff'
                }
            }
        },
        series: [{}]

    };



    $.getJSON("/public/content/wugms.network_stats.public.chart.get.php", function (json) {
        options.series = json.data;
        chart = new Highcharts.Chart(options);
    });

});
