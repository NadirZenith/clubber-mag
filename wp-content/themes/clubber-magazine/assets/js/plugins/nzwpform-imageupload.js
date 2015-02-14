/**
 * image upload class
 */
(function($, window, document, undefined) {

      var pluginName = "nzwpform_imageupload";
      var defaults = {
            uploadContainerClass: "nzwpform-upload-container",
            previewContainerClass: "preview-container",
            proxyButtonValue: "Subir Photo",
      };
      /*      
       var ajaxForm = {
       action: window.ajaxurl,
       wpaction: "nzwpform_image_upload",
       };
       * */
      var field = {
            $current: null,
            previewImageClass: "nzwpform_preview",
      };
      var loadings = [];
      // The actual plugin constructor
      function Plug(element, options) {
            this.$el = $(element);
            this.options = $.extend({}, defaults, options);
            this.init();
      }
      ;
      Plug.prototype = {
            init: function() {
                  var self = this;
                  var $form_row = this.$el.parent();
                  var $container = $('<div></div>').attr('class', this.options.uploadContainerClass);
                  var $img_container = $('<div></div>').attr('class', this.options.previewContainerClass);
                  var $proxy_button = $('<input class="proxy-button" type="button">').attr('value', this.options.proxyButtonValue);
                  var $loading = $('<div class="loading" style="height:5px;"></div>');
                  /*var $loading = $('<div class="loading x" style="height:5px;"><span>50%</span></div>');*/

                  /*var img_data = $.parseJSON(this.$el.val());*/

                  /*console.log(this.$el.data('preview'));*/
                  /*return;*/
                  var img_src = (this.$el.val() != '') ? this.$el.val() : this.$el.data('placeholder');
                  $('<img >').attr({
                        /*src: this.$el.val(),*/
                        src: img_src,
                        class: field.previewImageClass,
                        id: this.$el.attr('id') + '_preview'
                  }).appendTo($img_container);
                  $container.append($img_container, $loading, $proxy_button);
                  $form_row.append($container);
                  $proxy_button.on('click', function(e) {
                        e.preventDefault;
                        field.$current = $(e.target).parent();
                        var id = field.$current.parent().children('input[type="text"]').attr('id');
                        var $fileinput = self.getInput(id);
                        $fileinput.click();
                  });
            },
            beforeSubmit: function(arr, $form, options) {
                  var id = $form.attr('id').replace('_ajax_upload_form', '');
                  var $loading = $("#" + id).parent().find('.loading');
                  loadings[id] = setInterval(function() {
                        $loading.toggleClass("x");
                  }, 100);
                  return true;
            },
            uploadProgress: function($form, percentComplete) {
                  var id = $form.attr('id').replace('_ajax_upload_form', '');
                  var $loading = $("#" + id).parent().find('.loading');
                  var $percent = (percentComplete == 100) ? '' : $("<span>" + percentComplete + "%</span>");
                  $loading.html($percent);
            },
            getForm: function(id) {
                  var form_id = id + "_ajax_upload_form";
                  var $form = $("#" + form_id);
                  if ($form.length > 0) {
                        return $form;
                  }

                  var $formContainer, $form,
                          self = this,
                          formOptions = {
                                data: {
                                      /*action: ajaxForm.wpaction*/
                                      action: "nzwpform_image_upload"
                                              /*wpaction: "nzwpform_image_upload"*/
                                },
                                beforeSubmit: function(arr, $form, options) {
                                      console.log($form);
                                      self.beforeSubmit(arr, $form, options);
                                      /*return true;*/
                                },
                                success: function(response, statusText, xhr, $form) {
                                      self.success(response, statusText, xhr, $form);
                                },
                                uploadProgress: function(event, position, total, percentComplete) {
                                      self.uploadProgress($form, percentComplete);
                                }
                          };
                  $formContainer = $('<div></div>', {
                        css: {
                              position: 'absolute',
                              top: '-500px',
                              /*right: '0',*/
                              /*backgroundColor: '#fff'*/
                        }
                  }).appendTo('body');
                  $form = $('<form>', {
                        action: window.ajaxurl,
                        /*wpaction: "nzwpform_image_upload",*/
                        method: 'POST',
                        id: form_id,
                        enctype: 'multipart/form-data'
                  });
                  $form.ajaxForm(formOptions);
                  $formContainer.append($form);
                  return $form;
            },
            success: function(response, statusText, xhr, $form) {
                  var id = $form.attr('id').replace('_ajax_upload_form', '');
                  var $input = $("#" + id);
                  $input.val(JSON.stringify(response));
                  $input.val(response);
                  var $imgprev = $input.parent().find('img');
                  /*$imgprev.attr('src', response[1].src).css('opacity', 1);*/
                  $imgprev.attr('src', response).css('opacity', 1);
                  /*                                                      
                   $imgprev.attr('src', response[1].src).delay(300).one('load', function() {
                   $imgprev.css('opacity', 1);
                   
                   });
                   */
                  //loading finish
                  var $loading = $("#" + id).parent().find('.loading');
                  window.clearInterval(loadings[id]);
                  $loading.addClass("x").delay(1000).animate({opacity: 0}, 1000, function() {
                        $loading.removeClass("x").css("opacity", "").html('');
                  });
            },
            /**
             *    handler for file input change
             *    @param dom object
             */
            readFileInput: function(input) {
                  var id = $(input).attr('id').replace('_ajax_upload_input', '');
                  if (input.files && input.files[0]) {
                        var $input = $("#" + id);
                        var $imgprev = $input.parent().find('img');
                        try {
                              var reader = new FileReader();
                              reader.onload = function(e) {
                                    $imgprev.attr('src', e.target.result).css('opacity', 0.5);
                              }
                              reader.readAsDataURL(input.files[0]);
                        } catch (e) {
                              console.log(e.message);
                        }
                  }
                  var $form = $("#" + id + '_ajax_upload_form');
                  $form.submit();
            },
            getInput: function(id) {
                  var input_id = id + "_ajax_upload_input", self = this;
                  var $fileinput = $("#" + input_id);
                  if ($fileinput.length > 0) {
                        return $fileinput;
                  }

                  $fileinput = $('<input>', {
                        type: 'file',
                        name: 'files[]',
                        accept: 'image/*',
                        id: input_id
                  });
                  $fileinput.on('change', function() {
                        self.readFileInput(this);
                  });
                  var $form = this.getForm(id);
                  $form.append($fileinput);
                  return $fileinput;
            }
      };
      // A really lightweight plugin wrapper around the constructor,
      // preventing against multiple instantiations
      $.fn[pluginName] = function(options) {
            return this.each(function() {
                  if (!$.data(this, "plugin_" + pluginName)) {
                        $.data(this, "plugin_" + pluginName,
                                new Plug(this, options));
                  }
            });
      }

})(jQuery, window, document);