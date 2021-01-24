<?php

/**
 * Description of NzStartMsgs
 *
 * @author tino
 */
class NzStartMsgs {

      public $user_id;
      public $msgs;
      public $current;

      public function __construct() {
            $this->user_id = get_current_user_id();
            $this->options = wp_parse_args( $options, array(
                  'where' => '',
                  'msgs' => array()
                      ) );

            add_action( 'wp', array( $this, 'maybeShowMessages' ) );
            add_action( 'wp_ajax_nz_start_msgs', array( $this, 'ajax_close' ) );

            if ( is_admin() ) {

                  add_action( 'show_user_profile', array( $this, 'add_messages_box' ) );
                  add_action( 'edit_user_profile', array( $this, 'add_messages_box' ) );
                  add_action( 'personal_options_update', array( $this, 'save_user_messages_states' ) );
                  add_action( 'edit_user_profile_update', array( $this, 'save_user_messages_states' ) );
            }
      }

      public function addMsg( $msg ) {
            $this->msgs[] = $msg;
      }

      public function add_messages_box( $user ) {
            ?>
            <h3>User Start messages</h3>

            <table class="form-table">
                  <?php
                  foreach ( $this->msgs as $key => $item ) {
                        ?>
                        <tr>
                              <th><label for="facebook_profile"><?php echo $item[ 'name' ] ?></label></th>
                              <td><input type="checkbox" name="nz_start_msgs[]" value="<?php echo $item[ 'id' ] ?>" class="regular-text2" <?php echo($this->userSawMessage( $user->ID, $item[ 'id' ] )) ? 'checked="yes"' : ''; ?> /></td>
                        </tr>
                        <?php
                  }
                  ?>

            </table>
            <?php
      }

      public function maybeShowMessages( $wp ) {

            foreach ( $this->msgs as $key => $item ) {

                  if ( $this->check_callback( $item[ 'when' ] ) ) {
    /*d($this->msgs);*/
    /*d($item);*/
                        if ( $this->userSawMessage( $item[ 'id' ] ) ) {
                              continue;
                        }

                        wp_register_script( 'NzStartMsgs', get_template_directory_uri() . '/assets/js/plugins/manual/jquery.startMsgs.js', array( 'jquery' ), '0.1', true );

                        /* wp_localize_script( 'NzStartMsgs', 'nz_start_msgs', $item ); */

                        wp_enqueue_script( 'NzStartMsgs' );

                        add_action( 'wp_footer', array( $this, 'initScript' ) );

                        $this->current = $key;
                        break;
                  }
            }
      }

      private function userSawMessage( $msg_id ) {
            $key = 'nz_start_msgs';
            $data = get_user_meta( $this->user_id, $key, true );
            $data = empty( $data ) ? array() : $data;

            return in_array( $msg_id, $data );
      }

