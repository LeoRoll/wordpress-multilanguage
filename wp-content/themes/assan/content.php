<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <div class="blog-post">
        <?php if (!is_single()) : ?>
        <?php assan_post_thumbnail(); ?>
        <?php endif; ?>
        <?php if (is_single()) : ?>
            <ul class="list-inline post-detail">
                <?php assan_posted_on(); ?>
            </ul>
            <?php
            the_content();
        else:
            ?>
            <h2><?php the_title(); ?></h2>
            <ul class="list-inline post-detail">
                <?php assan_posted_on(); ?>
            </ul>
            <?php
            the_excerpt();
        endif;
        ?>
    </div>
</div>
