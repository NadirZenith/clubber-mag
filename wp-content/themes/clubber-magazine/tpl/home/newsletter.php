<div  class="mt30 ibox-5">
    <div class="mb5">
        <?php
        cm_home_list_title('post', 'Newsletter');
        ?>
    </div>
    <div class="newsletter-container tc p5 oh block-5" style="height: 120px;">
        <form class="nzwpnewsletter">
            <div class="validation sc-3" style="background-color: rgba(255,255,255,0.5)"></div>
            <label for="email" class="sc-3 bold">
                <?php _e('Insert your email to receive our newsletter', 'cm'); ?>
                <input style="width:50%;max-width: 200px" class="col-1" type="email" id="newsletter-email" name="email"/>
            </label>
            <div class="cb mt15"></div>
            <input type="submit" class="readmore" value="<?php _e('Send', 'cm'); ?>"/>
        </form>

    </div>
</div>

