/**
 * map handle class
 */
;
(function($, window, document) {
      if (!$.nzwpform) {
            $.nzwpform = {};
      }
      ;
      $.nzwpform.mapaddress = function(el, myFunctionParam, options) {
            var base = this;
            base.$el = $(el);
            base.el = el;
            base.val = base.$el.val();


            base.$el.data("nzwpform.mapaddress", base);

            base.init = function() {
                  base.options = $.extend({}, $.nzwpform.mapaddress.defaultOptions, options);
                  var jsonVal = {};
                  var $dom = $(base.createDom(base.$el, base.onRawAddressChange));
                  var map = base.createMap(base.$el.attr('id'), base.afterComplete);

                  if (base.val) {
                        try {
                              jsonVal = $.parseJSON(base.val);
                        } catch (e) {
                              console.log("parseJSON error: " + e);
                        }
                  }

                  /*                  
                   * */
                  var useMap = true;

                  if ('lat' && 'lng' in jsonVal) {//latitude exist -> is map address
                        base.setMapImage(jsonVal.lat, jsonVal.lng);

                        $dom.find('.map-container').slideDown();
                        $dom.find('.map-search').val(jsonVal.formatted_address);
                  } else if (jsonVal.components && 'address' in jsonVal.components) {
                        var useMap = false;

                        $dom.find('.map-options input').each(function(e) {
                              var key = this.name;
                              if (jsonVal.components[key]) {
                                    this.value = jsonVal.components[key];

                              }
                        });

                        $dom.children('.option-switch, .map-options').css('display', 'block');
                        $dom.find('.option-switch input').prop('checked', true);

                  }
                  if (useMap) {
                        $dom.find('.map-container').slideDown();
                  }

            };

            base.setMapImage = function(lat, lng, center) {

                  var url = 'http://maps.googleapis.com/maps/api/staticmap';

                  if (center) {
                        url = base.addUrlParam(url, 'center', lat + ',' + lng);
                        url = base.addUrlParam(url, 'zoom', '13');

                  } else {
                        url = base.addUrlParam(url, 'markers', lat + ',' + lng);
                        url = base.addUrlParam(url, 'zoom', '17');

                  }
                  url = base.addUrlParam(url, 'zoom', '15');
                  url = base.addUrlParam(url, 'size', '1000x150');
                  url = base.addUrlParam(url, 'sensor', 'false');
                  url = base.addUrlParam(url, 'scale', '2');

                  base.$el.parent().find('.map-canvas').html(
                          $('<img/>').attr({
                        src: url
                  })
                          );

            };

            base.afterComplete = function(place) {

                  var jsonVal = {
                        lat: place.geometry.location.lat(),
                        lng: place.geometry.location.lng(),
                        components: base.getAddressComponents(place.address_components),
                        formatted_address: place.formatted_address,
                        formatted_phone_number: place.formatted_phone_number
                  };
                  base.$el.val(JSON.stringify(jsonVal));

                  var ref_id = base.$el.attr('id');
                  base.$el.parent().find(".option-switch").slideDown()

            };
            base.onRawAddressChange = function(e) {
                  var components = {};
                  $(this).find(':input').each(function() {
                        components[this.name] = $(this).val();
                  });
                  var jsonVal = {
                        components: components
                  };

                  base.$el.val(JSON.stringify(jsonVal));

            };

            base.addUrlParam = function(url, param, value) {
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
            base.createMap = function(ref_id, callback) {
                  var input = (document.getElementById('mapsearch-' + ref_id));
                  $(input).css('z-index', 100000);
                  var autocomplete = new google.maps.places.Autocomplete(input);

                  base.setMapImage(base.options.startLat, base.options.startLng, true);

                  google.maps.event.addListener(autocomplete, 'place_changed', function() {
                        var place = autocomplete.getPlace();

                        if (!place.geometry) {
                              return;
                        }
                        base.setMapImage(place.geometry.location.lat(), place.geometry.location.lng());

                        if (callback && typeof (callback) === "function") {
                              callback.call(ref_id, place);
                        }

                  });

            };
            base.createMap2 = function(ref_id, callback) {
                  var mapOptions = {
                        center: new google.maps.LatLng(base.options.startLat, base.options.startLng),
                        zoom: 13
                  };

                  var map = new google.maps.Map(document.getElementById('map-canvas-' + ref_id), mapOptions);
                  var input = (document.getElementById('mapsearch-' + ref_id));
                  var autocomplete = new google.maps.places.Autocomplete(input);
                  autocomplete.bindTo('bounds', map);
                  var marker = new google.maps.Marker({
                        map: map,
                        anchorPoint: new google.maps.Point(0, -29)
                  });
                  google.maps.event.addListener(autocomplete, 'place_changed', function() {
                        marker.setVisible(false);
                        var place = autocomplete.getPlace();

                        if (!place.geometry) {
                              return;
                        }

                        // If the place has a geometry, then present it on a map.
                        if (place.geometry.viewport) {
                              map.fitBounds(place.geometry.viewport);
                        } else {
                              map.setCenter(place.geometry.location);
                              map.setZoom(17);
                        }
                        marker.setIcon(
                                ({
                                      url: place.icon,
                                      size: new google.maps.Size(71, 71),
                                      origin: new google.maps.Point(0, 0),
                                      anchor: new google.maps.Point(17, 34),
                                      scaledSize: new google.maps.Size(35, 35)
                                })
                                );
                        marker.setPosition(place.geometry.location);
                        marker.setVisible(true);

                        if (callback && typeof (callback) === "function") {
                              callback.call(ref_id, place);
                        }

                  });

                  return map;
            };
            base.getAddressComponents = function(address_components) {
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
            };
            base.createDom = function($ref_el, callback) {
                  var $wrapper, $map_search, $map_container, $map_canvas, $checker_wrap, $map_options,
                          ref_id = $ref_el.attr('id');

/*d($ref_el.attr('class').replace('nzwpform_mapaddress',''));*/
                  //map input search
                  $map_search = $('<input type="text"/>')
                          .attr({
                                class: 'map-search ' + $ref_el.attr('class').replace('nzwpform_mapaddress',''),
                                /*class: 'map-search ' + $ref_el.attr('class'),*/
                                id: 'mapsearch-' + ref_id
                          });

                  //prevent form submission on enter
                  $map_search.bind("keyup keypress", function(e) {
                        var code = e.keyCode || e.which;
                        if (code == 13) {
                              e.preventDefault();
                              return false;
                        }
                  });

                  //map container
                  $map_container = $('<div></div>')
                          .attr({
                                class: 'map-container',
                                style: 'display:none;'
                          });

                  //map canvas
                  $map_canvas = $('<div></div>')
                          .attr({
                                id: 'map-canvas-' + ref_id,
                                class: 'map-canvas'
                          });

                  /*var $map_wrapper = $('<div></div>').append($map_canvas);*/
                  $map_container.append($map_search, $map_canvas);

                  //change input type
                  var $checker = $('<input />', {
                        type: 'checkbox',
                        id: 'rawaddress-' + ref_id,
                        name: 'rawaddress-' + ref_id
                  });

                  $checker.on('change', function() {
                        if ($(this).prop("checked")) {
                              $map_container.slideUp();
                              $map_options.slideDown();
                        } else {
                              $map_container.slideDown();
                              $map_options.slideUp();
                        }
                  });

                  $checker_wrap = $('<label />')
                          .attr({
                                class: 'option-switch', style: 'display:none'
                          }).append($checker, $('<span></span>', {text: ' Introduzir manual'}));

                  //the options
                  $map_options = $('<div></div>')
                          .attr({
                                class: 'map-options',
                                style: 'display:none'
                          });

                  $map_options.on('focusout', 'input', function(e) {
                        if (callback && typeof (callback) === "function") {
                              callback.call($map_options, e);
                        }

                  });

                  var components = ['address', 'city', 'contry'],
                          arrayLength = components.length;
                  for (var i = 0; i < arrayLength; i++) {
                        var component = components[i];
                        $('<label />').append(
                                $('<span></span>', {
                                      text: component
                                }),
                        $('<input />', {
                              type: 'text',
                              id: 'rawaddress-' + component + '-' + ref_id,
                              name: component
                        })
                                ).appendTo($map_options);
                  }

                  $wrapper = $('<div></div>').attr({class: 'nzwpform-mapaddress-container'});
                  $wrapper.append($map_container, $checker_wrap, $map_options);
                  $ref_el.parent().append($wrapper);
                  return $wrapper;
            }

            // Run initializer
            base.init();

      };

      $.nzwpform.mapaddress.defaultOptions = {
            myDefaultValue: "",
            startLat: 41.382573,
            startLng: 2.175293
      };

      $.fn.nzwpform_mapaddress = function(myFunctionParam, options) {
            return this.each(function() {
                  /*console.log('this', $(this).data("nzwpform.mapaddress"));*/
                  if (typeof $(this).data("nzwpform.mapaddress") == 'undefined')
                  {
                        /*alert('no exist create');*/
                        /*console.log('create', this.id);*/
                        (new $.nzwpform.mapaddress(this, myFunctionParam, options));
                  }
            });
      };
})(jQuery, window, document);
/**
 * endmap handle class
 */

