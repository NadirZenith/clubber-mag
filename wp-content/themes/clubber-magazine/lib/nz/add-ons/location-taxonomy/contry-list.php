<?php
if (is_admin() && current_user_can('manage_options')) {
    include_once('tax-tools.php');
}
Class NzWpLocationTerms
{
    static $taxonomy;
    private $options;
    static $current_country;
    public static $current_city;

    public function __construct($options)
    {

        $this->options = wp_parse_args($options, array(
            'post_type' => 'post',
            'taxonomy' => 'location',
            'default_country_slug' => 'es',
            'default_city_slug' => 'barcelona',
            'custom_pre_get_posts' => false
        ));

        self::$taxonomy = $this->options['taxonomy'];

        add_action('init', array($this, 'init'));

        add_action('pre_get_posts', array($this, 'pre_get_posts_archive'));
        add_action('query_vars', array($this, 'add_location_vars'));
    }

    public function init()
    {
        $this->registerTaxonomy();
    }

    public function pre_get_posts_archive($query)
    {
        if (
            !$query->is_main_query() || $query->is_admin
        )
            return;


        if ($query->is_post_type_archive($this->options['post_type'])) {
            return $this->_apply_query_filter($query);
        }

        if ($this->options['custom_pre_get_posts']) {
            if ($this->_check_conditional_tag()) {
                return $this->_apply_query_filter($query);
            }
        }
    }

    private function _check_conditional_tag()
    {
        if (is_array($this->options['custom_pre_get_posts'])) {
            return $this->options['custom_pre_get_posts'][0]($this->options['custom_pre_get_posts'][1]);
        } else {
            return $this->options['custom_pre_get_posts']();
        }
    }

    private function _apply_query_filter($query)
    {
        //set current country and city
        $city = get_query_var('city');
        $country = get_query_var('country');

        if (!empty($city) && !empty($country)) {
            //both set
            $country_term = get_term_by('slug', $country, $this->options['taxonomy']);
            if (!$country_term) {
                //contry does not exits
                $query->set_404();
                return;
            }

            $city_term = get_term_by('slug', $city, $this->options['taxonomy']);
            if ($city_term && $city_term->parent != $country_term->term_id) {
                //city does not exist
                $query->set_404();
                return;
            }
        } elseif (!empty($country) && empty($city)) {
            //country set
            $country_term = get_term_by('slug', $country, $this->options['taxonomy']);
            if (!$country_term) {
                $query->set_404();
                return;
            }

            $city_terms = get_terms($this->options['taxonomy'], array('parent' => $country_term->term_id));

            $city_term = (!empty($city_terms)) ? $city_terms[0] : false;
        } elseif (!empty($city) && empty($country)) {
            //city set
            $city_term = get_term_by('slug', $city, $this->options['taxonomy']);
            if (!$city_term || is_wp_error($city_term)) {
                $query->set_404();
                return;
            }

            $country_term = get_term_by('id', $city_term->parent, $this->options['taxonomy']);
        } else {
            //none set
            $country_term = get_term_by('slug', $this->options['default_country_slug'], $this->options['taxonomy']);
            $city_term = get_term_by('slug', $this->options['default_city_slug'], $this->options['taxonomy']);

            if (!$country_term || !$city_term) {
                $query->set_404();
                return;
            }
        }

        self::$current_country = $country_term;
        self::$current_city = $city_term;

        $countries = get_terms($this->options['taxonomy'], array(
            'parent' => 0,
            'hide_empty' => FALSE
            )
        );
        $query->set('_countries', $countries);

        $cities = get_terms($this->options['taxonomy'], array(
            'parent' => self::$current_country->term_id,
            'hide_empty' => FALSE,
            'orderby' => 'count',
            'order' => 'DESC'
            )
        );

        $query->set('_cities', $cities);

        $city_tax_query = array(
            'taxonomy' => $this->options['taxonomy'],
            'field' => 'slug',
            'terms' => self::$current_city->slug
        );

        $tax_query = array(
            $city_tax_query,
        );

        $query->set('tax_query', $tax_query);
    }

    public function add_location_vars($vars)
    {

        $vars[] = "country"; //
        $vars[] = "city"; //

        return $vars;
    }

    private function registerTaxonomy()
    {
        // Add new taxonomy, make it hierarchical (like categories)
        $labels = array(
            'name' => _x('Locations', 'taxonomy general name', 'cm'),
            'singular_name' => _x('Location', 'taxonomy singular name', 'cm'),
            'search_items' => __('Search Locations', 'cm'),
            'all_items' => __('All Locations', 'cm'),
            'parent_item' => __('Parent Location', 'cm'),
            'parent_item_colon' => __('Parent Location:', 'cm'),
            'edit_item' => __('Edit Location', 'cm'),
            'update_item' => __('Update Location', 'cm'),
            'add_new_item' => __('Add New Location', 'cm'),
            'new_item_name' => __('New Location Name', 'cm'),
            'menu_name' => __('Location', 'cm'),
        );

        $args = array(
            'hierarchical' => true,
            'labels' => $labels,
            'show_ui' => true,
            'show_admin_column' => true,
            'query_var' => true,
            'rewrite' => array('slug' => 'location'),
        );

        register_taxonomy($this->options['taxonomy'], $this->options['post_type'], $args);
    }

    static function get_post_city_name($post_id)
    {
        $city = '';
        $city_term = self::get_post_city_term($post_id);
        if ($city_term)
            $city = $city_term->name;

        return $city;
    }
    
    public function get_current_city(){
        
    }

    static function get_post_city_term($post_id)
    {
        $terms = get_the_terms($post_id, self::$taxonomy);
        if (!is_wp_error($terms) && !empty($terms)) {
            foreach ($terms as $term) {
                if ($term->parent === 0)//is contry
                    continue;
                return $term; //return first city
            }
        }
        return FALSE;
    }

    static function get_location_filter($options = array())
    {
        global $wp_query;
        $countries = $wp_query->get('_countries');
        ?>
        <div class="location-filter-wrap">
            <div class="country-select-wrap fl">
                <select name="contry-select" id="contry-select" style="visibility: hidden">
                    <?php
                    foreach ($countries as $country) {
                        ?>
                        <option value="<?php echo $country->slug ?>" <?php echo ($country->slug == self::$current_country->slug ) ? 'selected' : ''; ?> >
                        <?php echo $country->name ?>
                        </option> 
                        <?php
                    }
                    ?>
                </select>
            </div>
            <?php
            $cities = $wp_query->get('_cities');
            if (!empty($cities)) {
                ?>
                <div class="city-select-wrap fl">
                    <select name="city-select" id="city-select" style="visibility: hidden">
                        <?php
                        foreach ($cities as $city) {
                            ?>
                            <option value="<?php echo $city->slug ?>" <?php echo ($city->slug == self::$current_city->slug ) ? 'selected' : ''; ?> >
                            <?php echo $city->name ?>
                            </option> 
                            <?php
                        }
                        ?>
                    </select>
                </div>
                <?php
            }
            ?>
        </div>
        <script type="text/javascript">
            (function () {
                $(function () {
                    $("#contry-select").selectbox({
                        onChange: function (val, inst) {
                            var country_url = UpdateQueryString('city', null, window.location.href);
                            window.location.href = UpdateQueryString('country', val, country_url);
                        }
                    });
                });
                $(function () {
                    $("#city-select").selectbox({
                        onChange: function (val, inst) {
                            var country_url = UpdateQueryString('country', $("#contry-select").val(), window.location.href);
                            window.location.href = UpdateQueryString('city', val, country_url);
                        }
                    });
                });
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
            .country-select-wrap .sbOptions{
                min-height: 300px;
                height: 350px;
            }
        </style>
        <?php
    }
}
$NzLocationsTerms = New NzWpLocationTerms(array(
    'post_type' => array('agenda', 'cool-place'),
    'custom_pre_get_posts' => array('is_tax', 'cool_place_type')
    )
);
