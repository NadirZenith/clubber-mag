
<ul>
        <!--   USER PROFILE INFO     -->
        <li class="col-2-4 fl">
                <?php
                include (locate_template('templates/user-profile/user-profile-info.php'));
                ?>
        </li>

        <?php
        /*
         */
        if ($artist_page_id = get_user_meta($curauth->ID, 'artist_page', true)) {
                ?>
                <!--   USER ARTIST PAGE     -->
                <li class="col-2-4 fl">
                        <?php
                        include (locate_template('templates/user-profile/user-profile-artist-page.php'));
                        ?>
                </li>
                <?php
        }
        /*
         */
        if (get_current_user_id() == $curauth->ID) {
                if ($label_page_id = get_user_meta($curauth->ID, 'label_page', true)) {
                        ?>
                        <li class="col-2-4 fl">
                                <?php
                                include (locate_template('templates/user-profile/user-profile-label.php'));
                                ?>
                        </li>
                        <?php
                }
        }
        if (get_current_user_id() == $curauth->ID) {
                if (get_user_meta($curauth->ID, 'has_coolplace', true)) {
                        ?>
                        <li class="col-2-4 fl">
                                <?php
                                include (locate_template('templates/user-profile/user-profile-coolplace.php'));
                                ?>
                        </li>
                        <?php
                }
        }
        ?>
        <?php
        if (get_user_meta($curauth->ID, 'is_promoter', true)) {
                ?>
                <!--   USER EVENTS     -->
                <li class="col-2-4 fl">
                        <?php
                        include (locate_template('templates/user-profile/user-profile-promoter.php'));
                        ?>
                </li>
                <?php
        }
        ?>

        <!--   USER AGENDA     -->
        <li class="col-2-4 fl">
                <?php
                include (locate_template('templates/user-profile/user-profile-agenda.php'));
                ?>
        </li>

        <?php
        ?>

</ul>



