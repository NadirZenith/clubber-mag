<div class="location-filter-wrap group cb">
      <?php
      $tax = 'location';
      $countries = get_terms( $tax, array( 'parent' => 0, 'hide_empty' => FALSE ) );
      ?>
      <div class="country-select-wrap fl">

            <select name="contry-select" id="contry-select" style="visibility: hidden">
                  <?php
                  $current = get_query_var( 'country', 'es' );
                  foreach ( $countries as $country ) {
                        ?>
                        <option value="<?php echo $country->slug ?>" 
                        <?php
                        if ( $country->slug == $current ) {
                              echo 'selected';
                              $current_country = $country;
                        };
                        ?>
                                >
                                      <?php echo $country->name ?>
                        </option> 
                        <?php
                  }
                  ?>
            </select>
      </div>
      <?php
      if ( $current_country ) {
            global $wp_query;
            $cities = $wp_query->get('_cities');
            if ( !empty( $cities ) ) {
                  ?>
                  <div class="city-select-wrap fl">
                        <select name="city-select" id="city-select" style="visibility: hidden">
                              <?php
                              $current = get_query_var( 'city', 'barcelona' );
                              foreach ( $cities as $city ) {
                                    ?>
                                    <option value="<?php echo $city->slug ?>" 
                                    <?php
                                    if ( $city->slug == $current ) {
                                          echo 'selected';
                                          $current_city = $city;
                                    };
                                    ?>
                                            >
                                                  <?php echo $city->name ?>
                                    </option> 
                                    <?php
                              }
                              ?>
                        </select>
                  </div>
                  <?php
            }
      }
      ?>
</div>
<script type="text/javascript">
      (function() {
            $(function() {
                  $("#contry-select").selectbox({
                        onChange: function(val, inst) {
                              var country_url = UpdateQueryString('city', null, window.location.href);
                              window.location.href = UpdateQueryString('country', val, country_url);
                        }
                  });
            });
            $(function() {
                  $("#city-select").selectbox({
                        onChange: function(val, inst) {
                              var country_url = UpdateQueryString('country', $("#contry-select").val(), window.location.href);
                              window.location.href = UpdateQueryString('city', val, country_url);
                        }
                  });
            });
            /*
             var d = document.getElementById("contry-select");
             d.onchange = function() {
             var o = (window.location.href.indexOf("?") > -1) ? '&' : '?';
             location.href = UpdateQueryString('country', this.options[this.selectedIndex].value, window.location.href);
             }
             
             */
            function UpdateQueryString(key, value, url) {
                  if (!url)
                        url = window.location.href;
                  var re = new RegExp("([?&])" + key + "=.*?(&|#|$)(.*)", "gi"),
                          hash;

                  if (re.test(url)) {
                        if (typeof value !== 'undefined' && value !== null)
                              return url.replace(re, '$1' + key + "=" + value + '$2$3');
                        else {
                              hash = url.split('#');
                              url = hash[0].replace(re, '$1$3').replace(/(&|\?)$/, '');
                              if (typeof hash[1] !== 'undefined' && hash[1] !== null)
                                    url += '#' + hash[1];
                              return url;
                        }
                  }
                  else {
                        if (typeof value !== 'undefined' && value !== null) {
                              var separator = url.indexOf('?') !== -1 ? '&' : '?';
                              hash = url.split('#');
                              url = hash[0] + separator + key + '=' + value;
                              if (typeof hash[1] !== 'undefined' && hash[1] !== null)
                                    url += '#' + hash[1];
                              return url;
                        }
                        else
                              return url;
                  }
            }


      })();
</script>

<style>
      .location-filter-wrap{
            margin-bottom: 15px;
            /*margin-left: 5px;*/
            /*min-height: 50px;*/
            /*background-color: rgba(255,255,255,0.5);*/
      }
</style>
<?php
/*
  $json = file_get_contents( 'https://freegeoip.net/json/188.87.83.179' );
  $obj = json_decode( $json );

  d(
  $obj
  );
 */
?>