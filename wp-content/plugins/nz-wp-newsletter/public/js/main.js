// ---------------------------------
// ---------- Plugin Name ----------
// ---------------------------------
// Brief plugin description
// ------------------------
;
(function ($, window, document, undefined) {

    var pluginName = 'nzwpnewsletter';

    function Plugin(element, options) {

        this.element = element;
        this._name = pluginName;
        this._defaults = $.fn.NzWpNewsletter.defaults;
        this.options = $.extend({}, this._defaults, options);

        this.init();
    }

    $.extend(Plugin.prototype, {
        init: function () {
            this.buildCache();
            this.bindEvents();
        },
        buildCache: function () {
            this.$element = $(this.element);
        },
        bindEvents: function () {
            var plugin = this;

            plugin.$element.on('submit' + '.' + plugin._name, function (e) {
                e.preventDefault();
                console.log(this);
                console.log(plugin);

                var email = plugin.$element.find('input[name = email]').val();
                if (IsEmail(email)) {
                    console.log('submit', plugin.options.security);
                    $.ajax({
                        url: ajaxurl,
                        type: 'post',
                        dataType: 'json',
                        data: {
                            action: 'nzwpnewsletter',
                            email: email,
                            security: plugin.options.security

                        },
                        success: function (data) {
                            plugin.handleResponse(data);
                        },
                        error: function (data) {
                            plugin.handleResponse(data);
                        }
                    });
                } else {
                    plugin.$element.find('.validation').html(plugin.options.invalid_email_msg);
                    console.log('mail not valid');
                }

            });
        },
        handleResponse: function (data) {
            if (data.msg) {
                this.$element.find('.validation').html(data.msg);
                /*this.$element.replaceWith(data.msg);*/
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