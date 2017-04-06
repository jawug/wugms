var config = {
    '.chosen-select': {},
    '.chosen-select-deselect': {allow_single_deselect: true},
    '.chosen-select-no-single': {disable_search_threshold: 10},
    '.chosen-select-no-results': {no_results_text: 'Oops, nothing found!'},
    '.chosen-select-width': {width: "95%"}
}
for (var selector in config) {
    $(selector).chosen(config[selector]);
}


$(function () {
    var rb_select = '';

    $("#router_select").chosen().change(function () {
        // $('#selection').html("qwerty"); 
        $rb_select = $(this).val();
        $('#selection').html();
        console.log($rb_select);
        $.post("/content/rb_sel.php?sn=".$rb_select, $rb_select);
//		localStorage['rb_selected'] = $(this).val();
//		$_SESSION['amyusername'] = "$amyusername";
//		console.log($rb_selected);
    });
});