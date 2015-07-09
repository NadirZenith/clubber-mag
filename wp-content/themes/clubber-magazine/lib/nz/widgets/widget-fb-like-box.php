<?php
class NzWpSocials_FbLikeBox_Widget extends WP_Widget
{
    /* -------------------------------------------------- */
    /* CONSTRUCT THE WIDGET
      /*-------------------------------------------------- */

    function NzWpSocials_FbLikeBox_Widget()
    {
        /* Widget name and description */
        $widget_opts = array(
            'classname' => 'like-box',
            'description' => __('fb like box', 'clubber')
        );

        $this->WP_Widget('fb-like-box-widget', __('Fb Like Box - widget', 'clubber'), $widget_opts);
    }
    /* -------------------------------------------------- */
    /* DISPLAY THE WIDGET
      /*-------------------------------------------------- */
    /* outputs the content of the widget
     * @args --> The array of form elements */

    function widget($args, $instance)
    {
        $fb_page_url = $instance['fb_page_url'];

        if ($fb_page_url && $fb_page_url !== '') {
            ?>
            <div class="group mt10 pb10" >
                <?php echo nz_fb_like_box($fb_page_url); ?>
            </div>
            <?php
        }
    }
    /* -------------------------------------------------- */
    /* UPDATE THE WIDGET
      /*-------------------------------------------------- */

    function update($new_instance, $old_instance)
    {
        $instance = $old_instance;
        $instance['fb_page_url'] = strip_tags($new_instance['fb_page_url']);

        return $instance;
    }
    /*
     */

    /* -------------------------------------------------- */
    /* WIDGET ADMIN FORM
      /*-------------------------------------------------- */
    /* @instance	The array of keys and values for the widget. */

    function form($instance)
    {
        $instance = wp_parse_args((array) $instance, array(
            'fb_page_url' => null
        ));
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('fb_page_url'); ?>">
                <?php _e('facebook page url:', 'clubber'); ?>
            </label>
            <input type="text" class="widefat" 
                   id="<?php echo $this->get_field_id('fb_page_url'); ?>"
                   name="<?php echo $this->get_field_name('fb_page_url'); ?>"
                   value="<?php echo $instance['fb_page_url']; ?>" 
                   />
        </p>

        <?php
    }
}

// end class
add_action('widgets_init', create_function('', 'register_widget("NzWpSocials_FbLikeBox_Widget");'));
?>