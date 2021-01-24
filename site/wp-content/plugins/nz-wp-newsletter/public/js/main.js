;
(function ($, window, document, undefined) {

    var pluginName = 'nzwpnewsletter';

    function Plugin(el, options) {

        this.el = el;
        this._name = pluginName;
        this._defaults = $.fn.NzWpNewsletter.defaults;
        this.options = $.extend({}, this._defaults, options);
        this.state = 0;
        this.init();
    }

    $.extend(Plugin.prototype, {
        init: function () {
            this.buildCache();
            this.bindEvents();
        },
        buildCache: function () {
            this.$el = $(this.el);
            this.$forms = this.$el.find('form');
            this.$switch = this.$el.find('.switch');
            this.$validation = this.$el.find('.validation');
        },
        switchForms: function () {
            var $hidden = this.$forms.filter(':hidden');
            var $visible = this.$forms.filter(':visible');
            if (!$hidden.length || !$visible.length) {
                return;
            }
            
            $visible.hide();
            $hidden.show();

        },
        bindEvents: function () {
            var self = this;

            this.$switch.on('click', function () {
                self.switchForms();
            });

            this.$forms.each(function (form) {
                var $form = $(this);

                $form.on('submit' + '.' + self._name, function (e) {
                    e.preventDefault();
                    self.processForm(this);
                });

            });

        },
        processForm: function (form) {
            var $form = $(form);
            var $field = $form.find('input[type=text]');
            var type = $field.attr('name');
            var email = $field.val();
            var self = this;
            if (!IsEmail(email)) {

                this.$validation.html(this.options.invalid_email_msg).delay( 1500 ).hide( 400 );;
            } else {

                var data = {
                    action: 'nzwpnewsletter',
                    security: self.options.security
                };

                data[type] = email;

                $.ajax({
                    url: ajaxurl,
                    type: 'post',
                    dataType: 'json',
                    data: data,
                    success: function (data) {
                        self.handleResponse(data);
                    },
                    error: function (data) {
                        self.handleResponse(data);
                    }
                });

            }
        },
        handleResponse: function (data) {
            if (data.msg) {
                this.$el.replaceWith(data.msg);
            }
        }

    });

    function IsEmail(email) {
        var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        return regex.test(email);
    }

    $.fn.NzWpNewsletter = function (options) {
        this.each(function () {
            if (!$.data(this, "plugin_" + pluginName)) {
                $.data(this, "plugin_" + pluginName, new Plugin(this, options));
            }
        });
        return this;
    };

    $.fn.NzWpNewsletter.defaults = {
        invalid_email_msg: 'Email not valid',
        security: null
    };

})(jQuery, window, document);