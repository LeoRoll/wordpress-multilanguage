<div id="post-<?php the_ID(); ?>" class="results-box">
    <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
    <ul class="post-detail list-inline link-ul">
        <?php assan_posted_on(); ?>
    </ul>
    <?php the_excerpt(); ?>
</div><!--result box-->
<hr>
