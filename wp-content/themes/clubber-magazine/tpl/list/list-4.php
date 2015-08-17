<?php
/*
 * event reviews / music archive page item
 */
?>
<article class="pure-g">
    <div class="pure-u-1 pure-u-sm-1-2 pure-u-md-1-3">
        <a class="featured-image" href="<?php echo $item['link']; ?>">
            <?php echo $item['thumbnail'] ?>
        </a>
    </div>
    <div class="pure-u-1 pure-u-sm-1-2 pure-u-md-2-3">
        <div class="ml10">
            <header>
                <h2>
                    <a class="title" href="<?php echo $item['link'] ?>">
                        <?php echo $item['title'] ?>
                    </a>
                </h2>
            </header>
            <p>
                <?php echo $item['content'] ?>
            </p>
            <a class="pure-button mt15 ml15" href="<?php echo $item['link']; ?>" title=""> 
                <?php echo __('Read more', 'cm') ?>
            </a>
        </div>
    </div>
</article>