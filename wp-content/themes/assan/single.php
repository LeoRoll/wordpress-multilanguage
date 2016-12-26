<?php
get_header();
?>
<div class="breadcrumb-wrap">
    <div class="container">
        <h3><?php the_title(); ?></h3>
        <ol class="breadcrumb">
            <?php the_breadcrumb(); ?>
        </ol>
    </div>
</div><!--breadcrumbs-->
<div class="divide30"></div>
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <?php
            if (have_posts()) :
                while (have_posts()) : the_post();
                    get_template_part('content', get_post_format());
                    ?>
                    <ul class="pager">
                        <?php previous_post_link('<li class="previous">%link</li>', __('Previous', 'assan')); ?>
                        <?php next_post_link('<li class="next">%link</li>', __('Next', 'assan')); ?>
                    </ul><!--pager-->
                    <?php
                    // If comments are open or we have at least one comment, load up the comment template.
                    if (comments_open() || get_comments_number()) :
                        comments_template();
                    endif;
                    ?>
                </div>
                <?php
            endwhile;
        endif;
        ?>
        <div class="col-md-3 col-md-offset-1">
            <div class="sidebar">
                <?php dynamic_sidebar('primary-sidebar'); ?>
            </div>
        </div>
    </div>
</div>
<div class="divide30"></div>
<?php get_footer(); ?>
