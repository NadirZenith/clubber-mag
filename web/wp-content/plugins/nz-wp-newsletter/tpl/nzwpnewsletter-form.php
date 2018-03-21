<div class="nzwpnewsletter">
    <div class="validation"></div>
    <form class="subscribe">
        <div class="confirmation"></div>
        <label for="subscribe_email">
            <?php _e('Enter your email', 'nzwpnewsletter') ?>
            <input type="text" name="subscribe_email"/>
        </label>
        <input type="submit" value="Subscribe"/>
        <a class="switch"><?php _e('unsubscribe', 'nzwpnewsletter') ?></a>
    </form>
    <form class="unsubscribe" style="display: none">
        <div class="confirmation"></div>
        <label for="unsubscribe_email">
            <?php _e('Unsubscribe from newsletter', 'nzwpnewsletter') ?>
            <input type="text" name="unsubscribe_email"/>
        </label>
        <input type="submit" value="Unsubscribe"/>
        <a class="switch"><?php _e('subscribe', 'nzwpnewsletter') ?></a>
    </form>
</div>