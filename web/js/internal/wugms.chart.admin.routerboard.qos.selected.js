$(function() {
    var options = {
        chart: {
            type: 'pie',
            options3d: {
                enabled: true,
                alpha: 45
            },
            renderTo: 'sel_rb_qos'
        },
        title: {
            text: ' '
        },
        tooltip: {
            formatter: function() {
                var $row = this.point.name;
                var n = $row.indexOf("__");
                var $flow_name = $row.slice(0, n);
                return '<b>' + $flow_name + '</b>: ' + Highcharts.numberFormat(this.percentage, 2) + ' %'
            }
        },
        credits: {
            enabled: false
        },
        plotOptions: {
            pie: {
                innerSize: 100,
                depth: 45
            },
            series: {
                cursor: 'pointer',
                point: {
                    events: {
                        click: function() {
                            var $row = this.name;
                            n = $row.indexOf("__");
                            //var $sel_ip = $row.slice(1, n);
                            var $sel_flow = $row.slice(0, n);
                            var $sel_ip = $row.substr(n + 2);
                            /*$.getJSON("/content/wugms.chart.user.routerboard.qos.selected.php?sel_ip=" + $sel_ip, function(json) {
                                sel_rb_qos_chart.addSeries(json);
                                sel_rb_qos_chart.redraw();
                            });*/
                            //console.log(this.name);
                            //console.log($sel_ip);
                            //console.log($sel_flow);
                            //sel_rb_sel_ip_flow
                            $('#sel_rb_sel_ip_flow').html("Flow data for: <span style='color: rgb(0, 0, 153);'>" + $sel_ip + " - " + $sel_flow + "</span>");
                                                            while (sel_rb_qos_chart_area.series.length > 0)
                                                                sel_rb_qos_chart_area.series[0].remove(true);
                            $.getJSON("/content/wugms.chart.admin.routerboard.qos.area.php?sel_ip=" + $sel_ip + "&sel_area=" + $sel_flow, function(json) {
								
								/*var series = {
									id: '',
									name: '',
									data: []
									};*/
									
/*									$.each(json, function(itemNo, item) {
										series.data.push(item);
										sel_rb_qos_chart_area.addSeries(series);
									}); */
								for (var i = 0; i < json.length; i++) {
									sel_rb_qos_chart_area.addSeries(json[i]);
////								console.log('ID: ' + i + ' Length: ' + json[i].data.length);
//									for (var j = 0; j < json[i].length; j++){
								//console.log('Array: ' + i);
//										console.log('ID: ' + i + ' Length: ' + json[i].length);
//								console.log(json)
////								series.id = i;
////								console.log('Series ID: ' + series.id);
////								series.name = json[series.id].name;
////								console.log('Series Name: ' + series.name);
////								for (var j = 0; j < json[i].data.length; j++){
								
////								}
//								series.data = json[series.id].data;
								//console.log('Series Data: ' + series.data);
//								sel_rb_qos_chart_area.addSeries(series);
                                /*$.each(json, function(key, data) {
                                    console.log('Array: ' + key)
                                    $.each(data, function(index, data) {
                                        console.log('qwerty', data)
                                    })
                                });*/
								/*$.each(json,function(key,value){
									console.log(json[key].attrib1name);
									console.log(json[key].attrib2name); 
									activities=json[key].activities;
									console.log(value);
									});*/
	//								}
////								}
							/*});  								*/
								//}
									}
							//	sel_rb_qos_chart_area.series = json;
								sel_rb_qos_chart_area.redraw();
                            });
                        }
                    }
                },

                dataLabels: {
                    enabled: true,
                    formatter: function() {
                        var $row = this.point.name;
                        var n = $row.indexOf("__");
                        var $flow_name2 = $row.slice(0, n);
                        return $flow_name2
                    }
                }
            },
            //}
        },
        series: [{}]
    }


    $.getJSON("/content/wugms.chart.admin.routerboard.qos.selected.php", function(json) {
        options.series[0].data = json;
        sel_rb_qos_chart = new Highcharts.Chart(options);
    });

});