// ---------------------------------
// ---------- NZ SoundCloud Field ----------
// ---------------------------------
// from this:
// <div>
//    <input class="nzSCField"/>
// </div>
// 
// to this:
// <div>
//    <input class="nzSCField"/>
//    <div class="nzSCField-wrap">
//          <input class="sc-resolver"/>
//          <div class="loading"></div>
//          <div class="sc-container">
//                <iframe class="sc-player"/>
//          </div>
//    </div>
// </div>
// 
// 
// ------------------------

;
(function($, window, document, undefined) {

      var pluginName = 'nzSCField';

      // Create the plugin constructor for each element
      function Plugin(element, options) {
            this.element = element;
            this._name = pluginName;
            this._defaults = $.fn.nzSCField.defaults;
            this.options = $.extend({}, this._defaults, options);

            this.status = {
                  resolved_url: null,
                  resolving: false,
                  loading: null
            };

            this.init();
      }

      // Avoid Plugin.prototype conflicts
      $.extend(Plugin.prototype, {
            // Initialization logic
            init: function() {
                  this.buildCache();
                  this.bindEvents();

                  var val = this.$element.val();
                  var track = nz_is_json_object(val);
                  if (track) {
                        this.$resolver.val(track.permalink_url);

                        var $iframe = $(this.options.tpl.iframe).attr({
                              src: this.options.player_url + "?url=" + track.uri
                        });
                        this.setIframe($iframe);
                  }
            },
            // Remove plugin instance completely
            destroy: function() {
                  this.unbindEvents();
                  this.$element.removeData();
            },
            // Cache DOM nodes for performance
            buildCache: function() {

                  this.$element = $(this.element);
                  this.$row = this.$element.parent();
                  this.$resolver = $(this.options.tpl.resolver);
                  /*this.$resolver = this.$element.clone().attr({id:'id',name:'name'});*/
                  this.$sc_container = $(this.options.tpl.sc_container);
                  this.$loading = $(this.options.tpl.loading);
                  this.$wrap = $(this.options.tpl.wrap);

                  this.$wrap.append(
                          this.$resolver,
                          this.$loading,
                          this.$sc_container
                          ).appendTo(this.$row);

            },
            // Bind events that trigger methods
            bindEvents: function() {
                  var plugin = this;

                  plugin.$resolver.on('input change' + '.' + plugin._name, function() {
                        var url = $(this).val().trim();

                        if (
                                plugin.status.resolving
                                || plugin.status.resolved_url == url
                                || !nz_is_valid_soundcloud_uri(url)
                                )
                              return;

                        plugin.status.resolving = true;
                        plugin.status.resolved_url = url;
                        plugin.status.loading = setInterval(function() {
                              plugin.$loading.toggleClass("x");
                        }, 100);

                        SC.get('/resolve', {url: url}, function(track) {
                              //update field
                              var t = plugin.getTrackInfo(track);
                              plugin.setJsonVal(t);

                              var $iframe = $(plugin.options.tpl.iframe).attr({
                                    src: plugin.options.player_url + "?url=" + t.uri + '&color=' + plugin.options.color
                              });
                              plugin.setIframe($iframe);

                              //callback
                              plugin.options.onComplete.call(plugin, track);

                              //stop loading
                              clearInterval(plugin.status.loading);
                              plugin.$loading.addClass("x").delay(2000).animate({opacity: 0}, 1000, function() {
                                    plugin.$loading.removeClass("x").css("opacity", "").html('');
                              });

                              plugin.status.resolving = false;
                        });

                  });//resolver change event

            },
            setIframe: function($iframe) {
                  var $container = this.$sc_container;
                  $iframe.attr({
                        style: 'display:none',
                        load: function() {
                              setTimeout(function() {
                                    $iframe.slideDown();
                              }, 1000);
                        }
                  });
                  $container.html($iframe);
            },
            onComplete: function(track) {

            },
            setJsonVal: function(json) {
                  this.$element.val(JSON.stringify(json));
            },
            getTrackInfo: function(t) {

                  return{
                        'permalink_url': t.permalink_url,
                        'uri': t.uri,
                        'kind': t.kind,
                        'wave_form': t.wave_form,
                        'artwork_url': t.artwork_url,
                        'tag_list': t.tag_list,
                        'title': t.title,
                        'genre': t.genre
                  };

            }


      });//Plugin.prototype

      //plugin wrapper single constructor
      $.fn.nzSCField = function(options) {
            this.each(function() {
                  if (!$.data(this, "plugin_" + pluginName)) {
                        $.data(this, "plugin_" + pluginName, new Plugin(this, options));
                  }
            });

            return this;
      };
      //global defaults $.fn.pluginName.defaults.property = 'myValue';
      $.fn.nzSCField.defaults = {
            onComplete: function(track) {
                  this.onComplete(track);
            },
            player_url: 'https://w.soundcloud.com/player/',
            color: '0583F2',
            tpl: {
                  wrap: '<div class="nzSCField-wrap"></div>',
                  resolver: '<input type="text" class="sc-resolver text control"/>',
                  sc_container: '<div class="sc-container"></div>',
                  iframe: '<iframe class="sc-player" width="100%" height="166" scrolling="no" frameborder="no"></iframe>',
                  loading: '<div class="loading"></div>'
            }
      };

})(jQuery, window, document);


function nz_is_json_object(value) {
      try {
            var json = jQuery.parseJSON(value);

            return  (typeof json == 'object') ? json : false;


            /*return (typeof jQuery.parseJSON(value) == 'object');*/
      } catch (er) {
            return false;
      }
}

function nz_is_valid_soundcloud_uri(value) {

      return (value.indexOf("soundcloud.com") > -1);
}
;