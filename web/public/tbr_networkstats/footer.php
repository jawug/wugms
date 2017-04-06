<?php include($_SERVER['DOCUMENT_ROOT'] . '/footreq.php'); ?>
<script src="/js/highcharts.js"></script>
<!--<script src="/js/highcharts-3d.js"></script>-->
<script src="/js/modules/no-data-to-display.js"></script>
<script src="/js/wugms.chart.routerboard.qos.js"></script>
<script>
    $(function () {
        Highcharts.getOptions().colors = Highcharts.map(Highcharts.getOptions().colors, function (color) {
            return {
                radialGradient: {
                    cx: 0.5,
                    cy: 0.3,
                    r: 0.7
                },
                stops: [
                    [0, color],
                    [1, Highcharts.Color(color).brighten(-0.3).get('rgb')]
                ]
            };
        });
    });
</script>
</body>
</html>