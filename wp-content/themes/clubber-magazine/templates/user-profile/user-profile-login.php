<?php ?>
<style>
    .sign-in label,
    .user-forms label{
        font-size: 16px;
    }
    .sign-in p,
    .user-forms p
    {
        width: 50%;
    }
    .sign-in .login-form-submit,
    .user-forms .submit{
        margin-top: 30px;
    }


</style>
<div class="meddium">
    <div class="col-2-4 fl pb15 pt5 mt15 bg-50 block-5">
        <div class="ml5 pb15">
            <h1>Entra</h1>
            <h2 class="">Accede a nuestra plataforma y podrás compartir tus eventos, fotografías y vídeos además de colaborar con contenido en nuestras publicaciones. </h2>
        </div>
        <div class="ml5">
            <?php
            echo do_shortcode( '[wppb-login]' );
            ?>
        </div>
        <div class="ml5 mt15">
            <?php
            facebookall_render_facebook_button();
            ?>
        </div>

    </div>
    <div class="col-2-4 fl pb15 pt5 mt15 bg-50 block-5">
        <div class="ml5 pb15">
            <h1 class="">Regístrate</h1>
            <h2>Si te gusta la música electrónica, eres productor, dj, promotor o un club, regístrate en Clubber Mag y sé parte de nosotros.</h2>
        </div>
        <div class="ml5">
            <?php
            echo do_shortcode( '[gravityform id="' . 5 . '" name="User registration" title="false" description="false" ajax="false"]' );
            ?>
        </div>
    </div>
</div>
