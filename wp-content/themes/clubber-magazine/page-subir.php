<?php
$url = add_query_arg(null, null);
parse_str(parse_url($url, PHP_URL_QUERY), $vars);
if (isset($vars['tipo'])) {


        /*
          id ->                 The id of the form to be embedded. (required)
          title ->              Whether or not do display the form title. Defaults to 'false'. (optional)
          description ->        Whether or not do display the form description. Defaults to 'false'. (optional)
          ajax ->               Specify whether or not to use AJAX to submit the form.
          tabindex ->           Specify the starting tab index for the fields of this form.
         */

        switch ($vars['tipo']) {
                case 'artista':
                        $content = do_shortcode('[gravityform id=3 title=false description=false ajax=true]');
                        $title = 'Nuevo Artista';

                        break;
                case 'cool-place':
                        $content = do_shortcode('[gravityform id=4 title=false description=false ajax=true]');
                        $title = 'Nuevo Cool-Place';

                        break;
                default:
                        $content = 'No existe ese contenido ! 404';

                        break;
        }
} else {

        $content = '404 NOT FOUND';
}
?>
<?php get_header(); ?>

<div id="container">

        <script type="text/javascript">
                jQuery(document).ready(function($) {

                });
        </script>
        <style>

                .gform_fields .small{
                        width: 30%;
                        margin-left: 5px;
                }
                .gform_fields .medium{
                        width: 70%;
                        margin-left: 5px;
                }
                .gform_fields .large{
                        width: 90%;
                        margin-left: 5px;
                }
                .gfield_label {
                        margin-left: 5px;
                }
                .gfield_required{
                        margin-left: 5px;
                        /*color: ;*/
                }
                .gfield_description{
                        margin-left: 5px;
                        color: #bbb;
                }
                .gfield:hover .gfield_description{
                        color: #ddd;
                }
                .validation_error, .gfield .validation_message {
                        color: blue;
                }

                
                .gform_confirmation_wrapper {
                        font-size: 150%;
                        font-weight: 700;
                        margin-left: 20px;
                        margin-top: 30px;
                        color:#333;
                }
                .gform_footer{
                        /*height: 200px;*/
                        clear: both;
                        padding-top: 20px;
                        margin-left: 20px;
                        margin-bottom: 20px;
                }
                .gform_validation_container{
                        display: none;
                }

        </style>
        <?php
        /*d('page-subir');*/
        ?>
        <section class="bg-50 block-5" id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <header class="">
                        <h1 class="ml5 mt5">
                                <?php echo $title ?>
                        </h1>
                </header>
                <div class="mt5 ml5 meddium mr5 cb">
                        <?php
                       if($content){
                               echo $content;
                       } else {
                               echo 'Los campos marcados con * son obligatorios';
                       }
                        ?>

                </div>

        </section>
        <?php
        ?>


</div><!-- #container -->

<?php get_footer(); ?>
