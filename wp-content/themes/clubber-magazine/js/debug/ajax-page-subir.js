
jQuery(function($) {
    $('#ajax-test').on('click', nz_debug_ajax);

    function nz_debug_ajax() {
        $.post(ajaxurl, nz_send_debug_data(), function(data) {
            /*console.log(data);*/
            nz_log(data, '.panel-1');
            /*$('#nz-debug-output .panel-1').html(data); // alerts 'ajax submitted'*/
        });
    }

    function nz_send_debug_data() {
        return {action: 'nz_debug', field: 2, nz_token: 'tino'};
    }



    function nz_log(content, panel) {
        if ($('#nz-output-keep').prop('checked')) {
            $("#nz-debug-output .panel-1").append(content);
        } else {

            $("#nz-debug-output .panel-1").html(content);
        }

        $("#nz-debug-output .panel-1").scrollTop($("#nz-debug-output .panel-1")[0].scrollHeight);

    }

});

