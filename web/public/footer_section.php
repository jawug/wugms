<!-- Scripts! -->
<?php
include($page_data->getIncludePath() . '/include_footer.php');
echo PHP_EOL;
switch ($page_name) {
    case "corenetworkdevices":

        echo "<script src='/js/highcharts.js'></script>" . PHP_EOL;
        echo "<!--<script src='/js/modules/exporting.js'></script>-->" . PHP_EOL;
        echo "<!--<script src='/js/modules/no-data-to-display.js'></script>-->" . PHP_EOL;
        echo "<script src='/js/bootstrap-table.min.js'></script>" . PHP_EOL;
        echo "<script src='/js/modules/no-data-to-display.js'></script>" . PHP_EOL;
        echo"<script type='text/javascript'>" . PHP_EOL;
        echo"$(function () {" . PHP_EOL;
        echo"    Highcharts.getOptions().colors = Highcharts.map(Highcharts.getOptions().colors, function (color) {" . PHP_EOL;
        echo"        return {" . PHP_EOL;
        echo"            radialGradient: {" . PHP_EOL;
        echo"                cx: 0.5," . PHP_EOL;
        echo"                cy: 0.3," . PHP_EOL;
        echo"                r: 0.7" . PHP_EOL;
        echo"            }," . PHP_EOL;
        echo"            stops: [" . PHP_EOL;
        echo"                [0, color]," . PHP_EOL;
        echo"                [1, Highcharts.Color(color).brighten(-0.3).get('rgb')] // darken" . PHP_EOL;
        echo"            ]" . PHP_EOL;
        echo"        };" . PHP_EOL;
        echo"    });" . PHP_EOL;
        echo"});" . PHP_EOL;
        echo"</script>" . PHP_EOL;
        echo "<script src='/js/internal/wugms.routerboard_model.public.chart.get.js'></script>" . PHP_EOL;
        echo "<script src='/js/internal/wugms.routerboard_ros.public.chart.get.js'></script>" . PHP_EOL;
        break;
    case "networkstats":
        /* */
        break;
    case "userstats":
        /* */
        break;
    case "wifistats":
        /* */
        break;
    case "contactus":
        echo "<script>
            function reverse(s) {
                if (s.length > 1) {
                    return reverse(s.substr(1)) + s[0];
                } else {
                    return s;
                }
            }
            $(document).ready(function () {
                $('#email1').html(reverse(\"az.gro.guwaj@mocnam\"));
            });
            $(document).ready(function () {
                $('#email2').html(reverse(\"az.gro.guwaj@snimda\"));
            });
        </script>";
        break;
    case "aboutus":
        /* */
        break;
    case "gettingstarted":
        /* */
        break;
    default:
    /* */
}

?>

</body>

</html>
