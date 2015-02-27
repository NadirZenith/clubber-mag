<?php

/**
 * Description of NzStartMsgs
 *
 * @author tino
 */
class NzStartMsgs {

      public $msgs;
      public $current;

      public function __construct() {

            $this->options = wp_parse_args( $options, array(
                  'where' => '',
                  'msgs' => array()
                      ) );

            add_action( 'wp', array( $this, 'maybeShowMessages' ) );
      }

      public function addMsg( $msg ) {
            $this->msgs[] = $msg;
      }

      public function maybeShowMessages( $wp ) {

            foreach ( $this->msgs as $key => $item ) {

                  if ( $this->check_conditional_tag( $item[ 'when' ] ) ) {

                        wp_register_script( 'NzStartMsgs', get_template_directory_uri() . '/assets/js/plugins/manual/jquery.startMsgs.js', array( 'jquery' ), '0.1', true );

                        /* wp_localize_script( 'NzStartMsgs', 'nz_start_msgs', $item ); */

                        wp_enqueue_script( 'NzStartMsgs' );

                        add_action( 'wp_footer', array( $this, 'initScript' ) );

                        $this->current = $key;
                        break;
                  }
            }
      }

      public function initScript() {
            ?>
            <script>
                  $(document).ready(function() {
                        $.NzStartMsgs(<?php echo json_encode( $this->msgs[ $this->current ] ); ?>);
                  });

            </script>
            <style>
                  .nz-start-msg-wrap{
                        width: 95%;
                        margin: 5px auto;
                        padding: 5px;
                        border: 1px solid #170;
                        background-color: #33BB55;
                        border-radius: 5px;
                        position: relative;
                        color: #eee;
                  }
                  .nz-start-msg-wrap .fa-question{
                        position: absolute;
                        right: 5px;
                        top: 5px;
                        color: #00a22e;
                        font-size: 20px;
                  }
                  .nz-start-msg-wrap .msg-title{
                        font-family: 'Russo One';
                        font-size: 20px;
                        color: #170;


                  }
                  .nz-start-msg-wrap .btn{
                        cursor: pointer;
                        clear: both;
                        display: block;
                        width: 50px;
                        text-align: center;
                        margin: 3px auto;
                        padding: 3px 2px;
                        background-color: #fff;
                  }
            </style>
            <?php
      }

      private function check_conditional_tag( $conditional_tag ) {
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

      $NzStartMsgs = new NzStartMsgs( );

      $author_msgs = array(
            'when' => 'is_author',
            'msgs' => array(
                  array(
                        'container' => '#user-profile-main',
                        'msg' => '<span class="msg-title">Aprende como usar tu perfil!</span><br> Mensagem sobre o perfil de usuário mensagem sobre o perfil de usuário mensagem sobre o perfil de usuário mensagem sobre o perfil de usuário',
                        'btnText' => 'next',
                  ),
                  array(
                        'container' => '#user-profile-agenda',
                        'msg' => 'mensagem acerca da agenda do usuário',
                        'btnText' => 'next',
                  ),
                  array(
                        'container' => '#user-profile-promoter',
                        'msg' => 'mensagem acerca de los eventos de usuário',
                        'btnText' => 'finish',
                  )
            )
      );

       $NzStartMsgs->addMsg( $author_msgs ); 

      //single_agenda_msgs
      $single_agenda_msgs = array(
            'when' => array( 'is_singular', array( 'agenda' ) ),
            'msgs' => array(
                  array(
                        'container' => '#user-event-signin',
                        'msg' => '<span class="msg-title">Apunta-te a los eventos!</span><br> Mensagem sobre a funcionalidade do botão',
                        'btnText' => 'next',
                  )
            )
      );

      $NzStartMsgs->addMsg( $single_agenda_msgs );
}
