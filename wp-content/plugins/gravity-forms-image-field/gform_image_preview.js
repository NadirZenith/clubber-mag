jQuery(document).ready(function($) {
    var nz_gform_image_preview_id, nz_gform_image_preview_type;
    $('.gform_wrapper').on('click', '.nz-upload-button', selectFile);

    function selectFile(e) {
        if (!selectFile.form) {
            createForm();
            $("#fileUploadInput").on('change', sendForm);
            selectFile.form = true;
        }
        nz_gform_image_preview_id = e.target.id.replace('-button', '');
        nz_gform_image_preview_type = $(e.target).data('type');
        switch (nz_gform_image_preview_type) {
            case 'multiple':
                $("#fileUploadInput").attr('multiple', 'true');
                break;

            default:
                $("#fileUploadInput").removeAttr('multiple');

        }
        $("#fileUploadInput").click();
    }

    function createForm() {
        var $form = $('<form>', {
            'action': ajaxurl,
            'method': 'POST',
            'id': 'fileUploadForm',
            'enctype': 'multipart/form-data'
        }).append($('<input>', {//wp ajax action
            'type': 'text',
            'name': 'action',
            'value': 'nz_gform_image_upload'
        })).append($('<input>', {//input for files
            'type': 'file',
            'name': 'files[]',
            'accept': 'image/*',
            'id': 'fileUploadInput'
        })).append($('<input>', {
            'type': 'submit',
            'id': 'fileUploadSubmit',
            'value': 'submit'
        }));

        var $formContainer = $('<div></div>', {css: {'display': 'none'}}).appendTo('body');
        $formContainer.append($form);

    }

    function sendForm() {
        var bar = $('#preview-' + nz_gform_image_preview_id + ' .bar');
        /*var percent = $('.percent');*/
        var options = {
            success: showResponse,
            uploadProgress: function(event, position, total, percentComplete) {
                var percentVal = percentComplete + '%';
                console.log(percentVal);
                bar.width(percentVal);
                /*percent.html(percentVal);*/
            }
        };

        $('#fileUploadForm').ajaxForm(options);
        $('#fileUploadSubmit').click();
    }

    function showResponse(responseText, statusText, xhr, $form) {
        $('#' + nz_gform_image_preview_id).val(responseText);
        
        var response = $.parseJSON(responseText);
        switch (nz_gform_image_preview_type) {
            case 'multiple':
                preview_container = $('#preview-' + nz_gform_image_preview_id);
                console.log(response);
                $.each(response, function(index, value) {
                    console.log(index);
                    console.log(value);
                    $('<img/>', {'src': value.src}).appendTo(preview_container);
                });

                break;

            default:
                $('#nz-gform-image-preview-' + nz_gform_image_preview_id).attr('src', response[1].src);

        }
    }

});