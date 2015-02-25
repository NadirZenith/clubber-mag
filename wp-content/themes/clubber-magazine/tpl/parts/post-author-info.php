<div class="fr cb p5" style="min-width: 200px;">
      <?php
      $default = get_template_directory_uri() . '/assets/images/user/user-profile-ph.jpg';
      $url = nz_get_user_image( get_the_author_meta( 'ID' ), 'profile', $default );
      ?>
      <img class="fr ml5" src="<?php echo $url ?>" alt="clubber-mag-profile-picture" width="45" height="45">
      <div class="fr" style="text-align: right;line-height: 1;">
            <a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>">
                  <?php the_author_meta( 'display_name' ); ?> 
            </a>
            <br>
            <span class="sc-2 smalling" >
                  <?php echo get_the_date(); ?>
            </span>
      </div>
</div>