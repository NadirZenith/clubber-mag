
<!--   USER PROFILE INFO     -->
<div class="fl col-2-4">
        <?php
        include (locate_template('templates/user-profile/user-profile-info.php'));
        ?>
</div>
<ul class="fl col-2-4">
        <?php
        $main_resource = get_user_meta($curauth->ID, 'main_resource', true);
        if ($main_resource) {
                ?>
                <li>
                        <?php
                        include (locate_template('templates/user-profile/user-profile-resource-' . $main_resource . '.php'));
                        ?>
                </li>
                <?php
        }
        ?>

        <?php
        if (get_user_meta($curauth->ID, 'is_promoter', true)) {
                ?>
                <!--   USER EVENTS     -->
                <li>
                        <?php
                        include (locate_template('templates/user-profile/user-profile-resource-promoter.php'));
                        ?>
                </li>
                <?php
        }
        ?>

        <!--   USER AGENDA     -->
        <li>
                <?php
                include (locate_template('templates/user-profile/user-profile-agenda.php'));
                ?>
        </li>
</ul>
<?php

function more_resources_header() {
        /* d($curauth . 'hasdf'); */
        $curauth = (isset($_GET['author_name'])) ? get_user_by('slug', $author_name) : get_userdata(intval($author));
        ?>
<!--
        <div style="height: 300px; background-color: red;width: 100%;clear: both">

                <?php
                d(get_userdata(intval($author)));
                d(get_user_by('slug', $author_name));
                d(
                        get_query_var('author')
                );
                d($_GET['author_name']);
                ?>
        </div>
-->
        <div class="cb ml5 mr5">
                <?php
                if (get_query_var('author') == get_current_user_id()) {
                        ?>
                        <h1>Mis otros recursos</h1>
                        <?php
                } else {
                        ?>
                        <h1>Otros recursos Clubber-Mag</h1>
                        <?php
                }
                ?>
                <hr class="p5">
        </div>
        <?php
}

$first = true;
/*      cool-place   */
if (
        get_user_meta($curauth->ID, 'coolplaces_ids', true) &&
        $main_resource != 'cool-place'
) {
        ($first) ? more_resources_header() : null;
        ?>
        <div class="fl col-2-4">
                <?php
                include (locate_template('templates/user-profile/user-profile-resource-cool-place.php'));
                ?>
        </div>
        <?php
        $first = false;
}

/*      SELLO */
if (
        get_user_meta($curauth->ID, 'label_page', true) &&
        $main_resource != 'sello'
) {
        ($first) ? more_resources_header() : null;
        ?>
        <div class="fl col-2-4">
                <?php
                include (locate_template('templates/user-profile/user-profile-resource-sello.php'));
                ?>
        </div>
        <?php
        $first = false;
}

/*      ARTIST */
if (
        get_user_meta($curauth->ID, 'artist_page', true) &&
        $main_resource != 'artist'
) {
        ($first) ? more_resources_header() : null;
        ?>
        <div class="fl col-2-4">
                <?php
                include (locate_template('templates/user-profile/user-profile-resource-artist.php'));
                ?>
        </div>
        <?php
        $first = false;
}
?>
<?php
/*
  if (current_user_can('manage_options')) {
  ?>
  <div class="cb">

  <?php
  d(get_post_types());
  ?>
  </div>
  <?php
  }
 */
?>





