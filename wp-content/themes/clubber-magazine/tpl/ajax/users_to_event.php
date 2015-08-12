<div class="group">
      <section>
            <header class="mt5 mb10">
                  <h1>
                        <span class="cm-title">
                              <?php _e( 'Participants', 'cm' ) ?>
                        </span> 
                  </h1>
            </header>
            <ul>
                  <?php
                  foreach ( $users as $user ) {
                        ?>
                        <li class="col-1-5 fl">
                              <article class="box-3">
                                    <a href="<?php echo get_author_posts_url( $user->ID ); ?>" class="featured-image">
                                          <?php
                                          $default = get_template_directory_uri() . '/assets/images/user/user-profile-ph.jpg';
                                          $url = nz_get_user_image( $user->ID, 'profile', $default );
                                          ?>
                                          <img src="<?php echo $url ?>" alt="clubber-mag-profile-picture" width="100" height="100">
                                    </a>
                                    <a href="<?php echo get_author_posts_url( $user->ID ); ?>" >
                                          <?php echo $user->display_name ?>
                                    </a>
                              </article>
                        </li>
                        <?php
                  }
                  ?>
            </ul>
      </section>
</div>