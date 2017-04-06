$(function () {
	var options = {
		chart : {
			renderTo : 'wifi_58GHz',
			plotBackgroundColor : null,
			plotBorderWidth : null,
			plotShadow : false
		},
		title : {
			text : '5.8GHz Frequency usage'
		},
		tooltip : {
			formatter : function () {
				return '<b>' + this.point.name + '</b>: ' + this.point.y + ' AP(s) ';
/*				return '<b>' + this.point.name + '</b>: ' + this.point.y + ' AP(s) '; */
			}
		},
		credits : {
			enabled : false
		},
		plotOptions : {
			pie : {
				allowPointSelect : true,
				cursor : 'pointer',
				dataLabels : {
					enabled : true,
					color : '#000000',
					connectorColor : '#000000',
					formatter : function () {
						return '<b>' + this.point.name + '</b>: ' ;
						/*return '<b>' + this.point.name + '</b>: ' + this.point.y + '  '; */
					}
				}
			},
            series: {
                cursor: 'pointer',
                point: {
                    events: {
                        click: function () {
                        /*theWifiTable.fnReloadAjax( '/content/wugms.table.wifi.php?param=' + this.name );*/
						$('#wifi_table').bootstrapTable('refresh',{url: '/content/wugms.table.wifi.php?param=' + this.name});
                        }
                    }
                }
            }
        },
		series : [{
				type : 'pie',
				name : 'Browser share',
				data : [
				]
			}
		]
	}

	$.getJSON("/content/wugms.chart.wifi.58ghz.php", function (json) {
		options.series[0].data = json;
		chart = new Highcharts.Chart(options);
	});

});