      public function initScript() {
            d($this->current);
            d($this->msgs);
            ?>
            <script>
                  $(document).ready(function() {
                        $.NzStartMsgs(<?php echo json_encode( $this->msgs[ $this->current ] ); ?>);
                  });

            </script>
            <style>
                  .nz-start-msg-wrap{
                        clear: both;
                        width: 95%;
                        margin: 5px auto;
                        padding: 5px;
                        border: 2px solid #025EB1;
                        /*background-color: #0583F2;*/
                        /*border: 1px solid #0583F2;*/
                        /*background-color: #025EB1;*/
                        border-radius: 5px;
                        position: relative;
                        /*color: #eee;*/
                        background: #8fc2ef; /* Old browsers */
                        background: -moz-linear-gradient(top,  #8fc2ef 0%, #53a5ed 54%, #8fc2ef 100%); /* FF3.6+ */
                        background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#8fc2ef), color-stop(54%,#53a5ed), color-stop(100%,#8fc2ef)); /* Chrome,Safari4+ */
                        background: -webkit-linear-gradient(top,  #8fc2ef 0%,#53a5ed 54%,#8fc2ef 100%); /* Chrome10+,Safari5.1+ */
                        background: -o-linear-gradient(top,  #8fc2ef 0%,#53a5ed 54%,#8fc2ef 100%); /* Opera 11.10+ */
                        background: -ms-linear-gradient(top,  #8fc2ef 0%,#53a5ed 54%,#8fc2ef 100%); /* IE10+ */
                        background: linear-gradient(to bottom,  #8fc2ef 0%,#53a5ed 54%,#8fc2ef 100%); /* W3C */
                        filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#8fc2ef', endColorstr='#8fc2ef',GradientType=0 ); /* IE6-9 */

                  }
                  .nz-start-msg-wrap p{
                        margin-top: 5px;
                        margin-bottom: 5px;
                  }
                  .nz-start-msg-wrap p a{
                        color: #fff;
                        text-decoration: underline;
                  }
                  .nz-start-msg-wrap .fa-question{
                        position: absolute;
                        right: 5px;
                        top: 5px;
                        color: #025EB1;
                        font-size: 20px;
                  }
                  .nz-start-msg-wrap .msg-title{
                        font-family: 'Russo One';
                        font-size: 20px;
                        color: #025EB1;
                  }
                  .nz-start-msg-wrap .btn-wrap{
                        text-align: center;
                  }
                  .nz-start-msg-wrap .btn{
                        font-family: 'Russo One';
                        cursor: pointer;
                        margin: 5px;
                        padding: 2px 15px;
                        background: #e2e2e2; /* Old browsers */
                        background: -moz-linear-gradient(top,  #e2e2e2 0%, #dbdbdb 50%, #d1d1d1 51%, #fefefe 100%); /* FF3.6+ */
                        background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#e2e2e2), color-stop(50%,#dbdbdb), color-stop(51%,#d1d1d1), color-stop(100%,#fefefe)); /* Chrome,Safari4+ */
                        background: -webkit-linear-gradient(top,  #e2e2e2 0%,#dbdbdb 50%,#d1d1d1 51%,#fefefe 100%); /* Chrome10+,Safari5.1+ */
                        background: -o-linear-gradient(top,  #e2e2e2 0%,#dbdbdb 50%,#d1d1d1 51%,#fefefe 100%); /* Opera 11.10+ */
                        background: -ms-linear-gradient(top,  #e2e2e2 0%,#dbdbdb 50%,#d1d1d1 51%,#fefefe 100%); /* IE10+ */
                        background: linear-gradient(to bottom,  #e2e2e2 0%,#dbdbdb 50%,#d1d1d1 51%,#fefefe 100%); /* W3C */
                        filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#e2e2e2', endColorstr='#fefefe',GradientType=0 ); /* IE6-9 */
                        border-radius: 3px;
                  }

            </style>
            <?php
      }

      public function ajax_close() {
            $key = 'nz_start_msgs';
            $user_id = get_current_user_id();

            $data = get_user_meta( $user_id, $key, true );
            $data = empty( $data ) ? array() : $data;

            $data[] = stripslashes( $_GET[ 'id' ] );

            $data = array_unique( $data );
            update_user_meta( $user_id, $key, $data );

            wp_die();
      }

      public function save_user_messages_states( $user_id ) {
            $data = isset( $_POST[ 'nz_start_msgs' ] ) ? $_POST[ 'nz_start_msgs' ] : array();
            update_user_meta( $user_id, 'nz_start_msgs', $data );
      }

      private function check_callback( $conditional_tag ) {
            if ( is_array( $conditional_tag ) ) {
                  return $conditional_tag[ 0 ]( $conditional_tag[ 1 ] );
            } else {
                  return $conditional_tag();
            }
      }

}

add_action( 'init', 'cm_start_msgs' );

function cm_start_msgs() {

      if ( !is_user_logged_in() )
            return;

      $artist = '<a href="' . get_permalink( CM_RESOURCE_ARTIST_PAGE_ID ) . '">artista</a>';
      $promoter = '<a href="' . get_permalink( CM_RESOURCE_EVENT_PAGE_ID ) . '">promotor</a>';
      $label = '<a href="' . get_permalink( CM_RESOURCE_LABEL_PAGE_ID ) . '">sello discográfico</a>';
      $coolplace = '<a href="' . get_permalink( CM_RESOURCE_COOLPLACE_PAGE_ID ) . '">cool place</a>';
      $recurso = '<a href="' . get_permalink( CM_RESOURCE_MAIN_PAGE_ID ) . '">recurso para usuarios Clubber Magazine</a>';

      $NzStartMsgs = new NzStartMsgs( );

      $profile_msgs = array(
            'id' => 1,
            'name' => 'profile-message',
            'when' => array( 'is_author', array( get_current_user_id() ) ),
            'msgs' => array(
                  array(
                        'container' => '#user-profile-main',
                        'msg' => '<span class="msg-title">¡Te damos la bienvenida a la comunidad Clubber Magazine!</span><br>'
                        . '<p>Aprende a utilizar tu perfil. Aquí podrás editar tu información de usuario donde podrás agregar '
                        . 'fotografías, tu página web y redes sociales en las que participas. También te podrás apuntar a '
                        . 'eventos y así programar tu agenda.</p> '
                        . '<p>Si eres un ' . $artist . ', ' . $promoter . ', ' . $label . ' o un ' . $coolplace . ' (Club, bar o restaurant) puedes '
                        . 'crear un ' . $recurso . ' y disfrutar de todas las ventajas que ofrecemos.</p>',
                        'btnText' => 'Ah!  Vale, lo entiendo.',
                  ),
                  array(
                        'container' => '#user-profile-agenda',
                        'msg' => '<p>Programa tu agenda y apúntate a los eventos que quieras asistir.<br>'
                        . '(Los eventos quedarán guardados en tú perfil para que puedas tener un rápido acceso a ellos)</p>',
                        'btnText' => 'Vale, ¡gracias! Tomaré nota.',
                  )
            )
      );
      $NzStartMsgs->addMsg( $profile_msgs );

      $promoter_msgs = array(
            'id' => 2,
            'name' => 'promoter-message',
            'when' => 'cm_is_promoter',
            'msgs' => array(
                  array(
                        'container' => '#user-profile-promoter',
                        'msg' => '<p>Aquí encontrarás tú recurso de usuario.  Como Promotor podrás crear y compartir tus eventos '
                        . 'de forma directa con la comunidad.</p>',
                        'btnText' => '¡Vale, gracias! Lo entiendo.',
                  )
            )
      );

      $NzStartMsgs->addMsg( $promoter_msgs );

      $resource_coolplace_msg = array(
            'id' => 3,
            'name' => 'resource-coolplace-message',
            'when' => 'cm_has_resource_coolplace',
            'msgs' => array(
                  array(
                        'container' => '#user-profile-cool-place',
                        'msg' => '<p>Aquí encontrarás tú recurso de usuario. Podrás EDITAR y AGREGAR  información de tú página '
                        . 'Cool Place cuando estimes conveniente, además de COMPARTIR TUS EVENTOS con la comunidad.</p>',
                        'btnText' => '¡Vale, gracias! Compartiré mis eventos.',
                  )
            )
      );

      $NzStartMsgs->addMsg( $resource_coolplace_msg );

      $resource_artist_msg = array(
            'id' => 4,
            'name' => 'resource-artist-message',
            'when' => 'cm_has_resource_artist',
            'msgs' => array(
                  array(
                        'container' => '#user-profile-artist',
                        'msg' => 'Aquí encontrarás tú recurso de usuario. Podrás EDITAR y AGREGAR  información a tú página '
                        . 'de <b>artista</b> además de <b>COMPARTIR  TÚ MÚSICA</b> con la comunidad.',
                        'btnText' => '¡Vale, gracias! Lo entiendo.',
                  )
            )
      );

      $NzStartMsgs->addMsg( $resource_artist_msg );

      $resource_label_msg = array(
            'id' => 5,
            'name' => 'resource-artist-message',
            'when' => 'cm_has_resource_label',
            'msgs' => array(
                  array(
                        'container' => '#user-profile-label',
                        'msg' => 'Aquí encontrarás tú recurso de usuario.  Podrás EDITAR y AGREGAR información a tú página de <b>sello '
                        . 'discográfico</b> cuando estimes conveniente además de <b>COMPARTIR  TÚ MÚSICA</b> con la comunidad.',
                        'btnText' => '¡Vale, gracias! Lo entiendo.',
                  )
            )
      );

      $NzStartMsgs->addMsg( $resource_label_msg );


      //single_agenda_msgs
      $single_agenda_msgs = array(
            'id' => 6,
            'name' => 'event-message',
            'when' => array( 'is_single', array( 'agenda' ) ),
            'msgs' => array(
                  array(
                        'container' => '#user-event-signin',
                        'msg' => '<p>Haciendo click en “Me apunto” podrás participar y organizar tus eventos en la agenda.<br>'
                        . 'Luego los podrás ver y gestionar en tú página de perfil. </p>',
                        'btnText' => '¡Vale! Gracias.',
                  )
            )
      );

      $NzStartMsgs->addMsg( $single_agenda_msgs );
}

/* add_filter( 'cron_schedules', 'cron_add_5_minutes' ); */

function cron_add_5_minutes( $schedules ) {
      // Adds once weekly to the existing schedules.
      $schedules[ 'minutes5' ] = array(
            'interval' => 300,
            'display' => __( '5 minutes' )
      );
      return $schedules;
}

/**
 * On an early action hook, check if the hook is scheduled - if not, schedule it.
 */
/* add_action( 'wp', 'nz_start_msg_renable_messages' ); */

function nz_start_msg_renable_messages() {
      if ( !wp_next_scheduled( 'nz_start_msgs_check_states' ) ) {
            wp_schedule_event( time(), 'minutes5', 'nz_start_msgs_check_states' );
      }
}

/**
 * On the scheduled action hook, run a function.
 */
/* add_action( 'nz_start_msgs_check_states', '_nz_start_msgs_check_states' ); */

function _nz_start_msgs_check_states() {
      $users = get_users( array( 'role' => 'administrator' ) );

      foreach ( $users as $user ) {
            update_user_meta( $user->ID, 'nz_start_msgs', array() );
      }
}
