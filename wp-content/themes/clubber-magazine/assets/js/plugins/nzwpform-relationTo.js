// ---------------------------------
// ---------- Plugin Name ----------
// ---------------------------------
// Brief plugin description
// ------------------------

;
(function($, window, document, undefined) {


      var pluginName = 'nzwpform_relationTo';

      function Plugin(element, options) {

            this.element = element;
            this._name = pluginName;
            this._defaults = $.fn.nzwpform_relationTo.defaults;

            this.options = $.extend({}, this._defaults, options);

            this.init();
      }

      $.extend(Plugin.prototype, {
            init: function() {

                  this.buildCache();
                  this.bindEvents();
            },
            // Cache DOM nodes for performance
            buildCache: function() {

                  this.$element = $(this.element);
                  this.$row = this.$element.parent();
                  this.$select2 = this.$row.children('.select2');
                  console.log(this.$select2);
                  this.$add_new = $(this.options.tpl.add).attr({
                        href: '#link'
                  }).html(this.options.addText);

                  this.$select2.after(this.$add_new);

            },
            // Bind events that trigger methods
            bindEvents: function() {
                  var plugin = this;

                  plugin.$element.select2({
                        //placeholder: "Select a cool-place",
                        minimumInputLength: 1,
                        allowClear: true,
                        selectOnBlur: true,
                        ajax: {
                              url: ajaxurl,
                              dataType: 'json',
                              quietMillis: 250,
                              cache: true,
                              data: function(params) {
                                    return {
                                          action: 'get_posts',
                                          post_type: plugin.$element.data('to'),
                                          q: params.term
                                    };
                              },
                              processResults: function(data, page) {
                                    return {results: data.items};
                              }
                        },
                        templateSelection: plugin.templateSelection,
                        templateResult: plugin.templateResult,
                        dropdownCssClass: "bigdrop", // apply css that makes the dropdown taller
                        escapeMarkup: function(m) {
                              return m;
                        } // we do not want to escape markup since we are displaying html in results
                  });
            },
            // Create custom methods
            templateSelection: function(post) {
                  return post.text || post.title;

            },
            templateResult: function(post) {
                  if (post.loading)
                        return post.text;

                  var markup = '<div class="cb group">' +
                          '<div class="col-1-4 fl featured-image">' + post.img + '</div>' +
                          '<div class="col-3-4 fl">' +
                          '<div class="ml5">' +
                          '<div class="bold">' + post.title + '</div>';
                  if (post.meta.address) {
                        markup += '<span style="font-size:11px;line-height: 0px;;">' + post.meta.address + '</span>';
                  } else {
                        console.log('no address');
                  }
                  '</div>' +
                          '</div>';
                  return markup;

            },
            callback: function() {
                  // Cache onComplete option
                  var onComplete = this.options.onComplete;

                  if (typeof onComplete === 'function') {

                        onComplete.call(this.element);
                  }
            },
            // Unbind events that trigger methods
            unbindEvents: function() {

                  this.$element.off('.' + this._name);
            },
            // Remove plugin instance completely
            destroy: function() {

                  this.unbindEvents();
                  this.$element.removeData();
            },
      });


      $.fn.nzwpform_relationTo = function(options) {
            this.each(function() {
                  if (!$.data(this, "plugin_" + pluginName)) {

                        $.data(this, "plugin_" + pluginName, new Plugin(this, options));
                  }
            });

            return this;
      };

      $.fn.nzwpform_relationTo.defaults = {
            property: 'value',
            onComplete: null,
            addText: 'new',
            tpl: {
                  add: '<a class="nz-addrelation">add</a>',
            }
      };

})(jQuery, window, document);