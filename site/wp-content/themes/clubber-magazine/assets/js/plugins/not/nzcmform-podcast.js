;
(function($) {
      $.nzcmform_podcast = function(el, options) {
            var bs = this;

            var defaults = {
                  onResponse: function(container) {
                        onResponse(this, container);
                  },
                  sc_player_url: 'https://w.soundcloud.com/player/',
                  sc_iframe: '<iframe class="sc-player" width="100%" height="166" scrolling="no" frameborder="no"></iframe>',
                  sc_iframe_container: '<div class="sc-iframe-container"></div>',
                  tpl: {
                        sc_iframe: '<iframe class="sc-player" width="100%" height="166" scrolling="no" frameborder="no"></iframe>',
                        sc_iframe_container: '<div class="sc-iframe-container"></div>'
                  }
            };

            bs.settings = {};

            var status = {
                  resolved_url: null,
                  resolving: false,
            };
            var resolved_url = null;
            var working = false;


            // the "constructor" method that gets called when the object is created
            // this is a private method, it can be called only from inside the bs
            var init = function() {
                  bs.settings = $.extend({}, defaults, options);
                  bs.$el = $(el);
                  bs.el = el;

                  bs.$row = bs.$el.parent();

                  var $sc_resolver = $('<input type="text"/>')
                          .attr({
                                class: 'sc-resolver ' + bs.$el.attr('class').replace('nzcmform_podcast', '')
                          });



                  $sc_resolver.on('paste input change', function() {
                        var url = $(this).val();
                        /*console.log(url);*/
                        if (working || !nz_is_valid_soundcloud_uri(url) || resolved_url == url)
                              return;
                        resolved_url = url;
                        working = true;
                        console.log('resolve ...');
                        SC.get('/resolve', {url: url}, function(track) {
                              /*plugin.settings.onResponse.call(track, $sc_iframe_container);*/


                              var $sc_iframe = $(bs.settings.sc_iframe).attr({
                                    src: bs.settings.sc_player_url + "?url=" + track.uri
                              });
                              var $sc_iframe_container = $(bs.settings.sc_iframe_container);
                              $sc_iframe_container.html($sc_iframe);

                              bs.$row.append($sc_iframe_container);
                              setTimeout(function() {
                                    working = false;
                              }, 500);
                              /*
                               * */
                        });
                  });

                  bs.$row.append($sc_resolver);

            };

            // a public method. for demonstration purposes only - remove it!
            bs.foo_public_method = function() {

                  // code goes here

            };

            var onResponse = function(track, $container) {
                  console.log('track', track);

                  var $sc_iframe = $(bs.settings.sc_iframe).attr({
                        src: bs.settings.sc_player_url + "?url=" + track.uri
                  });

                  console.log($sc_iframe);
                  console.log($container);
                  $container.append($sc_iframe);

                  console.log('end');
            };

            if (typeof SC == "undefined") {
                  console.log('nzcmform-podcast error - SC not found ');
            } else {
                  // call the "constructor" method
                  init();
            }

      };

})(jQuery);

jQuery(document).ready(function() {

      // create a new instance of the plugin
      /*var cmpod = new $.nzcmform_podcast('.nzcmform_podcast');*/

      // call a public method
      /*cmpod.foo_public_method();*/

      // get the value of a public property
      /*cmpod.settings.property;*/

});

function nz_is_valid_soundcloud_uri(value) {

      return (value.indexOf("soundcloud.com") > -1);
}
;