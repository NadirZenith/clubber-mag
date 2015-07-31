<div  class="mt30 ibox-5">
    <div class="mb5">
        <?php
        cm_home_list_title('post', 'Newsletter');
        ?>
    </div>
    <div class="newsletter-container tc p5 oh block-5" style="">

        <div class="nzwpnewsletter">
            <div class="validation sc-3"></div>

            <form class="subscribe">
                <label for="subscribe_email">
                    <?php _e('Insert your email to receive our newsletter', 'cm'); ?>
                </label><br>
                <input type="text" name="subscribe_email"/><br>
                <input type="submit" value="Subscribe"/>
                <a class="switch"><?php _e('unsubscribe', 'nzwpnewsletter') ?></a>
            </form>
            <form class="unsubscribe" style="display: none">
                <label for="unsubscribe_email">
                    <?php _e('Unsubscribe from newsletter', 'nzwpnewsletter') ?>
                </label><br>
                <input type="text" name="unsubscribe_email"/><br>
                <input type="submit" value="Unsubscribe"/>
                <a class="switch"><?php _e('subscribe', 'nzwpnewsletter') ?></a>
            </form>
        </div>
    </div>
</div>
