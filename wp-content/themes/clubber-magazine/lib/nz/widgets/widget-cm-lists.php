<?php

class CM_Lists_Widget extends WP_Widget
{

    /* -------------------------------------------------- */
    /* CONSTRUCT THE WIDGET
      /*-------------------------------------------------- */

    protected static $count = 1;
    protected static $flexslider = false;
    protected static $custom_scroll = false;

    function CM_Lists_Widget()
    {
        /* Widget name and description */
        $widget_opts = array(
            'classname' => 'cm list widget',
            'description' => __('Display list of posts.', 'cm')
        );
        $this->WP_Widget('widget-cm-lists', __('CM posts lists', 'cm'), $widget_opts);
    }
    /* -------------------------------------------------- */
    /* DISPLAY THE WIDGET
      /*-------------------------------------------------- */
    /* outputs the content of the widget
     * @args --> The array of form elements */

    function widget($args, $instance)
    {
        /*
          d($args);
          d($instance);
         */
        extract($args, EXTR_SKIP);
        $title = apply_filters('widget_title', $instance['title']);

        $style = ($instance['js_lib'] === 'customscroll') ? 'max-height:220px' : '';

        /* before widget */
        echo $before_widget;
        /* echo $before_title . $title . $after_title; */
        ?>
        <section>
            <?php
            if ($title) {
                ?>
                <header>
                    <h2>
                        <a class="title" href="<?php echo get_post_type_archive_link($instance['post_type']); ?>">
                            <?php echo $title; ?>
                        </a>
                    </h2>
                </header>
                <?php
            }
            /* style="max-height: 455px;" */
            ?>
            <div id="widget-cm-list-<?php echo self::$count ?>" class="pr widget-cm-list-<?php echo $instance['js_lib'] ?> "  style="zoom:0.7;<?php echo $style; ?>" >
                <ul class="slides">
                    <?php
                    $args = array(
                        'post_type' => $instance['post_type'],
                        'posts_per_page' => $instance['num_posts'],
                        /*
                          'meta_query' => array(

                          array(
                          'key' => '_thumbnail_id',
                          'compare' => 'EXISTS',
                          )
                          )
                         */
                    );
                    $query = new WP_Query($args);
                    /* d($query); */
                    while ($query->have_posts()) {
                        $query->the_post();
                        ?>
                        <li>
                            <div class="p3">
                                <article class="pr">
                                    <?php
                                    if (get_post_type() == 'into-the-beat') {
                                        get_template_part('tpl/podcast/into-the-beat-header');
                                    }
                                    if ('open-frequency' === get_post_type()) {
                                        get_template_part('tpl/podcast/open-frequency-header-bottom');
                                    }
                                    get_template_part('tpl/podcast/soundcloud-iframe');
                                    ?>
                                </article>
                                <?php //get_template_part('tpl/list/list-5'); ?>
                            </div>
                        </li>
                        <?php
                    } //END while
                    ?>
                    <?php wp_reset_postdata(); ?>
                </ul>
            </div>
            <div class="cb"></div>

            <?php
            switch ($instance['js_lib']) {
                case 'customscroll':
                    if (self::$custom_scroll === true) {
                        return;
                    }
                    ?>
                    <script type="text/javascript">
                        (function ($) {
                            $(".widget-cm-list-customscroll").mCustomScrollbar();
                        })(jQuery);
                    </script>    
                    <?php
                    self::$custom_scroll = true;
                    break;

                //case 'flexslider':
                default :
                    if (self::$flexslider === true) {
                        return;
                    }
                    ?>
                    <script type="text/javascript">

                        (function ($) {

                            $('.widget-cm-list-flexslider').flexslider({
                                slideshowSpeed: 4000,
                                animation: "fade",
                                controlNav: true,
                                directionNav: false,
                                pauseOnHover: false,
                                direction: "horizontal",
                                reverse: false,
                                animationSpeed: 600,
                                prevText: "&lt;",
                                nextText: "&gt;",
                                slideshow: true
                            });
                        })(jQuery);
                    </script>    
                    <?php
                    self::$flexslider = true;
                    break;
            }
            ?>
        </section>

        <?php
        /* after widget */
        echo $after_widget;

        self::$count ++;
    }
    /* -------------------------------------------------- */
    /* UPDATE THE WIDGET
      /*-------------------------------------------------- */

    function update($new_instance, $old_instance)
    {
        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['post_type'] = strip_tags($new_instance['post_type']);
        $instance['num_posts'] = strip_tags($new_instance['num_posts']);
        $instance['js_lib'] = strip_tags($new_instance['js_lib']);
        /*
         */
        return $instance;
    }
    /* -------------------------------------------------- */
    /* WIDGET ADMIN FORM
      /*-------------------------------------------------- */
    /* @instance	The array of keys and values for the widget. */

    function form($instance)
    {
        $instance = wp_parse_args((array) $instance, array(
            'title' => 'test',
            'post_type' => 'post',
            'num_posts' => 3,
            'js_lib' => 'flexslider',
        ));
        // Display the admin form
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'cm'); ?></label>

            <input type="text" class="widefat" id="<?php
            echo $this->get_field_id('title');
            ?>" name="<?php
                   echo $this->get_field_name('title');
                   ?>" value="<?php
                   echo $instance['title'];
                   ?>" />

            <!-- Post type-->
            <label for="<?php echo $this->get_field_id('post_type'); ?>"><?php _e('Post Type:', 'cm'); ?></label>
            <input type="text" class="widefat" id="<?php
            echo $this->get_field_id('post_type');
            ?>" name="<?php
                   echo $this->get_field_name('post_type');
                   ?>" value="<?php
                   echo $instance['post_type'];
                   ?>" />

            <!-- num of posts-->
            <label for="<?php echo $this->get_field_id('num_posts'); ?>"><?php _e('Num of posts:', 'cm'); ?></label>
            <input type="text" class="widefat" id="<?php
            echo $this->get_field_id('num_posts');
            ?>" name="<?php
                   echo $this->get_field_name('num_posts');
                   ?>" value="<?php
                   echo $instance['num_posts'];
                   ?>" />

            <!-- num of posts-->
            <label for="<?php echo $this->get_field_id('js_lib'); ?>"><?php _e('Js Library:', 'cm'); ?></label>

            <select class='widefat' id="<?php echo $this->get_field_id('js_lib'); ?>"
                    name="<?php echo $this->get_field_name('js_lib'); ?>" type="text">
                <option value='flexslider'<?php echo ($instance['js_lib'] == 'flexslider') ? 'selected' : ''; ?>>
                    Flexslider
                </option>
                <option value='customscroll'<?php echo ($instance['js_lib'] == 'customscroll') ? 'selected' : ''; ?>>
                    Custom Scroll
                </option> 
            </select>  
        </p>


        <?php
    }
// end form
}

// end class
add_action('widgets_init', create_function('', 'register_widget("CM_Lists_Widget");'));
?>