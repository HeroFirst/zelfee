$(document).ready(function() {
    $('.zf-toggle input[type=checkbox]').change(function() {
        var checked = $(this).is(":checked");

        if (checked){
            $('.nav-tabs a[href="#recent"]').tab('show')
        } else {
            $('.nav-tabs a[href="#now"]').tab('show')
        }
    });
});