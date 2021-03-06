/*
 *  loop throught msg array
 *    wrap each msg into predefined tag and append to msg container
 * 
 */

(function($) {
      $.NzStartMsgs = function(options) {

            var defaults = {
                  id: null,
                  msgs: null,
                  wrapper: '<div class="nz-start-msg-wrap"></div>',
                  btn_wrapper: '<div class="btn-wrap"></div>',
                  btn: '<a class="btn"></a>',
                  btnText: 'OK',
                  startTime: 1000
            }

            var plugin = this;

            var total = 0;
            var current = 0;
            var items = [];

            var addItem = function($item) {
                  items.push($item);
            };

            var btnClick = function() {
                  var $btn = $(this);
                  $btn.parent().parent().slideUp();

                  showNext();
            }
            var showNext = function() {
                  if (current == total - 1) {
                        $.get(ajaxurl + '?action=nz_start_msgs&id=' + plugin.settings.id);
                        return;
                  }
                  current++;
                  items[current].slideDown();

            };

            plugin.settings = {};

            plugin.init = function() {
                  plugin.settings = $.extend({}, defaults, options);
                  total = plugin.settings.msgs.length;
                  for (var i = 0; i < total; ++i) {
                        var item = plugin.settings.msgs[i];

                        var $btn = $(plugin.settings.btn).html(item.btnText || plugin.settings.btnText);
                        $btn.on('click', btnClick);
                        
                        var $btn_wrap = $(plugin.settings.btn_wrapper).append($btn);
                        
                        var $wrap = $(plugin.settings.wrapper).css({display: 'none'});
                        $wrap.append(item.msg, $btn_wrap);

                        if (i == 0) {
                              window.setTimeout(function($o) {
                                    $o.slideDown();
                              }, plugin.settings.startTime, $wrap);
                        }
                        $(item.container).append($wrap);
                        items[i] = $wrap;
                  }

            }

            plugin.init();

      }

}(jQuery));
