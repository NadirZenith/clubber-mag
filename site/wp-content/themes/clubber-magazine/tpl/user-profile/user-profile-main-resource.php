<?php
$resource_type = get_post_type_object($resource->post_type);
?>
<section id="user-profile-<?php echo $resource->post_type ?>">
    <header>
        <h2>
            <a class="title" href="<?php echo get_permalink($resource->ID) ?>">
                <span class="sc-1">  <?php _e($resource_type->labels->singular_name, 'cm') ?>: </span>
                <?php echo $resource->post_title ?>
            </a>
        </h2>
    </header>
    <div class="pure-g">
        <div class="pure-u-1-2 pr">
            <a class="featured-image" href="<?php echo get_permalink($resource->ID) ?>">
                <?php echo get_the_post_thumbnail($resource->ID, '340-155-thumb') ?>
            </a>
            <?php
            if ($curauth->ID == get_current_user_id()) :
                ?>
                <div class="hover top right">
                    <?php
                    if ($resource->post_status != 'publish') :
                        ?>
                        <span style="color:red" title="<?php _e('pending review', 'cm'); ?>"> <i class="fa fa-eye-slash"></i></span>
                        <?php
                    endif;
                    $link = get_permalink(constant(CM_RESOURCE_ . strtoupper(str_replace('-', '', $resource->post_type) . _PAGE_ID)));
                    $resource_edit_url = NZ_WP_Forms::link($link, $resource->ID);
                    ?>
                    <a href="<?php echo $resource_edit_url ?>" title="<?php _e('edit', 'cm') ?>">
                        <i class="fa fa-pencil-square-o"></i>
                    </a> 
                </div>
            <?php endif; ?>
        </div>
        <div class="pure-u-1-2 pr">
            <div class="ml5">
                <?php echo substr(strip_tags($resource->post_content), 0, 80) . '...'; ?>
            </div>
            <?php
            if ($curauth->ID == get_current_user_id()) :
                //Share soundcloud | share event 
                ?>
                <div class="tc mt15"  style="text-align: center" >
                    <?php
                    if (in_array($resource->post_type, ['artist', 'label'])) {
                        $podcast_form_url = get_permalink(CM_RESOURCE_PODCAST_PAGE_ID);
                        ?>
                        <a class="pure-button pure-button-primary fancybox ajax" data-fancybox-type="ajax" href="<?php echo $podcast_form_url ?>"> 
                            <?php _e('Share your', 'cm') ?>&nbsp;&nbsp;<i class="fa fa-soundcloud" style="color: #f50;"></i>
                        </a>
                        <?php
                    }
                    if ($resource->post_type == 'cool-place') {
                        $event_form_url = get_permalink(cm_lang_get_post(CM_RESOURCE_EVENT_PAGE_ID));
                        $event_form_url = add_query_arg(array('relation-to-coolplace' => $resource->ID), $event_form_url);
                        ?>
                        <a class="pure-button pure-button-primary" href="<?php echo $event_form_url ?>"> 
                            <?php _e('Share Event', 'cm') ?>&nbsp;&nbsp;<i class="fa fa-users"></i>
                        </a>
                        <?php
                    }
                    ?>
                </div>
                <?php
            endif;
            ?>
        </div>
    </div> 

    <?php if (in_array($resource->post_type, array('artist', 'label'))): ?>
        <?php include_once 'resource-related-podcasts.php'; ?>
    <?php elseif ($resource->post_type = 'cool-place'): ?>
        <?php include_once 'resource-related-events.php'; ?>
    <?php endif; ?>

</section>
