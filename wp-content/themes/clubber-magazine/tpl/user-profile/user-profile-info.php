<section class="ibox-5">
      <header class="mb5">
            <h2>
                  <a href="#">
                        <?php
                        echo $curauth->get( 'display_name' );
                        ?>
                  </a>
            </h2>
      </header>

      <div id="user-profile-main" class="bg-50 block-5">
            <div id="user-profile-images">
                  <div class="pr">
                        <?php
                        if ( $curauth->ID == get_current_user_id() ):
                              $edit_perfil_url = add_query_arg( array( 'edit-id' => $curauth->ID, 'action' => 'editar' ), get_author_posts_url( $curauth->ID ) );
                              $logout_url = wp_logout_url( home_url() );
                              ?>
                              <div class="p-detail">
                                    <a title="<?php _e( 'edit', 'cm' ) ?>" href="<?php echo $edit_perfil_url ?>">
                                          <i class="fa fa-edit"></i>
                                    </a>
                                    <a title="<?php _e( 'sign-out', 'cm' ) ?>" href="<?php echo $logout_url ?>">
                                          <i class="fa  fa-sign-out"></i>
                                    </a>
                              </div>
                        <?php endif; ?>
                        <div id="user-profile-background" class="featured-image">
                              <?php
                              $default = get_template_directory_uri() . '/assets/images/user/user-background-ph.jpg';
                              $url = nz_get_user_image( $curauth->ID, 'background', $default );
                              ?>
                              <img src="<?php
                              echo $url
                              ?>" alt="clubber-mag-background-picture" width="589" height="200">
                        </div>
                        <div id="user-profile-picture" >
                              <?php
                              $default = get_template_directory_uri() . '/assets/images/user/user-profile-ph.jpg';
                              $url = nz_get_user_image( $curauth->ID, 'profile', $default );
                              ?>
                              <img src="<?php
                              echo $url
                              ?>" alt="clubber-mag-profile-picture" width="160" height="160">
                        </div>
                  </div>
            </div>
            <div class="cb m5 tj">
                  <?php
                  echo get_user_meta( $curauth->ID, 'description', true );
                  ?>
            </div>
            <hr class="pb5" style="border-color: #aaa">
            <div class="group pb10">
                  <div class="col-1 fr">
                        <div class="mr5">
                              <?php
                              include_once 'user-profile-social.php';
                              ?>

                        </div>
                  </div>
            </div>

      </div>
</section>

<?php
wp_reset_postdata();
?>