
// ---------------------------------
// ---------- SlideU ----------
// ---------------------------------
// Show rest of lines in absolute positioned element
// ------------------------
        ;
        (function ($, window, document, undefined) {

            var pluginName = 'slideU';

            function SlideU(el, options) {
                this.el = el;
                this._name = pluginName;
                this._defaults = $.fn.slideU.defaults;
                this.options = $.extend({}, this._defaults, options);

                this.init();
            }

            $.extend(SlideU.prototype, {
                init: function () {
                    this.buildCache();
                    this.bindEvents(); 
                },
                buildCache: function () {
                    this.$el = $(this.el);

                    this.fixElement();
                },
                fixElement: function () {
                    var plugin = this;
                    var height = plugin.$el.height();
                    
                    if (height > plugin.options.divider) {
                        console.log('fix height ');
                        var multiple = height / plugin.options.divider;

                        var overHide = '-' + (plugin.options.divider * (multiple - 1)) + 'px';
                        plugin.$el.css('bottom', overHide);

                    }
                },
                bindEvents: function () {
                    var plugin = this;
                    var $parent = plugin.getParent();

                    if (plugin.options.hideParentOverflow) {
                        $parent.css('overflow', 'hidden');
                    }

                    $(window).on('resize' + '.' + plugin._name, function () {
                        plugin.fixElement.call(plugin);
                    });

                    $parent.on('mouseenter' + '.' + plugin._name, function () {

                        if (plugin.$el.height() > plugin.options.divider) {
                            plugin.$el.css('bottom', '0px');
                        }
                    });

                    $parent.on('mouseleave' + '.' + plugin._name, function () {
                        var height = plugin.$el.height();
                        if (height > plugin.options.divider) {
                            var multiple = height / plugin.options.divider;
                            var overHide = '-' + (plugin.options.divider * (multiple - 1)) + 'px';
                            plugin.$el.css('bottom', overHide);
                        }
                    });

                },
                getParent: function () {
                    return this.$el.parent(this.options.parentSelector);
                },
                destroy: function () {

                    this.unbindEvents();
                    this.$el.removeData();
                },
                unbindEvents: function () {
                    this.getParent.off('.' + this._name);

                    this.$el.off('.' + this._name);
                }

            });

            $.fn.slideU = function (options) {
                //set the divider to the small el height
                if (typeof options.divider === 'undefined') {
                    var arr = [];
                    this.each(function () {

                        arr.push($(this).height());

                    });

                    var min = Math.min.apply(Math, arr);
                    options.divider = min;
                }
                this.each(function () {

                    if (!$.data(this, "plugin_" + pluginName)) {
                        $.data(this, "plugin_" + pluginName, new SlideU(this, options));
                    }
                });
                return this;
            };

            $.fn.slideU.defaults = {
                divider: 17,
                parentSelector: 'article',
                hideParentOverflow: false
            };

        })(jQuery, window, document);