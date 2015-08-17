<?php
/* home page news and music list */
?>
<article class="pr">
    <header>
        <h2 class="reset h3 hover bottom w-100">
            <a href="<?php the_permalink() ?>">
                <?php
                $mytitle = get_the_title();
                if (strlen($mytitle) > 40) {
                    $mytitle = substr($mytitle, 0, 40) . '...';
                }
                echo $mytitle;
                ?>
            </a>
        </h2>
        <?php
        $terms = get_the_terms(get_the_ID(), 'music_type');
        if (!empty($terms)) {
            ?>
            <div class="hover top right">
                <?php
                echo $terms[0]->name;
                ?>
            </div>
            <?php
        }
        ?>
    </header>
    <a class="featured-image" href="<?php the_permalink() ?>" >
        <?php the_post_thumbnail('340-155-thumb'); ?>
    </a>
</article>