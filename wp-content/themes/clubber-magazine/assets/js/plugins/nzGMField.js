// ---------------------------------
// ---------- Plugin Name ----------
// ---------------------------------
// Brief plugin description
// ------------------------
;
(function($, window, document, undefined) {


      var pluginName = 'nzGMField';
      // plugin constructor
      function Plugin(element, options) {

            this.element = element;
            this._name = pluginName;
            this._defaults = $.fn.nzGMField.defaults;
            this.options = $.extend({}, this._defaults, options);

            this.init();
      }

      // Avoid Plugin.prototype conflicts
      $.extend(Plugin.prototype, {
            // Initialization logic
            init: function() {
                  this.buildCache();
                  this.bindEvents();
                  /*this.createDom();*/

                  var val = this.$element.val();
                  var info = nz_is_json_object(val);

                  console.log(info);
                  if (info) {

                        if ('type' in info) {
                              if (info.type == 'map') {
                                    if ('lat' && 'lng' in info.components) {

                                          if (this.options.map_options.type == 'image') {
                                                var $img = map.getImage(info.components.lat, info.components.lng, false);
                                                this.$map_wrapper.html($img[0]);
                                          }
                                          this.$autocomplete.val(info.components.formatted_address);

                                    }
                                    this.$map_container.slideDown();

                              } else if (info.type == 'raw') {
                                    this.$raw_container.find(' input').each(function(e) {
                                          var key = this.name;
                                          if (info.components[key]) {
                                                this.value = info.components[key];

                                          }
                                    });

                                    this.$raw_container.slideDown();
                                    this.$switch.prop('checked', true);

                              }

                        }
                  } else {
                        /*                        
                        var $img = map.getImage(this.options.map_options.startLat, this.options.map_options.startLng, true);
                        this.$map_wrapper.html($img[0]);
                         * */
                        this.$map_container.slideDown();

                  }

            },
            // Cache DOM nodes for performance
            buildCache: function() {
                  this.$element = $(this.element);
                  this.$row = this.$element.parent();
                  this.$autocomplete = $(this.options.tpl.autocomplete);
                  this.$map_wrapper = $(this.options.tpl.map_wrapper);
                  this.$map_container = $(this.options.tpl.map_container).attr('style', 'display:none;').append(this.$autocomplete, this.$map_wrapper);
                  map.createMap.call(this, this.$autocomplete);
                  this.$switch = $('<input type="checkbox" class=""/>');
                  this.$raw_container = $('<div class="raw-options"></div>').attr('style', 'display:none;');

                  var $switch_wrapper = $('<label />')
                          .attr({
                                class: 'option-switch'//, style: 'display:none'
                          }).append(this.$switch, $('<span></span>', {text: this.options.switchText}));


                  var options = this.options.raw_options,
                          size = 0, option;
                  for (option in options) {
                        if (!options.hasOwnProperty(option))
                              continue;

                        $('<label />').append(
                                $('<span></span>', {
                                      text: options[option]
                                }),
                        $('<input />', {
                              type: 'text',
                              name: option
                        })
                                ).appendTo(this.$raw_container);
                        size++;
                  }

                  this.$row.append(
                          this.$map_container,
                          $switch_wrapper,
                          this.$raw_container);
                  return;

            },
            // Bind events that trigger methods
            bindEvents: function() {
                  var plugin = this;

                  //switch event
                  plugin.$switch.on('change', function() {
                        if ($(this).prop("checked")) {
                              plugin.$map_container.slideUp();
                              plugin.$raw_container.slideDown();
                        } else {
                              plugin.$map_container.slideDown();
                              plugin.$raw_container.slideUp();
                        }
                  });

                  //options change
                  plugin.$raw_container.on('change', 'input', function(e) {
                        plugin.updateValRaw();
                  });

                  //prevent form submission
                  plugin.$autocomplete.bind("keyup keypress", function(e) {
                        var code = e.keyCode || e.which;
                        if (code == 13) {
                              e.preventDefault();
                              return false;
                        }
                  });

            },
            updateValRaw: function() {
                  var components = {}, jsonVal;
                  this.$raw_container.find(':input').each(function() {
                        components[this.name] = $(this).val();
                  });
                  var jsonVal = {
                        type: 'raw',
                        components: components
                  };

                  this.$element.val(JSON.stringify(jsonVal));
            },
            updateValMap: function(components) {
                  var jsonVal = {
                        type: 'map',
                        components: components
                  };
                  this.$element.val(JSON.stringify(jsonVal));
            }

      });

      var addUrlParam = function(url, param, value) {
            var a = document.createElement('a'), regex = /[?&]([^=]+)=([^&]*)/g;
            var match, str = [];
            a.href = url;
            value = value || "";
            while (match = regex.exec(a.search))
                  if (encodeURIComponent(param) != match[1])
                        str.push(match[1] + "=" + match[2]);
            str.push(encodeURIComponent(param) + "=" + value);
            /*str.push(encodeURIComponent(param) + "=" + encodeURIComponent(value));*/
            a.search = (a.search.substring(0, 1) == "?" ? "" : "?") + str.join("&");
            return a.href;
      };

      var map = {
            getImage: function(lat, lng, center) {
                  var url = 'http://maps.googleapis.com/maps/api/staticmap';

                  if (center) {
                        url = addUrlParam(url, 'center', lat + ',' + lng);
                        url = addUrlParam(url, 'zoom', '13');

                  } else {
                        url = addUrlParam(url, 'markers', lat + ',' + lng);
                        url = addUrlParam(url, 'zoom', '17');

                  }

                  url = addUrlParam(url, 'size', '1000x150');
                  url = addUrlParam(url, 'sensor', 'false');
                  url = addUrlParam(url, 'scale', '2');

                  return $('<img/>').attr({
                        src: url
                  });
            },
            createMap: function($input) {
                  var input = $input[0];
                  var plugin = this;
                  var autocomplete = new google.maps.places.Autocomplete(input);

                  if (plugin.options.map_options.type == 'image') {
                        var $img = map.getImage(plugin.options.map_options.startLat, plugin.options.map_options.startLng, true);
                        plugin.$map_wrapper.html($img[0]);
                  }

                  google.maps.event.addListener(autocomplete, 'place_changed', function() {
                        var place = autocomplete.getPlace();
                        if (!place.geometry) {
                              return;
                        }

                        var components = map.getAddressComponents(place.address_components);
                        components['lat'] = place.geometry.location.k;
                        components['lng'] = place.geometry.location.B;
                        components['formatted_address'] = place.formatted_address;
                        plugin.updateValMap(components);

                        if (plugin.options.map_options.type == 'image') {
                              var $img = map.getImage(place.geometry.location.k, place.geometry.location.B, false);
                              plugin.$map_wrapper.html($img[0]);
                        }

                  });

            },
            getAddressComponents: function(address_components) {
                  var results = {}, city, county, country;

                  //var address_components = place.address_components;
                  for (j = 0; j < address_components.length; ++j)
                  {
                        var component_type = address_components[j].types;
                        for (k = 0; k < component_type.length; ++k)
                        {
                              //find city
                              if (component_type[k] == "locality")
                              {
                                    city = address_components[j].long_name; //BARCELONA
                                    results.city = city;
                              }
                              //find county
                              if (component_type[k] == "administrative_area_level_2")
                              {
                                    county = address_components[j].long_name; //CATALUNHA

                                    if (city != county) {
                                          results.city = county;
                                          results.region = city;
                                    }
                                    results.county = county;
                              }
                              //find country
                              if (component_type[k] == "country")
                              {
                                    country = address_components[j].long_name;
                                    results.country = country;
                              }
                        }
                  }

                  return results;
            }

      };

      //wrapper initializator
      $.fn.nzGMField = function(options) {
            this.each(function() {
                  if (!$.data(this, "plugin_" + pluginName)) {

                        $.data(this, "plugin_" + pluginName, new Plugin(this, options));
                  }
            });

            return this;
      };


      //defaults
      $.fn.nzGMField.defaults = {
            property: 'value',
            onComplete: null,
            switchText: 'Introducir manual',
            startOn: 'map', //raw
            tpl: {
                  autocomplete: '<input type="text" class="gm-autocomplete control text"/>',
                  map_container: '<div class="gm-container"></div>',
                  map_wrapper: '<div class="gm-wrapper"></div>'
            },
            raw_options: {
                  address: 'Dirección:',
                  city: 'Ciudad:',
                  contry: 'País:'
            },
            map_options: {
                  type: 'image', //iframe
                  startLat: 41.382573,
                  startLng: 2.175293
            }
      };

})(jQuery, window, document);

