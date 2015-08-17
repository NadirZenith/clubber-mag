
<section <?php post_class(); ?>>
    <article>
        <header>
            <h1><?php _e('Edit your profile', 'cm') ?></h1>
        </header>
        <div class="pure-g">

            <div class="pure-u-3-4">
                <?php echo do_shortcode('[nz-wp-form name=edituser_form]'); ?>
            </div>
        </div>
    </article>
</section>

<style>
    .row-edit_password,
    .row-confirm_edit_password{
        width: 30%;
        float: left;
    }
    .row-edit_description,
    .row-lang
    {
        clear: both;
    }
</style>