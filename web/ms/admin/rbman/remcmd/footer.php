<?php include($_SERVER['DOCUMENT_ROOT'] . '/footreq.php'); ?>
<script src="/js/select2.min.js" type="text/javascript"></script>

<script type="text/javascript">
    $(".inputCMD").select2({
        placeholder: "Select a command",
        allowClear: true,
        theme: "classic"
    });
</script>
<script type="text/javascript">
    $(document).ready(function () {
        $('#inputCMD').on('change', function (event, params) {
            /* Set the heading to show which rb has been selected */
            var selt = $(this).val();
            res = selt.slice(5);
            switch (Number(selt.slice(5))) {
                case 1:
                    //console.log("res");
                    document.getElementById('iphost').style.display = 'none';
                    document.getElementById('usedns').style.display = 'none';
                    break;
                case 2:
                    //console.log("reboot");
                    document.getElementById('iphost').style.display = 'none';
                    document.getElementById('usedns').style.display = 'none';
                    break;
                case 3:
                    //console.log("ping");
                    document.getElementById('iphost').style.display = 'block';
                    document.getElementById('usedns').style.display = 'none';
                    break;
                case 4:
                    //console.log("traceroute");
                    document.getElementById('iphost').style.display = 'block';
                    document.getElementById('usedns').style.display = 'block';
                    break;
                case 5:
                    //console.log("logging");
                    document.getElementById('iphost').style.display = 'none';
                    document.getElementById('usedns').style.display = 'none';
                    break;
                default:
                    console.log("No valid selection made");
            }
        });

        $("button").click(function () {

            //console.log(this.id); // or alert($(this).attr('id'));
            /* Get teh ID of teh button pressed */
            var str = this.id;
            /*console.log($('#inputHost').val());
             console.log($('#inputUser').val());
             console.log($('#inputPassword').val());*/
            $.ajaxSetup({
                error: function (x, e) {
                    if (x.status == 0) {
                        alert('You are offline!!\n Please Check Your Network.');
                    } else if (x.status == 404) {
                        alert('Requested URL not found.');
                    } else if (x.status == 500) {
                        alert('Internel Server Error.');
                    } else if (e == 'parsererror') {
                        alert('Error.\nParsing JSON Request failed.');
                    } else if (e == 'timeout') {
                        alert('Request Time out.');
                    } else {
                        alert('Unknow Error.\n' + x.responseText);
                    }
                }
            });
            /* qwerty */
            $.ajax({
                type: "POST",
                url: "/content/wugms.mikrotik.user.cmd.php",
                data: {rb_host: $('#inputHost').val(),
                    rb_user: $('#inputUser').val(),
                    rb_password: $('#inputPassword').val(),
                    rb_cmd: $('#inputCMD').val(),
                    rb_remadd: $('#inputRemAddress').val(),
                    rb_ud: $('#inputUseDNS').prop('checked')
                },
                success: function (data) {
                    $('#results').html(data);

                },
                error: function (a, b, c) {
                    console.debug(a)
                    $('#results').html('<div class="alert alert-danger" role="alert">.dfdfsdfsdsf..</div>');
                    console.log('no');
                }
            });
        });
    });
</script>

<!-- Custom ajax error -->
<script type="text/javascript">
    $(document).ajaxError(function (event, request, settings) {
        $("#results").append("<li>Error requesting page " + settings.url + "</li>");
    });
</script>
<!-- The Chosen selector for the  -->
<script type="text/javascript">
    $(document).ready(function () {
        $('.chzn-select').each(function () {
            if ($(this).html().trim().length > 0) {
                pimpSelect($(this));
            }
        });

    });

    function pimpSelect(select, options) {
        var prepend = '';
        if (select.attr('data-placeholder')) {
            prepend = '<option></option>';
        }
        if (options) {
            options = prepend + options;
            select.empty().html(options);
        } else {
            select.prepend(prepend);
        }
        if (select.hasClass('chzn-select')) {
            var _width = select.css('width');
            select.chosen({
                width: _width
            });
        }
    }
    ;
</script>

<script type="text/javascript">
    $(document).ready(function () {
        $('.chzn-select-rbcmd').each(function () {
            if ($(this).html().trim().length > 0) {
                pimpSelect($(this));
            }
        });

    });

    function pimpSelect(select, options) {
        var prepend = '';
        if (select.attr('data-placeholder')) {
            prepend = '<option></option>';
        }
        if (options) {
            options = prepend + options;
            select.empty().html(options);
        } else {
            select.prepend(prepend);
        }
        if (select.hasClass('chzn-select-rbcmd')) {
            var _width = select.css('width');
            select.chosen({
                width: _width
            });
        }
    }
    ;
</script>
</body>
</html>
