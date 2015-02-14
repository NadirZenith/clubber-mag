<div id="example-one">

        <ul class="nav">
                <li class="nav-one"><a href="#featured" class="current">Featured</a></li>
                <li class="nav-two"><a href="#core">Core</a></li>
                <li class="nav-three"><a href="#jquerytuts">jQuery</a></li>
                <li class="nav-four last"><a href="#classics">Classics</a></li>
        </ul>

        <div class="list-wraper">

                <ul id="featured">
                        <li>Stuff in here!</li>
                        <li>Stuff in here!</li>
                        <li>Stuff in here!</li>
                </ul>

                <ul id="core" class="hide">
                        <li>Stuff in here!</li>
                        <li>Stuff in here!</li>
                        <li>Stuff in here!</li>
                </ul>

                <ul id="jquerytuts" class="hide">
                        <li>Stuff in here!</li>
                        <li>Stuff in here!</li>
                        <li>Stuff in here!</li>
                </ul>

                <ul id="classics" class="hide">
                        <li>Stuff in here!</li>
                        <li>Stuff in here!</li>
                        <li>Stuff in here!</li>
                </ul>

        </div> <!-- END List Wrap -->

</div> <!-- END Organic Tabs (Example One) -->
<?php
add_action('wp_footer', 'nz_debug_add_footer_scripts');

function nz_debug_add_footer_scripts() {
        /* wp_enqueue_style('tabulous', get_template_directory_uri() . '/js/tabulous/tabulous.css'); */
        /* wp_enqueue_script('tabulous', get_template_directory_uri() . '/js/tabulous/tabulous.min.js', array('jquery')); */

        wp_enqueue_style('organictabs', get_template_directory_uri() . '/js/organictabs/css/style.css');
        wp_enqueue_script('organictabs', get_template_directory_uri() . '/js/organictabs/organictabs.jquery.js', array('jquery'));
        ?>
        <script>
                jQuery(document).ready(function($) {

                        

                        $("#example-one").organicTabs({
                                "speed": 200
                        });

                });
        </script>
        <?php
}
