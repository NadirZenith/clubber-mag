

//
jQuery(document).ready(function($) {

    $('#upload-image-button').on('click', selectFile);

    function selectFile() {
        console.log('selectFile');

        if (!selectFile.bound) {
            $("#fileUploadInput").on('change', sendForm);
            selectFile.bound = true;
        }
        $('#fileUploadInput').clearFields();
        $('#fileUploadInput').click();

    }

    function sendFile() {
        $("#fileUploadInput").change(function() {
            sendForm();
            /*readURL(this);*/
        });
        $('#fileUploadInput').click();
    }



    function sendForm() {
        var bar = $('.bar');
        /*var percent = $('.percent');*/
        var options = {
            success: showResponse,
            uploadProgress: function(event, position, total, percentComplete) {
                var percentVal = percentComplete + '%';
                bar.width(percentVal);
                /*percent.html(percentVal);*/
            }
        };

        $('#fileUploadForm').ajaxForm(options);
        $('#fileUploadSubmit').click();
    }



    function showResponse(responseText, statusText, xhr, $form) {
        var response = $.parseJSON(responseText);

        console.log('response jsons -> ', response);
        $('#imagePreview').attr('src', response[1].src[0]);
        $('#input_6_4').val(response[1].id);
    }
});
/*------------------------ ------------------------*/
/*------------- NZ DEBUG   ------------------------*/
/*------------------------ ------------------------*/



function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            jQuery('#imagePreview').attr('src', e.target.result);
        };
        reader.readAsDataURL(input.files[0]);
    }
}