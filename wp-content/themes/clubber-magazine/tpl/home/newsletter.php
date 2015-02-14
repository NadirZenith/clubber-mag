<div  class="mt30 ibox-5">
      <div class="mb5">
            <?php
            cm_home_list_title( 'post', 'Newsletter' );
            ?>
      </div>
      <div class="newsletter-container tc p5 oh block-5" style="height: 100px;">
            <label for="newsletter-email" class="sc-3 bold" >
                  <?php _e( 'Insert your email to receive our newsletter', 'cm' ); ?>

            </label>
            <br>
            <input style="width:50%;max-width: 200px" class="col-1" type="email" id="newsletter-email" name="newsletter-email"/>
            <div class="cb mb5"></div>
            <a class="readmore">
                  <?php _e( 'Send', 'cm' ); ?>

            </a>
      </div>
</div>