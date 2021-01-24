<section>
    <div class="pure-g">
        <div class="pure-u-1 pure-u-md-1-2">
            <div class="p3">
                <?php
                $curauth = (isset($_GET['author_name'])) ? get_user_by('slug', $author_name) : get_userdata(intval($author));

                //USER PROFILE INFO
                include (locate_template('tpl/user-profile/user-profile-info.php'));
                ?>
            </div>
        </div>
        <div class="pure-u-1 pure-u-md-1-2">
            <div class="p3">
                <?php
                if ($main_resource_id = get_user_meta($curauth->ID, CM_USER_META_RESOURCE_ID, true)) {
                    $resource = get_post($main_resource_id);
                    if ($resource) {
                        if ($curauth->ID != get_current_user_id() & $resource->post_status != 'publish') {
                            
                        } else {
                            include (locate_template('tpl/user-profile/user-profile-main-resource.php'));
                        }
                    }
                }
                ?>
                <?php
                //USER EVENTS
                if (get_user_meta($curauth->ID, 'is_promoter', true)) {
                    include (locate_template('tpl/user-profile/user-profile-resource-promoter.php'));
                }
                //USER AGENDA
                include (locate_template('tpl/user-profile/user-profile-resource-agenda.php'));
                ?>
            </div>
        </div>
    </div>
</section>