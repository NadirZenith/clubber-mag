<div>
    <div class="h1">
        <span class="title"><?php _e('Newsletter', 'cm') ?></span>
    </div>
    <div class="newsletter-container tc p5- oh- block-5-" style="">

        <div class="nzwpnewsletter">
            <div class="validation sc-3"></div>

            <form class="subscribe">
                <!--<label for="subscribe_email">-->
                <label>
                    <?php _e('Insert your email to receive our newsletter', 'cm'); ?>
                </label><br>
                <input type="text" name="subscribe_email"/><br>
                <input type="submit" value="Subscribe"/>
                <a class="switch"><?php _e('unsubscribe', 'cm') ?></a>
            </form>
            <form class="unsubscribe" style="display: none">
                <label>
                    <?php _e('Unsubscribe from newsletter', 'cm') ?>
                </label><br>
                <input type="text" name="unsubscribe_email"/><br>
                <input type="submit" value="Unsubscribe"/>
                <a class="switch"><?php _e('subscribe', 'cm') ?></a>
            </form>
        </div>
    </div>
</div>