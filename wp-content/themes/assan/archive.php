<?php get_header(); ?>
<div class="breadcrumb-wrap">
    <div class="container">
        <?php
        if ( is_post_type_archive() ) {
            echo('<h3>' . post_type_archive_title( '', false ) . '</h3>');
        }
        else {
            the_archive_title('<h3>', '</h3>');
        }
        ?>
        <ol class="breadcrumb">
            <?php the_breadcrumb(); ?>
        </ol>
    </div>
</div>
<div class="divide30"></div>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="row blog-list">
                <?php if (have_posts()) : ?>
                    <?php
                    $queried_tax = get_queried_object()->taxonomy;
                    $queried_name = get_queried_object()->name;
                    if (!$queried_tax) {
                        $queried_tax = $queried_name;
                    }
                    $queried_post_type = split('_', $queried_tax)[0];
                    // var_dump(get_queried_object());
                    // Start the Loop.
                    while (have_posts()) : the_post();
                        if ($queried_post_type == 'category' ||  $queried_post_type == $post->post_type) {
                        ?>
                        <div class="col-md-6 col-sm-6 col-xs-12 masonry-item">
                            <?php get_template_part('content', get_post_format()); ?>
                        </div>
                        <?php
                        }
                    // End the loop.
                    endwhile;

                // If no content, include the "No posts found" template.
                else :
                    get_template_part('content', 'none');

                endif;
                ?>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <?php assan_page_navi(); ?>
        </div>
    </div>
</div>
<?php get_footer(); ?>
