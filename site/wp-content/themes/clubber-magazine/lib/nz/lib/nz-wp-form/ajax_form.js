$(document).ready(function() {

      $('#@form_name').ajaxForm({
            dataType: 'json',
            beforeSubmit: function(formData, jqForm, options) {


                  /*
                   * 
                   console.log('beforeSubmit', jqForm);
                   
                   var $zf = $('#@form_name').data('Zebra_Form');
                   
                   console.log('zebra', $zf);
                   
                   console.log('validate', $zf.validate());
                   return false;
                   */

            },
            success: function(response, statusText, xhr, $form) {
                  console.log('response', response);
                  if (response.success) {
                        if ('redirectTo' in response.data) {
                              document.location.replace(response.data.redirectTo);
                        } else if ('confirmations' in response.data) {
                              var full = response.data.confirmations.join();
                              var wrapper = $('<div></div>').attr({class: 'nzwpform-confirmation'});
                              wrapper.html(full);
                              $form.replaceWith(wrapper);
                        }
                  } else {
                        $('#nzwp-form-@form_name').replaceWith(response.data.error_form);
                  }

            }
      });
});
