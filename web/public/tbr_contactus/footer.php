<?php include($_SERVER['DOCUMENT_ROOT'] . '/footreq.php'); ?>
<!-- Section one -->

<script>
    function reverse(s) {
        if (s.length > 1) {
            return reverse(s.substr(1)) + s[0];
        } else {
            return s;
        }
    }
    $(document).ready(function () {
        $('#email1').html(reverse("az.gro.guwaj@mocnam"));
    });
    $(document).ready(function () {
        $('#email2').html(reverse("az.gro.guwaj@snimda"));
    });
</script>

</body>
</html>
